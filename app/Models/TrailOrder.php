<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
class TrailOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'shop_id',
        'user_id',
        'photo_display_of_battu',
        'types_of_order',
        'potential_order_horizon',
        'order_quantity',
        'order_delivery_calendar',
        'meeting_discussion_summary',
    ];

    protected $appends = ['photo_display_of_battu_url'];

    public function getPhotoDisplayOfBattuUrlAttribute()
    {
        return $this->photo_display_of_battu ? Storage::url($this->photo_display_of_battu) : null;
    }
    public function shop()
    {
        return $this->belongsTo(SurveyVisit::class, 'shop_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
