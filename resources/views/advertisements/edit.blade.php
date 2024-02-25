<!-- resources/views/advertisements/edit.blade.php -->

@extends('layouts.app')

@section('content')
<h1>Edit Advertisement</h1>

<form action="{{ route('advertisements.update', $advertisement->id) }}" method="post" enctype="multipart/form-data" s>
    @csrf
    @method('put')
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $advertisement->name }}" required>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" rows="4" required>{{ $advertisement->description }}</textarea>
    </div>
    <div class="form-group">
        <label for="image">Image</label>
        <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
    </div>
    <div class="form-group">
        <label>Current Image</label>
        @if ($advertisement->image)
        <img src="{{ asset('storage/' . $advertisement->image) }}" alt="{{ $advertisement->name }}" class="img-thumbnail" style="max-width: 100px;">
        <p>{{ $advertisement->description }}</p>
        @else
        No Image
        @endif
    </div>
    <button type="submit" class="btn btn-primary">Update Advertisement</button>
</form>
@endsection