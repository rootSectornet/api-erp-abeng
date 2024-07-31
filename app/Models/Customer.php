<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = "costumers";
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = ['name','email','address','phone','city_id',
        'created_at',
        'updated_at'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
