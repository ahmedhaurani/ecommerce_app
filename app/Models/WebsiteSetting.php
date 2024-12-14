<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name',
        'site_description',
        'logo',
        'favicon',
        'meta_description',
        'meta_keyword',
        'header_ads_text',
        'footer_text',
        'facebook',
        'instagram',
        'snapchat',
        'youtube',
        'x', // X (formerly Twitter)
        'maintenance_mode',
    ];

    protected $casts = [
        'maintenance_mode' => 'boolean',
    ];
}
