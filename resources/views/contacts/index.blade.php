@extends('layouts.app')
@section('title', 'My Contacts')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>My Contacts</h2>
    <a href="{{ route('contacts.create') }}" class="btn btn-success">Add New Contact</a>
</div>

<form method="GET" action="{{ route('contacts.index') }}" class="mb-3 d-flex">
    <input type="text" name="search" class="form-control me-2" placeholder="Search..." value="{{ request('search') }}">
    <button type="submit" class="btn btn-primary">Search</button>
</form>

@if($contacts->count())
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th><th>Name</th><th>Email</th><th>Message</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($contacts as $contact)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $contact->name }}</td>
            <td>{{ $contact->email }}</td>
            <td>{{ $contact->message }}</td>
            <td>
                <a href="{{ route('contacts.edit', $contact) }}" class="btn btn-sm btn-primary">Edit</a>
                <form action="{{ route('contacts.destroy', $contact) }}" method="POST" style="display:inline-block;">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="d-flex justify-content-center mt-3">
    {{ $contacts->links('pagination::bootstrap-5') }}
</div>


@else
<p>No contacts found.</p>
@endif
@endsection
