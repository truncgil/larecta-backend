<?php 
namespace App\Models;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }
}
?>