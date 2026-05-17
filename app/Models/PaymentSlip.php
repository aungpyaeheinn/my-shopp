<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class PaymentSlip extends Model
{
    protected $fillable = [
        'user_id',
        'advisor_id',
        'title',
        'description',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function advisor()
    {
        return $this->belongsTo(User::class, 'advisor_id');
    }
}
