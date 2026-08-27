e etudiant pdf.blade · PHP


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Carte d'étudiant</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; }
 
        .card {
            width: 400px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }
        .card-top {
            background: #1a365d;
            padding: 14px 18px;
            color: #ffffff;
        }
        .card-top table { width: 100%; }
        .card-top .brand { font-size: 17px; font-weight: bold; color: #ffffff; }
        .card-top .brand svg { vertical-align: middle; margin-right: 6px; }
        .card-top .badge {
            font-size: 10px;
            background: #ecc94b;
            color: #1a365d;
            padding: 3px 12px;
            border-radius: 20px;
            font-weight: bold;
        }
 
        .card-body { padding: 18px; }
        .card-body table { width: 100%; }
        .avatar {
            width: 90px;
            height: 108px;
            background: #edf2f7;
            border-radius: 8px;
            text-align: center;
            vertical-align: middle;
        }
        .avatar img { width: 90px; height: 108px; object-fit: cover; border-radius: 8px; }
 
        .info { padding-left: 15px; vertical-align: top; }
        .info .name { font-size: 15px; font-weight: bold; color: #1a365d; }
        .info .matricule { font-size: 11px; color: #718096; margin-bottom: 8px; }
 
        .row-table { width: 100%; margin-top: 6px; }
        .row-table td { font-size: 12px; padding: 4px 0; border-bottom: 1px dashed #e2e8f0; }
        .row-table .lbl { color: #718096; font-size: 10px; }
        .row-table .val { text-align: right; font-weight: bold; color: #2d3748; }
 
        .card-bottom {
            background: #f7fafc;
            border-top: 1px solid #e2e8f0;
            padding: 10px 18px;
        }
        .card-bottom table { width: 100%; }
        .card-bottom .valid { font-size: 9px; color: #718096; }
        .card-bottom .num { font-size: 10px; color: #1a365d; font-weight: bold; }
        .card-bottom .icon-box {
            width: 32px;
            height: 32px;
            background: #1a365d;
            border-radius: 6px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="card">
        <!-- En-tête -->
        <div class="card-top">
            <table>
                <tr>
                    <td class="brand">
                        <svg width="16" height="16" viewBox="0 0 24 24" style="vertical-align:-3px">
                            <path d="M12 3L1 9l11 6 9-4.9V17h2V9L12 3z" fill="#ffffff"/>
                            <path d="M5 13.2V18c0 1.7 3.1 3 7 3s7-1.3 7-3v-4.8l-7 3.8-7-3.8z" fill="#ffffff"/>
                        </svg>
                        EduManager
                    </td>
                    <td style="text-align:right;">
                        <span class="badge">CARTE</span>
                    </td>
                </tr>
            </table>
        </div>
 
        <!-- Corps -->
        <div class="card-body">
            <table>
                <tr>
                    <td class="avatar" width="90">
                        <?php if($inscription->etudiant->photo && file_exists(public_path('storage/' . $inscription->etudiant->photo))): ?>
                            <img src="<?php echo e(public_path('storage/' . $inscription->etudiant->photo)); ?>" alt="">
                        <?php else: ?>
                            <svg width="40" height="40" viewBox="0 0 24 24" style="margin-top:32px">
                                <circle cx="12" cy="8" r="4" fill="#a0aec0"/>
                                <path d="M4 20c0-4.4 3.6-8 8-8s8 3.6 8 8" fill="#a0aec0"/>
                            </svg>
                        <?php endif; ?>
                    </td>
                    <td class="info">
                        <div class="name"><?php echo e($inscription->etudiant->prenom); ?> <?php echo e($inscription->etudiant->nom); ?></div>
                        <div class="matricule">Matricule: <?php echo e($inscription->etudiant->matricule); ?></div>
 
                        <table class="row-table">
                            <tr>
                                <td class="lbl">Niveau</td>
                                <td class="val"><?php echo e($inscription->niveau->libelle ?? '-'); ?></td>
                            </tr>
                            <tr>
                                <td class="lbl">Spécialité</td>
                                <td class="val"><?php echo e($inscription->specialite->libelle ?? '-'); ?></td>
                            </tr>
                            <tr>
                                <td class="lbl" style="border-bottom:none;">Département</td>
                                <td class="val" style="border-bottom:none;"><?php echo e($inscription->departement->libelle ?? '-'); ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
 
        <!-- Pied -->
        <div class="card-bottom">
            <table>
                <tr>
                    <td>
                        <div class="valid">Valable jusqu'au 31/12/<?php echo e(date('Y') + 1); ?></div>
                        <div class="num">N° <?php echo e($inscription->etudiant->matricule); ?></div>
                    </td>
                    <td style="text-align:right;">
                        <table class="icon-box" style="margin-left:auto;">
                            <tr>
                                <td style="padding:7px;">
                                    <svg width="18" height="18" viewBox="0 0 24 24">
                                        <rect x="2" y="2" width="8" height="8" fill="#ffffff"/>
                                        <rect x="14" y="2" width="8" height="8" fill="#ffffff"/>
                                        <rect x="2" y="14" width="8" height="8" fill="#ffffff"/>
                                        <rect x="14" y="14" width="3" height="3" fill="#ffffff"/>
                                        <rect x="19" y="14" width="3" height="3" fill="#ffffff"/>
                                        <rect x="14" y="19" width="3" height="3" fill="#ffffff"/>
                                        <rect x="19" y="19" width="3" height="3" fill="#ffffff"/>
                                    </svg>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
 <?php /**PATH D:\gestion-academique\resources\views/effets/carte-etudiant-pdf.blade.php ENDPATH**/ ?>