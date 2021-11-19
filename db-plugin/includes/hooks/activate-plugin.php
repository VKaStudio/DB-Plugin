<?php
    register_activation_hook( WP_PLUGIN_DIR . '/plugins/db-plugin/db-plugin.php', 'db_plugin_activate' );

    function db_plugin_activate(){
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        $table_name = $wpdb->prefix . PREFIX_DB;
        $sql = "CREATE TABLE $table_name (
                team_id INTEGER NOT NULL AUTO_INCREMENT,
                team_name TEXT NOT NULL,
                team_city TEXT NOT NULL,
                team_state TEXT NOT NULL,
                team_stadium TEXT NOT NULL,
                PRIMARY KEY (team_id)
            ) $charset_collate;";
        dbDelta( $sql );
    }