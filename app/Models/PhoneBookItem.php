<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneBookItem extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'country_code',
        'timezone', 
        'insertedOn',
        'updatedOn'
    ];
}
