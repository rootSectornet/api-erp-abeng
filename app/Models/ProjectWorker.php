<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectWorker extends Model
{
    use HasFactory;
    protected $table = "project_workers";
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_dt';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ProjectStepId',
        'positionId',
        'total',
        'salary',
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
    /**
     * Get the product that owns the step.
     */
    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
