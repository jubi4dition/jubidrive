<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>JubiDrive - Login</title>

  <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">
  <link rel="stylesheet" href="/css/app.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

  <!-- Styles -->
  <style>
      body {
          background-color: #fff;
      }
      .full-height {
          height: 100vh;
      }
      .flex-center {
          /*align-items: center;*/
          display: flex;
          justify-content: center;
      }
      .position-ref {
          position: relative;
      }
      .content {
          min-width: 320px;
      }
      .title{
          text-align: center;
      }
  </style>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>
</head>
<body>
  <div class="flex-center position-ref full-height">

    <div class="content">
      
      <h1 class="title">Login</h1>
      
      <div class="login">
          {!! Form::open(array('url' => 'login')) !!}
          <div class="row">
            <div class="input-field col s12">
              {!! Form::text('username', '', ['id' => 'username', 'required' => 'required', 'autofocus' => 'true']) !!}
              {!! Form::label('username', trans('app.username')) !!}
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              {!! Form::password('password', ['id' => 'password', 'required' => 'required']) !!}
              {!! Form::label('password', trans('app.password')) !!}
            </div>
          </div>
          <div class="row">
            <div class="col s12">
              <button type="submit" class="waves-effect waves-light btn-large btn-block">@lang('app.login')</button>
            </div>
          </div>
          {!! Form::close() !!}
        </div>
    </div>
    
  </div>
</body>
</html>
