@extends('layouts.vendor')

@section('title', 'Billing & Expenses')

@section('content')
<h4 class="mb-3">Billing & Expenses</h4>

<div class="card">
    <div class="card-body">
        <table class="table table-striped table-bordered data-table">
            <thead>
                <tr>
                    <th>Invoice #</th>
                    <th>Period</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->invoice_number }}</td>
                        <td>{{ $invoice->period_start }} - {{ $invoice->period_end }}</td>
                        <td>{{ $invoice->payable_amount }}</td>
                        <td>{{ ucfirst($invoice->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection


