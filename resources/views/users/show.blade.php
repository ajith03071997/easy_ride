@extends('layouts.app')

@section('title', 'User Details - Easy Ride')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-user"></i> User Details</h1>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Users
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">User Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>User ID:</strong> #{{ $user->id }}</p>
                        <p><strong>Name:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Email Verified:</strong>
                            @if($user->email_verified_at)
                                <span class="badge bg-success">Verified</span>
                            @else
                                <span class="badge bg-warning">Not Verified</span>
                            @endif
                        </p>
                        <p><strong>Created:</strong> {{ $user->created_at->format('d/m/Y h:i A') }}</p>
                    </div>
                </div>

                <div class="mt-3">
                    <p><strong>Roles:</strong></p>
                    @if($user->roles->count() > 0)
                        @foreach($user->roles as $role)
                            <span class="badge bg-primary me-1">{{ $role->name }}</span>
                        @endforeach
                    @else
                        <span class="text-muted">No roles assigned</span>
                    @endif
                </div>

                <div class="mt-3">
                    <p><strong>Permissions:</strong></p>
                    @if($user->getAllPermissions()->count() > 0)
                        @foreach($user->getAllPermissions() as $permission)
                            <span class="badge bg-info me-1">{{ $permission->name }}</span>
                        @endforeach
                    @else
                        <span class="text-muted">No permissions assigned</span>
                    @endif
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit User
                </a>
                @if($user->id !== auth()->id())
                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                            <i class="fas fa-trash"></i> Delete User
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
