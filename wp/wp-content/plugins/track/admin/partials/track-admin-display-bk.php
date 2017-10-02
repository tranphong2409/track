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
    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>

    <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-2">
            <div id="post-body-content">
                <div class="meta-box-sortables ui-sortable">
                    <form method="post">
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
<!---->
<!---->
<!--<div class="wrap">-->
<!---->
<!--    <h2>--><?php //echo esc_html(get_admin_page_title()); ?><!--</h2>-->
<!---->
<!---->
<!---->
<!--        <!-- remove some meta and generators from the <head> -->
<!--        <div class="input-group col-md-4">-->
<!--            <span class="input-group-addon">Nhập mã phiếu gửi: </span>-->
<!---->
<!--                <input type="text" id="--><?php //echo $this->plugin_name; ?><!---id" name="tracking_number"  class="form-control" value=""/>-->
<!--            <div class="input-group-btn">-->
<!--                <button class="btn btn-primary" type="submit" id="search-tracking">-->
<!--                    <i class="glyphicon glyphicon-search"></i> Tìm Kiếm-->
<!--                </button>-->
<!--            </div>-->
<!---->
<!--        </div>-->
<!--        <div style="height:20px"></div>-->
<!--    <div id='alert' role="alert">-->
<!---->
<!--    </div>-->
<!--    <div id="listview">-->
<!--        <table class="table">-->
<!--            <thead>-->
<!--            <tr>-->
<!--                <th>Mã số</th>-->
<!--                <th>Người gửi</th>-->
<!--                <th>Nơi gửi</th>-->
<!--                <th>Nơi đến</th>-->
<!--                <th>Tình trạng</th>-->
<!--                <th></th>-->
<!--            </tr>-->
<!--            </thead>-->
<!--            <tbody>-->
<!--            --><?php //if(count($trackingList) > 0) {
//                    foreach($trackingList as $item) { ?>
<!--                <tr>-->
<!--                    <td>--><?php //echo $item->code ?><!--</td><td>--><?php //echo $item->username ?><!--</td><td>--><?php //echo $item->origin ?><!--</td><td>--><?php //echo $item->destination ?><!--</td><td>--><?php //echo $item->status ?><!--</td><td><a href="--><?php //echo 'http://'.$_SERVER[HTTP_HOST].'/wp-admin/admin.php?page=track&code='.$item->code; ?><!--" class="btn btn-default">Chi tiết</a></td>-->
<!--                </tr>-->
<!--            --><?php //      }
//                    } ?>
<!---->
<!--            </tbody>-->
<!--        </table>-->
<!---->
<!--    </div>-->
<?php //if($layout == 'addnew') { ?>
<!--        <div id="new-tracking">-->
<!--            <div class="alert alert-success" role="alert">-->
<!--                <h4>Bạn có muốn tạo Tracking với thông tin:</h4>-->
<!--                <div class="input-group col-md-4">-->
<!--                    <span class="input-group-addon">Mã phiếu gửi: </span>-->
<!--                    <input type="text" class="form-control new-tracking-text" value=""/>-->
<!--                </div>-->
<!--                <br>-->
<!--                <div class="input-group col-md-4">-->
<!--                    <span class="input-group-addon">username: </span>-->
<!--                    <input type="text" class="form-control new-tracking-email" value=""/>-->
<!--                </div>-->
<!--                <br>-->
<!--                <div class="btn-group"><button class="btn btn-primary" id="new-tracking-add">Có</button><button class="btn btn-danger" id="new-tracking-reset">Không</button></div>-->
<!--            </div>-->
<!--        </div>-->
<?php // } ?>
<!--        <div id="tracking-information" style="display: none;">-->
<!--            <div class="row tr-info">-->
<!--                <div class="col-md-4">Mã phiếu gửi: <span id="tr-code"></span></div>-->
<!--                <div class="col-md-4 input-group" style="display: none;">  <span class="input-group-addon">Email: </span>-->
<!---->
<!--                    <input type="text" id="tr-email"  class="form-control" value=""/>-->
<!--                </div>-->
<!--            </div>-->
<!--            <table class="table">-->
<!--                <thead>-->
<!--                    <tr>-->
<!--                        <th>Thời gian</th>-->
<!--                        <th>Địa điểm</th>-->
<!--                        <th>Ghi chú</th>-->
<!--                        <th>Tình trạng</th>-->
<!--                        <th></th>-->
<!--                    </tr>-->
<!--                </thead>-->
<!--                <tbody>-->
<!---->
<!--                </tbody>-->
<!--            </table>-->
<!---->
<!--            <button class="btn btn-primary btn-sm popup-link" id="add-tr-item">-->
<!--                <i class="glyphicon glyphicon-plus"></i> Thêm theo dõi-->
<!--            </button>-->
<!--        </div>-->
<!--    <div style="display:none;">-->
<!--        <div class="tr-footer" id="popup" >-->
<!--            <h3>Thêm theo dõi:</h3>-->
<!--            <div class="row insert">-->
<!--                <div class="input-group"> <span class="input-group-addon">Thời gian: </span><input type="text" value="" class="form-control time" placeholder="2016-02-01 14:30" ></div>-->
<!--                <div class="input-group"> <span class="input-group-addon">Địa điểm: </span><input type="text" value="" class="form-control location" placeholder="HOCHIMINH - VIETNAM"></div>-->
<!--                <div class="input-group"> <span class="input-group-addon">Ghi chú: </span><textarea class="form-control note" placeholder="SHIPMENT PICKED UP"></textarea></div>-->
<!--                <div class="input-group">-->
<!--                    <span class="input-group-addon">Trạng thái: </span>-->
<!--                    <select class="form-control status" >-->
<!--                        <option value="process">Đang tiến hành</option>-->
<!--                        <option value="error">Lỗi</option>-->
<!--                    </select>-->
<!--                </div>-->
<!--                <div class="btn-group">-->
<!--                    <button class="btn btn-primary btn-sm" id="save-tr-item" data-id="">-->
<!--                        <i class="glyphicon glyphicon-floppy-disk"></i> Lưu theo dõi-->
<!--                    </button>-->
<!--                    <button class="btn btn-danger btn-sm" onClick="jQuery.magnificPopup.close();">-->
<!--                        <i class="glyphicon glyphicon-remove-sign"></i> Hủy-->
<!--                    </button>-->
<!--                </div>-->
<!--            </div>-->
<!---->
<!---->
<!---->
<!--        </div>-->
<!---->
<!--        <div id="confirm" >-->
<!--            <h3>Bạn có chắc chắn muốn xóa?</h3>-->
<!--            <div class="row btn-group-wrap">-->
<!--                 <div class="btn-group">-->
<!--                    <button class="btn btn-primary btn-sm" id="delete-tr-item" data-id="">-->
<!--                        <i class="glyphicon glyphicon-ok"></i> Có-->
<!--                    </button>-->
<!--                    <button class="btn btn-danger btn-sm" onClick="jQuery.magnificPopup.close();">-->
<!--                        <i class="glyphicon glyphicon-remove"></i> Không-->
<!--                    </button>-->
<!--                </div>-->
<!--            </div>-->
<!---->
<!---->
<!---->
<!--        </div>-->
<!--    </div>-->
<!---->
<!---->
<!--</div>-->
