<?php
/**
 * Toast Notifications
 * 
 * @package WebMatic
 */

if (!defined('ABSPATH')) exit;

/**
 * Ajouter les styles et scripts des toasts
 */
function webmatic_toasts_assets() {
    ?>
    <style>
        /* Toast Container */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 99999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 400px;
        }

        /* Toast Item */
        .toast {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            transform: translateX(120%);
            transition: transform 0.3s ease, opacity 0.3s ease;
            opacity: 0;
            border-left: 4px solid #4CAF50;
        }

        .toast.show {
            transform: translateX(0);
            opacity: 1;
        }

        .toast.toast-success {
            border-left-color: #4CAF50;
        }

        .toast.toast-error {
            border-left-color: #f44336;
        }

        .toast.toast-warning {
            border-left-color: #ff9800;
        }

        .toast.toast-info {
            border-left-color: #2196F3;
        }

        .toast-icon {
            font-size: 20px;
            flex-shrink: 0;
        }

        .toast-success .toast-icon { color: #4CAF50; }
        .toast-error .toast-icon { color: #f44336; }
        .toast-warning .toast-icon { color: #ff9800; }
        .toast-info .toast-icon { color: #2196F3; }

        .toast-content {
            flex: 1;
        }

        .toast-title {
            font-weight: 600;
            margin: 0 0 4px 0;
            font-size: 14px;
        }

        .toast-message {
            margin: 0;
            font-size: 13px;
            color: #666;
        }

        .toast-close {
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            color: #999;
            transition: color 0.2s ease;
        }

        .toast-close:hover {
            color: #333;
        }

        /* Progress bar */
        .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: currentColor;
            opacity: 0.3;
            width: 100%;
            transform-origin: left;
            animation: toast-progress linear forwards;
        }

        @keyframes toast-progress {
            to { transform: scaleX(0); }
        }
    </style>

    <script>
    // Toast Notification System
    window.WebmaticToast = {
        container: null,
        
        init: function() {
            if (!this.container) {
                this.container = document.createElement('div');
                this.container.className = 'toast-container';
                document.body.appendChild(this.container);
            }
        },
        
        show: function(message, type = 'success', title = '', duration = 5000) {
            this.init();
            
            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                warning: 'fa-exclamation-triangle',
                info: 'fa-info-circle'
            };
            
            const titles = {
                success: title || '<?php echo esc_js(__('Succès', 'webmatic')); ?>',
                error: title || '<?php echo esc_js(__('Erreur', 'webmatic')); ?>',
                warning: title || '<?php echo esc_js(__('Attention', 'webmatic')); ?>',
                info: title || '<?php echo esc_js(__('Info', 'webmatic')); ?>'
            };
            
            const toast = document.createElement('div');
            toast.className = 'toast toast-' + type;
            toast.innerHTML = `
                <i class="fas ${icons[type]} toast-icon"></i>
                <div class="toast-content">
                    <h4 class="toast-title">${titles[type]}</h4>
                    <p class="toast-message">${message}</p>
                </div>
                <button class="toast-close" aria-label="<?php echo esc_js(__('Fermer', 'webmatic')); ?>">
                    <i class="fas fa-times"></i>
                </button>
                <div class="toast-progress" style="animation-duration: ${duration}ms"></div>
            `;
            
            // Close button
            toast.querySelector('.toast-close').addEventListener('click', () => {
                this.hide(toast);
            });
            
            this.container.appendChild(toast);
            
            // Show animation
            requestAnimationFrame(() => {
                toast.classList.add('show');
            });
            
            // Auto hide
            setTimeout(() => {
                this.hide(toast);
            }, duration);
            
            return toast;
        },
        
        hide: function(toast) {
            toast.classList.remove('show');
            setTimeout(() => {
                toast.remove();
            }, 300);
        },
        
        success: function(message, title) {
            return this.show(message, 'success', title);
        },
        
        error: function(message, title) {
            return this.show(message, 'error', title);
        },
        
        warning: function(message, title) {
            return this.show(message, 'warning', title);
        },
        
        info: function(message, title) {
            return this.show(message, 'info', title);
        }
    };
    
    // Auto-show toasts from URL params or session
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        
        if (urlParams.has('toast')) {
            const type = urlParams.get('toast');
            const message = urlParams.get('message') || '';
            WebmaticToast.show(message, type);
        }
    });
    </script>
    <?php
}
add_action('wp_footer', 'webmatic_toasts_assets', 10);

/**
 * Helper PHP pour afficher des toasts via redirect
 */
function webmatic_add_toast_redirect($url, $type, $message) {
    return add_query_arg([
        'toast' => $type,
        'message' => urlencode($message),
    ], $url);
}
