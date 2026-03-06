# Changelog

Tous les changements notables de ce projet seront documentés dans ce fichier.

## [1.0.0] - 2025-01-29

### Ajouté

#### Core
- Structure complète du thème WordPress
- Support de `title-tag`, `post-thumbnails`, `custom-logo`, `html5`
- Support natif d'Elementor
- Système de menus (principal et footer)
- 3 zones de widgets (sidebar + 3 colonnes footer)

#### Custom Post Types
- **Services** : Gestion des services avec icônes, prix et caractéristiques
- **Réalisations** : Portfolio avec URL et tags
- **Témoignages** : Avis clients avec notation et informations auteur
- **Devis** : Système complet de gestion des devis

#### Générateur de Devis
- Formulaire multi-étapes (4 étapes)
- Sélection de services avec quantités
- Calcul automatique du total HT
- Sauvegarde en base de données
- Envoi automatique par email (client + admin)
- Génération de numéro de devis unique
- Interface d'administration pour gérer les devis
- Changement de statut (En attente / Accepté / Refusé)

#### Templates
- `front-page.php` : Page d'accueil complète avec toutes les sections
- `page-devis.php` : Template du générateur de devis
- `page.php` : Template de page standard
- `single.php` : Template d'article
- `index.php` : Template principal
- `header.php` et `footer.php` : En-tête et pied de page
- `sidebar.php` : Barre latérale

#### Shortcodes
- `[webmatic_contact_form]` : Formulaire de contact avec Ajax
- `[webmatic_default_services]` : Services par défaut

#### Styles CSS
- `main.css` : Styles principaux du thème
  - Design moderne et responsive
  - Variables CSS pour personnalisation facile
  - Animations et transitions
  - Grilles flexibles
  - Support mobile, tablette, desktop
- `devis.css` : Styles spécifiques au générateur de devis
  - Interface multi-étapes
  - Indicateurs de progression
  - Formulaires stylisés

#### JavaScript
- `main.js` : Fonctionnalités principales
  - Menu mobile responsive
  - Smooth scroll
  - Animations au scroll
  - Header sticky
- `devis-generator.js` : Générateur de devis
  - Navigation multi-étapes
  - Sélection de services dynamique
  - Gestion des quantités
  - Calcul en temps réel
  - Validation des formulaires
  - Soumission Ajax

#### Customizer (Personnalisation)
- **Section Hero**
  - Titre et sous-titre
  - Image hero
- **Informations de Contact**
  - Téléphone
  - Email
  - Adresse
  - Horaires d'ouverture
- **Réseaux Sociaux**
  - Facebook, Twitter, LinkedIn, Instagram
  - Affichage on/off
- **Options Page d'Accueil**
  - Section devis on/off
  - Sélection de la page devis
- **Pied de page**
  - Texte de copyright personnalisable

#### Sections de la Page d'Accueil
1. **Hero** : Section d'en-tête avec titre, sous-titre, CTA
2. **Services** : Grille de services avec icônes et caractéristiques
3. **Promo Devis** : Section promotionnelle pour le générateur
4. **Réalisations** : Portfolio avec images et tags
5. **Témoignages** : Avis clients avec notation
6. **Contact** : Informations de contact + formulaire

#### Fonctionnalités Ajax
- Chargement dynamique des services
- Soumission de devis sans rechargement
- Formulaire de contact Ajax
- Réponses en temps réel

#### Compatibilité Elementor
- Support du thème activé
- Structure prête pour widgets personnalisés
- Fichier de configuration des widgets

#### Documentation
- **README.md** : Documentation complète (français)
  - Description des fonctionnalités
  - Guide d'utilisation
  - Shortcodes
  - Personnalisation
  - Dépannage
- **INSTALLATION.md** : Guide d'installation rapide
  - Installation en 5 minutes
  - Configuration pas à pas
  - Checklist complète
- **CHANGELOG.md** : Historique des versions
- **LISEZ-MOI.txt** : Fichier de présentation

#### Optimisations
- Code sémantique HTML5
- Accessibilité (ARIA labels, skip links)
- Performance (enqueue conditionnel des scripts)
- SEO-friendly (balises correctes, structure logique)
- Sécurité (nonces, sanitization, validation)

#### Fonctionnalités Admin
- Meta boxes personnalisées pour tous les CPT
- Colonnes personnalisées dans les listes
- Interface dédiée pour la gestion des devis
- Tableaux de détails pour chaque devis
- Gestion du statut des devis

### Sécurité
- Vérification des nonces sur toutes les soumissions
- Sanitization de toutes les entrées utilisateur
- Vérification des permissions (capabilities)
- Protection contre les injections SQL
- Protection CSRF

### Performance
- Chargement conditionnel des assets
- Minification potentielle des CSS/JS
- Images responsives
- Lazy loading compatible

### Accessibilité
- Navigation au clavier
- Labels ARIA
- Skip links
- Contraste des couleurs
- Tailles de police lisibles

### Compatible
- WordPress 5.8+
- PHP 7.4+
- Tous navigateurs modernes
- Mobile, tablette, desktop

## [Prévu pour v1.1.0]

### À venir
- Widgets Elementor complètement implémentés
- Export PDF des devis
- Statistiques des devis dans le dashboard
- Mode sombre
- Plus d'options de personnalisation des couleurs
- Support du Gutenberg avec blocs personnalisés
- Intégration calendrier pour prise de rendez-vous

---

**Note** : Ce changelog suit les principes de [Keep a Changelog](https://keepachangelog.com/fr/1.0.0/).