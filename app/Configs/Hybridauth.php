<?php

/**
 * HybridAuth
 * http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
 * (c) 2009-2015, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
 */
// ----------------------------------------------------------------------------------------
//	HybridAuth Config file: http://hybridauth.sourceforge.net/userguide/Configuration.html
// ----------------------------------------------------------------------------------------

return
    array(
        "base_url" => 'http://localhost/makanplz_core/public/api/v1/auth/hybridauth/',
        "providers" => array(
            "Google" => array(
                "enabled" => true,
                "keys" => array("id" => "110894562329-l35podth4nok67lq3dr45jhhlf9p7sv8.apps.googleusercontent.com", "secret" => "VDtKd2hIg6r6InRCLyUuDxGT"),
            ),
            "Facebook" => array(
                "enabled" => true,
                "keys" => array("id" => "1048424188607752", "secret" => "c9e4169d8b3831e292cf229cd14e6b3a"),
                "scope" => "email, user_about_me", // optional
                "display" => "popup" // optional
            ),
            "Twitter" => array(
                "enabled" => false,
                "keys" => array("key" => "714012650611429377", "secret" => ""),
                "includeEmail" => false
            ),
            "Foursquare" => array(
                "enabled" => false,
                "keys" => array("id" => "", "secret" => "")
            ),
        ),
        // If you want to enable logging, set 'debug_mode' to true.
        // You can also set it to
        // - "error" To log only error messages. Useful in production
        // - "info" To log info and error messages (ignore debug messages)
        "debug_mode" => true,
        // Path to file writable by the web server. Required if 'debug_mode' is not false
        "debug_file" => dirname(dirname(dirname(__FILE__))) . '/logs/hybridauth-error.text',
    );
