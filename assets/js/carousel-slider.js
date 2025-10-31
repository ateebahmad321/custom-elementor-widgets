/**
 * Carousel Slider JavaScript
 * Path: /assets/js/carousel-slider.js
 */

(function($) {
    'use strict';

    class Carousel {
        constructor(element) {
            if (!element) {
                console.error('Carousel: Element is null or undefined');
                return;
            }
            
            this.carousel = element;
            this.carouselId = this.carousel.id;
            
            if (!this.carouselId) {
                console.error('Carousel: Element has no ID');
                return;
            }
            
            const widgetId = this.carouselId.replace('carousel-', '');
            
            this.container = element.querySelector(`#carouselContainer-${widgetId}`);
            this.prevBtn = element.querySelector(`#prevBtn-${widgetId}`);
            this.nextBtn = element.querySelector(`#nextBtn-${widgetId}`);
            this.dotsContainer = element.querySelector(`#dotsContainer-${widgetId}`);
            
            if (!this.container) {
                console.error('Carousel: Container not found for ID:', widgetId);
                return;
            }
            
            this.originalSlides = Array.from(this.container.querySelectorAll('.banner-carousel'));
            this.totalOriginalSlides = this.originalSlides.length;
            
            if (this.totalOriginalSlides === 0) {
                console.warn('Carousel: No slides found');
                return;
            }
            
            this.currentIndex = 0;
            this.slideWidth = 0;
            this.gap = 20; // 1.25rem in pixels
            this.autoplayInterval = null;
            this.autoplayDelay = parseInt(this.carousel.dataset.autoplaySpeed) || 3000;
            this.autoplayEnabled = this.carousel.dataset.autoplay === 'true';
            this.isTransitioning = false;
            
            this.init();
        }
        
        init() {
            this.cloneSlides();
            this.createDots();
            this.calculateSlideWidth();
            this.currentIndex = this.totalOriginalSlides; // Start at first original slide
            this.updateCarousel(false);
            this.attachEventListeners();
            
            if (this.autoplayEnabled) {
                this.startAutoplay();
            }
            
            // Recalculate on window resize
            window.addEventListener('resize', () => {
                this.calculateSlideWidth();
                this.updateCarousel(false);
            });
        }
        
        cloneSlides() {
            // Clone slides and append/prepend for infinite loop
            const firstClones = this.originalSlides.map(slide => slide.cloneNode(true));
            const lastClones = this.originalSlides.map(slide => slide.cloneNode(true));
            
            // Append clones to the end
            firstClones.forEach(clone => this.container.appendChild(clone));
            
            // Prepend clones to the beginning
            lastClones.reverse().forEach(clone => this.container.insertBefore(clone, this.container.firstChild));
        }
        
        calculateSlideWidth() {
            const allSlides = this.container.querySelectorAll('.banner-carousel');
            if (allSlides.length > 0) {
                const slideElement = allSlides[0].querySelector('.banner-carousel-item');
                this.slideWidth = slideElement.offsetWidth + this.gap;
            }
        }
        
        createDots() {
            this.dotsContainer.innerHTML = '';
            this.originalSlides.forEach((_, index) => {
                const dot = document.createElement('button');
                dot.classList.add('zt-carousel__dot');
                dot.type = 'button';
                if (index === 0) {
                    dot.classList.add('zt-carousel__dot--selected');
                }
                dot.addEventListener('click', () => this.goToSlide(index));
                this.dotsContainer.appendChild(dot);
            });
        }
        
        updateCarousel(animate = true) {
            if (!animate) {
                this.container.classList.add('no-transition');
            }
            
            const offset = -this.currentIndex * this.slideWidth;
            this.container.style.transform = `translate3d(${offset}px, 0px, 0px)`;
            
            if (!animate) {
                // Force reflow to apply the no-transition class
                this.container.offsetHeight;
                setTimeout(() => {
                    this.container.classList.remove('no-transition');
                }, 50);
            }
            
            // Update dots based on actual position
            const actualIndex = this.getActualIndex();
            const dots = this.dotsContainer.querySelectorAll('.zt-carousel__dot');
            dots.forEach((dot, index) => {
                if (index === actualIndex) {
                    dot.classList.add('zt-carousel__dot--selected');
                } else {
                    dot.classList.remove('zt-carousel__dot--selected');
                }
            });
            
            // Buttons are never disabled in infinite loop
            if (this.prevBtn) this.prevBtn.disabled = false;
            if (this.nextBtn) this.nextBtn.disabled = false;
        }
        
        getActualIndex() {
            // Convert current index to the corresponding original slide index
            let actualIndex = this.currentIndex - this.totalOriginalSlides;
            if (actualIndex < 0) {
                actualIndex = this.totalOriginalSlides + actualIndex;
            } else if (actualIndex >= this.totalOriginalSlides) {
                actualIndex = actualIndex - this.totalOriginalSlides;
            }
            return actualIndex;
        }
        
        goToSlide(index) {
            this.currentIndex = index + this.totalOriginalSlides;
            this.updateCarousel();
            this.resetAutoplay();
        }
        
        next() {
            if (this.isTransitioning) return;
            this.isTransitioning = true;
            
            this.currentIndex++;
            this.updateCarousel();
            
            // Check if we've reached the end of cloned slides
            if (this.currentIndex >= this.totalOriginalSlides * 2) {
                setTimeout(() => {
                    this.currentIndex = this.totalOriginalSlides;
                    this.updateCarousel(false);
                    this.isTransitioning = false;
                }, 500);
            } else {
                setTimeout(() => {
                    this.isTransitioning = false;
                }, 500);
            }
        }
        
        prev() {
            if (this.isTransitioning) return;
            this.isTransitioning = true;
            
            this.currentIndex--;
            this.updateCarousel();
            
            // Check if we've reached the beginning of cloned slides
            if (this.currentIndex < this.totalOriginalSlides) {
                setTimeout(() => {
                    this.currentIndex = this.totalOriginalSlides * 2 - 1;
                    this.updateCarousel(false);
                    this.isTransitioning = false;
                }, 500);
            } else {
                setTimeout(() => {
                    this.isTransitioning = false;
                }, 500);
            }
        }
        
        startAutoplay() {
            if (!this.autoplayEnabled) return;
            
            this.autoplayInterval = setInterval(() => {
                this.next();
            }, this.autoplayDelay);
        }
        
        stopAutoplay() {
            if (this.autoplayInterval) {
                clearInterval(this.autoplayInterval);
                this.autoplayInterval = null;
            }
        }
        
        resetAutoplay() {
            if (!this.autoplayEnabled) return;
            this.stopAutoplay();
            this.startAutoplay();
        }
        
        attachEventListeners() {
            if (this.prevBtn) {
                this.prevBtn.addEventListener('click', () => {
                    this.prev();
                    this.resetAutoplay();
                });
            }
            
            if (this.nextBtn) {
                this.nextBtn.addEventListener('click', () => {
                    this.next();
                    this.resetAutoplay();
                });
            }
            
            // Pause autoplay on hover
            this.carousel.addEventListener('mouseenter', () => {
                this.stopAutoplay();
            });
            
            this.carousel.addEventListener('mouseleave', () => {
                if (this.autoplayEnabled) {
                    this.startAutoplay();
                }
            });
            
            // Touch support for mobile
            let touchStartX = 0;
            let touchEndX = 0;
            
            this.container.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
            }, { passive: true });
            
            this.container.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                const swipeThreshold = 50;
                if (touchStartX - touchEndX > swipeThreshold) {
                    this.next();
                    this.resetAutoplay();
                }
                if (touchEndX - touchStartX > swipeThreshold) {
                    this.prev();
                    this.resetAutoplay();
                }
            }, { passive: true });
        }
    }
    
    // Store initialized carousels to prevent double initialization
    const initializedCarousels = new Set();
    
    // Initialize all carousels
    function initCarousels() {
        const carousels = document.querySelectorAll('[id^="carousel-"]');
        carousels.forEach(carousel => {
            // Check if already initialized
            if (!initializedCarousels.has(carousel.id)) {
                const instance = new Carousel(carousel);
                if (instance && instance.carousel) {
                    initializedCarousels.add(carousel.id);
                }
            }
        });
    }
    
    // Elementor Frontend Init
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/carousel-slider.default', function($scope) {
            const carousel = $scope.find('[id^="carousel-"]')[0];
            if (carousel && !initializedCarousels.has(carousel.id)) {
                const instance = new Carousel(carousel);
                if (instance && instance.carousel) {
                    initializedCarousels.add(carousel.id);
                }
            }
        });
    });
    
    // Regular page load
    if (typeof elementorFrontend === 'undefined') {
        $(document).ready(function() {
            initCarousels();
        });
    }

})(jQuery);