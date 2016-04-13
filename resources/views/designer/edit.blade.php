@extends('layout.edit', [
    'title' => 'Edit: ' . $designer->getTranslation()->name,
    'body_id' => 'designer-edit-page',
    'body_class' => 'designer-edit-page',
    'back_link' => url('/designer/' . $designer->id),
])

@section('content')
<button class="btn btn-default" type="submit">Save</button>
@endsection
