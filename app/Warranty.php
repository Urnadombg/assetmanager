<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\TemplateProcessor;

class Warranty extends Model
{
    protected $fillable = [
        'asset_id',
        'component_id',
        'card_id',
        'start',
        'end',
        'periodInDays',
    ];

    public function components()
    {
        return $this->belongsTo(Component::class);
    }

    public function assets()
    {
        return $this->belongsTo(Asset::class);
    }

    public function generateAssetWarrantyCardFromToday($data)
    {
        $phpWord  = new PhpWord();
        $template = new TemplateProcessor(storage_path() . '/Garancionna-karta.docx');

        $template->setValues([
            'assetTitle' => $data['title'],
            'assetModel' => $data['model'],
            'serialNumber' => $data['serial'],
            'protocolDate' => '',
            'customer' => $data['customer']->name . ' ' . $data['customer']->lastname,
            'customerAddress' => $data['customer']->address,
            'customerPhone' => $data['customer']->phone,
            'cartDate' => \Carbon\Carbon::today(),
            'period' => \Carbon\Carbon::parse(\Carbon\Carbon::today()->addMonths(25))->diffInMonths(),
//        'customerAddress' => 'Lite',
        ]);
        // check if customer has directory
        if(!Storage::exists(storage_path('app/public/customers/customer-' . $data['customer']->id))) {
            Storage::disk('public')->makeDirectory('customers/customer-' . $data['customer']->id);
            Storage::disk('public')->makeDirectory('customers/customer-' . $data['customer']->id . '/warrantyCards');
            // save warranty cart
            $template->saveAs(storage_path('app/public/customers/customer-' .$data['customer']->id
            . '/warrantyCards/'
            . $data['title'] .
            '-'
            . $data['model']
            . '-'
            . $data['serial']
            . '.docx'
        ));
        } else {
            return;
        }

    }
}
