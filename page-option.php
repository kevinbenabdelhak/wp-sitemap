<?php 


if (!defined('ABSPATH')) {
    exit; 
}

function wps_add_admin_menu() {
    add_options_page('WP Sitemap Réglages', 'WP Sitemap', 'manage_options', 'wp_sitemap', 'wps_options_page_html');
}
add_action('admin_menu', 'wps_add_admin_menu');

function wps_settings_init() {
    register_setting('wps_sitemap_settings', 'wps_sitemap_options', 'wps_options_sanitize');
    add_settings_section('wps_sitemap_style_section', __('Personnalisation du Style', 'wp-sitemap'), null, 'wps_sitemap_settings');

    add_settings_field('wps_link_color', __('Couleur du lien', 'wp-sitemap'), 'wps_link_color_callback', 'wps_sitemap_settings', 'wps_sitemap_style_section');
    add_settings_field('wps_enable_transition', __('Activer la transition au survol', 'wp-sitemap'), 'wps_enable_transition_callback', 'wps_sitemap_settings', 'wps_sitemap_style_section');
    add_settings_field('wps_link_hover_color', __('Couleur au survol', 'wp-sitemap'), 'wps_link_hover_color_callback', 'wps_sitemap_settings', 'wps_sitemap_style_section');
    add_settings_field('wps_transition_time', __('Temps de transition (s)', 'wp-sitemap'), 'wps_transition_time_callback', 'wps_sitemap_settings', 'wps_sitemap_style_section');
}
add_action('admin_init', 'wps_settings_init');

function wps_options_sanitize($input) {
    $new_input = [];

    if (isset($input['link_color'])) {
        $new_input['link_color'] = sanitize_hex_color($input['link_color']);
    }

    if (isset($input['enable_transition'])) {
        $new_input['enable_transition'] = 'on';
        
        if (isset($input['link_hover_color'])) {
            $new_input['link_hover_color'] = sanitize_hex_color($input['link_hover_color']);
        }
        if (isset($input['transition_time']) && is_numeric($input['transition_time'])) {
            $new_input['transition_time'] = floatval($input['transition_time']);
        }
    }

    return $new_input;
}

function wps_link_color_callback() {
    $options = get_option('wps_sitemap_options');
    $val = isset($options['link_color']) ? $options['link_color'] : '#000000';
    echo '<input type="color" name="wps_sitemap_options[link_color]" value="' . esc_attr($val) . '" />';
}

function wps_enable_transition_callback() {
    $options = get_option('wps_sitemap_options');
    $checked = isset($options['enable_transition']) ? 'checked' : '';
    echo '<input type="checkbox" id="wps_enable_transition_checkbox" name="wps_sitemap_options[enable_transition]" ' . $checked . ' />';
}

function wps_link_hover_color_callback() {
    $options = get_option('wps_sitemap_options');
    $val = isset($options['link_hover_color']) ? $options['link_hover_color'] : '#0073aa';
    echo '<input type="color" name="wps_sitemap_options[link_hover_color]" value="' . esc_attr($val) . '" />';
}

function wps_transition_time_callback() {
    $options = get_option('wps_sitemap_options');
    $val = isset($options['transition_time']) ? $options['transition_time'] : '0.3';
    echo '<input type="number" name="wps_sitemap_options[transition_time]" value="' . esc_attr($val) . '" step="0.1" min="0" class="small-text" />';
    echo '<p class="description">'.__("Temps en secondes pour l'effet de transition de couleur.", 'wp-sitemap').'</p>';
}

function wps_options_page_html() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <h2 class="nav-tab-wrapper">
            <a href="?page=wp_sitemap&tab=help" class="nav-tab <?php echo !isset($_GET['tab']) || $_GET['tab'] === 'help' ? 'nav-tab-active' : ''; ?>"><?php _e('Aide', 'wp-sitemap'); ?></a>
            <a href="?page=wp_sitemap&tab=style" class="nav-tab <?php echo isset($_GET['tab']) && $_GET['tab'] === 'style' ? 'nav-tab-active' : ''; ?>"><?php _e('Style', 'wp-sitemap'); ?></a>
        </h2>
        <?php
        $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'help';
        if ($active_tab === 'help') {
            ?>
            <h3><?php _e('Comment utiliser le shortcode WP Sitemap', 'wp-sitemap'); ?></h3>
            <p><?php _e("Utilisez le shortcode pour afficher un plan de site sur n'importe quelle page, article ou widget.", 'wp-sitemap'); ?></p>
            <h4><?php _e('Afficher tout le contenu', 'wp-sitemap'); ?></h4>
            <p><?php _e('Pour afficher toutes les pages, articles, et autres types de contenu public :', 'wp-sitemap'); ?></p>
            <code>[sitemap]</code>
            <h4><?php _e('Filtrer par type de contenu', 'wp-sitemap'); ?></h4>
            <p><?php _e("Pour n'afficher que les articles (posts) :", 'wp-sitemap'); ?></p>
            <code>[sitemap type="post"]</code>
            <p><?php _e("Pour n'afficher que les pages et les produits (exemple) :", 'wp-sitemap'); ?></p>
            <code>[sitemap type="page,product"]</code>
            <p><?php _e("Vous pouvez utiliser n'importe quel type de contenu personnalisé, séparés par une virgule.", 'wp-sitemap'); ?></p>
            <h4><?php _e('Limiter le nombre de résultats', 'wp-sitemap'); ?></h4>
            <p><?php _e('Pour afficher les 30 derniers articles :', 'wp-sitemap'); ?></p>
            <code>[sitemap type="post" limit="30"]</code>
            <h4><?php _e('Trier les résultats', 'wp-sitemap'); ?></h4>
            <p><?php _e("Vous pouvez trier les résultats avec les attributs <code>orderby</code> et <code>order</code>.", 'wp-sitemap'); ?></p>
            <p><strong><?php _e("Trier par ordre alphabétique (A-Z) :", 'wp-sitemap'); ?></strong></p>
            <code>[sitemap orderby="title" order="ASC"]</code>
            <h4><?php _e('Exclure du contenu', 'wp-sitemap'); ?></h4>
            <p><?php _e("Vous pouvez exclure des éléments spécifiques en utilisant l'attribut <code>excluded</code>. Vous pouvez y mettre une liste d'IDs, de slugs ou d'URLs, séparés par des virgules.", 'wp-sitemap'); ?></p>
            <p><strong><?php _e("Exclure plusieurs éléments :", 'wp-sitemap'); ?></strong></p>
            <code>[sitemap excluded="123, nom-de-la-page, 456"]</code>
            <?php
        } elseif ($active_tab === 'style') {
            ?>
            <form action="options.php" method="post">
                <?php
                settings_fields('wps_sitemap_settings');
                do_settings_sections('wps_sitemap_settings');
                submit_button(__('Enregistrer les modifications', 'wp-sitemap'));
                ?>
            </form>
            <?php
        }
        ?>
    </div>
    <?php
}