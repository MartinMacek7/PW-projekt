<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'birth_number',
        'phone_number',
        'gender',
        'password',
        'address_street',
        'address_number',
        'address_city',
        'address_zip_code',
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



    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->surname;
    }


    public function getGenderTextAttribute()
    {
        return $this->gender === 'M' ? 'Muž' : 'Žena';
    }


}
