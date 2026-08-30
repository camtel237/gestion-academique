<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Etablissement\AnneeAcademiqueController;
use App\Http\Controllers\Etablissement\DepartementController;
use App\Http\Controllers\Etablissement\SpecialiteController;
use App\Http\Controllers\Etablissement\NiveauController;
use App\Http\Controllers\Etablissement\SemestreController;
use App\Http\Controllers\Etablissement\PersonnelController;
use App\Http\Controllers\Etablissement\UEController;
use App\Http\Controllers\Notes\NoteController;
use App\Http\Controllers\Etablissement\MatiereController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\EffetsAcademiques\CarteEtudiantController;
use App\Http\Controllers\EffetsAcademiques\CertificatController;
use App\Http\Controllers\EffetsAcademiques\ReleveController;
use App\Http\Controllers\EffetsAcademiques\EffectifController;
use App\Http\Controllers\Administration\SettingController;
use App\Http\Controllers\Administration\ProfileController;



// ============================================
// ROUTES PUBLIQUES
// ============================================

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// Contournement fiable des soucis de lien symbolique Windows/Apache pour les fichiers stockés
Route::get('/storage/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);
    abort_unless(file_exists($fullPath), 404);
    return response()->file($fullPath);
})->where('path', '.*');

// ============================================
// ROUTES PROTÉGÉES (AUTHENTIFICATION REQUISE)
// ============================================
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ============================================
    // ROUTES ADMIN UNIQUEMENT
    // ============================================

    Route::middleware(['role:admin'])->group(function () {


        // ----- Profil personnel -----
        Route::get('/profile', fn () => redirect()->route('settings.index'))->name('profile.show');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

        // ----- Années académiques -----
        Route::resource('annees-academiques', AnneeAcademiqueController::class)
            ->parameters(['annees-academiques' => 'anneeAcademique']);
        Route::patch('annees-academiques/{anneeAcademique}/toggle-status', [AnneeAcademiqueController::class, 'toggleStatus'])->name('annees-academiques.toggle-status');

        // ----- Départements -----
        Route::resource('departements', DepartementController::class);
        Route::patch('departements/{departement}/toggle-status', [DepartementController::class, 'toggleStatus'])->name('departements.toggle-status');
        Route::patch('departements/{departement}/nommer-chef', [DepartementController::class, 'nommerChef'])->name('departements.nommer-chef');
        Route::patch('departements/{departement}/retirer-chef', [DepartementController::class, 'retirerChef'])->name('departements.retirer-chef');

        // ----- Spécialités -----
        Route::resource('specialites', SpecialiteController::class);
        Route::patch('specialites/{specialite}/toggle-status', [SpecialiteController::class, 'toggleStatus'])->name('specialites.toggle-status');

        // ----- Niveaux -----
        Route::resource('niveaux', NiveauController::class);
        Route::patch('niveaux/{niveau}/toggle-status', [NiveauController::class, 'toggleStatus'])->name('niveaux.toggle-status');
        Route::get('get-specialites', [NiveauController::class, 'getSpecialites'])->name('get-specialites');

        // ----- Semestres -----
        Route::resource('semestres', SemestreController::class);
        Route::patch('semestres/{semestre}/toggle-status', [SemestreController::class, 'toggleStatus'])->name('semestres.toggle-status');

        // ----- Diplômes -----
        //Route::resource('diplomes', DiplomeController::class);
        //Route::patch('diplomes/{diplome}/toggle-status', [DiplomeController::class, 'toggleStatus'])->name('diplomes.toggle-status');

        // ----- Personnel -----
        Route::resource('personnels', PersonnelController::class);
        Route::patch('personnels/{personnel}/toggle-status', [PersonnelController::class, 'toggleStatus'])->name('personnels.toggle-status');
        Route::get('personnels/{personnel}/create-user', [PersonnelController::class, 'createUser'])->name('personnels.create-user');
        Route::post('personnels/{personnel}/store-user', [PersonnelController::class, 'storeUser'])->name('personnels.store-user');
        Route::delete('personnels/{personnel}/detach-user', [PersonnelController::class, 'detachUser'])->name('personnels.detach-user');

        // ----- Unités d'enseignement -----
        Route::resource('ues', UEController::class);
        Route::get('get-semestres-by-niveau-ue', [UEController::class, 'getSemestresByNiveau'])->name('get.semestres.by.niveau.ue');
        Route::get('get-niveaux-by-annee-ue', [UEController::class, 'getNiveauxByAnnee'])->name('get.niveaux.by.annee.ue');
        // ----- Matières (UN SEUL) -----
        Route::resource('matieres', MatiereController::class);
        Route::patch('matieres/{matiere}/toggle-status', [MatiereController::class, 'toggleStatus'])->name('matieres.toggle-status');

        // ✅ Routes AJAX pour les filtres en cascade
        Route::get('get-niveaux-by-departement', [MatiereController::class, 'getNiveauxByDepartement'])->name('get.niveaux.by.departement');
        Route::get('get-semestres-by-niveau', [MatiereController::class, 'getSemestresByNiveau'])->name('get.semestres.by.niveau');
        Route::get('get-niveaux-by-annee-ue', [UEController::class, 'getNiveauxByAnnee'])->name('get.niveaux.by.annee.ue');
        Route::get('get-ues-by-niveau', [MatiereController::class, 'getUesByNiveau'])->name('get.ues.by.niveau');

        // ----- Administration -----
        Route::get('/users', function () {
            return view('administration.users');
        })->name('users.index');

        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    });
     // Route::resource('diplomes', DiplomeController::class);
     // Route::patch('diplomes/{diplome}/toggle-status', [DiplomeController::class, 'toggleStatus'])->name('diplomes.toggle-status');  
    // ============================================
    // ROUTES ÉTUDIANTS
    // ============================================
    Route::resource('etudiants', EtudiantController::class);
    Route::get('etudiants-export', [EtudiantController::class, 'export'])->name('etudiants.export');
    Route::post('etudiants-import', [EtudiantController::class, 'import'])->name('etudiants.import');
    Route::patch('etudiants/{etudiant}/toggle-status', [EtudiantController::class, 'toggleStatus'])->name('etudiants.toggle-status');

    // ============================================
    // ROUTES INSCRIPTIONS
    // ============================================
    Route::resource('inscriptions', InscriptionController::class);
    Route::patch('inscriptions/{inscription}/valider', [InscriptionController::class, 'valider'])->name('inscriptions.valider');
    Route::patch('inscriptions/{inscription}/annuler', [InscriptionController::class, 'annuler'])->name('inscriptions.annuler');
    Route::get('get-specialites-by-departement', [InscriptionController::class, 'getSpecialitesByDepartement'])
    ->name('get.specialites.by.departement');
    Route::get('get-niveaux-by-specialite-inscription', [InscriptionController::class, 'getNiveauxBySpecialite'])
    ->name('get.niveaux.by.specialite.inscription');



    // Notes - Routes AJAX pour la cascade
    Route::get('get-specialites-by-annee', [NoteController::class, 'getSpecialitesByAnnee'])->name('get.specialites.by.annee');
    Route::get('get-niveaux-by-specialite', [NoteController::class, 'getNiveauxBySpecialite'])->name('get.niveaux.by.specialite');
    Route::get('get-semestres-by-niveau-note', [NoteController::class, 'getSemestresByNiveau'])->name('get.semestres.by.niveau.note');
    Route::get('get-semestres-by-specialite', [NoteController::class, 'getSemestresBySpecialite'])->name('get.semestres.by.specialite');
    Route::get('get-matieres-by-semestre', [NoteController::class, 'getMatieresBySemestre'])->name('get.matieres.by.semestre');
    Route::get('get-etudiants-by-matiere', [NoteController::class, 'getEtudiantsByMatiere'])->name('get.etudiants.by.matiere');
    Route::get('get-inscription', [NoteController::class, 'getInscription'])->name('get.inscription');
    Route::post('notes-bulk', [NoteController::class, 'storeBulk'])->name('notes.store-bulk');
    // Notes CRUD
    Route::resource('notes', NoteController::class);

       // Effets académiques - Effectif (interface unifiée : spécialité -> niveau -> actions)
    Route::get('/effectifs', [EffectifController::class, 'index'])->name('effectifs.index');
    Route::get('/effectifs/get-niveaux', [EffectifController::class, 'getNiveauxBySpecialite'])->name('effectifs.get-niveaux');
    Route::get('/effectifs/get-etudiants', [EffectifController::class, 'getEtudiantsByNiveau'])->name('effectifs.get-etudiants');
    // Effets académiques - Cartes
    Route::get('/cartes-etudiant', [CarteEtudiantController::class, 'index'])->name('cartes.index');
    Route::get('/cartes-etudiant/{id}', [CarteEtudiantController::class, 'show'])->name('cartes.show');
    Route::get('/cartes-etudiant/{id}/download', [CarteEtudiantController::class, 'download'])->name('cartes.download');

      // Effets académiques - Certificats de scolarité
    Route::get('/certificats-scolarite', [CertificatController::class, 'index'])->name('certificats.index');
    Route::get('/certificats-scolarite/{id}', [CertificatController::class, 'show'])->name('certificats.show');
    Route::get('/certificats-scolarite/{id}/apercu', [CertificatController::class, 'preview'])->name('certificats.preview');
    Route::get('/certificats-scolarite/{id}/download', [CertificatController::class, 'download'])->name('certificats.download');
    
    // Effets académiques - Relevés de notes
    Route::get('/releves-notes', [ReleveController::class, 'index'])->name('releves.index');
    Route::get('/releves-notes/{id}', [ReleveController::class, 'show'])->name('releves.show');
    Route::get('/releves-notes/{id}/apercu', [ReleveController::class, 'preview'])->name('releves.preview');
    Route::get('/releves-notes/{id}/download', [ReleveController::class, 'download'])->name('releves.download');





    // ============================================
    // ROUTES EMPLOYÉ
    // ============================================

   /* Route::middleware(['role:employe'])->group(function () {
        Route::get('/etudiants', function () {
            return view('etudiants.index');
        })->name('etudiants.index');

        Route::get('/inscriptions', function () {
            return view('inscriptions.index');
        })->name('inscriptions.index');

        Route::get('/notes', function () {
            return view('notes.index');
        })->name('notes.index');

        Route::get('/releves', function () {
            return view('effets.releves');
        })->name('releves.index');

        Route::get('/cartes', function () {
            return view('effets.cartes');
        })->name('cartes.index');

        Route::get('/statistiques', function () {
            return view('statistiques.index');
        })->name('statistiques.index');

        Route::post('/etudiants', function () {
            return redirect()->back()->with('success', 'Étudiant créé avec succès.');
        })->name('etudiants.store');

        Route::post('/inscriptions', function () {
            return redirect()->back()->with('success', 'Inscription enregistrée avec succès.');
        })->name('inscriptions.store');

        Route::post('/notes', function () {
            return redirect()->back()->with('success', 'Notes saisies avec succès.');
        })->name('notes.store');
    });*/
});