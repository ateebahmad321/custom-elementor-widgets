/**
 * Achievements Gallery JavaScript
 * Path: /assets/js/achievements-gallery.js
 */

(function($) {
    'use strict';

    // Desktop Gallery Functionality
    class AchievementsGallery {
        constructor(galleryElement) {
            if (!galleryElement) {
                console.error('AchievementsGallery: Element is null or undefined');
                return;
            }
            
            this.gallery = galleryElement;
            this.items = Array.from(this.gallery.querySelectorAll('.achievements-image-gallery-item'));
            
            if (this.items.length === 0) {
                console.warn('AchievementsGallery: No items found');
                return;
            }
            
            this.currentActiveIndex = 0;
            this.init();
        }
        
        init() {
            this.attachEventListeners();
        }
        
        setActive(index) {
            // Remove active class from all items
            this.items.forEach(item => {
                item.classList.remove('achievements-image-gallery-active');
            });
            
            // Add active class to hovered/clicked item
            this.items[index].classList.add('achievements-image-gallery-active');
            this.currentActiveIndex = index;
        }
        
        attachEventListeners() {
            this.items.forEach((item, index) => {
                // Handle mouse enter - expand on hover
                item.addEventListener('mouseenter', () => {
                    this.setActive(index);
                });
                
                // Handle click
                item.addEventListener('click', (e) => {
                    // Don't trigger if clicking on the link or button
                    if (e.target.closest('a') || e.target.closest('button')) {
                        return;
                    }
                    this.setActive(index);
                });
                
                // Handle arrow button click
                const arrowButton = item.querySelector('.achievements-image-gallery-arrow-button');
                if (arrowButton) {
                    arrowButton.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const link = item.querySelector('.achievements-image-gallery-link');
                        if (link) {
                            window.open(link.href, link.target || '_blank');
                        }
                    });
                }
            });
        }
    }
    
    // Mobile Tabs Functionality
    class MobileTabs {
        constructor(widgetId) {
            this.widgetId = widgetId;
            this.tabs = document.querySelectorAll(`#mobileTabNav-${widgetId} .achievements-mobile-tab-item`);
            this.contents = document.querySelectorAll(`#mobileTabNav-${widgetId}`).length > 0 
                ? document.querySelectorAll(`#mobileTabNav-${widgetId}`)[0].closest('.zt-achievements').querySelectorAll('.achievements-mobile-content')
                : [];
            
            if (this.tabs.length > 0 && this.contents.length > 0) {
                this.init();
            }
        }
        
        init() {
            this.attachEventListeners();
        }
        
        setActive(tabId) {
            // Remove active class from all tabs
            this.tabs.forEach(tab => {
                tab.classList.remove('achievements-mobile-item-active');
            });
            
            // Remove active class from all contents
            this.contents.forEach(content => {
                content.classList.remove('achievements-mobile-item-active');
            });
            
            // Add active class to clicked tab
            const activeTab = document.querySelector(`[data-tab="${tabId}"]`);
            if (activeTab) {
                activeTab.classList.add('achievements-mobile-item-active');
            }
            
            // Add active class to corresponding content
            const activeContent = document.getElementById(`${tabId}-mobile`);
            if (activeContent) {
                activeContent.classList.add('achievements-mobile-item-active');
            }
        }
        
        attachEventListeners() {
            this.tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const tabId = tab.getAttribute('data-tab');
                    this.setActive(tabId);
                });
            });
        }
    }
    
    // Initialize based on screen size
    function initializeGallery(galleryElement) {
        const widgetId = galleryElement.id.replace('achievementsImageGallery-', '');
        
        if (window.innerWidth > 1024) {
            // Desktop: Initialize hover gallery
            new AchievementsGallery(galleryElement);
        } else {
            // Mobile: Initialize tabs
            new MobileTabs(widgetId);
        }
    }
    
    // Initialize all galleries on the page
    function initAllGalleries() {
        const galleries = document.querySelectorAll('[id^="achievementsImageGallery-"]');
        galleries.forEach(gallery => {
            initializeGallery(gallery);
        });
    }
    
    // Elementor Frontend Init
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/achievements_gallery.default', function($scope) {
            const gallery = $scope.find('[id^="achievementsImageGallery-"]')[0];
            if (gallery) {
                initializeGallery(gallery);
            }
        });
    });
    
    // Regular page load
    if (typeof elementorFrontend === 'undefined') {
        $(document).ready(function() {
            initAllGalleries();
        });
    }
    
    // Reinitialize on window resize with debounce
    let resizeTimeout;
    $(window).on('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
            initAllGalleries();
        }, 250);
    });

})(jQuery);