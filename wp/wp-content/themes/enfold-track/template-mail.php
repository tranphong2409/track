<div style="font-size:12.8px">
    <p>Dear <?php echo $data['display_name'];?></p>
    <p>Please be informed the final status of your shipment as below (Chúng tôi xin thông báo tình trạng lô hàng của anh/chị như sau):</p>
    <p>HAWB(Số vận đơn): <?php echo $data['code'];?></p>
    <p>Destination (Nước đến): <?php echo $data['destination'];?></p>
    <p>Delivery Time (Ngày phát): <?php echo date("d-m-Y H:i", strtotime($data['time']));?></p>
    <p>Notes (Ghi chú): <?php echo $data['note'];?></p>
    <p>For any enquiry of information, please contact our Customer Service at the below telephone number (Để biết thêm thông tin, vui lòng liên hệ với bộ phận Dịch vụ Khách hàng theo số điện thoại sau):</p>
    <p>- Hanoi Office (Văn phòng tại Hà Nội): (+84)-4-3632 1149</p>
    <p>- Hochiminh Office (Văn phòng tại Tp. Hồ Chí Minh): (+84)-8-3845 8536</p>
</div>
