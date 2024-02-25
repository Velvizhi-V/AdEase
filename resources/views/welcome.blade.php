<!-- resources/views/welcome.blade.php -->

@extends('layouts.app')

@section('content')
<h1>Welcome to the Home Page</h1>

@if (Session::has('success'))
<div class="alert alert-success" role="alert">
    {{ Session::get('success') }}
</div>
@endif



<p>This is the home page content.</p>
<p><a href="{{ route('advertisements.create') }}">Create Advertisement</a></p>

@if(count($advertisements) > 0)
<h2>Advertisements:</h2>
<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($advertisements as $advertisement)
        <tr>
            <td>{{ $advertisement->name }}</td>
            <td>{{ $advertisement->description }}</td>
            <td>
                @if ($advertisement->image)
                <img src="{{ asset('storage/' . $advertisement->image) }}" alt="{{ $advertisement->name }}" class="img-thumbnail" style="max-width: 100px;">
                @else
                No Image
                @endif
            </td>
            <td>
                <a href="{{ route('advertisements.edit', $advertisement->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('advertisements.destroy', $advertisement->id) }}" method="post" class="d-inline">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<p>No advertisements available.</p>
@endif
@endsection\