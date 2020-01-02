<?php

namespace App\Http\Controllers\API;

use App\Component;
use App\Http\Resources\Components;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ComponentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $components = Component::with(['warranty', 'asset'])->get();
        $request = Component::with(['warranty', 'asset'])->paginate();
        $components = \App\Http\Resources\ComponentsResource::collection($request);

        return $components;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $component = new Component();
        $component->title = $request->title;
        $component->model = $request->model;
        $component->serial = $request->serial;


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $component = Component::findOrFail($id)->load(['customer','warranty','maintenances']);
        return $component;
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

    public function createNewMaintenance(Request $request)
    {
        $component = Component::findOrFail($request->component_id)->load(['warranty', 'maintenances']);

//        $asset = \App\Asset::findOrFail(1)->load(['components', 'warranty', 'maintenances']);
//

        $component->maintenances()->create([
            'perform_on' => Carbon::parse($request->perform_on),
            'protocolUUID' => \Ramsey\Uuid\Uuid::uuid4(),
            'isWarrantyEvent' => $request->isWarrantyEvent,
            'explanation' => $request->explanation,
        ]);

        return response()->json('ok');
    }
}
