<?php

function colored_rocks_init_theme_options(){

    global $colored_rocks_params;
    $theme = CROPTIONS_THEME;


    $options = array();

    $options[] = array(
        'id' => 'general_settings',
        'name' => __('General Settings', 'colored_rocks'),
        'type' => 'set',
        'help' => ''
    );
	
    $options[] = array(
        'id' => 'sidebar',
        'name' => __('Sidebar ?', 'colored_rocks'),
        'help' => __('Display a sidebar or not ?', 'colored_rocks'),
        'default' => 'yes',
        'type' => 'select',
        'choices' => array(
            array( 'name' => __('no', 'colored_rocks'), 'value' => 'no'),
            array( 'name' => __('yes', 'colored_rocks'), 'value' => 'yes'),
        )
    );
    $options[] = array(
        'id' => 'search',
        'name' => __('Search Box ?', 'colored_rocks'),
        'help' => __('Display a search box in the nav ?', 'colored_rocks'),
        'default' => 'yes',
        'type' => 'select',
        'choices' => array(
            array( 'name' => __('no', 'colored_rocks'), 'value' => 'no'),
            array( 'name' => __('yes', 'colored_rocks'), 'value' => 'yes'),
        )
    );
    
    $options[] = array(
        'id' => 'footer_settings',
        'name' => __('Footer settings', 'colored_rocks'),
        'type' => 'set',
        'help' => ''
    );
    $options[] = array(
        'id' => 'footer_sidebar',
        'name' => __('Sidebar ?', 'colored_rocks'),
        'help' => __('Display a sidebar or not in the footer ?', 'colored_rocks'),
        'default' => 'no',
        'type' => 'select',
        'choices' => array(
            array( 'name' => __('no', 'colored_rocks'), 'value' => 'no'),
            array( 'name' => __('yes', 'colored_rocks'), 'value' => 'yes'),
        )
    );
    
    $options[] = array(
        'id' => 'social',
        'name' => __('Social Networks', 'colored_rocks'),
        'type' => 'set',
        'help' => 'Just set the url profile for each social networks you want.'
    );
    
    $socials = array (
        'twitter' => 'Twitter',
        'facebook' => 'Facebook',
        'myspace' => 'MySpace',
        'flickr' => 'Flickr',
        'skype' => 'Skype',
        'youtube' => 'Youtube',
        'vimeo' => 'Vimeo',
        'dailymotion' => 'DailyMotion'
    );    
    foreach ($socials as $sid => $sname) {
        $options[] = array(
            'id' => $sid,
            'name' => $sname,
            'help' => '',
            'default' => '',
            'type' => 'text',
            'options' => array(
                'style' => 'style="width: 98%;"'
            )
        );
    }
    
    $options[] = array(
        'id' => 'miscellanious',
        'name' => __('Miscellanious', 'colored_rocks'),
        'type' => 'set',
        'help' => ''
    );
    $options[] = array(
        'id' => 'sc',
        'name' => __('Use Shortcodes', 'colored_rocks'),
        'help' => __('Enables the plugin\'s shortcodes.', 'colored_rocks'),
        'default' => 'yes',
        'type' => 'select',
        'choices' => array(
            array( 'name' => __('no', 'colored_rocks'), 'value' => 'no'),
            array( 'name' => __('yes', 'colored_rocks'), 'value' => 'yes'),
        )
    );
    $options[] = array(
        'id' => 'sc_prefixe',
        'name' => __('Prefix For Schortcode', 'colored_rocks'),
        'help' => __('If shortcodes names are in conflict with other plugin shortcode use this field<br />Ex: with prefix &quot;custom&quot; use &quot;[custom_button ...]...[/custom_button]&quot;', 'colored_rocks'),
        'default' => '',
        'type' => 'text',
        'options' => array(
            'style' => 'style="width: 100px;"'
        )
    );
    $options[] = array(
        'id' => 'fancybox',
        'name' => __('FancyBox', 'colored_rocks'),
        'help' => __('Display image in a Mac-style "lightbox" that floats overtop of web page.', 'colored_rocks'),
        'default' => 'yes',
        'type' => 'select',
        'choices' => array(
            array( 'name' => __('no', 'colored_rocks'), 'value' => 'no'),
            array( 'name' => __('yes', 'colored_rocks'), 'value' => 'yes'),
        )
    );
    
    $colored_rocks_params = $options;
    //update_option('colored_rocks_theme_options', $options);
}

