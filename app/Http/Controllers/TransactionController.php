<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all();
        
        $balance = User::sum('balance');
        
        return view('home', 
        ['transactions' => $transactions,
        'balance' => $balance
        ]);
    }

    public function showDeposits()
    {
        // Check if the user is logged in
        if (Auth::check()) {
            // Retrieve the currently authenticated user
            $user = Auth::user();

            // Retrieve all deposited transactions for the current user
            $deposits = $user->transactions()->where('transaction_type', 'deposit')->get();
            
            // Calculate the balance by summing the deposited amounts
            $balance = $deposits->sum('amount');

            // Return the view with the deposited transactions and balance
            return view('showDeposit', compact('deposits', 'balance'));
        } else {
            // User is not logged in, redirect to the login page
            return redirect()->route('login')->with('error', 'Please log in to view deposited transactions.');
        }
    }

    public function makeDeposit(){
        return view('makeDeposit');
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $user = User::findOrFail($request->user_id);

        $user->balance += $request->amount;
        $user->save();

        Transaction::create([
            'user_id' => $user->id,
            'transaction_type' => 'deposit',
            'amount' => $request->amount,
            'date' => now(),
        ]);

        return redirect()->back()->with('success', 'Deposit successful.');
    }


    public function makeWithdrawal(){
        return view('makeWithdraw');
    }



    public function showWithdrawals()
    {
        // Check if the user is logged in
        if (Auth::check()) {
            // Retrieve the currently authenticated user
            $user = Auth::user();

            // Retrieve all withdrawal transactions for the current user
            $withdrawals = $user->transactions()->where('transaction_type', 'withdrawal')->get();
            
            // Return the view with the withdrawal transactions
            return view('showWithdraws', compact('withdrawals'));
        } else {
            // User is not logged in, redirect to the login page
            return redirect()->route('login')->with('error', 'Please log in to view withdrawal transactions.');
        }
    }


    public function processWithdrawal(Request $request)
    {
        // Validate the request data
        $request->validate([
            'amount' => 'required|numeric|min:0.01', // Minimum withdrawal amount of $0.01
        ]);

        // Get the currently authenticated user
        $user = Auth::user();

        // Get the withdrawal amount from the request
        $withdrawalAmount = $request->amount;

        // Calculate withdrawal fee based on the user's account type
        $withdrawalFee = $this->calculateWithdrawalFee($user, $withdrawalAmount);

        // Apply withdrawal fee
        $finalWithdrawalAmount = $withdrawalAmount - $withdrawalFee;

        // Deduct the final withdrawal amount from the user's balance
        $user->balance -= $finalWithdrawalAmount;
        $user->save();

        // Create a withdrawal transaction record
        Transaction::create([
            'user_id' => $user->id,
            'transaction_type' => 'withdrawal',
            'amount' => $withdrawalAmount,
            'fee' => $withdrawalFee,
            'date' => now(),
        ]);

        return redirect()->back()->with('success', 'Withdrawal processed successfully.');
    }


    private function calculateWithdrawalFee(User $user, $withdrawalAmount)
    {
        $withdrawalFeeRate = $user->account_type === 'Business' ? 0.025 : 0.015;

        // Check for free withdrawal conditions for Individual accounts
        if ($user->account_type === 'Individual') {
            // Each Friday withdrawal is free of charge
            if (now()->dayOfWeek === 5) { // 5 corresponds to Friday
                return 0;
            }

            // The first 1K withdrawal per transaction is free
            if ($withdrawalAmount <= 1000) {
                return 0;
            }

            // The first 5K withdrawal each month is free
            $totalWithdrawalsThisMonth = $user->transactions()->where('transaction_type', 'withdrawal')
                ->whereMonth('date', now()->month)->sum('amount');

            if ($totalWithdrawalsThisMonth + $withdrawalAmount <= 5000) {
                return 0;
            }
        }

        // Calculate withdrawal fee based on the withdrawal amount and fee rate
        return $withdrawalAmount * $withdrawalFeeRate;
    }
}
