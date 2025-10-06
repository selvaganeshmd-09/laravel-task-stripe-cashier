<?php

namespace App\Models;
use Illuminate\Support\Str;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name','price','description','stripe_product_id'];

    public function checkouts()
    {
        return $this->hasMany(Checkout::class);
    }

    public function users()
    {
        return $this->hasManyThrough(User::class, Checkout::class, 'product_id', 'id', 'id', 'user_id');
    }

    protected static function boot()
    {
        parent::boot();

        //Generate UUID
        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }
}
