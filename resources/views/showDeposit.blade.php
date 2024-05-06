@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Deposited Transactions</h1>
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
                @foreach($deposits as $deposit)
                    <tr>
                        <td>{{ $deposit->id }}</td>
                        <td>{{ $deposit->user->name }}</td>
                        <td>${{ $deposit->amount }}</td>
                        <td>{{ $deposit->date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
