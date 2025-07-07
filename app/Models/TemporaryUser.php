<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemporaryUser extends Model
{
    protected $table = 'tbl_user_temp';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    protected $fillable = [
        'nama_user',
        'username',
        'email',
        'password',
        'jk',
        'nohp',
        'id_level',
        'verificationToken',
        'createdAt'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'createdAt' => 'datetime',
        'password' => 'hashed',
    ];

    public function level()
    {
        return $this->belongsTo(Level::class, 'id_level', 'id_level');
    }
}
