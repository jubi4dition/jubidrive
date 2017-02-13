@extends('app')

@section('headline')
<a href="#!" class="breadcrumb">Trash</a>
@stop

@section('content')
<table class="bordered trash full-width">
<thead>
  <tr>
      <th>Name</th>
      <th>Deleted At</th>
      <th>&nbsp;</th>
  </tr>
</thead>
<tbody>
  @foreach ($files as $file)
  <tr>
    <td>{{ $file->original_filename }}</td>
    <td>{{ $file->deleted_at->toDayDateTimeString() }}</td>
    <td>
        <button type="button" data-fileid="{{ $file->id }}" class="waves-effect waves-light btn pink btn_restore"><i class="material-icons left">restore</i>restore</button>
        <button type="button" data-fileid="{{ $file->id }}" class="waves-effect waves-light btn pink btn_deleteforever"><i class="material-icons left">delete_forever</i>delete</button>
    </td>
  </tr>
  @endforeach
</tbody>
</table>

{!! Form::open(array('id' => 'form_restore','url' => route('restore', ['id' => 'id']))) !!}
{!! Form::hidden('file_id') !!}
{!! Form::close() !!}

{!! Form::open(array('id' => 'form_deleteforever','url' => route('deleteforever', ['id' => 'id']))) !!}
{!! Form::hidden('file_id') !!}
{!! Form::close() !!}

<script>
/*global $*/
$(document).ready(function(){
  
  $('.btn_restore').on('click', function(e) {
    e.preventDefault();
    fileid = $(this).data('fileid');
    $('#form_restore input[name="file_id"]').val(fileid);
    $('#form_restore').submit();
  });
  
  $('.btn_deleteforever').on('click', function(e) {
    e.preventDefault();
    fileid = $(this).data('fileid');
    $('#form_deleteforever input[name="file_id"]').val(fileid);
    $('#form_deleteforever').submit();
  });
  
});
</script>
@endsection
