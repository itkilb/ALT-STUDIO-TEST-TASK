<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'id_user', 'lat', 'lon' 
    ];

    protected $hidden = [
        'position'
    ];

    public function setCoordinate($lat, $lon)
    {

        $this->attributes['position'] = DB::raw("ST_GeomFromText('POINT($lat $lon)')");

        return $this;
    }

    public function GetCoordinate()
    {
        return new Coordinate($this->lat, $this->lon);
    }
}
