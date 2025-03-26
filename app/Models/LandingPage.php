<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LandingPage extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'is_active',
        'meta_description',
        'meta_keywords',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Les hooks du modèle.
     */
    protected static function boot()
    {
        parent::boot();

        // Générer automatiquement un slug à partir du titre si le slug n'est pas défini
        static::creating(function ($landingPage) {
            if (empty($landingPage->slug)) {
                $landingPage->slug = Str::slug($landingPage->title);
            }
        });
    }

    /**
     * Cloner la landing page.
     *
     * @return \App\Models\LandingPage
     */
    public function duplicate()
    {
        $clone = $this->replicate();

        // Modifier le titre et le slug pour éviter les doublons
        $clone->title = $this->title . ' (copie)';
        $clone->slug = $this->slug . '-' . uniqid();

        $clone->save();

        return $clone;
    }
}
