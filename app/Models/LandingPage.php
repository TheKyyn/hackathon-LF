<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
        'header_title',
        'header_subtitle',
        'header_cta_text',
        'header_cta_url',
        'footer_text',
        'footer_links',
        'custom_css',
        'custom_js',
        'section1_title',
        'section1_content',
        'section2_title',
        'section2_content',
        'section3_title',
        'section3_content',
        'testimonials',
        'faq_title',
        'faq_content',
        'custom_fields',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'testimonials' => 'array',
        'faq_content' => 'array',
        'footer_links' => 'array',
        'custom_fields' => 'array',
    ];

    /**
     * Les attributs par défaut.
     *
     * @var array
     */
    protected $attributes = [
        'is_active' => true,
        'cta_text' => 'Commencer maintenant',
        'cta_color' => '#41b99f',
        'primary_color' => '#4CAF50',
        'secondary_color' => '#2196F3',
        'blue_color' => '#013565',
        'header_cta_text' => 'Obtenez un devis',
        'footer_text' => '© 2025 Lead Factory - Tous droits réservés',
        'content' => '<p>Contenu par défaut de la landing page. Vous pouvez modifier ce contenu dans l\'interface d\'administration.</p>',
        'custom_fields' => '{}',
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

            // S'assurer que le contenu n'est jamais NULL
            if (is_null($landingPage->content)) {
                $landingPage->content = '<p>Contenu par défaut de la landing page. Vous pouvez modifier ce contenu dans l\'interface d\'administration.</p>';
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
     * Retourne la landing page par défaut (la première active)
     */
    public static function getDefault()
    {
        // D'abord, essayer de trouver une landing page marquée comme 'default'
        $default = self::where('slug', 'default')->first();

        // Si pas trouvé, prendre la première landing page active
        if (!$default) {
            $default = self::where('is_active', true)->first();
        }

        // Si toujours aucune landing page active n'existe, créer une landing page par défaut
        if (!$default) {
            $default = self::createDefault();
        }

        return $default;
    }

    /**
     * Crée une landing page par défaut
     */
    public static function createDefault()
    {
        $default = new self();
        $default->title = 'Landing Page par défaut';
        $default->subtitle = 'Économisez sur votre facture d\'énergie';
        $default->slug = 'default';
        $default->content = '<h2>Pourquoi choisir des panneaux solaires ?</h2><p>Les panneaux solaires vous permettent de produire votre propre électricité et de réduire considérablement votre facture énergétique. C\'est un investissement rentable et écologique.</p>';
        $default->advantages_title = 'Les avantages';
        $default->advantages_list = '<ul><li>Économies sur votre facture d\'électricité</li><li>Énergie propre et renouvelable</li><li>Valorisation de votre bien immobilier</li><li>Réduction de votre empreinte carbone</li></ul>';
        $default->is_active = true;
        $default->save();

        return $default;
    }

    /**
     * Duplique la landing page.
     */
    public function duplicate()
    {
        // Réplication de base du modèle
        $clone = $this->replicate();

        // Modifications spécifiques pour la copie
        $clone->title = $this->title . ' (copie)';
        $clone->slug = $this->slug . '-' . Str::random(5);
        $clone->is_active = true;

        // Duplication des images
        $imagesToDuplicate = ['background_image', 'logo', 'og_image'];

        foreach ($imagesToDuplicate as $imageField) {
            if (!empty($this->$imageField)) {
                // Copier le fichier dans le stockage
                $originalPath = $this->$imageField;
                $extension = pathinfo($originalPath, PATHINFO_EXTENSION);
                $newFileName = $imageField . '_' . Str::random(10) . '.' . $extension;
                $newPath = 'landing-pages/' . $newFileName;

                if (Storage::disk('public')->exists($originalPath)) {
                    try {
                        // Copier le fichier
                        Storage::disk('public')->copy($originalPath, $newPath);
                        // Attribuer le nouveau chemin
                        $clone->$imageField = $newPath;
                    } catch (\Exception $e) {
                        // En cas d'erreur, conserver l'ancien chemin
                        Log::error('Erreur lors de la duplication de l\'image: ' . $e->getMessage());
                        $clone->$imageField = $originalPath;
                    }
                }
            }
        }

        // Enregistrer la copie
        $clone->save();

        return $clone;
    }

    /**
     * Vérifie si un champ est personnalisé ou utilise la valeur par défaut
     *
     * @param string $field Nom du champ
     * @return bool True si le champ est personnalisé
     */
    public function isCustomized($field)
    {
        // Si le champ est null ou vide, il n'est pas personnalisé
        if (empty($this->$field) && $this->$field !== 0 && $this->$field !== false) {
            return false;
        }

        // Si le champ a une valeur par défaut dans $attributes et est différent
        if (isset($this->attributes[$field])) {
            return $this->$field != $this->attributes[$field];
        }

        // Si le champ n'a pas de valeur par défaut mais a une valeur
        return true;
    }

    /**
     * Récupère la valeur d'un champ ou sa valeur par défaut si non personnalisé
     *
     * @param string $field Nom du champ
     * @param mixed $defaultValue Valeur par défaut si aucune n'est définie
     * @return mixed Valeur du champ ou valeur par défaut
     */
    public function getValueOrDefault($field, $defaultValue = null)
    {
        // Si le champ est virtuel, on le gère directement via custom_fields
        if ($this->isVirtualField($field)) {
            $customFields = is_array($this->custom_fields) ? $this->custom_fields : [];
            return $customFields[$field] ?? $defaultValue;
        }

        // 1. Vérifier si c'est une propriété standard du modèle
        if (isset($this->$field) && !empty($this->$field) && $this->isCustomized($field)) {
            return $this->$field;
        }

        // 2. Vérifier dans le tableau custom_fields
        if (isset($this->custom_fields[$field]) && !empty($this->custom_fields[$field])) {
            return $this->custom_fields[$field];
        }

        // 3. Valeur par défaut du modèle
        if (isset($this->attributes[$field]) && !empty($this->attributes[$field])) {
            return $this->attributes[$field];
        }

        // 4. Landing page par défaut (si différente de celle-ci)
        if ($this->slug !== 'default') {
            $default = self::getDefault();
            if ($default && $default->id !== $this->id) {
                if (!empty($default->$field)) {
                    return $default->$field;
                }
                if (isset($default->custom_fields[$field]) && !empty($default->custom_fields[$field])) {
                    return $default->custom_fields[$field];
                }
            }
        }

        // 5. Valeur par défaut fournie en paramètre
        return $defaultValue;
    }

    /**
     * Intercepte l'assignation de propriétés non existantes pour les stocker dans custom_fields
     */
    public function __set($key, $value)
    {
        // Si le champ est virtuel ou n'existe pas comme attribut/colonne, le stocker dans custom_fields
        if ($this->isVirtualField($key) || !array_key_exists($key, $this->attributes)) {
            $customFields = is_array($this->custom_fields) ? $this->custom_fields : [];
            $customFields[$key] = $value;
            $this->attributes['custom_fields'] = json_encode($customFields);
        } else {
            $this->attributes[$key] = $value;
        }
    }

    /**
     * Permet d'accéder aux propriétés stockées dans custom_fields
     */
    public function __get($key)
    {
        // Si le champ est virtuel, le chercher directement dans custom_fields
        if ($this->isVirtualField($key)) {
            $customFields = json_decode($this->attributes['custom_fields'] ?? '{}', true);
            return $customFields[$key] ?? null;
        }

        // D'abord regarder si c'est un attribut standard
        if (array_key_exists($key, $this->attributes)) {
            return $this->attributes[$key];
        }

        // Sinon, regarder dans custom_fields
        $customFields = json_decode($this->attributes['custom_fields'] ?? '{}', true);
        return $customFields[$key] ?? null;
    }

    /**
     * Vérifie si un champ est virtuel (géré via custom_fields)
     *
     * @param string $field Nom du champ
     * @return bool True si le champ est virtuel
     */
    public function isVirtualField($field)
    {
        $virtual_fields = [
            'guarantee3_title', 'guarantee3_text',
            'benefits_title', 'benefit1_text', 'benefit2_text', 'benefit3_text',
            'footer_logo', 'footer_image', 'mentions_text', 'mentions_url',
            'privacy_text', 'privacy_url'
        ];

        return in_array($field, $virtual_fields);
    }

    /**
     * Sauvegarde le modèle dans la base de données
     *
     * @param array $options
     * @return bool
     */
    public function save(array $options = [])
    {
        // Récupérer les données à sauvegarder
        $attributes = $this->getAttributes();

        // Trouver les champs virtuels et les déplacer vers custom_fields
        $customFields = is_array($this->custom_fields) ? $this->custom_fields : [];
        $virtualFields = [];

        foreach ($attributes as $key => $value) {
            if ($this->isVirtualField($key)) {
                // Stocker dans custom_fields
                $customFields[$key] = $value;
                $virtualFields[] = $key;

                // Supprimer de la liste des attributs à sauvegarder directement
                unset($this->attributes[$key]);
            }
        }

        // Mettre à jour custom_fields
        $this->attributes['custom_fields'] = json_encode($customFields);

        // Journal pour debugging
        if (!empty($virtualFields)) {
            \Illuminate\Support\Facades\Log::debug('Champs virtuels déplacés vers custom_fields', [
                'model' => get_class($this),
                'id' => $this->id,
                'virtual_fields' => $virtualFields,
                'custom_fields' => $customFields,
            ]);
        }

        // Appeler la méthode parent
        return parent::save($options);
    }

    /**
     * Test de la gestion des champs virtuels
     *
     * @param string $field Nom du champ à tester
     * @param mixed $value Valeur à assigner
     * @return array Résultat du test
     */
    public static function testVirtualField($field, $value)
    {
        $landing = new self();
        $landing->title = 'Test Landing Page';
        $landing->slug = 'test-landing-' . time();

        // Assigner la valeur au champ
        $landing->$field = $value;

        // Vérifier si le champ est considéré comme virtuel
        $isVirtual = $landing->isVirtualField($field);

        // Récupérer les attributs avant sauvegarde
        $attributes = $landing->getAttributes();
        $customFields = json_decode($attributes['custom_fields'] ?? '{}', true);

        // Créer une copie sans effectuer de sauvegarde en base
        $result = [
            'field' => $field,
            'value' => $value,
            'is_virtual' => $isVirtual,
            'in_attributes' => array_key_exists($field, $attributes),
            'in_custom_fields' => array_key_exists($field, $customFields),
            'attributes' => array_keys($attributes),
            'custom_fields' => $customFields,
        ];

        // Simuler une sauvegarde sans sauvegarder réellement en base
        $landing->save(['touch' => false]);

        // Récupérer les attributs après processus de sauvegarde
        $afterAttributes = $landing->getAttributes();
        $afterCustomFields = json_decode($afterAttributes['custom_fields'] ?? '{}', true);

        $result['after_save'] = [
            'in_attributes' => array_key_exists($field, $afterAttributes),
            'in_custom_fields' => array_key_exists($field, $afterCustomFields),
            'attributes' => array_keys($afterAttributes),
            'custom_fields' => $afterCustomFields,
        ];

        // Vérifier la récupération via getValueOrDefault
        $result['get_value'] = $landing->getValueOrDefault($field, 'default');

        return $result;
    }

    /**
     * Test de création complète d'une landing page avec champs virtuels
     *
     * @return array Résultat du test
     */
    public static function testCreateWithVirtualFields()
    {
        try {
            $landing = new self();
            $landing->title = 'Test Landing Page ' . time();
            $landing->slug = 'test-landing-' . time();
            $landing->content = '<p>Test content</p>';

            // Définir quelques champs virtuels
            $landing->guarantee3_title = 'Test Garantie 3';
            $landing->guarantee3_text = 'Description de la garantie 3';
            $landing->benefits_title = 'Avantages Test';
            $landing->footer_logo = 'test-logo.png';

            // Ne pas sauvegarder réellement en base
            // $landing->save();

            return [
                'success' => true,
                'landing' => $landing->toArray(),
                'custom_fields' => $landing->custom_fields,
                'virtual_fields' => [
                    'guarantee3_title' => $landing->guarantee3_title,
                    'benefits_title' => $landing->benefits_title,
                ],
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ];
        }
    }
}
