<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\book;
use App\Models\User;


class order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'books',
        'quantity',
        'email',
        'name',
        'phone_number',
        'billing_address',
        'status',
        'grand_total',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function books()
    {
        return $this->belongsToMany(book::class);
    }
}
