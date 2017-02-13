@extends('app')

@section('headline')
<a href="{!! route('files') !!}" class="breadcrumb">Files</a><a href="#!" class="breadcrumb">{{ $file->original_filename }}</a>
@stop

@section('content')
<div class="flex-center">
    <div class="card">
      <div class="card-content">
        <span class="card-title">{{ $file->original_filename }}</span>
        <table>
          <tbody>
            <tr><td>Type</td><td><strong>{{ $file->mime }}</strong></td></tr>
            <tr><td>Owner</td><td><strong>{{ $file->owner->fullname }}</strong></td></tr>
            <tr><td>Size</td><td><strong>{{ $file->size_formatted }}</strong></td></tr>
            <tr><td>Created at</td><td><strong>{{ $file->created_at->toDayDateTimeString() }}</strong></td></tr>
            @if($file->isOwner(Auth::user()->id))
            <tr><td>Shared with</td>
                <td>
                  @if ($file->sharedWith->isEmpty())
                  <strong>-</strong>
                  @else
                    @foreach ($file->sharedWith as $user)
                    <strong>{{ $user->fullname }}</strong><br />
                    @endforeach
                  @endif
                </td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>
      <div class="card-action">
        <a href="{{ route('download', ['id' => $file->id]) }}" class="btn-floating btn-large waves-effect waves-light pink"><i class="large material-icons">file_download</i></a>
        <a href="{{ route('view', ['id' => $file->id]) }}" target="_blank" class="btn-floating btn-large waves-effect waves-light pink"><i class="large material-icons">visibility</i></a>
        @if($file->isOwner(Auth::user()->id))
        <a href="#modal_delete" class="btn-floating btn-large waves-effect waves-light pink modal-trigger"><i class="large material-icons">delete</i></a>
        <a href="#modal_person_add" class="btn-floating btn-large waves-effect waves-light pink modal-trigger"><i class="large material-icons">person_add</i></a>
        @endif
      </div>
    </div>
</div>

@if($file->isOwner(Auth::user()->id))
<div id="modal_delete" class="modal center-align">
  <div class="modal-content">
    <h4>Delete</h4>
    <p>Do you really want to delete this file?</p>
  </div>
  <div class="modal-footer">
    {!! Form::open(array('id' => 'form_delete','url' => route('delete', ['id' => $file->id]))) !!}
    {!! Form::hidden('file_id', $file->id) !!}
    {!! Form::close() !!}
    <a href="#!" onclick="javascript:$('#form_delete').submit();" class="modal-action waves-effect btn">Yes</a>
    <a href="#!" class="modal-action modal-close waves-effect btn grey">No</a>
  </div>
</div>

<div id="modal_person_add" class="modal center-align">
  <div class="modal-content">
    <h4>Share with</h4>
    {!! Form::open(array('id' => 'form_share','url' => route('share', ['id' => $file->id]))) !!}
    {!! Form::hidden('file_id', $file->id) !!}
    <div class="row">
      <div class="input-field col s7 offset-s1">
      {!! Form::select('user_ids[]', \App\User::getAllforSelectbox(), \App\FileShares::usersFromFile($file->id), ['multiple' => true]) !!}
      </div>
      <div class="input-field col s3" style="text-align: left;">
        <button class="btn waves-effect waves-light" type="submit" name="action">Share</button>
      </div>
    </div>
    {!! Form::close() !!}
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-action modal-close waves-effect btn grey">Close</a>
  </div>
</div>
@endif

<script>
$(document).ready(function(){
  $('select').material_select();
  $('.modal').modal();
});
</script>
@endsection