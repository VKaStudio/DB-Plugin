<?php
class Example_List_Table extends WP_List_Table
    {
        /**
         * Prepare the items for the table to process
         *
         * @return Void
         */
        public function prepare_items()
        {
            $columns = $this->get_columns();
            $hidden = $this->get_hidden_columns();
            $sortable = $this->get_sortable_columns();

            $data = $this->table_data();
            usort( $data, array( &$this, 'sort_data' ) );

            $perPage = 15;
            $currentPage = $this->get_pagenum();
            $totalItems = count($data);

            $this->set_pagination_args( array(
                'total_items' => $totalItems,
                'per_page'    => $perPage
            ) );

            $data = array_slice($data,(($currentPage-1)*$perPage),$perPage);

            $this->_column_headers = array($columns, $hidden, $sortable);
            $this->items = $data;
        }

        /**
         * Override the parent columns method. Defines the columns to use in your listing table
         *
         * @return Array
         */
        public function get_columns()
        {
            $columns = array(
                'team_id'           => __( 'ID', 'dbplugin'),
                'team_name'         => __( 'Name', 'dbplugin'),
                'team_city'         => __( 'City', 'dbplugin'),
                'team_state'        => __( 'State', 'dbplugin'),
                'team_stadium'      => __( 'Stadium', 'dbplugin'),
                'action'            => __( 'Action', 'dbplugin')

            );

            return $columns;
        }

        /**
         * Define which columns are hidden
         *
         * @return Array
         */
        public function get_hidden_columns()
        {
            return array();
        }

        /**
         * Define the sortable columns
         *
         * @return Array
         */
        public function get_sortable_columns()
        {
            return array(
                            'team_name' => array('team_name', false),
                            'team_id' => array('team_id', false)
                        );
        }

        /**
         * Get the table data
         *
         * @return Array
         */
        private function table_data()
        {
            $data = array();

            global $wpdb;

            $table_name = $wpdb->prefix . PREFIX_DB;
            $sql = $wpdb->prepare("SELECT * FROM $table_name");
            $all_data = $wpdb->get_results( $sql, ARRAY_A );

            foreach ($all_data as $row) {
                $id = $row["team_id"];
                $name = $row["team_name"];
                $city = $row["team_city"];
                $state = $row["team_state"];
                $stadium = $row["team_stadium"];

                $data[] = array(
                    'team_id'       => $id,
                    'team_name'     => $name,
                    'team_city'     => $city,
                    'team_state'    => $state,
                    'team_stadium'  => $stadium,
                    'action'        => ''
                );

            }

            return $data;
        }

        function column_action($item) {
            $actions = array(
                'edit' => sprintf('<a href=' . get_admin_url( null, 'admin.php?page=edit_data_db' ) . '&action=%s&id=%s>Edit</a>','edit',$item['team_id']),
                'delete' => sprintf('<a href=' . get_admin_url( null, 'admin.php?page=del_data_db' ) . '&action=%s&id=%s">Delete</a>','delete',$item['team_id']),
            );
            return sprintf('%1$s %2$s', $item['Name'], $this->row_actions($actions) );
        }

        /**
         * Define what data to show on each column of the table
         *
         * @param  Array $item        Data
         * @param  String $column_name - Current column name
         *
         * @return Mixed
         */
        public function column_default( $item, $column_name )
        {
            switch( $column_name ) {
                case 'team_id':
                case 'team_name':
                case 'team_city':
                case 'team_state':
                case 'team_stadium':
                case 'action':    
                    return $item[ $column_name ];

                default:
                    return print_r( $item, true ) ;
            }
        }


        /**
         * Allows you to sort the data by the variables set in the $_GET
         *
         * @return Mixed
         */
        private function sort_data( $a, $b )
        {
            // Set defaults
            $orderby = 'team_id';
            $order = 'asc';

            // If orderby is set, use this as the sort column
            if(!empty($_GET['orderby']))
            {
                $orderby = $_GET['orderby'];
            }

            // If order is set use this as the order
            if(!empty($_GET['order']))
            {
                $order = $_GET['order'];
            }


            $result = strcmp( $a[$orderby], $b[$orderby] );

            if($order === 'asc')
            {
                return $result;
            }

            return -$result;
        }
    }