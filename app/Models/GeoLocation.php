<?php

namespace App\Models;

use App\Traits\SoftDeleteAttributes;
use App\Traits\TracksUserActions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GeoLocation extends Model
{
    protected $table = 'geo_locations';

    /** @use HasFactory<\Database\Factories\GeoLocationFactory> */
    use HasFactory, SoftDeletes, SoftDeleteAttributes, TracksUserActions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'created_by',
        'updated_by',
        'deleted_by',
        'name',
        'latitude',
        'longitude',
        'marker_color',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

}
