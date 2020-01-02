<?php

namespace App;

use App\Http\Resources\ComponentsResource;
use Illuminate\Database\Eloquent\Model;
use App\Support\Dataviewer;
class Asset extends Model
{
    use Dataviewer;
    protected $fillable = [
        'type_of_asset',
        'model',
        'location',
        'customer_id',
        'serial',
        'purchaseDate',
        'department',
        'title'
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

    public function media()
    {
        return $this->belongsToMany(Media::class, 'asset_media');
    }
    public function scopeOfType($query, $type) {
        return $query->where('type_of_asset', $type);
    }

    public function manufacturers()
    {
        return $this->belongsToMany(Manufacturer::class);
    }

    public function additionals()
    {
        return $this->belongsToMany(Additionals::class,'asset_additional','asset_id','id');
    }

    public function maintenances()
    {
        return $this->belongsToMany(Maintenance::class, 'asset_maintenance', 'asset_id');
    }

    public function countComponents()
    {
        return $this->components()->count();
    }

    public function openedMaintenanceProtocols()
    {
        return $this->maintenances()->where('status', '=',0);
    }

}
