@extends('layouts.vendor')

@section('title', 'Notifications')

@section('content')
<h4 class="mb-3">Notifications</h4>

<div class="card">
    <div class="card-body">
        <table class="table table-striped table-bordered data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Type</th>
                    <th>Title</th>
                    <th>Read</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($notifications as $notification)
                    <tr>
                        <td>{{ $notification->id }}</td>
                        <td>{{ $notification->type }}</td>
                        <td>{{ $notification->title }}</td>
                        <td>{{ $notification->read ? 'Yes' : 'No' }}</td>
                        <td>{{ $notification->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection


