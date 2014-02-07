<?php

if ( !class_exists( "ReduxFramework" ) ) {
    return;
}

if ( !class_exists( "ATS_Config" ) ) {
    class ATS_Config {

        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;

        public function __construct( ) {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if ( !isset( $this->args['opt_name'] ) ) { // No errors please
                return;
            }

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);

        }

        /**

        Custom function for filtering the sections array. Good for child themes to override or add to the sections.
        Simply include this function in the child themes functions.php file.

        NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
        so you must use get_template_directory_uri() if you want to use any of the built in icons

         **/

        function dynamic_section($sections){
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', 'redux-framework-demo'),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'redux-framework-demo'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if ( class_exists('ReduxFrameworkPlugin') ) {
                remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_meta_demo_mode_link'), null, 2 );
            }

            // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
            remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );

        }


        public function setSections() {

            global $themes;

            $devmode_1 = 'In developer mode, you can assign an installed theme to your username and fully configure it\'s look/feel without disrupting the live site. Once the target theme is configured, you can assign it to old browser versions in the "Theme Pairing" tab.';
            $devmode_2 = 'Running the Alternate Theme Switcher in dev mode will cause wp_mail to break. Do not do this while live mail operations are underway!';
            $devmode_3 = 'Technical Explanation';

            $this->sections[] = array(
                'title' => __('Developer Mode', 'ats-plugin'),
                'desc' => '<p>' . $devmode_1 . '</p><p><span style="color: red;"><i class="el-icon-warning-sign"></i> ' . $devmode_2 . '</span> (<a href="https://github.com/ReduxFramework/ReduxFramework/wiki/How-to-fix-%22Fatal-error%3A-Call-to-undefined-function-wp_get_current_user%28%29-%22" target="_blank">' . $devmode_3 . '</a>)</p>',
                'icon' => 'el-icon-cogs',
                'fields' => array(
                    array(
                        'id'=>'dev_mode',
                        'type' => 'switch',
                        'title' => __('Developer Mode', 'ats-plugin'),
                        'subtitle'=> __('Turning this on will cause the theme selected below to be your user name\'s default until it is disabled.', 'ats-plugin'),
                        'default' 		=> 0,
                    ),
                    array(
                        'id'=>'dev_theme',
                        'type' => 'select',
                        'title' => __('Theme Selector', 'ats-plugin'),
                        'subtitle' => __('Installed Themes', 'ats-plugin'),
                        'options' => $themes,
                    ),
                ),
            );

            $this->sections[] = array(
                'title' => __('Theme Pairing', 'ats-plugin'),
                'desc' => __('<p>Here you will find a plethora of neanderthal browsers. It\'s like a museum of pain! Chose which theme to display for each browser condition and don\'t forget to configure each theme\'s options in Developer Mode.</p>', 'ats-plugin'),
                'icon' => 'el-icon-magnet',
                'fields' => array(
                    array(
                        'id'=>'ie5_switch',
                        'type' => 'switch',
                        'title' => __('Enable IE5 Support', 'ats-plugin'),
                        'subtitle'=> __('Switching this on will cause the associated theme to display for all IE5 browsers', 'ats-plugin'),
                        "default" 		=> 0,
                    ),
                    array(
                        'id'=>'ie5_theme',
                        'type' => 'select',
                        'title' => __('Internet Explorer 5 Theme', 'ats-plugin'),
                        'subtitle' => __('Choose the theme you would like to display for IE5 users', 'ats-plugin'),
                        'options' => $themes,
                    ),
                    array(
                        'id'=>'ie6_switch',
                        'type' => 'switch',
                        'title' => __('Enable IE6 Support', 'ats-plugin'),
                        'subtitle'=> __('Switching this on will cause the associated theme to display for all IE6 browsers', 'ats-plugin'),
                        "default" 		=> 0,
                    ),
                    array(
                        'id'=>'ie6_theme',
                        'type' => 'select',
                        'title' => __('Internet Explorer 6 Theme', 'ats-plugin'),
                        'subtitle' => __('Choose the theme you would like to display for IE6 users', 'ats-plugin'),
                        'options' => $themes,
                    ),
                    array(
                        'id'=>'ie7_switch',
                        'type' => 'switch',
                        'title' => __('Enable IE7 Support', 'ats-plugin'),
                        'subtitle'=> __('Switching this on will cause the associated theme to display for all IE7 browsers', 'ats-plugin'),
                        "default" 		=> 0,
                    ),
                    array(
                        'id'=>'ie7_theme',
                        'type' => 'select',
                        'title' => __('Internet Explorer 7 Theme', 'ats-plugin'),
                        'subtitle' => __('Choose the theme you would like to display for IE7 users', 'ats-plugin'),
                        'options' => $themes,
                    ),
                    array(
                        'id'=>'ie8_switch',
                        'type' => 'switch',
                        'title' => __('Enable IE8 Support', 'ats-plugin'),
                        'subtitle'=> __('Switching this on will cause the associated theme to display for all IE8 browsers', 'ats-plugin'),
                        "default" 		=> 0,
                    ),
                    array(
                        'id'=>'ie8_theme',
                        'type' => 'select',
                        'title' => __('Internet Explorer 8 Theme', 'ats-plugin'),
                        'subtitle' => __('Choose the theme you would like to display for IE8 users', 'ats-plugin'),
                        'options' => $themes,
                    ),
                    array(
                        'id'=>'ie9_switch',
                        'type' => 'switch',
                        'title' => __('Enable IE9 Support', 'ats-plugin'),
                        'subtitle'=> __('Setting this probably isn\'t necessary', 'ats-plugin'),
                        "default" 		=> 0,
                    ),
                    array(
                        'id'=>'ie9_theme',
                        'type' => 'select',
                        'title' => __('Internet Explorer 9 Theme', 'ats-plugin'),
                        'subtitle' => __('Choose the theme you would like to display for IE9 users', 'ats-plugin'),
                        'options' => $themes,
                    ),
                    array(
                        'id'=>'ie10_switch',
                        'type' => 'switch',
                        'title' => __('Enable IE10 Support', 'ats-plugin'),
                        'subtitle'=> __('Setting this almost certainly isn\'t necessary', 'ats-plugin'),
                        "default" 		=> 0,
                    ),
                    array(
                        'id'=>'ie10_theme',
                        'type' => 'select',
                        'title' => __('Internet Explorer 10 Theme', 'ats-plugin'),
                        'subtitle' => __('Choose the theme you would like to display for IE10 users', 'ats-plugin'),
                        'options' => $themes,
                    ),
                ),
            );

        }

        // Options Page Definitions

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id' => 'help-instructions',
                'title' => __('Instructions', 'ats-plugin'),
                'content' => __('<p>A bit of help is going to go in this area. Alas, I haven\'t written it yet.</p>', 'ats-plugin')
            );

            $this->args['help_tabs'][] = array(
                'id' => 'help-credits',
                'title' => __('Credits', 'ats-plugin'),
                'content' => __('<p>This tab will contain a bit of information on Imperative Ideas</p>', 'ats-plugin')
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = __('<p>This is the help sidebar content, I may not use it at all.</p>', 'ats-plugin');
        }


        /**

        All the possible arguments for Redux.
        For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         **/
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(

                // TYPICAL -> Change these values as you need/desire
                'opt_name'          	=> 'ats_plugin', // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'			=> ATS_NAME, // Name that appears at the top of your panel
                'display_version'		=> ATS_VERSION, // Version that appears at the top of your panel
                'menu_type'          	=> 'submenu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'     	=> true, // Show the sections below the admin menu item or not
                'menu_title'			=> __( 'ATS Options', 'ats-plugin' ),
                'page'		 	 		=> __( ATS_NAME . 'Options', 'ats-plugin' ),
                'google_api_key'   	 	=> 'AIzaSyBeQyjy7LCB5j0bGw_DeXDyWeF1otKc2_c', // Must be defined to add google fonts to the typography module
                'global_variable'    	=> '', // Set a different name for your global variable other than the opt_name
                'dev_mode'           	=> false, // Show the time the page took to load, etc
                'customizer'         	=> false, // Enable basic customizer support

                // OPTIONAL -> Give you extra features
                'page_priority'      	=> null, // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'        	=> 'options-general.php', // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'   	=> 'manage_options', // Permissions needed to access the options panel.
                'menu_icon'          	=> '', // Specify a custom URL to an icon
                'last_tab'           	=> '', // Force your panel to always open to a specific tab (by id)
                'page_icon'          	=> 'icon-themes', // Icon displayed in the admin panel next to your menu_title
                'page_slug'          	=> 'ats_plugin', // Page slug used to denote the panel
                'save_defaults'      	=> true, // On load save the defaults to DB before user clicks save or not
                'default_show'       	=> false, // If true, shows the default value next to each field that is not the default value.
                'default_mark'       	=> '', // What to print by the field's title if the value shown is default. Suggested: *


                // CAREFUL -> These options are for advanced use only
                'transient_time' 	 	=> 60 * MINUTE_IN_SECONDS,
                'output'            	=> true, // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'            	=> true, // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                //'domain'             	=> 'redux-framework', // Translation domain key. Don't change this unless you want to retranslate all of Redux.
                //'footer_credit'      	=> '', // Disable the footer credit of Redux. Please leave if you can help it.


                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'           	=> '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!


                'show_import_export' 	=> false, // REMOVE
                'system_info'        	=> false, // REMOVE

                'help_tabs'          	=> array(),
                'help_sidebar'       	=> '', // __( '', $this->args['domain'] );
            );


            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.

            $this->args['share_icons'][] = array(
                'url' => 'https://facebook.com/imperativeideas',
                'title' => 'Like me on Facebook',
                'icon' => 'el-icon-facebook'
            );
            $this->args['share_icons'][] = array(
                'url' => 'http://twitter.com/imperativeideas',
                'title' => 'Follow me on Twitter',
                'icon' => 'el-icon-twitter'
            );
            $this->args['share_icons'][] = array(
                'url' => 'http://www.linkedin.com/in/isarmstrong/',
                'title' => 'Find me on LinkedIn',
                'icon' => 'el-icon-linkedin'
            );



            // Panel Intro text -> before the form
            $this->args['intro_text'] = '<p>';
            $this->args['intro_text'] .= __('The Alternate Theme Selector allows you to specify alternate themes for old versions of IE, which solves a whole lot of developer problems. My personal preference is to set up multiple <a href="http://wordpress.org/themes/twentyten" target="_blank">TwentyTen</a> and <a href="http://wordpress.org/themes/twentytwelve" target="_blank">TwentyTwelve</a> child themes.', 'ats-plugin');
            $this->args['intro_text'] .= '</p><br /><p>';
            $this->args['intro_text'] .= __('It\'s generally best to select a theme from an era that was designed to support your neanderthal guest. For a more detailed explaination, use the "Help" tab in the upper right hand corner.', 'ats-plugin');
            $this->args['intro_text'] .= '</p><ul style="padding: 0 0 0 12px; color:#888888;"><li><i class="el-icon-ok" style="color: mediumseagreen;"></i> ';
            $this->args['intro_text'] .= __('Configure your alternate themes in "Developer Mode"', 'ats-plugin');
            $this->args['intro_text'] .= '</li><li><i class="el-icon-ok" style="color: mediumseagreen;"></i> ';
            $this->args['intro_text'] .= __('Assign themes to browsers in the "Theme Pairing" tab', 'ats-plugin');
            $this->args['intro_text'] .= '</li></ul>';


            // Add content after the form.
            $this->args['footer_text'] = __('<p style="text-align: center;">This plugin was developed by <a href="http://imperativeideas.com" title="Imperative Ideas | Designed for Humans">Imperative Ideas</a> to make supporting old browsers easier, then shared with the world free of charge, because it makes the Internet a happier place.<br />A special thanks to the <a href="http://reduxframework.com/" title="ReduxFramework for WordPress">Redux Framework</a> crew for creating such an incredible tool for building admin screens.</p>', 'ats-plugin');

        }
    }
    new ATS_Config();

}


/**

Custom function for the callback referenced above

 */
if ( !function_exists( 'redux_my_custom_field' ) ):
    function redux_my_custom_field($field, $value) {
        print_r($field);
        print_r($value);
    }
endif;

/**

Custom function for the callback validation referenced above

 **/
if ( !function_exists( 'redux_validate_callback_function' ) ):
    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value =  'just testing';
        /*
        do your validation

        if(something) {
            $value = $value;
        } elseif(something else) {
            $error = true;
            $value = $existing_value;
            $field['msg'] = 'your custom error message';
        }
        */

        $return['value'] = $value;
        if($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;