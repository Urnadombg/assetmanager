<?php

namespace App\Http\Controllers\API;

use App\Asset;
use App\Component;
use App\Maintenance;
use Carbon\Carbon;
use DemeterChain\Main;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
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

//dd($request->asset[0]['id']);
        $asset = \App\Asset::findOrFail($request->asset[0]['id'])->load(['components', 'warranty', 'maintenances']);

        $maintenance = new Maintenance();
        dd($asset);

        $maintenance->perform_on = \Carbon\Carbon::now();
        $maintenance->protocolUUID = \Ramsey\Uuid\Uuid::uuid4();
        $maintenance->protocolNumber = str_replace("0","",explode("0", $request->protocolId,'2')[1]);
        $maintenance->status = $request->status;
        $maintenance->isWarrantyEvent = $request->isWarrantyEvent;
        $maintenance->explanation = $request->explanation;

//        $maintenance = new \App\Maintenance([
////            'perform_on' => \Carbon\Carbon::now(),
////            'protocolUUID' => \Ramsey\Uuid\Uuid::uuid4(),
////            'protocolNumber' => $request->protocolId === null ? "1234" : $request->protocolId,
//            'status' => $request->status,
//            'isWarrantyEvent' => $request->isWarrantyEvent,
//            'explanation' => $request->explanation,
//        ]);
//
//        dd($maintenance);
//        $asset
        $asset->maintenances()->save($maintenance);
        return response()->json('ok');
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
        $asset = \App\Asset::findOrFail($request->id)->load(['components', 'warranty', 'maintenances']);

        $maintenance = new \App\Maintenance([
            'perform_on' => \Carbon\Carbon::now(),
            'protocolUUID' => \Ramsey\Uuid\Uuid::uuid4(),
            'protocolNumber' => $request->protocolId,
            'status' => $request->status,
            'isWarrantyEvent' => $request->isWarrantyEvent,
            'explanation' => $request->explanation,
        ]);

        dd($asset);
        $asset->maintenances()->save($maintenance);

        return response()->json($asset);
    }

    public function setCaseStatus(Request $request)
    {

        $case = Maintenance::findOrFail($request->id);
        $case->status = $request->status;

        $case->saveOrFail();

        return response()->json(['message' => 'ok']);
    }

    public function getRmaNumber()
    {
        $lastMaintenanceID = DB::table('maintenances')
            ->orderBy('id', 'DESC')
            ->first()->id;
        $lastMaintenanceID += 1;
        if(!$lastMaintenanceID) {
            $lastMaintenanceID += 1;
        }
//        dd($lastMaintenanceID);
        $leadZeroPatern = str_pad($lastMaintenanceID, 10, 0, STR_PAD_LEFT);
        $completeMaintenanceIdForRecord = 'RMA-' . $leadZeroPatern;

        return $completeMaintenanceIdForRecord;

    }
}
