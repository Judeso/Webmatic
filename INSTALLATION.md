# Guide d'Installation Rapide - Thème WebMatic

## 🚀 Installation en 5 Minutes

### Étape 1 : Préparation du Thème

1. **Créer l'archive ZIP**
   ```bash
   cd /app/wordpress-theme
   zip -r webmatic.zip webmatic/
   ```

2. **Télécharger le fichier `webmatic.zip`**

### Étape 2 : Installation sur WordPress

1. Connectez-vous à votre administration WordPress
2. Allez dans **Apparence > Thèmes**
3. Cliquez sur **Ajouter** puis **Téléverser un thème**
4. Sélectionnez le fichier `webmatic.zip`
5. Cliquez sur **Installer maintenant**
6. Une fois installé, cliquez sur **Activer**

### Étape 3 : Configuration de Base (3 minutes)

#### A. Informations de Contact

1. Allez dans **Apparence > Personnaliser**
2. Cliquez sur **Informations de Contact**
3. Remplissez :
   - Téléphone : `07 56 91 30 61`
   - Email : `contact@web-matic.fr`
   - Adresse : `Pommier (69) et région Rhône-Alpes`
4. Cliquez sur **Publier**

#### B. Section Hero

1. Dans le Personnaliseur, cliquez sur **Section Hero**
2. Modifiez si nécessaire :
   - Titre Hero
   - Sous-titre Hero
   - Image Hero (optionnel)
3. Cliquez sur **Publier**

#### C. Créer les Pages Essentielles

1. **Page d'Accueil**
   - Allez dans **Pages > Ajouter**
   - Titre : "Accueil"
   - Publiez sans ajouter de contenu (le thème gère tout)
   
2. **Page de Devis**
   - Allez dans **Pages > Ajouter**
   - Titre : "Demande de Devis"
   - Dans **Attributs de page**, sélectionnez le modèle : **"Générateur de Devis"**
   - Publiez

3. **Configurer la Page d'Accueil**
   - Allez dans **Réglages > Lecture**
   - Sélectionnez "Une page statique"
   - Page d'accueil : "Accueil"
   - Enregistrez

4. **Lier la Page de Devis**
   - Allez dans **Apparence > Personnaliser > Options Page d'Accueil**
   - "Page de devis" : Sélectionnez "Demande de Devis"
   - Publiez

#### D. Créer le Menu

1. Allez dans **Apparence > Menus**
2. Créez un nouveau menu "Menu Principal"
3. Ajoutez les pages :
   - Accueil
   - Services (créez une page ou utilisez #services comme lien personnalisé)
   - Réalisations
   - Témoignages
   - Devis
   - Contact
4. Cochez "Menu Principal" dans "Emplacement du menu"
5. Enregistrez

### Étape 4 : Ajouter du Contenu (Optionnel mais recommandé)

#### Services

Les services par défaut s'affichent automatiquement. Pour personnaliser :

1. Allez dans **Services > Ajouter un service**
2. Exemple :
   - **Titre** : Création de Sites Web
   - **Contenu** : Description détaillée
   - **Extrait** : Sites sur mesure qui reflètent votre identité
   - **Image à la une** : Téléchargez une image
3. Dans **Détails du service** :
   - **Icône** : `fas fa-laptop`
   - **Prix HT** : `450`
   - **Caractéristiques** (une par ligne) :
     ```
     Design responsive moderne
     Optimisation SEO incluse
     CMS facile à utiliser
     Hébergement et maintenance
     ```
4. Publiez

Répétez pour tous vos services (Maintenance IT, Consoles/Gaming, Mobile, etc.)

#### Réalisations

1. Allez dans **Réalisations > Ajouter une réalisation**
2. Exemple :
   - **Titre** : Sakura Massage
   - **Contenu** : Site vitrine pour un institut de massage...
   - **Image à la une** : Capture d'écran du site
3. Dans **Détails de la réalisation** :
   - **URL du site** : `https://sakuramassage.fr`
   - **Tags** : `Site Vitrine, Responsive, Réservation`
4. Publiez

#### Témoignages

1. Allez dans **Témoignages > Ajouter un témoignage**
2. Exemple :
   - **Titre** : Thierry Gray
   - **Contenu** : Audric a ressuscité mon vieux PC...
3. Dans **Détails du témoignage** :
   - **Note** : 5 étoiles
   - **Info auteur** : `Local Guide · 35 avis`
4. Publiez

### Étape 5 : Optimisation (Recommandé)

#### A. Configuration des Permaliens

1. Allez dans **Réglages > Permaliens**
2. Sélectionnez **"Nom de l'article"**
3. Enregistrez

#### B. Plugin Email (Important pour les devis)

1. Installez **WP Mail SMTP** ou **Easy WP SMTP**
2. Configurez avec vos identifiants email
3. Testez l'envoi d'email

#### C. Plugins Recommandés

Installez ces plugins pour une meilleure expérience :

- **Elementor** (si vous voulez utiliser le page builder)
- **Yoast SEO** ou **Rank Math** (référencement)
- **WP Super Cache** (performance)
- **Wordfence** (sécurité)

## 🎨 Personnalisation Avancée

### Modifier les Couleurs

Allez dans **Apparence > Personnaliser > CSS Additionnel** et ajoutez :

```css
:root {
    --color-primary: #votre-couleur;
    --color-secondary: #votre-couleur;
}
```

### Ajouter votre Logo

1. Allez dans **Apparence > Personnaliser**
2. Cliquez sur **Identité du site**
3. **Logo** : Téléchargez votre logo
4. Publiez

### Modifier les Réseaux Sociaux

1. Allez dans **Apparence > Personnaliser > Réseaux Sociaux**
2. Activez l'affichage
3. Ajoutez les URLs de vos profils
4. Publiez

## 📧 Configuration des Emails pour le Générateur de Devis

### Méthode 1 : Plugin SMTP (Recommandé)

1. Installez **WP Mail SMTP**
2. Allez dans **WP Mail SMTP > Settings**
3. Choisissez votre fournisseur (Gmail, Outlook, SendGrid, etc.)
4. Configurez les identifiants
5. Testez l'envoi

### Méthode 2 : Configuration Serveur

Si votre hébergeur le permet, configurez directement dans `wp-config.php` :

```php
define('SMTP_HOST', 'smtp.votredomaine.com');
define('SMTP_PORT', '587');
define('SMTP_USER', 'votre@email.com');
define('SMTP_PASS', 'votre-mot-de-passe');
define('SMTP_SECURE', 'tls');
```

## 🐛 Dépannage Rapide

### Les emails ne partent pas

1. Installez WP Mail SMTP
2. Configurez avec Gmail ou autre service
3. Testez avec l'outil de test du plugin

### La page d'accueil affiche "Aucun contenu"

1. Allez dans **Réglages > Lecture**
2. Vérifiez que "Accueil" est bien sélectionnée
3. Assurez-vous que le thème est activé

### Les services ne s'affichent pas dans le devis

- Les services doivent avoir un **prix** défini
- Si aucun service avec prix, les services par défaut s'affichent automatiquement

### Erreur 404 sur les services/réalisations

1. Allez dans **Réglages > Permaliens**
2. Cliquez simplement sur **Enregistrer** (cela rafraîchit les règles)

## 📞 Support

**Email** : contact@web-matic.fr  
**Téléphone** : 07 56 91 30 61  
**Site** : https://web-matic.fr

## ✅ Checklist Finale

- [ ] Thème activé
- [ ] Informations de contact configurées
- [ ] Page d'accueil créée et définie
- [ ] Page de devis créée avec le bon template
- [ ] Menu principal créé et assigné
- [ ] Logo uploadé
- [ ] Au moins 4 services ajoutés
- [ ] Au moins 2 réalisations ajoutées
- [ ] Au moins 3 témoignages ajoutés
- [ ] Plugin SMTP installé et configuré
- [ ] Test d'envoi de devis effectué
- [ ] Permaliens configurés en "Nom de l'article"

---

**Félicitations ! Votre site WebMatic est prêt ! 🎉**
