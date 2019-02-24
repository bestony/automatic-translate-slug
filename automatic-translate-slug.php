<?php
/**
 * Plugin Name: Automatic Translate Slug
 * Plugin URI:  https://wpstore.app/archives/automatic-translate-slug/
 * Description: Make Your Post Slug Into English
 * Version:     1.0.2
 * Author:      Bestony
 * Author URI:  https://wpstore.app/
 * License:     GPL3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: automatic-translate-slug
 * Domain Path: /languages
 */
include plugin_dir_path(__FILE__) . 'options.php';

function ats_plugin_textdomain()
{
    load_plugin_textdomain('automatic-translate-slug', false, basename(dirname(__FILE__)) . '/languages/');
}
add_action('plugins_loaded', 'ats_plugin_textdomain');

function ats_update_slug($data, $post)
{
    $options = get_option('ats_settings');
    switch ($options['ats_select_service']) {
        case 'youdaofanyi':
            require_once plugin_dir_path(__FILE__) . 'provider/youdaofanyi.php';
            $translationService = new ATS_YoudaoFanYi([
                'key' => $options['ats_appid'],
                'from' => $options['ats_secret'],
            ]);
            break;
        case 'youdaoai':
            require_once plugin_dir_path(__FILE__) . 'provider/youdao.php';
            break;
        default:
            break;
    }

    if (!in_array($data['post_status'], array('draft', 'pending', 'auto-draft', 'inherit'))) {
        if (strpos($data['post_name'], '%') !== false) {
            $data['post_name'] = wp_unique_post_slug(sanitize_title($translationService->getSlug($data['post_title'])), $post['ID'], $data['post_status'], $data['post_type'], $data['post_parent']);
        }
    }
    return $data;
}
add_filter('wp_insert_post_data', 'ats_update_slug', 99, 2);
