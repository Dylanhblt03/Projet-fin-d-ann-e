<?php

// ===============================================
// DÉMARRAGE DE SESSION
session_start();
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
        SELECT date_rdv as reserved_day, COUNT(id) as total_rdv
        FROM rendez_vous
        WHERE date_rdv >= :start_month AND date_rdv < :end_month AND statut NOT IN ('annule', 'termine')
        GROUP BY reserved_day
    ");

    $start_month = $current_date->format('Y-m-01');
    $end_month = (clone $current_date)->modify('+1 month')->format('Y-m-01');

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
                <!-- Nouvelle structure en deux colonnes -->
                <div class="row justify-content-center g-5">
                    <!-- Colonne de gauche : Calendrier -->
                    <div class="col-lg-7 col-md-12">
                        <div class="calendar-box bg-white p-4 p-md-5 shadow-lg rounded" data-aos="fade-up">
                            <div class="calendar-header mb-4 text-center">
                                <a href="?month=<?php echo $prev_month->format('m'); ?>&year=<?php echo $prev_month->format('Y'); ?>"
                                   class="btn btn-outline-dark float-start"><i class="fas fa-chevron-left"></i></a>

                                <h2 class="d-inline-block text-capitalize">
                                    <?php echo $month_name_fr; ?> <?php echo $year; ?>
                                </h2>

                                <a href="?month=<?php echo $next_month->format('m'); ?>&year=<?php echo $next_month->format('Y'); ?>"
                                   class="btn btn-outline-dark float-end"><i class="fas fa-chevron-right"></i></a>
                            </div>

                            <div class="table-responsive">
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
                                                // Si le jour n'est pas passé, il est cliquable.
                                                echo "<button class='btn btn-link date-picker-btn' data-date='$full_date' data-status='$reserved_status'
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
                    <!-- Colonne de droite : Formulaire de RDV -->
                    <div class="col-lg-5 col-md-12">
                        <div class="appointment-form-container bg-white p-4 p-md-5 shadow-lg rounded" data-aos="fade-left">
                            <h3 class="mb-4">Prendre rendez-vous</h3>
                            <!-- Le formulaire est maintenant toujours visible -->
                            <form id="reservationForm" action="traitement_rdv.php" method="POST" novalidate>
                                <div class="mb-3">
                                    <label class="form-label">Date sélectionnée</label>
                                    <input type="text" id="selectedDateText" class="form-control" value="Veuillez choisir une date" readonly>
                                    <input type="hidden" name="date_selectionnee" id="dateInput">
                                </div>
                                <div class="mb-3"><label class="form-label">Créneaux disponibles</label><div id="slotsContainer" class="text-center bg-light p-3 rounded"><p class="text-muted m-0">En attente d'une date...</p></div><input type="hidden" name="creneau_selectionne" id="creneauInput" required></div>
                                    <?php if (!isset($_SESSION['user_id'])): ?>
                                        <div class="mb-3"><label for="rdvNom" class="form-label">Nom complet</label><input type="text" class="form-control" id="rdvNom" name="nom" placeholder="Votre nom et prénom" required></div>
                                        <div class="mb-3"><label for="rdvEmail" class="form-label">Email</label><input type="email" class="form-control" id="rdvEmail" name="email" placeholder="votre@email.com" required></div>
                                    <?php else: ?>
                                        <p class="text-center">Vous réservez en tant que <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong>.</p>
                                    <?php endif; ?>
                                    <div class="mb-3"><label for="rdvDescription" class="form-label">Pourquoi prenez-vous rendez-vous ?</label><textarea class="form-control" id="rdvDescription" name="description_rdv" rows="3" placeholder="Décrivez brièvement la raison de votre rendez-vous..." required></textarea></div>
                                    <div id="reservationMessage" class="alert mt-3" style="display:none;"></div>
                                    <button type="submit" class="btn btn-gold w-100 mt-3" id="submitReservationBtn" disabled>Confirmer le Rendez-vous</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

<?php
include 'includes/footer.inc.php'; // Inclut le pied de page.
?>
