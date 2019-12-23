<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Maintenance extends Model
{
    protected $fillable = [
        'perform_on',
        'protocolUUID',
        'isWarrantyEvent',
        'protocolNumber',
        'status',
        'explanation'
    ];

    public function assets()
    {
        return $this->belongsToMany(Asset::class, 'asset_maintenance','asset_id','id');
    }

    public function generateRMANumber()
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

        return $leadZeroPatern;
    }
}
