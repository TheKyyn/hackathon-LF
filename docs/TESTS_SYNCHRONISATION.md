# Guide de test pour la synchronisation des Leads

Ce document explique comment tester le système de synchronisation des leads entre le site de collecte et la plateforme centrale.

## Prérequis

1. Les deux projets doivent être installés et configurés :

    - Le site de collecte (hackathon-LF)
    - La plateforme centrale (hackathon-platform-centrale)

2. Les migrations doivent être exécutées sur les deux projets.

3. Le fichier `.env` du site de collecte doit contenir les variables suivantes :

    ```
    CENTRAL_PLATFORM_URL=http://localhost:8000
    CENTRAL_PLATFORM_API_TOKEN=your_api_token_here
    ```

4. Un site doit être créé dans la plateforme centrale avec le token API correspondant.

## Tests automatisés

Les tests automatisés vous permettent de vérifier que chaque composant fonctionne correctement.

### Exécuter les tests sur le site de collecte

```bash
cd hackathon-LF
php artisan test --filter=LeadSynchronization
```

### Exécuter les tests sur la plateforme centrale

```bash
cd hackathon-platform-centrale
php artisan test --filter=LeadApi
```

## Test manuel

Pour tester manuellement l'ensemble du système :

1. Créer un lead dans le site de collecte via le formulaire ou directement dans la base de données.

2. Observer le comportement du système :

    - L'observer devrait détecter la création/modification du lead
    - Le job de synchronisation devrait être mis en file d'attente (si la queue est configurée)
    - Le lead devrait apparaître dans la plateforme centrale

3. Vous pouvez également utiliser le script de test manuel :

    ```bash
    cd hackathon-LF
    php tests/manual_sync_test.php
    ```

4. Synchroniser les leads existants avec la commande Artisan :
    ```bash
    php artisan leads:sync-platform
    ```

## Vérification des résultats

Pour vérifier que tout fonctionne correctement :

1. Vérifier les logs des deux applications :

    ```bash
    tail -f hackathon-LF/storage/logs/laravel.log
    tail -f hackathon-platform-centrale/storage/logs/laravel.log
    ```

2. Vérifier les données dans les bases de données :

    - Table `leads` dans le site de collecte
    - Table `centralized_leads` dans la plateforme centrale

3. Vérifier le tableau de bord de la plateforme centrale pour voir si les leads apparaissent.

## Résolution des problèmes courants

1. **Erreur de connexion à la plateforme centrale**

    - Vérifier que l'URL de la plateforme centrale est correcte
    - Vérifier que la plateforme centrale est en cours d'exécution
    - Vérifier que le token API est valide

2. **Les leads ne sont pas synchronisés automatiquement**

    - Vérifier que l'observer est bien enregistré dans `AppServiceProvider`
    - Vérifier les logs pour détecter d'éventuelles erreurs

3. **Les mises à jour ne sont pas synchronisées**

    - Vérifier que l'observer gère bien l'événement `updated`
    - Vérifier que la méthode `syncWithCentralPlatform` fonctionne correctement

4. **La commande artisan échoue**
    - Vérifier les paramètres de la commande
    - Exécuter la commande avec l'option `--verbose` pour plus d'informations
