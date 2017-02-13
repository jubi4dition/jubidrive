@extends('app')

@section('headline')
<a href="#!" class="breadcrumb">Settings</a>
@stop

@section('content')
<div class="flex-center">
  <div class="card">
    <div class="card-header">Your Photo</div>
    <div class="card-content">
      <div class="user-image-holder"><img src="{{ $photo }}"></div>
      
      <form method="POST" action="/settings/photo" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="file-field input-field">
          <div class="btn pink">
            <span>File</span>
            <input type="file" name="file" required>
          </div>
          <div class="file-path-wrapper">
            <input class="file-path" type="text">
          </div>
        </div>
          <button type="submit" class="waves-effect waves-light btn pink">Upload</button>
      </form>
    </div>
  </div>
</div>
<div class="flex-center">
  <div class="card">
    <div class="card-header">Your Password</div>
    <div class="card-content">
      {!! Form::open(['url' => 'settings/password']) !!}
        <div class="row">
          <div class="input-field col s12">
            {!! Form::password('password', ['id' => 'password', 'required' => 'required']) !!}
            {!! Form::label('password', trans('app.password')) !!}
          </div>
          <div class="input-field col s12">
            {!! Form::password('password_repeat', ['id' => 'password_repeat', 'required' => 'required']) !!}
            {!! Form::label('password_repeat', trans('app.password_repeat')) !!}
            <button type="submit" class="waves-effect waves-light btn pink">Update</button>
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>
@endsection
