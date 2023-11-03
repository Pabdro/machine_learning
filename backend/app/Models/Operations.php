<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operations extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'operation_type_id', 'box_id', 'user'];
}
