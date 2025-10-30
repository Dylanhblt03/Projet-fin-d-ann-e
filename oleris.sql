-- ============================================
-- DONNÉES DE TEST COHÉRENTES - OLERIS
-- À copier-coller directement dans PhpMyAdmin
-- ============================================

-- ============================================
-- 1. SERVICES (de base, déjà en place normalement)
-- ============================================
INSERT INTO `services` (`nom`, `description`, `icone`, `prix_min`, `prix_max`, `duree_estimee`, `actif`, `ordre_affichage`) VALUES
('Sites Web Sur-Mesure', 'Conception et développement de sites web uniques, performants et adaptés à votre identité. De la landing page au site e-commerce complexe.', 'fa-code', 1500.00, 10000.00, '4-12 semaines', 1, 1),
('Design & Identité Visuelle', 'Création de logos professionnels, chartes graphiques complètes et identité visuelle cohérente pour marquer les esprits.', 'fa-palette', 500.00, 2500.00, '1-3 semaines', 1, 2),
('Photographie Professionnelle', 'Shootings photo de qualité pour sublimer vos produits, locaux et équipes. Traitement et retouche professionnelle inclus.', 'fa-camera', 300.00, 1500.00, '1-2 semaines', 1, 3),
('E-commerce', 'Création de boutiques en ligne complètes avec systèmes de paiement sécurisés et gestion des stocks.', 'fa-shopping-cart', 3000.00, 12000.00, '6-16 semaines', 1, 4),
('Référencement SEO', 'Optimisation de votre visibilité en ligne pour atteindre vos clients potentiels sur les moteurs de recherche.', 'fa-search', 500.00, 3000.00, '3-6 mois', 1, 5),
('Maintenance & Support', 'Support technique et maintenance continue pour garantir la performance et la sécurité de votre site.', 'fa-cog', 50.00, 500.00, 'Mensuel', 1, 6);

-- ============================================
-- 2. PORTFOLIO (projets réalisés)
-- ============================================
INSERT INTO `portfolio` (`titre`, `description`, `categorie`, `image_url`, `url_projet`, `client`, `date_realisation`, `technologies`, `visible`, `ordre_affichage`) VALUES
('Alpha Tech Solutions - Refonte Site Web', 'Refonte complète du site institutionnel d\'Alpha Tech Solutions. Design moderne, responsive et optimisé SEO. Intégration CMS pour gestion autonome.', 'site_web', 'https://images.unsplash.com/photo-1467232004584-a241de8bcf5d?w=800', 'https://alpha-tech.example.com', 'Alpha Tech Solutions', '2025-09-15', 'HTML5, CSS3, JavaScript, PHP, MySQL, WordPress', 1, 1),
('Eco Vert Jardinage - E-commerce', 'Plateforme e-commerce complète pour vente de produits de jardinage. Panier, paiement Stripe, gestion des stocks, fiche produit dynamique.', 'site_web', 'https://images.unsplash.com/photo-1522542550221-31fd19575a2d?w=800', 'https://eco-vert.example.com', 'Eco Vert Jardinage', '2025-08-20', 'WooCommerce, WordPress, PHP, MySQL, Stripe', 1, 2),
('Le Délice Boulangerie - Identité Visuelle', 'Création complète de l\'identité visuelle : logo, charte graphique, cartes de visite, entête de courrier, packaging.', 'design', 'https://images.unsplash.com/photo-1558655146-9f40138edfeb?w=800', NULL, 'Le Délice Boulangerie', '2025-07-10', 'Photoshop, Illustrator, InDesign', 1, 3),
('Shooting Photo - Cabinet Garcia & Associés', 'Séance photo professionnel des locaux et portraits des avocats. 150 photos retouchées, galerie en ligne intégrée.', 'photo', 'https://images.unsplash.com/photo-1542744094-3a31f272c490?w=800', NULL, 'Cabinet Garcia & Associés', '2025-06-25', 'Photographie professionnelle, Retouche Lightroom, Galerie web HTML/CSS', 1, 4),
('Startup X - Landing Page', 'Landing page haute conversion pour présentation et prise de leads. Design minimaliste, animations fluides, formulaire intégré.', 'site_web', 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=800', 'https://startup-x.example.com', 'Startup X', '2025-06-05', 'HTML5, CSS3, JavaScript, Bootstrap, Formspree', 1, 5);

-- ============================================
-- 3. PROJETS CLIENTS
-- ============================================
INSERT INTO `projets` (`client_id`, `titre`, `description`, `type_projet`, `budget_estime`, `statut`, `date_debut`, `date_fin_prevue`, `date_fin_reelle`, `pourcentage_avancement`, `notes`) VALUES
(1, 'Refonte site Alpha Tech', 'Refonte complète du site institutionnel avec nouveau design', 'site_web', 4500.00, 'termine', '2025-08-01', '2025-09-15', '2025-09-15', 100, 'Projet terminé avec succès. Client satisfait.'),
(2, 'Boutique E-commerce Eco Vert', 'Création plateforme e-commerce pour vente produits jardinage', 'site_web', 8000.00, 'termine', '2025-07-01', '2025-08-20', '2025-08-20', 100, 'Mise en ligne et formation client complétée.'),
(3, 'Logo + Charte Délice Boulangerie', 'Création logo et identité visuelle complète', 'design', 1200.00, 'termine', '2025-06-15', '2025-07-10', '2025-07-10', 100, 'Client très satisfait des propositions.'),
(4, 'Landing Page Startup X', 'Landing page haute conversion pour lancement produit', 'site_web', 2000.00, 'termine', '2025-05-15', '2025-06-05', '2025-06-05', 100, 'En attente de photos produit pour finalisation.'),
(5, 'Photos Cabinet Juridique', 'Shooting photo locaux et portraits professionnels', 'photo', 1500.00, 'termine', '2025-05-20', '2025-06-25', '2025-06-25', 100, 'Retouches complétées, galerie en ligne livrée.');

-- ============================================
-- 4. RENDEZ-VOUS
-- ============================================
INSERT INTO `rendez_vous` (`client_id`, `contact_id`, `titre`, `description`, `date_rdv`, `heure_debut`, `heure_fin`, `type_rdv`, `lieu`, `statut`, `rappel_envoye`, `notes_admin`) VALUES
(1, 1, 'Consultation - Présentation Alpha Tech', 'Appel initial pour présentation et écoute des besoins', '2025-10-20', '10:00:00', '11:00:00', 'telephone', NULL, 'confirme', 1, 'Appel confirmé avec Sophie. Dossier consulté.'),
(2, 2, 'Réunion Projet E-commerce Eco Vert', 'Visioconférence pour suivi du projet e-commerce', '2025-10-21', '14:00:00', '15:30:00', 'visio', NULL, 'confirme', 1, 'Zoom configuré. Lien partagé avec Marc.'),
(3, 3, 'RDV Conseil Logo Délice', 'Présentation des premières propositions de logo', '2025-10-22', '15:00:00', '16:00:00', 'presentiel', '12 Rue des Innovations, Paris 75002', 'confirme', 0, 'Présentation des 3 concepts préparée.'),
(5, 5, 'Devis Photographie Cabinet', 'Consultation pour définir le scope du shooting photo', '2025-10-23', '09:30:00', '10:30:00', 'telephone', NULL, 'en_attente', 0, 'À confirmer par Laura Garcia.');

-- ============================================
-- 5. DEVIS
-- ============================================
INSERT INTO `devis` (`numero_devis`, `client_id`, `projet_id`, `titre`, `description`, `montant_ht`, `tva`, `montant_ttc`, `statut`, `date_emission`, `date_validite`, `date_acceptation`, `conditions`, `notes`, `fichier_pdf`) VALUES
('DEV-2025-001', 1, 1, 'Refonte Site Alpha Tech Solutions', 'Refonte complète du site institutionnel avec nouveau design responsif et optimisation SEO', 3750.00, 20.00, 4500.00, 'accepte', '2025-08-01', '2025-08-31', '2025-08-10', 'Paiement: 50% acompte, 50% à livraison', 'Projet accepté le 10 août. Débuté 01 août.', 'devis_2025_001.pdf'),
('DEV-2025-002', 2, 2, 'Boutique E-commerce Eco Vert', 'Plateforme e-commerce WooCommerce avec 100 produits, paiement Stripe, gestion stocks', 6666.67, 20.00, 8000.00, 'accepte', '2025-07-01', '2025-07-31', '2025-07-05', 'Paiement: 30% acompte, 40% mi-projet, 30% livraison', 'Accepté rapidement. Excellent client.', 'devis_2025_002.pdf'),
('DEV-2025-003', 3, 3, 'Identité Visuelle Délice Boulangerie', 'Logo + charte graphique 20 pages + supports imprimés (cartes, entête courrier)', 1000.00, 20.00, 1200.00, 'accepte', '2025-06-15', '2025-07-15', '2025-06-20', 'Paiement: 50% acompte, 50% livraison', 'Client très enthousiaste. 3 concepts proposés.', 'devis_2025_003.pdf'),
('DEV-2025-004', 4, 4, 'Landing Page Startup X', 'Landing page haute conversion, formulaire lead intégré, animations, SEO basique', 1666.67, 20.00, 2000.00, 'accepte', '2025-05-15', '2025-06-15', '2025-05-18', 'Paiement: 50% acompte, 50% livraison', 'Startup rapide en prise de décision.', 'devis_2025_004.pdf'),
('DEV-2025-005', 5, 5, 'Shooting Photo Cabinet Juridique', 'Shooting 4 heures: photos locaux + 5 portraits individuels. Retouche complète. Galerie web.', 1250.00, 20.00, 1500.00, 'accepte', '2025-05-20', '2025-06-20', '2025-05-22', 'Paiement: 100% à la confirmation', 'Cabinet sérieux. RDV de consultation prévu.', 'devis_2025_005.pdf');

-- ============================================
-- 6. DEVIS LIGNES (détails des devis)
-- ============================================
INSERT INTO `devis_lignes` (`devis_id`, `designation`, `quantite`, `prix_unitaire`, `total`, `ordre_affichage`) VALUES
(1, 'Audit et stratégie Web', 1, 500.00, 500.00, 1),
(1, 'Design et maquettes (5 pages)', 1, 1500.00, 1500.00, 2),
(1, 'Développement Front-end', 1, 1000.00, 1000.00, 3),
(1, 'Intégration CMS WordPress', 1, 750.00, 750.00, 4),

(2, 'Architecture WooCommerce', 1, 1500.00, 1500.00, 1),
(2, 'Design boutique (20 pages)', 1, 2000.00, 2000.00, 2),
(2, 'Intégration 100 produits', 1, 1500.00, 1500.00, 3),
(2, 'Configuration Stripe + test paiement', 1, 1000.00, 1000.00, 4),
(2, 'Formation client (2h)', 1, 666.67, 666.67, 5),

(3, 'Création 3 concepts logo', 1, 600.00, 600.00, 1),
(3, 'Charte graphique 20 pages', 1, 300.00, 300.00, 2),
(3, 'Supports imprimés (design)', 1, 100.00, 100.00, 3),

(4, 'Design Landing Page', 1, 800.00, 800.00, 1),
(4, 'Développement + Animations', 1, 700.00, 700.00, 2),
(4, 'Intégration formulaire lead', 1, 166.67, 166.67, 3),

(5, 'Shooting photo 4h', 1, 800.00, 800.00, 1),
(5, 'Retouche 50 photos', 1, 300.00, 300.00, 2),
(5, 'Galerie web + optimisation images', 1, 150.00, 150.00, 3);

-- ============================================
-- 7. FACTURES (basées sur les devis acceptés)
-- ============================================
INSERT INTO `factures` (`numero_facture`, `client_id`, `projet_id`, `devis_id`, `titre`, `description`, `montant_ht`, `tva`, `montant_ttc`, `montant_paye`, `statut`, `date_emission`, `date_echeance`, `date_paiement`, `moyen_paiement`, `reference_paiement`, `conditions`, `notes`, `fichier_pdf`) VALUES
('FAC-2025-001', 1, 1, 1, 'Refonte Site Alpha Tech Solutions', 'Refonte complète site institutionnel - Projet terminé', 3750.00, 20.00, 4500.00, 4500.00, 'payee', '2025-09-15', '2025-10-15', '2025-09-20', 'virement', 'VIR20250920ALPHATECH', 'Conditions de paiement acceptées', 'Paiement reçu le 20/09. Projet livré.', 'facture_2025_001.pdf'),
('FAC-2025-002', 2, 2, 2, 'Boutique E-commerce Eco Vert', 'Plateforme e-commerce WooCommerce - Projet terminé', 6666.67, 20.00, 8000.00, 8000.00, 'payee', '2025-08-20', '2025-09-20', '2025-09-18', 'virement', 'VIR20250918ECOVERT', 'Conditions de paiement acceptées', 'Paiement complet reçu. Système en production.', 'facture_2025_002.pdf'),
('FAC-2025-003', 3, 3, 3, 'Identité Visuelle Délice Boulangerie', 'Logo et charte graphique - Projet terminé', 1000.00, 20.00, 1200.00, 1200.00, 'payee', '2025-07-10', '2025-08-10', '2025-07-25', 'cheque', 'CHQ789456', 'Conditions de paiement acceptées', 'Chèque reçu. Tous fichiers livrés.', 'facture_2025_003.pdf'),
('FAC-2025-004', 4, 4, 4, 'Landing Page Startup X', 'Landing page haute conversion - Projet terminé', 1666.67, 20.00, 2000.00, 2000.00, 'payee', '2025-06-05', '2025-07-05', '2025-06-15', 'carte', 'CARD***6789', 'Conditions de paiement acceptées', 'Paiement par carte approuvé. Site en ligne.', 'facture_2025_004.pdf'),
('FAC-2025-005', 5, 5, 5, 'Shooting Photo Cabinet Juridique', 'Shooting professionnel et retouche - Projet terminé', 1250.00, 20.00, 1500.00, 1500.00, 'payee', '2025-06-25', '2025-07-25', '2025-06-28', 'virement', 'VIR20250628CABINET', 'Conditions de paiement acceptées', 'Virement reçu. Galerie web livrée.', 'facture_2025_005.pdf');

-- ============================================
-- 8. FACTURES LIGNES (détails des factures)
-- ============================================
INSERT INTO `factures_lignes` (`facture_id`, `designation`, `quantite`, `prix_unitaire`, `total`, `ordre_affichage`) VALUES
(1, 'Audit et stratégie Web', 1, 500.00, 500.00, 1),
(1, 'Design et maquettes (5 pages)', 1, 1500.00, 1500.00, 2),
(1, 'Développement Front-end', 1, 1000.00, 1000.00, 3),
(1, 'Intégration CMS WordPress', 1, 750.00, 750.00, 4),

(2, 'Architecture WooCommerce', 1, 1500.00, 1500.00, 1),
(2, 'Design boutique (20 pages)', 1, 2000.00, 2000.00, 2),
(2, 'Intégration 100 produits', 1, 1500.00, 1500.00, 3),
(2, 'Configuration Stripe + test paiement', 1, 1000.00, 1000.00, 4),
(2, 'Formation client (2h)', 1, 666.67, 666.67, 5),

(3, 'Création 3 concepts logo', 1, 600.00, 600.00, 1),
(3, 'Charte graphique 20 pages', 1, 300.00, 300.00, 2),
(3, 'Supports imprimés (design)', 1, 100.00, 100.00, 3),

(4, 'Design Landing Page', 1, 800.00, 800.00, 1),
(4, 'Développement + Animations', 1, 700.00, 700.00, 2),
(4, 'Intégration formulaire lead', 1, 166.67, 166.67, 3),

(5, 'Shooting photo 4h', 1, 800.00, 800.00, 1),
(5, 'Retouche 50 photos', 1, 300.00, 300.00, 2),
(5, 'Galerie web + optimisation images', 1, 150.00, 150.00, 3);

-- ============================================
-- 9. PAIEMENTS (historique)
-- ============================================
INSERT INTO `paiements` (`facture_id`, `client_id`, `montant`, `moyen_paiement`, `reference`, `statut`, `date_paiement`, `notes`) VALUES
(1, 1, 4500.00, 'virement', 'VIR20250920ALPHATECH', 'valide', '2025-09-20', 'Paiement intégral reçu sans problème.'),
(2, 2, 8000.00, 'virement', 'VIR20250918ECOVERT', 'valide', '2025-09-18', 'Client de très bonne volonté, paiement rapide.'),
(3, 3, 1200.00, 'cheque', 'CHQ789456', 'valide', '2025-07-25', 'Chèque reçu et encaissé.'),
(4, 4, 2000.00, 'carte', 'CARD***6789', 'valide', '2025-06-15', 'Paiement par carte bancaire.'),
(5, 5, 1500.00, 'virement', 'VIR20250628CABINET', 'valide', '2025-06-28', 'Virement rapide, client très professionnel.');