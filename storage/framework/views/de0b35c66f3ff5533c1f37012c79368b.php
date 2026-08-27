
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Relevé de notes</title>
    <style>
        @page { margin: 0; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #000;
        }

        .page {
            width: 210mm;
            height: 297mm;
            background-image: url('<?php echo e(public_path('images/effets/certificat-fond.png')); ?>');
            background-repeat: no-repeat;
            background-position: top left;
            background-size: 210mm 297mm;
            position: relative;
        }

        .content { 
            padding: 18px 28px 0 28px; 
        }

        .entete img { 
            width: 100%; 
        }

        .title { 
            text-align: center; 
            margin-top: 4px; 
        }
        .title h1 { 
            font-size: 18px; 
            font-weight: bold; 
            color: #000; 
            letter-spacing: 0.5px; 
        }
        .title h2 { 
            font-size: 12px; 
            font-style: italic; 
            font-weight: bold; 
            color: #333; 
            margin-top: 1px; 
        }

        .numero { 
            text-align: center; 
            font-size: 10.5px; 
            font-weight: bold; 
            margin-top: 4px; 
            margin-bottom: 6px; 
        }

        /* Champs d'informations */
        .champs { 
            width: 100%;
            font-size: 10px;
            border-collapse: collapse;
            margin-top: 4px;
        }
        .champs td { padding-bottom: 4px; vertical-align: top; }
        .champs .lbl { font-weight: normal; font-size: 9.5px; }
        .champs .val { font-weight: bold; font-size: 10px; }
        .champs .en { display: block; font-style: italic; font-size: 8.5px; color: #4a5568; font-weight: normal; }

        /* Alignement spécfique Né(e) le / à */
        .birth-block {
            display: inline-block;
            vertical-align: top;
        }
        .birth-block .sub-en {
            font-style: italic;
            font-size: 8.5px;
            color: #4a5568;
            font-weight: normal;
            display: block;
        }

        /* Tableau des notes et synthèse */
        table.notes {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            font-size: 9px;
            border: 1px solid #000;
        }
        table.notes th, table.notes td {
            border: 1px solid #000;
            padding: 3px 4px;
        }
        table.notes th {
            color: #000;
            font-weight: bold;
            text-align: left;
            font-size: 8.5px;
            text-transform: uppercase;
        }
        
        table.notes tr.ue-row td {
            font-weight: bold;
        }
        
        table.notes td.center, table.notes th.center { text-align: center; }

        table.notes tr.synthese-title td {
            text-align: center;
            font-weight: bold;
            font-size: 9.5px;
            letter-spacing: 0.5px;
        }
        table.notes tr.synthese-head th {
            font-size: 8.5px;
            text-align: center;
        }
        table.notes tr.synthese-row td {
            text-align: center;
            font-weight: bold;
            font-size: 9px;
        }
        table.notes tr.caption td {
            text-align: center;
            font-size: 8px;
            font-style: italic;
            font-weight: normal;
        }

        /* Signatures et bas de page */
        .signature-block {
            width: 100%;
            margin-top: 30px;
        }
        .signature-date {
            margin-left:480px;
            font-weight: bold;
            font-style: italic;
            font-size: 10px;
            margin-bottom: 15px;
        }
        .signature-table {
            width: 85%;
            margin: 0 auto;
            border-collapse: collapse;
        }
        .signature-table td {
            text-align: center;
            font-weight: bold;
            font-size: 10px;
            vertical-align: top;
        }
        .signature-table .en {
            font-style: italic;
            font-size: 8.5px;
            display: block;
            font-weight: normal;
        }

        .qr-wrap {
            text-align: center;
            margin-top: 180px;
        }
        .qr-wrap img { width: 65px; height: 65px; }

        .footer-note {
            margin-top: 180px;
            text-align: center;
            font-size: 11px;
            font-style: italic;
            line-height: 1.3;
            letter-spacing: 0.7px;
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="content">

            <div class="entete">
                <img src="<?php echo e(public_path('images/effets/certificat-entete.png')); ?>">
            </div>

            <div class="title">
                <h1>RELEVÉ DE NOTES</h1>
                <h2>TRANSCRIPT</h2>
            </div>

            <div class="numero">
                N° <?php echo e(str_pad($numero, 6, '0', STR_PAD_LEFT)); ?>-<?php echo e(config('etablissement.code')); ?>/<?php echo e(date('Y')); ?>/<?php echo e(config('etablissement.code')); ?>/DA/DASR/SCO/CISI
            </div>

            <table class="champs">
                <tr>
                    <td width="62%">
                        <span class="lbl">Nom(s) & Prénom(s) :</span>
                        <span class="val"><?php echo e(mb_strtoupper($inscription->etudiant->nom . ' ' . $inscription->etudiant->prenom, 'UTF-8')); ?></span>
                        <span class="en">First and last Name</span>
                    </td>
                    <td width="38%">
                        <span class="lbl">Matricule :</span>
                        <span class="val"><?php echo e($inscription->etudiant->matricule); ?></span>
                        <span class="en">Registration N°</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="birth-block" style="margin-right: 15px;">
                            <span class="lbl">Né(e) le :</span>
                            <span class="val"><?php echo e($inscription->etudiant->date_naissance ? \Carbon\Carbon::parse($inscription->etudiant->date_naissance)->format('d / m / Y') : '-'); ?></span>
                            <span class="sub-en">Born on the</span>
                        </div>
                        <div class="birth-block">
                            <span class="lbl">à :</span>
                            <span class="val"><?php echo e($inscription->etudiant->lieu_naissance ?? '-'); ?></span>
                            <span class="sub-en">At</span>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <span class="lbl">Département :</span>
                        <span class="val"><?php echo e(mb_strtoupper($inscription->departement->libelle ?? '-', 'UTF-8')); ?></span>
                        <span class="en">Department</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="lbl">Spécialité / Option :</span>
<span class="val"><?php echo e(mb_strtoupper($inscription->specialite->libelle ?? '-', 'UTF-8')); ?></span>                        <span class="en">Speciality / Option</span>
                    </td>
                    <td>
                        <span class="lbl">Niveau :</span>
                        <span class="val"><?php echo e($inscription->niveau->libelle ?? '-'); ?></span>
                        <span class="en">Level</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span class="lbl">Année Académique :</span>
                        <span class="val"><?php echo e($inscription->anneeAcademique->libelle ?? '-'); ?></span>
                        <span class="en">Academic year</span>
                    </td>
                </tr>
            </table>

            <table class="notes">
                <thead>
                    <tr>
                        <th width="12%">Code UE</th>
                        <th width="15%">Code EC</th>
                        <th width="37%" class="center">Intitulé</th>
                        <th width="9%" class="center">Note/20</th>
                        <th width="9%" class="center">Crédit</th>
                        <th width="8%" class="center">Grade</th>
                        <th width="10%" class="center">Décision</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $ues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="ue-row">
                            <td colspan="3"><?php echo e($ue->code); ?> : <?php echo e($ue->libelle); ?></td>
                            <td class="center"><?php echo e($ue->moyenne !== null ? number_format($ue->moyenne, 2) : '-'); ?></td>
                            <td class="center"><?php echo e($ue->credit); ?></td>
                            <td class="center"><?php echo e($ue->grade); ?></td>
                            <td class="center"><?php echo e($ue->decision); ?></td>
                        </tr>
                        <?php $__currentLoopData = $ue->matieres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $matiere): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td></td>
                                <td><?php echo e($matiere->code); ?></td>
                                <td><?php echo e($matiere->libelle); ?></td>
                                <td class="center"><?php echo e($matiere->moyenne !== null ? number_format($matiere->moyenne, 2) : '-'); ?></td>
                                <td class="center"><?php echo e($matiere->credit); ?></td>
                                <td class="center"><?php echo e($matiere->grade); ?></td>
                                <td class="center"><?php echo e($matiere->decision); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <tr class="synthese-title">
                        <td colspan="7">SYNTHÈSE GÉNÉRALE DE L'ANNÉE</td>
                    </tr>
                    <tr class="synthese-head">
                        <th>SYNTHÈSE</th>
                        <th class="center">UE</th>
                        <th class="center">EC</th>
                        <th class="center">Crédit</th>
                        <th class="center">Moyenne</th>
                        <th class="center">Grade</th>
                        <th class="center">Mention</th>
                    </tr>
                    <tr class="synthese-row">
                        <td style="text-align:left;">Acquis</td>
                        <td><?php echo e($synthese->ue_acquis); ?></td>
                        <td><?php echo e($synthese->ec_acquis); ?></td>
                        <td rowspan="2" style="vertical-align: middle;"><?php echo e($synthese->credit_acquis); ?></td>
                        <td rowspan="2" style="vertical-align: middle;"><?php echo e($synthese->moyenne !== null ? number_format($synthese->moyenne, 2) : '-'); ?></td>
                        <td rowspan="2" style="vertical-align: middle;"><?php echo e($synthese->grade); ?></td>
                        <td rowspan="2" style="vertical-align: middle;"><?php echo e($synthese->mention); ?></td>
                    </tr>
                    <tr class="synthese-row">
                        <td style="text-align:left;">Taux</td>
                        <td><?php echo e(number_format($synthese->taux_ue, 2)); ?>%</td>
                        <td><?php echo e(number_format($synthese->taux_ec, 2)); ?>%</td>
                    </tr>
                    <tr class="caption">
                        <td colspan="7">UE : Unité d'Enseignements &nbsp;&nbsp;&nbsp;&nbsp; EC : Elément Constitutif</td>
                    </tr>
                </tbody>
            </table>

            <div class="signature-block">
                <div class="signature-date">Nkongsamba, le</div>
                <table class="signature-table">
                    <tr>
                        <td width="50%">
                            Le Chef de Département
                            <span class="en">The Head of Department</span>
                        </td>
                        <td width="50%">
                            Le Directeur
                            <span class="en">The Director</span>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="qr-wrap">
                <img src="<?php echo e(public_path('images/effets/qr-code.png')); ?>">
            </div>

         

        </div>
    </div>
</body>
</html><?php /**PATH D:\gestion-academique\resources\views/effets/releves/pdf.blade.php ENDPATH**/ ?>