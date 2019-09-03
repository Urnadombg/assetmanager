<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    protected $fillable = [
        'title',
        'model',
        'serial',
        'asset_id'
    ];

    public function warranty() {
        return $this->hasOne(Warranty::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function maintenances()
    {
        return $this->belongsToMany(Maintenance::class,'component_maintenance','component_id','id');
    }

    public function media()
    {
        return $this->hasMany(Media::class, 'component_id', 'id');
    }
}
