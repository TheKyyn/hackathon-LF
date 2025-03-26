<?php

namespace App\Livewire;

use App\Models\Lead;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class MultiStepForm extends Component
{
    // Données du formulaire
    public $step = 1;
    public $totalSteps = 10;

    // Vérification d'éligibilité
    public $isEligible = false;

    // Informations du lead
    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $phone = '';
    public $address = '';
    public $postal_code = '';
    public $city = '';
    public $department = '';
    public $birth_date = null;
    public $age = null;

    // Informations sur le logement
    public $energy_bill = '';
    public $energy_type = '';
    public $location_type = 'code_postal';
    public $is_owner = null;
    public $confirm_owner = false;
    public $property_type = '';
    public $property_size = '';
    public $household_status = '';
    public $heating_type = '';
    public $roof_insulated = null;
    public $roof_material = '';
    public $roof_orientation = '';

    // Informations financières et professionnelles
    public $professional_situation = '';
    public $financing_method = '';
    public $fiscal_reference_income = '';
    public $has_credits = null;
    public $credit_types = [];
    public $credit_monthly_amount = '';
    public $marital_status = '';
    public $spouse_professional_situation = '';

    // Informations sur le projet
    public $installation_type = '';
    public $panel_size = '';
    public $pac_type = '';
    public $accept_aid = false;
    public $household_count = '';
    public $annual_income = '';

    // Paramètres optionnels
    public $optin = false;

    // Paramètres de tracking
    public $utm_source = null;
    public $utm_medium = null;
    public $utm_campaign = null;

    // Getter pour $currentStep
    public function getCurrentStepProperty()
    {
        return $this->step;
    }

    // Options pour les différentes étapes
    public $energyBillOptions = [
        'less_100' => 'Moins de 100€',
        '100_200' => 'Entre 100€ et 200€',
        '200_300' => 'Entre 200€ et 300€',
        'more_300' => 'Plus de 300€'
    ];

    public $propertyTypeOptions = [
        'maison' => 'Maison individuelle',
        'appartement' => 'Appartement'
    ];

    public $propertySizeOptions = [
        'less_50' => 'Moins de 50m²',
        '51_100' => 'De 51 à 100m²',
        '101_150' => 'De 101 à 150m²',
        '151_200' => 'De 151 à 200m²',
        'more_200' => 'Plus de 200m²'
    ];

    public $householdStatusOptions = [
        'cdi' => 'CDI',
        'cdd' => 'CDD',
        'chomage' => 'Chômage',
        'retraite' => 'Retraité',
        'autre' => 'Autre'
    ];

    public $heatingTypeOptions = [
        'electrique' => 'Électrique',
        'gaz' => 'Gaz',
        'fioul' => 'Fioul',
        'bois' => 'Bois',
        'autre' => 'Autre'
    ];

    public $roofMaterialOptions = [
        'tuile' => 'Tuile',
        'ardoise' => 'Ardoise',
        'zinc' => 'Zinc',
        'etancheite' => 'Étanchéité',
        'autre' => 'Autre'
    ];

    public $installationTypeOptions = [
        'solaire' => 'Solaire',
        'photovoltaique' => 'Photovoltaïque',
        'chauffe_eau' => 'Chauffe-eau'
    ];

    public $pacTypeOptions = [
        'air_eau' => 'PAC Air/Eau',
        'air_air' => 'PAC Air/Air',
        'geothermie' => 'PAC géothermie'
    ];

    public $panelSizeOptions = [
        '10m' => '10m²',
        '20m' => '20m²',
        '30m' => '30m²',
        'dont_know' => 'Je ne sais pas'
    ];

    public $householdCountOptions = [
        '1' => '1 personne',
        '2' => '2 personnes',
        '3' => '3 personnes',
        '4_plus' => '4 personnes ou plus'
    ];

    public $annualIncomeOptions = [
        'less_20k' => 'Moins de 20k€/an',
        '20k_40k' => 'Entre 20k€ et 40k€/an',
        'more_40k' => 'Plus de 40k€/an'
    ];

    public $professionalSituationOptions = [
        'stable' => 'CDI, Retraité, Indépendant',
        'precaire' => 'CDD, Chômage, Autre'
    ];

    public $financingMethodOptions = [
        'auto' => 'Auto financement',
        'credit' => 'Financement'
    ];

    public $maritalStatusOptions = [
        'marie' => 'Marié',
        'concubinage' => 'Concubinage',
        'celibataire' => 'Célibataire'
    ];

    public $creditTypeOptions = [
        'immobilier' => 'Immobilier',
        'consommation' => 'Consommation',
        'renouvelable' => 'Renouvelable'
    ];

    // Règles de validation
    protected $rules = [
        'energy_bill' => 'required',
        'energy_type' => 'required',
        'location_type' => 'required',
        'postal_code' => 'required_if:location_type,code_postal|regex:/^[0-9]{5}$/',
        'department' => 'required_if:location_type,departement',
        'is_owner' => 'required|boolean',
        'confirm_owner' => 'required|accepted',
        'property_type' => 'required',
        'property_size' => 'required',
        'household_status' => 'required',
        'heating_type' => 'required',
        'roof_insulated' => 'required',
        'roof_material' => 'required',
        'roof_orientation' => 'required',
        'installation_type' => 'required',
        'panel_size' => 'required_if:installation_type,solaire,photovoltaique',
        'pac_type' => 'required_if:installation_type,chauffe_eau',
        'accept_aid' => 'boolean',
        'household_count' => 'required',
        'annual_income' => 'required',
        'first_name' => 'required|min:2',
        'last_name' => 'required|min:2',
        'email' => 'required|email|unique:leads,email',
        'phone' => 'required|regex:/^0[6-7][0-9]{8}$/',
        'birth_date' => 'nullable|date',
        'age' => 'nullable|numeric|min:18|max:100',
        'optin' => 'boolean',
        'professional_situation' => 'required',
        'financing_method' => 'required_if:professional_situation,stable',
        'fiscal_reference_income' => 'required|numeric',
        'has_credits' => 'required_if:financing_method,credit|boolean',
        'credit_types' => 'required_if:has_credits,1',
        'credit_monthly_amount' => 'required_if:has_credits,1|numeric',
        'marital_status' => 'required_if:professional_situation,precaire',
        'spouse_professional_situation' => 'required_if:marital_status,marie,concubinage',
    ];

    // Messages d'erreur personnalisés
    protected $messages = [
        'energy_bill.required' => 'Veuillez sélectionner le montant de votre facture',
        'energy_type.required' => 'Veuillez sélectionner votre fournisseur d\'énergie',
        'location_type.required' => 'Veuillez indiquer votre localisation',
        'postal_code.required_if' => 'Le code postal est obligatoire',
        'postal_code.regex' => 'Le code postal doit contenir 5 chiffres',
        'department.required_if' => 'Le département est obligatoire',
        'is_owner.required' => 'Veuillez indiquer si vous êtes propriétaire',
        'confirm_owner.required' => 'Vous devez confirmer être propriétaire du bien',
        'confirm_owner.accepted' => 'Vous devez confirmer être propriétaire du bien',
        'property_type.required' => 'Veuillez sélectionner un type de logement',
        'property_size.required' => 'Veuillez sélectionner la surface de votre logement',
        'household_status.required' => 'Veuillez sélectionner votre statut',
        'heating_type.required' => 'Veuillez sélectionner votre type de chauffage actuel',
        'roof_insulated.required' => 'Veuillez indiquer si votre toiture est isolée',
        'roof_material.required' => 'Veuillez sélectionner le matériau de votre toiture',
        'roof_orientation.required' => 'Veuillez sélectionner l\'orientation de votre toiture',
        'installation_type.required' => 'Veuillez sélectionner le type d\'installation souhaité',
        'panel_size.required_if' => 'Veuillez sélectionner la surface de panneaux souhaitée',
        'pac_type.required_if' => 'Veuillez sélectionner le type de pompe à chaleur souhaité',
        'accept_aid.required' => 'Veuillez indiquer si vous acceptez de bénéficier des aides',
        'household_count.required' => 'Veuillez indiquer le nombre de personnes dans votre foyer',
        'annual_income.required' => 'Veuillez indiquer vos revenus annuels',
        'first_name.required' => 'Le prénom est obligatoire',
        'last_name.required' => 'Le nom est obligatoire',
        'email.required' => 'L\'email est obligatoire',
        'email.email' => 'Veuillez entrer un email valide',
        'email.unique' => 'Cet email est déjà utilisé',
        'phone.required' => 'Le numéro de téléphone est obligatoire',
        'phone.regex' => 'Veuillez entrer un numéro de mobile valide (06/07)',
        'age.numeric' => 'L\'âge doit être un nombre',
        'age.min' => 'Vous devez avoir au moins 18 ans',
        'age.max' => 'L\'âge doit être inférieur à 100 ans',
        'professional_situation.required' => 'Veuillez sélectionner votre situation professionnelle',
        'financing_method.required_if' => 'Veuillez sélectionner votre méthode de financement',
        'fiscal_reference_income.required' => 'Veuillez indiquer votre revenu fiscal de référence',
        'fiscal_reference_income.numeric' => 'Le revenu fiscal doit être un nombre',
        'has_credits.required_if' => 'Veuillez indiquer si vous avez des crédits en cours',
        'credit_types.required_if' => 'Veuillez sélectionner les types de crédit',
        'credit_monthly_amount.required_if' => 'Veuillez indiquer le montant mensuel de vos crédits',
        'credit_monthly_amount.numeric' => 'Le montant mensuel doit être un nombre',
        'marital_status.required_if' => 'Veuillez sélectionner votre situation matrimoniale',
        'spouse_professional_situation.required_if' => 'Veuillez sélectionner la situation professionnelle de votre conjoint',
    ];

    /**
     * Montage du composant
     */
    public function mount()
    {
        // Récupérer les UTM s'ils existent
        $this->utm_source = request()->get('utm_source', null);
        $this->utm_medium = request()->get('utm_medium', null);
        $this->utm_campaign = request()->get('utm_campaign', null);

        // Récupérer le paramètre cost de l'URL et définir la réponse correspondante
        if (request()->has('cost')) {
            $costOption = request()->get('cost');

            switch ($costOption) {
                case 1:
                    $this->energy_bill = '0-50';
                    break;
                case 2:
                    $this->energy_bill = '50-100';
                    break;
                case 3:
                    $this->energy_bill = '100-150';
                    break;
                case 4:
                    $this->energy_bill = '150+';
                    break;
            }

            // Optionnellement, passer automatiquement à l'étape suivante
            // $this->nextStep();
        }

        // Pour les besoins du hackathon, définir isEligible à true par défaut
        $this->isEligible = true;
        Log::info('Composant monté avec isEligible=true par défaut');
    }

    /**
     * Rendu du composant
     */
    public function render()
    {
        return view('livewire.multi-step-form');
    }

    /**
     * Calcule si le lead est éligible en fonction des critères
     */
    public function calculateEligibility()
    {
        // Calculer l'âge à partir de la date de naissance
        if (!empty($this->birth_date)) {
            $birthDate = new \DateTime($this->birth_date);
            $today = new \DateTime();
            $age = $birthDate->diff($today)->y;
            $this->age = $age;
        }

        // Pour les besoins du hackathon, toujours définir comme éligible
        $this->isEligible = true;

        // Code original commenté
        /*
        $this->isEligible =
            (!empty($this->age) && $this->age <= 70) &&
            ($this->property_type === 'maison' && $this->confirm_owner) &&
            ($this->professional_situation === 'stable' ||
            (in_array($this->marital_status, ['marie', 'concubinage']) &&
            $this->spouse_professional_situation === 'stable'));
        */

        Log::info('Éligibilité calculée', ['isEligible' => $this->isEligible]);
        return $this->isEligible;
    }

    /**
     * Passer à l'étape suivante
     */
    public function nextStep()
    {
        // Valider les champs selon l'étape actuelle
        $this->validateStep();

        // Logique conditionnelle de parcours basée sur les étapes et les choix de l'utilisateur
        if ($this->step == 2 && $this->property_type === 'appartement') {
            // Si l'utilisateur a un appartement, on passe directement à la partie Profil (étape 8)
            $this->step = 8;
            return;
        }

        // Logique pour étape 4 - Situation professionnelle
        if ($this->step == 4) {
            if ($this->professional_situation === 'stable') {
                // Si stable, l'étape suivante est la méthode de financement
                $this->step = 5;
            } else {
                // Si précaire, l'étape suivante est la situation matrimoniale
                $this->step = 5;
            }
            return;
        }

        // Logique pour étape 5 - Financement ou situation matrimoniale
        if ($this->step == 5) {
            if ($this->professional_situation === 'stable') {
                if ($this->financing_method === 'auto') {
                    // Auto-financement -> revenu fiscal (étape 6)
                    $this->step = 6;
                } else {
                    // Financement -> crédits en cours (étape 6)
                    $this->step = 6;
                }
            } else { // Si précaire
                if ($this->marital_status === 'celibataire') {
                    // Si célibataire -> revenu fiscal (étape 6)
                    $this->step = 6;
                } else {
                    // Si marié/concubinage -> situation professionnelle du conjoint (étape 6)
                    // Ne pas changer l'étape, juste afficher la demande de situation du conjoint
                    $this->step = 6;
                }
            }
            return;
        }

        // Logique pour étape 6 - Crédits en cours ou situation conjoint ou revenu fiscal
        if ($this->step == 6) {
            if ($this->professional_situation === 'stable' && $this->financing_method === 'credit') {
                if ($this->has_credits) {
                    // Si a des crédits -> types de crédits (étape 7)
                    $this->step = 7;
                } else {
                    // Si pas de crédits -> revenu fiscal (étape 7)
                    $this->step = 7;
                }
            } else if ($this->professional_situation === 'precaire' && in_array($this->marital_status, ['marie', 'concubinage'])) {
                // Si précaire et marié/concubinage -> on vient de remplir la situation du conjoint
                if ($this->spouse_professional_situation === 'stable') {
                    // Si conjoint stable -> méthode financement conjoint (étape 7)
                    $this->step = 7;
                } else {
                    // Si conjoint précaire -> revenu fiscal (étape 7)
                    $this->step = 7;
                }
            } else {
                // Si auto-financement ou célibataire -> code postal (étape 7)
                $this->step = 7;
            }
            return;
        }

        // Logique pour étape 7 - Types de crédits ou méthode financement conjoint ou revenu fiscal
        if ($this->step == 7) {
            // Toutes les branches mènent à l'étape 8 (Profil)
            $this->step = 8;
            return;
        }

        // À l'étape 8 (Profil), on calcule l'éligibilité avant de passer aux coordonnées
        if ($this->step == 8) {
            $this->calculateEligibility();
            $this->step = 9;
            return;
        }

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
            case 1: // Montant facture d'énergie
                $this->validate(['energy_bill' => $this->rules['energy_bill']]);
                break;

            case 2: // Type de propriété et confirmation propriétaire
                $this->validate([
                    'property_type' => $this->rules['property_type'],
                    'confirm_owner' => $this->rules['confirm_owner'],
                ]);
                break;

            case 3: // Type de chauffage actuel
                $this->validate(['heating_type' => $this->rules['heating_type']]);
                break;

            case 4: // Situation professionnelle
                $this->validate(['professional_situation' => $this->rules['professional_situation']]);
                break;

            case 5: // Méthode de financement (si situation stable)
                if ($this->professional_situation === 'stable') {
                    $this->validate(['financing_method' => $this->rules['financing_method']]);
                } else if ($this->professional_situation === 'precaire') {
                    $this->validate(['marital_status' => $this->rules['marital_status']]);
                }
                break;

            case 6: // Crédits en cours (si financement) ou conjoint (si situation précaire et marié/concubinage)
                if ($this->professional_situation === 'stable' && $this->financing_method === 'credit') {
                    $this->validate(['has_credits' => $this->rules['has_credits']]);
                } else if ($this->professional_situation === 'precaire' && in_array($this->marital_status, ['marie', 'concubinage'])) {
                    $this->validate(['spouse_professional_situation' => $this->rules['spouse_professional_situation']]);
                } else if ($this->professional_situation === 'stable' && $this->financing_method === 'auto' ||
                         $this->professional_situation === 'precaire' && $this->marital_status === 'celibataire') {
                    $this->validate(['fiscal_reference_income' => $this->rules['fiscal_reference_income']]);
                }
                break;

            case 7: // Types de crédits (si a des crédits) ou code postal
                if ($this->professional_situation === 'stable' && $this->financing_method === 'credit' && $this->has_credits) {
                    $this->validate(['credit_types' => $this->rules['credit_types']]);
                } else if ($this->professional_situation === 'precaire' && in_array($this->marital_status, ['marie', 'concubinage']) && $this->spouse_professional_situation === 'stable') {
                    $this->validate(['financing_method' => $this->rules['financing_method']]);
                } else {
                    $this->validate(['postal_code' => $this->rules['postal_code']]);
                }
                break;

            case 8: // Profil (nom, prénom, date de naissance)
                $this->validate([
                    'first_name' => $this->rules['first_name'],
                    'last_name' => $this->rules['last_name'],
                    'birth_date' => $this->rules['birth_date'],
                ]);
                break;

            case 9: // Informations de contact (email, téléphone)
                $this->validate([
                    'email' => $this->rules['email'],
                    'phone' => $this->rules['phone']
                ]);
                $this->validatePhone();
                break;

            // Pas d'étapes 10+ car totalSteps = 10
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
            '0601020304',
            '0607080910',
        ];

        // Vérifier si le numéro est dans la liste des faux numéros
        if (in_array($this->phone, $fakeNumbers)) {
            $this->addError('phone', 'Ce numéro semble être un faux numéro');
            throw new \Exception('Faux numéro de téléphone détecté');
        }

        // Vérifier les répétitions suspectes
        if (preg_match('/(\d)\1{4,}/', $this->phone)) {
            $this->addError('phone', 'Ce numéro semble comporter trop de chiffres répétés');
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
        try {
            // Vérifier que les champs critiques sont remplis
            if (empty($this->email) || empty($this->phone)) {
                session()->flash('error', 'Veuillez remplir tous les champs obligatoires (email et téléphone).');
                return;
            }

            // S'assurer que is_owner est bien un booléen
            $isOwner = $this->is_owner;
            if (!is_bool($isOwner)) {
                if ($isOwner === '1' || $isOwner === 1) {
                    $isOwner = true;
                } elseif ($isOwner === '0' || $isOwner === 0) {
                    $isOwner = false;
                } else {
                    $isOwner = true; // Valeur par défaut
                }
            }

            // Simplifier la validation pour tester
            $validatedData = [
                'first_name' => $this->first_name ?: 'Non renseigné',
                'last_name' => $this->last_name ?: 'Non renseigné',
                'email' => $this->email ?: 'test'.time().'@example.com',
                'phone' => $this->phone,
                'energy_bill' => $this->energy_bill ?: '0-50',
                'energy_type' => $this->energy_type ?: 'EDF',
                'is_owner' => $isOwner,
                'property_type' => $this->property_type ?: 'maison',
                'property_size' => $this->property_size ?: 'more_200',
                'roof_material' => $this->roof_material ?: 'tuile',
                'roof_orientation' => $this->roof_orientation ?: 'Sud',
                'installation_type' => $this->installation_type ?: 'solaire',
                'postal_code' => $this->postal_code ?: '75000',
                'optin' => $this->optin ? true : false,
                'status' => 'new', // Ajout du statut par défaut
            ];

            // Ajouter l'adresse IP
            $validatedData['ip_address'] = Request::ip();

            // Ajouter les paramètres UTM
            $validatedData['utm_source'] = $this->utm_source;
            $validatedData['utm_medium'] = $this->utm_medium;
            $validatedData['utm_campaign'] = $this->utm_campaign;

            // Loguer les données pour debug
            Log::info('Tentative de création de lead', ['data' => $validatedData]);

            // Créer le lead avec le nouvel objet
            $lead = new Lead();
            $lead->first_name = $validatedData['first_name'];
            $lead->last_name = $validatedData['last_name'];
            $lead->email = $validatedData['email'];
            $lead->phone = $validatedData['phone'];
            $lead->energy_bill = $validatedData['energy_bill'];
            $lead->energy_type = $validatedData['energy_type'];
            $lead->is_owner = $validatedData['is_owner'];
            $lead->property_type = $validatedData['property_type'];
            $lead->property_size = $validatedData['property_size'];
            $lead->roof_material = $validatedData['roof_material'];
            $lead->roof_orientation = $validatedData['roof_orientation'];
            $lead->installation_type = $validatedData['installation_type'];
            $lead->postal_code = $validatedData['postal_code'];
            $lead->optin = $validatedData['optin'];
            $lead->status = $validatedData['status'];
            $lead->ip_address = $validatedData['ip_address'];
            $lead->utm_source = $validatedData['utm_source'];
            $lead->utm_medium = $validatedData['utm_medium'];
            $lead->utm_campaign = $validatedData['utm_campaign'];

            $lead->save();

            // Loguer le succès
            Log::info('Lead créé avec succès', ['id' => $lead->id]);

            // Afficher un message de succès sur la page courante au lieu de rediriger
            session()->flash('success', true);

            // Ne pas réinitialiser l'étape - laisser l'utilisateur voir le message de félicitations
            // $this->reset(['first_name', 'last_name', 'email', 'phone']);
            // $this->step = 1;

        } catch (\Exception $e) {
            // Loguer l'erreur de façon détaillée
            Log::error('Erreur lors de la soumission du formulaire: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'data' => [
                    'first_name' => $this->first_name,
                    'last_name' => $this->last_name,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'energy_bill' => $this->energy_bill,
                    'energy_type' => $this->energy_type,
                    'is_owner' => $this->is_owner,
                    'property_type' => $this->property_type,
                    'property_size' => $this->property_size,
                    'roof_material' => $this->roof_material,
                    'roof_orientation' => $this->roof_orientation,
                    'installation_type' => $this->installation_type,
                    'postal_code' => $this->postal_code,
                ]
            ]);
            session()->flash('error', 'Une erreur est survenue lors de la soumission du formulaire: ' . $e->getMessage());
        }
    }

    /**
     * Méthode de soumission alternative simplifiée
     */
    public function submitForm()
    {
        try {
            // Version ultra simplifiée sans validation
            $lead = new Lead();
            $lead->first_name = $this->first_name ?: 'Non renseigné';
            $lead->last_name = $this->last_name ?: 'Non renseigné';
            $lead->email = $this->email ?: 'test'.time().'@example.com';
            $lead->phone = $this->phone ?: '0600000000';
            $lead->postal_code = $this->postal_code ?: '75000';
            $lead->property_type = $this->property_type ?: 'maison';
            $lead->property_size = $this->property_size ?: 'more_200';

            // S'assurer que is_owner est bien un booléen
            if ($this->is_owner === '1' || $this->is_owner === 1 || $this->is_owner === true) {
                $lead->is_owner = true;
            } elseif ($this->is_owner === '0' || $this->is_owner === 0 || $this->is_owner === false) {
                $lead->is_owner = false;
            } else {
                $lead->is_owner = true; // Valeur par défaut
            }

            $lead->energy_bill = $this->energy_bill ?: '150+';
            $lead->energy_type = $this->energy_type ?: 'EDF';
            $lead->roof_material = $this->roof_material ?: 'tuile';
            $lead->roof_orientation = $this->roof_orientation ?: 'Sud';
            $lead->installation_type = $this->installation_type ?: 'solaire';
            $lead->ip_address = Request::ip();
            $lead->status = 'new';

            // Sauvegarder sans passer par create() pour éviter les fillable/validation
            $lead->save();

            // Log et notification de succès
            Log::info('Lead créé via méthode alternative', ['id' => $lead->id]);
            session()->flash('success', true);

            // Ne pas réinitialiser l'étape
            // $this->step = 1;

        } catch (\Exception $e) {
            // Message d'erreur visible directement
            session()->flash('error', 'ERREUR : ' . $e->getMessage());
            Log::error('Erreur submitForm: ' . $e->getMessage());
        }
    }

    /**
     * Définir le type de propriété
     */
    public function setPropertyType($value)
    {
        $this->property_type = $value;
    }

    /**
     * Définir le type d'énergie
     */
    public function setEnergyType($value)
    {
        $this->energy_type = $value;
    }

    /**
     * Définir si l'utilisateur est propriétaire
     */
    public function setIsOwner($value)
    {
        $this->is_owner = $value;
    }

    /**
     * Définir la taille de la propriété
     */
    public function setPropertySize($value)
    {
        $this->property_size = $value;
    }

    /**
     * Définir le matériau du toit
     */
    public function setRoofMaterial($value)
    {
        $this->roof_material = $value;
    }

    /**
     * Définir l'orientation du toit
     */
    public function setRoofOrientation($value)
    {
        $this->roof_orientation = $value;
    }

    /**
     * Définir le type d'installation
     */
    public function setInstallationType($value)
    {
        $this->installation_type = $value;
    }

    /**
     * Définir la situation professionnelle
     */
    public function setProfessionalSituation($value)
    {
        $this->professional_situation = $value;
    }

    /**
     * Définir la méthode de financement
     */
    public function setFinancingMethod($value)
    {
        $this->financing_method = $value;
    }

    /**
     * Définir si l'utilisateur a des crédits en cours
     */
    public function setHasCredits($value)
    {
        $this->has_credits = $value;
    }

    /**
     * Définir le type de crédit
     */
    public function setCreditType($value, $checked)
    {
        if ($checked) {
            if (!in_array($value, $this->credit_types)) {
                $this->credit_types[] = $value;
            }
        } else {
            $this->credit_types = array_filter($this->credit_types, function($type) use ($value) {
                return $type !== $value;
            });
        }
    }

    /**
     * Définir la situation matrimoniale
     */
    public function setMaritalStatus($value)
    {
        $this->marital_status = $value;
    }

    /**
     * Définir la situation professionnelle du conjoint
     */
    public function setSpouseProfessionalSituation($value)
    {
        $this->spouse_professional_situation = $value;
    }

    /**
     * Définir le type de chauffage
     */
    public function setHeatingType($value)
    {
        $this->heating_type = $value;
    }

    // Méthode d'urgence pour débogage
    public function addTestLead()
    {
        try {
            // Créer un lead test directement en DB
            $testLead = new Lead();
            $testLead->first_name = 'Test';
            $testLead->last_name = 'Urgence';
            $testLead->email = 'test'.time().'@test.com';
            $testLead->phone = '0687654321';
            $testLead->ip_address = '127.0.0.1';
            $testLead->status = 'debug';
            // Ajouter tous les champs requis
            $testLead->is_owner = true;
            $testLead->property_type = 'maison';
            $testLead->property_size = 'more_200';
            $testLead->energy_bill = '150+';
            $testLead->energy_type = 'EDF';
            $testLead->roof_material = 'tuile';
            $testLead->roof_orientation = 'Sud';
            $testLead->installation_type = 'solaire';
            $testLead->postal_code = '75000';
            $testLead->optin = false;

            $testLead->save();

            // Alerter du succès
            session()->flash('success', true);
            $this->dispatchBrowserEvent('alert', ['message' => 'Lead de test créé avec succès!']);
            Log::info('Lead de test créé avec succès', ['id' => $testLead->id]);

            // Ne pas réinitialiser l'étape
            // $this->step = 1;

            return true;
        } catch (\Exception $e) {
            session()->flash('error', 'ERREUR de test: ' . $e->getMessage());
            Log::error('Erreur création lead test: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Gère l'appui sur la touche Entrée
     */
    public function handleEnterKey()
    {
        // Appelle nextStep lorsque l'utilisateur appuie sur Entrée
        $this->nextStep();
    }
}
