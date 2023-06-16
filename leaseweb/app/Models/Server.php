<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use App\Models\Location;


class Server extends Model
{
    use HasFactory, AsSource;

    /**
     * @var array
     */
    protected $fillable = [
        'location_id',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['location'];



    /**
     * Get the location associated with the request.
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'servers';

   
}
