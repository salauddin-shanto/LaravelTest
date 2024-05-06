@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Withdrawal Transactions</h1>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($withdrawals as $withdrawal)
                        <tr>
                            <td>{{ $withdrawal->id }}</td>
                            <td>${{ number_format($withdrawal->amount, 2) }}</td>
                            <td>{{ $withdrawal->date }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">No withdrawal transactions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
