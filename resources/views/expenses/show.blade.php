@extends('layouts.app')

@section('title', 'Expense Details - Easy Ride')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-receipt"></i> Expense Details</h1>
    <a href="{{ route('expenses.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Expenses
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Expense Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Expense ID:</strong> #{{ $expense->id }}</p>
                        <p><strong>Category:</strong> {{ $expense->expenseCategory->name }}</p>
                        <p><strong>Amount:</strong> {{ $expense->amount }} EGP</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Daily Session:</strong> Session #{{ $expense->daily_session_id }}</p>
                        <p><strong>Date:</strong> {{ $expense->created_at->format('d/m/Y h:i A') }}</p>
                    </div>
                </div>
                @if($expense->note)
                <div class="mt-3">
                    <p><strong>Note:</strong></p>
                    <p class="text-muted">{{ $expense->note }}</p>
                </div>
                @endif
            </div>
            <div class="card-footer">
                <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit Expense
                </a>
                <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                        <i class="fas fa-trash"></i> Delete Expense
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
