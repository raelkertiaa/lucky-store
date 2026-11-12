<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// #[Fillable(['name', 'email', 'password'])]
// #[Hidden(['password', 'remember_token'])]

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return[
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }

    protected function phone(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => self::normalizePhone($value),
        );
    }

    public static function normalizePhone(string $phone): string
    {
        $digits = preg_replace('/\D/', '',$phone);

        if(str_starts_with($digits, '0')){
            return '62' . substr($digits, 1);
        }

        if(str_starts_with($digits, '8')){
            return '62' . $digits;
        }

        return $digits;
    }

    public function isAdmin(): bool
    {
        return  $this->role === UserRole::Admin;
    }
}