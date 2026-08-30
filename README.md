# EduManager

Application de gestion académique développée avec Laravel, permettant la gestion complète du cursus étudiant : années académiques, départements, spécialités, niveaux, matières, inscriptions, notes, et génération des effets académiques (cartes étudiant, certificats de scolarité, relevés de notes).

## Sommaire

- [Fonctionnalités](#fonctionnalités)
- [Stack technique](#stack-technique)
- [Prérequis](#prérequis)
- [Installation](#installation)
- [Configuration](#configuration)
- [Utilisation](#utilisation)
- [Structure du projet](#structure-du-projet)
- [Déploiement](#déploiement)
- [Licence](#licence)

## Fonctionnalités

### Administration académique
- Gestion des **années académiques** (activation/désactivation, seuil de validation configurable par année)
- Gestion des **départements**, **spécialités** et **niveaux**
- Gestion des **semestres** et **unités d'enseignement (UE)**
- Gestion des **matières**, rattachées à une UE avec cascade département → niveau → semestre → UE
- Gestion du **personnel enseignant**

### Étudiants et inscriptions
- CRUD complet des **étudiants** (avec photo)
- **Import/export Excel** des étudiants (via Maatwebsite/Excel)
- **Inscriptions** des étudiants avec cascade département → spécialité → niveau
- Règle métier : un étudiant ne peut avoir qu'**une seule inscription active** à la fois (annulation requise avant réinscription)
- Validation et annulation des inscriptions

### Notes et évaluation
- Saisie des notes (CC 30% + Examen 70%) par matière
- Calcul automatique de la moyenne
- **Seuil de validation** propre à chaque année académique, appliqué uniquement à la moyenne générale (pas matière par matière)
- Génération de la **synthèse générale** : UE/EC acquis, taux de réussite, mention, décision (Admis/Ajourné)

### Effets académiques (génération PDF)
- **Cartes d'étudiant** au format carte (centrée, non A4)
- **Certificats de scolarité**
- **Relevés de notes** détaillés par UE/matière avec synthèse générale
- Génération via [DomPDF](https://github.com/barryvdh/laravel-dompdf)
- Vue "Générer effectif" pour parcourir les étudiants par spécialité/niveau et générer leurs effets en un clic

### Administration
- Gestion des utilisateurs et des rôles (admin)
- Paramètres généraux de l'application

## Stack technique

| Composant | Technologie |
|---|---|
| Framework | Laravel |
| Base de données | MySQL |
| Génération PDF | barryvdh/laravel-dompdf |
| Import/Export Excel | maatwebsite/excel |
| Frontend | Blade + Tailwind CSS |
| Icônes | Font Awesome |

## Prérequis

- PHP >= 8.2
- Composer
- MySQL >= 5.7 (ou MariaDB équivalent)
- Extensions PHP : `pdo_mysql`, `mbstring`, `zip`, `gd`, `bcmath`, `exif`

## Installation

```bash
# Cloner le dépôt
git clone https://github.com/votre-utilisateur/edumanager.git
cd edumanager

# Installer les dépendances PHP
composer install

# Copier le fichier d'environnement
cp .env.example .env

# Générer la clé d'application
php artisan key:generate
```

## Configuration

Renseignez les informations de connexion à la base de données dans `.env` :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestion_academique
DB_USERNAME=root
DB_PASSWORD=
```

Puis lancez les migrations :

```bash
php artisan migrate
php artisan storage:link
```

(Optionnel) Peuplez la base avec des données de test :

```bash
php artisan db:seed
```

## Utilisation

Démarrer le serveur de développement :

```bash
php artisan serve
```

L'application est accessible sur [http://localhost:8000](http://localhost:8000).

### Compte administrateur

> À compléter : indiquez ici les identifiants par défaut si vous avez un seeder d'admin, ou la procédure de création du premier compte.

## Structure du projet

```
app/
├── Http/Controllers/
│   ├── Etablissement/       # Départements, spécialités, niveaux, semestres, UE, matières, personnel
│   ├── EffetsAcademiques/   # Cartes, certificats, relevés (génération PDF)
│   ├── Notes/                # Gestion des notes
│   ├── Auth/                 # Authentification
│   └── ...
├── Models/
│   ├── Etablissement/        # Modèles liés à la structure académique
│   └── ...
resources/views/
├── etablissement/            # Vues d'administration académique
├── effets/                   # Vues cartes, certificats, relevés (aperçu + PDF)
├── notes/                    # Saisie et consultation des notes
└── layouts/                  # Layout principal de l'application
```

## Déploiement

Le projet inclut un `Dockerfile` prêt pour un déploiement sur des plateformes comme [Render](https://render.com).

Variables d'environnement requises en production :

```env
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=

DB_CONNECTION=mysql
DB_HOST=
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

> Note : le stockage des fichiers uploadés (photos étudiants) sur les plans gratuits de la plupart des hébergeurs est éphémère. Pour une utilisation en production durable, prévoyez un stockage externe (S3, Cloudinary, etc.).

## Licence

> À compléter selon votre choix (MIT, propriétaire, usage interne à l'établissement, etc.).




















<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
