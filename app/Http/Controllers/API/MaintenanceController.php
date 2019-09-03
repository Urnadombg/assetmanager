<?php

namespace App\Http\Controllers\API;

use App\Asset;
use App\Component;
use App\Maintenance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ramsey\Uuid\Uuid;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        //
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

    public function createNewRecord(Request $request)
    {
        $asset = \App\Asset::findOrFail(1)->load(['components', 'warranty', 'maintenances']);


        $maintenance = new App\Maintenance([
            'perform_on' => \Carbon\Carbon::now(),
            'protocolUUID' => \Ramsey\Uuid\Uuid::uuid4(),
            'isWarrantyEvent' => 1,
            'explanation' => 's',
        ]);

        $asset->maintenances()->save($maintenance);
//    dd($maintenance);

        return response()->json($asset);
    }
}
