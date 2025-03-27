@component('mail::message')
# Rappel de votre rendez-vous

Bonjour {{ $lead->first_name }},

Nous vous rappelons que votre rendez-vous avec un expert en panneaux solaires est prévu pour le **{{ $formattedDate }}**, soit dans moins de {{ $hoursBeforeAppointment }} heures.

Nous vous contacterons par téléphone au moment du rendez-vous. Assurez-vous d'être disponible et d'avoir votre téléphone à portée de main.

Pour rappel, voici vos informations :
- Nom : {{ $lead->first_name }} {{ $lead->last_name }}
- Email : {{ $lead->email }}
- Téléphone : {{ $lead->phone }}

@component('mail::button', ['url' => config('app.url')])
Voir mes informations
@endcomponent

Si vous avez besoin de modifier ou d'annuler votre rendez-vous, veuillez nous contacter dès que possible.

Merci de votre confiance,<br>
L'équipe La Factory
@endcomponent
