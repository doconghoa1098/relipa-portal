<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'members';

    protected $fillable = [
        'member_code',
        'full_name',
        'email',
        'password',
        'gender',
        'marital_status',
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
        'avatar_official',
        'avatar',
        'nick_name',
        'birth_date',
        'skype',
        'facebook',
        'passport_number',
        'passport_expiration',
        'academic_level',
        'tax_identification',
        'healthcare_provider',
    ];
}
