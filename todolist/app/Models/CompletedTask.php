<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletedTask extends Model
{
    use HasFactory;

    const PRIORITY_VALUE = [
        1 => '低い',
        2 => '普通',
        3 => '高い',
    ];

    public function getPriorityString()
    {
        return $this::PRIORITY_VALUE[ $this->priority ] ?? '';
    }

    protected $guarded = [];
}
