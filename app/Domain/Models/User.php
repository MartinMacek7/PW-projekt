<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


/**
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property string $birth_number
 * @property string $phone_number
 * @property string $gender
 * @property string $password
 * @property string $address_street
 * @property string $address_number
 * @property string $address_city
 * @property string $address_zip_code
 * @property \Carbon\Carbon $created_at
 *
 * --------- Accessors ---------
 * @property-read string $full_name
 * @property-read string $gender_text
 */
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
