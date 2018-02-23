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
    <h2><?php echo esc_html(get_admin_page_title()); ?><a href="/wp-admin/admin.php?page=track&layout=add" class="page-title-action">Thêm mới</a></h2>

    <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-2">
            <div id="post-body-content">
                <div class="meta-box-sortables ui-sortable">
                    <form method="post" style="width:110%">
                        <input type="text" name="beginTime" value="<?php echo (isset($_REQUEST['beginTime']))?$_REQUEST['beginTime']:''?>" id="beginTime" class="time hasDatepicker" placeholder="Chọn ngày bắt đầu">
                        <input type="text" name="endTime" value="<?php echo (isset($_REQUEST['endTime']))?$_REQUEST['endTime']:''?>" id="endTime" class="time hasDatepicker" placeholder="Chọn ngày kết thúc">
                        <button id="filterDate" type="submit" name="submit" value="filter" class="btn btn-primary btn-sm btn-update">Tìm</button>    
                        <?php
                        $this->tracks_obj->prepare_items();
                        $this->tracks_obj->display(); ?>
                    </form>
                </div>
            </div>
        </div>
        <br class="clear">
    </div>
</div>