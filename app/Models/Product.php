<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'product';

    public $timestamps = true;

    // protected $guarded = [];

    protected $fillable = [
        'id',
        'name',
        'price',
        'stock',
        'image',
        'created_at',
        'updated_at',
        'created_by',
        'update_by',
        'delete_by',
        'delete_at'
    ];


}