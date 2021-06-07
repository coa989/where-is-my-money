<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'date', 'amount', 'category_id'];

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function category()
    {
        $this->hasOne(User::class);
    }
}
