<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $dateFormat = 'd/m/Y H:i:s';
}
