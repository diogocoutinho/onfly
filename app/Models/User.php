<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable ;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relationship with Expediture
     * 
     * @return Expediture
     */
    public function expediture()
    {
        return $this->hasMany(Expenditure::class);
    }

    /**
     * Mapping users
     * @author Diogo C. Coutinho
     * @return User $object
     */
    public function scopeMappingUsers()
    {
        return $this->all()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'edit_url' => URL::route('users.edit', $user),
                'delete_url'    => URL::route('users.destroy', $user)
            ];
        });
    }

    /**
     * Create a new user
     * @param Array $data
     * @return User $data
     */
    public static function newUser($data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Update user data
     * @author Diogo C. Coutinho
     * @param Array $data
     * @return User $data
     */
    public static function updateUser($data)
    {
        return User::find($data['id'])->update([
            'name'  => $data['name'],
            'email' => $data['email']
        ]);
    }
}
