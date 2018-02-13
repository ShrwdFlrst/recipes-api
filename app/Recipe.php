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

//    protected $hidden = ['rating', 'rating_count'];

    protected $dateFormat = 'd/m/Y H:i:s';

    protected $appends = ['average_rating'];

    /**
     * @return float|int
     */
    public function getAverageRatingAttribute()
    {
        return $this->rating_count > 0 ? $this->rating / $this->rating_count : 0;
    }
}
