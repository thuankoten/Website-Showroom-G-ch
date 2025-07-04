<?php
include("../connect.php");

header('Content-Type: application/json');

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    
    switch ($action) {
        case 'get_phoicanh':
            // Lấy tất cả dữ liệu phối cảnh
            $sql = "SELECT * FROM phoicanh ORDER BY id_phoicanh";
            $result = mysqli_query($conn, $sql);
            
            $phoicanh = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $phoicanh[] = $row;
            }
            
            echo json_encode(['success' => true, 'data' => $phoicanh]);
            break;
            
        case 'get_sanpham':
            // Lấy thông tin chi tiết sản phẩm
            $sanpham_id = $_POST['sanpham_id'];
            
            $sql = "SELECT sp.*, ls.loai_name as ten_loai, cls.kichthuoc as ten_chungloai 
                    FROM sanpham sp 
                    LEFT JOIN loai_sanpham ls ON sp.loai_id = ls.loai_id 
                    LEFT JOIN chungloai_sanpham cls ON sp.chungloai_id = cls.chungloai_id 
                    WHERE sp.sanpham_id = '$sanpham_id'";
            
            $result = mysqli_query($conn, $sql);
            
            if ($row = mysqli_fetch_assoc($result)) {
                echo json_encode(['success' => true, 'data' => $row]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Không tìm thấy sản phẩm']);
            }
            break;
            
        case 'get_sanpham_random':
            // Lấy sản phẩm ngẫu nhiên cho hiển thị
            $sql = "SELECT * FROM sanpham ORDER BY RAND() LIMIT 12";
            $result = mysqli_query($conn, $sql);
            
            $sanpham = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $sanpham[] = $row;
            }
            
            echo json_encode(['success' => true, 'data' => $sanpham]);
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Action không hợp lệ']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Thiếu tham số action']);
}

mysqli_close($conn);
?>
