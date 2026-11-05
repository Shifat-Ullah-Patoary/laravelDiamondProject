<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    protected $fillable = [
        'title',
        'description',
        'facebook_url',
        'instagram_url',
        'linkedin_url',
        'whatsapp_url',
    ];

    protected $attributes = [
        'title' => 'Diamond Group',
        'description' => 'Providing quality solutions in travel, transport, and construction.',
        'facebook_url' => 'https://facebook.com/yourpage',
        'instagram_url' => 'https://instagram.com/yourpage',
        'linkedin_url' => 'https://linkedin.com/company/yourcompany',
        'whatsapp_url' => 'https://wa.me/8801XXXXXXXXX',
    ];
}
