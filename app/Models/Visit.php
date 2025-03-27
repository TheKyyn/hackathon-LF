<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visit extends Model
{
    use HasFactory;

    /**
     * Les attributs assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cookie_token',
        'landing_page',
        'referrer_url',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
        'device_type',
        'browser',
        'browser_version',
        'os',
        'ip_address',
        'is_converted',
        'lead_id'
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_converted' => 'boolean',
    ];

    /**
     * Relation avec le lead.
     *
     * @return BelongsTo
     */
    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    /**
     * Marque cette visite comme convertie et l'associe à un lead.
     *
     * @param Lead $lead
     * @return void
     */
    public function convertToLead(Lead $lead): void
    {
        $this->update([
            'lead_id' => $lead->id,
            'is_converted' => true
        ]);
    }
}
