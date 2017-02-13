<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Storagefile, App\FileShares, App\Notification, Auth, Storage, Validator;

class StorageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Show the application welcome page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())->orderBy('id', 'desc')->get();
        
        return view('welcome')->with('notifications', $notifications);
    }
    
    /**
     * Show the page with all files for the current user.
     *
     * @return \Illuminate\Http\Response
     */
    public function files()
    {
        $shares = FileShares::where('user_id', Auth::id())->get();
        $fileIds = $shares->pluck('file_id');
        
        $files = Storagefile::where('user_id', Auth::id())
                            ->orWhereIn('id', $fileIds)
                            ->orderBy('original_filename')->with('owner')->get();
        
        return view('files')->with('files', $files);
    }
    
    /**
     * Show the file page.
     *
     * @return \Illuminate\Http\Response
     */
    public function file($id)
    {
        $file = Storagefile::find($id);
        
        if ($file === null || ! $file->hasAccess(Auth::id())) {
            return redirect()->route('files');
        }
        
        return view('file')->with('file', $file);
    }
    
    /**
     * Delete the file.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $file = Storagefile::find($request->input('file_id'));
        
        if ($file === null || ! $file->isOwner(Auth::id())) {
            return redirect()->route('files');
        }
        
        $file->delete();
        
        Notification::create([
            'type' => Notification::TYPE_DELETE,
            'user_id' => Auth::id(),
            'file_id' => $file->id,
            'file_name' => $file->original_filename
        ]);
        
        return redirect()->route('files')->withInfo('File deleted.');
    }
    
    /**
     * Delete the file forever.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteforever(Request $request, $id)
    {
        $file = Storagefile::withTrashed()->find($request->input('file_id'));
        
        if ($file === null || ! $file->isOwner(Auth::id())) {
            return redirect()->route('trash');
        }
        
        $file->forceDelete();
        
        FileShares::where('file_id', $file->id)->delete();
        
        $filepath = Auth::user()->foldername.'/'.$file->filename;
        Storage::delete($filepath);
        
        return redirect()->route('trash')->withInfo('File deleted forever.');
    }
    
    
    /**
     * Show the upload page.
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadPage()
    {
        return view('upload');
    }
    
    /**
     * Upload the file.
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function upload(Request $request)
    {
        if ($request->file('file') === null) {
            abort(404);
        }
        
        $uploadedFile = $request->file('file');
        
        if (Storagefile::where('filename', $uploadedFile->hashName())->first() !== null) {
            return view('upload')->withInfo('File already exists.');
        }
        
        $uploadedFile->store(Auth::user()->foldername);
        
        $file = Storagefile::create([
            'filename' => $uploadedFile->hashName(),
            'mime' => $uploadedFile->getClientMimeType(),
            'original_filename' => $uploadedFile->getClientOriginalName(),
            'size' => $uploadedFile->getClientSize(),
            'user_id' => Auth::id()
        ]);
        
        Notification::create([
            'type' => Notification::TYPE_NEW,
            'user_id' => Auth::id(),
            'file_id' => $file->id,
            'file_name' => $file->original_filename
        ]);
        
        return redirect()->route('file', ['id' => $file->id]);
    }
    
    /**
     * Download the file.
     *
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
        $file = Storagefile::find($id);
        
        if ($file === null || ! $file->hasAccess(Auth::user()->id)) {
            abort(404);
        }
        
        if ($file->isOwner(Auth::user()->id)) {
            $foldername = Auth::user()->foldername;
        } else {
            $foldername = \App\User::where('id', $file->user_id)->first()->foldername;
        }
        
        $filepath = 'app/'.$foldername.'/'.$file->filename;
        
        return response()->download(storage_path($filepath), $file->original_filename);
    }
    
    /**
     * Restore the file.
     *
     * @param  \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Request $request, $id)
    {
        $file = Storagefile::withTrashed()->find($request->input('file_id'));
        
        if ($file === null || ! $file->isOwner(Auth::user()->id)) {
            return redirect()->route('trash');
        }
        
        $file->restore();
        
        Notification::create([
            'type' => Notification::TYPE_RESTORE,
            'user_id' => Auth::id(),
            'file_id' => $file->id,
            'file_name' => $file->original_filename
        ]);
        
        return redirect()->route('files')->withInfo('File restored.');
    }
    
    /**
     * Share the file.
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function share(Request $request, $id)
    {
        $file = Storagefile::find($request->input('file_id'));
        
        if ($file === null || ! $file->isOwner(Auth::user()->id)) {
            abort(404);
        }
        
        $shares = FileShares::where('file_id', $file->id)->pluck('user_id');
        
        FileShares::where('file_id', $file->id)->delete();
        
        $userIDs = $request->input('user_ids');
        
        if ($userIDs !== null && is_array($userIDs)) {
            foreach ($userIDs as $userID) {
                
                FileShares::create([
                    'file_id' => $file->id,
                    'user_id' => $userID
                ]);
                
                if (! $shares->contains($userID)) {
                    Notification::create([
                        'type' => Notification::TYPE_SHARE,
                        'user_id' => $userID,
                        'file_id' => $file->id,
                        'file_name' => $file->original_filename,
                        'sharer_id' => Auth::id(),
                        'sharer_name' => Auth::user()->fullname
                    ]);
                }
            }
        }
        
        return redirect()->route('file', ['id' => $file->id]);
    }
    
    /**
     * Show the page with the deleted files.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        $files = Storagefile::onlyTrashed()
                            ->where('user_id', Auth::id())
                            ->get();
        
        return view('trash')->with('files', $files);
    }
    
    /**
     * Show the file in the browser.
     *
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $file = Storagefile::find($id);
        
        if ($file === null || ! $file->hasAccess(Auth::user()->id)) {
            abort(404);
        }
        
        if ($file->isOwner(Auth::user()->id)) {
            $foldername = Auth::user()->foldername;
        } else {
            $foldername = \App\User::where('id', $file->user_id)->first()->foldername;
        }
        
        $filepath = 'app/'.$foldername.'/'.$file->filename;
        
        return response()->file(storage_path($filepath));
    }
}
