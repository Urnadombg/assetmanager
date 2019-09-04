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


//
        $customer = new App\Customer();
        $customer->name = 'Стефан';
        $customer->lastname = 'Костянев';
        $customer->phone = '032032032';
        $customer->address = 'бул. Васил Априлов №15 А';
        $customer->city = 'Пловдив';
        $customer->IsLegalEntity = true;
        $customer->legalEntity_id = 1;
        $customer->saveOrFail();
//
        $customer->companies()->create([
            'companyName' => 'Медицински Университет Пловдив',
            'address' => 'В. Априлов 15 А',
            'officialPersonInCharge' => 'Вяра Михова',
            'eik' => '0045995093',
            'bulstat' => 'BG0045995093',
            'isEntityRegisteredInVATRegister' => 1,
        ])->save();

//        $customer->saveOrFail();
        for ($i =0; $i <= 1000; $i++) {
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
                $createAsset->customer_id = 1;
                $createAsset->save();

                $createAsset->warranty()->create([
                    'asset_id' => $createAsset->id,
                    'card_id' => \Ramsey\Uuid\Uuid::uuid4(),
                    'start' => \Carbon\Carbon::parse($createAsset->purchaseDate),
                    'end' => \Carbon\Carbon::parse($createAsset->purchaseDate)->addYears(2),
                    'periodInDays' => \Carbon\Carbon::parse($createAsset->purchaseDate)
                        ->diffInDays(\Carbon\Carbon::parse($createAsset->purchaseDate)
                            ->addYears(2))
                ]);
                foreach ($asset->components as $component) {
                    $createComponent = new \App\Component();
                    $createComponent->title = $component->title;
                    $createComponent->model = $component->model;
                    $createComponent->serial = $component->serial;
                    $createComponent->asset_id = $createAsset->id;
//                $createAsset->components()->create(array(
//                    'title' => $component->title,
//                    'model' => $component->model,
//                    'serial' => $component->serial,
//                    'asset_id' => $createAsset->id
//                ));
                    $createComponent->save();

                    $createComponent->warranty()->create([
                        'component_id' => $createComponent->id,
                        'card_id' => \Ramsey\Uuid\Uuid::uuid4(),
                        'start' => \Carbon\Carbon::parse($createAsset->purchaseDate),
                        'end' => \Carbon\Carbon::parse($createAsset->purchaseDate)->addYears(2),
                        'periodInDays' => \Carbon\Carbon::parse($createAsset->purchaseDate)
                            ->diffInDays(\Carbon\Carbon::parse($createAsset->purchaseDate)
                                ->addYears(2))
                    ]);
                }

            }
        }
    }
}
