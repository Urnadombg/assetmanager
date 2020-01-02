<?php

namespace App\Http\Controllers\API;

use App\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::with(['assets','companies'])->get();
        return response()->json($customers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $customer = new Customer();

        $customer->name = $request->name;
        $customer->lastname = $request->lastname;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->city = $request->city;
//        $customer->legalEntity_id = $request->legalEntity_id;

        // TODO: to be implemented

//        if ($request->has('legalEntity')) {
//            $customer->companies()->create([
//
//            ]);
//        }
        $customer->save();
        return response()->json(['message' => 'Customer has been saved!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::findOrFail($id)->load(['assets', 'companies']);

        return $customer;
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
