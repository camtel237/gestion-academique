
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Certificat de scolarité</title>
    <style>
        @page { margin: 0; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
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
            padding: 28px 55px 0 55px;
        }
        .entete img { width: 100%; }

        .photo-wrap { text-align: center; margin-top: 6px; }
        .photo-wrap img {
            width: 80px;
            height: 95px;
            object-fit: cover;
            border: 1px solid #cbd5e0;
        }

        .title { text-align: center; margin-top: 4px; }
        .title h1 { font-size: 21px; font-weight: bold; color: #1a202c; letter-spacing: 0.5px; }
        .title h2 { 
            font-size: 15px; 
            color: #a0aec0;
            letter-spacing: 2px; 
            font-weight: normal; 
            margin-top: -6px; 
        }
        .numero { text-align: center; font-size: 13px; margin-top: 10px; color: #1a202c; }

        .intro-img { margin-top: 18px; }
        .intro-img img { width: 100%; }

        .fields { margin-top: 20px; width: 100%; }
        .fields td { font-size: 12.5px; padding-bottom: 13px; vertical-align: top; }
        .fields .lbl { font-weight: bold; color: #1a202c; }
        .fields .en { display: block; font-style: normal; font-size: 9.5px; color: #4a5568; }

        .statut { font-size: 12.5px; margin-top: 2px; font-weight: bold; color: #1a202c; }
        .statut .en { font-style: normal; font-size: 10px; color: #4a5568; display: block; font-weight: normal; }

        .footer-img { margin-top: 28px; }
        .footer-img img { width: 100%; }

        .qr-wrap { margin-top: -70px; padding-left: 4px; }
        .qr-wrap img { width: 70px; height: 70px; }

        /* Style pour le texte en bas - centré et stylé */
        .bottom-text {
            position: absolute;
            bottom: 35px;
            left: 0;
            right: 0;
            text-align: center;
            z-index: 2;
            padding: 0 55px;
        }

        .bottom-text .line1 {
            display: block;
            font-size: 10px;
            color:black;
            letter-spacing: 0.7px;
            line-height: 1.6;
            font-weight: 400;
        }

        .bottom-text .line2 {
            display: block;
            font-size: 10px;
            color:black;
            margin-top: 3px;
            letter-spacing: 0.5px;
            font-weight: 400;
        }

        .bottom-text .separator {
            display: inline-block;
            margin: 0 6px;
            color: rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="content">
            
            <div class="entete">
                <img src="<?php echo e(public_path('images/effets/certificat-entete.png')); ?>">
            </div>

            
            <div class="photo-wrap">
                <?php if($inscription->etudiant->photo && file_exists(public_path('storage/' . $inscription->etudiant->photo))): ?>
                    <img src="<?php echo e(public_path('storage/' . $inscription->etudiant->photo)); ?>">
                <?php endif; ?>
            </div>

            <div class="title">
                <h1>CERTIFICAT DE SCOLARITE</h1>
                <h2>SCHOOL ATTENDANCE CERTIFICATE</h2>
            </div>

            <div class="numero">
                N° <?php echo e(str_pad($numero, 5, '0', STR_PAD_LEFT)); ?>-<?php echo e(config('etablissement.code')); ?>/<?php echo e(date('Y')); ?>/<?php echo e(config('etablissement.code')); ?>/DA/DASR/CD/SCO/CISI
            </div>

            
            <div class="intro-img">
                <img src="<?php echo e(public_path('images/effets/certificat-intro.png')); ?>">
            </div>

            <table class="fields">
                <tr>
                    <td width="60%">
                        <span class="lbl">M./Mme/Mlle :</span>
                        <?php echo e(strtoupper($inscription->etudiant->nom . ' ' . $inscription->etudiant->prenom)); ?>

                        <span class="en">Mr/Mrs/Miss</span>
                    </td>
                </tr>
                <tr>
                    <td width="50%">
                        <span class="lbl">Né(e) le :</span>
                        <span class="value"><?php echo e($inscription->etudiant->date_naissance ? \Carbon\Carbon::parse($inscription->etudiant->date_naissance)->format('Y-m-d') : '-'); ?></span>
                        <span class="en">Born on the</span>
                    </td>
                    <td width="50%">
                        <span class="lbl">à :</span> 
                        <span class="value"><?php echo e($inscription->etudiant->lieu_naissance ?? '-'); ?></span>
                        <span class="en">at</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span class="lbl">Matricule :</span> <?php echo e($inscription->etudiant->matricule); ?>

                        <span class="en">Registration N°</span>
                    </td>
                </tr>
            </table>

            <div class="statut">
                Est étudiant(e) régulièrement inscrit(e) dans mon établissement
                <span class="en">is currently enrolled as a student in my school</span>
            </div>

            <table class="fields" style="margin-top: 16px;">
                <tr>
                    <td width="60%">
                        <span class="lbl">Département :</span> <?php echo e($inscription->departement->libelle ?? '-'); ?>

                        <span class="en">Department</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span class="lbl">Spécialité / Option :</span> <?php echo e($inscription->specialite->libelle ?? '-'); ?>

                        <span class="en">Speciality / Option</span>
                    </td>
                    <td width="40%">
                        <span class="lbl">Niveau :</span> <?php echo e($inscription->niveau->libelle ?? '-'); ?>

                        <span class="en">level</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-bottom:0;">
                        <span class="lbl">Année académique :</span> <?php echo e($inscription->anneeAcademique->libelle ?? '-'); ?>

                        <span class="en">Academic year</span>
                    </td>
                </tr>
            </table>

            
            <div class="footer-img">
                <img src="<?php echo e(public_path('images/effets/certificat-footer.png')); ?>">
            </div>

            
            <div class="qr-wrap">
                <img src="<?php echo e(public_path('images/effets/qr-code.png')); ?>">
            </div>
        </div>

        
        <div class="bottom-text">
            <span class="line1">Il n'est délivré qu'un seul exemplaire du présent certificat de scolarité. Only a unique school attendance certificate shall be issued</span>
            <span class="line2"> verification : infos.iba@univ-douala.cm</span>
        </div>
    </div>
</body>
</html><?php /**PATH C:\Users\horta-christ\Downloads\Nouveau dossier (3)\gestion-academique\resources\views/effets/certificats/pdf.blade.php ENDPATH**/ ?>