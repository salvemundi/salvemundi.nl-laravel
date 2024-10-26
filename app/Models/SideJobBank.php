<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SideJobBank extends Model
{
    use HasFactory;
    protected $table = "side_job_bank";
    public function skills(): BelongsToMany
    {
        return $this->belongsToMany
        (
            SideJobSkill::class,
            'skill_jobs',
            'jobId',
            'skillId'
        );
    }
}
