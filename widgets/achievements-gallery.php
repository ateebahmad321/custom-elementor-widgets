<?php
/**
 * Achievements Gallery Widget
 * Path: /widgets/achievements-gallery.php
 */

if (!defined('ABSPATH')) {
    exit;
}

class Custom_Elementor_Achievements_Gallery extends \Elementor\Widget_Base {

    public function get_name() {
        return 'achievements-gallery';
    }

    public function get_title() {
        return esc_html__('Achievements Gallery', 'custom-elementor-widgets');
    }

    public function get_icon() {
        return 'eicon-gallery-group';
    }

    public function get_categories() {
        return ['basic'];
    }

    public function get_keywords() {
        return ['achievements', 'gallery', 'showcase', 'portfolio', 'custom'];
    }

    public function get_style_depends() {
        return ['achievements-gallery'];
    }

    public function get_script_depends() {
        return ['achievements-gallery'];
    }

    protected function register_controls() {
        
        // Header Section
        $this->start_controls_section(
            'header_section',
            [
                'label' => __('Header', 'custom-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'badge_icon',
            [
                'label' => __('Badge Icon', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => 'https://media.zoom.com/images/assets/blue-dot.svg/Zz0xYzc3ZTkyODYwNzYxMWYwOTBmNTQ2NjhmMmZjODQ3ZA==',
                ],
            ]
        );

        $this->add_control(
            'badge_text',
            [
                'label' => __('Badge Text', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Customer stories', 'custom-elementor-widgets'),
            ]
        );

        $this->add_control(
            'main_title',
            [
                'label' => __('Main Title', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Companies are achieving more with Zoom', 'custom-elementor-widgets'),
            ]
        );

        $this->end_controls_section();

        // Gallery Items Section
        $this->start_controls_section(
            'gallery_section',
            [
                'label' => __('Gallery Items', 'custom-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'company_logo',
            [
                'label' => __('Company Logo', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'background_image',
            [
                'label' => __('Background Image', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'item_title',
            [
                'label' => __('Title', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Item Title', 'custom-elementor-widgets'),
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label' => __('Description', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Description text goes here', 'custom-elementor-widgets'),
            ]
        );

        $repeater->add_control(
            'author_name',
            [
                'label' => __('Author Name', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('John Doe', 'custom-elementor-widgets'),
            ]
        );

        $repeater->add_control(
            'author_title',
            [
                'label' => __('Author Title/Position', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('CEO', 'custom-elementor-widgets'),
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => __('Link', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'custom-elementor-widgets'),
            ]
        );

        $this->add_control(
            'gallery_items',
            [
                'label' => __('Gallery Items', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'item_title' => __('Major League Baseball™ and Zoom expand the employee-fan experience', 'custom-elementor-widgets'),
                        'company_logo' => ['url' => 'https://st1.zoom.us/homepage/publish/primary/assets/img/achievements/baseball-club-logo.svg'],
                        'background_image' => ['url' => 'https://st1.zoom.us/homepage/publish/primary/assets/img/achievements/baseball-club-bg.png'],
                        'description' => __('Zoom has allowed us to continue a tradition of really being a technology-focused company.', 'custom-elementor-widgets'),
                        'author_name' => __('Noah Garden', 'custom-elementor-widgets'),
                        'author_title' => __('Chief Revenue Officer', 'custom-elementor-widgets'),
                    ],
                ],
                'title_field' => '{{{ item_title }}}',
            ]
        );

        $this->end_controls_section();

        // Style Section - Header
        $this->start_controls_section(
            'header_style_section',
            [
                'label' => __('Header Style', 'custom-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'badge_bg_color',
            [
                'label' => __('Badge Background Color', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .achievements-title-badge' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'badge_text_color',
            [
                'label' => __('Badge Text Color', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#0b5cff',
                'selectors' => [
                    '{{WRAPPER}} .achievements-title-badge-text' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'main_title_color',
            [
                'label' => __('Main Title Color', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#00053d',
                'selectors' => [
                    '{{WRAPPER}} .achievements-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'main_title_typography',
                'label' => __('Main Title Typography', 'custom-elementor-widgets'),
                'selector' => '{{WRAPPER}} .achievements-title',
            ]
        );

        $this->end_controls_section();

        // Style Section - Gallery Items
        $this->start_controls_section(
            'gallery_style_section',
            [
                'label' => __('Gallery Items Style', 'custom-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'item_title_color',
            [
                'label' => __('Item Title Color', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .achievements-image-gallery-title' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .achievements-mobile-content-text h3' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => __('Description Color', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .achievements-image-gallery-description p' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .achievements-mobile-content-right p' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_bg_color',
            [
                'label' => __('Button Background Color', 'custom-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#0b5cff',
                'selectors' => [
                    '{{WRAPPER}} .achievements-mobile-button' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .achievements-image-gallery-arrow-button:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="zt-achievements">
            <div class="achievements-title-container">
                <div class="achievements-title-badge">
                    <div class="achievements-title-badge-icon">
                        <img src="<?php echo esc_url($settings['badge_icon']['url']); ?>" 
                             alt="<?php echo esc_attr($settings['badge_text']); ?>" 
                             loading="lazy">
                    </div>
                    <div class="achievements-title-badge-text"><?php echo esc_html($settings['badge_text']); ?></div>
                </div>
                <div class="achievements-title"><?php echo esc_html($settings['main_title']); ?></div>
            </div>

            <!-- Desktop Gallery -->
            <div class="achievements-image-gallery-container is-desktop">
                <div class="achievements-image-gallery" id="achievementsImageGallery-<?php echo $this->get_id(); ?>">
                    <?php foreach ($settings['gallery_items'] as $index => $item) : 
                        $active_class = ($index === 0) ? 'achievements-image-gallery-active' : '';
                        $item_id = 'item-' . $index;
                    ?>
                    <div class="achievements-image-gallery-item <?php echo $active_class; ?>" 
                         data-index="<?php echo $item_id; ?>"
                         style="background-image: url('<?php echo esc_url($item['background_image']['url']); ?>');">
                        <?php if (!empty($item['link']['url'])) : 
                            $target = $item['link']['is_external'] ? '_blank' : '_self';
                            $nofollow = $item['link']['nofollow'] ? 'rel="nofollow"' : '';
                        ?>
                        <a href="<?php echo esc_url($item['link']['url']); ?>" 
                           class="achievements-image-gallery-link" 
                           target="<?php echo $target; ?>"
                           <?php echo $nofollow; ?>
                           title="Read more">
                            <span class="visually-hidden">Read more</span>
                        </a>
                        <?php endif; ?>
                        <img src="<?php echo esc_url($item['background_image']['url']); ?>" 
                             alt="<?php echo esc_attr($item['item_title']); ?>" 
                             class="achievements-image-gallery-active-image">
                        <div class="achievements-image-gallery-content">
                            <img src="<?php echo esc_url($item['company_logo']['url']); ?>" 
                                 alt="<?php echo esc_attr($item['item_title']); ?>" 
                                 class="achievements-image-gallery-logo">
                            <h3 class="achievements-image-gallery-title"><?php echo esc_html($item['item_title']); ?></h3>
                            <div class="achievements-image-gallery-description">
                                <p><?php echo esc_html($item['description']); ?></p>
                                <?php if (!empty($item['author_name'])) : ?>
                                <p>- <strong><?php echo esc_html($item['author_name']); ?></strong><?php echo !empty($item['author_title']) ? ', ' . esc_html($item['author_title']) : ''; ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if (!empty($item['link']['url'])) : ?>
                        <button class="achievements-image-gallery-arrow-button" data-id="<?php echo $item_id; ?>">
                            <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 15L15 5M15 5H9M15 5V11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Mobile Version -->
            <div class="achievements-mobile-section is-non-desktop">
                <div class="achievements-mobile-tab-header">
                    <div class="achievements-mobile-tab-nav" id="mobileTabNav-<?php echo $this->get_id(); ?>">
                        <?php foreach ($settings['gallery_items'] as $index => $item) : 
                            $active_class = ($index === 0) ? 'achievements-mobile-item-active' : '';
                            $item_id = 'item-' . $index;
                        ?>
                        <div class="achievements-mobile-tab-row">
                            <button data-tab="<?php echo $item_id; ?>" class="achievements-mobile-tab-item <?php echo $active_class; ?>">
                                <img class="achievements-mobile-tab-item__logo" 
                                     src="<?php echo esc_url($item['company_logo']['url']); ?>" 
                                     alt="<?php echo esc_attr($item['item_title']); ?>">
                            </button>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <?php foreach ($settings['gallery_items'] as $index => $item) : 
                    $active_class = ($index === 0) ? 'achievements-mobile-item-active' : '';
                    $item_id = 'item-' . $index;
                ?>
                <div class="achievements-mobile-content <?php echo $active_class; ?>" id="<?php echo $item_id; ?>-mobile">
                    <div class="achievements-mobile-content-left" 
                         style="background-image: url('<?php echo esc_url($item['background_image']['url']); ?>');">
                        <div class="achievements-mobile-content-text">
                            <h3><?php echo esc_html($item['item_title']); ?></h3>
                            <?php if (!empty($item['link']['url'])) : 
                                $target = $item['link']['is_external'] ? '_blank' : '_self';
                                $nofollow = $item['link']['nofollow'] ? 'rel="nofollow"' : '';
                            ?>
                            <a class="achievements-mobile-button" 
                               href="<?php echo esc_url($item['link']['url']); ?>" 
                               target="<?php echo $target; ?>"
                               <?php echo $nofollow; ?>>
                                <span>Read more</span>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="achievements-mobile-content-right">
                        <p><?php echo esc_html($item['description']); ?></p>
                        <?php if (!empty($item['author_name'])) : ?>
                        <p>- <strong><?php echo esc_html($item['author_name']); ?></strong><?php echo !empty($item['author_title']) ? ', ' . esc_html($item['author_title']) : ''; ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }

    protected function content_template() {
        ?>
        <# 
        var widgetId = 'widget-' + view.getID();
        #>
        <div class="zt-achievements">
            <div class="achievements-title-container">
                <div class="achievements-title-badge">
                    <div class="achievements-title-badge-icon">
                        <img src="{{{ settings.badge_icon.url }}}" alt="{{{ settings.badge_text }}}" loading="lazy">
                    </div>
                    <div class="achievements-title-badge-text">{{{ settings.badge_text }}}</div>
                </div>
                <div class="achievements-title">{{{ settings.main_title }}}</div>
            </div>

            <div class="achievements-image-gallery-container is-desktop">
                <div class="achievements-image-gallery" id="achievementsImageGallery-{{{ widgetId }}}">
                    <# _.each(settings.gallery_items, function(item, index) { 
                        var activeClass = (index === 0) ? 'achievements-image-gallery-active' : '';
                        var itemId = 'item-' + index;
                    #>
                    <div class="achievements-image-gallery-item {{{ activeClass }}}" 
                         data-index="{{{ itemId }}}"
                         style="background-image: url('{{{ item.background_image.url }}}');">
                        <# if (item.link && item.link.url) { #>
                        <a href="{{{ item.link.url }}}" class="achievements-image-gallery-link" title="Read more">
                            <span class="visually-hidden">Read more</span>
                        </a>
                        <# } #>
                        <img src="{{{ item.background_image.url }}}" alt="{{{ item.item_title }}}" class="achievements-image-gallery-active-image">
                        <div class="achievements-image-gallery-content">
                            <img src="{{{ item.company_logo.url }}}" alt="{{{ item.item_title }}}" class="achievements-image-gallery-logo">
                            <h3 class="achievements-image-gallery-title">{{{ item.item_title }}}</h3>
                            <div class="achievements-image-gallery-description">
                                <p>{{{ item.description }}}</p>
                                <# if (item.author_name) { #>
                                <p>- <strong>{{{ item.author_name }}}</strong><# if (item.author_title) { #>, {{{ item.author_title }}}<# } #></p>
                                <# } #>
                            </div>
                        </div>
                        <# if (item.link && item.link.url) { #>
                        <button class="achievements-image-gallery-arrow-button" data-id="{{{ itemId }}}">
                            <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 15L15 5M15 5H9M15 5V11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <# } #>
                    </div>
                    <# }); #>
                </div>
            </div>
        </div>
        <?php
    }
}