<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'userID',
        'fullname',
        'email',
        'password',
        'position',
        'picture',
    ];
    public $timestamps = false;
    protected $table = 'MasterUser';

    
    public function children()
    {
        return $this->hasMany(Attendance::class, 'userID');
    }
    
}
