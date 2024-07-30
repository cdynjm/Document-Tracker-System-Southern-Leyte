<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceivedLogs extends Model
{
    use HasFactory;

    protected $table = 'received_logs';

    protected $fillable = [
        'documentID',
        'officeID',
        'sectionID',
        'userID',
        'username'
    ];

    public function User() {
        return $this->hasOne(User::class, 'id', 'userID');
    }
    public function Username() {
        return $this->hasOne(User::class, 'id', 'username');
    }
    public function Office() {
        return $this->hasOne(Sections::class, 'id', 'officeID');
    }
    public function Document() {
        return $this->hasOne(Documents::class, 'id', 'documentID');
    }
    public function Section() {
        return $this->hasOne(Sections::class, 'id', 'sectionID');
    }
}
