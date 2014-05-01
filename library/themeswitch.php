<?php

// Fetch theme options array
global $ats_plugin;
global $is_IE;

// Initialize the main variables
global $ats_active;
global $the_theme;
global $the_template;

// We only want to run this fat chunk of logic on IE since it's IE with the issues
if ($is_IE) {

// Is a supported useragent active?
    function checkActive($data)
    {
        global $ats_active;

        if (strpos(USER_AGENT, 'MSIE 5')) {
            if ($data['ie5_switch'] == 1 && !empty($data['ie5_theme'])) {
                $ats_active = 'ie5';
            };
        } else if (strpos(USER_AGENT, 'MSIE 6')) {
            if ($data['ie6_switch'] == 1 && !empty($data['ie6_theme'])) {
                $ats_active = 'ie6';
            };
        } else if (strpos(USER_AGENT, 'MSIE 7')) {
            if ($data['ie7_switch'] == 1 && !empty($data['ie7_theme'])) {
                $ats_active = 'ie7';
            };
        } else if (strpos(USER_AGENT, 'MSIE 8')) {
            if ($data['ie8_switch'] == 1 && !empty($data['ie8_theme'])) {
                $ats_active = 'ie8';
            };
        } else if (strpos(USER_AGENT, 'MSIE 9')) {
            if ($data['ie9_switch'] == 1 && !empty($data['ie9_theme'])) {
                $ats_active = 'ie9';
            };
        } else if (strpos(USER_AGENT, 'MSIE 10')) {
            if ($data['ie10_switch'] == 1 && !empty($data['ie10_theme'])) {
                $ats_active = 'ie10';
            };
        } else {
            $ats_active = 0;
        }

        return $ats_active;
    }

// Run active agents check
    checkActive($ats_plugin);

    if (!empty($ats_active)) {

        function change_theme()
        {
            global $ats_plugin;
            global $ats_active;
            global $the_theme;

            if (!empty($ats_plugin['ie5_theme'])) {
                $ie5 = $ats_plugin['ie5_theme'];
            } else {
                $ie5 = null;
            }
            if (!empty($ats_plugin['ie6_theme'])) {
                $ie6 = $ats_plugin['ie6_theme'];
            } else {
                $ie6 = null;
            }
            if (!empty($ats_plugin['ie7_theme'])) {
                $ie7 = $ats_plugin['ie7_theme'];
            } else {
                $ie7 = null;
            }
            if (!empty($ats_plugin['ie8_theme'])) {
                $ie8 = $ats_plugin['ie8_theme'];
            } else {
                $ie8 = null;
            }
            if (!empty($ats_plugin['ie9_theme'])) {
                $ie9 = $ats_plugin['ie9_theme'];
            } else {
                $ie9 = null;
            }
            if (!empty($ats_plugin['ie10_theme'])) {
                $ie10 = $ats_plugin['ie10_theme'];
            } else {
                $ie10 = null;
            }

            $theme_key = array(
                'ie5' => $ie5,
                'ie6' => $ie6,
                'ie7' => $ie7,
                'ie8' => $ie8,
                'ie9' => $ie9,
                'ie10' => $ie10
            );

            // Only one value should return
            foreach ($theme_key as $browser => $selection) {
                if ($ats_active == $browser) {
                    $the_theme = $selection;
                }
            }

            return $the_theme;
        }

        // Set the returned theme to a variable so we can calculate the template in case of children
        $chosen = change_theme();

        // Move the chosen theme back to a function for the final action (better than running the logic twice)
        function fetch_theme()
        {
            global $chosen;
	        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	        header("Cache-Control: post-check=0, pre-check=0", false);
	        header("Pragma: no-cache");
            return $chosen;
        }

        // In case of child theming, we need to calculate the template from the selected item
        function if_child_theme()
        {
            global $chosen;
	        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	        header("Cache-Control: post-check=0, pre-check=0", false);
	        header("Pragma: no-cache");
            global $the_template;
            $theme_data = wp_get_theme($chosen);
            $the_template = $theme_data['Template'];
            return $the_template;
        }

        // Filter it all down to the user
        add_filter('template', 'if_child_theme');
        add_filter('option_template', 'fetch_theme');
        add_filter('option_stylesheet', 'fetch_theme');
    }
}

// For non-IE browsers, we check if the user is an admin and enable developer mode
// IMPORTANT: Running the Alternate Theme Switcher in dev mode will cause wp_mail to temporarily break.
if ($ats_plugin['dev_mode'] == 1 && !empty($ats_plugin['dev_theme'])) {

    global $the_template;
    $the_template = "";

    if (!function_exists('wp_get_current_user')) {
        require(ABSPATH . WPINC . '/pluggable.php');
    }

    if (current_user_can('manage_options')) {

        function dev_theme()
        {
            global $ats_plugin;
	        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	        header("Cache-Control: post-check=0, pre-check=0", false);
	        header("Pragma: no-cache");
            $the_theme = $ats_plugin['dev_theme'];
            return $the_theme;
        }

        function if_child_theme()
        {
            global $ats_plugin;
            global $the_template;
	        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	        header("Cache-Control: post-check=0, pre-check=0", false);
	        header("Pragma: no-cache");
            $theme_data = wp_get_theme($ats_plugin['dev_theme']);
            $the_template = $theme_data['Template'];
            return $the_template;
        }

        /* @todo if the theme is in developer mode, there should be a visual warning as a reminder */

        if ($ats_plugin['dev_mode'] == 1) {
            add_filter('template', 'if_child_theme');
            add_filter('option_template', 'dev_theme');
            add_filter('option_stylesheet', 'dev_theme');
        }
    }
}