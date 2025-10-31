<?php
/**
 * Plugin Name: Custom Elementor Widgets
 * Description: Custom Elementor widgets including Achievements Gallery, Carousel Slider, Testimonials Marquee and more with Admin Dashboard
 * Version: 2.0.0
 * Author: Your Name
 * Text Domain: custom-elementor-widgets
 * Elementor tested up to: 3.21.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('CEW_VERSION', '2.0.0');
define('CEW_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CEW_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Main Plugin Class
 */
class Custom_Elementor_Widgets {
    
    private static $instance = null;
    private $widgets = [];
    
    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function __construct() {
        // Define available widgets
        $this->define_widgets();
        
        // Initialize plugin
        add_action('plugins_loaded', [$this, 'init']);
        
        // Admin menu and settings
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_init', [$this, 'register_settings']);
        
        // Enqueue admin styles
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
    }
    
    private function define_widgets() {
        $this->widgets = [
            'achievements-gallery' => [
                'title' => 'Achievements Gallery',
                'description' => 'Showcase company achievements with an interactive hover gallery',
                'file' => 'widgets/achievements-gallery.php',
                'class' => 'Custom_Elementor_Achievements_Gallery',
                'icon' => 'eicon-gallery-group',
                'css' => ['achievements-gallery'],
                'js' => ['achievements-gallery'],
            ],
            'carousel-slider' => [
                'title' => 'Carousel Slider',
                'description' => 'Infinite loop carousel with autoplay and navigation',
                'file' => 'widgets/carousel-slider.php',
                'class' => 'Custom_Elementor_Carousel_Slider',
                'icon' => 'eicon-slider-push',
                'css' => ['carousel-slider'],
                'js' => ['carousel-slider'],
            ],
            'testimonials-marquee' => [
                'title' => 'Testimonials Marquee',
                'description' => 'Animated testimonials marquee with multiple rows',
                'file' => 'widgets/testimonials-marquee.php',
                'class' => 'Custom_Elementor_Testimonials_Marquee',
                'icon' => 'eicon-testimonial',
                'css' => ['testimonials-marquee'],
                'js' => ['testimonials-marquee'],
            ],
        ];
    }
    
    public function init() {
        // Check if Elementor is installed and activated
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'elementor_missing_notice']);
            return;
        }
        
        // Register widgets
        add_action('elementor/widgets/register', [$this, 'register_widgets']);
        
        // Register styles
        add_action('elementor/frontend/after_enqueue_styles', [$this, 'enqueue_frontend_styles']);
        
        // Register scripts
        add_action('elementor/frontend/after_register_scripts', [$this, 'register_frontend_scripts']);
        
        // Enqueue editor scripts
        add_action('elementor/editor/after_enqueue_scripts', [$this, 'enqueue_editor_scripts']);
    }
    
    public function elementor_missing_notice() {
        echo '<div class="notice notice-warning is-dismissible">';
        echo '<p><strong>Custom Elementor Widgets</strong> requires <strong>Elementor</strong> to be installed and activated.</p>';
        echo '</div>';
    }
    
    public function register_widgets($widgets_manager) {
        $enabled_widgets = get_option('cew_enabled_widgets', array_keys($this->widgets));
        
        foreach ($this->widgets as $widget_key => $widget_data) {
            if (in_array($widget_key, $enabled_widgets)) {
                $file_path = CEW_PLUGIN_DIR . $widget_data['file'];
                
                if (file_exists($file_path)) {
                    require_once($file_path);
                    
                    if (class_exists($widget_data['class'])) {
                        $widgets_manager->register(new $widget_data['class']());
                    }
                }
            }
        }
    }
    
    public function enqueue_frontend_styles() {
        $enabled_widgets = get_option('cew_enabled_widgets', array_keys($this->widgets));
        
        foreach ($this->widgets as $widget_key => $widget_data) {
            if (in_array($widget_key, $enabled_widgets) && !empty($widget_data['css'])) {
                foreach ($widget_data['css'] as $css_file) {
                    wp_enqueue_style(
                        $css_file,
                        CEW_PLUGIN_URL . "assets/css/{$css_file}.css",
                        [],
                        CEW_VERSION
                    );
                }
            }
        }
    }
    
    public function register_frontend_scripts() {
        $enabled_widgets = get_option('cew_enabled_widgets', array_keys($this->widgets));
        
        foreach ($this->widgets as $widget_key => $widget_data) {
            if (in_array($widget_key, $enabled_widgets) && !empty($widget_data['js'])) {
                foreach ($widget_data['js'] as $js_file) {
                    wp_register_script(
                        $js_file,
                        CEW_PLUGIN_URL . "assets/js/{$js_file}.js",
                        ['jquery'],
                        CEW_VERSION,
                        true
                    );
                }
            }
        }
    }
    
    public function enqueue_editor_scripts() {
        $enabled_widgets = get_option('cew_enabled_widgets', array_keys($this->widgets));
        
        foreach ($this->widgets as $widget_key => $widget_data) {
            if (in_array($widget_key, $enabled_widgets) && !empty($widget_data['js'])) {
                foreach ($widget_data['js'] as $js_file) {
                    wp_enqueue_script(
                        $js_file,
                        CEW_PLUGIN_URL . "assets/js/{$js_file}.js",
                        ['jquery'],
                        CEW_VERSION,
                        true
                    );
                }
            }
        }
    }
    
    public function add_admin_menu() {
        add_menu_page(
            __('Custom Widgets', 'custom-elementor-widgets'),
            __('Custom Widgets', 'custom-elementor-widgets'),
            'manage_options',
            'custom-elementor-widgets',
            [$this, 'render_admin_page'],
            'dashicons-layout',
            59
        );
    }
    
    public function register_settings() {
        register_setting('cew_settings', 'cew_enabled_widgets');
        register_setting('cew_settings', 'cew_load_optimization');
    }
    
    public function enqueue_admin_assets($hook) {
        if ($hook !== 'toplevel_page_custom-elementor-widgets') {
            return;
        }
        
        wp_enqueue_style(
            'cew-admin-styles',
            CEW_PLUGIN_URL . 'assets/css/admin-dashboard.css',
            [],
            CEW_VERSION
        );
        
        wp_enqueue_script(
            'cew-admin-script',
            CEW_PLUGIN_URL . 'assets/js/admin-dashboard.js',
            ['jquery'],
            CEW_VERSION,
            true
        );
    }
    
    public function render_admin_page() {
        include CEW_PLUGIN_DIR . 'admin/dashboard.php';
    }
    
    public function get_widgets() {
        return $this->widgets;
    }
}

// Initialize plugin
function custom_elementor_widgets() {
    return Custom_Elementor_Widgets::instance();
}

// Kick off
custom_elementor_widgets();