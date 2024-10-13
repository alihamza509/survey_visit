<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    use HasFactory;
    protected $fillable = [
        'shop_id',
        'user_id',
        'photo_display_of_battu',
        'trial_order',
        'potential_order_horizon',
        'payment_preference',
        'comments_of_meeting',
    ];

    public function shop()
    {
        return $this->belongsTo(SurveyVisit::class, 'shop_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
