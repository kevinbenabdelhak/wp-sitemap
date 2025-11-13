<?php 


if (!defined('ABSPATH')) {
    exit; 
}



function wps_admin_footer_scripts() {
    $screen = get_current_screen();
    if (!$screen || $screen->id !== 'settings_page_wp_sitemap') {
        return;
    }
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            var hoverColorRow = $('input[name="wps_sitemap_options[link_hover_color]"]').closest('tr');
            var transitionTimeRow = $('input[name="wps_sitemap_options[transition_time]"]').closest('tr');
            var checkbox = $('#wps_enable_transition_checkbox');
            function toggleFields() {
                if (checkbox.is(':checked')) {
                    hoverColorRow.show();
                    transitionTimeRow.show();
                } else {
                    hoverColorRow.hide();
                    transitionTimeRow.hide();
                }
            }
            toggleFields();
            checkbox.on('change', toggleFields);
        });
    </script>
    <?php
}
add_action('admin_footer', 'wps_admin_footer_scripts');

function wps_enqueue_custom_styles() {
    $options = get_option('wps_sitemap_options');
    $custom_css = '';
    $base_styles = [];

    if (!empty($options['link_color'])) {
        $base_styles[] = "color: " . sanitize_hex_color($options['link_color']) . ";";
    }

    if (isset($options['enable_transition'])) {
        if (!empty($options['link_hover_color'])) {
            $custom_css .= ".wps-sitemap-container a:hover { color: " . sanitize_hex_color($options['link_hover_color']) . "; }";
        }
        if (isset($options['transition_time']) && is_numeric($options['transition_time'])) {
            $base_styles[] = "transition: color " . floatval($options['transition_time']) . "s ease-in-out;";
        }
    }

    if (!empty($base_styles)) {
        $custom_css = ".wps-sitemap-container a { " . implode(' ', $base_styles) . " }" . $custom_css;
    }

    if (!empty($custom_css)) {
        wp_register_style('wps-custom-style', false);
        wp_enqueue_style('wps-custom-style');
        wp_add_inline_style('wps-custom-style', $custom_css);
    }
}
add_action('wp_enqueue_scripts', 'wps_enqueue_custom_styles');