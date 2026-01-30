/**
 * ==========================================================================
 * FICHIER JAVASCRIPT GLOBAL - Agence Oléris
 * Organisation :
 * 1. Initialisation & Animations (AOS)
 * 2. Navigation (Smooth Scroll & Navbar Style)
 * 3. Formulaires (Contact & AJAX)
 * 4. Chatbot Professionnel
 * 5. Statistiques (Compteurs animés)
 * 6. Easter Eggs (Konami Code)
 * ==========================================================================
 */

document.addEventListener("DOMContentLoaded", function () {

    /* ---------------------------------------------------------
       1. INITIALISATION & ANIMATIONS
       --------------------------------------------------------- */
    AOS.init({
        duration: 1000,
        once: true,
    });

    /* ---------------------------------------------------------
       2. NAVIGATION
       --------------------------------------------------------- */
    
    // Smooth Scroll pour les ancres
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
            let href = this.getAttribute("href");
            if (href === '#') return;

            try {
                let target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: "smooth",
                        block: "start",
                    });
                }
            } catch (err) { /* Sécurité pour sélecteurs invalides */ }
        });
    });

    // Style de la Navbar au défilement
    $(window).on("scroll", function () {
        if ($(window).scrollTop() > 50) {
            $(".navbar").addClass("scrolled");
        } else {
            $(".navbar").removeClass("scrolled");
        }
    });

    /* ---------------------------------------------------------
       3. FORMULAIRES (CONTACT)
       --------------------------------------------------------- */
    
    $("#contactForm").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            url: "traitement_contact.php", 
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    alert("Merci pour votre demande ! Je vous recontacterai très prochainement.");
                    $("#contactForm")[0].reset();
                    window.location.href = "contact.php";
                } else {
                    alert("Erreur: " + response.message);
                }
            },
            error: function () {
                alert("Une erreur est survenue. Veuillez réessayer.");
            },
        });
    });

    /* ---------------------------------------------------------
       4. CHATBOT PROFESSIONNEL
       --------------------------------------------------------- */
    
    let chatWindow = document.getElementById('chatbot-window');
    
    if (chatWindow) {
        let toggleBtn = document.getElementById('chatbot-toggle-btn');
        let closeBtn = document.getElementById('chatbot-close-btn');
        let input = document.getElementById('chatbot-input');
        let sendBtn = document.getElementById('chatbot-send-btn');
        let messagesContainer = document.getElementById('chatbot-messages');

        // Ouvrir/Fermer le chat
        toggleBtn.addEventListener('click', () => {
            chatWindow.classList.toggle('open'); 
            if (chatWindow.classList.contains('open')) input.focus();
        });

        closeBtn.addEventListener('click', () => {
            chatWindow.classList.remove('open');
        });

        // Ajouter une réponse du Bot
        function addBotResponse(text, url, label) {
            let messageDiv = document.createElement('div');
            messageDiv.classList.add('message', 'bot-message');
            messageDiv.textContent = text;
            messagesContainer.appendChild(messageDiv);

            if (url) {
                let btnWrapper = document.createElement('div');
                btnWrapper.style.cssText = "margin-bottom: 20px; margin-top: 10px; padding-left: 10px;";

                let link = document.createElement('a');
                link.href = url;
                link.classList.add('btn-chat-link');
                link.innerHTML = (label || "En savoir plus") + " &nbsp;→"; 
                
                btnWrapper.appendChild(link);
                messagesContainer.appendChild(btnWrapper);
            }
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        // Ajouter un message Utilisateur
        function addUserMessage(text) {
            let messageDiv = document.createElement('div');
            messageDiv.classList.add('message', 'user-message');
            messageDiv.textContent = text;
            messagesContainer.appendChild(messageDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        // Envoyer la question au PHP (AJAX)
        function sendMessage() {
            let userQuestion = input.value.trim();
            if (userQuestion === '') return;

            addUserMessage(userQuestion);
            input.value = '';

            fetch('script/chatbot_reponse.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `question=${encodeURIComponent(userQuestion)}`
            })
            .then(response => response.json())
            .then(data => { 
                addBotResponse(data.reponse, data.url, data.label);
            })
            .catch(error => {
                console.error('Erreur Chatbot:', error);
                addBotResponse("Une petite erreur est survenue, réessayez.", null, null);
            });
        }

        sendBtn.addEventListener('click', sendMessage);
        input.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') sendMessage();
        });
    }

    /* ---------------------------------------------------------
       5. ANIMATION COMPTEURS STATS
       --------------------------------------------------------- */
    
    let statsSection = document.querySelector('.stats-section');
    if (statsSection) {
        let counters = document.querySelectorAll('.counter');
        let speed = 2000;

        let animateCounters = () => {
            counters.forEach(counter => {
                let target = +counter.getAttribute('data-target');
                let count = +counter.innerText;
                let increment = target / speed;

                if (count < target) {
                    counter.innerText = Math.ceil(count + increment);
                    setTimeout(animateCounters, 30);
                } else {
                    counter.innerText = (target === 100) ? target + '%' : target + '+';
                }
            });
        };

        let observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        observer.observe(statsSection);
    }

    /* ---------------------------------------------------------
       6. EASTER EGGS (KONAMI CODE)
       --------------------------------------------------------- */
    
    let konamiCode = [];
    let konamiSequence = [38, 38, 40, 40, 37, 39, 37, 39, 66, 65];
    let isRainbowActive = false;

    $(document).on("keydown", function (e) {
        if (isRainbowActive) return;
        
        konamiCode.push(e.keyCode);
        if (konamiCode.length > 10) konamiCode.shift();

        if (konamiCode.length === 10 && konamiCode.join(",") === konamiSequence.join(",")) {
            isRainbowActive = true;
            $("body").addClass("rainbow-active");
            
            setTimeout(() => {
                $("body").removeClass("rainbow-active");
                isRainbowActive = false;
                konamiCode = [];
            }, 5000);
        }
    });
});

    /* ---------------------------------------------------------
       7. Cookies & RGPD
       --------------------------------------------------------- */

       document.addEventListener("DOMContentLoaded", function() {
    let cookieBanner = document.getElementById('cookie-banner');
    let acceptBtn = document.getElementById('accept-cookies');

    // Vérifie si le cookie "cookies_accepted" existe déjà
    if (!localStorage.getItem('cookies_accepted')) {
        setTimeout(() => {
            cookieBanner.classList.add('show');
        }, 2000); // Apparaît après 2 secondes
    }

    acceptBtn.addEventListener('click', function() {
        localStorage.setItem('cookies_accepted', 'true'); // Stocke le choix
        cookieBanner.classList.remove('show'); // Cache la bannière
    });
});

    /* ---------------------------------------------------------
       9. PERFORMANCE MONITORING
       --------------------------------------------------------- */

window.addEventListener('load', function() {
    // Performance monitoring
    if ('performance' in window && 'getEntriesByType' in performance) {
        let navigation = performance.getEntriesByType('navigation')[0];
        let loadTime = navigation.loadEventEnd - navigation.fetchStart;
        
        // Log performance for monitoring (you can send to analytics)
        console.log('Page load time:', loadTime + 'ms');
        
        // Only log if load time is slow (> 3 seconds)
        if (loadTime > 3000) {
            console.warn('Slow page load detected:', loadTime + 'ms');
        }
    }
});
