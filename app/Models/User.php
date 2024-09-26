<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Support\Facades\Storage;
 
class User extends Authenticatable implements FilamentUser,HasAvatar
{
    use HasRoles;

    // Definisikan fillable dan properti lain sesuai kebutuhan
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo_path', // Tambahkan ini agar bisa menyimpan path foto profil
    ];
    

    protected $hidden = [
        'password', 'remember_token',
    ];
    public function getFilamentAvatarUrl(): ?string
    {
        return asset(Storage::url($this->profile_photo_path));
    }
    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
