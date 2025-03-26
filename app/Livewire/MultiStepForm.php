<?php

namespace App\Livewire;

use App\Models\Lead;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class MultiStepForm extends Component
{
    // Données du formulaire
    public $step = 1;
    public $totalSteps = 8;

    // Informations du lead
    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $phone = '';
    public $address = '';
    public $postal_code = '';
    public $city = '';
    public $energy_type = '';
    public $property_type = '';
    public $is_owner = null;
    public $has_project = null;
    public $optin = false;

    // Paramètres de tracking
    public $utm_source = null;
    public $utm_medium = null;
    public $utm_campaign = null;

    // Messages d'erreur
    public $errorMessage = '';

    // Règles de validation pour chaque étape
    protected $rules = [
        'first_name' => 'required|min:2',
        'last_name' => 'required|min:2',
        'email' => 'required|email|unique:leads,email',
        'phone' => 'required|regex:/^0[6-7][0-9]{8}$/',
        'address' => 'required',
        'postal_code' => 'required|regex:/^[0-9]{5}$/',
        'city' => 'required',
        'energy_type' => 'required',
        'property_type' => 'required',
        'is_owner' => 'required|boolean',
        'has_project' => 'required|boolean',
        'optin' => 'boolean',
    ];

    // Messages d'erreur personnalisés
    protected $messages = [
        'first_name.required' => 'Le prénom est obligatoire',
        'last_name.required' => 'Le nom est obligatoire',
        'email.required' => 'L\'email est obligatoire',
        'email.email' => 'Veuillez entrer un email valide',
        'email.unique' => 'Cet email est déjà utilisé',
        'phone.required' => 'Le numéro de téléphone est obligatoire',
        'phone.regex' => 'Veuillez entrer un numéro de mobile valide (06/07)',
        'address.required' => 'L\'adresse est obligatoire',
        'postal_code.required' => 'Le code postal est obligatoire',
        'postal_code.regex' => 'Le code postal doit contenir 5 chiffres',
        'city.required' => 'La ville est obligatoire',
        'energy_type.required' => 'Veuillez sélectionner un type d\'énergie',
        'property_type.required' => 'Veuillez sélectionner un type de propriété',
        'is_owner.required' => 'Veuillez indiquer si vous êtes propriétaire',
        'has_project.required' => 'Veuillez indiquer si vous avez un projet',
    ];

    // Liste des types d'énergie
    public $energyTypes = [
        'pompe_a_chaleur' => 'Pompe à chaleur',
        'panneaux_photovoltaiques' => 'Panneaux photovoltaïques',
        'les_deux' => 'Les deux',
    ];

    // Liste des types de propriétés
    public $propertyTypes = [
        'maison_individuelle' => 'Maison individuelle',
        'appartement' => 'Appartement',
    ];

    /**
     * Montage du composant
     */
    public function mount()
    {
        // Récupérer les paramètres UTM s'ils existent
        $this->utm_source = Request::input('utm_source');
        $this->utm_medium = Request::input('utm_medium');
        $this->utm_campaign = Request::input('utm_campaign');
    }

    /**
     * Rendu du composant
     */
    public function render()
    {
        return view('livewire.multi-step-form');
    }

    /**
     * Passer à l'étape suivante
     */
    public function nextStep()
    {
        // Valider les champs selon l'étape actuelle
        $this->validateStep();

        // Si on est à la dernière étape, soumettre le formulaire
        if ($this->step == $this->totalSteps) {
            $this->submit();
            return;
        }

        // Sinon, passer à l'étape suivante
        $this->step++;
    }

    /**
     * Revenir à l'étape précédente
     */
    public function prevStep()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    /**
     * Valider les champs selon l'étape actuelle
     */
    public function validateStep()
    {
        // Définir les règles de validation en fonction de l'étape
        switch ($this->step) {
            case 1: // Type d'énergie
                $this->validate(['energy_type' => $this->rules['energy_type']]);
                break;
            case 2: // Type de propriété
                $this->validate(['property_type' => $this->rules['property_type']]);
                break;
            case 3: // Propriétaire ou locataire
                $this->validate(['is_owner' => $this->rules['is_owner']]);
                break;
            case 4: // A un projet
                $this->validate(['has_project' => $this->rules['has_project']]);
                break;
            case 5: // Coordonnées personnelles (nom, prénom)
                $this->validate([
                    'first_name' => $this->rules['first_name'],
                    'last_name' => $this->rules['last_name'],
                ]);
                break;
            case 6: // Email
                $this->validate(['email' => $this->rules['email']]);
                break;
            case 7: // Téléphone
                $this->validate(['phone' => $this->rules['phone']]);

                // Vérifier si le numéro de téléphone est un faux numéro
                $this->validatePhone();
                break;
            case 8: // Adresse
                $this->validate([
                    'address' => $this->rules['address'],
                    'postal_code' => $this->rules['postal_code'],
                    'city' => $this->rules['city'],
                ]);
                break;
        }
    }

    /**
     * Vérifier si le numéro de téléphone est valide (pas un faux numéro)
     */
    private function validatePhone()
    {
        // Liste de faux numéros courants
        $fakeNumbers = [
            '0600000000',
            '0611111111',
            '0622222222',
            '0633333333',
            '0644444444',
            '0655555555',
            '0666666666',
            '0677777777',
            '0688888888',
            '0699999999',
            '0612345678',
            '0687654321',
        ];

        // Vérifier si le numéro est dans la liste des faux numéros
        if (in_array($this->phone, $fakeNumbers)) {
            $this->addError('phone', 'Ce numéro semble être un faux numéro');
            throw new \Exception('Faux numéro de téléphone détecté');
        }

        // Vérifier si le numéro est déjà utilisé
        $existingLead = Lead::where('phone', $this->phone)->first();
        if ($existingLead) {
            $this->addError('phone', 'Ce numéro de téléphone est déjà utilisé');
            throw new \Exception('Numéro de téléphone déjà utilisé');
        }
    }

    /**
     * Soumettre le formulaire
     */
    public function submit()
    {
        // Valider tous les champs obligatoires
        $validatedData = $this->validate([
            'first_name' => $this->rules['first_name'],
            'last_name' => $this->rules['last_name'],
            'email' => $this->rules['email'],
            'phone' => $this->rules['phone'],
            'address' => $this->rules['address'],
            'postal_code' => $this->rules['postal_code'],
            'city' => $this->rules['city'],
            'energy_type' => $this->rules['energy_type'],
            'property_type' => $this->rules['property_type'],
            'is_owner' => $this->rules['is_owner'],
            'has_project' => $this->rules['has_project'],
            'optin' => $this->rules['optin'],
        ]);

        // Ajouter l'adresse IP
        $validatedData['ip_address'] = Request::ip();

        // Ajouter les paramètres UTM
        $validatedData['utm_source'] = $this->utm_source;
        $validatedData['utm_medium'] = $this->utm_medium;
        $validatedData['utm_campaign'] = $this->utm_campaign;

        // Créer le lead
        $lead = Lead::create($validatedData);

        // Rediriger vers la page de confirmation
        return redirect()->route('calendly', ['lead_id' => $lead->id]);
    }
}
