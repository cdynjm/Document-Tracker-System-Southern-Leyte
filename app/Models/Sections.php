<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sections extends Model
{
    use HasFactory;

    protected $table = "sections";

    protected $fillable = [
        'officeID',
        'section'
    ];

    public function Office() {
        return $this->hasOne(Offices::class, 'id', 'officeID');
     }
}
