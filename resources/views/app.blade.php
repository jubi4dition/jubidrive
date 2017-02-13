<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <title>JubiDrive</title>
  
  <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css">
  <link rel="stylesheet" href="/css/app.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/js/materialize.min.js"></script>
</head>
<body>
    
  <header>
      <div class="navbar-fixed">
      <nav class="indigo">
        <div class="nav-wrapper">
          <div class="brand-logo"><a href="/" class="breadcrumb">JubiDrive</a> @yield('headline')</div>
          <ul class="right hide-on-med-and-down">
            <li><a href="#!"><i class="material-icons left">person</i>{{ Auth::user()->fullname }}</a></li>
            <li><a href="#!"><i class="material-icons">notifications</i></a></li>
            <li><a href="/logout"><i class="material-icons">power_settings_new</i></a></li>
          </ul>
        </div>
      </nav>
      </div>
      <ul style="transform: translateX(0%);" id="nav-mobile" class="side-nav fixed">
          <li class="logo"><a id="logo-container" href="/" class="brand-logo">
          <i class="large material-icons indigo-text">cloud</i></a></li>
          <li class="bold"><a href="/files" class="waves-effect waves-light"><i class="material-icons">folder</i>Files</a></li>
          <li class="bold"><a href="/upload" class="waves-effect waves-light"><i class="material-icons">file_upload</i>Upload</a></li>
          <li class="bold"><a href="/trash" class="waves-effect waves-light"><i class="material-icons">delete</i>Trash</a></li>
          <li class="bold"><a href="/people" class="waves-effect waves-light"><i class="material-icons">people</i>People</a></li>
          <li class="bold"><a href="/settings" class="waves-effect waves-light"><i class="material-icons">settings</i>Settings</a></li>
      </ul>
  </header>
    
  <main>

    <div class="content container">
         @yield('content')
    </div>
    
    @if(isset($alert))
    <div id="info" style="display: none;">{{ info }}</div>
    @endif
    
    @if( Session::has('info'))
    <div id="info" style="display: none;">{{ Session::get('info') }}</div>
    @endif
    
  </main>
    
<script>
$(document).ready(function(){
  $('#info').fadeIn('slow', function() {
    $(this).delay(5000).fadeOut('slow');
  });
});
</script>
</body>
</html>
