<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Carte d'étudiant</title>

    <style>
        /*
        |--------------------------------------------------------------------------
        | CONFIGURATION DOMPDF
        |--------------------------------------------------------------------------
        | Pas de "size" ici : la taille de page est imposée par
        | $pdf->setPaper([0, 0, 383, 216]) dans le contrôleur.
        */

        @page {
            margin: 0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            background: #ffffff;
            color: #0f172a;
        }

        .page {
            width: 100%;
            height: 100%;
            position: relative;
        }

        /*
        |--------------------------------------------------------------------------
        | CARTE
        |--------------------------------------------------------------------------
        */

        .card {
            width: 450px;
            height: 205px;

            position: absolute;
            top: 50%;
            left: 50%;
            margin-top: -102.5px;
            margin-left: -225px;
             display: flex;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 14px;

            overflow: hidden;
        }

        /*
        |--------------------------------------------------------------------------
        | COLONNE GAUCHE
        |--------------------------------------------------------------------------
        */

        .left-side {
            position: absolute;
            left: 0;
            top: 0;
            width: 36px;
            height: 205px;
            background: #f8fafc;
            border-right: 1px solid #e2e8f0;
        }

        .reversed-title {
            position: absolute;
            top: 78px;
            left: -33px;
            width: 105px;
            font-size: 10.5px;
            font-weight: bold;
            color: #1e3a8a;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            transform: rotate(-90deg);
            white-space: nowrap;
        }

        .reversed-title span {
            color: #16a34a;
            font-size: 8.5px;
            margin-left: 6px;
            font-weight: bold;
        }

        /*
        |--------------------------------------------------------------------------
        | PARTIE DROITE
        |--------------------------------------------------------------------------
        */

        .right-side {
            position: absolute;
            left: 36px;
            top: 0;
            width: 413px;
            height: 205px;
        }

        /*
        |--------------------------------------------------------------------------
        | EN-TÊTE (fond blanc, pas gris)
        |--------------------------------------------------------------------------
        */

        .card-top {
            position: relative;
            width: 100%;
            height: 62px;
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
        }

    

        .flag img {
            width: 34px;
            height: 34px;
            object-fit: cover;
            margin-top: 5px;
        }
        .official-block {
            position: absolute;
            left: 60px;
            top: 6px;
            width: 345px;
            height: 50px;
            text-align: center;
            font-size: 7px;
            color: #334155;
            font-weight: bold;
            line-height: 1.3;
        }

        .official-left-logo {
            position: absolute;
            left: 0;
            top: 5px;
            width: 34px;
            height: 34px;
        }

      .official-right-logo {
    position: absolute;
    right: 15px;
    top: 5px;
    width: 30px;
    height: 34px;
}

        .official-text {
            position: absolute;
            left: 42px;
            right: 38px;
            top: 0;
            text-align: center;
        }

        .official-text .country {
            color: #1e3a8a;
            font-size: 7.5px;
        }

        .official-text .motto {
            font-style: italic;
            font-weight: normal;
            color: #475569;
        }

        .official-text .ministry {
            font-size: 7px;
        }

        .official-text .university {
            font-size: 8px;
            font-weight: bold;
            color: #0f172a;
        }

        /*
        |--------------------------------------------------------------------------
        | CORPS (fond jaune clair)
        |--------------------------------------------------------------------------
        */

        .card-body {
            position: relative;
            width: 100%;
            height: 108px;
            background: #fef9c3;
        }

        /*
        |--------------------------------------------------------------------------
        | PHOTO — cercle bleu clair, icône grise
        |--------------------------------------------------------------------------
        */

        .avatar {
            position: absolute;
            left: 16px;
            top: 12px;
            width: 82px;
            height: 82px;
            background: #dbeafe;
            border: 2px solid #bfdbfe;
            border-radius: 50%;
            overflow: hidden;
            text-align: center;
        }

        .avatar img {
            width: 78px;
            height: 78px;
            object-fit: cover;
            border-radius: 50%;
        }

        .avatar-placeholder {
            font-size: 34px;
            line-height: 78px;
            color: #93c5fd;
        }

        /*
        |--------------------------------------------------------------------------
        | INFORMATIONS — libellés en bleu, valeurs en noir gras
        |--------------------------------------------------------------------------
        */

        .info {
            position: absolute;
            left: 112px;
            top: 15px;
            width: 285px;
        }

        .info-row {
            width: 100%;
            margin-bottom: 8px;
            font-size: 10px;
            line-height: 1.3;
            white-space: nowrap;
        }

        .info-row .lbl {
            color: #2563eb;
            font-size: 9.5px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .info-row .val {
            color: #0f172a;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        /*
        |--------------------------------------------------------------------------
        | PIED DE CARTE
        |--------------------------------------------------------------------------
        */

        .card-bottom {
            position: relative;
            width: 100%;
            height: 35px;
            background: #fef9c3;
            border-top: 1px solid #fde68a;
        }

        .validity {
            position: absolute;
            right: 15px;
            top: 10px;
            font-size: 10.5px;
            color: #dc2626;
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>
</head>

<body>

<div class="page">

    <div class="card">

        <!-- BANDE GAUCHE -->
      <div class="left-side">
    <div class="flag">
        <img src="{{ public_path('images/effets/cmr.jpeg') }}" alt="Drapeau Cameroun">
    </div>
    <div class="reversed-title">
        CARTE D'ÉTUDIANT
        <span>STUDENT CARD</span>
    </div>
</div>
        <!-- PARTIE DROITE -->
        <div class="right-side">

            <!-- EN-TÊTE -->
            <div class="card-top">


                <div class="official-block">
                    <img src="{{ public_path('images/effets/logo-udo.png') }}" class="official-left-logo" alt="Université de Douala">

                    <div class="official-text">
                        <span class="country">REPUBLIQUE DU CAMEROUN</span>
                        <br>
                        <span class="motto">Paix - Travail - Patrie</span>
                        <br>
                        <span class="ministry">MINISTERE DE L'ENSEIGNEMENT SUPERIEUR</span>
                        <br>
                        <span class="university">UNIVERSITE DE DOUALA</span>
                    </div>

                    <img src="{{ public_path('images/effets/iba.png') }}" class="official-right-logo" alt="IBA">
                </div>

            </div>

            <!-- CORPS -->
            <div class="card-body">

                <div class="avatar">
                    @if($inscription->etudiant->photo)
                        <img src="{{ storage_path('app/public/' . $inscription->etudiant->photo) }}" alt="Photo étudiant">
                    @else
                        <div class="avatar-placeholder">👤</div>
                    @endif
                </div>

                <div class="info">
                    <div class="info-row">
                        <span class="lbl">MATRICULE:</span>
                        <span class="val">{{ $inscription->etudiant->matricule ?? '-' }}</span>
                    </div>

                    <div class="info-row">
                        <span class="lbl">NOMS & PRÉNOMS:</span>
                        <span class="val">{{ $inscription->etudiant->nom ?? '-' }} {{ $inscription->etudiant->prenom ?? '' }}</span>
                    </div>

                    <div class="info-row">
                        <span class="lbl">NIVEAU & SPÉCIALITÉ:</span>
                        <span class="val">{{ $inscription->niveau->libelle ?? '-' }} - {{ $inscription->specialite->libelle ?? '-' }}</span>
                    </div>

                    <div class="info-row">
                        <span class="lbl">DÉPARTEMENT:</span>
                        <span class="val">{{ $inscription->departement->libelle ?? '-' }}</span>
                    </div>
                </div>

            </div>

            <!-- PIED -->
            <div class="card-bottom">
                <div class="validity">
                    VALIDITÉ : {{ date('Y') }}-{{ date('Y') + 1 }}
                </div>
            </div>

        </div>

    </div>

</div>

</body>
</html>