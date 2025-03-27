<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LandingPage extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'subtitle',
        'slug',
        'content',
        'advantages_title',
        'advantages_list',
        'cta_text',
        'cta_color',
        'primary_color',
        'secondary_color',
        'background_image',
        'logo',
        'is_active',
        'meta_description',
        'meta_keywords',
        'og_title',
        'og_description',
        'og_image',
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
     * Les attributs par défaut.
     *
     * @var array
     */
    protected $attributes = [
        'is_active' => false,
        'cta_text' => 'Commencer maintenant',
        'cta_color' => '#4CAF50',
        'primary_color' => '#4CAF50',
        'secondary_color' => '#2196F3',
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
     * Retourne tous les landing pages actives.
     */
    public static function getActive()
    {
        return self::where('is_active', true)->get();
    }

    /**
     * Duplique la landing page.
     */
    public function duplicate()
    {
        $clone = $this->replicate();
        $clone->title = $this->title . ' (copie)';
        $clone->slug = $this->slug . '-' . Str::random(5);
        $clone->is_active = false;
        $clone->save();

        return $clone;
    }
}
