<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       chuyenphatnhanhfoco.com
 * @since      1.0.0
 *
 * @package    Track
 * @subpackage Track/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Track
 * @subpackage Track/admin
 * @author     Phong Tran <tranphong2409@gmail.com>
 */
include(ABSPATH . 'wp-content/plugins/track/includes/class-track-list.php');

class Track_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    public $tracks_obj;
    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version    The current version of this plugin.
     */
    private $version;

    public $layout = "";

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name       The name of this plugin.
     * @param      string $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $array = array(
            __CLASS__,
           'set_screen'
        );

        add_filter('set-screen-option', $array, 10, 3);
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Track_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Track_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        $page = $_GET['page'];
        if ($page == 'track') {
            wp_enqueue_style($this->plugin_name . '-bootstrap', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name . '-theme', plugin_dir_url(__FILE__) . 'css/bootstrap-theme.min.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name . '-datetime', plugin_dir_url(__FILE__) . 'css/bootstrap-datetimepicker.min.css', array(), $this->version, 'all');
        }
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/track-admin.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name . 'popup', '/wp-content/themes/enfold/js/aviapopup/magnific-popup.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Track_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Track_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name. '-bootstrap', plugin_dir_url(__FILE__) . 'js/bootstrap.min.js', array('jquery'), $this->version, false);
        wp_enqueue_script($this->plugin_name. '-datetime', plugin_dir_url(__FILE__) . 'js/bootstrap-datetimepicker.min.js', array('jquery'), $this->version, false);
        wp_enqueue_script($this->plugin_name.'-custom', plugin_dir_url(__FILE__) . 'js/track-admin.js', array('jquery'), $this->version, false);
        wp_enqueue_script($this->plugin_name . 'popup', '/wp-content/themes/enfold/js/aviapopup/jquery.magnific-popup.min.js', array('jquery'), $this->version, false);

    }

    /**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     *
     * @since    1.0.0
     */

    public function add_plugin_admin_menu()
    {

        /*
         * Add a settings page for this plugin to the Settings menu.
         *
         * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
         *
         *        Administration Menus: http://codex.wordpress.org/Administration_Menus
         *
         */
        $hook = add_menu_page('Manage Tracking', 'Tracking', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page'), "", 3
        );
        add_action("load-$hook", array($this, 'screen_option'));
    }

    /**
     * Screen options
     */
    public function screen_option()
    {

        $option = 'per_page';
        $args = array(
            'label' => 'Tracks',
            'default' => 15,
            'option' => 'track_per_page'
        );

        add_screen_option($option, $args);

        $this->tracks_obj = new Tracks_List();
    }

    public function find_tracking()
    {
        $return = array("msg" => "Vui lòng nhập mã", "is_error" => 1);
        $code = $_POST['code'];
        if (isset($code) && !empty($code)) {
            global $wpdb;
            $exist = $this->check_exist($code,true);
            if ($exist) {
                $sql = 'SELECT * FROM wp_tracking_item WHERE code like "' . trim($code) . '"';
                $results = $wpdb->get_results($sql);
                $total = count($results);
                if ($total) {
                    $return['msg'] = "Có $total thông tin theo dõi";
                } else {
                    $return['msg'] = "Không có thông tin theo dõi";
                }
                $return['data'] = $results;
                $return['is_error'] = -1;
            } else {
                $return['is_error'] = 0;
                $return['msg'] = "Không có thông tin, vui lòng kiểm tra lại mã phiếu gửi";
            }

        }
        wp_send_json($return);
    }

    public function check_exist($code,$isInter = false)
    {
        global $wpdb;
        if(!$isInter){
            $code = $_POST['code'];
        }
        if(trim($code)){
            $sql = 'SELECT COUNT(*) FROM wp_tracking WHERE code like "' . trim($code) . '"';
            $return = $wpdb->get_var($sql);
            if($isInter){
                return $return;
            }
            wp_send_json($return);
        }else{
            if($isInter){
                return 1;
            }
            wp_send_json(1);
        }

    }

    public function create_tracking()
    {
        $return = array("msg" => "Vui lòng nhập mã", "is_error" => true);
        $code = $_POST['code'];
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $origin = isset($_POST['origin']) ? $_POST['origin'] : '';
        $destination = isset($_POST['destination']) ? $_POST['destination'] : '';
        if (isset($code) && !empty($code)) {
            $exist = $this->check_exist($code,true);
            if (!$exist) {
                global $wpdb;
                $result = $wpdb->insert('wp_tracking', array(
                    'code' => $code,
                    'username' => $username,
                    'origin' => $origin,
                    'destination' => $destination
                ), array('%s', '%s'));
                if ($result) {
                    $return["msg"] = "Đã thêm mới";
                    $return["is_error"] = false;
                    $return["id"] = $wpdb->insert_id;
                } else {
                    $return["msg"] = "Phát sinh lỗi xin liên hệ admin hoặc thử lại sau";
                }
            } else {
                $return["msg"] = "Đã tồn tại";
            }
        }
        wp_send_json($return);
    }

    public function update_tracking()
    {
        $return = array("msg" => "Vui lòng nhập đầy đủ thông tin", "is_error" => true);
        $item = $_POST['Item'];
        $ID = $_POST['ID'];
        if (isset($item) && !empty($item)) {
            global $wpdb;
            $updated = $wpdb->update('wp_tracking', $item, array('ID' => $ID));

            if (false === $updated) {
                $return["msg"] = "Phát sinh lỗi xin liên hệ admin hoặc thử lại sau";
            } else {
                $return["msg"] = "Đã cập nhật";
                $return["is_error"] = false;
                $item["ID"] = $ID;
                $return["item"] = $item;
            }
        }
        wp_send_json($return);
    }

    public function create_tracking_item()
    {
        $return = array("msg" => "Vui lòng nhập đầy đủ thông tin", "is_error" => true);
        $item = $_POST['Item'];
        if (isset($item) && !empty($item)) {
            global $wpdb;
            $result = $wpdb->insert('wp_tracking_item', $item);
            if ($result) {
                $return["msg"] = "Đã thêm mới";
                $return["is_error"] = false;
                $item["ID"] = $wpdb->insert_id;
                $return["item"][] = $item;
            } else {
                $return["msg"] = "Phát sinh lỗi xin liên hệ admin hoặc thử lại sau";
            }
        }
        wp_send_json($return);
    }

    public function update_tracking_item()
    {
        $return = array("msg" => "Vui lòng nhập đầy đủ thông tin", "is_error" => true);
        $item = $_POST['Item'];
        $ID = $_POST['ID'];
        if (isset($item) && !empty($item)) {
            global $wpdb;
            $updated = $wpdb->update('wp_tracking_item', $item, array('ID' => $ID));

            if (false === $updated) {
                $return["msg"] = "Phát sinh lỗi xin liên hệ admin hoặc thử lại sau";
            } else {
                $return["msg"] = "Đã cập nhật";
                $return["is_error"] = false;
                $item["ID"] = $ID;
                $return["item"] = $item;
            }
        }
        wp_send_json($return);
    }

    public function delete_tracking_item()
    {
        $return = array("msg" => "Phát sinh lỗi xin liên hệ admin hoặc thử lại sau!!", "is_error" => true);
        $ID = $_POST['ID'];
        if (isset($ID) && !empty($ID)) {
            global $wpdb;
            $deleted = $wpdb->delete('wp_tracking_item', array('ID' => $ID));

            if (false === $deleted) {
                $return["msg"] = "Phát sinh lỗi xin liên hệ admin hoặc thử lại sau";
            } else {
                $return["msg"] = "Đã xóa";
                $return["is_error"] = false;
                $return["ID"] = $ID;
            }
        }
        wp_send_json($return);
    }

    public function resolve_tracking_item()
    {
        $return     = array("msg" => "Phát sinh lỗi xin liên hệ admin hoặc thử lại sau!!", "is_error" => true);        
        $item       = $_POST['Item'];
        $ID         = $_POST['ID'];
        
        if (isset($item) && $item) {
            global $wpdb;
            $sql1    = "select t.username, t.code, t.destination, t.origin, t.note, t2.time from {$wpdb->prefix}tracking as t JOIN {$wpdb->prefix}tracking_item AS t2 ON t.code = t2.code AND t.ID = '{$ID}' ORDER BY t2.ID DESC LIMIT 1";
            $sql2    = "SELECT t1.*, t2.user_email, t2.display_name FROM ($sql1) AS t1 JOIN {$wpdb->prefix}users AS t2 WHERE t2.user_login = '".$item['username']."'";
            $result  = $wpdb->get_results($sql2);
            
            if ($result) {
                if(empty($result[0]->user_email)){
                    $return["is_error"]         = true;
                    $return["msg"]              = "Lỗi không tìm thấy email của user này";
                } else {
                    //update status resolve
                    $data['status']             = 'resolve';
                    $wpdb->update('wp_tracking', $data, array('ID' => $ID));
                    $item = $wpdb->get_row("SELECT ID FROM {$wpdb->prefix}tracking_item WHERE code = '{$result[0]->code}' ORDER BY id DESC LIMIT 1");
                    $wpdb->update('wp_tracking_item', $data, array('ID' => $item->ID));
                    
                    //send mail
                    $configmail                 = new stdClass();
                    $configmail->GUSER          = "info@gocphonho.net";
                    $configmail->SMTPHOST       = "smtp.zoho.com";
                    $configmail->GPWD           = "fewa#@%$##$@!$#@%";
                    $configmail->SMTPSERCURITY  = "tls";

                    $data = array(
                        'code'                  =>  $result[0]->code,
                        'destination'           =>  $result[0]->destination,
                        'origin'                =>  $result[0]->origin,
                        'time'                  =>  $result[0]->time,
                        'display_name'          =>  $result[0]->display_name,
                        'note'                  =>  $result[0]->note
                    );

                    $body                           = $this->loadTemplateMmail('mail',$data);
                    $subject                        = 'MAXIMUM SOURCING_POD of shipment #'.$data['code'];

                    $sendmail                       = json_decode($this->smtpmailer($result[0]->user_email, $configmail->GUSER, 'FOCO', $subject, $body, '', $configmail));
                    
                    $return["link"]                 = admin_url().'admin.php?page=track&layout=detail&id='.$ID;
                    session_start();
                    if($sendmail->error){
                        $return["is_error"]         = false;
                        $return["msg"]              = $sendmail->message;    
                        $_SESSION['msg-success']    = 'Cập nhật thông tin thành công';
                    } else {
                        $return["is_error"]         = true;
                        $return["msg"]              = $sendmail->message;    
                        $_SESSION['msg-success']    = $sendmail->message;
                    }
                }                
            } else {
                $return["is_error"]                 = true;
                $return["msg"]                      = "Phát sinh lỗi xin liên hệ admin hoặc thử lại sau";
            }
        }
        wp_send_json($return);
    }

    /**
     * Add settings action link to the plugins page.
     *
     * @since    1.0.0
     */

    public function add_action_links($links)
    {
        /*
        *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
        */
        $settings_link = array(
            '<a href="' . admin_url('admin.php?page=' . $this->plugin_name) . '">' . __('Settings', $this->plugin_name) . '</a>',
        );
        return array_merge($settings_link, $links);

    }

    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */

    private function getTrackingDetail($id)
    {
        global $wpdb;
        $sql = 'SELECT i.*,u.user_email as email  FROM wp_tracking as i join wp_users as u on i.username = u.user_login where i.ID ="'.$id.'"';
        $results = $wpdb->get_results($sql);
        return $results;
    }

    private function getUserList()
    {
        global $wpdb;
        $sql = 'SELECT u.user_login, u.user_nicename FROM wp_users as u ';
        $results = $wpdb->get_results($sql);
        return $results;
    }

    private function getTrackingListItem($code){
        global $wpdb;
        $sql = 'SELECT * FROM wp_tracking_item WHERE code like "' . trim($code) . '"';
        $results = $wpdb->get_results($sql);
        $total = count($results);
        $data =  array("total"=> $total, "lists"=> $results);
        return $data;
    }

    public function display_plugin_setup_page()
    {
        $detail = null;
        $listItem = array();
        $this->layout = $_REQUEST["layout"];
        switch ($this->layout) {
            case "detail":
                $id = $_REQUEST["id"];
                $detail = $this->getTrackingDetail($id);
                $listItem = $this->getTrackingListItem($detail[0]->code);
                include_once('partials/track-admin-detail-display.php');
                break;
            case "edit":
                $id = $_REQUEST["id"];
                $detail = $this->getTrackingDetail($id);
                $userlist = $this->getUserList();
                include_once('partials/track-admin-edit-display.php');
                break;
            case "add":
                $userlist = $this->getUserList();
                include_once('partials/track-admin-add-display.php');
                break;
            default:
                include_once('partials/track-admin-display.php');
        }

    }
    
    public function smtpmailer($to, $from, $from_name, $subject, $body,$attachment='',$configmail)
    {
        require_once('../wp-includes/PHPMailer/class.phpmailer.php');
        require_once('../wp-includes/PHPMailer/class.pop3.php');
        $mail = new PHPMailer;
        $mail->CharSet="utf-8";					// bật chức năng SMTP
        $mail->SMTPDebug = 0;  					// kiểm tra lỗi : 1 là  hiển thị lỗi và thông báo cho ta biết, 2 = chỉ thông báo lỗi
        $mail->SMTPAuth = true;  				// bật chức năng đăng nhập vào SMTP này

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = $configmail->SMTPHOST;  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $configmail->GUSER;                 // SMTP username
        $mail->Password = $configmail->GPWD;                           // SMTP password
        $mail->SMTPSecure = $configmail->SMTPSERCURITY; 				// sử dụng giao thức SSL vì gmail bắt buộc dùng cái này            
        $mail->Port = 587;                                    // TCP port to connect to

        $mail->From = $from;
        $mail->FromName = $from_name;
        $mail->addAddress($to, $from_name);     // Add a recipient
        //$mail->addAddress('nurettin@a.com');               // Name is optional
        //$mail->addReplyTo('satis@yandex.com.tr', 'aaa sitesii');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = $subject;

        if(!$mail->send()) {
            return json_encode(array('error'=>false,'message'=>'Mailer Error: ' . $mail->ErrorInfo));
        } else {
            return json_encode(array('error'=>true,'message'=>'Mail Sent Success'));
        }
    }
        
    private function loadTemplateMmail($template,$data=array()){
        ob_start();
        set_query_var('data', $data);        
        get_template_part('template',$template);
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

}
