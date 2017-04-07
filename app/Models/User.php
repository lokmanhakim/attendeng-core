<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $hidden = [
        'password',
        'token_expiry',
        'updated_at',
        'deleted_at'
    ];
    protected $primaryKey = 'id';

    public function Transaction()
    {
        return $this->hasOne('App\Models\Transaction', 'id', 'created_by');
    }
}
