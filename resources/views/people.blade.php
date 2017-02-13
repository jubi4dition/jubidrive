@extends('app')

@section('headline')
<a href="#!" class="breadcrumb">People</a>
@stop

@section('content')
<div class="flex-center">
  <div class="card">
    <div class="card-content">
      <table class="bordered users">
      <tbody>
        @foreach ($users as $user)
        <tr>
          <td class="user-photo"><img src="{{ $user->photoURL() }}"></td>
          <td><strong>{{ $user->fullname }}</strong></td>
        </tr>
        @endforeach
      </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
