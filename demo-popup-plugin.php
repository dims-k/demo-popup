<?php
/*
Plugin Name: Demo Popup Plugin
Plugin URI: https://t.me/dimsseo
Description: Adds a demo popup with demo game and affiliate link.
Version: 1.0
Author: Dims SEO
Author URI: https://t.me/dimsseo
*/

// Register custom post type
function dpp_register_custom_post_type() {
    register_post_type('dpp_modal', array(
        'labels' => array(
            'name' => __('Popups'),
            'singular_name' => __('Popup'),
            'add_new' => __('Add New'),
            'add_new_item' => __('Add New Popup'),
            'edit_item' => __('Edit Popup'),
            'new_item' => __('New Popup'),
            'view_item' => __('View Popup'),
            'search_items' => __('Search Popups'),
            'not_found' => __('No popups found'),
            'not_found_in_trash' => __('No popups found in Trash'),
        ),
        'public' => false,
        'show_ui' => true,
        'supports' => array('title'),
        'menu_icon' => 'dashicons-editor-expand', // Используем иконку dashicons-editor-expand
    ));
}
add_action('init', 'dpp_register_custom_post_type');

// Add meta boxes
function dpp_add_meta_boxes() {
    add_meta_box('dpp_modal_meta', __('Popup Settings'), 'dpp_modal_meta_callback', 'dpp_modal', 'normal', 'high');
}
add_action('add_meta_boxes', 'dpp_add_meta_boxes');

function dpp_modal_meta_callback($post) {
    $demo_link = get_post_meta($post->ID, '_dpp_demo_link', true);
    $casino_link = get_post_meta($post->ID, '_dpp_casino_link', true);
    $button_style = get_post_meta($post->ID, '_dpp_button_style', true);

    ?>
    <p>
        <label for="dpp_demo_link"><?php _e('Demo Game Link', 'dpp'); ?></label><br>
        <input type="text" name="dpp_demo_link" id="dpp_demo_link" value="<?php echo esc_attr($demo_link); ?>" size="50">
    </p>
    <p>
        <label for="dpp_casino_link"><?php _e('Casino Link', 'dpp'); ?></label><br>
        <input type="text" name="dpp_casino_link" id="dpp_casino_link" value="<?php echo esc_attr($casino_link); ?>" size="50">
    </p>
    <p>
        <label for="dpp_button_style"><?php _e('Button Style', 'dpp'); ?></label><br>
        <select name="dpp_button_style" id="dpp_button_style">
            <option value="style1" <?php selected($button_style, 'style1'); ?>>Style 1</option>
            <!-- Add more styles here in the future -->
        </select>
    </p>
    <?php
}

// Save meta box data
function dpp_save_meta_box_data($post_id) {
    if (array_key_exists('dpp_demo_link', $_POST)) {
        update_post_meta($post_id, '_dpp_demo_link', sanitize_text_field($_POST['dpp_demo_link']));
    }
    if (array_key_exists('dpp_casino_link', $_POST)) {
        update_post_meta($post_id, '_dpp_casino_link', sanitize_text_field($_POST['dpp_casino_link']));
    }
    if (array_key_exists('dpp_button_style', $_POST)) {
        update_post_meta($post_id, '_dpp_button_style', sanitize_text_field($_POST['dpp_button_style']));
    }
}
add_action('save_post', 'dpp_save_meta_box_data');

// Register settings
require_once plugin_dir_path(__FILE__) . 'admin-settings.php';

// Enqueue scripts and styles
function dpp_enqueue_scripts() {
    wp_enqueue_style('dpp-style', plugins_url('style.css', __FILE__));
    wp_enqueue_script('dpp-script', plugins_url('modal-script.js', __FILE__), array('jquery'), null, true);

    // Pass plugin settings to the script
    $settings = array(
        'modal_color' => get_option('dpp_modal_color', '#333'),
        'reload_icon' => get_option('dpp_reload_icon', plugins_url('img/reload.png', __FILE__)),
        'close_icon' => get_option('dpp_close_icon', plugins_url('img/close.png', __FILE__)),
        'link_button_color' => get_option('dpp_link_button_color', '#0155be'),
        'link_button_text_color' => get_option('dpp_link_button_text_color', '#FFFFFF'),
        'link_button_hover_color' => get_option('dpp_link_button_hover_color', '#296cbf'),
        'modal_button_color' => get_option('dpp_modal_button_color', '#d60202'),
        'modal_button_text_color' => get_option('dpp_modal_button_text_color', '#FFFFFF'),
        'modal_button_hover_color' => get_option('dpp_modal_button_hover_color', '#ce2c2c')
    );

    wp_localize_script('dpp-script', 'dpp_settings', $settings);
}
add_action('wp_enqueue_scripts', 'dpp_enqueue_scripts');

// Add shortcode column in admin list
function dpp_add_shortcode_column($columns) {
    $columns['shortcode'] = __('Shortcode', 'dpp');
    return $columns;
}
add_filter('manage_dpp_modal_posts_columns', 'dpp_add_shortcode_column');

function dpp_render_shortcode_column($column, $post_id) {
    if ($column === 'shortcode') {
        echo '[demo_popup id="' . $post_id . '"]';
    }
}
add_action('manage_dpp_modal_posts_custom_column', 'dpp_render_shortcode_column', 10, 2);

// Make shortcode column sortable
function dpp_sortable_shortcode_column($columns) {
    $columns['shortcode'] = 'shortcode';
    return $columns;
}
add_filter('manage_edit-dpp_modal_sortable_columns', 'dpp_sortable_shortcode_column');

// Shortcode to display popup
function dpp_modal_shortcode($atts) {
    $atts = shortcode_atts(array(
        'id' => '',
        'show-link' => 'yes'
    ), $atts, 'demo_popup');

    $post_id = $atts['id'];
    $demo_link = get_post_meta($post_id, '_dpp_demo_link', true);
    $casino_link = get_post_meta($post_id, '_dpp_casino_link', true);
    $button_style = get_post_meta($post_id, '_dpp_button_style', 'style1');

    $reload_icon = get_option('dpp_reload_icon') ? get_option('dpp_reload_icon') : plugins_url('img/reload.png', __FILE__);
    $close_icon = get_option('dpp_close_icon') ? get_option('dpp_close_icon') : plugins_url('img/close.png', __FILE__);

    ob_start();
    ?>
    <div class="popup-demo" data-popup-id="<?php echo esc_attr($post_id); ?>">
        <div class="overlay <?php echo esc_attr($button_style); ?>">
            <?php if ($atts['show-link'] === 'yes') : ?>
                <button class="link-button" data-casino-link="<?php echo esc_url($casino_link); ?>">Jogar no Cassino</button>
            <?php endif; ?>
            <button class="play-button" data-demo-link="<?php echo esc_url($demo_link); ?>">Jogar Demo Grátis</button>
        </div>
    </div>
    <div id="popup-<?php echo esc_attr($post_id); ?>" class="popup" style="display:none;">
        <div class="popup-content">
            <iframe class="popup-iframe" src="" width="100%" height="100%" frameborder="0" scrolling="none" allowfullscreen></iframe>
            <button class="reload-iframe" title="Reload" style="background: none; border: none; cursor: pointer;">
                <img src="<?php echo esc_url($reload_icon); ?>" alt="Reload" width="24" height="24" />
            </button>
            <button class="close-popup" title="Close" style="background: none; border: none; cursor: pointer;">
                <img src="<?php echo esc_url($close_icon); ?>" alt="Close" width="24" height="24" />
            </button>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('demo_popup', 'dpp_modal_shortcode');
?>