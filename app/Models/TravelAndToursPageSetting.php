<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TravelAndToursPageSetting extends Model
{
    protected $fillable = [
        'header_badge',
        'header_title_part_1',
        'header_title_part_2',
        'header_description',
        'header_image',
    ];

    public function sections(): HasMany
    {
        return $this->hasMany(TravelAndToursSection::class)->orderBy('position');
    }
}
