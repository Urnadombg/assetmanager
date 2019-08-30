<?php

use Illuminate\Database\Seeder;
use Laravel\File;

class ChairsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $file = \Illuminate\Support\Facades\File::get('database/fdm.json');
        $data = json_decode($file);

        foreach ($data as $asset) {
            $createAsset = new \App\Asset();
            $createAsset->type_of_asset = $asset->type_of_asset;
            $createAsset->model = $asset->model;
            $createAsset->location = $asset->location;
            $createAsset->customer_id = $asset->customer_id;
            $createAsset->serial = $asset->serial;
            $createAsset->purchaseDate = \Carbon\Carbon::parse($asset->purchaseDate)->toDate();
            $createAsset->department = $asset->department;
            $createAsset->title = $asset->title;
            $createAsset->save();

            foreach ($asset->components as $component) {
                $createAsset->components()->create(array(
                    'title' => $component->title,
                    'model' => $component->model,
                    'serial' => $component->serial,
                    'asset_id' => $createAsset->id
                ));
            }

        }
//        foreach (json_decode($file) as $obj) {
//            \App\Asset::create(array(
//                'type_of_asset' => $obj->type_of_asset,
//                'model' => $obj->model,
//                'location' => $obj ->location,
//                'customer_id' => $obj  ->customer_id,
//                'serial' => $obj   ->serial,
//                'purchaseDate' => \Carbon\Carbon::parse($obj ->purchaseDate)->toDate(),
//                'department' => $obj   ->department,
//                'title' => $obj->title
//            ));
//            foreach ($obj->components as $component) {
//
//            }
//        }


    }
}
