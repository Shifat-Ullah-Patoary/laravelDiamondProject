<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConstructionServiceSection extends Model
{
    protected $fillable = [
        'badge',
        'title',
        'subtitle',
        'description_1',
        'description_2',
        'image',
        'position',
    ];

    /**
     * @return array<int, array<string, string|null>>
     */
    public static function defaultSections(): array
    {
        return [
            [
                'badge' => 'Construction Supply',
                'title' => 'Building Materials You Can Rely On',
                'subtitle' => 'Quality products for every project.',
                'description_1' => 'Diamond Group supplies dependable construction materials to support residential, commercial, and infrastructure projects.',
                'description_2' => 'Our focus on quality, timely service, and customer satisfaction helps builders complete their work with confidence.',
                'image' => null,
            ],
            [
                'badge' => 'Project Support',
                'title' => 'Supporting Stronger Communities',
                'subtitle' => 'Practical solutions from start to finish.',
                'description_1' => 'We help customers find practical material solutions for projects of different sizes and requirements.',
                'description_2' => 'With reliable service and a commitment to long-term relationships, Diamond Group helps projects move forward.',
                'image' => null,
            ],
        ];
    }

    public function constructionDetailsPageSetting(): BelongsTo
    {
        return $this->belongsTo(ConstructionDetailsPageSetting::class);
    }
}
