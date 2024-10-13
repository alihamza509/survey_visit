<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckInCheckOut extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'check_in',
        'check_out',
    ];

    // Define any relationships if needed
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
