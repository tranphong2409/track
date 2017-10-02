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

<div class="wrap">
    <h2>
        <a class="btn btn-primary-outline btn-sm nav-back" href="#">
            <i class="glyphicon glyphicon-chevron-left"></i>
        </a> <?php echo esc_html(get_admin_page_title()); ?></h2>
    <div style="height:20px"></div>
    <div id="edit-tracking" class=" custab col-md-6" >

        <h4>Chỉnh sửa đơn hàng: </h4>

        <div class="input-group code-box">
            <span class="input-group-addon">Mã phiếu gửi: </span>
            <input type="text" class="form-control tracking-code" value="<?php echo $detail[0]->code; ?>" readonly/>
            <span class="input-group-addon check-code"><span class="glyphicon glyphicon-check"></span></span>
        </div>
        <br>

        <div class="input-group username-box">
            <span class="input-group-addon">username: </span>
            <input type="text" class="form-control tracking-username" value="<?php echo $detail[0]->username; ?>"/>
        </div>
        <br>

        <div class="input-group origin-box">
            <span class="input-group-addon">Origin: </span>
            <input type="text" class="form-control tracking-origin" value="<?php echo $detail[0]->origin; ?>"/>
        </div>
        <br>

        <div class="input-group destination-box">
            <span class="input-group-addon">Destination: </span>
            <input type="text" class="form-control tracking-destination" value="<?php echo $detail[0]->destination; ?>"/>
        </div>
        <br>

        <div class="input-group note-box">
            <span class="input-group-addon">Note: </span>
            <textarea class="form-control tracking-note"><?php echo $detail[0]->note; ?></textarea>
        </div>
        <br>

        <div class="btn-group">
            <button class="btn btn-primary" id="btn-edit-tracking" data-id="<?php echo $detail[0]->ID; ?>">Lưu</button>
            <button class="btn btn-danger nav-back" >Hủy</button>
        </div>
    </div>
    <div id='alert' role="alert">

    </div>

</div>

