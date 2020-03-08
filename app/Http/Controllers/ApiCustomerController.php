<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\User;
use App\Account;

class ApiCustomerController extends Controller
{
    public function index(){
        return response()->json(Customer::get());
    }
    public function show(Customer $customer){
        return response()->json($customer);
    }

    public function store(Request $request){
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'type' => 'Cliente',
            ]);
    
            $customer = Customer::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone
            ]);
    
            return response()->json([
                'user' => $user,
                'customer' => $customer,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ]);
        }
    }

    public function update(Request $request, Customer $customer){
        try {

            $customer->user->update([
                'email' => $request->email,
            ]);

            $customer->update([
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
            ]);

            return response()->json([
                'customer' => $customer,
                'user' => $customer->user,
                'account' => $customer->accounts()->first()
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ]);
        }
    }

    public function delete(Customer $customer){
        $customer->accounts()->detach();
        $customer->user()->delete();
        $customer->delete();
        return response()->json([
            'message' => 'User deleted'
        ]);
    }
}
