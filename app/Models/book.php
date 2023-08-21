<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\order;
use App\Models\ratings_and_reviews;

class book extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_encrypted_id',
        'image',
        'title',
        'author',
        'price',
        'categories',
        'description',
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

    public function orders()
    {
        return $this->belongsToMany(order::class);
    }

    public function ratings()
    {
        return $this->hasMany(ratings_and_reviews::class);
    }
}
