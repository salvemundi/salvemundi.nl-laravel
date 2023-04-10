<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SideJobSkill extends Model
{
    use HasFactory;
    protected $table = 'side_job_skills';

    public function jobs(): BelongsToMany
    {
        return $this->belongsToMany
        (
            SideJobBank::class,
            'skill_jobs',
            'skillId',
            'jobId'
        );
    }
}
