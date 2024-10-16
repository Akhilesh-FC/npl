<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionsUser extends Model
{
    use HasFactory;

    protected $table = 'permissions_users';

    protected $fillable = [
        'permissions_id',
        'role_id',
    ];
}
