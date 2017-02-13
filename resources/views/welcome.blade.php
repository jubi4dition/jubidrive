@extends('app')

@section('content')
<div class="flex-center">
  @if (! $notifications->isEmpty())
  <div class="card">
    <div class="card-content">
      <ul class="collection notifications">
        @foreach ($notifications as $notification)
        <li class="collection-item">{!! $notification->badge() !!}{!! $notification->text() !!}<br/><span class="date">{{ $notification->created_at->toDayDateTimeString() }}</span></li>
        @endforeach
      </ul>
    </div>
  </div>
  @endif
</div>
@endsection
