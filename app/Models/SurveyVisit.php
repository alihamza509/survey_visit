<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyVisit extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'shop_name',
        'owner_name',
        'owner_phone',
        'owner_email',
        'geo_location',
        'comments',
        'cement_brands',
        'other_products',
        'photo_1',
        'photo_2',
        'photo_3',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
