<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TruckVehicleSection extends Model
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
                'badge' => 'Truck Service',
                'title' => 'Truck Name',
                'subtitle' => 'Reliable Transport Service',
                'description_1' => 'Diamond Group provides dependable transport solutions to help businesses move goods and materials efficiently.',
                'description_2' => 'Our commitment to reliable service, customer satisfaction, and professional transportation helps keep your business moving.',
                'image' => null,
            ],
            [
                'badge' => 'Transportation Solutions',
                'title' => 'Moving Your Business Forward',
                'subtitle' => 'Dependable Vehicles. Reliable Service.',
                'description_1' => 'Our transport services support businesses with practical vehicle solutions for moving goods and materials.',
                'description_2' => 'From everyday transportation needs to business logistics, Diamond Group is committed to dependable service and customer satisfaction.',
                'image' => null,
            ],
        ];
    }

    public function truckDetailsPageSetting(): BelongsTo
    {
        return $this->belongsTo(TruckDetailsPageSetting::class);
    }
}
