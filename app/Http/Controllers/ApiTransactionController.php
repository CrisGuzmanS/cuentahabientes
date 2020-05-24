<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\Account;
use App\Customer;
use App\User;
use Illuminate\Support\Facades\Auth;

class ApiTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json( Transaction::get(), 200 );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $originAccount = Account::where('account_number',$request->origin_account_number)->first();
        $destinationAccount = Account::where('account_number',$request->destination_account_number)->first();
        $customer = Customer::find( $request->customer_id );

        $transaction = Transaction::create([
            'origin_account_id' => $originAccount->id,
            'destination_account_id' => $destinationAccount->id,
            'customer_id' => $customer->id,
            'amount' => $request->amount
        ]);

        $originAccount->decrement('balance', $transaction->amount);
        $destinationAccount->increment('balance', $transaction->amount);

        return response()->json( $transaction, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
