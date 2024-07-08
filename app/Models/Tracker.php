<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracker extends Model
{
    use HasFactory;

    protected $table = "tracker";

    protected $fillable = [
        'trackerID',
        'sectionID',
        'officeID',
        'userID'
    ];

    public function Section() {
        return $this->hasOne(Sections::class, 'id', 'sectionID');
    }
    public function Office() {
        return $this->hasOne(Offices::class, 'id', 'officeID');
    }
}
