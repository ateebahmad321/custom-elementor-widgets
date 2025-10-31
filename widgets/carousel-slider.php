<?php
/**
 * Carousel Slider Widget
 * Path: /widgets/carousel-slider.php
 */

if (!defined('ABSPATH')) {
    exit;
}

class Custom_Elementor_Carousel_Slider extends \Elementor\Widget_Base {

    public function get_name() {
        return 'carousel-slider';
    }

    public function get_title() {
        return esc_html__('Carousel Slider', 'custom-elementor-widgets');
    }

    public function get_icon() {
        return 'eicon-slider-push';
    }

    public function get_categories() {
        return ['basic'];
    }

    public function get_keywords() {
        return ['carousel', 'slider', 'gallery', 'loop', 'autoplay'];
    }

    public function get_style_depends() {
        return ['carousel-slider'];
    }

    public function get_script_depends() {
        return ['carousel-slider'];
    }

    protected function register_controls() {
        
        // Carousel Items Section
        $this->start_controls_section(
            'carousel_section',
            [
                'label' => __('Carousel Items', 'custom-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'slide_image',
            [
                'label' => __('Slide Image', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'slide_link',
            [
                'label' => __('Link', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'custom-elementor-widgets'),
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
            'carousel_items',
            [
                'label' => __('Carousel Items', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'slide_image' => ['url' => \Elementor\Utils::get_placeholder_image_src()],
                        'slide_link' => ['url' => '#'],
                    ],
                    [
                        'slide_image' => ['url' => \Elementor\Utils::get_placeholder_image_src()],
                        'slide_link' => ['url' => '#'],
                    ],
                    [
                        'slide_image' => ['url' => \Elementor\Utils::get_placeholder_image_src()],
                        'slide_link' => ['url' => '#'],
                    ],
                    [
                        'slide_image' => ['url' => \Elementor\Utils::get_placeholder_image_src()],
                        'slide_link' => ['url' => '#'],
                    ],
                ],
                'title_field' => 'Slide',
            ]
        );

        $this->end_controls_section();

        // Settings Section
        $this->start_controls_section(
            'settings_section',
            [
                'label' => __('Settings', 'custom-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => __('Autoplay', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'custom-elementor-widgets'),
                'label_off' => __('No', 'custom-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label' => __('Autoplay Speed (ms)', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 3000,
                'min' => 1000,
                'max' => 10000,
                'step' => 500,
                'condition' => [
                    'autoplay' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Carousel
        $this->start_controls_section(
            'carousel_style_section',
            [
                'label' => __('Carousel Style', 'custom-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'slide_height',
            [
                'label' => __('Slide Height', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 800,
                        'step' => 10,
                    ],
                    'rem' => [
                        'min' => 10,
                        'max' => 50,
                        'step' => 0.5,
                    ],
                ],
                'default' => [
                    'unit' => 'rem',
                    'size' => 25,
                ],
                'selectors' => [
                    '{{WRAPPER}} .banner-carousel-item' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'slide_width',
            [
                'label' => __('Slide Width', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 600,
                        'step' => 10,
                    ],
                    'rem' => [
                        'min' => 10,
                        'max' => 40,
                        'step' => 0.5,
                    ],
                ],
                'default' => [
                    'unit' => 'rem',
                    'size' => 18.75,
                ],
                'selectors' => [
                    '{{WRAPPER}} .banner-carousel-item' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'slide_border_radius',
            [
                'label' => __('Border Radius', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'rem'],
                'default' => [
                    'unit' => 'rem',
                    'top' => 1.25,
                    'right' => 1.25,
                    'bottom' => 1.25,
                    'left' => 1.25,
                ],
                'selectors' => [
                    '{{WRAPPER}} .banner-carousel-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Controls
        $this->start_controls_section(
            'controls_style_section',
            [
                'label' => __('Controls Style', 'custom-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'button_bg_color',
            [
                'label' => __('Button Background Color', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#e6f0ff',
                'selectors' => [
                    '{{WRAPPER}} .zt-carousel__button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => __('Button Icon Color', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#00053D',
                'selectors' => [
                    '{{WRAPPER}} .zt-carousel__button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'dot_color',
            [
                'label' => __('Dot Color', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#d1def2',
                'selectors' => [
                    '{{WRAPPER}} .zt-carousel__dot::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'dot_active_color',
            [
                'label' => __('Active Dot Color', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#00053d',
                'selectors' => [
                    '{{WRAPPER}} .zt-carousel__dot--selected::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $widget_id = $this->get_id();
        $autoplay = $settings['autoplay'] === 'yes' ? 'true' : 'false';
        $autoplay_speed = $settings['autoplay_speed'] ? $settings['autoplay_speed'] : 3000;
        ?>
        <div class="banner-carousel-container">
            <div class="zt-carousel" id="carousel-<?php echo esc_attr($widget_id); ?>" 
                 data-autoplay="<?php echo esc_attr($autoplay); ?>"
                 data-autoplay-speed="<?php echo esc_attr($autoplay_speed); ?>">
                <div class="zt-carousel__viewport">
                    <div class="zt-carousel__container" id="carouselContainer-<?php echo esc_attr($widget_id); ?>">
                        <?php foreach ($settings['carousel_items'] as $index => $item) : 
                            $target = $item['slide_link']['is_external'] ? '_blank' : '_self';
                            $nofollow = $item['slide_link']['nofollow'] ? 'rel="nofollow"' : '';
                        ?>
                        <div class="banner-carousel">
                            <a class="banner-carousel-item" 
                               style="background-image: url('<?php echo esc_url($item['slide_image']['url']); ?>');"
                               href="<?php echo esc_url($item['slide_link']['url']); ?>"
                               target="<?php echo esc_attr($target); ?>"
                               <?php echo $nofollow; ?>>
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="zt-carousel__controls">
                    <div class="zt-carousel__buttons">
                        <button class="zt-carousel__button zt-carousel__button--prev" type="button" id="prevBtn-<?php echo esc_attr($widget_id); ?>">
                            <svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.5859 7.19824H1.8185" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M7.73438 1.29102L1.8274 7.19799L7.73438 13.105" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        
                        <div class="zt-carousel__dots" id="dotsContainer-<?php echo esc_attr($widget_id); ?>"></div>
                        
                        <button class="zt-carousel__button zt-carousel__button--next" type="button" id="nextBtn-<?php echo esc_attr($widget_id); ?>">
                            <svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.41406 7.19824H16.1815" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M10.2656 1.29102L16.1726 7.19799L10.2656 13.105" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}