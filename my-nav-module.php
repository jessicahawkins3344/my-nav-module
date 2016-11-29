<?php 

/**
 * Plugin Name: My Nav Module
 * Description: A simple module for Live Composer plugin.
 * Version: 1.0
 */

// Check if Live Composer is active
if ( defined( 'DS_LIVE_COMPOSER_URL' ) ) {

	//ENQUEUE JQUERY & CUSTOM SCRIPTS
	function lc_nav_load_scripts() {
	    wp_enqueue_style( 'cs-select',  plugin_dir_url( __FILE__ ) . 'css/cs-select.css' );
	    wp_enqueue_style( 'cs-skin-underline',  plugin_dir_url( __FILE__ ) . 'css/cs-skin-underline.css' );
	    wp_enqueue_script( 'classie', plugin_dir_url( __FILE__ ) . 'js/classie.js', false, null, false  );
        wp_enqueue_script( 'selectFx', plugin_dir_url( __FILE__ ) . 'js/selectFx.js', false, null, false );
	}
	add_action( 'wp_enqueue_scripts', 'lc_nav_load_scripts' );

	add_action('dslc_hook_register_modules',
	     create_function('', 'return dslc_register_module( "My_Nav_Module" );')
	);

	class My_Nav_Module extends DSLC_Module {
	 		
	 	// Module Attributes
	    var $module_id = 'My_Nav_Module';
	    var $module_title = 'My Nav Module';
	    var $module_icon = 'circle';
	    var $module_category = 'general';
	 
	 	// Module Options
        function options() {

            $locs = get_registered_nav_menus();

            $loc_choices = array();
            $loc_choices[] = array(
                'label' => __( 'Choose Navigation', 'live-composer-page-builder' ),
                'value' => 'not_set',
            );

            if ( ! empty( $locs ) ) {
                foreach ( $locs as $loc_id => $loc_label ) {
                    $loc_choices[] = array(
                        'label' => $loc_label,
                        'value' => $loc_id,
                    );
                }
            } 

            // The options array
            $options = array(

                array(
                    'label' => __( 'Show On', 'live-composer-page-builder' ),
                    'id' => 'css_show_on',
                    'std' => 'desktop tablet phone',
                    'type' => 'checkbox',
                    'choices' => array(
                        array(
                            'label' => __( 'Desktop', 'live-composer-page-builder' ),
                            'value' => 'desktop',
                        ),
                        array(
                            'label' => __( 'Tablet', 'live-composer-page-builder' ),
                            'value' => 'tablet',
                        ),
                        array(
                            'label' => __( 'Phone', 'live-composer-page-builder' ),
                            'value' => 'phone',
                        ),
                    ),
                ),

                array(
                    'label' => __( 'Navigation', 'live-composer-page-builder' ),
                    'id' => 'location',
                    'std' => 'not_set',
                    'type' => 'select',
                    'choices' => $loc_choices,
                    'help' => __( 'The locations from the theme will be shown here but you can register your own in <br>WP Admin > Live Composer > Navigation.', 'live-composer-page-builder' ),
                ),

                array(
                    'label' => 'Responsive Text',
                    'id' => 'res_text',
                    'std' => 'CLICK TO EDIT',
                    'type' => 'text',
                ),

                /**
                * Styling
                */

                array(
                    'label' => __( 'Align', 'live-composer-page-builder' ),
                    'id' => 'css_main_align',
                    'std' => 'right',
                    'type' => 'text_align',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation',
                    'affect_on_change_rule' => 'text-align',
                    'section' => 'styling',
                ),
                array(
                    'label' => __( 'BG Color', 'live-composer-page-builder' ),
                    'id' => 'css_main_bg_color',
                    'std' => '',
                    'type' => 'color',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation-inner',
                    'affect_on_change_rule' => 'background-color',
                    'section' => 'styling',
                ),
                array(
                    'label' => __( 'BG Image', 'live-composer-page-builder' ),
                    'id' => 'css_main_bg_img',
                    'std' => '',
                    'type' => 'image',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation-inner',
                    'affect_on_change_rule' => 'background-image',
                    'section' => 'styling',
                ),
                array(
                    'label' => __( 'BG Image Repeat', 'live-composer-page-builder' ),
                    'id' => 'css_main_bg_img_repeat',
                    'std' => 'repeat',
                    'type' => 'select',
                    'choices' => array(
                        array(
                            'label' => __( 'Repeat', 'live-composer-page-builder' ),
                            'value' => 'repeat',
                        ),
                        array(
                            'label' => __( 'Repeat Horizontal', 'live-composer-page-builder' ),
                            'value' => 'repeat-x',
                        ),
                        array(
                            'label' => __( 'Repeat Vertical', 'live-composer-page-builder' ),
                            'value' => 'repeat-y',
                        ),
                        array(
                            'label' => __( 'Do NOT Repeat', 'live-composer-page-builder' ),
                            'value' => 'no-repeat',
                        ),
                    ),
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation-inner',
                    'affect_on_change_rule' => 'background-repeat',
                    'section' => 'styling',
                ),
                array(
                    'label' => __( 'BG Image Attachment', 'live-composer-page-builder' ),
                    'id' => 'css_main_bg_img_attch',
                    'std' => 'scroll',
                    'type' => 'select',
                    'choices' => array(
                        array(
                            'label' => __( 'Scroll', 'live-composer-page-builder' ),
                            'value' => 'scroll',
                        ),
                        array(
                            'label' => __( 'Fixed', 'live-composer-page-builder' ),
                            'value' => 'fixed',
                        ),
                    ),
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation-inner',
                    'affect_on_change_rule' => 'background-attachment',
                    'section' => 'styling',
                ),
                array(
                    'label' => __( 'BG Image Position', 'live-composer-page-builder' ),
                    'id' => 'css_main_bg_img_pos',
                    'std' => 'top left',
                    'type' => 'select',
                    'choices' => array(
                        array(
                            'label' => __( 'Top Left', 'live-composer-page-builder' ),
                            'value' => 'left top',
                        ),
                        array(
                            'label' => __( 'Top Right', 'live-composer-page-builder' ),
                            'value' => 'right top',
                        ),
                        array(
                            'label' => __( 'Top Center', 'live-composer-page-builder' ),
                            'value' => 'Center Top',
                        ),
                        array(
                            'label' => __( 'Center Left', 'live-composer-page-builder' ),
                            'value' => 'left center',
                        ),
                        array(
                            'label' => __( 'Center Right', 'live-composer-page-builder' ),
                            'value' => 'right center',
                        ),
                        array(
                            'label' => __( 'Center', 'live-composer-page-builder' ),
                            'value' => 'center center',
                        ),
                        array(
                            'label' => __( 'Bottom Left', 'live-composer-page-builder' ),
                            'value' => 'left bottom',
                        ),
                        array(
                            'label' => __( 'Bottom Right', 'live-composer-page-builder' ),
                            'value' => 'right bottom',
                        ),
                        array(
                            'label' => __( 'Bottom Center', 'live-composer-page-builder' ),
                            'value' => 'center bottom',
                        ),
                    ),
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation-inner',
                    'affect_on_change_rule' => 'background-position',
                    'section' => 'styling',
                ),
                array(
                    'label' => __( 'Border Color', 'live-composer-page-builder' ),
                    'id' => 'css_main_border_color',
                    'std' => 'rgba(0,0,0,0)',
                    'type' => 'color',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation-inner, .cs-select span',
                    'affect_on_change_rule' => 'border-color',
                    'section' => 'styling',
                ),
                array(
                    'label' => __( 'Placeholder Color', 'live-composer-page-builder' ),
                    'id' => 'css_res_ph_color',
                    'std' => '#fd4970',
                    'type' => 'color',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.cs-skin-border.cs-active > span, span.cs-placeholder',
                    'affect_on_change_rule' => 'color',
                    'section' => 'styling',
                    'tab' => 'responsive menu'
                ),
                array(
                    'label' => __( 'Placeholder Background', 'live-composer-page-builder' ),
                    'id' => 'css_res_ph_bg_color',
                    'std' => '',
                    'type' => 'color',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.cs-skin-border.cs-active > span, span.cs-placeholder',
                    'affect_on_change_rule' => 'background',
                    'section' => 'styling',
                    'tab' => 'responsive menu'
                ),
                array(
                    'label' => __( 'Placeholder Border Color', 'live-composer-page-builder' ),
                    'id' => 'css_res_ph_border_color',
                    'std' => '#ffffff',
                    'type' => 'color',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.cs-skin-border > span, .cs-select > span, .cs-skin-underline > span, div.cs-skin-underline ',
                    'affect_on_change_rule' => 'border-color',
                    'section' => 'styling',
                    'tab' => 'responsive menu'
                ),
                array(
                    'label' => __( 'Placeholder Border Width', 'live-composer-page-builder' ),
                    'id' => 'css_res_ph_border_width',
                    'onlypositive' => true, // Value can't be negative.
                    'std' => '3',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.cs-skin-border > span, .cs-select > span, .cs-skin-underline > span, div.cs-skin-underline ',
                    'affect_on_change_rule' => 'border-width',
                    'section' => 'styling',
                    'tab' => 'responsive menu',
                    'ext' => 'px',
                ),
                array(
                    'label' => __( 'Placeholder Borders', 'live-composer-page-builder' ),
                    'id' => 'css_res_ph_border',
                    'std' => 'top right bottom left',
                    'type' => 'checkbox',
                    'choices' => array(
                        array(
                            'label' => __( 'Top', 'live-composer-page-builder' ),
                            'value' => 'top',
                        ),
                        array(
                            'label' => __( 'Right', 'live-composer-page-builder' ),
                            'value' => 'right',
                        ),
                        array(
                            'label' => __( 'Bottom', 'live-composer-page-builder' ),
                            'value' => 'bottom',
                        ),
                        array(
                            'label' => __( 'Left', 'live-composer-page-builder' ),
                            'value' => 'left',
                        ),
                    ),
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.cs-skin-border > span, .cs-select > span',
                    'affect_on_change_rule' => 'border-style',
                    'section' => 'styling',
                    'tab' => 'responsive menu',
                ),
                array(
                    'label' => __( 'Placeholder Border Radius', 'live-composer-page-builder' ),
                    'id' => 'css_res_ph_border_radius',
                    'std' => '5',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.cs-skin-border.cs-active > span, span.cs-placeholder',
                    'affect_on_change_rule' => 'border-radius',
                    'section' => 'styling',
                    'tab' => 'responsive menu',
                    'ext' => 'px',

                ),
                array(
                    'label' => __( 'Border Width', 'live-composer-page-builder' ),
                    'id' => 'css_main_border_width',
                    'onlypositive' => true, // Value can't be negative.
                    'std' => '0',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation-inner',
                    'affect_on_change_rule' => 'border-width',
                    'section' => 'styling',
                    'ext' => 'px',
                ),
                array(
                    'label' => __( 'Borders', 'live-composer-page-builder' ),
                    'id' => 'css_main_border_trbl',
                    'std' => 'top right bottom left',
                    'type' => 'checkbox',
                    'choices' => array(
                        array(
                            'label' => __( 'Top', 'live-composer-page-builder' ),
                            'value' => 'top',
                        ),
                        array(
                            'label' => __( 'Right', 'live-composer-page-builder' ),
                            'value' => 'right',
                        ),
                        array(
                            'label' => __( 'Bottom', 'live-composer-page-builder' ),
                            'value' => 'bottom',
                        ),
                        array(
                            'label' => __( 'Left', 'live-composer-page-builder' ),
                            'value' => 'left',
                        ),
                    ),
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation-inner',
                    'affect_on_change_rule' => 'border-style',
                    'section' => 'styling',
                ),
                array(
                    'label' => __( 'Border Radius - Top', 'live-composer-page-builder' ),
                    'id' => 'css_main_border_radius_top',
                    'onlypositive' => true, // Value can't be negative.
                    'std' => '0',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation-inner',
                    'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
                    'section' => 'styling',
                    'ext' => 'px',
                ),
                array(
                    'label' => __( 'Border Radius - Bottom', 'live-composer-page-builder' ),
                    'id' => 'css_main_border_radius_bottom',
                    'onlypositive' => true, // Value can't be negative.
                    'std' => '0',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation-inner',
                    'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
                    'section' => 'styling',
                    'ext' => 'px',
                ),
                array(
                    'label' => __( 'Margin Top', 'live-composer-page-builder' ),
                    'id' => 'css_margin_top',
                    'std' => '0',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation-inner, .dslc-mobile-navigation',
                    'affect_on_change_rule' => 'margin-top',
                    'section' => 'styling',
                    'ext' => 'px',
                ),
                array(
                    'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
                    'id' => 'css_margin_bottom',
                    'std' => '0',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation-inner, .dslc-mobile-navigation',
                    'affect_on_change_rule' => 'margin-bottom',
                    'section' => 'styling',
                    'ext' => 'px',
                ),
                array(
                    'label' => __( 'Minimum Height', 'live-composer-page-builder' ),
                    'id' => 'css_min_height',
                    'onlypositive' => true, // Value can't be negative.
                    'std' => '0',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation-inner',
                    'affect_on_change_rule' => 'min-height',
                    'section' => 'styling',
                    'ext' => 'px',
                    'increment' => 5,
                ),
                array(
                    'label' => __( 'Orientation', 'live-composer-page-builder' ),
                    'id' => 'nav_orientation',
                    'std' => 'horizontal',
                    'type' => 'select',
                    'choices' => array(
                        array(
                            'label' => __( 'Horizontal', 'live-composer-page-builder' ),
                            'value' => 'horizontal',
                        ),
                        array(
                            'label' => __( 'Vertical', 'live-composer-page-builder' ),
                            'value' => 'vertical',
                        ),
                    ),
                    'section' => 'styling',
                ),
                array(
                    'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
                    'id' => 'css_main_padding_vertical',
                    'onlypositive' => true, // Value can't be negative.
                    'max' => 600,
                    'std' => '0',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation-inner',
                    'affect_on_change_rule' => 'padding-top,padding-bottom',
                    'section' => 'styling',
                    'ext' => 'px',
                ),
                array(
                    'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
                    'id' => 'css_main_padding_horizontal',
                    'onlypositive' => true, // Value can't be negative.
                    'std' => '0',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation-inner',
                    'affect_on_change_rule' => 'padding-left,padding-right',
                    'section' => 'styling',
                    'ext' => 'px',
                ),

                /**
                 * Styling - Item
                 */

                array(
                    'label' => __( 'BG Color', 'live-composer-page-builder' ),
                    'id' => 'css_item_bg_color',
                    'std' => '',
                    'type' => 'color',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu > li > a',
                    'affect_on_change_rule' => 'background-color',
                    'section' => 'styling',
                    'tab' => __( 'Item', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'BG Color - Hover', 'live-composer-page-builder' ),
                    'id' => 'css_item_bg_color_hover',
                    'std' => '',
                    'type' => 'color',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu > li > a:hover',
                    'affect_on_change_rule' => 'background-color',
                    'section' => 'styling',
                    'tab' => __( 'Item', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'BG Color - Active', 'live-composer-page-builder' ),
                    'id' => 'css_item_bg_color_active',
                    'std' => '',
                    'type' => 'color',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu > li.current-menu-item > a',
                    'affect_on_change_rule' => 'background-color',
                    'section' => 'styling',
                    'tab' => __( 'Item', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Dropdown BG Color', 'live-composer-page-builder' ),
                    'id' => 'css_res_dropdown_bg_color',
                    'std' => '#323232',
                    'type' => 'color',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.cs-select .cs-options',
                    'affect_on_change_rule' => 'background-color',
                    'section' => 'styling',
                    'tab' => __( 'Responsive Menu', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Dropdown Border Color', 'live-composer-page-builder' ),
                    'id' => 'css_res_dd_border_color',
                    'std' => '',
                    'type' => 'color',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.cs-skin-border .cs-options, .cs-select .cs-options',
                    'affect_on_change_rule' => 'border-color',
                    'section' => 'styling',
                    'tab' => 'responsive menu'
                ),
                array(
                    'label' => __( 'Dropdown Border Width', 'live-composer-page-builder' ),
                    'id' => 'css_res_dd_border_width',
                    'onlypositive' => true, // Value can't be negative.
                    'std' => '3',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.cs-skin-border .cs-options, .cs-select .cs-options',
                    'affect_on_change_rule' => 'border-width',
                    'section' => 'styling',
                    'tab' => 'responsive menu',
                    'ext' => 'px',
                ),
                array(
                    'label' => __( 'Dropdown Borders', 'live-composer-page-builder' ),
                    'id' => 'css_res_dd_borders',
                    'std' => 'top right bottom left',
                    'type' => 'checkbox',
                    'choices' => array(
                        array(
                            'label' => __( 'Top', 'live-composer-page-builder' ),
                            'value' => 'top',
                        ),
                        array(
                            'label' => __( 'Right', 'live-composer-page-builder' ),
                            'value' => 'right',
                        ),
                        array(
                            'label' => __( 'Bottom', 'live-composer-page-builder' ),
                            'value' => 'bottom',
                        ),
                        array(
                            'label' => __( 'Left', 'live-composer-page-builder' ),
                            'value' => 'left',
                        ),
                    ),
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.cs-skin-border .cs-options, .cs-select .cs-options',
                    'affect_on_change_rule' => 'border-style',
                    'section' => 'styling',
                    'tab' => 'responsive menu',
                ),
                array(
                    'label' => __( 'Dropdown Border Radius', 'live-composer-page-builder' ),
                    'id' => 'css_res_dd_border_radius',
                    'onlypositive' => true, // Value can't be negative.
                    'std' => '5',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.cs-skin-border .cs-options, .cs-select .cs-options, .cs-select ul.menu',
                    'affect_on_change_rule' => 'border-radius',
                    'section' => 'styling',
                    'ext' => 'px',
                    'section' => 'styling',
                    'tab' => __( 'responsive menu', 'live-composer-page-builder' ),
                ),

                array(
                    'label' => __( 'Border Color', 'live-composer-page-builder' ),
                    'id' => 'css_item_border_color',
                    'std' => '',
                    'type' => 'color',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu > li > a',
                    'affect_on_change_rule' => 'border-color',
                    'section' => 'styling',
                    'tab' => __( 'Item', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Border Color - Hover', 'live-composer-page-builder' ),
                    'id' => 'css_item_border_color_hover',
                    'std' => '',
                    'type' => 'color',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu > li > a:hover',
                    'affect_on_change_rule' => 'border-color',
                    'section' => 'styling',
                    'tab' => __( 'Item', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Border Color - Active', 'live-composer-page-builder' ),
                    'id' => 'css_item_border_color_active',
                    'std' => '',
                    'type' => 'color',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu > li.current-menu-item > a',
                    'affect_on_change_rule' => 'border-color',
                    'section' => 'styling',
                    'tab' => __( 'Item', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Border Width', 'live-composer-page-builder' ),
                    'id' => 'css_item_border_width',
                    'onlypositive' => true, // Value can't be negative.
                    'std' => '0',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu > li > a',
                    'affect_on_change_rule' => 'border-width',
                    'section' => 'styling',
                    'ext' => 'px',
                    'tab' => __( 'Item', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Borders', 'live-composer-page-builder' ),
                    'id' => 'css_item_border_trbl',
                    'std' => 'top right bottom left',
                    'type' => 'checkbox',
                    'choices' => array(
                        array(
                            'label' => __( 'Top', 'live-composer-page-builder' ),
                            'value' => 'top',
                        ),
                        array(
                            'label' => __( 'Right', 'live-composer-page-builder' ),
                            'value' => 'right',
                        ),
                        array(
                            'label' => __( 'Bottom', 'live-composer-page-builder' ),
                            'value' => 'bottom',
                        ),
                        array(
                            'label' => __( 'Left', 'live-composer-page-builder' ),
                            'value' => 'left',
                        ),
                    ),
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu > li > a',
                    'affect_on_change_rule' => 'border-style',
                    'section' => 'styling',
                    'tab' => __( 'Item', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Border Radius - Top', 'live-composer-page-builder' ),
                    'id' => 'css_item_border_radius_top',
                    'onlypositive' => true, // Value can't be negative.
                    'std' => '0',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu > li > a',
                    'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
                    'section' => 'styling',
                    'ext' => 'px',
                    'tab' => __( 'Item', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Border Radius - Bottom', 'live-composer-page-builder' ),
                    'id' => 'css_item_border_radius_bottom',
                    'onlypositive' => true, // Value can't be negative.
                    'std' => '0',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu > li > a',
                    'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
                    'section' => 'styling',
                    'ext' => 'px',
                    'tab' => __( 'Item', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Color', 'live-composer-page-builder' ),
                    'id' => 'css_res_item_color',
                    'std' => '#ffffff',
                    'type' => 'color',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.cs-select span',
                    'affect_on_change_rule' => 'color',
                    'section' => 'styling',
                    'tab' => __( 'Responsive Menu', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Color - Hover', 'live-composer-page-builder' ),
                    'id' => 'css_res_item_color_hover',
                    'std' => '#fd4970',
                    'type' => 'color',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.cs-select span:hover, .cs-select span:focus, cs-options li.menu-item:hover, li.menu-item:focus, .cs-options li span:hover, .cs-select span:hover',
                    'affect_on_change_rule' => 'color',
                    'section' => 'styling',
                    'tab' => __( 'Responsive Menu', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Item Background Color', 'live-composer-page-builder' ),
                    'id' => 'css_res_item_bg_color_active',
                    'std' => '#fd4970',
                    'type' => 'color',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.cs-select ul > li',
                    'affect_on_change_rule' => 'background',
                    'section' => 'styling',
                    'tab' => __( 'Responsive Menu', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Color', 'live-composer-page-builder' ),
                    'id' => 'css_res_item_color',
                    'std' => '#555555',
                    'type' => 'color',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu > li > a',
                    'affect_on_change_rule' => 'color',
                    'section' => 'styling',
                    'tab' => __( 'Item', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Color - Hover', 'live-composer-page-builder' ),
                    'id' => 'css_item_color_hover',
                    'std' => '#fd4970',
                    'type' => 'color',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu > li > a:hover',
                    'affect_on_change_rule' => 'color',
                    'section' => 'styling',
                    'tab' => __( 'Item', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Color - Active', 'live-composer-page-builder' ),
                    'id' => 'css_item_color_active',
                    'std' => '#fd4970',
                    'type' => 'color',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu > li.current-menu-item > a',
                    'affect_on_change_rule' => 'color',
                    'section' => 'styling',
                    'tab' => __( 'Item', 'live-composer-page-builder' ),
                ),

                array(
                    'label' => __( 'Font Size', 'live-composer-page-builder' ),
                    'id' => 'css_item_font_size',
                    'onlypositive' => true, // Value can't be negative.
                    'std' => '14',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu > li > a',
                    'affect_on_change_rule' => 'font-size',
                    'section' => 'styling',
                    'tab' => __( 'Item', 'live-composer-page-builder' ),
                    'ext' => 'px',
                ),
                array(
                    'label' => __( 'Font Size', 'live-composer-page-builder' ),
                    'id' => 'css_res_item_font_size',
                    'onlypositive' => true, // Value can't be negative.
                    'std' => '14',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu > li > a, .cs-select span',
                    'affect_on_change_rule' => 'font-size, line-height',
                    'section' => 'styling',
                    'tab' => __( 'Responsive Menu', 'live-composer-page-builder' ),
                    'ext' => 'px',
                ),
                array(
                    'label' => __( 'Font Weight', 'live-composer-page-builder' ),
                    'id' => 'css_item_font_weight, .cs-select span',
                    'std' => '700',
                    'type' => 'select',
                    'choices' => array(
                        array(
                            'label' => '100 - Thin',
                            'value' => '100',
                        ),
                        array(
                            'label' => '200 - Extra Light',
                            'value' => '200',
                        ),
                        array(
                            'label' => '300 - Light',
                            'value' => '300',
                        ),
                        array(
                            'label' => '400 - Normal',
                            'value' => '400',
                        ),
                        array(
                            'label' => '500 - Medium',
                            'value' => '500',
                        ),
                        array(
                            'label' => '600 - Semi Bold',
                            'value' => '600',
                        ),
                        array(
                            'label' => '700 - Bold',
                            'value' => '700',
                        ),
                        array(
                            'label' => '800 - Extra Bold',
                            'value' => '800',
                        ),
                        array(
                            'label' => '900 - Black',
                            'value' => '900',
                        ),
                    ),
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu > li > a',
                    'affect_on_change_rule' => 'font-weight',
                    'section' => 'styling',
                    'tab' => __( 'Item', 'live-composer-page-builder' ),
                    'ext' => '',
                ),
                array(
                    'label' => __( 'Font Family', 'live-composer-page-builder' ),
                    'id' => 'css_item_font_family',
                    'std' => 'Montserrat',
                    'type' => 'font',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu > li > a, .cs-select span',
                    'affect_on_change_rule' => 'font-family',
                    'section' => 'styling',
                    'tab' => __( 'Item', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Letter Spacing', 'live-composer-page-builder' ),
                    'id' => 'css_item_letter_spacing',
                    'max' => 30,
                    'std' => '0',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu > li > a, .cs-skin-border ul span, .cs-select ul span',
                    'affect_on_change_rule' => 'letter-spacing',
                    'section' => 'styling',
                    'tab' => __( 'Item', 'live-composer-page-builder' ),
                    'ext' => 'px',
                    'min' => -50,
                    'max' => 50,
                ),
                array(
                    'label' => __( 'Line Height', 'live-composer-page-builder' ),
                    'id' => 'css_item_line_height',
                    'onlypositive' => true, // Value can't be negative.
                    'std' => '22',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu > li > a',
                    'affect_on_change_rule' => 'line-height',
                    'section' => 'styling',
                    'tab' => __( 'Item', 'live-composer-page-builder' ),
                    'ext' => 'px',
                ),
                array(
                    'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
                    'id' => 'css_item_padding_vertical',
                    'onlypositive' => true, // Value can't be negative.
                    'max' => 600,
                    'std' => '0',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu > li > a',
                    'affect_on_change_rule' => 'padding-top,padding-bottom',
                    'section' => 'styling',
                    'ext' => 'px',
                    'tab' => __( 'Item', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Item Spacing', 'live-composer-page-builder' ),
                    'id' => 'css_res_item_spacing',
                    'std' => '3',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.cs-skin-border ul span, .cs-select ul span',
                    'affect_on_change_rule' => 'margin-bottom,margin-top',
                    'section' => 'styling',
                    'ext' => 'px',
                    'tab' => __( 'Responsive Menu', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Item Padding Vertical', 'live-composer-page-builder' ),
                    'id' => 'css_res_item_padding_vertical',
                    'onlypositive' => true, // Value can't be negative.
                    'max' => 600,
                    'std' => '15',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.cs-skin-border ul span, .cs-select ul span',
                    'affect_on_change_rule' => 'padding-top,padding-bottom',
                    'section' => 'styling',
                    'ext' => 'px',
                    'tab' => __( 'Responsive Menu', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
                    'id' => 'css_item_padding_horizontal',
                    'onlypositive' => true, // Value can't be negative.
                    'std' => '15',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu > li > a',
                    'affect_on_change_rule' => 'padding-left,padding-right',
                    'section' => 'styling',
                    'ext' => 'px',
                    'tab' => __( 'Item', 'live-composer-page-builder' ),
                ),
                 array(
                    'label' => __( 'Item Padding Horizontal', 'live-composer-page-builder' ),
                    'id' => 'css_res_item_padding_horizontal',
                    'onlypositive' => true, // Value can't be negative.
                    'std' => '20',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.cs-skin-border ul span, .cs-select ul span',
                    'affect_on_change_rule' => 'padding-left,padding-right',
                    'section' => 'styling',
                    'ext' => 'px',
                    'tab' => __( 'Responsive Menu', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Dropdown Margin Top', 'live-composer-page-builder' ),
                    'id' => 'css_dd_margin_top_horizontal',
                    'onlypositive' => true, // Value can't be negative.
                    'std' => '15',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.cs-select .cs-options',
                    'affect_on_change_rule' => 'margin-top',
                    'section' => 'styling',
                    'ext' => 'px',
                    'tab' => __( 'Responsive Menu', 'live-composer-page-builder' ),
                ),
                 array(
                    'label' => __( 'Dropdown Padding Horizontal', 'live-composer-page-builder' ),
                    'id' => 'css_item_padding_horizontal',
                    'onlypositive' => true, // Value can't be negative.
                    'std' => '0',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.cs-select .cs-options',
                    'affect_on_change_rule' => 'padding-left,padding-right',
                    'section' => 'styling',
                    'ext' => 'px',
                    'tab' => __( 'Responsive Menu', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Text Transform', 'live-composer-page-builder' ),
                    'id' => 'css_item_text_transform',
                    'std' => 'none',
                    'type' => 'select',
                    'choices' => array(
                        array(
                            'label' => __( 'None', 'live-composer-page-builder' ),
                            'value' => 'none',
                        ),
                        array(
                            'label' => __( 'Capitalize', 'live-composer-page-builder' ),
                            'value' => 'capitalize',
                        ),
                        array(
                            'label' => __( 'Uppercase', 'live-composer-page-builder' ),
                            'value' => 'uppercase',
                        ),
                        array(
                            'label' => __( 'Lowercase', 'live-composer-page-builder' ),
                            'value' => 'lowercase',
                        ),
                    ),
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu > li > a, .cs-skin-border ul span, .cs-select ul span',
                    'affect_on_change_rule' => 'text-transform',
                    'section' => 'styling',
                    'tab' => __( 'Item', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Spacing', 'live-composer-page-builder' ),
                    'id' => 'css_item_spacing',
                    'std' => '40',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu > li',
                    'affect_on_change_rule' => 'margin-left,margin-top',
                    'section' => 'styling',
                    'ext' => 'px',
                    'tab' => __( 'Item', 'live-composer-page-builder' ),
                ),

                array(
                    'label' => __( 'Chevron - Enable/Disable', 'live-composer-page-builder' ),
                    'id' => 'css_item_chevron_display',
                    'std' => 'none',
                    'type' => 'select',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation-arrow',
                    'affect_on_change_rule' => 'display',
                    'section' => 'styling',
                    'tab' => __( 'Item', 'live-composer-page-builder' ),
                    'choices' => array(
                        array(
                            'label' => __( 'Enabled', 'live-composer-page-builder' ),
                            'value' => 'inline-block',
                        ),
                        array(
                            'label' => __( 'Disabled', 'live-composer-page-builder' ),
                            'value' => 'none',
                        ),
                    ),
                ),
                array(
                    'label' => __( 'Chevron - Color', 'live-composer-page-builder' ),
                    'id' => 'css_item_chevron_color',
                    'std' => '#555555',
                    'type' => 'color',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation-arrow',
                    'affect_on_change_rule' => 'color',
                    'section' => 'styling',
                    'tab' => __( 'Item', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Chevron - Size', 'live-composer-page-builder' ),
                    'id' => 'css_item_chevron_size',
                    'std' => '10',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation-arrow',
                    'affect_on_change_rule' => 'font-size',
                    'section' => 'styling',
                    'tab' => __( 'Item', 'live-composer-page-builder' ),
                    'ext' => 'px',
                ),
                array(
                    'label' => __( 'Chevron - Spacing', 'live-composer-page-builder' ),
                    'id' => 'css_item_chevron_spacing',
                    'std' => '10',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation-arrow',
                    'affect_on_change_rule' => 'margin-left',
                    'section' => 'styling',
                    'tab' => __( 'Item', 'live-composer-page-builder' ),
                    'ext' => 'px',
                ),

                /**
                 * Subnav
                 */

                array(
                    'label' => __( 'Position', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_position',
                    'std' => 'default',
                    'type' => 'select',
                    'choices' => array(
                        array(
                            'label' => __( 'Default', 'live-composer-page-builder' ),
                            'value' => 'default',
                        ),
                        array(
                            'label' => __( 'Left', 'live-composer-page-builder' ),
                            'value' => 'left',
                        ),
                        array(
                            'label' => __( 'Center', 'live-composer-page-builder' ),
                            'value' => 'center',
                        ),
                        array(
                            'label' => __( 'Right', 'live-composer-page-builder' ),
                            'value' => 'right',
                        ),
                    ),
                    'section' => 'styling',
                    'tab' => __( 'Subnav', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Align', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_align',
                    'std' => 'left',
                    'type' => 'text_align',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu ul',
                    'affect_on_change_rule' => 'text-align',
                    'section' => 'styling',
                    'tab' => __( 'Subnav', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'BG Color', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_bg_color',
                    'std' => '#fff',
                    'type' => 'color',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu ul',
                    'affect_on_change_rule' => 'background-color',
                    'section' => 'styling',
                    'tab' => __( 'Subnav', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'BG Image', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_bg_img',
                    'std' => '',
                    'type' => 'image',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu ul',
                    'affect_on_change_rule' => 'background-image',
                    'section' => 'styling',
                    'tab' => __( 'Subnav', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'BG Image Repeat', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_bg_img_repeat',
                    'std' => 'repeat',
                    'type' => 'select',
                    'choices' => array(
                        array(
                            'label' => __( 'Repeat', 'live-composer-page-builder' ),
                            'value' => 'repeat',
                        ),
                        array(
                            'label' => __( 'Repeat Horizontal', 'live-composer-page-builder' ),
                            'value' => 'repeat-x',
                        ),
                        array(
                            'label' => __( 'Repeat Vertical', 'live-composer-page-builder' ),
                            'value' => 'repeat-y',
                        ),
                        array(
                            'label' => __( 'Do NOT Repeat', 'live-composer-page-builder' ),
                            'value' => 'no-repeat',
                        ),
                    ),
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu ul',
                    'affect_on_change_rule' => 'background-repeat',
                    'section' => 'styling',
                    'tab' => __( 'Subnav', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'BG Image Attachment', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_bg_img_attch',
                    'std' => 'scroll',
                    'type' => 'select',
                    'choices' => array(
                        array(
                            'label' => __( 'Scroll', 'live-composer-page-builder' ),
                            'value' => 'scroll',
                        ),
                        array(
                            'label' => __( 'Fixed', 'live-composer-page-builder' ),
                            'value' => 'fixed',
                        ),
                    ),
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu ul',
                    'affect_on_change_rule' => 'background-attachment',
                    'section' => 'styling',
                    'tab' => __( 'Subnav', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'BG Image Position', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_bg_img_pos',
                    'std' => 'top left',
                    'type' => 'select',
                    'choices' => array(
                        array(
                            'label' => __( 'Top Left', 'live-composer-page-builder' ),
                            'value' => 'left top',
                        ),
                        array(
                            'label' => __( 'Top Right', 'live-composer-page-builder' ),
                            'value' => 'right top',
                        ),
                        array(
                            'label' => __( 'Top Center', 'live-composer-page-builder' ),
                            'value' => 'Center Top',
                        ),
                        array(
                            'label' => __( 'Center Left', 'live-composer-page-builder' ),
                            'value' => 'left center',
                        ),
                        array(
                            'label' => __( 'Center Right', 'live-composer-page-builder' ),
                            'value' => 'right center',
                        ),
                        array(
                            'label' => __( 'Center', 'live-composer-page-builder' ),
                            'value' => 'center center',
                        ),
                        array(
                            'label' => __( 'Bottom Left', 'live-composer-page-builder' ),
                            'value' => 'left bottom',
                        ),
                        array(
                            'label' => __( 'Bottom Right', 'live-composer-page-builder' ),
                            'value' => 'right bottom',
                        ),
                        array(
                            'label' => __( 'Bottom Center', 'live-composer-page-builder' ),
                            'value' => 'center bottom',
                        ),
                    ),
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu ul',
                    'affect_on_change_rule' => 'background-position',
                    'section' => 'styling',
                    'tab' => __( 'Subnav', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Border Color', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_border_color',
                    'std' => '#ededed',
                    'type' => 'color',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu ul',
                    'affect_on_change_rule' => 'border-color',
                    'section' => 'styling',
                    'tab' => __( 'Subnav', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Border Width', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_border_width',
                    'onlypositive' => true, // Value can't be negative.
                    'max' => 10,
                    'std' => '1',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu ul',
                    'affect_on_change_rule' => 'border-width',
                    'section' => 'styling',
                    'ext' => 'px',
                    'tab' => __( 'Subnav', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Borders', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_border_trbl',
                    'std' => 'top right bottom left',
                    'type' => 'checkbox',
                    'choices' => array(
                        array(
                            'label' => __( 'Top', 'live-composer-page-builder' ),
                            'value' => 'top',
                        ),
                        array(
                            'label' => __( 'Right', 'live-composer-page-builder' ),
                            'value' => 'right',
                        ),
                        array(
                            'label' => __( 'Bottom', 'live-composer-page-builder' ),
                            'value' => 'bottom',
                        ),
                        array(
                            'label' => __( 'Left', 'live-composer-page-builder' ),
                            'value' => 'left',
                        ),
                    ),
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu ul',
                    'affect_on_change_rule' => 'border-style',
                    'section' => 'styling',
                    'tab' => __( 'Subnav', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Border Radius - Top', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_border_radius_top',
                    'onlypositive' => true, // Value can't be negative.
                    'std' => '0',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu ul',
                    'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
                    'section' => 'styling',
                    'ext' => 'px',
                    'tab' => __( 'Subnav', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Border Radius - Bottom', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_border_radius_bottom',
                    'onlypositive' => true, // Value can't be negative.
                    'std' => '0',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu ul',
                    'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
                    'section' => 'styling',
                    'ext' => 'px',
                    'tab' => __( 'Subnav', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_padding_vertical',
                    'onlypositive' => true, // Value can't be negative.
                    'max' => 600,
                    'std' => '10',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu ul',
                    'affect_on_change_rule' => 'padding-top,padding-bottom',
                    'section' => 'styling',
                    'ext' => 'px',
                    'tab' => __( 'Subnav', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_padding_horizontal',
                    'onlypositive' => true, // Value can't be negative.
                    'std' => '25',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu ul',
                    'affect_on_change_rule' => 'padding-left,padding-right',
                    'section' => 'styling',
                    'ext' => 'px',
                    'tab' => __( 'Subnav', 'live-composer-page-builder' ),
                ),

                /**
                 * Styling - Item
                 */

                array(
                    'label' => __( 'BG Color', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_item_bg_color',
                    'std' => '',
                    'type' => 'color',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu ul li a',
                    'affect_on_change_rule' => 'background-color',
                    'section' => 'styling',
                    'tab' => __( 'Subnav item', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'BG Color - Hover', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_item_bg_color_hover',
                    'std' => '',
                    'type' => 'color',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu ul li a:hover',
                    'affect_on_change_rule' => 'background-color',
                    'section' => 'styling',
                    'tab' => __( 'Subnav item', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'BG Color - Active', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_item_bg_color_active',
                    'std' => '',
                    'type' => 'color',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu ul li.current-menu-item > a',
                    'affect_on_change_rule' => 'background-color',
                    'section' => 'styling',
                    'tab' => __( 'Subnav item', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Border Color', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_item_border_color',
                    'std' => '#ededed',
                    'type' => 'color',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu ul li a',
                    'affect_on_change_rule' => 'border-color',
                    'section' => 'styling',
                    'tab' => __( 'Subnav item', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Border Color - Hover', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_item_border_color_hover',
                    'std' => '#ededed',
                    'type' => 'color',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu ul li > a:hover',
                    'affect_on_change_rule' => 'border-color',
                    'section' => 'styling',
                    'tab' => __( 'Subnav item', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Border Color - Active', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_item_border_color_active',
                    'std' => '#ededed',
                    'type' => 'color',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu ul li.current-menu-item > a',
                    'affect_on_change_rule' => 'border-color',
                    'section' => 'styling',
                    'tab' => __( 'Subnav item', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Border Width', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_item_border_width',
                    'onlypositive' => true, // Value can't be negative.
                    'max' => 10,
                    'std' => '1',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu ul li a',
                    'affect_on_change_rule' => 'border-width',
                    'section' => 'styling',
                    'ext' => 'px',
                    'tab' => __( 'Subnav item', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Borders', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_item_border_trbl',
                    'std' => 'bottom',
                    'type' => 'checkbox',
                    'choices' => array(
                        array(
                            'label' => __( 'Top', 'live-composer-page-builder' ),
                            'value' => 'top',
                        ),
                        array(
                            'label' => __( 'Right', 'live-composer-page-builder' ),
                            'value' => 'right',
                        ),
                        array(
                            'label' => __( 'Bottom', 'live-composer-page-builder' ),
                            'value' => 'bottom',
                        ),
                        array(
                            'label' => __( 'Left', 'live-composer-page-builder' ),
                            'value' => 'left',
                        ),
                    ),
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu ul li a',
                    'affect_on_change_rule' => 'border-style',
                    'section' => 'styling',
                    'tab' => __( 'Subnav item', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Border Radius - Top', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_item_border_radius_top',
                    'onlypositive' => true, // Value can't be negative.
                    'std' => '0',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu ul li a',
                    'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
                    'section' => 'styling',
                    'ext' => 'px',
                    'tab' => __( 'Subnav item', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Border Radius - Bottom', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_item_border_radius_bottom',
                    'onlypositive' => true, // Value can't be negative.
                    'std' => '0',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu ul li a',
                    'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
                    'section' => 'styling',
                    'ext' => 'px',
                    'tab' => __( 'Subnav item', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Color', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_item_color',
                    'std' => '#555555',
                    'type' => 'color',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu ul li a',
                    'affect_on_change_rule' => 'color',
                    'section' => 'styling',
                    'tab' => __( 'Subnav item', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Color - Hover', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_item_color_hover',
                    'std' => '#fd4970',
                    'type' => 'color',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu ul li a:hover',
                    'affect_on_change_rule' => 'color',
                    'section' => 'styling',
                    'tab' => __( 'Subnav item', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Color - Active', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_item_color_active',
                    'std' => '#fd4970',
                    'type' => 'color',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu ul li.current-menu-item > a',
                    'affect_on_change_rule' => 'color',
                    'section' => 'styling',
                    'tab' => __( 'Subnav item', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Font Size', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_item_font_size',
                    'onlypositive' => true, // Value can't be negative.
                    'std' => '13',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu ul li a',
                    'affect_on_change_rule' => 'font-size',
                    'section' => 'styling',
                    'tab' => __( 'Subnav item', 'live-composer-page-builder' ),
                    'ext' => 'px',
                ),
                array(
                    'label' => __( 'Font Weight', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_item_font_weight',
                    'std' => '700',
                    'type' => 'select',
                    'choices' => array(
                        array(
                            'label' => '100 - Thin',
                            'value' => '100',
                        ),
                        array(
                            'label' => '200 - Extra Light',
                            'value' => '200',
                        ),
                        array(
                            'label' => '300 - Light',
                            'value' => '300',
                        ),
                        array(
                            'label' => '400 - Normal',
                            'value' => '400',
                        ),
                        array(
                            'label' => '500 - Medium',
                            'value' => '500',
                        ),
                        array(
                            'label' => '600 - Semi Bold',
                            'value' => '600',
                        ),
                        array(
                            'label' => '700 - Bold',
                            'value' => '700',
                        ),
                        array(
                            'label' => '800 - Extra Bold',
                            'value' => '800',
                        ),
                        array(
                            'label' => '900 - Black',
                            'value' => '900',
                        ),
                    ),
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu ul li a',
                    'affect_on_change_rule' => 'font-weight',
                    'section' => 'styling',
                    'tab' => __( 'Subnav item', 'live-composer-page-builder' ),
                    'ext' => '',
                ),
                array(
                    'label' => __( 'Font Family', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_item_font_family',
                    'std' => 'Montserrat',
                    'type' => 'font',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu ul li a',
                    'affect_on_change_rule' => 'font-family',
                    'section' => 'styling',
                    'tab' => __( 'Subnav item', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Letter Spacing', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_item_letter_spacing',
                    'max' => 30,
                    'std' => '0',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu ul li a',
                    'affect_on_change_rule' => 'letter-spacing',
                    'section' => 'styling',
                    'tab' => __( 'Subnav item', 'live-composer-page-builder' ),
                    'ext' => 'px',
                    'min' => -50,
                    'max' => 50,
                ),
                array(
                    'label' => __( 'Line Height', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_item_line_height',
                    'onlypositive' => true, // Value can't be negative.
                    'std' => '13',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu ul li a',
                    'affect_on_change_rule' => 'line-height',
                    'section' => 'styling',
                    'tab' => __( 'Subnav item', 'live-composer-page-builder' ),
                    'ext' => 'px',
                ),
                array(
                    'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_item_padding_vertical',
                    'onlypositive' => true, // Value can't be negative.
                    'max' => 600,
                    'std' => '17',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu ul li a',
                    'affect_on_change_rule' => 'padding-top,padding-bottom',
                    'section' => 'styling',
                    'ext' => 'px',
                    'tab' => __( 'Subnav item', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_item_padding_horizontal',
                    'onlypositive' => true, // Value can't be negative.
                    'std' => '0',
                    'type' => 'slider',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu ul li a',
                    'affect_on_change_rule' => 'padding-left,padding-right',
                    'section' => 'styling',
                    'ext' => 'px',
                    'tab' => __( 'Subnav item', 'live-composer-page-builder' ),
                ),
                array(
                    'label' => __( 'Text Transform', 'live-composer-page-builder' ),
                    'id' => 'css_subnav_item_text_transform',
                    'std' => 'none',
                    'type' => 'select',
                    'choices' => array(
                        array(
                            'label' => __( 'None', 'live-composer-page-builder' ),
                            'value' => 'none',
                        ),
                        array(
                            'label' => __( 'Capitalize', 'live-composer-page-builder' ),
                            'value' => 'capitalize',
                        ),
                        array(
                            'label' => __( 'Uppercase', 'live-composer-page-builder' ),
                            'value' => 'uppercase',
                        ),
                        array(
                            'label' => __( 'Lowercase', 'live-composer-page-builder' ),
                            'value' => 'lowercase',
                        ),
                    ),
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-navigation .menu ul li a',
                    'affect_on_change_rule' => 'text-transform',
                    'section' => 'styling',
                    'tab' => __( 'Subnav item', 'live-composer-page-builder' ),
                ),

                /**
                 * Responsive
                 */

                array(
                    'label' => __( 'Responsive Styling', 'live-composer-page-builder' ),
                    'id' => 'css_res_t',
                    'std' => 'enabled',
                    'type' => 'select',
                    'choices' => array(
                        array(
                            'label' => __( 'Disabled', 'live-composer-page-builder' ),
                            'value' => 'disabled',
                        ),
                        array(
                            'label' => __( 'Enabled', 'live-composer-page-builder' ),
                            'value' => 'enabled',
                        ),
                    ),
                ),

                array(
                    'label' => __( 'Responsive Align', 'live-composer-page-builder' ),
                    'id' => 'css_res_align',
                    'std' => 'right',
                    'type' => 'text_align',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => '.dslc-mobile-navigation, .cs-select ul',
                    'affect_on_change_rule' => 'text-align',
                    'section' => 'responsive',
                    'tab' => __( 'Responsive Menu', 'live-composer-page-builder' ),
                ),

                array(
                    'label' => __( 'Responsive Styling', 'live-composer-page-builder' ),
                    'id' => 'css_res_p',
                    'std' => 'enabled',
                    'type' => 'select',
                    'choices' => array(
                        array(
                            'label' => __( 'Disabled', 'live-composer-page-builder' ),
                            'value' => 'disabled',
                        ),
                        array(
                            'label' => __( 'Enabled', 'live-composer-page-builder' ),
                            'value' => 'enabled',
                        ),
                    ),
                    'section' => 'styling',
                ),

            );

            // Return the array
            $options = array_merge( $options, $this->presets_options() );

            return apply_filters( 'dslc_module_options', $options, $this->module_id );

        }
     
        // Module Output
        function output( $options ) {

        $this->module_start( $options );

        /* Module output starts here */

        global $dslc_active;

        if ( $dslc_active && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {
            $dslc_is_admin = true;
        } else {
            $dslc_is_admin = false;
        }

        if ( 'not_set' === $options['location'] ) {

            if ( $dslc_is_admin ) {

                ?><div class="dslc-notification dslc-red"><?php esc_attr_e( 'Edit the module and choose which location to show.', 'live-composer-page-builder' ); ?> <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></span></div><?php
            }
        } elseif ( ! has_nav_menu( $options['location'] ) ) {

            if ( $dslc_is_admin ) {

                ?><div class="dslc-notification dslc-red"><?php esc_attr_e( 'The chosen location does not have a menu assigned.', 'live-composer-page-builder' ); ?> <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></span></div><?php
            }
        } else {
            ?>
            <div class="dslc-navigation dslc-navigation-sub-position-<?php echo esc_attr( $options['css_subnav_position'] ); ?> dslc-navigation-res-t-<?php echo esc_attr( $options['css_res_t'] ); ?> dslc-navigation-res-p-<?php echo esc_attr( $options['css_res_p'] ); ?> dslc-navigation-orientation-<?php echo esc_attr( $options['nav_orientation'] ); ?>">
                <div class="dslc-navigation-inner">
                    <?php wp_nav_menu( array( 'theme_location' => $options['location'] ) ); ?>
                </div>
            </div>
            <div class="dslc-mobile-navigation dslc-navigation-res-t-<?php echo esc_attr( $options['css_res_t'] ); ?>  dslc-navigation-res-p-<?php echo esc_attr( $options['css_res_p'] ); ?>">
                <?php
                if ( has_nav_menu( $options['location'] ) ) {

                    $placeholder = $options['res_text'];
                    $select_class = 'cs-select cs-skin-underline ';
                    $mobile_nav_output = '';
                    $mobile_nav_output .= '<select class="' . $select_class . '" value="' . $options['location'] . '">';
                    $mobile_nav_output .= '<option disabled>' . $placeholder . '</option>';

                    if ( has_nav_menu( $options['location'] ) ) {

                        $locations = get_nav_menu_locations();
                        $menu = wp_get_nav_menu_object( $locations[ $options['location'] ] );
                        $menu_items = wp_get_nav_menu_items( $menu->term_id );

                        foreach ( $menu_items as $key => $menu_item ) {

                            $title = $menu_item->title;
                            $url = $menu_item->url;
                            $nav_selected = '';

                            if ( $menu_item->menu_item_parent ) {
                                $mobile_nav_output .= '<option data-class="menu-item child" data-link="' . $url . '" ' . $nav_selected . $title .'>' . $title . '</option>';
                            } else {
                                $mobile_nav_output .= '<option  data-class="menu-item" data-link="' . $url . '" ' . $nav_selected . '>' . $title . '</option>';
                            }
                        }
                    }

                    $mobile_nav_output .= '</select>';
                    echo $mobile_nav_output;
                }
                ?>
            </div><!-- .dslc-mobile-navigation -->

            <?php 
                if (function_exists('load_my_scripts')) {
                    function load_my_scripts() {
                        wp_enqueue_script( 'classie', plugin_dir_url( __FILE__ ) . 'js/classie.js', false, null, false  );
                        wp_enqueue_script( 'selectFx', plugin_dir_url( __FILE__ ) . 'js/selectFx.js', false, null, false );
                    }
                }
                add_action('admin_init', 'load_my_scripts'); 
            ?>

            <script type="text/javascript" src="<?= plugin_dir_url( __FILE__ ) . 'js/classie.js' ?>"></script>

            <script type="text/javascript" src="<?= plugin_dir_url( __FILE__ ) . 'js/selectFx.js' ?>"></script>


            <script>
                (function() {
                    [].slice.call( document.querySelectorAll( 'select.cs-select' ) ).forEach( function(el) { 
                        
                        new SelectFx(el, {
                            newTab: false
                        });
                    } );
                })();
            </script>

            <script type="text/javascript">
                var menuItems = document.querySelectorAll( '.dslc-navigation .menu > li.menu-item-has-children:not(.menu-with-arrow) > a' );

                for (var i = 0, len = menuItems.length; i < len; i++) {
                  menuItems[i].insertAdjacentHTML('afterend', '<span class="dslc-navigation-arrow dslc-icon dslc-icon-chevron-down"></span>');
                  menuItems[i].parentElement.className += " menu-with-arrow";
                }

                var childItems = document.querySelectorAll( '.menu > li.child > a');
                for (var i = 0, len = childItems.length; i < len; i++) {
                  childItems[i].insertAdjacentHTML('beforerend', '<span class="dslc-navigation-arrow dslc-icon dslc-icon-chevron-right"></span>');
                }

            </script>
            <?php
        }

        /* Module output ends here */

        $this->module_end( $options );

    	}
     
    }

}

function my_nav_module_defaults( $options, $id ) {

    // The array that will hold new defaults
    $new_defaults = array();

    if ( $id == 'My_Nav_Module' ) {
        $new_defaults = array(
            'location' => 'dslc_main_nav',
            'res_text' => 'MENU',
            'css_res_ph_bg_color' => 'rgba(0,0,0,0)',
            'css_res_border_color' => '#303030',
            'css_res_border_width' => '3',
            'css_margin_bottom' => '20',
            'css_res_dropdown_bg_color_active' => '#353535',
            'css_res_dd_border_color' => '#424242',
            'css_res_dd_border_width' => '3',
            'css_res_dd_borders' => 'right left ',
            'css_dd_border_radius' => '5',
            'css_item_color' => '#fd4970',
            'css_res_item_color_hover' => '#ffffff',
            'css_res_item_bg_color_active' => '#383838',
            'css_item_font_size' => '29',
            'css_res_item_font_size' => '19',
            'css_item_font_weight, .cs-select span' => '',
            'css_res_item_spacing' => '3',
            'css_res_item_padding_vertical' => '18',
            'css_res_item_padding_horizontal' => '25',
            'css_dd_margin_top_horizontal' => '15',
            'css_item_text_transform' => 'uppercase',
            'css_res_align' => 'center',
        );
    }

    return dslc_set_defaults( $new_defaults, $options );
 
} 
add_filter( 'dslc_module_options', 'my_nav_module_defaults', 10, 2 );
