<?php
// Add settings page
function dpp_add_admin_menu() {
    add_options_page('Demo Popup Plugin', 'Demo Popup Plugin', 'manage_options', 'demo-popup-plugin', 'dpp_options_page');
}
add_action('admin_menu', 'dpp_add_admin_menu');

// Register settings
function dpp_settings_init() {
    // Define default values
    $default_settings = array(
        'dpp_modal_color' => '#333333',
        'dpp_reload_icon' => plugins_url('img/reload.png', __FILE__),
        'dpp_close_icon' => plugins_url('img/close.png', __FILE__),
        'dpp_link_button_color' => '#0155be',
        'dpp_link_button_text_color' => '#FFFFFF',
        'dpp_link_button_hover_color' => '#296cbf',
        'dpp_modal_button_color' => '#d60202',
        'dpp_modal_button_text_color' => '#FFFFFF',
        'dpp_modal_button_hover_color' => '#ce2c2c'
    );

    // Register each setting and set the default value if it's not already set
    foreach ($default_settings as $setting => $default) {
        register_setting('pluginPage', $setting);
        if (get_option($setting) === false) {
            update_option($setting, $default);
        }
    }

    add_settings_section(
        'dpp_pluginPage_section',
        __('Settings', 'wordpress'),
        null,
        'pluginPage'
    );

    add_settings_field(
        'dpp_modal_color',
        __('Popup Background Color', 'wordpress'),
        'dpp_modal_color_render',
        'pluginPage',
        'dpp_pluginPage_section'
    );

    add_settings_field(
        'dpp_reload_icon',
        __('Reload Icon', 'wordpress'),
        'dpp_reload_icon_render',
        'pluginPage',
        'dpp_pluginPage_section'
    );

    add_settings_field(
        'dpp_close_icon',
        __('Close Icon', 'wordpress'),
        'dpp_close_icon_render',
        'pluginPage',
        'dpp_pluginPage_section'
    );

    add_settings_field(
        'dpp_link_button_color',
        __('Link Button Color', 'wordpress'),
        'dpp_link_button_color_render',
        'pluginPage',
        'dpp_pluginPage_section'
    );

    add_settings_field(
        'dpp_link_button_text_color',
        __('Link Button Text Color', 'wordpress'),
        'dpp_link_button_text_color_render',
        'pluginPage',
        'dpp_pluginPage_section'
    );

    add_settings_field(
        'dpp_link_button_hover_color',
        __('Link Button Hover Color', 'wordpress'),
        'dpp_link_button_hover_color_render',
        'pluginPage',
        'dpp_pluginPage_section'
    );

    add_settings_field(
        'dpp_modal_button_color',
        __('Modal Button Color', 'wordpress'),
        'dpp_modal_button_color_render',
        'pluginPage',
        'dpp_pluginPage_section'
    );

    add_settings_field(
        'dpp_modal_button_text_color',
        __('Modal Button Text Color', 'wordpress'),
        'dpp_modal_button_text_color_render',
        'pluginPage',
        'dpp_pluginPage_section'
    );

    add_settings_field(
        'dpp_modal_button_hover_color',
        __('Modal Button Hover Color', 'wordpress'),
        'dpp_modal_button_hover_color_render',
        'pluginPage',
        'dpp_pluginPage_section'
    );
}
add_action('admin_init', 'dpp_settings_init');

// Render settings fields
function dpp_modal_color_render() {
    $value = get_option('dpp_modal_color', '#333333');
    echo '<input type="text" name="dpp_modal_color" value="' . esc_attr($value) . '" size="7" class="color-field">';
}

function dpp_reload_icon_render() {
    $value = get_option('dpp_reload_icon', plugins_url('img/reload.png', __FILE__));
    echo '<input type="hidden" name="dpp_reload_icon" id="dpp_reload_icon" value="' . esc_attr($value) . '">';
    echo '<button class="upload_button button">Upload/Select Image</button>';
    if ($value) {
        echo '<img src="' . esc_url($value) . '" style="max-width: 100px; display: block; margin-top: 10px;">';
        echo '<button class="remove_button button">Remove Image</button>';
    }
}

function dpp_close_icon_render() {
    $value = get_option('dpp_close_icon', plugins_url('img/close.png', __FILE__));
    echo '<input type="hidden" name="dpp_close_icon" id="dpp_close_icon" value="' . esc_attr($value) . '">';
    echo '<button class="upload_button button">Upload/Select Image</button>';
    if ($value) {
        echo '<img src="' . esc_url($value) . '" style="max-width: 100px; display: block; margin-top: 10px;">';
        echo '<button class="remove_button button">Remove Image</button>';
    }
}

function dpp_link_button_color_render() {
    $value = get_option('dpp_link_button_color', '#0155be');
    echo '<input type="text" name="dpp_link_button_color" value="' . esc_attr($value) . '" size="7" class="color-field">';
}

function dpp_link_button_text_color_render() {
    $value = get_option('dpp_link_button_text_color', '#FFFFFF');
    echo '<input type="text" name="dpp_link_button_text_color" value="' . esc_attr($value) . '" size="7" class="color-field">';
}

function dpp_link_button_hover_color_render() {
    $value = get_option('dpp_link_button_hover_color', '#296cbf');
    echo '<input type="text" name="dpp_link_button_hover_color" value="' . esc_attr($value) . '" size="7" class="color-field">';
}

function dpp_modal_button_color_render() {
    $value = get_option('dpp_modal_button_color', '#d60202');
    echo '<input type="text" name="dpp_modal_button_color" value="' . esc_attr($value) . '" size="7" class="color-field">';
}

function dpp_modal_button_text_color_render() {
    $value = get_option('dpp_modal_button_text_color', '#FFFFFF');
    echo '<input type="text" name="dpp_modal_button_text_color" value="' . esc_attr($value) . '" size="7" class="color-field">';
}

function dpp_modal_button_hover_color_render() {
    $value = get_option('dpp_modal_button_hover_color', '#ce2c2c');
    echo '<input type="text" name="dpp_modal_button_hover_color" value="' . esc_attr($value) . '" size="7" class="color-field">';
}

// Options page
function dpp_options_page() {
    ?>
    <form action="options.php" method="post">
        <h2>Demo Popup Plugin</h2>
        <?php
        settings_fields('pluginPage');
        do_settings_sections('pluginPage');
        submit_button();
        ?>
    </form>
    <?php
}

// Enqueue media uploader script
function dpp_enqueue_media_uploader() {
    wp_enqueue_media();
    wp_enqueue_script('dpp-admin-script', plugins_url('admin-script.js', __FILE__), array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'dpp_enqueue_media_uploader');
?>