<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'Attendance';

    protected $fillable = [
        'attendanceID', 
        'userID', 
        'clockedIn', 
        'clockedOut', 
        'activity', 
        'longitudeIn', 
        'latitudeIn', 
        'longitudeOut', 
        'latitudeOut', 
        'pictureIn', 
        'pictureOut', 
        'condition'
    ];

    
    public $timestamps = false;
}
