<?php
    register_deactivation_hook( WP_PLUGIN_DIR . '/plugins/db-plugin/db-plugin.php', 'db_plugin_deactivation' );

    function db_plugin_deactivation() {
        global $wpdb;
        $table_name = $wpdb->prefix . PREFIX_DB;
        $sql = $wpdb->prepare("DROP TABLE IF EXISTS $table_name");
        $wpdb->query($sql);
    }