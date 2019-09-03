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
        if ($request->has('asset_id')) {
            $asset = Asset::findOrFail($request->asset_id);

            $asset->maintenances()->create([
                'asset_id' => $request->asset_id,
                'component_id' => $request->component_id,
                'perform_on' => Carbon::parse($request->perform_on),
                'protocolUUID' => Uuid::uuid4(),
                // TODO: Should FIX IT !!!!!!!!!!!!
                'isWarrantyEvent' => true,
                'component_id' => 0,
                'explanation' => 'dggwegwegwegweg'
            ]);
        }
        else if($request->has('component_id')) {
            $component = Component::findOrFail($request->component_id);

            $component->maintenances()->create([
                'component_id' => $request->component_id,
                'perform_on' => Carbon::parse($request->perform_on),
                'protocolUUID' => Uuid::uuid4(),
                // TODO: Should FIX IT !!!!!!!!!!!!
                'isWarrantyEvent' => true,
                'explanation' => $request->explanation
            ]);
        }

    }
}
