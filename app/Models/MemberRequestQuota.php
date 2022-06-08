<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberRequestQuota extends Model
{
    use HasFactory;

    protected $table = 'member_request_quota';

    protected $fillable = [
        'member_id',
        'month',
        'quota',
        'remain'
    ];
}
