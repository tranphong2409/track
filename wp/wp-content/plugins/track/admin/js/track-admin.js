(function ($) {
    'use strict';

    /**
     * All of the code for your admin-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     *
     * $(function() {
	 *
	 * });
     *
     * When the window is loaded:
     *
     * $( window ).load(function() {
	 *
	 * });
     *
     * ...and/or other possibilities.
     *
     * Ideally, it is not considered best practise to attach more than a
     * single DOM-ready or window-load handler for a particular page.
     * Although scripts in the WordPress core, Plugins and Themes may be
     * practising this, we should strive to set a better example in our own work.
     */


    var track;
    track = new function () {
        this.findTracking = function (code, obj) {
            obj.disabled = true;
            jQuery.ajax({
                method: "POST",
                url: ajaxurl,
                data: {'action': 'find_tracking', code: code }
            })
                .done(function (msg) {
                    var className = 'alert ';
                    switch (msg.is_error) {
                        case 0:
                            // không có Tracking, hiện box thông báo tạo tracking
                            className += 'alert-danger';
                            jQuery('#new-tracking').show();
                            jQuery('#tracking-information').hide();
                            jQuery('#new-tracking').find('.new-tracking-text').val(code);
                            break;
                        case -1:
                            var rowHtml = parseRow(msg.data);
                            jQuery('#tr-code').html(code);
                            jQuery('#new-tracking').hide();
                            jQuery('#tracking-information').show().find('tbody').html(rowHtml);
                            className = 'alert alert-success';
                            break;
                        default:
                            // phát sinh lỗi
                            jQuery('#new-tracking').hide();
                            jQuery('#tracking-information').hide();
                            className += 'alert-danger';
                    }
                    alertBox(className, msg.msg);
                    obj.disabled = false;
                });
        };
        this.check_exist = function (code, obj) {
            obj.disabled = true;
            if (jQuery(obj).hasClass("onProcess") || code === "") {
                return;
            }
            jQuery(obj).addClass("onProcess");
            jQuery.ajax({
                method: "POST",
                url: ajaxurl,
                data: {'action': 'check_exist', code: code }
            })
                .done(function (msg) {
                    var className = 'alert ';
                    var mess = "Lỗi, Mã đã tồn tại.";
                    if (!+msg) {
                        className = 'alert alert-success';
                        jQuery(obj).css({'background-color': '#dff0d8','color':"green"});
                        mess = "Mã hợp lệ, chưa tồn tại.";
                    } else {
                        className += 'alert-danger';
                        jQuery(obj).css({'background-color': 'red','color':"#fff"});
                    }
                    alertBox(className, mess);
                    obj.disabled = false;
                    jQuery(obj).removeClass("onProcess");
                });
        };

        var alertBox = function (className, msg) {
            var alert = jQuery('#alert');
            alert.attr("class", className).html(msg).fadeTo(3000, 500).slideUp(500, function () {
                alert.slideUp(500);
            });
        };
        var parseRow = function (data) {
            var html = '';
            data.forEach(function (e) {
                html += '<tr id="item-' + e.ID + '"  data-id="' + e.ID + '"> ' +
                    '<td><span class="time">' + e.time + '</span></td>' +
                    '<td><span class="location">' + e.location + '</span></td>' +
                    '<td><span class="note">' + e.note + '</span></td>' +
                    '<td><span class="status">' + (e.status == 'process' ? 'Đang tiến hành' : '') + (e.status == 'error' ? 'Lỗi' : '') + '</span></td>' +
                    '<td ><button class="btn btn-primary btn-sm btn-update" >Sửa</button><button class="btn btn-danger btn-sm btn-delete">Xóa</button></td>' +
                    '</tr>';
            });
            return html;
        };
        var updateRow = function (e) {
            return '<td><span class="time">' + e.time + '</span></td>' +
                '<td><span class="location">' + e.location + '</span></td>' +
                '<td><span class="note">' + e.note + '</span></td>' +
                '<td><span class="status">' + (e.status == 'process' ? 'Đang tiến hành' : '') + (e.status == 'error' ? 'Lỗi' : '') + '</span></td>' +
                '<td ><button class="btn btn-primary btn-sm btn-update" >Sửa</button><button class="btn btn-danger btn-sm btn-delete">Xóa</button></td>';
        };

        this.updateItem = function (ID, data, obj) {
            data.action = 'update_tracking_item';
            data.ID = ID;
            jQuery.ajax({
                method: "POST",
                url: ajaxurl,
                data: data
            })
                .done(function (msg) {
                    var className = 'alert ';
                    if (msg.is_error) {
                        className += 'alert-danger';
                    } else {
                        jQuery.magnificPopup.close();
                        var rowHtml = updateRow(msg.item);
                        jQuery("#item-" + msg.item.ID).html(rowHtml);
                    }
                    alertBox(className, msg.msg);
                    obj.disabled = false;
                });
        };
        this.createTracking = function (code, username, origin, destination, note, obj) {
            obj.disabled = true;
            var data = {
                action: 'create_tracking',
                code: code,
                username: username,
                origin: origin,
                destination: destination,
                note: note
            };
            jQuery.ajax({
                method: "POST",
                url: ajaxurl,
                data: data
            })
                .done(function (msg) {
                    var className = 'alert ';
                    if (msg.is_error) {
                        className += 'alert-danger';
                    } else {
                        setTimeout(function () {
                            var link = "/wp-admin/admin.php?page=track&layout=detail&id=" + msg.id;
                            window.location.href = link;
                        }, 2000);
                    }
                    alertBox(className, msg.msg);
                    obj.disabled = false;
                });
        };
        this.updateTracking = function (ID, data, obj) {
            data.action = 'update_tracking';
            data.ID = ID;
            jQuery.ajax({
                method: "POST",
                url: ajaxurl,
                data: data
            })
                .done(function (msg) {
                    var className = 'alert ';
                    if (msg.is_error) {
                        className += 'alert-danger';
                    } else {
                        className += 'alert-success';
                        setTimeout(function () {
                            var link = "/wp-admin/admin.php?page=track&layout=detail&id=" + ID;
                            window.location.href = link;
                        }, 2000);
                    }
                    alertBox(className, msg.msg);
                    obj.disabled = false;
                });
        };
        this.createItem = function (data, obj) {
            data.action = 'create_tracking_item';
            obj.disabled = true;
            jQuery.ajax({
                method: "POST",
                url: ajaxurl,
                data: data
            })
                .done(function (msg) {
                    jQuery("#no-item").hide();
                    var className = 'alert ';
                    if (msg.is_error) {
                        className += 'alert-danger';
                    } else {
                        jQuery.magnificPopup.close();
                        var rowHtml = parseRow(msg.item);
                        jQuery('#tracking-information').find('tbody').append(rowHtml);
                    }
                    alertBox(className, msg.msg);
                    obj.disabled = false;
                });
        };
        this.deleteItem = function (data, obj) {
            data.action = 'delete_tracking_item';
            jQuery.ajax({
                method: "POST",
                url: ajaxurl,
                data: data
            })
                .done(function (msg) {
                    var className = 'alert ';
                    if (msg.is_error) {
                        className += 'alert-danger';
                    } else {
                        jQuery.magnificPopup.close();
                        jQuery("#item-" + msg.ID).remove();
                    }
                    alertBox(className, msg.msg);
                    obj.disabled = false;
                });
        };
        this.resolveItem = function (ID, data, obj) {
            data.action = 'resolve_tracking_item';
            data.ID = ID;
            obj.disabled = true;
            jQuery.ajax({
                method: "POST",
                url: ajaxurl,
                data: data
            })
            .done(function (msg) {
                window.location.href = msg.link;
            });
        };
        this.goBack = function () {
            window.history.back();
        }
    };

    $(function () {
        //init datetime picker
        jQuery('.form_datetime').datetimepicker({
            weekStart: 1,
            todayBtn: 1,
            autoclose: 1,
            todayHighlight: 1,
            minuteStep: 2,
            startView: 2,
            forceParse: 0,
            format: "dd-mm-yyyy hh:ii",
            showMeridian: 1
        });
        jQuery('.nav-back').click(function () {
            track.goBack();
        });

        jQuery(".check-code").click(function () {
            var newTracking = jQuery('#new-tracking');
            var code = newTracking.find('.new-tracking-code').val();
            if ($.trim(code) === "") {
                newTracking.find(".code-box").addClass("invalid");
                return;
            } else {
                newTracking.find(".code-box").removeClass("invalid");
            }
            track.check_exist(code, this);


        });

        jQuery(".clickable td").click(function () {
            var sLink = jQuery(this).parents('tr').attr("data-link");
            window.location.href = sLink;
        });
        jQuery("#search-tracking").click(function () {
            var code = jQuery("#track-id").val();
            if (jQuery.trim(code)) {
                track.findTracking(code, this);
            }
        });

        jQuery("#new-tracking-add").click(function () {
            var newTracking = jQuery('#new-tracking');
            var code = newTracking.find('.new-tracking-code').val();
            var username = newTracking.find('.new-tracking-username').val();
            var origin = newTracking.find('.new-tracking-origin').val();
            var destination = newTracking.find('.new-tracking-destination').val();
            var note = newTracking.find('.new-tracking-note').val() + "";

            if ($.trim(code) === "") {
                newTracking.find(".code-box").addClass("invalid");
                return;
            } else {
                newTracking.find(".code-box").removeClass("invalid");
            }

            if ($.trim(username) === "") {
                newTracking.find(".username-box").addClass("invalid");
                return;
            } else {
                newTracking.find(".username-box").removeClass("invalid");
            }

            if ($.trim(origin) === "") {
                newTracking.find(".origin-box").addClass("invalid");
                return;
            } else {
                newTracking.find(".origin-box").removeClass("invalid");
            }

            if ($.trim(destination) === "") {
                newTracking.find(".destination-box").addClass("invalid");
                return;
            } else {
                newTracking.find(".destination-box").removeClass("invalid");
            }

            if (jQuery.trim(code)) {
                track.createTracking(code, username, origin, destination, note, this);
            }
        });

        jQuery("#btn-edit-tracking").click(function () {
            var ID = jQuery(this).attr("data-id");
            var newTracking = jQuery('#edit-tracking');
            var username = newTracking.find('.tracking-username').val();
            var origin = newTracking.find('.tracking-origin').val();
            var destination = newTracking.find('.tracking-destination').val();
            var note = newTracking.find('.tracking-note').val() + "";


            if ($.trim(username) === "") {
                newTracking.find(".username-box").addClass("invalid");
                return;
            } else {
                newTracking.find(".username-box").removeClass("invalid");
            }

            if ($.trim(origin) === "") {
                newTracking.find(".origin-box").addClass("invalid");
                return;
            } else {
                newTracking.find(".origin-box").removeClass("invalid");
            }

            if ($.trim(destination) === "") {
                newTracking.find(".destination-box").addClass("invalid");
                return;
            } else {
                newTracking.find(".destination-box").removeClass("invalid");
            }
            var dataItem = {
                username: username,
                origin: origin,
                destination: destination,
                note: note
            }
            var data = {};
            data.Item = dataItem;

            if (ID) {
                track.updateTracking(ID, data, this);
            }

        });


        jQuery("#new-tracking-reset").click(function () {
            jQuery('#new-tracking').find('.new-tracking-text').val('');
            jQuery('#new-tracking').find('.new-tracking-email').val('');
            jQuery('#new-tracking').hide();
        });
        jQuery("#save-tr-item").click(function () {
            var ID = jQuery(this).attr("data-id");
            var popup = jQuery("#popup");
            var dataItem = {
                code: jQuery("#tr-code").html(),
                time: popup.find(".time").val(),
                location: popup.find(".location").val(),
                note: popup.find(".note").val(),
                status: popup.find(".status").val()
            }
            if ($.trim(dataItem.time) === "") {
                popup.find(".form_datetime").addClass("invalid");
                return;
            } else {
                popup.find(".form_datetime").removeClass("invalid");
            }
            if ($.trim(dataItem.location) === "") {
                popup.find(".location-box").addClass("invalid");
                return;
            } else {
                popup.find(".location-box").removeClass("invalid");
            }
            var data = {};
            data.Item = dataItem;
            if (ID > 0) {
                track.updateItem(ID, data, this);
            } else {
                track.createItem(data, this);
            }
        });

        $('button.popup-link').magnificPopup({
            items: {
                src: '#popup',
                type: 'inline'
            },
            callbacks: {
                open: function () {
                    jQuery("input.form-control, textarea.form-control").val("");
                    jQuery("#popup").find("#save-tr-item").attr("data-id", "");
                }
            },
            closeOnBgClick: false
        });
        jQuery("table").on("click", ".btn-update", function () {
            var btn = jQuery(this);
            jQuery.magnificPopup.open({
                items: {
                    src: '#popup',
                    type: 'inline'
                },
                callbacks: {
                    open: function () {
                        var popup = jQuery("#popup");
                        var trItem = btn.closest('tr');
                        var status = (trItem.find(".status").html() == 'Đang tiến hành') ? 'process' : 'error';
                        var dataItem = {
                            ID: trItem.attr("data-id"),
                            time: trItem.find(".time").html(),
                            location: trItem.find(".location").html(),
                            note: trItem.find(".note").html(),
                            status: status
                        };
                        popup.find('.timereadonly').val(dataItem.time);
                        popup.find('.location').val(dataItem.location);
                        popup.find('.note').val(dataItem.note);
                        popup.find('.status').val(dataItem.status);
                        popup.find('#save-tr-item').attr('data-id', dataItem.ID);
                    }
                },
                closeOnBgClick: false
            });
        });

        jQuery("table").on("click", ".btn-delete", function () {
            var btn = jQuery(this);
            jQuery.magnificPopup.open({
                items: {
                    src: '#confirm',
                    type: 'inline'
                },
                callbacks: {
                    open: function () {
                        var confirm = jQuery("#confirm");
                        var trItem = btn.closest('tr');
                        var ID = trItem.data("id");
                        confirm.find("#delete-tr-item").attr("data-id", ID);
                    }
                }
            });
        });

        jQuery("#delete-tr-item").click(function () {
            var ID = jQuery(this).attr("data-id");
            var data = {};
            data.ID = ID;
            if (ID > 0) {
                track.deleteItem(data, this);
            } else {
                jQuery.magnificPopup.close();
            }
        });

        jQuery("#tracking-resolve").click(function () {
            var ID = jQuery(this).attr("data-id");
            var newTracking = jQuery('#edit-tracking');
            var username = newTracking.find('.tracking-username').val();
            var origin = newTracking.find('.tracking-origin').val();
            var destination = newTracking.find('.tracking-destination').val();
            var note = newTracking.find('.tracking-note').val() + "";


            if ($.trim(username) === "") {
                newTracking.find(".username-box").addClass("invalid");
                return;
            } else {
                newTracking.find(".username-box").removeClass("invalid");
            }

            if ($.trim(origin) === "") {
                newTracking.find(".origin-box").addClass("invalid");
                return;
            } else {
                newTracking.find(".origin-box").removeClass("invalid");
            }

            if ($.trim(destination) === "") {
                newTracking.find(".destination-box").addClass("invalid");
                return;
            } else {
                newTracking.find(".destination-box").removeClass("invalid");
            }
            var dataItem = {
                username: username,
                origin: origin,
                destination: destination,
                note: note
            }
            var data = {};
            data.Item = dataItem;

            if (ID) {
                track.resolveItem(ID, data, this);
            }
        });
    });

})(jQuery);
