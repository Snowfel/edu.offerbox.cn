<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable
{
  use HasFactory, Notifiable;

  protected $guard = 'admin';

  protected $fillable = [
    'name',
    'email',
    'password',
  ];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function roles()
  {
    return $this->belongsToMany(Role::class, 'role_admin');
  }

  public function permissions()
  {
    return $this->roles()->with('permissions')->get()->pluck('permissions')->flatten()->pluck('name')->unique()->toArray();
  }

  public function hasPermission($permission)
  {
    return in_array($permission, $this->permissions());
  }

}
