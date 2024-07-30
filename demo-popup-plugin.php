<?php
/*
Plugin Name: Demo Popup Plugin
Plugin URI: https://t.me/dimsseo
Description: Adds a demo popup with demo game and affiliate link.
Version: 1.5
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
        'menu_icon' => 'dashicons-editor-expand',
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
    $play_button_text = get_post_meta($post->ID, '_dpp_play_button_text', 'Demo button');
    $link_button_text = get_post_meta($post->ID, '_dpp_link_button_text', 'Link button');
    $show_link_button = get_post_meta($post->ID, '_dpp_show_link_button', true);
    $overlay_enabled = get_post_meta($post->ID, '_dpp_overlay_enabled', true);
    $overlay_button_text = get_post_meta($post->ID, '_dpp_overlay_button_text', 'Play');
    $overlay_button_color = get_post_meta($post->ID, '_dpp_overlay_button_color', '#007bff');
    $overlay_button_text_color = get_post_meta($post->ID, '_dpp_overlay_button_text_color', '#FFFFFF');
    $overlay_button_hover_color = get_post_meta($post->ID, '_dpp_overlay_button_hover_color', '#0056b3');
    $overlay_button_hover_text_color = get_post_meta($post->ID, '_dpp_overlay_button_hover_text_color', '#FFFFFF');
    $overlay_button_link = get_post_meta($post->ID, '_dpp_overlay_button_link', true);
    $overlay_continue_button_text = get_post_meta($post->ID, '_dpp_overlay_continue_button_text', 'Continue play');
    $overlay_continue_button_color = get_post_meta($post->ID, '_dpp_overlay_continue_button_color', '#28a745');
    $overlay_continue_button_text_color = get_post_meta($post->ID, '_dpp_overlay_continue_button_text_color', '#FFFFFF');
    $overlay_continue_button_hover_color = get_post_meta($post->ID, '_dpp_overlay_continue_button_hover_color', '#218838');
    $overlay_continue_button_hover_text_color = get_post_meta($post->ID, '_dpp_overlay_continue_button_hover_text_color', '#FFFFFF');
    $overlay_time = get_post_meta($post->ID, '_dpp_overlay_time', 30);

    ?>
    <p>
        <label for="dpp_demo_link"><?php _e('Demo Game Link', 'dpp'); ?></label><br>
        <input type="text" name="dpp_demo_link" id="dpp_demo_link" value="<?php echo esc_attr($demo_link); ?>" size="50">
    </p>
    <p>
        <label for="dpp_casino_link"><?php _e('Affiliate Link', 'dpp'); ?></label><br>
        <input type="text" name="dpp_casino_link" id="dpp_casino_link" value="<?php echo esc_attr($casino_link); ?>" size="50">
    </p>
    <p>
        <label for="dpp_button_style"><?php _e('Button Style', 'dpp'); ?></label><br>
        <select name="dpp_button_style" id="dpp_button_style">
            <option value="style1" <?php selected($button_style, 'style1'); ?>>Style 1</option>
            <!-- Add more styles here in the future -->
        </select>
    </p>
    <p>
        <label for="dpp_play_button_text"><?php _e('Play Button Text', 'dpp'); ?></label><br>
        <input type="text" name="dpp_play_button_text" id="dpp_play_button_text" value="<?php echo esc_attr($play_button_text); ?>" size="50">
    </p>
    <p>
        <label for="dpp_link_button_text"><?php _e('Link Button Text', 'dpp'); ?></label><br>
        <input type="text" name="dpp_link_button_text" id="dpp_link_button_text" value="<?php echo esc_attr($link_button_text); ?>" size="50">
    </p>
    <p>
        <input type="checkbox" name="dpp_show_link_button" id="dpp_show_link_button" value="1" <?php checked($show_link_button, '1'); ?>>
        <label for="dpp_show_link_button"><?php _e('Show Link Button', 'dpp'); ?></label>
    </p>
    <h4><?php _e('Overlay Button Settings', 'dpp'); ?></h4>
    <p>
        <input type="checkbox" name="dpp_overlay_enabled" id="dpp_overlay_enabled" value="1" <?php checked($overlay_enabled, '1'); ?>>
        <label for="dpp_overlay_enabled"><?php _e('Enable Overlay', 'dpp'); ?></label>
    </p>
    <p>
        <label for="dpp_overlay_time"><?php _e('Overlay Time (seconds)', 'dpp'); ?></label><br>
        <input type="number" name="dpp_overlay_time" id="dpp_overlay_time" value="<?php echo esc_attr($overlay_time); ?>" size="50">
    </p>
    <p>
        <label for="dpp_overlay_button_text"><?php _e('Overlay Button Text', 'dpp'); ?></label><br>
        <input type="text" name="dpp_overlay_button_text" id="dpp_overlay_button_text" value="<?php echo esc_attr($overlay_button_text); ?>" size="50">
    </p>
    <p>
        <label for="dpp_overlay_button_color"><?php _e('Overlay Button Color', 'dpp'); ?></label><br>
        <input type="text" name="dpp_overlay_button_color" id="dpp_overlay_button_color" value="<?php echo esc_attr($overlay_button_color); ?>" size="7" class="color-field">
    </p>
    <p>
        <label for="dpp_overlay_button_text_color"><?php _e('Overlay Button Text Color', 'dpp'); ?></label><br>
        <input type="text" name="dpp_overlay_button_text_color" id="dpp_overlay_button_text_color" value="<?php echo esc_attr($overlay_button_text_color); ?>" size="7" class="color-field">
    </p>
    <p>
        <label for="dpp_overlay_button_hover_color"><?php _e('Overlay Button Hover Color', 'dpp'); ?></label><br>
        <input type="text" name="dpp_overlay_button_hover_color" id="dpp_overlay_button_hover_color" value="<?php echo esc_attr($overlay_button_hover_color); ?>" size="7" class="color-field">
    </p>
    <p>
        <label for="dpp_overlay_button_hover_text_color"><?php _e('Overlay Button Hover Text Color', 'dpp'); ?></label><br>
        <input type="text" name="dpp_overlay_button_hover_text_color" id="dpp_overlay_button_hover_text_color" value="<?php echo esc_attr($overlay_button_hover_text_color); ?>" size="7" class="color-field">
    </p>
    <p>
        <label for="dpp_overlay_button_link"><?php _e('Overlay Button Link', 'dpp'); ?></label><br>
        <input type="text" name="dpp_overlay_button_link" id="dpp_overlay_button_link" value="<?php echo esc_attr($overlay_button_link); ?>" size="50">
    </p>
    <h4><?php _e('Overlay Continue Button Settings', 'dpp'); ?></h4>
    <p>
        <label for="dpp_overlay_continue_button_text"><?php _e('Overlay Continue Button Text', 'dpp'); ?></label><br>
        <input type="text" name="dpp_overlay_continue_button_text" id="dpp_overlay_continue_button_text" value="<?php echo esc_attr($overlay_continue_button_text); ?>" size="50">
    </p>
    <p>
        <label for="dpp_overlay_continue_button_color"><?php _e('Overlay Continue Button Color', 'dpp'); ?></label><br>
        <input type="text" name="dpp_overlay_continue_button_color" id="dpp_overlay_continue_button_color" value="<?php echo esc_attr($overlay_continue_button_color); ?>" size="7" class="color-field">
    </p>
    <p>
        <label for="dpp_overlay_continue_button_text_color"><?php _e('Overlay Continue Button Text Color', 'dpp'); ?></label><br>
        <input type="text" name="dpp_overlay_continue_button_text_color" id="dpp_overlay_continue_button_text_color" value="<?php echo esc_attr($overlay_continue_button_text_color); ?>" size="7" class="color-field">
    </p>
    <p>
        <label for="dpp_overlay_continue_button_hover_color"><?php _e('Overlay Continue Button Hover Color', 'dpp'); ?></label><br>
        <input type="text" name="dpp_overlay_continue_button_hover_color" id="dpp_overlay_continue_button_hover_color" value="<?php echo esc_attr($overlay_continue_button_hover_color); ?>" size="7" class="color-field">
    </p>
    <p>
        <label for="dpp_overlay_continue_button_hover_text_color"><?php _e('Overlay Continue Button Hover Text Color', 'dpp'); ?></label><br>
        <input type="text" name="dpp_overlay_continue_button_hover_text_color" id="dpp_overlay_continue_button_hover_text_color" value="<?php echo esc_attr($overlay_continue_button_hover_text_color); ?>" size="7" class="color-field">
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
    if (array_key_exists('dpp_play_button_text', $_POST)) {
        update_post_meta($post_id, '_dpp_play_button_text', sanitize_text_field($_POST['dpp_play_button_text']));
    }
    if (array_key_exists('dpp_link_button_text', $_POST)) {
        update_post_meta($post_id, '_dpp_link_button_text', sanitize_text_field($_POST['dpp_link_button_text']));
    }
    if (array_key_exists('dpp_show_link_button', $_POST)) {
        update_post_meta($post_id, '_dpp_show_link_button', sanitize_text_field($_POST['dpp_show_link_button']));
    } else {
        update_post_meta($post_id, '_dpp_show_link_button', '0');
    }
    if (array_key_exists('dpp_overlay_enabled', $_POST)) {
        update_post_meta($post_id, '_dpp_overlay_enabled', sanitize_text_field($_POST['dpp_overlay_enabled']));
    } else {
        update_post_meta($post_id, '_dpp_overlay_enabled', '0');
    }
    if (array_key_exists('dpp_overlay_time', $_POST)) {
        update_post_meta($post_id, '_dpp_overlay_time', intval($_POST['dpp_overlay_time']));
    }
    if (array_key_exists('dpp_overlay_button_text', $_POST)) {
        update_post_meta($post_id, '_dpp_overlay_button_text', sanitize_text_field($_POST['dpp_overlay_button_text']));
    }
    if (array_key_exists('dpp_overlay_button_color', $_POST)) {
        update_post_meta($post_id, '_dpp_overlay_button_color', sanitize_text_field($_POST['dpp_overlay_button_color']));
    }
    if (array_key_exists('dpp_overlay_button_text_color', $_POST)) {
        update_post_meta($post_id, '_dpp_overlay_button_text_color', sanitize_text_field($_POST['dpp_overlay_button_text_color']));
    }
    if (array_key_exists('dpp_overlay_button_hover_color', $_POST)) {
        update_post_meta($post_id, '_dpp_overlay_button_hover_color', sanitize_text_field($_POST['dpp_overlay_button_hover_color']));
    }
    if (array_key_exists('dpp_overlay_button_hover_text_color', $_POST)) {
        update_post_meta($post_id, '_dpp_overlay_button_hover_text_color', sanitize_text_field($_POST['dpp_overlay_button_hover_text_color']));
    }
    if (array_key_exists('dpp_overlay_button_link', $_POST)) {
        update_post_meta($post_id, '_dpp_overlay_button_link', esc_url_raw($_POST['dpp_overlay_button_link']));
    }
    if (array_key_exists('dpp_overlay_continue_button_text', $_POST)) {
        update_post_meta($post_id, '_dpp_overlay_continue_button_text', sanitize_text_field($_POST['dpp_overlay_continue_button_text']));
    }
    if (array_key_exists('dpp_overlay_continue_button_color', $_POST)) {
        update_post_meta($post_id, '_dpp_overlay_continue_button_color', sanitize_text_field($_POST['dpp_overlay_continue_button_color']));
    }
    if (array_key_exists('dpp_overlay_continue_button_text_color', $_POST)) {
        update_post_meta($post_id, '_dpp_overlay_continue_button_text_color', sanitize_text_field($_POST['dpp_overlay_continue_button_text_color']));
    }
    if (array_key_exists('dpp_overlay_continue_button_hover_color', $_POST)) {
        update_post_meta($post_id, '_dpp_overlay_continue_button_hover_color', sanitize_text_field($_POST['dpp_overlay_continue_button_hover_color']));
    }
    if (array_key_exists('dpp_overlay_continue_button_hover_text_color', $_POST)) {
        update_post_meta($post_id, '_dpp_overlay_continue_button_hover_text_color', sanitize_text_field($_POST['dpp_overlay_continue_button_hover_text_color']));
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
    $play_button_text = get_post_meta($post_id, '_dpp_play_button_text', 'Demo button');
    $link_button_text = get_post_meta($post_id, '_dpp_link_button_text', 'Link button');
    $show_link_button = get_post_meta($post_id, '_dpp_show_link_button', '1');
    $overlay_enabled = get_post_meta($post_id, '_dpp_overlay_enabled', true);
    $overlay_time = get_post_meta($post_id, '_dpp_overlay_time', 30);
    $overlay_button_text = get_post_meta($post_id, '_dpp_overlay_button_text', 'Play');
    $overlay_button_color = get_post_meta($post_id, '_dpp_overlay_button_color', '#007bff');
    $overlay_button_text_color = get_post_meta($post_id, '_dpp_overlay_button_text_color', '#FFFFFF');
    $overlay_button_hover_color = get_post_meta($post_id, '_dpp_overlay_button_hover_color', '#0056b3');
    $overlay_button_hover_text_color = get_post_meta($post_id, '_dpp_overlay_button_hover_text_color', '#FFFFFF');
    $overlay_button_link = get_post_meta($post_id, '_dpp_overlay_button_link', true);
    $overlay_continue_button_text = get_post_meta($post_id, '_dpp_overlay_continue_button_text', 'Continue play');
    $overlay_continue_button_color = get_post_meta($post_id, '_dpp_overlay_continue_button_color', '#28a745');
    $overlay_continue_button_text_color = get_post_meta($post_id, '_dpp_overlay_continue_button_text_color', '#FFFFFF');
    $overlay_continue_button_hover_color = get_post_meta($post_id, '_dpp_overlay_continue_button_hover_color', '#218838');
    $overlay_continue_button_hover_text_color = get_post_meta($post_id, '_dpp_overlay_continue_button_hover_text_color', '#FFFFFF');

    $reload_icon = get_option('dpp_reload_icon') ? get_option('dpp_reload_icon') : plugins_url('img/reload.png', __FILE__);
    $close_icon = get_option('dpp_close_icon') ? get_option('dpp_close_icon') : plugins_url('img/close.png', __FILE__);

    ob_start();
    ?>
    <div class="popup-demo" data-popup-id="<?php echo esc_attr($post_id); ?>"
         data-overlay-enabled="<?php echo esc_attr($overlay_enabled); ?>"
         data-overlay-time="<?php echo esc_attr($overlay_time); ?>"
         data-overlay-button-text="<?php echo esc_attr($overlay_button_text); ?>"
         data-overlay-button-color="<?php echo esc_attr($overlay_button_color); ?>"
         data-overlay-button-text-color="<?php echo esc_attr($overlay_button_text_color); ?>"
         data-overlay-button-hover-color="<?php echo esc_attr($overlay_button_hover_color); ?>"
         data-overlay-button-hover-text-color="<?php echo esc_attr($overlay_button_hover_text_color); ?>"
         data-overlay-button-link="<?php echo esc_attr($overlay_button_link); ?>"
         data-overlay-continue-button-text="<?php echo esc_attr($overlay_continue_button_text); ?>"
         data-overlay-continue-button-color="<?php echo esc_attr($overlay_continue_button_color); ?>"
         data-overlay-continue-button-text-color="<?php echo esc_attr($overlay_continue_button_text_color); ?>"
         data-overlay-continue-button-hover-color="<?php echo esc_attr($overlay_continue_button_hover_color); ?>"
         data-overlay-continue-button-hover-text-color="<?php echo esc_attr($overlay_continue_button_hover_text_color); ?>">
        <div class="<?php echo esc_attr($button_style); ?>">
            <?php if ($show_link_button === '1') : ?>
                <button class="link-button" data-casino-link="<?php echo esc_url($casino_link); ?>"><?php echo esc_html($link_button_text); ?></button>
            <?php endif; ?>
            <button class="play-button" data-demo-link="<?php echo esc_url($demo_link); ?>"><?php echo esc_html($play_button_text); ?></button>
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