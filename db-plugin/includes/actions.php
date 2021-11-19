<?php
    /*
     * Add main page of plugin to admin menu
     */
    add_action( 'admin_menu', 'db_plugin_admin_page');

    function db_plugin_admin_page() {
        add_menu_page(
            __( 'DB Plugin', 'dbplugin' ),
            __( 'DB Plugin', 'dbplugin' ),
            'manage_options',
            'db-plugin',
            'list_table_page',
            'dashicons-schedule',
            20
        );
    }

    function list_table_page() {
        $exampleListTable = new Example_List_Table();
        $exampleListTable->prepare_items();
        ?>
        <div class="wrap">
            <div id="icon-users" class="icon32"></div>
            <h2>List Table Page</h2>
            <?php $exampleListTable->display(); ?>
        </div>
        <?php
    }

    /**
     * WP_List_Table is not loaded automatically so we need to load it in our application
     */
    if( ! class_exists( 'WP_List_Table' ) ) {
        require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
    }

    /**
     * Create a new table class that will extend the WP_List_Table
     */
    include plugin_dir_path( WP_PLUGIN_DIR ) . '/plugins/db-plugin/class/list-table-class.php';

    /**
     * Add submenu page for create data to database
     */
    add_action('admin_menu', 'register_db_plugin_submenu_create_page');

    function register_db_plugin_submenu_create_page() {
        add_submenu_page(
            'db-plugin',
            __( 'Add data', 'my-textdomain' ),
            __( 'Add data', 'my-textdomain' ),
            'edit_pages',
            'create_data_db',
            'create_data_db_page_contents'
        );
    }

    function create_data_db_page_contents() {
        global $wpdb;

        $table_name = $wpdb->prefix . PREFIX_DB;

        $post = (!empty($_POST));
        if($post) {

            if ( !wp_verify_nonce( $_POST['db_plugin_noncename'], "db-plugin/db-plugin.php" ) )
                return;

            $name_team_val = $_POST['name-team-input'];
            $city_team_val = $_POST['city-team-input'];
            $state_team_val = $_POST['state-team-input'];
            $stadium_team_val = $_POST['stadium-team-input'];

            $result = $wpdb->insert( $table_name, [
                'team_name' => $name_team_val,
                'team_city' => $city_team_val,
                'team_state' => $state_team_val,
                'team_stadium' => $stadium_team_val
            ] );
        }

        include plugin_dir_path( WP_PLUGIN_DIR ) . '/plugins/db-plugin/template/add-data.php';
    }

    /**
     * Add submenu page for edit data to database
     */
    add_action('admin_menu', 'register_db_plugin_submenu_edit_page');

    function register_db_plugin_submenu_edit_page() {
        add_submenu_page(
            'options.php',
            __( 'Edit data', 'my-textdomain' ),
            __( 'Edit data', 'my-textdomain' ),
            'edit_pages',
            'edit_data_db',
            'edit_data_db_page_contents'
        );
    }

    function edit_data_db_page_contents() {

        global $wpdb;

        $table_name = $wpdb->prefix . PREFIX_DB;

        if ( $_GET["action"] === "edit" ) {

            $id = $_GET["id"];
            $sql = $wpdb->prepare( "SELECT * FROM $table_name WHERE team_id = $id" );

            $row = $wpdb->get_row( $sql, ARRAY_A );

        }

        $post = (!empty($_POST));

        if ( $post ) {
            if ( !wp_verify_nonce( $_POST['db_plugin_noncename'], "db-plugin/db-plugin.php" ) )
                return;

            $up_team_id = $_POST['id-team-input'];
            $up_team_name = $_POST['name-team-input'];
            $up_team_city = $_POST['city-team-input'];
            $up_team_state = $_POST['state-team-input'];
            $up_team_stadium = $_POST['stadium-team-input'];

            $sql = $wpdb->prepare( "SELECT * FROM $table_name WHERE team_id = $team_id" );

            $result = $wpdb->update( $table_name,
                [
                    'team_name'    => $up_team_name,
                    'team_city'     => $up_team_city,
                    'team_state'    => $up_team_state,
                    'team_stadium'  => $up_team_stadium
                ],
                [ 'team_id' => $up_team_id ]
            );

        }

        include plugin_dir_path( WP_PLUGIN_DIR ) . '/plugins/db-plugin/template/edit-data.php';
    }

    /**
     * Add submenu page for del data from database
     */
    add_action('admin_menu', 'register_db_plugin_submenu_del_page');

    function register_db_plugin_submenu_del_page() {
        add_submenu_page(
            'options.php',
            __( 'Edit data', 'my-textdomain' ),
            __( 'Edit data', 'my-textdomain' ),
            'edit_pages',
            'del_data_db',
            'remove_item_from_db'
        );
    }

    function remove_item_from_db() {

        global $wpdb;

        $table_name = $wpdb->prefix . PREFIX_DB;

        $get = (!empty($_GET));

        if( $get ) {

            if ( $_GET["action"] === "delete" ) {
                $id = $_GET["id"];
                $result = $wpdb->delete( $table_name, [ 'team_id' => $id ] );
                if( !empty($result) ) {
                    echo    "<div>Deleted!<br>
                                    <a href=" . get_admin_url( null, 'admin.php?page=db-plugin' ) . ">Come back</a></div>";
                }

            }

        }

    }

    /**
     * necessary scripts
     */
    function register_db_plugin_scripts() {

        wp_register_script( 'db-plugin', plugins_url( 'db-plugin/js/db-plugin.js' ) );

    }

    add_action( 'admin_enqueue_scripts', 'register_db_plugin_scripts' );

    function load_db_plugin_scripts( $hook ) {


        // Load only on ?page=db-plugin

        if( $hook != 'toplevel_page_db-plugin' && $hook != "db-plugin_page_edit_data_db" ) {

            return;

        }

        // Load style & scripts.

        wp_enqueue_script( 'db-plugin' );

    }

    add_action( 'admin_enqueue_scripts', 'load_db_plugin_scripts' );