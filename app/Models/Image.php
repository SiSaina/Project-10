<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /** @use HasFactory<\Database\Factories\ImageFactory> */
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'url'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
