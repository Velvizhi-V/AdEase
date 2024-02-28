<!-- resources/views/advertisements/create.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Advertisement</h2>
    <form method="POST" action="{{ route('advertisements.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Advertisement Name:</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Advertisement Description:</label>
            <textarea name="description" id="description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="image">Upload Image:</label>
            <input type="file" name="image" id="image" class="form-control-file" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Advertisement</button>
    </form>
</div>
@endsection