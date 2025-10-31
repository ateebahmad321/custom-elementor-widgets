<?php
/**
 * Testimonials Marquee Widget
 * Path: /widgets/testimonials-marquee.php
 */

if (!defined('ABSPATH')) {
    exit;
}

class Custom_Elementor_Testimonials_Marquee extends \Elementor\Widget_Base {

    public function get_name() {
        return 'testimonials-marquee';
    }

    public function get_title() {
        return esc_html__('Testimonials Marquee', 'custom-elementor-widgets');
    }

    public function get_icon() {
        return 'eicon-testimonial';
    }

    public function get_categories() {
        return ['basic'];
    }

    public function get_keywords() {
        return ['testimonials', 'reviews', 'marquee', 'slider', 'clients'];
    }

    public function get_style_depends() {
        return ['testimonials-marquee'];
    }

    public function get_script_depends() {
        return ['testimonials-marquee'];
    }

    protected function register_controls() {
        
        // Testimonials Section
        $this->start_controls_section(
            'testimonials_section',
            [
                'label' => __('Testimonials', 'custom-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'platform',
            [
                'label' => __('Platform', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'upwork',
                'options' => [
                    'upwork' => __('Upwork', 'custom-elementor-widgets'),
                    'fiverr' => __('Fiverr', 'custom-elementor-widgets'),
                    'linkedin' => __('LinkedIn', 'custom-elementor-widgets'),
                    'google' => __('Google', 'custom-elementor-widgets'),
                    'facebook' => __('Facebook', 'custom-elementor-widgets'),
                    'twitter' => __('Twitter', 'custom-elementor-widgets'),
                ],
            ]
        );

        $repeater->add_control(
            'platform_logo',
            [
                'label' => __('Custom Platform Logo', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'description' => __('Optional: Upload custom platform logo (overrides default)', 'custom-elementor-widgets'),
            ]
        );

        $repeater->add_control(
            'rating',
            [
                'label' => __('Rating', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 5,
                'min' => 1,
                'max' => 5,
                'step' => 1,
            ]
        );

        $repeater->add_control(
            'testimonial_text',
            [
                'label' => __('Testimonial Text', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Great experience working together!', 'custom-elementor-widgets'),
                'rows' => 3,
            ]
        );

        $repeater->add_control(
            'client_name',
            [
                'label' => __('Client Name', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('John Doe', 'custom-elementor-widgets'),
            ]
        );

        $this->add_control(
            'testimonials_list',
            [
                'label' => __('Testimonials', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'platform' => 'upwork',
                        'rating' => 5,
                        'testimonial_text' => 'Shajeel delivered exceptional work on our e-commerce platform. His attention to detail and technical expertise made our project a huge success.',
                        'client_name' => 'Sarah Johnson',
                    ],
                    [
                        'platform' => 'fiverr',
                        'rating' => 5,
                        'testimonial_text' => 'Outstanding React developer! Built our entire frontend from scratch with beautiful animations and perfect responsiveness.',
                        'client_name' => 'Michael Chen',
                    ],
                    [
                        'platform' => 'upwork',
                        'rating' => 5,
                        'testimonial_text' => 'Shajeel\'s UI/UX skills are top-notch. He transformed our outdated website into a modern, user-friendly experience.',
                        'client_name' => 'Emily Rodriguez',
                    ],
                    [
                        'platform' => 'linkedin',
                        'rating' => 5,
                        'testimonial_text' => 'Professional, reliable, and delivers quality work on time. Highly recommend for any web development project.',
                        'client_name' => 'David Kim',
                    ],
                ],
                'title_field' => '{{{ client_name }}} - {{{ platform }}}',
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
            'rows_count',
            [
                'label' => __('Number of Rows', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '1' => __('1 Row', 'custom-elementor-widgets'),
                    '2' => __('2 Rows', 'custom-elementor-widgets'),
                    '3' => __('3 Rows', 'custom-elementor-widgets'),
                    '4' => __('4 Rows', 'custom-elementor-widgets'),
                ],
            ]
        );

        $this->add_control(
            'animation_duration',
            [
                'label' => __('Animation Duration (seconds)', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 60,
                'min' => 20,
                'max' => 120,
                'step' => 5,
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label' => __('Pause on Hover', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'custom-elementor-widgets'),
                'label_off' => __('No', 'custom-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        // Style Section - Card
        $this->start_controls_section(
            'card_style_section',
            [
                'label' => __('Card Style', 'custom-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'card_max_width',
            [
                'label' => __('Card Max Width', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 250,
                        'max' => 500,
                        'step' => 10,
                    ],
                    'rem' => [
                        'min' => 15,
                        'max' => 35,
                        'step' => 0.5,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 384,
                ],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-card' => 'max-width: {{SIZE}}{{UNIT}}; width: 100%;',
                ],
            ]
        );

        $this->add_control(
            'card_background',
            [
                'label' => __('Background Color', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .testimonial-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'card_border_color',
            [
                'label' => __('Border Color', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(0, 5, 61, 0.1)',
                'selectors' => [
                    '{{WRAPPER}} .testimonial-card' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'card_border_radius',
            [
                'label' => __('Border Radius', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'rem'],
                'default' => [
                    'unit' => 'rem',
                    'top' => 0.75,
                    'right' => 0.75,
                    'bottom' => 0.75,
                    'left' => 0.75,
                ],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'card_padding',
            [
                'label' => __('Padding', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'rem'],
                'default' => [
                    'unit' => 'rem',
                    'top' => 1,
                    'right' => 1,
                    'bottom' => 1,
                    'left' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Text
        $this->start_controls_section(
            'text_style_section',
            [
                'label' => __('Text Style', 'custom-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'testimonial_text_color',
            [
                'label' => __('Testimonial Text Color', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .testimonial-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'testimonial_typography',
                'label' => __('Testimonial Typography', 'custom-elementor-widgets'),
                'selector' => '{{WRAPPER}} .testimonial-text',
            ]
        );

        $this->add_control(
            'client_name_color',
            [
                'label' => __('Client Name Color', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .client-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'client_name_typography',
                'label' => __('Client Name Typography', 'custom-elementor-widgets'),
                'selector' => '{{WRAPPER}} .client-name',
            ]
        );

        $this->add_control(
            'platform_text_color',
            [
                'label' => __('Platform Text Color', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#6b7280',
                'selectors' => [
                    '{{WRAPPER}} .platform-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Stars
        $this->start_controls_section(
            'stars_style_section',
            [
                'label' => __('Stars Style', 'custom-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'star_color',
            [
                'label' => __('Star Color', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#facc15',
                'selectors' => [
                    '{{WRAPPER}} .star-icon' => 'fill: {{VALUE}}; color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'star_size',
            [
                'label' => __('Star Size', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 12,
                        'max' => 32,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 12,
                ],
                'selectors' => [
                    '{{WRAPPER}} .star-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $widget_id = $this->get_id();
        $rows_count = intval($settings['rows_count']);
        $testimonials = $settings['testimonials_list'];
        $animation_duration = $settings['animation_duration'];
        $pause_class = $settings['pause_on_hover'] === 'yes' ? 'group-hover:[animation-play-state:paused]' : '';

        // Platform logos mapping
        $platform_logos = [
            'upwork' => 'https://cdn.worldvectorlogo.com/logos/upwork-1.svg',
            'fiverr' => 'https://cdn.worldvectorlogo.com/logos/fiverr-1.svg',
            'linkedin' => 'https://cdn.worldvectorlogo.com/logos/linkedin-icon-2.svg',
            'google' => 'https://cdn.worldvectorlogo.com/logos/google-icon.svg',
            'facebook' => 'https://cdn.worldvectorlogo.com/logos/facebook-2.svg',
            'twitter' => 'https://cdn.worldvectorlogo.com/logos/twitter-6.svg',
        ];

        // Calculate testimonials per row
        $total_testimonials = count($testimonials);
        $per_row = ceil($total_testimonials / $rows_count);
        $rows = array_chunk($testimonials, $per_row);
        ?>

        <div class="testimonials-marquee-wrapper" id="testimonials-<?php echo esc_attr($widget_id); ?>" style="--duration: <?php echo esc_attr($animation_duration); ?>s; --gap: 1rem;">
            <div class="testimonials-marquee-container">
                <?php foreach ($rows as $row_index => $row_testimonials) : 
                    $reverse_class = ($row_index % 2 !== 0) ? '[animation-direction:reverse]' : '';
                    $row_mt = ($row_index > 0) ? 'mt-4' : '';
                ?>
                <div class="group flex overflow-hidden p-2 flex-row <?php echo esc_attr($row_mt); ?>" style="gap: var(--gap);">
                    <?php 
                    // Render testimonials 2 times for infinite loop
                    for ($i = 0; $i < 2; $i++) : 
                    ?>
                    <div class="flex shrink-0 justify-around animate-marquee flex-row <?php echo esc_attr($pause_class); ?> <?php echo esc_attr($reverse_class); ?>" style="gap: var(--gap);">
                        <?php foreach ($row_testimonials as $testimonial) : 
                            $platform_logo = !empty($testimonial['platform_logo']['url']) 
                                ? $testimonial['platform_logo']['url'] 
                                : $platform_logos[$testimonial['platform']];
                            $initials = $this->get_initials($testimonial['client_name']);
                        ?>
                        <div class="testimonial-card relative cursor-pointer overflow-hidden rounded-xl border p-4">
                            <div class="flex flex-col gap-3">
                                <!-- Platform and Rating -->
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <img alt="<?php echo esc_attr($testimonial['platform']); ?>" 
                                             loading="lazy" 
                                             width="20" 
                                             height="20" 
                                             class="rounded-sm" 
                                             src="<?php echo esc_url($platform_logo); ?>">
                                        <span class="platform-name text-sm font-medium capitalize"><?php echo esc_html($testimonial['platform']); ?></span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <?php for ($j = 0; $j < intval($testimonial['rating']); $j++) : ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="star-icon h-3 w-3" aria-hidden="true">
                                            <path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"></path>
                                        </svg>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                
                                <!-- Testimonial Text -->
                                <blockquote class="testimonial-text text-sm leading-relaxed">"<?php echo esc_html($testimonial['testimonial_text']); ?>"</blockquote>
                                
                                <!-- Client Info -->
                                <div class="flex items-center gap-2">
                                    <div class="h-8 w-8 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center">
                                        <span class="text-xs font-semibold text-white"><?php echo esc_html($initials); ?></span>
                                    </div>
                                    <div>
                                        <div class="client-name font-semibold text-sm"><?php echo esc_html($testimonial['client_name']); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endfor; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }

    private function get_initials($name) {
        $words = explode(' ', trim($name));
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        return strtoupper(substr($name, 0, 2));
    }
}