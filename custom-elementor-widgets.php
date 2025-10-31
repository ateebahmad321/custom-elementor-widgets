<?php
/**
 * Plugin Name: Custom Elementor Widgets
 * Description: Custom Elementor widgets including Achievements Gallery, Carousel Slider, Testimonials Marquee and more
 * Version: 1.0.1
 * Author: Ateeb Azhar
 * Text Domain: custom-elementor-widgets
 * Elementor tested up to: 3.21.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Main Plugin Class
 */
function custom_elementor_widgets_init() {
    
    // Check if Elementor is installed and activated
    if (!did_action('elementor/loaded')) {
        add_action('admin_notices', function() {
            echo '<div class="notice notice-warning is-dismissible"><p><strong>Custom Elementor Widgets</strong> requires <strong>Elementor</strong> to be installed and activated.</p></div>';
        });
        return;
    }

    // Register Widgets - Wait for Elementor to be fully loaded
    add_action('elementor/widgets/register', function($widgets_manager) {
        // Include the Achievements Gallery widget file
        require_once(__DIR__ . '/widgets/achievements-gallery.php');
        $widgets_manager->register(new \Custom_Elementor_Achievements_Gallery());
        
        // Include the Carousel Slider widget file
        require_once(__DIR__ . '/widgets/carousel-slider.php');
        $widgets_manager->register(new \Custom_Elementor_Carousel_Slider());
        
        // Include the Testimonials Marquee widget file
        require_once(__DIR__ . '/widgets/testimonials-marquee.php');
        $widgets_manager->register(new \Custom_Elementor_Testimonials_Marquee());
    });
    
    // Register Widget Styles
    add_action('elementor/frontend/after_enqueue_styles', function() {
        wp_enqueue_style('achievements-gallery', plugins_url('assets/css/achievements-gallery.css', __FILE__), [], '1.0.0');
        wp_enqueue_style('carousel-slider', plugins_url('assets/css/carousel-slider.css', __FILE__), [], '1.0.0');
        wp_enqueue_style('testimonials-marquee', plugins_url('assets/css/testimonials-marquee.css', __FILE__), [], '1.0.0');
    });
    
    // Register Widget Scripts
    add_action('elementor/frontend/after_register_scripts', function() {
        wp_register_script('achievements-gallery', plugins_url('assets/js/achievements-gallery.js', __FILE__), ['jquery'], '1.0.0', true);
        wp_register_script('carousel-slider', plugins_url('assets/js/carousel-slider.js', __FILE__), ['jquery'], '1.0.0', true);
        wp_register_script('testimonials-marquee', plugins_url('assets/js/testimonials-marquee.js', __FILE__), ['jquery'], '1.0.0', true);
    });
    
    // Enqueue editor scripts
    add_action('elementor/editor/after_enqueue_scripts', function() {
        wp_enqueue_script('achievements-gallery', plugins_url('assets/js/achievements-gallery.js', __FILE__), ['jquery'], '1.0.0', true);
        wp_enqueue_script('carousel-slider', plugins_url('assets/js/carousel-slider.js', __FILE__), ['jquery'], '1.0.0', true);
    });
}

add_action('plugins_loaded', 'custom_elementor_widgets_init');