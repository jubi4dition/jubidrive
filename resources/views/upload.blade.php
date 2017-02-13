@extends('app')

@section('headline')
<a href="#!" class="breadcrumb">Upload</a>
@stop

@section('content')
<div class="flex-center">
  <div class="card">
    <div class="card-content">
        <form method="POST" action="/upload" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="file-field input-field">
            <div class="btn pink">
              <span>File</span>
              <input type="file" name="file" required />
            </div>
            <div class="file-path-wrapper">
              <input class="file-path" type="text">
            </div>
          </div>
          <button type="submit" class="waves-effect waves-light btn pink">Upload</button>
        </form>
    </div>
  </div>
</div
@endsection