<?php

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class Tracks_List extends WP_List_Table
{

    /** Class constructor */
    public function __construct()
    {

        parent::__construct(array(
            'singular' => __('Track', 'sp'), //singular name of the listed records
            'plural' => __('Tracks', 'sp'), //plural name of the listed records
            'ajax' => false //does this table support ajax?
        ));

    }


    /**
     * Retrieve customers data from the database
     *
     * @param int $per_page
     * @param int $page_number
     *
     * @return mixed
     */
    public static function get_Tracks($per_page = 15, $page_number = 1)
    {

        global $wpdb;

        $sql = "SELECT * FROM {$wpdb->prefix}tracking";
        
        if (!empty($_REQUEST['beginTime'])) {
            $sql .= ' WHERE created_date >= "' . esc_sql(date("Y-m-d",strtotime($_REQUEST['beginTime']))).'"';
        }
        
        if (!empty($_REQUEST['endTime'])) {
            $sql .= ' AND created_date <= "' . esc_sql(date("Y-m-d",strtotime($_REQUEST['endTime']))).'"';
        }

        if (!empty($_REQUEST['orderby'])) {
            $sql .= ' ORDER BY ' . esc_sql($_REQUEST['orderby']);
            $sql .= !empty($_REQUEST['order']) ? ' ' . esc_sql($_REQUEST['order']) : ' ASC';
        }

        $sql .= " LIMIT $per_page";
        $sql .= ' OFFSET ' . ($page_number - 1) * $per_page;


        $result = $wpdb->get_results($sql, 'ARRAY_A');

        return $result;
    }


    /**
     * Delete a customer record.
     *
     * @param int $id customer ID
     */
    public static function delete_track($id)
    {
        global $wpdb;

        $wpdb->delete(
            "{$wpdb->prefix}tracking",
            array('ID' => $id),
            array('%d')
        );
    }


    /**
     * Returns the count of records in the database.
     *
     * @return null|string
     */
    public static function record_count()
    {
        global $wpdb;

        $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}tracking";

        if (!empty($_REQUEST['beginTime'])) {
            $sql .= ' WHERE created_date >= ' . esc_sql($_REQUEST['beginTime']);
        }
        
        if (!empty($_REQUEST['endTime'])) {
            $sql .= ' WHERE created_date <= ' . esc_sql($_REQUEST['endTime']);
        }
        
        return $wpdb->get_var($sql);
    }


    /** Text displayed when no customer data is available */
    public function no_items()
    {
        _e('No tracking avaliable.', 'sp');
    }


    /**
     * Render a column when no column specific method exist.
     *
     * @param array $item
     * @param string $column_name
     *
     * @return mixed
     */
    public function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'ID':
            case 'code':
            case 'destination':
            case 'origin':
            case 'status':
            case 'username':
            case 'note':
            case 'created_date':
                return $item[$column_name];
            default:
                return print_r($item, true); //Show the whole array for troubleshooting purposes
        }
    }

    /**
     * Render the bulk edit checkbox
     *
     * @param array $item
     *
     * @return string
     */
    function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['ID']
        );
    }


    /**
     * Method for name column
     *
     * @param array $item an array of DB data
     *
     * @return string
     */
    function column_name($item)
    {

        $delete_nonce = wp_create_nonce('sp_delete_track');

        $title = '<strong>' . $item['name'] . '</strong>';

        $actions = array(
            'delete' => sprintf('<a href="?page=%s&action=%s&track=%s&_wpnonce=%s">Delete</a>', esc_attr($_REQUEST['page']), 'delete', absint($item['ID']), $delete_nonce)
        );

        return $title . $this->row_actions($actions);
    }


    /**
     *  Associative array of columns
     *
     * @return array
     */
    function get_columns()
    {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'ID' => __('ID', 'sp'),
            'code' => __('Code', 'sp'),
            'username' => __('Username', 'sp'),
            'origin' => __('Origin', 'sp'),
            'destination' => __('Destination', 'sp'),
            'status' => __('Status', 'sp'),
            'note' => __('Note', 'sp'),
            'created_date' => __('Created date', 'sp')
        );

        return $columns;
    }


    /**
     * Columns to make sortable.
     *
     * @return array
     */
    public function get_sortable_columns()
    {
        $sortable_columns = array(
            'destination' => __('Destination', 'sp'),
            'origin' => __('Origin', 'sp'),
            'status' => __('Status', 'sp')
        );

        return $sortable_columns;
    }

    /**
     * Returns an associative array containing the bulk action
     *
     * @return array
     */
    public function get_bulk_actions()
    {
        $actions = array(
            'bulk-delete' => 'Delete'
        );

        return $actions;
    }


    /**
     * Handles data query and filter, sorting, and pagination.
     */
    public function prepare_items()
    {

        $this->_column_headers = $this->get_column_info();

        /** Process bulk action */
        $this->process_bulk_action();

        $per_page = $this->get_items_per_page('tracks_per_page', 15);
        $current_page = $this->get_pagenum();
        $total_items = self::record_count();

        $this->set_pagination_args(array(
            'total_items' => $total_items, //WE have to calculate the total number of items
            'per_page' => $per_page //WE have to determine how many items to show on a page
        ));

        $this->items = self::get_Tracks($per_page, $current_page);
    }

    /**
     * Display the rows of records in the table
     * @return string, echo the markup of the rows 
     */
    function display_rows()
    {

        //Get the records registered in the prepare_items method
        $records = $this->items;

        //Get the columns registered in the get_columns and get_sortable_columns methods
        list($columns, $hidden) = $this->get_column_info();

        //Loop for each record
        if (!empty($records)) {
            foreach ($records as $rec) {
                $detailLink = '/wp-admin/admin.php?page=track&layout=detail&id=' . (int)$rec['ID'];
                //Open the line
                echo '<tr id="record_' . $rec['ID'] . '" class="clickable" data-link="' . $detailLink . '">';
                foreach ($columns as $column_name => $column_display_name) {
                    //Style attributes for each col
                    $class = "class='$column_name column-$column_name'";
                    $style = "";
                    if (in_array($column_name, $hidden)) $style = ' style="display:none;"';
                    $attributes = $class . $style;

                    //Display the cell
                    switch ($column_name) {
                        case "cb":
                            echo '<th scope="row" class="check-column"><input type="checkbox" name="bulk-delete[]" value="' . $rec['ID'] . '"></th>';
                            break;
                        case "ID":
                            echo '<td ' . $attributes . '>' . $rec['ID'] . '</td>';
                            break;
                        case "code":
                            echo '<td ' . $attributes . '>' . $rec['code'] . '</td>';
                            break;
                        case "username":
                            echo '<td ' . $attributes . '>' . $rec['username'] . '</td>';
                            break;
                        case "destination":
                            echo '<td ' . $attributes . '>' . $rec['destination'] . '</td>';
                            break;
                        case "origin":
                            echo '<td ' . $attributes . '>' . $rec['origin'] . '</td>';
                            break;
                        case "status":
                            echo '<td ' . $attributes . '>' . $rec['status'] . '</td>';
                            break;
                        case "note":
                            echo '<td ' . $attributes . '>' . $rec['note'] . '</td>';
                            break;
                        case "created_date":
                            echo '<td ' . $attributes . '>' . date("d-m-Y",strtotime($rec['created_date'])) . '</td>';    
                            break;
                    }
                }

                //Close the line
                echo '</tr>';
            }
        }
    }

    public function process_bulk_action()
    {

        //Detect when a bulk action is being triggered...
        if ('delete' === $this->current_action()) {

            // In our file that handles the request, verify the nonce.
            $nonce = esc_attr($_REQUEST['_wpnonce']);

            if (!wp_verify_nonce($nonce, 'sp_delete_track')) {
                die('Go get a life script kiddies');
            } else {
                self::delete_track(absint($_GET['track']));
                // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
                // add_query_arg() return the current url
                wp_redirect(esc_url_raw(add_query_arg()));
                exit;
            }

        }

        // If the delete bulk action is triggered
        if ((isset($_POST['action']) && $_POST['action'] == 'bulk-delete')
            || (isset($_POST['action2']) && $_POST['action2'] == 'bulk-delete')
        ) {

            $delete_ids = esc_sql($_POST['bulk-delete']);

            // loop over the array of record IDs and delete them
            foreach ($delete_ids as $id) {
                self::delete_track($id);
            }
            // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
            // add_query_arg() return the current url
            wp_redirect(esc_url_raw(add_query_arg()));
            exit;
        }
    }

}