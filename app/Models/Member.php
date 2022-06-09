<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

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
        'other_email',
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
        'insurance_number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

     /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }

    public function memberId()
    {
        return $this->hasOne(MemberRole::class, 'member_id');
    }
}
