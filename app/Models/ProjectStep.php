<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectStep extends Model
{
    use HasFactory;
    protected $table = "project_steps";
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_dt';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'notes',
        'rank',
        'status',
        'dateStart',
        'dateEnd',
        'projectNo',
    ];

    /**
     * Get the product that owns the step.
     */
    public function project()
    {
        return $this->belongsTo(Projects::class);
    }
}
