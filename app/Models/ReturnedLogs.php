<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnedLogs extends Model
{
    use HasFactory;

    protected $table = 'returned_logs';

    protected $fillable = [
        'documentID',
        'trackerID',
        'officeID',
        'userID',
        'remarks'
    ];
}

