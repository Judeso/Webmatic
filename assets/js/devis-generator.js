/**
 * Générateur de Devis JavaScript
 * @package WebMatic
 */

(function($) {
    'use strict';
    
    let currentStep = 1;
    let formData = {};
    let selectedServices = [];
    let availableServices = [];
    
    /**
     * Initialisation
     */
    function init() {
        loadServices();
        setupEventListeners();
        updateStepIndicator();
    }
    
    /**
     * Charger les services disponibles
     */
    function loadServices() {
        $.ajax({
            url: webmaticAjax.ajax_url,
            type: 'POST',
            data: {
                action: 'webmatic_get_services',
            },
            success: function(response) {
                if (response.success) {
                    availableServices = response.data;
                    renderServices();
                }
            },
            error: function() {
                $('#services-list').html('<p style="color: red;">Erreur lors du chargement des services.</p>');
            }
        });
    }
    
    /**
     * Afficher les services par catégorie
     */
    function renderServices() {
        const categories = {
            'web': { icon: 'fa-laptop', label: 'Développement Web' },
            'maintenance': { icon: 'fa-tools', label: 'Maintenance IT' },
            'securite': { icon: 'fa-video', label: 'Sécurité' },
            'mobile': { icon: 'fa-mobile-alt', label: 'Mobile & Gaming' },
            'formation': { icon: 'fa-graduation-cap', label: 'Formation' },
            'general': { icon: 'fa-cog', label: 'Autres Services' }
        };
        
        let html = '';
        
        // Grouper les services par catégorie
        const groupedServices = {};
        availableServices.forEach(service => {
            const cat = service.category || 'general';
            if (!groupedServices[cat]) {
                groupedServices[cat] = [];
            }
            groupedServices[cat].push(service);
        });
        
        // Afficher par catégorie
        Object.keys(groupedServices).forEach(category => {
            const catInfo = categories[category] || categories['general'];
            html += `
                <div class="service-category">
                    <h4><i class="fas ${catInfo.icon}"></i> ${catInfo.label}</h4>
                    <div class="service-items">
            `;
            
            groupedServices[category].forEach(service => {
                html += `
                    <div class="service-item" data-service-id="${service.id}">
                        <div class="service-info">
                            <div class="service-name">${service.name}</div>
                            <div class="service-price">${formatPrice(service.price)} €</div>
                        </div>
                        <div class="service-controls">
                            <input type="checkbox" class="service-checkbox" data-service-id="${service.id}">
                            <div class="quantity-controls" style="display: none;">
                                <button type="button" class="qty-minus" data-service-id="${service.id}">-</button>
                                <input type="number" class="service-quantity" data-service-id="${service.id}" value="1" min="1">
                                <button type="button" class="qty-plus" data-service-id="${service.id}">+</button>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            html += `
                    </div>
                </div>
            `;
        });
        
        $('#services-list').html(html);
        setupServiceEventListeners();
    }
    
    /**
     * Event listeners pour les services
     */
    function setupServiceEventListeners() {
        // Checkbox des services
        $('.service-checkbox').on('change', function() {
            const serviceId = $(this).data('service-id');
            const $item = $(this).closest('.service-item');
            const $controls = $item.find('.quantity-controls');
            
            if ($(this).is(':checked')) {
                $item.addClass('selected');
                $controls.show();
                addService(serviceId);
            } else {
                $item.removeClass('selected');
                $controls.hide();
                removeService(serviceId);
            }
        });
        
        // Boutons de quantité
        $('.qty-minus').on('click', function() {
            const serviceId = $(this).data('service-id');
            const $input = $(`.service-quantity[data-service-id="${serviceId}"]`);
            let value = parseInt($input.val());
            if (value > 1) {
                $input.val(value - 1);
                updateServiceQuantity(serviceId, value - 1);
            }
        });
        
        $('.qty-plus').on('click', function() {
            const serviceId = $(this).data('service-id');
            const $input = $(`.service-quantity[data-service-id="${serviceId}"]`);
            let value = parseInt($input.val());
            $input.val(value + 1);
            updateServiceQuantity(serviceId, value + 1);
        });
        
        $('.service-quantity').on('change', function() {
            const serviceId = $(this).data('service-id');
            const value = Math.max(1, parseInt($(this).val()) || 1);
            $(this).val(value);
            updateServiceQuantity(serviceId, value);
        });
    }
    
    /**
     * Ajouter un service
     */
    function addService(serviceId) {
        const service = availableServices.find(s => s.id == serviceId);
        if (service && !selectedServices.find(s => s.id == serviceId)) {
            selectedServices.push({
                id: service.id,
                name: service.name,
                price: service.price,
                quantity: 1
            });
            updateSelectedServicesSummary();
        }
    }
    
    /**
     * Retirer un service
     */
    function removeService(serviceId) {
        selectedServices = selectedServices.filter(s => s.id != serviceId);
        updateSelectedServicesSummary();
    }
    
    /**
     * Mettre à jour la quantité
     */
    function updateServiceQuantity(serviceId, quantity) {
        const service = selectedServices.find(s => s.id == serviceId);
        if (service) {
            service.quantity = quantity;
            updateSelectedServicesSummary();
        }
    }
    
    /**
     * Mettre à jour le résumé des services sélectionnés
     */
    function updateSelectedServicesSummary() {
        const $list = $('#selected-services-list');
        
        if (selectedServices.length === 0) {
            $list.html('<p style="color: #6b7280;">Aucun service sélectionné</p>');
            return;
        }
        
        let html = '';
        selectedServices.forEach(service => {
            const total = service.price * service.quantity;
            html += `
                <div class="selected-service-item">
                    <span>${service.name} x${service.quantity}</span>
                    <span>${formatPrice(total)} €</span>
                </div>
            `;
        });
        
        $list.html(html);
    }
    
    /**
     * Configuration des event listeners
     */
    function setupEventListeners() {
        // Boutons suivant
        $('.btn-next').on('click', function() {
            if (validateCurrentStep()) {
                saveCurrentStepData();
                goToStep(currentStep + 1);
            }
        });
        
        // Boutons précédent
        $('.btn-prev').on('click', function() {
            goToStep(currentStep - 1);
        });
        
        // Soumission du formulaire
        $('#devis-form').on('submit', function(e) {
            e.preventDefault();
            submitDevis();
        });
    }
    
    /**
     * Aller à une étape
     */
    function goToStep(step) {
        $('.form-step').removeClass('active');
        $(`.form-step[data-step="${step}"]`).addClass('active');
        currentStep = step;
        updateStepIndicator();
        
        // Si on arrive à l'étape 3, afficher le récapitulatif
        if (step === 3) {
            displayRecap();
        }
        
        // Scroll vers le haut
        $('html, body').animate({ scrollTop: $('#devis-generator').offset().top - 100 }, 300);
    }
    
    /**
     * Mettre à jour l'indicateur d'étapes
     */
    function updateStepIndicator() {
        $('.step').each(function() {
            const stepNum = parseInt($(this).data('step'));
            $(this).removeClass('active completed');
            
            if (stepNum === currentStep) {
                $(this).addClass('active');
            } else if (stepNum < currentStep) {
                $(this).addClass('completed');
            }
        });
    }
    
    /**
     * Valider l'étape actuelle
     */
    function validateCurrentStep() {
        const $currentStep = $(`.form-step[data-step="${currentStep}"]`);
        const $requiredFields = $currentStep.find('[required]');
        let isValid = true;
        
        $requiredFields.each(function() {
            if (!$(this).val()) {
                $(this).addClass('error');
                isValid = false;
            } else {
                $(this).removeClass('error');
            }
        });
        
        // Validation spécifique pour l'étape 2
        if (currentStep === 2 && selectedServices.length === 0) {
            alert('Veuillez sélectionner au moins un service.');
            return false;
        }
        
        if (!isValid) {
            alert('Veuillez remplir tous les champs obligatoires.');
        }
        
        return isValid;
    }
    
    /**
     * Sauvegarder les données de l'étape
     */
    function saveCurrentStepData() {
        const $currentStep = $(`.form-step[data-step="${currentStep}"]`);
        $currentStep.find('input, select, textarea').each(function() {
            const name = $(this).attr('name');
            if (name) {
                formData[name] = $(this).val();
            }
        });
    }
    
    /**
     * Afficher le récapitulatif
     */
    function displayRecap() {
        // Informations client
        let clientHtml = `
            <p><strong>Nom :</strong> ${formData.prenom} ${formData.nom}</p>
            <p><strong>Email :</strong> ${formData.email}</p>
            <p><strong>Téléphone :</strong> ${formData.telephone}</p>
            <p><strong>Adresse :</strong> ${formData.adresse}, ${formData.code_postal} ${formData.ville}</p>
            <p><strong>Type :</strong> ${formData.type_client === 'entreprise' ? 'Entreprise' : 'Particulier'}</p>
        `;
        
        if (formData.type_client === 'entreprise') {
            clientHtml += `
                <p><strong>Entreprise :</strong> ${formData.nom_entreprise}</p>
                <p><strong>SIRET :</strong> ${formData.siret}</p>
            `;
        }
        
        $('#recap-client').html(clientHtml);
        
        // Services
        let servicesHtml = '<ul style="list-style: none; padding: 0;">';
        let total = 0;
        
        selectedServices.forEach(service => {
            const subtotal = service.price * service.quantity;
            total += subtotal;
            servicesHtml += `
                <li style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid #e5e7eb;">
                    <span>${service.name} x${service.quantity}</span>
                    <span><strong>${formatPrice(subtotal)} €</strong></span>
                </li>
            `;
        });
        servicesHtml += '</ul>';
        
        $('#recap-services').html(servicesHtml);
        $('#total-ht').text(formatPrice(total) + ' €');
    }
    
    /**
     * Soumettre le devis
     */
    function submitDevis() {
        const $button = $('.btn-submit');
        $button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Envoi en cours...');
        
        const submitData = {
            action: 'webmatic_submit_devis',
            nonce: webmaticAjax.nonce,
            ...formData,
            services: JSON.stringify(selectedServices)
        };
        
        $.ajax({
            url: webmaticAjax.ajax_url,
            type: 'POST',
            data: submitData,
            success: function(response) {
                if (response.success) {
                    $('#devis-number').text(response.data.devis_number);
                    $('#devis-amount').text(response.data.montant);
                    goToStep(4);
                } else {
                    alert('Erreur : ' + response.data.message);
                    $button.prop('disabled', false).html('<i class="fas fa-check"></i> Valider et envoyer le devis');
                }
            },
            error: function() {
                alert('Erreur lors de l\'envoi du devis. Veuillez réessayer.');
                $button.prop('disabled', false).html('<i class="fas fa-check"></i> Valider et envoyer le devis');
            }
        });
    }
    
    /**
     * Formater le prix
     */
    function formatPrice(price) {
        return parseFloat(price).toFixed(2).replace('.', ',');
    }
    
    // Initialiser au chargement du document
    $(document).ready(function() {
        if ($('#devis-generator').length) {
            init();
        }
    });
    
})(jQuery);