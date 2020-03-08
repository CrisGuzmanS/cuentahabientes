<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;

class ApiAccountController extends Controller
{
    public function index(){
        $accounts = Account::get();
        return response()->json($accounts);
    }

    public function show(Account $account){
        return response()->json([
            'account' => $account,
            'customers' => $account->customers
        ]);
    }

    public function store(Request $request){

        try {

            $account = Account::create([
                'account_number' => $request->account_number,
                'balance' => $request->balance
            ]);
            $account->customers()->attach($request->customers);
            return response()->json($account);

        } catch (\Throwable $th) {

            return response()->json([
                'message' => $th->getMessage()
            ]);

        }
        
    }

    public function update(Request $request, Account $account){
        $account->update([
            'account_number' => $request->account_number,
            'balance' => $request->balance
        ]);

        $account->customers()->detach();
        $account->customers()->attach($request->customers);
        return response()->json([
            'account' => $account,
            'customers' => $account->customers
        ]);
    }

    public function delete(Account $account){
        $account->customers()->detach();
        $account->delete();
        return response()->json([
            'message' => 'account deleted'
        ]);
    }
}
