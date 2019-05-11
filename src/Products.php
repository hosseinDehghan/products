<?php

namespace Hosein\Products;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable=[
        'id','title','image','summery',
        'details','price','off','category_id',
        'some','like','dislike','visited'
    ];
}
