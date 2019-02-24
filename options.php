<?php
add_action('admin_menu', 'ats_add_admin_menu');
add_action('admin_init', 'ats_settings_init');

function ats_add_admin_menu()
{

    add_options_page(__('Automatic Translate Slug', 'automatic-translate-slug'), __('Automatic Translate Slug', 'automatic-translate-slug'), 'manage_options', 'automatic_translate_slug', 'ats_options_page');

}

function ats_settings_init()
{

    register_setting('pluginPage', 'ats_settings');

    add_settings_section(
        'ats_pluginPage_section',
        __('Plugin Settings', 'automatic-translate-slug'),
        'ats_settings_section_callback',
        'pluginPage'
    );

    add_settings_field(
        'ats_select_service',
        __('Service Provider', 'automatic-translate-slug'),
        'ats_select_service_render',
        'pluginPage',
        'ats_pluginPage_section'
    );

    add_settings_field(
        'ats_appid',
        __('AppID', 'automatic-translate-slug'),
        'ats_appid_render',
        'pluginPage',
        'ats_pluginPage_section'
    );

    add_settings_field(
        'ats_secret',
        __('Secret', 'automatic-translate-slug'),
        'ats_secret_render',
        'pluginPage',
        'ats_pluginPage_section'
    );

}

function ats_select_service_render()
{

    $options = get_option('ats_settings');
    ?>
  <select name='ats_settings[ats_select_service]'>
    <option value='youdaofanyi' <?php selected($options['ats_select_service'], 1);?>><?php echo __('FanYi.YouDao.com', 'automatic-translate-slug'); ?></option>
    <option value='youdaoai' <?php selected($options['ats_select_service'], 2);?> disabled><?php echo __('AI.YouDao.com', 'automatic-translate-slug'); ?></option>
    <option value='sougoufanyi' <?php selected($options['ats_select_service'], 2);?> disabled><?php echo __('Deepi.sogou.com', 'automatic-translate-slug'); ?></option>
    <option value='googletranslate' <?php selected($options['ats_select_service'], 2);?> disabled><?php echo __('Translate.google.com', 'automatic-translate-slug'); ?></option>
    <option value='baidutranslate' <?php selected($options['ats_select_service'], 2);?> disabled><?php echo __('Fanyi.baidu.com', 'automatic-translate-slug'); ?></option>

  </select>

<?php

}

function ats_appid_render()
{

    $options = get_option('ats_settings');
    ?>
  <input type='text' name='ats_settings[ats_appid]' value='<?php echo $options['ats_appid']; ?>'>
    <br><p><?php _e('Input Your AppID Here', 'automatic-translate-slug');?></p>

  <?php

}

function ats_secret_render()
{

    $options = get_option('ats_settings');
    ?>
  <input type='text' name='ats_settings[ats_secret]' value='<?php echo $options['ats_secret']; ?>'>
  <br><p><?php _e('Input Your  Secret Here', 'automatic-translate-slug');?></p>
  <?php

}

function ats_settings_section_callback()
{

    echo __('Choose Translate Service to Transalte Your Title', 'automatic-translate-slug');

    echo "<br><br>";

    echo sprintf(__('<strong>Please Read <a href="%s" target="__blank">Document</a> at First</strong>', 'automatic-translate-slug'), 'https://wpstore.app/archives/automatic-translate-slug/');

}

function ats_options_page()
{

    ?>
  <form action='options.php' method='post'>

    <h2><?php echo __('Automatic Translate Slug', 'automatic-translate-slug'); ?></h2>

    <?php
settings_fields('pluginPage');
    do_settings_sections('pluginPage');
    submit_button();
    ?>

  </form>
  <?php

}

?>
