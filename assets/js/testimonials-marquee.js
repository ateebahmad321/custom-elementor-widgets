/**
 * Testimonials Marquee JavaScript
 * Path: /assets/js/testimonials-marquee.js
 */

(function($) {
    'use strict';

    class TestimonialsMarquee {
        constructor(element) {
            if (!element) {
                console.error('TestimonialsMarquee: Element is null or undefined');
                return;
            }
            
            this.wrapper = element;
            this.init();
        }
        
        init() {
            // The animation is handled purely by CSS
            // This file is here for future enhancements if needed
            console.log('Testimonials Marquee initialized');
        }
    }
    
    // Initialize all testimonials marquees
    function initAllMarquees() {
        const marquees = document.querySelectorAll('[id^="testimonials-"]');
        marquees.forEach(marquee => {
            new TestimonialsMarquee(marquee);
        });
    }
    
    // Elementor Frontend Init
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/testimonials-marquee.default', function($scope) {
            const marquee = $scope.find('[id^="testimonials-"]')[0];
            if (marquee) {
                new TestimonialsMarquee(marquee);
            }
        });
    });
    
    // Regular page load
    if (typeof elementorFrontend === 'undefined') {
        $(document).ready(function() {
            initAllMarquees();
        });
    }

})(jQuery);