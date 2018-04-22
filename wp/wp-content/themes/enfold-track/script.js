/**
 * Created with JetBrains PhpStorm.
 * User: PhongTran
 * Date: 7/4/17
 * Time: 6:08 AM
 * To change this template use File | Settings | File Templates.
 */

jQuery(document).ready(function($) {
    var breadcrumb = jQuery('.breadcrumb').html();
    jQuery("#breadcrumb").find(".container").html(breadcrumb);
    jQuery('#quote-form').on('click', '#bt_get_quote', function(e) {
        e.preventDefault();
        var args = $('#quote-form').serializeArray().reduce(function(obj, item) {
            obj[item.name] = item.value;
            return obj;
        }, {});
        jQuery.ajax({
            url : ajax_object.ajax_url,
            type : 'post',
            dataType: "json",
            data : {
                action : 'get_price_by_filter',
                args : args
            },
            success : function( response ) {
                var table = '';
                if(!response.error){
                    table = '<table class="table table-striped" id="tblGrid"> <thead id="tblHead"> <tr> <th>Services</th> <th>Time</th> <th class="text-right">Fee</th> </tr></thead> <tbody> ' ;
                    var res_val = response.val;

                    for(var i = 0; i < res_val.length; i++){
                        table +='<tr><td>'+ res_val[i].name+'</td><td>'+ res_val[i].day_time+'</td><td class="text-right">'+ res_val[i].price + ((parseInt(response.weight) >= 21)?' $/kg':' $') + ' </td></tr>';
                    }
                    table += '</tbody> </table> <p>Báo giá trên là giá tạm tính (tùy thuộc vào chi tiết hàng cụ thể, địa chỉ người nhận...sẽ có giá khác nhau). Vui lòng liên hệ với chúng tôi để nhận được báo giá tốt nhất.</p>';
                }else{
                    table= response.txt;
                }
                var html = '<div class="modal-content quote-popup"> <div class="modal-header"> <h3 class="modal-title">Quote</h3> </div><div class="modal-body"> <table class="table table-striped" id="tblGrid"> <thead id="tblHead"> <tr> <th>Destination</th> <th>Weight</th> <th class="text-right">Type</th> </tr></thead> <tbody> <tr><td>'+ response.dest +'</td><td>'+ response.weight +'</td><td class="text-right">'+ response.type +'</td></tr></tbody> </table>' +
                    table +
                    '</div></div>';
                $.magnificPopup.open({
                    items: {
                        src: html,
                        type: 'inline'
                    }

                    // You may add options here, they're exactly the same as for $.fn.magnificPopup call
                    // Note that some settings that rely on click event (like disableOn or midClick) will not work here
                }, 0);

            }
        });
    });

    var wWidth = window.innerWidth;
    if(wWidth < 767){
        var headerInformation = jQuery('.header-information');
        var topMenu = jQuery('#avia2-menu');
        setTimeout(function(){
            jQuery('#mobile-advanced').append(topMenu.html()+'<li class="mobile-information">'+headerInformation.html()+'</li>');
            headerInformation.remove();
            topMenu.remove();
        },1000);


    }
    if(jQuery("#scrolltoid").length > 0){
        jQuery('html, body').animate({
            scrollTop: jQuery("#scrolltoid").offset().top
        }, 2000);
     }   
});
