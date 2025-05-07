<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// class User extends Authenticatable implements MustVerifyEmail
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'primeiro_nome',
        'nomes_meio',
        'ultimo_nome',
        'email',
        'username',
        'password',
        'processo',
        'bi',
        'telefone',
        'tipo_usuario',
        
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
        'full_name',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed'
        ];
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->primeiro_nome . ' ' . $this->nomes_meio . ' ' . $this->ultimo_nome);
    }

    public function condominio(): BelongsTo
    {
        return $this->belongsTo(Condominio::class, 'condominio_id');
    }
    
    // public function acesso()
    // {
    //     return $this->hasMany(Acesso::class, 'id');
    // }

    public function notificacao()
    {
        return $this->hasMany(Notificacao::class, 'user_id');
    }
}