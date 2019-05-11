<?php

namespace Hosein\Products;

use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    protected $fillable=[
        'id','name','parent','is_parent'
    ];
}
