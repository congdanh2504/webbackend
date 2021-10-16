<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class PostItem extends Model
{
    use HasFactory;
    protected $collection = 'postItems';
    protected $fillable = [
        "companyId",
        "dateTime",
        "name",
        "description",
        "salary",
        "category",
        "address",
        "imagesAddress",
        "applies" 
    ];
}
