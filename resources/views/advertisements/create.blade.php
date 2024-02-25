<!-- resources/views/advertisements/create.blade.php -->

@extends('layouts.app')

@section('content')
<h1>Create Advertisement</h1>

<form action="{{ route('advertisements.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class=" form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
    </div>
    <div class="form-group">
        <label for="image">Image</label>
        <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
    </div>
    <button type="submit" class="btn btn-primary">Create Advertisement</button>
</form>
@endsection