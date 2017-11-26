<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       chuyenphatnhanhfoco.com
 * @since      1.0.0
 *
 * @package    Track
 * @subpackage Track/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <h2>
        <a class="btn btn-primary-outline btn-sm nav-back" href="#">
            <i class="glyphicon glyphicon-chevron-left"></i>
        </a> <?php echo esc_html(get_admin_page_title()); ?></h2>
    <div style="height:20px"></div>
    <div id="new-tracking" class=" custab col-md-6" >

        <h4>Tạo đơn hàng: </h4>

        <div class="input-group code-box">
            <span class="input-group-addon">Mã phiếu gửi: </span>
            <input type="text" class="form-control new-tracking-code" value=""/>
            <span class="input-group-addon check-code"><span class="glyphicon glyphicon-check"></span></span>
        </div>
        <br>

        <div class="input-group username-box">
            <span class="input-group-addon">username: </span>
            <select  class="form-control new-tracking-username typeahead">
                <?php
                    foreach($userlist as $u){
                      echo  " <option value=".$u->user_login.">".$u->user_nicename."</option>";
                    }
                ?>
            </select>
        </div>
        <br>

        <div class="input-group origin-box">
            <span class="input-group-addon">Origin: </span>
            <input type="text" class="form-control new-tracking-origin" value=""/>
        </div>
        <br>

        <div class="input-group destination-box">
            <span class="input-group-addon">Destination: </span>
            <input type="text" class="form-control new-tracking-destination" value=""/>
        </div>
        <br>

        <div class="input-group note-box">
            <span class="input-group-addon">Note: </span>
            <textarea class="form-control new-tracking-note" ></textarea>
        </div>
        <br>

        <div class="btn-group">
            <button class="btn btn-primary" id="new-tracking-add">Lưu</button>
            <button class="btn btn-danger nav-back">Hủy</button>
        </div>
    </div>
    <input type="hidden" value="<?php echo $userlist; ?>" id="userlist" />
    <div id='alert' role="alert">

    </div>

</div>

