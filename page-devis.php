<?php
/**
 * Template Name: Générateur de Devis
 * Template pour la page de générateur de devis
 * 
 * @package WebMatic
 */

get_header();
?>

<main id="main" class="site-main devis-page" role="main">
    <div class="container">
        <div class="devis-generator-wrapper">
            <div class="devis-header">
                <h1><?php _e('Générateur de Devis', 'webmatic'); ?></h1>
                <p><?php _e('Créez votre devis personnalisé en quelques clics et recevez-le instantanément', 'webmatic'); ?></p>
            </div>
            
            <!-- Avantages du générateur -->
            <div class="devis-features">
                <div class="feature-item">
                    <i class="fas fa-bolt"></i>
                    <h3><?php _e('Création Rapide', 'webmatic'); ?></h3>
                    <p><?php _e('Générez votre devis en moins de 3 minutes', 'webmatic'); ?></p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-euro-sign"></i>
                    <h3><?php _e('Prix Transparents', 'webmatic'); ?></h3>
                    <p><?php _e('Tous nos tarifs sont affichés clairement', 'webmatic'); ?></p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-envelope"></i>
                    <h3><?php _e('Envoi Automatique', 'webmatic'); ?></h3>
                    <p><?php _e('Recevez votre devis par email au format PDF', 'webmatic'); ?></p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-lock"></i>
                    <h3><?php _e('Données Sécurisées', 'webmatic'); ?></h3>
                    <p><?php _e('Vos informations sont protégées selon le RGPD', 'webmatic'); ?></p>
                </div>
            </div>
            
            <!-- Formulaire de devis multi-étapes -->
            <div id="devis-generator" class="devis-form-container" data-testid="devis-generator">
                
                <!-- Indicateur d'étapes -->
                <div class="devis-steps" data-testid="devis-steps">
                    <div class="step active" data-step="1">
                        <span class="step-number">1</span>
                        <span class="step-label"><?php _e('Infos', 'webmatic'); ?></span>
                    </div>
                    <div class="step" data-step="2">
                        <span class="step-number">2</span>
                        <span class="step-label"><?php _e('Services', 'webmatic'); ?></span>
                    </div>
                    <div class="step" data-step="3">
                        <span class="step-number">3</span>
                        <span class="step-label"><?php _e('Récap', 'webmatic'); ?></span>
                    </div>
                    <div class="step" data-step="4">
                        <span class="step-number">4</span>
                        <span class="step-label"><?php _e('Fini', 'webmatic'); ?></span>
                    </div>
                </div>
                
                <form id="devis-form" class="devis-form" data-testid="devis-form">
                    
                    <!-- Étape 1: Informations client -->
                    <div class="form-step active" data-step="1" data-testid="step-1">
                        <div class="step-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <h2><?php _e('Vos informations', 'webmatic'); ?></h2>
                        <p><?php _e('Renseignez vos coordonnées pour recevoir votre devis', 'webmatic'); ?></p>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="prenom"><?php _e('Prénom', 'webmatic'); ?> *</label>
                                <input type="text" id="prenom" name="prenom" required data-testid="prenom-input">
                            </div>
                            <div class="form-group">
                                <label for="nom"><?php _e('Nom', 'webmatic'); ?> *</label>
                                <input type="text" id="nom" name="nom" required data-testid="nom-input">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="email"><?php _e('Email', 'webmatic'); ?> *</label>
                                <input type="email" id="email" name="email" required data-testid="email-input">
                            </div>
                            <div class="form-group">
                                <label for="telephone"><?php _e('Téléphone', 'webmatic'); ?> *</label>
                                <input type="tel" id="telephone" name="telephone" required data-testid="telephone-input">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="adresse"><?php _e('Adresse', 'webmatic'); ?> *</label>
                            <input type="text" id="adresse" name="adresse" required data-testid="adresse-input">
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="code_postal"><?php _e('Code postal', 'webmatic'); ?> *</label>
                                <input type="text" id="code_postal" name="code_postal" required data-testid="code-postal-input">
                            </div>
                            <div class="form-group">
                                <label for="ville"><?php _e('Ville', 'webmatic'); ?> *</label>
                                <input type="text" id="ville" name="ville" required data-testid="ville-input">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="type_client"><?php _e('Type de client', 'webmatic'); ?></label>
                            <select id="type_client" name="type_client" data-testid="type-client-select">
                                <option value="particulier"><?php _e('Particulier', 'webmatic'); ?></option>
                                <option value="entreprise"><?php _e('Entreprise', 'webmatic'); ?></option>
                            </select>
                        </div>
                        
                        <div id="entreprise-fields" class="entreprise-fields" style="display: none;">
                            <div class="form-group">
                                <label for="nom_entreprise"><?php _e('Nom de l\'entreprise', 'webmatic'); ?></label>
                                <input type="text" id="nom_entreprise" name="nom_entreprise" data-testid="nom-entreprise-input">
                            </div>
                            <div class="form-group">
                                <label for="siret"><?php _e('SIRET', 'webmatic'); ?></label>
                                <input type="text" id="siret" name="siret" data-testid="siret-input">
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="button" class="btn btn-primary btn-next" data-testid="next-step-1">
                                <?php _e('Continuer vers les services', 'webmatic'); ?> <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Étape 2: Sélection des services -->
                    <div class="form-step" data-step="2" data-testid="step-2">
                        <div class="step-icon">
                            <i class="fas fa-tools"></i>
                        </div>
                        <h2><?php _e('Sélectionnez vos services', 'webmatic'); ?></h2>
                        <p><?php _e('Choisissez les prestations dont vous avez besoin', 'webmatic'); ?></p>
                        
                        <div id="services-list" class="services-selection" data-testid="services-list">
                            <!-- Les services seront chargés dynamiquement via JavaScript -->
                        </div>
                        
                        <div id="selected-services" class="selected-services-summary" data-testid="selected-services">
                            <h3><?php _e('Services sélectionnés:', 'webmatic'); ?></h3>
                            <div id="selected-services-list"></div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="button" class="btn btn-secondary btn-prev" data-testid="prev-step-2">
                                <i class="fas fa-arrow-left"></i> <?php _e('Retour', 'webmatic'); ?>
                            </button>
                            <button type="button" class="btn btn-primary btn-next" data-testid="next-step-2">
                                <?php _e('Calculer le devis', 'webmatic'); ?> <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Étape 3: Récapitulatif -->
                    <div class="form-step" data-step="3" data-testid="step-3">
                        <div class="step-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <h2><?php _e('Récapitulatif de votre devis', 'webmatic'); ?></h2>
                        <p><?php _e('Vérifiez les informations avant de valider', 'webmatic'); ?></p>
                        
                        <div class="recap-section">
                            <h3><i class="fas fa-user"></i> <?php _e('Vos informations', 'webmatic'); ?></h3>
                            <div id="recap-client" class="recap-content" data-testid="recap-client"></div>
                        </div>
                        
                        <div class="recap-section">
                            <h3><i class="fas fa-tools"></i> <?php _e('Services demandés', 'webmatic'); ?></h3>
                            <div id="recap-services" class="recap-content" data-testid="recap-services"></div>
                        </div>
                        
                        <div class="recap-total" data-testid="recap-total">
                            <div class="total-line">
                                <span><?php _e('Total HT', 'webmatic'); ?></span>
                                <span id="total-ht" class="total-amount">0,00 €</span>
                            </div>
                            <p class="total-note"><?php _e('Auto-entrepreneur - pas de TVA applicable', 'webmatic'); ?></p>
                        </div>
                        
                        <div class="form-actions">
                            <button type="button" class="btn btn-secondary btn-prev" data-testid="prev-step-3">
                                <i class="fas fa-arrow-left"></i> <?php _e('Modifier', 'webmatic'); ?>
                            </button>
                            <button type="submit" class="btn btn-success btn-submit" data-testid="submit-devis">
                                <i class="fas fa-check"></i> <?php _e('Valider et envoyer le devis', 'webmatic'); ?>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Étape 4: Confirmation -->
                    <div class="form-step" data-step="4" data-testid="step-4">
                        <div class="step-icon success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h2><?php _e('Devis envoyé avec succès !', 'webmatic'); ?></h2>
                        
                        <div id="confirmation-content" class="confirmation-content" data-testid="confirmation-content">
                            <p><strong><?php _e('Numéro de devis :', 'webmatic'); ?></strong> <span id="devis-number"></span></p>
                            <p><strong><?php _e('Montant :', 'webmatic'); ?></strong> <span id="devis-amount"></span></p>
                            
                            <div class="confirmation-message">
                                <p><i class="fas fa-envelope"></i> <?php _e('Votre devis a été envoyé par email', 'webmatic'); ?></p>
                                <p><?php _e('Vous recevrez un PDF détaillé dans quelques minutes.', 'webmatic'); ?></p>
                            </div>
                            
                            <div class="next-steps">
                                <h3><?php _e('Prochaines étapes :', 'webmatic'); ?></h3>
                                <ul>
                                    <li><?php _e('Audric vous contactera sous 24h', 'webmatic'); ?></li>
                                    <li><?php _e('Planification de l\'intervention', 'webmatic'); ?></li>
                                    <li><?php _e('Devis valable 30 jours', 'webmatic'); ?></li>
                                </ul>
                            </div>
                            
                            <div class="contact-info-box">
                                <h3><?php _e('Contact WebMatic :', 'webmatic'); ?></h3>
                                <p><i class="fas fa-phone"></i> <?php echo esc_html(get_theme_mod('webmatic_phone', '07 56 91 30 61')); ?></p>
                                <p><i class="fas fa-envelope"></i> <?php echo esc_html(get_theme_mod('webmatic_email', 'contact@web-matic.fr')); ?></p>
                                <p><i class="fas fa-map-marker-alt"></i> <?php echo esc_html(get_theme_mod('webmatic_address', 'Pommiers (69) et région')); ?></p>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="button" class="btn btn-primary" onclick="location.reload()" data-testid="new-devis-btn">
                                <?php _e('Créer un nouveau devis', 'webmatic'); ?>
                            </button>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>