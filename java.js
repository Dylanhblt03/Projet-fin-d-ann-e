// Attend que le contenu de la page (le DOM) soit entièrement chargé avant d'exécuter le script.
document.addEventListener('DOMContentLoaded', function() {

// Initialisation de la bibliothèque AOS (Animate On Scroll) pour les animations au défilement.
AOS.init({
  duration: 1000, // Durée de l'animation en millisecondes.
  once: true, // L'animation ne se joue qu'une seule fois.
});

// Gestion du défilement fluide (smooth scroll) pour les ancres internes.
// Sélectionne tous les liens `<a>` dont l'attribut `href` commence par '#'.
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
  anchor.addEventListener("click", function (e) {
    const href = this.getAttribute("href");
    // Si le href est juste "#", on ne fait rien pour éviter les erreurs.
    if (href === '#') return;

    try {
      const target = document.querySelector(href);
      if (target) {
        e.preventDefault(); // Empêcher le comportement par défaut SEULEMENT si la cible existe
        target.scrollIntoView({
          behavior: "smooth", // Active le défilement fluide.
          block: "start", // Aligne la cible en haut de la vue.
        });
      }
    } catch (err) { /* Ignorer les erreurs si le sélecteur est invalide (par ex. href="#-invalid") */ }
  });
});

// Soumission du formulaire de contact avec AJAX (en utilisant jQuery).
// Cela permet d'envoyer les données sans recharger la page.
$("#contactForm").on("submit", function (e) {
  e.preventDefault(); // Empêche la soumission classique du formulaire.

  $.ajax({
    url: "traitement_contact.php", // Le script PHP qui traitera les données.
    type: "POST", // La méthode d'envoi.
    data: $(this).serialize(), // Récupère toutes les données du formulaire.
    success: function (response) { // Fonction exécutée en cas de succès.
      alert(
        "Merci pour votre demande ! Je vous recontacterai très prochainement."
      );
      $("#contactForm")[0].reset();
    },
    error: function () {
      alert("Une erreur est survenue. Veuillez réessayer.");
    },
  });
});

// Ajoute un fond à la barre de navigation (navbar) lors du défilement.
// On utilise jQuery pour écouter l'événement 'scroll' sur la fenêtre.
$(window).on("scroll", function () {
  if ($(window).scrollTop() > 50) {
    $(".navbar").addClass("scrolled");
  } else {
    $(".navbar").removeClass("scrolled");
  }
});


// Easter Egg : Konami Code pour un effet arc-en-ciel.
let konamiCode = [];
// La séquence de touches à entrer : ↑ ↑ ↓ ↓ ← → ← → B A
const konamiSequence = [38, 38, 40, 40, 37, 39, 37, 39, 66, 65];
let isRainbowActive = false; // Variable pour savoir si l'effet est déjà actif.

// Écouteur d'événement pour les touches pressées sur tout le document.
$(document).on("keydown", function (e) {
    
    // Si la séquence est déjà active ou en cours de réinitialisation, on ignore les touches.
    if (isRainbowActive) return;
    
    konamiCode.push(e.keyCode); // Ajoute le code de la touche pressée au tableau.
    
    // Garde seulement les 10 dernières touches pour correspondre à la séquence.
    if (konamiCode.length > 10) {
        konamiCode.shift();
    }

    // Vérifie si le code correspond à la séquence
    if (konamiCode.length === 10 && konamiCode.join(",") === konamiSequence.join(",")) {
        
        // La séquence est entrée. On active l'effet.
        isRainbowActive = true;
        
        // 1. Activation de l'effet en ajoutant une classe CSS au body.
        $("body").addClass("rainbow-active");
        console.log("🌈 Rainbow Mode activé (5 secondes) !");
        
        // 2. Désactivation de l'effet après 5 secondes (5000 ms).
        setTimeout(() => {
            $("body").removeClass("rainbow-active");
            
            // Réinitialise la variable et le code pour pouvoir le réactiver plus tard
            isRainbowActive = false;
            konamiCode = [];
            console.log("Rainbow Mode désactivé (minuterie terminée).");
            
        }, 5000); // 5000 millisecondes = 5 secondes
        
    }
});

    // ===============================================
    // ANIMATION COMPTEUR STATS
    // ===============================================
    // Sélectionne la section des statistiques.
    const statsSection = document.querySelector('.stats-section');
    if (statsSection) {
        const counters = document.querySelectorAll('.counter');
        const speed = 2000; // Vitesse de l'animation

        // Fonction récursive pour animer les compteurs.
        const animateCounters = () => {
            counters.forEach(counter => {
                const target = +counter.getAttribute('data-target'); // La valeur cible à atteindre.
                const count = +counter.innerText; // La valeur actuelle affichée.

                const increment = target / speed; // Calcule de combien augmenter à chaque étape.

                if (count < target) {
                    counter.innerText = Math.ceil(count + increment); // Met à jour le texte avec la nouvelle valeur.
                    setTimeout(animateCounters, 30); // Rappelle la fonction pour continuer l'animation.
                } else {
                    // Une fois la cible atteinte, formate le texte final.
                    if (counter.getAttribute('data-target') === '100') {
                        counter.innerText = target + '%';
                    } else {
                        counter.innerText = target + '+';
                    }
                }
            });
        };

        // Utilise IntersectionObserver pour déclencher l'animation uniquement quand la section devient visible.
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    observer.unobserve(entry.target); // Arrête d'observer une fois l'animation lancée.
                }
            });
        }, { threshold: 0.5 });

        observer.observe(statsSection);
    }

    // ===============================================
    // JAVASCRIPT / AJAX pour afficher les créneaux
    // ===============================================

    // Liste des créneaux horaires disponibles par défaut pour une journée.
    const AVAILABLE_SLOTS = [
        '09:00', '10:00', '11:00', // Matin
        '14:00', '15:00', '16:00', // Après-midi
        '17:00', '18:00'           // Fin de journée
    ];

    // Sélection des éléments du DOM pour la modale de réservation.
    const slotsModal = document.getElementById('slotsModal');
    // Si la modale existe, on initialise toute la logique de réservation
    if (slotsModal) {
        const selectedDateText = document.getElementById('selectedDateText');
        const slotsContainer = document.getElementById('slotsContainer');
        const dateInput = document.getElementById('dateInput');
        const creneauInput = document.getElementById('creneauInput');
        const submitBtn = document.getElementById('submitReservationBtn');
        const reservationForm = document.getElementById('reservationForm');
        const reservationMessage = document.getElementById('reservationMessage');

        // Événement déclenché lorsque la modale est sur le point de s'afficher.
        slotsModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget; // Le bouton qui a déclenché la modale.
            const date = button.getAttribute('data-date'); // Récupère la date depuis l'attribut du bouton.
            const status = button.getAttribute('data-status'); // Récupère le statut (disponible, complet...).

            // Mise à jour de l'interface de la modale avec les informations de la date sélectionnée.
            selectedDateText.textContent = formatDateFr(date);
            dateInput.value = date;
            creneauInput.value = ''; // Réinitialiser le créneau
            submitBtn.disabled = true;
            reservationMessage.style.display = 'none';
            reservationMessage.className = 'alert mt-3';

            slotsContainer.innerHTML = '<p class="text-muted">Chargement des disponibilités...</p>'; // Message de chargement.

            // Si le jour est déjà complet, on affiche un message et on arrête.
            if (status === 'fully-booked') {
                slotsContainer.innerHTML = '<p class="text-danger">Ce jour est malheureusement complet. Veuillez choisir une autre date.</p>';
                return;
            }

            // Appel AJAX (avec fetch) pour obtenir les créneaux déjà réservés pour cette date.
            fetch('ajax_get_slots.php?date=' + date) // Le script PHP qui renvoie les créneaux pris.
                .then(response => response.json())
                .then(reservedSlots => {
                    displaySlots(date, reservedSlots);
                })
                .catch(error => {
                    slotsContainer.innerHTML = '<p class="text-danger">Erreur lors du chargement des créneaux.</p>';
                    console.error('Error fetching slots:', error);
                });
        });

        // Fonction pour formater une date (ex: "2024-01-15") en format français lisible (ex: "lundi 15 janvier").
        function formatDateFr(dateString) {
            const date = new Date(dateString);
            const options = { weekday: 'long', day: 'numeric', month: 'long' };
            return date.toLocaleDateString('fr-FR', options);
        }

        // Fonction pour afficher les boutons de créneaux horaires.
        function displaySlots(date, reservedSlots) {
            let html = '<div class="btn-group flex-wrap" role="group" aria-label="Créneaux horaires">';
            let availableCount = 0;

            AVAILABLE_SLOTS.forEach(slot => {
                const fullDateTime = date + ' ' + slot + ':00';
                const isReserved = reservedSlots.includes(slot);
                const btnClass = isReserved ? 'btn-secondary disabled' : 'btn-outline-gold slot-btn'; // Classe différente si réservé.
                const disabledAttr = isReserved ? 'disabled' : ''; // Attribut 'disabled' si réservé.

                if (!isReserved) {
                    availableCount++;
                }

                html += `<button type="button" class="btn ${btnClass} m-1" data-slot="${slot}" ${disabledAttr}>${slot}</button>`;
            });

            html += '</div>';

            // S'il n'y a aucun créneau disponible, on affiche un message.
            if (availableCount === 0) {
                 html = '<p class="text-danger">Désolé, tous les créneaux sont réservés pour ce jour.</p>';
            }

            slotsContainer.innerHTML = html;

            // On ajoute les écouteurs d'événements sur les boutons de créneaux disponibles.
            const slotButtons = slotsContainer.querySelectorAll('.slot-btn');
            if (slotButtons.length > 0) {
                slotButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        // Gère la sélection visuelle du créneau.
                        slotButtons.forEach(btn => btn.classList.remove('btn-gold', 'text-white'));
                        this.classList.add('btn-gold', 'text-white');
                        creneauInput.value = this.getAttribute('data-slot'); // Met à jour le champ caché du formulaire.
                        submitBtn.disabled = false;
                    });
                });
            }
        }

        reservationForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Empêche la soumission classique.

            // Validation simple côté client.
            if (!creneauInput.value) {
                reservationMessage.className = 'alert alert-danger mt-3';
                reservationMessage.textContent = 'Veuillez sélectionner un créneau horaire.';
                reservationMessage.style.display = 'block';
                return;
            }

            // Désactive le bouton pour éviter les double-clics.
            submitBtn.disabled = true; submitBtn.textContent = 'Envoi en cours...';
            // Envoi des données du formulaire via fetch.
            fetch('traitement_rdv.php', {
                method: 'POST',
                body: new FormData(this)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) { // Si la réservation a réussi.
                        reservationMessage.className = 'alert alert-success mt-3';
                        reservationMessage.textContent = 'Votre rendez-vous a été confirmé ! Nous vous contacterons bientôt.';
                        reservationForm.reset();
                        submitBtn.style.display = 'none'; 
                    } else {
                        reservationMessage.className = 'alert alert-danger mt-3';
                        reservationMessage.textContent = data.message || 'Une erreur est survenue lors de la réservation.';
                        submitBtn.disabled = false;
                        submitBtn.textContent = 'Confirmer le Rendez-vous';
                    }
                    reservationMessage.style.display = 'block';
                })
                .catch(error => {
                    reservationMessage.className = 'alert alert-danger mt-3';
                    reservationMessage.textContent = 'Erreur réseau ou serveur.';
                    reservationMessage.style.display = 'block';
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Confirmer le Rendez-vous';
                    console.error('Fetch error:', error);
                });
        });
    }
    // ===============================================
    // CHATBOT
    // ===============================================
    // Sélection des éléments du DOM pour le chatbot.
    const chatWindow = document.getElementById('chatbot-window');
    
    if (chatWindow) {
        const toggleBtn = document.getElementById('chatbot-toggle-btn');
        const closeBtn = document.getElementById('chatbot-close-btn');
        const input = document.getElementById('chatbot-input');
        const sendBtn = document.getElementById('chatbot-send-btn');
        const messagesContainer = document.getElementById('chatbot-messages');

        // Gère l'ouverture/fermeture de la fenêtre du chatbot.
        toggleBtn.addEventListener('click', () => {
            chatWindow.classList.toggle('open'); 
            if (chatWindow.classList.contains('open')) {
                input.focus(); // Met le focus sur le champ de saisie quand on ouvre le chat.
            }
        });

        // Gère la fermeture de la fenêtre.
        closeBtn.addEventListener('click', () => {
            chatWindow.classList.remove('open');
        });

        // Fonction pour ajouter un message (utilisateur ou bot) à la fenêtre de chat.
        function addMessage(text, sender) {
            const messageDiv = document.createElement('div');
            messageDiv.classList.add('message', sender === 'user' ? 'user-message' : 'bot-message');
            messageDiv.textContent = text;
            // Ajouter le message au conteneur, puis scroller
            messagesContainer.appendChild(messageDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        function sendMessage() {
            const userQuestion = input.value.trim();
            if (userQuestion === '') return;

            addMessage(userQuestion, 'user'); // Affiche la question de l'utilisateur.
            input.value = ''; // Vide le champ de saisie.

            // Envoi de la question au serveur via fetch pour obtenir une réponse.
            fetch('chatbot_reponse.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `question=${encodeURIComponent(userQuestion)}`
            })
                .then(response => response.json())
                .then(data => { 
                    // Affiche la réponse du bot, ou un message par défaut.
                    const botResponse = data.reponse || "Désolé, je n'ai pas trouvé de réponse pertinente. Veuillez reformuler votre question.";
                    addMessage(botResponse, 'bot');
                })
                .catch(error => {
                    // Gère les erreurs de communication.
                    addMessage("Une erreur de communication est survenue. Veuillez réessayer plus tard.", 'bot');
                    console.error('Erreur AJAX:', error);
                });
        }

        sendBtn.addEventListener('click', sendMessage);
        input.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });
    } // Fin de if(chatWindow)
});
