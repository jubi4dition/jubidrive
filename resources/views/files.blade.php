@extends('app')

@section('headline')
<a href="#!" class="breadcrumb">Files</a>
@stop

@section('content')
<table class="bordered files full-width">
<thead>
  <tr>
      <th>Name</th>
      <th>Owner</th>
      <th>Created At</th>
      <th>Size</th>
      <th>&nbsp;</th>
  </tr>
</thead>
<tbody>
  @foreach ($files as $file)
  <tr>
    <td>{{ $file->original_filename }}</td>
    <td>{{ $file->owner->fullname }}</td>
    <td class="hide-on-med-and-down">{{ $file->created_at->toDayDateTimeString() }}</td>
    <td class="hide-on-med-and-down">{{ $file->size_formatted }}</td>
    <td>
        <a href="{!! route('file', ['id' => $file->id]) !!}" class="waves-effect waves-light btn pink"><i class="material-icons left">open_in_browser</i>open</a>
    </td>
  </tr>
  @endforeach
</tbody>
</table>
@endsection
