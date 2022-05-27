<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use HasFactory, SoftDeletes;

    const TOOK_A_BREAK = -1;
    const OFFICIAL = 1;
    const COLLABORATORS = 2;
    const BUSSINESS = 3;
    const PARTIME = 4;
    const FRESHER = 5;

    protected $table = 'members';
    
    protected $fillable = [
        'member_code',
        'full_name',
        'email',
        'password',
        'remember_token',
        'gender',
        'marital_status',
        'birth_date',
        'permanent_address',
        'temporary_address',
        'identity_number',
        'identity_card_date',
        'identity_card_place',
        'nationality',
        'emergency_contact_name',
        'emergency_contact_relationship',
        'emergency_contact_number',
        'bank_name',
        'bank_account',
        'status',
    ];
}
