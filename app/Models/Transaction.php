<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $hidden = [];
    protected $primaryKey = 'id';
    public $timestamps = false;


    public function User()
    {
        return $this->belongsTo('App\Models\User', 'id', 'created_by');
    }
}
