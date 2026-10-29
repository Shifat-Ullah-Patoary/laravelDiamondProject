<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TravelAndToursSection extends Model
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
                'badge' => 'Holiday Packages',
                'title' => 'Travel experiences made for you',
                'subtitle' => 'Discover destinations with confidence.',
                'description_1' => 'From relaxing getaways to carefully planned adventures, our travel packages make it simple to enjoy more of every journey.',
                'description_2' => 'We coordinate the essential details around your itinerary so you can focus on the places, people, and experiences that matter most.',
                'image' => null,
            ],
            [
                'badge' => 'Flight Reservations',
                'title' => 'Better journeys start here',
                'subtitle' => 'Reliable booking support from take-off to landing.',
                'description_1' => 'Our flight reservation service helps individuals, families, and business travelers find practical routes that fit their plans and budgets.',
                'description_2' => 'With attentive support and clear communication, we help make every booking step smooth and straightforward.',
                'image' => null,
            ],
            [
                'badge' => 'Tour Management',
                'title' => 'Your journey, thoughtfully arranged',
                'subtitle' => 'Personalized itineraries for memorable trips.',
                'description_1' => 'We organize tours around your interests, schedule, and travel style, creating itineraries that balance discovery with comfort.',
                'description_2' => 'Whether you are planning a private holiday or a group tour, Diamond Travel & Tours is ready to help bring your plans to life.',
                'image' => null,
            ],
        ];
    }

    public function travelAndToursPageSetting(): BelongsTo
    {
        return $this->belongsTo(TravelAndToursPageSetting::class);
    }
}
