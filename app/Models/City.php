<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $table = "citys";
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_dt';

    protected $fillable = ['name',
        'created_at',
        'updated_dt'];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
