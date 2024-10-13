<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'shop_id',
        'user_id',
        'sample_order',
        'GST_details',
        'photo_of_product',
        'comments_of_meeting',
    ];
    public function shop()
    {
        return $this->belongsTo(SurveyVisit::class, 'shop_id');
    }
}
