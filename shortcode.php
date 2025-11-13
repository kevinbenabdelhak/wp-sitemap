<?php 


if (!defined('ABSPATH')) {
    exit; 
}


function wps_sitemap_shortcode($atts) {
    $atts = shortcode_atts(
        [
            'type'     => 'all',
            'limit'    => -1,
            'excluded' => '',
            'order'    => 'DESC',
            'orderby'  => 'date',
        ],
        $atts,
        'sitemap'
    );

    $order = strtoupper($atts['order']);
    if (!in_array($order, ['ASC', 'DESC'])) {
        $order = 'DESC';
    }
    $orderby = sanitize_key($atts['orderby']);

    $args = [
        'post_status'    => 'publish',
        'posts_per_page' => intval($atts['limit']),
        'order'          => $order,
        'orderby'        => $orderby,
    ];

    if ($atts['type'] !== 'all') {
        $post_types = explode(',', $atts['type']);
        $sanitized_post_types = array_map(function($pt) {
            return sanitize_key(trim($pt));
        }, $post_types);
        $args['post_type'] = $sanitized_post_types;
    } else {
        $args['post_type'] = get_post_types(['public' => true]);
    }

    if (!empty($atts['excluded'])) {
        $excluded_items = array_map('trim', explode(',', $atts['excluded']));
        $exclude_ids = [];
        foreach ($excluded_items as $item) {
            if (is_numeric($item)) {
                $exclude_ids[] = intval($item);
            } elseif (filter_var($item, FILTER_VALIDATE_URL)) {
                $post_id = url_to_postid($item);
                if ($post_id) {
                    $exclude_ids[] = $post_id;
                }
            } else {
                $post_found = get_page_by_path($item, OBJECT, $args['post_type']);
                if ($post_found) {
                    $exclude_ids[] = $post_found->ID;
                }
            }
        }
        if (!empty($exclude_ids)) {
            $args['post__not_in'] = array_unique($exclude_ids);
        }
    }

    $query = new WP_Query($args);
    $output = '<div class="wps-sitemap-container"><ul>';
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $output .= sprintf(
                '<li><a href="%s">%s</a></li>',
                esc_url(get_permalink()),
                esc_html(get_the_title())
            );
        }
    } else {
        $output .= '<li>'.__('Aucun contenu trouvé.', 'wp-sitemap').'</li>';
    }
    $output .= '</ul></div>';
    wp_reset_postdata();
    return $output;
}
add_shortcode('sitemap', 'wps_sitemap_shortcode');