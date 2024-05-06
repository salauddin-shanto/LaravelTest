@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Withdrawal Transactions</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($withdrawals as $withdrawal)
                    <tr>
                        <td>{{ $withdrawal->id }}</td>
                        <td>{{ $withdrawal->user->name }}</td>
                        <td>${{ $withdrawal->amount }}</td>
                        <td>{{ $withdrawal->date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
