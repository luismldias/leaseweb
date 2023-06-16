<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;


class Location extends Model
{
    use HasFactory, AsSource;

    public $timestamps = false;


    /**
     * @var array
     */
    protected $fillable = [
        'name',
    ];

   

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'locations';



}
