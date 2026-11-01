<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TeamPageSetting extends Model
{
    protected $fillable = [
        'section_header_top',
        'section_header_middle',
        'section_header_bottom',
        'founder_image',
        'founder_header_top',
        'founder_name',
        'designation',
        'founder_description',
        'member_heading',
        'member_description',

    ];

    public function teamMembers(): HasMany
    {
        return $this->hasMany(TeamMember::class)->orderBy('position_order');
    }
}
