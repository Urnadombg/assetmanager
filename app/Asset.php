<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = [
        'title',
        'model',
        'type_of_asset',
        'serial'
    ];

    public function components()
    {
        return $this->hasMany(Component::class);
    }
    public function warranty() {
        return $this->hasOne(Warranty::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
