<?php

// ===============================================
// 1. CONFIGURATION ET CONNEXION À LA BASE DE DONNÉES
// ===============================================

// Inclut le fichier de connexion à la base de données.
include 'includes/db.inc.php';

// ===============================================
// 2. FONCTION DE GESTION DU CALENDRIER (PHP)
// ===============================================

// Définit le mois et l'année à afficher (par défaut : mois actuel, ou via les paramètres GET pour la navigation).
$month = isset($_GET['month']) ? (int)$_GET['month'] : date('m');
$year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');

// S'assure que le mois et l'année sont dans une plage valide pour éviter les erreurs.
if ($month < 1 || $month > 12) {
    $month = date('m');
}
if ($year < 2024 || $year > 2030) {
    $year = date('Y');
}

// Crée un objet DateTime pour le premier jour du mois à afficher.
$current_date = new DateTime("$year-$month-01");

// Utilise IntlDateFormatter pour obtenir le nom du mois en français (méthode moderne et recommandée).
$formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::NONE, null, null, 'MMMM');
$month_name_fr = $formatter->format($current_date);

// 3. Récupérer les jours partiellement ou totalement réservés
$reserved_days = [];
try {
    // Sélectionner les jours (sans l'heure) pour le mois en cours où le statut n'est pas 'annulé'
    // et compter le nombre de rendez-vous pour chaque jour.
    $stmt = $pdo->prepare("
        SELECT DATE(date_heure) as reserved_day, COUNT(id) as total_rdv
        FROM rendez_vous
        WHERE date_heure >= :start_month AND date_heure < :end_month AND statut != 'annule'
        GROUP BY reserved_day
    ");

    $start_month = $current_date->format('Y-m-01 00:00:00');
    $end_month = (clone $current_date)->modify('+1 month')->format('Y-m-01 00:00:00');

    $stmt->execute([':start_month' => $start_month, ':end_month' => $end_month]);
    $results = $stmt->fetchAll();

    // Traite les résultats pour déterminer si un jour est complet ou partiellement réservé.
    foreach ($results as $row) {
        // Le chiffre 8 correspond au nombre total de créneaux disponibles par jour (défini dans java.js).
        $is_fully_booked = ($row['total_rdv'] >= 8);
        $day = (new DateTime($row['reserved_day']))->format('j');
        $reserved_days[$day] = $is_fully_booked ? 'fully-booked' : 'partially-booked';
    }

} catch (\PDOException $e) {
    // En cas d'erreur BDD
    error_log("Erreur BDD: " . $e->getMessage());
}

// Calcule le mois précédent et suivant pour les liens de navigation du calendrier.
$prev_month = (clone $current_date)->modify('-1 month');
$next_month = (clone $current_date)->modify('+1 month');

// Récupère les informations nécessaires pour construire la grille du calendrier.
$num_days = $current_date->format('t'); // Nombre de jours dans le mois
$start_day_of_week = $current_date->format('N'); // Jour de la semaine du 1er (1=Lundi, 7=Dimanche)

// ===============================================
// 4. Récupérer la liste des services pour le formulaire
$stmt_services = $pdo->query("SELECT nom FROM services WHERE actif = 1 ORDER BY ordre_affichage");
$services_list = $stmt_services->fetchAll();


// Inclut l'en-tête de la page.
include 'includes/header.inc.php';
?>
    <main>

        <section class="hero-section" id="accueil" style="min-height: 80vh; padding-top: 150px;">
            <div class="hero-pattern"></div>
            <div class="hero-gradient"></div>
            <div class="container">

                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10">
                        <div class="calendar-box bg-white p-4 p-md-5 shadow-lg rounded" data-aos="fade-up">
                            <!-- En-tête du calendrier avec la navigation mois/année -->
                            <div class="calendar-header mb-4 text-center">
                                <a href="?month=<?php echo $prev_month->format('m'); ?>&year=<?php echo $prev_month->format('Y'); ?>"
                                   class="btn btn-outline-dark float-start"><i class="fas fa-chevron-left"></i></a>

                                <h2 class="d-inline-block text-capitalize">
                                    <?php echo $month_name_fr; ?> <?php echo $year; ?>
                                </h2>

                                <a href="?month=<?php echo $next_month->format('m'); ?>&year=<?php echo $next_month->format('Y'); ?>"
                                   class="btn btn-outline-dark float-end"><i class="fas fa-chevron-right"></i></a>
                            </div>

                            <!-- Grille du calendrier -->
                            <table class="calendar table table-bordered text-center">
                                <thead>
                                <tr>
                                    <th>Lun</th>
                                    <th>Mar</th>
                                    <th>Mer</th>
                                    <th>Jeu</th>
                                    <th>Ven</th>
                                    <th>Sam</th>
                                    <th>Dim</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <?php
                                    // 1. Crée des cellules vides pour le décalage du premier jour du mois.
                                    for ($i = 1; $i < $start_day_of_week; $i++): ?>
                                        <td></td>
                                    <?php endfor;

                                    // 2. Boucle pour afficher chaque jour du mois.
                                    $day_counter = $start_day_of_week;
                                    for ($day = 1; $day <= $num_days; $day++):
                                        $full_date = "$year-$month-" . str_pad($day, 2, '0', STR_PAD_LEFT);
                                        $today_class = ($day == date('j') && $month == date('m') && $year == date('Y')) ? 'today' : ''; // Classe pour le jour actuel.
                                        $reserved_status = $reserved_days[$day] ?? ''; // Statut de réservation (complet, partiel, vide).
                                        $is_past = strtotime($full_date) < strtotime(date('Y-m-d')); // Vérifie si le jour est dans le passé.
                                        $disabled_class = $is_past ? 'disabled' : ''; // Classe pour désactiver les jours passés.

                                        // Définit la classe CSS de fond en fonction de la disponibilité.
                                        $day_class = '';
                                        if ($reserved_status === 'fully-booked') {
                                            $day_class = 'bg-danger text-white fully-booked'; // Complètement réservé
                                        } elseif ($reserved_status === 'partially-booked') {
                                            $day_class = 'bg-warning partially-booked'; // Réservé mais avec des créneaux
                                        } elseif (!$is_past) {
                                            $day_class = 'bg-success text-white available'; // Entièrement disponible
                                        }

                                        // Affiche la cellule du jour.
                                        echo "<td class='$today_class $day_class $disabled_class'>";

                                        if (!$is_past) {
                                            // Si le jour n'est pas passé, il est cliquable et ouvre la modale.
                                            // Les attributs `data-*` sont utilisés par JavaScript pour récupérer les informations.
                                            echo "<button class='btn btn-link date-picker-btn' 
                                                          data-date='$full_date' 
                                                          data-status='$reserved_status'
                                                          data-bs-toggle='modal' data-bs-target='#slotsModal'
                                                          " . ($reserved_status === 'fully-booked' ? 'disabled' : '') . "
                                                          >$day</button>";
                                        } else {
                                            // Jours passés non cliquables
                                            echo "<time datetime='$full_date'>$day</time>";
                                        }

                                        echo "</td>";

                                        // Passe à la ligne suivante dans le tableau après chaque dimanche.
                                        if ($day_counter % 7 == 0 && $day < $num_days) {
                                            echo "</tr><tr>";
                                        }
                                        $day_counter++;
                                    endfor;

                                    // 3. Crée des cellules vides pour compléter la dernière semaine du mois.
                                    while ($day_counter % 7 !== 1) {
                                        echo "<td></td>";
                                        $day_counter++;
                                    }
                                    ?>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Modale Bootstrap pour la réservation, cachée par défaut -->
                <div class="modal fade" id="slotsModal" tabindex="-1" aria-labelledby="slotsModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="slotsModalLabel">Créneaux disponibles pour le <span id="selectedDateText"></span></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Conteneur où JavaScript affichera les créneaux horaires disponibles -->
                                <div id="slotsContainer" class="text-center mb-4">
                                    <p class="text-muted">Chargement des disponibilités...</p>
                                </div>

                                <hr>

                                <!-- Formulaire de réservation, géré par JavaScript (fetch) -->
                                <form id="reservationForm" action="traitement_rdv.php" method="POST">
                                    <input type="hidden" name="date_selectionnee" id="dateInput" required>
                                    <input type="hidden" name="creneau_selectionne" id="creneauInput" required>

                                    <div class="mb-3">
                                        <label for="rdvNom" class="form-label">Nom complet</label>
                                        <input type="text" class="form-control" id="rdvNom" name="nom" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="rdvEmail" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="rdvEmail" name="email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="rdvService" class="form-label">Service concerné</label>
                                        <select class="form-select" id="rdvService" name="service_concerne" required>
                                            <!-- Boucle pour peupler la liste des services -->
                                            <option value="">-- Sélectionnez un service --</option>
                                            <?php foreach ($services_list as $service): ?>
                                                <option value="<?php echo htmlspecialchars($service['nom']); ?>">
                                                    <?php echo htmlspecialchars($service['nom']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                            <option value="Autre">Autre</option>
                                        </select>
                                    </div>

                                    <!-- Zone pour afficher les messages de succès ou d'erreur -->
                                    <div id="reservationMessage" class="alert alert-info mt-3" style="display:none;"></div>

                                    <button type="submit" class="btn btn-gold w-100 mt-3" id="submitReservationBtn" disabled>Confirmer le Rendez-vous</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </main>

<?php
include 'includes/footer.inc.php'; // Inclut le pied de page.
?>
