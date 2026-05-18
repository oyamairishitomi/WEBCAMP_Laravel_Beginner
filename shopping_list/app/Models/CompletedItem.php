<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletedItem extends Model
{
    public $timestamps = false;
    protected $table = 'completed_items';
    protected $fillable = ['name', 'user_id', 'completed_at'];
}
