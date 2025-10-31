/**
 * Admin Dashboard JavaScript
 * Path: /assets/js/admin-dashboard.js
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        
        // Enable All Widgets
        $('#cew-enable-all').on('click', function(e) {
            e.preventDefault();
            $('.cew-widget-checkbox').prop('checked', true);
            updateWidgetCards();
            showNotification('All widgets enabled', 'success');
        });
        
        // Disable All Widgets
        $('#cew-disable-all').on('click', function(e) {
            e.preventDefault();
            $('.cew-widget-checkbox').prop('checked', false);
            updateWidgetCards();
            showNotification('All widgets disabled', 'info');
        });
        
        // Update widget card appearance when toggle changes
        $('.cew-widget-checkbox').on('change', function() {
            updateWidgetCards();
            
            const widgetCard = $(this).closest('.cew-widget-card');
            const widgetName = widgetCard.find('h3').text();
            const isEnabled = $(this).is(':checked');
            
            if (isEnabled) {
                showNotification(`${widgetName} enabled`, 'success');
            } else {
                showNotification(`${widgetName} disabled`, 'info');
            }
        });
        
        // Clear Cache
        $('#cew-clear-cache').on('click', function(e) {
            e.preventDefault();
            
            const button = $(this);
            const originalText = button.html();
            
            button.prop('disabled', true);
            button.html('<span class="dashicons dashicons-update spin"></span> Clearing...');
            
            // Simulate cache clearing (you can add AJAX call here)
            setTimeout(function() {
                button.prop('disabled', false);
                button.html(originalText);
                showNotification('Widget cache cleared successfully', 'success');
            }, 1500);
        });
        
        // Update widget card appearance
        function updateWidgetCards() {
            $('.cew-widget-card').each(function() {
                const checkbox = $(this).find('.cew-widget-checkbox');
                const badge = $(this).find('.cew-widget-badge');
                
                if (checkbox.is(':checked')) {
                    $(this).addClass('cew-widget-enabled').removeClass('cew-widget-disabled');
                    badge.removeClass('cew-badge-disabled').addClass('cew-badge-success').text('Active');
                } else {
                    $(this).addClass('cew-widget-disabled').removeClass('cew-widget-enabled');
                    badge.removeClass('cew-badge-success').addClass('cew-badge-disabled').text('Inactive');
                }
            });
            
            updateStats();
        }
        
        // Update statistics
        function updateStats() {
            const totalWidgets = $('.cew-widget-checkbox').length;
            const activeWidgets = $('.cew-widget-checkbox:checked').length;
            const inactiveWidgets = totalWidgets - activeWidgets;
            
            // Update stat numbers with animation
            animateValue($('.cew-stat-success .cew-stat-number'), parseInt($('.cew-stat-success .cew-stat-number').text()), activeWidgets, 300);
            animateValue($('.cew-stat-warning .cew-stat-number'), parseInt($('.cew-stat-warning .cew-stat-number').text()), inactiveWidgets, 300);
        }
        
        // Animate number changes
        function animateValue(element, start, end, duration) {
            const range = end - start;
            const increment = range / (duration / 16); // 60fps
            let current = start;
            
            const timer = setInterval(function() {
                current += increment;
                if ((increment > 0 && current >= end) || (increment < 0 && current <= end)) {
                    current = end;
                    clearInterval(timer);
                }
                element.text(Math.round(current));
            }, 16);
        }
        
        // Show notification
        function showNotification(message, type = 'info') {
            // Remove existing notifications
            $('.cew-notification').remove();
            
            const typeClass = {
                'success': 'notice-success',
                'error': 'notice-error',
                'warning': 'notice-warning',
                'info': 'notice-info'
            };
            
            const notification = $('<div>', {
                class: `notice ${typeClass[type]} is-dismissible cew-notification`,
                html: `<p>${message}</p>`
            });
            
            $('.cew-dashboard').prepend(notification);
            
            // Add dismiss button functionality
            notification.find('.notice-dismiss').on('click', function() {
                notification.fadeOut(300, function() {
                    $(this).remove();
                });
            });
            
            // Auto dismiss after 3 seconds
            setTimeout(function() {
                notification.fadeOut(300, function() {
                    $(this).remove();
                });
            }, 3000);
        }
        
        // Add spinning animation for update icon
        const style = document.createElement('style');
        style.textContent = `
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
            .spin {
                animation: spin 1s linear infinite;
            }
        `;
        document.head.appendChild(style);
        
        // Smooth scroll for links
        $('a[href^="#"]').on('click', function(e) {
            const target = $(this.getAttribute('href'));
            if (target.length) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top - 32
                }, 500);
            }
        });
        
        // Confirm before leaving page if changes were made
        let changesMade = false;
        $('.cew-widget-checkbox, input[name="cew_load_optimization"]').on('change', function() {
            changesMade = true;
        });
        
        $('form.cew-form').on('submit', function() {
            changesMade = false;
        });
        
        $(window).on('beforeunload', function() {
            if (changesMade) {
                return 'You have unsaved changes. Are you sure you want to leave?';
            }
        });
        
        // Keyboard shortcuts
        $(document).on('keydown', function(e) {
            // Ctrl/Cmd + S to save
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                $('form.cew-form').submit();
            }
        });
        
        // Add tooltips (if needed)
        $('[data-tooltip]').hover(
            function() {
                const tooltip = $('<div>', {
                    class: 'cew-tooltip',
                    text: $(this).data('tooltip')
                });
                $('body').append(tooltip);
                
                const offset = $(this).offset();
                tooltip.css({
                    top: offset.top - tooltip.outerHeight() - 10,
                    left: offset.left + ($(this).outerWidth() / 2) - (tooltip.outerWidth() / 2)
                });
            },
            function() {
                $('.cew-tooltip').remove();
            }
        );
        
        console.log('Custom Elementor Widgets Dashboard initialized');
    });

})(jQuery);