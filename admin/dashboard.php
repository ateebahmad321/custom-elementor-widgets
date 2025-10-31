<?php
/**
 * Admin Dashboard Page
 * Path: /admin/dashboard.php
 */

if (!defined('ABSPATH')) {
    exit;
}

// Handle form submission
if (isset($_POST['cew_save_settings']) && check_admin_referer('cew_settings_action', 'cew_settings_nonce')) {
    $enabled_widgets = isset($_POST['cew_enabled_widgets']) ? array_map('sanitize_text_field', $_POST['cew_enabled_widgets']) : [];
    $load_optimization = isset($_POST['cew_load_optimization']) ? sanitize_text_field($_POST['cew_load_optimization']) : 'all';
    
    update_option('cew_enabled_widgets', $enabled_widgets);
    update_option('cew_load_optimization', $load_optimization);
    
    echo '<div class="notice notice-success is-dismissible"><p>Settings saved successfully!</p></div>';
}

$widgets = custom_elementor_widgets()->get_widgets();
$enabled_widgets = get_option('cew_enabled_widgets', array_keys($widgets));
$load_optimization = get_option('cew_load_optimization', 'all');
?>

<div class="wrap cew-dashboard">
    <div class="cew-header">
        <h1 class="cew-title">
            <span class="dashicons dashicons-layout"></span>
            Custom Elementor Widgets
        </h1>
        <p class="cew-subtitle">Manage your custom Elementor widgets and settings</p>
    </div>

    <form method="post" action="" class="cew-form">
        <?php wp_nonce_field('cew_settings_action', 'cew_settings_nonce'); ?>
        
        <div class="cew-stats-grid">
            <div class="cew-stat-card">
                <div class="cew-stat-icon">
                    <span class="dashicons dashicons-admin-plugins"></span>
                </div>
                <div class="cew-stat-content">
                    <div class="cew-stat-number"><?php echo count($widgets); ?></div>
                    <div class="cew-stat-label">Total Widgets</div>
                </div>
            </div>
            
            <div class="cew-stat-card cew-stat-success">
                <div class="cew-stat-icon">
                    <span class="dashicons dashicons-yes-alt"></span>
                </div>
                <div class="cew-stat-content">
                    <div class="cew-stat-number"><?php echo count($enabled_widgets); ?></div>
                    <div class="cew-stat-label">Active Widgets</div>
                </div>
            </div>
            
            <div class="cew-stat-card cew-stat-warning">
                <div class="cew-stat-icon">
                    <span class="dashicons dashicons-dismiss"></span>
                </div>
                <div class="cew-stat-content">
                    <div class="cew-stat-number"><?php echo count($widgets) - count($enabled_widgets); ?></div>
                    <div class="cew-stat-label">Inactive Widgets</div>
                </div>
            </div>
            
            <div class="cew-stat-card cew-stat-info">
                <div class="cew-stat-icon">
                    <span class="dashicons dashicons-info"></span>
                </div>
                <div class="cew-stat-content">
                    <div class="cew-stat-number">v<?php echo CEW_VERSION; ?></div>
                    <div class="cew-stat-label">Plugin Version</div>
                </div>
            </div>
        </div>

        <div class="cew-content-grid">
            <!-- Widgets Management -->
            <div class="cew-section">
                <div class="cew-section-header">
                    <h2>
                        <span class="dashicons dashicons-admin-tools"></span>
                        Widget Management
                    </h2>
                    <p>Enable or disable widgets to optimize performance</p>
                </div>

                <div class="cew-bulk-actions">
                    <button type="button" class="button cew-bulk-btn" id="cew-enable-all">
                        <span class="dashicons dashicons-yes"></span> Enable All
                    </button>
                    <button type="button" class="button cew-bulk-btn" id="cew-disable-all">
                        <span class="dashicons dashicons-no"></span> Disable All
                    </button>
                </div>

                <div class="cew-widgets-list">
                    <?php foreach ($widgets as $widget_key => $widget_data) : 
                        $is_enabled = in_array($widget_key, $enabled_widgets);
                        $status_class = $is_enabled ? 'cew-widget-enabled' : 'cew-widget-disabled';
                    ?>
                    <div class="cew-widget-card <?php echo $status_class; ?>">
                        <div class="cew-widget-header">
                            <div class="cew-widget-icon">
                                <i class="eicon <?php echo esc_attr($widget_data['icon']); ?>"></i>
                            </div>
                            <div class="cew-widget-info">
                                <h3><?php echo esc_html($widget_data['title']); ?></h3>
                                <p><?php echo esc_html($widget_data['description']); ?></p>
                            </div>
                            <div class="cew-widget-toggle">
                                <label class="cew-switch">
                                    <input 
                                        type="checkbox" 
                                        name="cew_enabled_widgets[]" 
                                        value="<?php echo esc_attr($widget_key); ?>"
                                        <?php checked($is_enabled); ?>
                                        class="cew-widget-checkbox"
                                    >
                                    <span class="cew-slider"></span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="cew-widget-meta">
                            <span class="cew-widget-badge <?php echo $is_enabled ? 'cew-badge-success' : 'cew-badge-disabled'; ?>">
                                <?php echo $is_enabled ? 'Active' : 'Inactive'; ?>
                            </span>
                            <div class="cew-widget-assets">
                                <?php if (!empty($widget_data['css'])) : ?>
                                <span class="cew-asset-badge">
                                    <span class="dashicons dashicons-media-code"></span>
                                    <?php echo count($widget_data['css']); ?> CSS
                                </span>
                                <?php endif; ?>
                                <?php if (!empty($widget_data['js'])) : ?>
                                <span class="cew-asset-badge">
                                    <span class="dashicons dashicons-media-code"></span>
                                    <?php echo count($widget_data['js']); ?> JS
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Settings Panel -->
            <div class="cew-sidebar">
                <div class="cew-section">
                    <div class="cew-section-header">
                        <h2>
                            <span class="dashicons dashicons-admin-settings"></span>
                            Settings
                        </h2>
                    </div>

                    <div class="cew-settings-group">
                        <h3>Load Optimization</h3>
                        <p class="description">Control when widget assets are loaded</p>
                        
                        <label class="cew-radio-label">
                            <input 
                                type="radio" 
                                name="cew_load_optimization" 
                                value="all" 
                                <?php checked($load_optimization, 'all'); ?>
                            >
                            <div class="cew-radio-content">
                                <strong>Load All Pages</strong>
                                <span>Load assets on all pages (default)</span>
                            </div>
                        </label>
                        
                        <label class="cew-radio-label">
                            <input 
                                type="radio" 
                                name="cew_load_optimization" 
                                value="conditional" 
                                <?php checked($load_optimization, 'conditional'); ?>
                            >
                            <div class="cew-radio-content">
                                <strong>Conditional Loading</strong>
                                <span>Load only when widget is used</span>
                            </div>
                        </label>
                    </div>

                    <div class="cew-settings-group">
                        <h3>Quick Actions</h3>
                        <a href="<?php echo admin_url('admin.php?page=elementor#tab-general'); ?>" class="button button-secondary" style="width: 100%; text-align: center; margin-bottom: 10px;">
                            <span class="dashicons dashicons-elementor"></span>
                            Elementor Settings
                        </a>
                        <button type="button" class="button button-secondary" id="cew-clear-cache" style="width: 100%;">
                            <span class="dashicons dashicons-update"></span>
                            Clear Widget Cache
                        </button>
                    </div>
                </div>

                <div class="cew-section">
                    <div class="cew-section-header">
                        <h2>
                            <span class="dashicons dashicons-sos"></span>
                            Support & Info
                        </h2>
                    </div>

                    <div class="cew-info-box">
                        <h4>Need Help?</h4>
                        <p>Check the documentation or contact support for assistance.</p>
                        <a href="#" class="button button-link" target="_blank">View Documentation</a>
                    </div>

                    <div class="cew-info-box">
                        <h4>System Info</h4>
                        <ul class="cew-system-info">
                            <li><strong>PHP Version:</strong> <?php echo PHP_VERSION; ?></li>
                            <li><strong>WordPress:</strong> <?php echo get_bloginfo('version'); ?></li>
                            <li><strong>Elementor:</strong> <?php echo defined('ELEMENTOR_VERSION') ? ELEMENTOR_VERSION : 'Not installed'; ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="cew-footer">
            <button type="submit" name="cew_save_settings" class="button button-primary button-large">
                <span class="dashicons dashicons-saved"></span>
                Save Changes
            </button>
            <a href="<?php echo admin_url('admin.php?page=custom-elementor-widgets'); ?>" class="button button-secondary button-large">
                <span class="dashicons dashicons-update"></span>
                Reset
            </a>
        </div>
    </form>
</div>