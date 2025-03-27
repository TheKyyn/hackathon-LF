# Lead Factory (LF) - Collecte de Leads

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-red" alt="Laravel Version">
  <img src="https://img.shields.io/badge/PHP-8.4-blue" alt="PHP Version">
  <img src="https://img.shields.io/badge/TALL%20Stack-1.0-purple" alt="TALL Stack">
  <img src="https://img.shields.io/badge/License-MIT-green" alt="License">
</p>

## 📋 À propos

Lead Factory est une plateforme web dédiée à la collecte de leads dans le domaine des énergies renouvelables (panneaux photovoltaïques et pompes à chaleur). Développée avec la stack TALL (Tailwind CSS, Alpine.js, Laravel, Livewire), elle propose un formulaire multi-étapes intuitif et des intégrations avec divers services externes.

Cette plateforme s'intègre avec la [Plateforme Centrale](https://github.com/TheKyyn/hackathon-platform-centrale) pour la synchronisation et le suivi des leads.

## ✨ Fonctionnalités

-   **Formulaire Multi-étapes**

    -   Interface utilisateur intuitive et responsive
    -   Validation en temps réel des données
    -   Progression visuelle entre les étapes
    -   Adaptation intelligente des questions suivantes

-   **Intégrations**

    -   Calendly pour la prise de rendez-vous
    -   Twilio pour l'envoi de SMS de confirmation
    -   Email personnalisé avec Mailtrap
    -   Synchronisation avec la Plateforme Centrale

-   **Administration**

    -   Tableau de bord avec statistiques
    -   Gestion des leads
    -   Suivi des conversions
    -   Visualisation des métriques

-   **Traçage des Visiteurs**

    -   Suivi du parcours utilisateur
    -   Analyse des sources de trafic
    -   Identification des points d'abandon

-   **Synchronisation avec la Plateforme Centrale**
    -   Envoi automatique des leads
    -   Webhooks pour les mises à jour
    -   API sécurisée par token
    -   File d'attente pour garantir la fiabilité

## 🚀 Installation

### Prérequis

-   PHP 8.4+
-   Composer
-   MySQL ou SQLite
-   Node.js & NPM

### Étapes d'installation

1. **Cloner le dépôt**

    ```bash
    git clone https://github.com/TheKyyn/hackathon-LF.git
    cd hackathon-LF
    ```

2. **Installer les dépendances**

    ```bash
    composer install
    npm install
    ```

3. **Configurer l'environnement**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Configurer la base de données**
   Modifiez le fichier `.env` avec vos informations de connexion à la base de données.

5. **Configurer les services externes**
   Dans le fichier `.env`, ajoutez les informations pour :

    - Twilio (SMS)
    - Calendly
    - Mailtrap (email)
    - Plateforme Centrale (URL et token API)

6. **Migrer la base de données**

    ```bash
    php artisan migrate
    ```

7. **Compiler les assets**

    ```bash
    npm run dev
    ```

8. **Démarrer le serveur**
    ```bash
    php artisan serve
    ```

## 🔄 Synchronisation avec la Plateforme Centrale

La synchronisation avec la Plateforme Centrale est une fonctionnalité clé :

1. **Configuration**

    - Définissez l'URL et le token API dans `.env`

    ```
    CENTRAL_PLATFORM_URL=http://localhost:8000
    CENTRAL_PLATFORM_API_TOKEN=your_api_token_here
    ```

2. **Synchronisation Manuelle**

    ```bash
    php artisan leads:sync
    ```

3. **Synchronisation Automatique**

    - La tâche planifiée s'exécute toutes les 10 minutes
    - Les nouveaux leads sont envoyés automatiquement
    - Les échecs sont réessayés via une file d'attente

4. **Tests**
   Les tests automatisés garantissent le bon fonctionnement de la synchronisation :
    ```bash
    php artisan test --filter=LeadSynchronizationTest
    ```

## 📊 Administration

Le tableau de bord d'administration offre :

-   Vue d'ensemble des leads collectés
-   Statistiques de conversion
-   Analyse des sources de trafic
-   Reporting des performances des campagnes

## 📱 Versions Mobiles et Tablettes

Le design responsive s'adapte parfaitement aux appareils mobiles et tablettes, offrant une expérience utilisateur optimale sur tous les écrans.

## 🔧 Personnalisation

La plateforme peut être personnalisée selon vos besoins :

-   Ajout de nouvelles étapes au formulaire
-   Modification des questions
-   Intégration de services supplémentaires
-   Personnalisation du design via Tailwind CSS

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.

## ✏️ Auteurs

-   **TheKyyn** - [GitHub](https://github.com/TheKyyn)

---

<p align="center">Développé avec ❤️ pour le Hackathon 2025</p>
