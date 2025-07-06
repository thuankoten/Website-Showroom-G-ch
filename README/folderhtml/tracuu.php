<?php
include 'header.php';
include 'database.php'; 
?>

<link rel="stylesheet" href="../foldercss/tracuu.css">

<div class="tracuu-container">
    <h2>Tra cứu đơn hàng</h2>

    <form method="GET" action="">
        <label for="order_code">Nhập mã đơn hàng:</label>
        <input type="text" name="order_code" id="order_code" required>
        <button type="submit">Tra cứu</button>
    </form>

    <?php
    if (isset($_GET['order_code'])) {
        $order_code = $_GET['order_code'];
        $sql = "SELECT * FROM orders WHERE order_code = '$order_code'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $order = mysqli_fetch_assoc($result);
        echo "<div class='result'>";
echo "<h3>Thông tin đơn hàng</h3>";
echo "<table class='info-table'>
        <tr><th>Mã đơn</th><td>{$order['order_code']}</td></tr>
        <tr><th>Họ tên</th><td>{$order['full_name']}</td></tr>
        <tr><th>SĐT</th><td>{$order['phone']}</td></tr>
        <tr><th>Email</th><td>{$order['email']}</td></tr>
        <tr><th>Địa chỉ</th><td>{$order['address']}</td></tr>
        <tr><th>Phương thức giao hàng</th><td>{$order['delivery_method']}</td></tr>
        <tr><th>Phương thức thanh toán</th><td>{$order['payment_method']}</td></tr>
        <tr><th>Ghi chú</th><td>{$order['order_note']}</td></tr>
      </table>";
            $status = $order['status'];
switch ($status) {
    case 'Chờ xác nhận':
        $badge = "<span style='color: orange;'>🕐 Chờ xác nhận</span>";
        break;
    case 'Đang giao':
        $badge = "<span style='color: blue;'>🚚 Đang giao</span>";
        break;
    case 'Đã giao':
        $badge = "<span style='color: green;'>✅ Đã giao</span>";
        break;
    case 'Đã hủy':
        $badge = "<span style='color: red;'>❌ Đã hủy</span>";
        break;
    default:
        $badge = "<span style='color: gray;'>$status</span>";
        break;
}
echo "<p><strong>Trạng thái đơn hàng:</strong> $badge</p>";

            // Hiển thị sản phẩm nếu có
$order_id = $order['id'];
$sql_items = "SELECT * FROM order_items WHERE order_id = $order_id";
$result_items = mysqli_query($conn, $sql_items);

if (mysqli_num_rows($result_items) > 0) {
    echo "<h3>Danh sách sản phẩm</h3>";
    echo "<table>
            <tr>
                <th>Sản Phẩm</th>
                <th>Tên Sản Phẩm</th>
                <th>Kích thước</th>
                <th>Số Lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
            </tr>";
    while ($row = mysqli_fetch_assoc($result_items)) {
        echo "<tr>
               <td><img src='{$row['image']}' alt='Sản Phẩm' width='60'></td>
                <td>{$row['product_name']}</td>
                <td>{$row['size']}</td>
                <td>{$row['quantity']}</td>
                <td>" . number_format($row['price'], 0, ',', '.') . "đ</td>
                <td>" . number_format($row['price'] * $row['quantity'], 0, ',', '.') . "đ</td>
              </tr>";
    }
    echo "</table>";
}

            echo "<div class='btns'>
                    <a href='cart.php' class='btn'>Quay lại giỏ hàng</a>
                  </div>";

            echo "</div>";
        } else {echo "<p class='error'>Không tìm thấy đơn hàng với mã: <strong>$order_code</strong></p>";
        }
    }
    ?>

</div>

<?php include 'footer.php'; ?>