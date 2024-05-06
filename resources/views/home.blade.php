@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Transaction History</h1>
        <div>
            <h3>Transactions</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->id }}</td>
                            <td>{{ $transaction->user->name }}</td>
                            <td>{{ $transaction->transaction_type }}</td>
                            <td>${{ $transaction->amount }}</td>
                            <td>{{ $transaction->date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div>
            <h3>Current Balance</h3>
            <p>${{ $balance }}</p>
        </div>
    </div>
@endsection
