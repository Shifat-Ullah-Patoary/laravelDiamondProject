<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamMember extends Model
{
    protected $fillable = [
        'team_page_setting_id',
        'name',
        'position',
        'description',
        'image',
        'position_order',
    ];

    public function teamPageSetting(): BelongsTo
    {
        return $this->belongsTo(TeamPageSetting::class);
    }
}
