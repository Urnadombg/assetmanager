<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $fillable = [
        'perform_on',
        'protocolUUID',
        'isWarrantyEvent',
        'asset_id',
        'component_id',
        'explanation'
    ];
}
