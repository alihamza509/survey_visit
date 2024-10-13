<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'date_of_expense',
        'invoice_photo',
        'expense_detail',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
