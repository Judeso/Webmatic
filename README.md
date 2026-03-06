# Thème WordPress WebMatic

## Description

Thème WordPress professionnel pour WebMatic - Services informatiques et développement web. Compatible avec Elementor et incluant un générateur de devis intégré.

## Caractéristiques

✅ **Design moderne et responsive**
✅ **Compatible Elementor**
✅ **Générateur de devis multi-étapes**
✅ **Custom Post Types** (Services, Réalisations, Témoignages, Devis)
✅ **Gestion des devis en administration**
✅ **Envoi automatique par email**
✅ **Personnalisation via WordPress Customizer**
✅ **SEO optimisé**
✅ **Shortcodes prêt à l'emploi**

## Installation

### Méthode 1 : Via l'administration WordPress

1. Connectez-vous à votre administration WordPress
2. Allez dans **Apparence > Thèmes**
3. Cliquez sur **Ajouter**
4. Cliquez sur **Téléverser un thème**
5. Sélectionnez le fichier ZIP du thème
6. Cliquez sur **Installer maintenant**
7. Activez le thème

### Méthode 2 : Via FTP

1. Décompressez le fichier ZIP du thème
2. Uploadez le dossier `webmatic` dans `/wp-content/themes/`
3. Allez dans **Apparence > Thèmes** dans votre administration
4. Activez le thème **WebMatic**

## Configuration Initiale

### 1. Réglages de Base

- Allez dans **Apparence > Personnaliser**
- Configurez :
  - Logo du site
  - Informations de contact (téléphone, email, adresse)
  - Section Hero (titre, sous-titre, image)
  - Réseaux sociaux
  - Copyright

### 2. Menus

1. Allez dans **Apparence > Menus**
2. Créez un menu "Menu Principal"
3. Assignez-le à l'emplacement "Menu Principal"
4. (Optionnel) Créez un menu pour le pied de page

### 3. Pages Essentielles

#### Page d'Accueil

1. Créez une nouvelle page "Accueil"
2. Allez dans **Réglages > Lecture**
3. Sélectionnez "Une page statique" comme page d'accueil
4. Choisissez la page "Accueil"

#### Page de Devis

1. Créez une nouvelle page "Devis" ou "Demande de devis"
2. Dans l'attribut de page, sélectionnez le modèle **"Générateur de Devis"**
3. Publiez la page
4. Allez dans **Apparence > Personnaliser > Options Page d'Accueil**
5. Sélectionnez cette page comme "Page de devis"

### 4. Ajouter du Contenu

#### Services

1. Allez dans **Services > Ajouter un service**
2. Remplissez :
   - Titre du service
   - Description (contenu)
   - Extrait (résumé court)
   - Image à la une
3. Dans la meta box "Détails du service" :
   - Icône Font Awesome (ex: `fas fa-laptop`)
   - Prix HT
   - Caractéristiques (une par ligne)
4. Publiez

**Note :** Les services avec un prix seront automatiquement disponibles dans le générateur de devis.

#### Réalisations

1. Allez dans **Réalisations > Ajouter une réalisation**
2. Remplissez :
   - Titre du projet
   - Description
   - Image à la une (capture d'écran du site)
3. Dans "Détails de la réalisation" :
   - URL du site
   - Tags (ex: Site Vitrine, Responsive, E-commerce)
4. Publiez

#### Témoignages

1. Allez dans **Témoignages > Ajouter un témoignage**
2. Titre = Nom du client
3. Contenu = Texte du témoignage
4. Image à la une = Photo du client (optionnel)
5. Dans "Détails du témoignage" :
   - Note (1-5 étoiles)
   - Info auteur (ex: "Local Guide · 35 avis")
6. Publiez

## Générateur de Devis

### Fonctionnement

Le générateur de devis fonctionne en 4 étapes :

1. **Informations client** : Coordonnées complètes
2. **Sélection des services** : Choix des prestations avec quantités
3. **Récapitulatif** : Vérification avant envoi
4. **Confirmation** : Succès et instructions

### Configuration

- Les services sont automatiquement chargés depuis le Custom Post Type "Services"
- Si aucun service n'est créé, des services par défaut sont utilisés
- Les devis sont sauvegardés dans l'administration WordPress
- Les emails sont envoyés au client ET à l'administrateur

### Gestion des Devis

1. Allez dans **Devis** dans le menu admin
2. Vous voyez la liste de tous les devis reçus
3. Cliquez sur un devis pour voir les détails complets
4. Changez le statut : En attente / Accepté / Refusé

## Shortcodes Disponibles

### Formulaire de Contact

```
[webmatic_contact_form]
```

Affiche un formulaire de contact complet avec envoi par email.

### Services Par Défaut

```
[webmatic_default_services]
```

Affiche les 4 services par défaut (utilisé automatiquement si aucun service créé).

## Utilisation avec Elementor

### Widgets Personnalisés (en cours de développement)

Le thème prépare le support pour des widgets Elementor personnalisés :

- Widget Services
- Widget Témoignages
- Widget Réalisations
- Widget Formulaire de Contact

### Créer des Pages avec Elementor

1. Créez une nouvelle page
2. Cliquez sur "Modifier avec Elementor"
3. Utilisez les sections du thème comme référence
4. Ajoutez vos propres widgets et mises en page

## Personnalisation CSS

### Ajouter du CSS Personnalisé

1. Allez dans **Apparence > Personnaliser**
2. Cliquez sur **CSS Additionnel**
3. Ajoutez votre code CSS

### Variables CSS Disponibles

```css
:root {
    --color-primary: #2563eb;     /* Couleur principale */
    --color-secondary: #10b981;   /* Couleur secondaire */
    --color-dark: #0f0f10;        /* Texte foncé */
    --color-light: #f9fafb;       /* Arrière-plan clair */
    --color-gray: #6b7280;        /* Texte gris */
}
```

## Support des Icônes

Le thème utilise **Font Awesome 6.4.0**. Vous pouvez utiliser toutes les icônes gratuites.

### Exemples d'Icônes pour Services

- `fas fa-laptop` - Ordinateur portable
- `fas fa-tools` - Outils
- `fas fa-gamepad` - Manette de jeu
- `fas fa-mobile-alt` - Téléphone
- `fas fa-shield-alt` - Sécurité
- `fas fa-graduation-cap` - Formation
- `fas fa-cloud` - Cloud
- `fas fa-code` - Programmation

Recherchez plus d'icônes sur : [https://fontawesome.com/icons](https://fontawesome.com/icons)

## Configuration Email

### Pour que les emails fonctionnent correctement

1. **Vérifiez votre serveur SMTP** : WordPress utilise la fonction `wp_mail()` qui peut être bloquée par certains hébergeurs

2. **Installez un plugin SMTP** (recommandé) :
   - WP Mail SMTP
   - Easy WP SMTP
   - Post SMTP

3. **Configurez l'expéditeur** :
   - Allez dans les réglages du plugin SMTP
   - Utilisez une adresse email valide de votre domaine

## Optimisation et Performance

### Plugins Recommandés

- **Yoast SEO** ou **Rank Math** : Référencement
- **WP Super Cache** ou **W3 Total Cache** : Mise en cache
- **Smush** : Optimisation des images
- **Wordfence** : Sécurité
- **UpdraftPlus** : Sauvegardes

### Checklist d'Optimisation

- [ ] Activer la mise en cache
- [ ] Compresser les images
- [ ] Utiliser un CDN (Cloudflare gratuit)
- [ ] Installer un certificat SSL
- [ ] Configurer les permaliens (Réglages > Permaliens > "Nom de l'article")

## Dépannage

### Les services ne s'affichent pas dans le générateur de devis

- Vérifiez que les services ont un **prix** défini
- Si aucun service n'a de prix, les services par défaut seront utilisés

### Les emails ne sont pas envoyés

- Installez et configurez un plugin SMTP (voir section Configuration Email)
- Vérifiez les logs d'erreur PHP
- Contactez votre hébergeur

### La page d'accueil n'affiche pas le bon contenu

- Allez dans **Réglages > Lecture**
- Vérifiez que "Une page statique" est sélectionnée
- Sélectionnez votre page d'accueil

### Le menu ne s'affiche pas

- Allez dans **Apparence > Menus**
- Créez un menu et assignez-le à "Menu Principal"

## Support

Pour toute question ou problème :

- **Email** : contact@web-matic.fr
- **Téléphone** : 07 56 91 30 61
- **Site web** : [https://web-matic.fr](https://web-matic.fr)

## Crédits

- **Développé par** : WebMatic
- **Version** : 1.0.0
- **Icônes** : Font Awesome 6.4.0
- **Compatible avec** : WordPress 5.8+, PHP 7.4+

## Changelog

### Version 1.0.0 (2025)

- Sortie initiale
- Générateur de devis intégré
- Custom Post Types (Services, Réalisations, Témoignages, Devis)
- Compatible Elementor
- Design responsive
- Shortcodes prêt à l'emploi

---

**WebMatic** - L'informatique côté pratique