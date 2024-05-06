@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Deposit</h1>
        <form method="POST" action="{{ route('deposit') }}">
            @csrf
            <div class="form-group">
                <label for="user_id">User ID:</label>
                <input type="text" id="user_id" name="user_id" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="text" id="amount" name="amount" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Deposit</button>
        </form>
    </div>
@endsection
