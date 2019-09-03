<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $fillable = [
        'perform_on',
        'protocolUUID',
        'isWarrantyEvent',
        'explanation'
    ];

    public function assets()
    {
        return $this->belongsToMany(Asset::class, 'asset_maintenance','asset_id','id');
    }
}
