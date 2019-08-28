<?php

namespace App\Http\Controllers\API;

use App\Asset;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $assets = Asset::all();
        $assets = Asset::with(['components','warranty','customer', 'media'])->paginate();
        return response()->json($assets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $asset = new Asset();
        $asset->type_of_asset = $request->type_of_asset;
        $asset->model = $request->model;
        $asset->location = $request->location;
        $asset->customer_id = ($request->customer_id == null ? 0 : $request->customer_id);
        $asset->serial = $request->serial;
        $asset->purchaseDate = $request->purchaseDate;
        $asset->department = $request->department;
        $asset->title = $request->title;

        $asset->saveOrFail();

        return response()->json(['message' => 'Item has been saved!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $asset = Asset::with(['customer','warranty','components', 'media'])->where('id','=',$id)->get();
        return response()->json($asset);
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
        $assetToUpdate = Asset::find($id);
        $assetToUpdate->type_of_asset = $request->type_of_asset;
        $assetToUpdate->model = $request->model;
        $assetToUpdate->location = $request->location;
        $assetToUpdate->customer_id = ($request->customer_id == null ? 0 : $request->customer_id);
        $assetToUpdate->serial = $request->serial;
        $assetToUpdate->purchaseDate = $request->purchaseDate;
        $assetToUpdate->department = $request->department;
        $assetToUpdate->title = $request->title;

        $assetToUpdate->save();
        return response()->json('ok');
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
    public function primaryAssets() {
        $asset = Asset::ofType('primary')
        ->with(['components','warranty','customer','media'])
        ->paginate();
        return response()->json($asset);
    }
    public function secondaryAssets() {
        $asset = Asset::ofType('primary')->paginate();
        return response()->json($asset);
    }
}
