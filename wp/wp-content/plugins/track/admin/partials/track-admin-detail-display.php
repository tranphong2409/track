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
session_start();
$resolve_status = false;
switch ($detail[0]->status) {
    case "process":
        $status = "Đang tiến hành";
        break;
    case "error":
        $status = "Lỗi";
        break;
    case "resolve":
        $resolve_status = true;
        $status = "Hoàn thành";
        break;
    default:
        $status = "";
}
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <h2><a class="btn btn-primary-outline btn-sm nav-back" href="/wp-admin/admin.php?page=track">
            <i class="glyphicon glyphicon-chevron-left"></i>
        </a> <span> Tracking Detail</span>
        <?php if (!$resolve_status): ?>
            <a href="/wp-admin/admin.php?page=track&layout=edit&id=<?php echo $detail[0]->ID ?>"
               class="page-title-action">Chỉnh sửa</a>
        <?php endif; ?>

    </h2>


    <div style="height:20px">

    </div>
    <div id='alert' role="alert">

    </div>
    <div id="tracking-info-header">
        <?php if (!empty($_SESSION['msg-success'])): ?>

            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $_SESSION['msg-success']; ?>
            </div>
            <?php unset($_SESSION['msg-success']); ?>
        <?php endif; ?>
    </div>
    <?php if ($id) { ?>
        <div id="tracking-information">
            <div class="tr-info custab">
                <div class="av-catalogue-container  avia-builder-el-8  el_after_av_codeblock  avia-builder-el-last">
                    <ul class="av-catalogue-list">
                        <li>
                            <div class="av-catalogue-item">
                                <div class="av-catalogue-item-inner">
                                    <div class="av-catalogue-title-container">
                                        <div class="av-catalogue-title">Awb.No</div>
                                        <div class="av-catalogue-price"></div>
                                    </div>
                                    <div class="av-catalogue-content">
                                        <em><strong><span
                                                    id="tr-code"><?php echo $detail[0]->code; ?></span></strong></em><br>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="av-catalogue-item">
                                <div class="av-catalogue-item-inner">
                                    <div class="av-catalogue-title-container">
                                        <div class="av-catalogue-title">Email</div>
                                        <div class="av-catalogue-price"></div>
                                    </div>
                                    <div class="av-catalogue-content">
                                        <em><strong><?php echo $detail[0]->email; ?></strong></em><br>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="av-catalogue-item">
                                <div class="av-catalogue-item-inner">
                                    <div class="av-catalogue-title-container">
                                        <div class="av-catalogue-title">Destination</div>
                                        <div class="av-catalogue-price"></div>
                                    </div>
                                    <div class="av-catalogue-content">
                                        <em><strong><?php echo $detail[0]->destination; ?></strong></em><br>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="av-catalogue-item">
                                <div class="av-catalogue-item-inner">
                                    <div class="av-catalogue-title-container">
                                        <div class="av-catalogue-title">Origin</div>
                                        <div class="av-catalogue-price"></div>
                                    </div>
                                    <div class="av-catalogue-content">
                                        <em><strong><?php echo $detail[0]->origin; ?></strong></em><br>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="av-catalogue-item">
                                <div class="av-catalogue-item-inner">
                                    <div class="av-catalogue-title-container">
                                        <div class="av-catalogue-title">Status</div>
                                        <div class="av-catalogue-price"></div>
                                    </div>
                                    <div class="av-catalogue-content">
                                        <em><strong><?php echo $status; ?></strong></em><br>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <table class="table table-striped custab" id="mytable" style="width:70%;">
                <thead>
                <tr>
                    <th>Thời gian</th>
                    <th>Địa điểm</th>
                    <th>Ghi chú</th>
                    <th>Tình trạng</th>
                    <?php if (!$resolve_status): ?>
                        <th></th><?php endif; ?>
                </tr>
                </thead>
                <tbody>
                <?php if ($listItem['total'] == 0) { ?>
                    <tr id="no-item">
                        <td colspan="5">Không có thông tin theo dõi</td>
                    </tr>
                <?php
                } else {
                    foreach ($listItem['lists'] as $e) {
                        ?>
                        <tr id="item-<?php echo $e->ID; ?>" data-id="<?php echo $e->ID; ?>">
                            <td><span class="time"><?php echo $e->time; ?></span></td>
                            <td><span class="location"><?php echo $e->location; ?></span></td>
                            <td><span class="note"><?php echo $e->note; ?></span></td>
                            <td><span class="status"><?php echo($e->status == 'process' ? 'Đang tiến hành' : '');
                                    echo($e->status == 'error' ? 'Lỗi' : ''); ?></span></td>
                            <?php if (!$resolve_status): ?>
                                <td>
                                    <button class="btn btn-primary btn-sm btn-update">Sửa</button>
                                    <button class="btn btn-danger btn-sm btn-delete">Xóa</button>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php
                    }
                } ?>

                </tbody>
            </table>
            <?php if (!$resolve_status): ?>
                <button class="btn btn-primary btn-sm popup-link pull-right" id="add-tr-item">
                    <i class="glyphicon glyphicon-plus"></i> Thêm theo dõi
                </button>
            <?php endif; ?>
        </div>
    <?php
    } else {
        echo "Không tìm thấy ID, Xin vui lòng trở lại trang chủ";
    }?>
</div>


<div style="display:none;">
    <div class="tr-footer" id="popup">
        <h3>Thêm theo dõi:</h3>

        <div class="row insert">
            <div class="input-group date form_datetime">
                <span class="input-group-addon">Thời gian: </span>
                <input class="form-control timereadonly" type="text" value="" readonly>
                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                <input type="hidden" id="dtp_input1" class="time" value=""/>
            </div>
            <div class="input-group location-box"><span class="input-group-addon lefttit">Địa điểm: </span><input
                    type="text" value=""
                    class="form-control location"
                    placeholder="HOCHIMINH - VIETNAM">
            </div>
            <div class="input-group note-box"><span class="input-group-addon lefttit">Ghi chú: </span>
                <select class="form-control note">
                    <option value="PICKED UP">PICKED UP</option>
                    <option value="CLEARANCE PROCESSING">CLEARANCE PROCESSING</option>
                    <option value="DEPARTED ORIGIN FACILITY">DEPARTED ORIGIN FACILITY</option>
                    <option value="ARRIVED AT SORT FACILITY">ARRIVED AT SORT FACILITY</option>
                    <option value="PROCESSED">PROCESSED</option>
                    <option value="DEPARTED FACILITY">DEPARTED FACILITY</option>
                    <option value="ARRIVED AT DELIVERY FACILITY">ARRIVED AT DELIVERY FACILITY</option>
                    <option value="OUT FOR DELIVERY">OUT FOR DELIVERY</option>
                    <option value="IN TRANSIT">IN TRANSIT</option>
                    <option value="CUSTOMS CLEARANCE">CUSTOMS CLEARANCE</option>
                    <option value="SHIPMENT ON HOLD"> SHIPMENT ON HOLD</option>
                    <option value="BROKER NOTIFIED TO ARRANGE FOR CLEARANCE">BROKER NOTIFIED TO ARRANGE FOR CLEARANCE
                    </option>
                    <option value="CUSTOMS STATUS UPDATE">CUSTOMS STATUS UPDATE</option>
                    <option value="CLEARANCE EVENT">CLEARANCE EVENT</option>
                    <option value="CLEARANCE PROCESSING COMPLETE">CLEARANCE PROCESSING COMPLETE</option>
                    <option value="PROCESSED FOR CLEARANCE AT">PROCESSED FOR CLEARANCE AT</option>
                    <option value="RECIPIENT MOVED">RECIPIENT MOVED</option>
                    <option value="AWAITING COLLECTION BY RECIPIENT AS REQUESTED">AWAITING COLLECTION BY RECIPIENT AS
                        REQUESTED
                    </option>
                    <option value="RETURNED TO SHIPPER">RETURNED TO SHIPPER</option>
                    <option value="DELIVERY ATTEMPTED; RECIPIENT NOT HOME">DELIVERY ATTEMPTED; RECIPIENT NOT HOME
                    </option>
                    <option value="ADDRESS INFORMATION NEEDED; CONTACT DHL">ADDRESS INFORMATION NEEDED; CONTACT DHL
                    </option>
                    <option value=" DELIVERY ARRANGED NO DETAILS EXPECTED"> DELIVERY ARRANGED NO DETAILS EXPECTED
                    </option>
                    <option value="RECIPIENT REFUSED DELIVERY">RECIPIENT REFUSED DELIVERY</option>
                    <option value="SCHEDULED FOR DELIVERY AS AGREED">SCHEDULED FOR DELIVERY AS AGREED</option>
                    <option value="DELIVERED">DELIVERED</option>
                </select>
            </div>
            <div class="input-group status-box">
                <span class="input-group-addon lefttit">Trạng thái: </span>
                <select class="form-control status">
                    <option value="process">Đang tiến hành</option>
                    <option value="error">Lỗi</option>
                </select>
            </div>
            <div class="btn-group">
                <button class="btn btn-primary btn-sm" id="save-tr-item" data-id="">
                    <i class="glyphicon glyphicon-floppy-disk"></i> Lưu theo dõi
                </button>
                <button class="btn btn-danger btn-sm" onClick="jQuery.magnificPopup.close();">
                    <i class="glyphicon glyphicon-remove-sign"></i> Hủy
                </button>
            </div>
        </div>


    </div>

    <div id="confirm">
        <h3>Bạn có chắc chắn muốn xóa?</h3>

        <div class="row btn-group-wrap">
            <div class="btn-group">
                <button class="btn btn-primary btn-sm" id="delete-tr-item" data-id="">
                    <i class="glyphicon glyphicon-ok"></i> Có
                </button>
                <button class="btn btn-danger btn-sm" onClick="jQuery.magnificPopup.close();">
                    <i class="glyphicon glyphicon-remove"></i> Không
                </button>
            </div>
        </div>


    </div>
</div>
