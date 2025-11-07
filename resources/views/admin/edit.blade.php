@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit User</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name:</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label>Password:</label>
            <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current password">
        </div>

        <div class="mb-3">
            <label>Role:</label>
            <select name="role_id" class="form-control" required>
                <option value="">-- Select Role --</option>
                @foreach ($roles as $role)
                <option value="{{ $role->id }}" 
                    {{ $user->role && $user->role->id == $role->id ? 'selected' : '' }}>
                    {{ ucfirst($role->name) }}
                </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
