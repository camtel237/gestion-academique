<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Carte d'étudiant</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f1f5f9;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .card {
            width: 450px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            overflow: hidden;
            border: 1px solid #cbd5e0;
            display: flex;
        }

        /* Colonne gauche renversée */
        .left-side {
            width: 40px;
            background: #f8fafc;
            border-right: 2px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .reversed-title {
            transform: rotate(-90deg);
            white-space: nowrap;
            font-size: 12px;
            font-weight: 800;
            color: #1e3a8a;
            text-transform: uppercase;
        }
        .reversed-title span {
            display: block;
            color: #15803d;
            font-size: 10px;
        }

        /* Contenu principal */
        .right-side {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* En-tête */
        .card-top {
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
            padding: 12px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .flag {
            width: 36px;
            height: 24px;
            display: flex;
            border: 1px solid #cbd5e0;
            border-radius: 2px;
            overflow: hidden;
            position: relative;
        }
        .flag .col { flex: 1; height: 100%; }
        .flag .green { background: #007a5e; }
        .flag .red { background: #ce1126; display: flex; align-items: center; justify-content: center; }
        .flag .yellow { background: #fcd116; }
        .flag .star { color: #fcd116; font-size: 8px; line-height: 1; }

        .official-block { text-align: center; font-size: 8px; color: #334155; font-weight: 700; line-height: 1.2; display: flex; align-items: center; gap: 10px;}
        .logo-img { width: 35px; height: auto; }

        /* Corps jaune */
        .card-body {
            padding: 16px;
            background: #fef9c3;
            display: flex;
            gap: 16px;
            align-items: center;
            flex: 1;
        }

        .avatar {
            width: 95px;
            height: 95px;
            background: #edf2f7;
            border-radius: 50%; /* Photo encerclée */
            border: 3px solid #cbd5e0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: #a0aec0;
            flex-shrink: 0;
            overflow: hidden;
        }
        .avatar img { width: 100%; height: 100%; object-fit: cover; }

        .info { flex: 1; }
        .info-row { margin-bottom: 5px; font-size: 11px; white-space: nowrap; }
        .info-row .lbl { color: #64748b; font-size: 9px; font-weight: 700; text-transform: uppercase; display: inline; }
        .info-row .val { color: #0f172a; font-weight: 700; text-transform: uppercase; }

        /* Pied de carte jaune, Validité à droite */
        .card-bottom {
            background: #fef9c3;
            padding: 10px 16px;
            display: flex;
            justify-content: flex-end; /* Validité à droite */
            align-items: center;
            border-top: 1px solid #e2e8f0;
        }
        .card-bottom .validity { font-size: 12px; color: #dc2626; font-weight: 800; text-transform: uppercase; }

        /* Suppression boutons, voir code original */
        .actions {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
        }
        .btn {
            padding: 9px 18px;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background 0.2s;
        }
        .btn-success { background: #16a34a; color: white; }
        .btn-success:hover { background: #15803d; }
        .btn-secondary { background: #cbd5e1; color: #334155; }
        .btn-secondary:hover { background: #94a3b8; }

        @media print {
            .no-print { display: none !important; }
            .card { box-shadow: none !important; }
            body { background: white !important; padding: 0 !important; }
        }
    </style>
</head>
<body>
    <div>
        <!-- Carte -->
        <div class="card">
            <!-- Colonne renversée à gauche -->
            <div class="left-side">
                <div class="reversed-title">
                    Carte d'étudiant
                    <span>Student Card</span>
                </div>
            </div>

            <div class="right-side">
                <div class="card-top">
                    <!-- Drapeau à gauche -->
                    <div class="flag">
                        <div class="col green"></div>
                        <div class="col red"><span class="star">★</span></div>
                        <div class="col yellow"></div>
                    </div>

                    <!-- Logos entourant le texte -->
                    <div class="official-block">
                        <!-- Remplacez les chemins par vos images -->
                        <img src="{{ asset('images/effets/logo-udo.png') }}" class="logo-img" alt="UD">
                        <div>
                            REPUBLIQUE DU CAMEROUN<br>
                            <i>Paix - Travail - Patrie</i><br>
                            MINISTERE DE L'ENSEIGNEMENT SUPERIEUR<br>
                            <b>UNIVERSITE DE DOUALA</b>
                        </div>
                        <img src="{{ asset('images/effets/iba.ico') }}" class="logo-img" alt="IBA">
                    </div>
                </div>

                <div class="card-body">
                    <div class="avatar">
                        @if($inscription->etudiant->photo)
                            <img src="{{ url('storage/' . $inscription->etudiant->photo) }}" alt="Photo">
                        @else
                            <i class="fas fa-user"></i>
                        @endif
                    </div>
                    <div class="info">
                        <div class="info-row">
                            <span class="lbl">Matricule:</span>
                            <span class="val">{{ $inscription->etudiant->matricule }}</span>
                        </div>
                        <div class="info-row">
                            <span class="lbl">Noms & Prénoms:</span>
                            <span class="val">{{ $inscription->etudiant->nom }} {{ $inscription->etudiant->prenom }}</span>
                        </div>
                        <div class="info-row">
                            <span class="lbl">Niveau & Spécialité:</span>
                            <span class="val">{{ $inscription->niveau->libelle ?? '-' }} - {{ $inscription->specialite->libelle ?? '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="lbl">Département:</span>
                            <span class="val">{{ $inscription->departement->libelle ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <div class="card-bottom">
                    <div class="validity">Validité : {{ date('Y') }}-{{ date('Y')+1 }}</div>
                </div>
            </div>
        </div>

        <!-- Boutons d'actions -->
        <div class="actions no-print">
            <a href="{{ route('cartes.download', $inscription->id) }}" class="btn btn-success">
                <i class="fas fa-file-pdf"></i> Télécharger PDF
            </a>
            <a href="{{ route('effectifs.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
</body>
</html>