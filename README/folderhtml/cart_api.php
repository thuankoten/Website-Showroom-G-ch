<?php
session_start();
include("../connect.php");

header('Content-Type: application/json');

// Debug function to log errors
function debug_log($message) {
    error_log(date('[Y-m-d H:i:s] ') . $message . PHP_EOL, 3, '../logs/cart_debug.log');
}

// Initialize cart session if not exists
if (!isset($_SESSION['cart_id']) && isset($_SESSION['user_id'])) {
    // Create cart for logged in user
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT id FROM cart WHERE user_id = '$user_id'";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows == 0) {
        // Create new cart
        $sql = "INSERT INTO cart (user_id) VALUES ('$user_id')";
        if ($conn->query($sql)) {
            $_SESSION['cart_id'] = $conn->insert_id;
        }
    } elseif ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['cart_id'] = $row['id'];
    }
} elseif (!isset($_SESSION['cart_id']) && !isset($_SESSION['user_id'])) {
    // Create temporary cart for guest user using session
    if (!isset($_SESSION['cart_items'])) {
        $_SESSION['cart_items'] = [];
    }
}

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    
    switch ($action) {
        case 'add_to_cart':
            $sanpham_id = intval($_POST['sanpham_id']);
            $quantity = intval($_POST['quantity']) ?: 1;
            
            debug_log("Adding product: $sanpham_id, quantity: $quantity");
            
            // Get product info
            $sql = "SELECT * FROM sanpham WHERE sanpham_id = '$sanpham_id'";
            $result = $conn->query($sql);
            
            if ($result && $row = $result->fetch_assoc()) {
                $price = $row['gia'] ?: 0;
                debug_log("Product found: " . $row['ten_sanpham'] . ", price: $price");
                
                if (isset($_SESSION['cart_id'])) {
                    // Logged in user - use database
                    $cart_id = $_SESSION['cart_id'];
                    debug_log("Using cart_id: $cart_id");
                    
                    // Check if item already exists
                    $sql = "SELECT * FROM cart_items WHERE card_id = '$cart_id' AND sp_id = '$sanpham_id'";
                    $result = $conn->query($sql);
                    
                    if ($result && $result->num_rows > 0) {
                        // Update quantity
                        $sql = "UPDATE cart_items SET qty = qty + $quantity WHERE card_id = '$cart_id' AND sp_id = '$sanpham_id'";
                        debug_log("Updating existing item");
                    } else {
                        // Insert new item
                        $sql = "INSERT INTO cart_items (card_id, sp_id, qty, price) VALUES ('$cart_id', '$sanpham_id', '$quantity', '$price')";
                        debug_log("Inserting new item");
                    }
                    
                    if ($conn->query($sql)) {
                        debug_log("Database operation successful");
                        echo json_encode(['success' => true, 'message' => 'Đã thêm vào giỏ hàng']);
                    } else {
                        debug_log("Database error: " . $conn->error);
                        echo json_encode(['success' => false, 'message' => 'Lỗi database: ' . $conn->error]);
                    }
                } else {
                    // Guest user - use session
                    debug_log("Using session for guest user");
                    if (!isset($_SESSION['cart_items'])) {
                        $_SESSION['cart_items'] = [];
                    }
                    
                    $found = false;
                    foreach ($_SESSION['cart_items'] as &$item) {
                        if ($item['sp_id'] == $sanpham_id) {
                            $item['qty'] += $quantity;
                            $found = true;
                            break;
                        }
                    }
                    
                    if (!$found) {
                        $_SESSION['cart_items'][] = [
                            'sp_id' => $sanpham_id,
                            'qty' => $quantity,
                            'price' => $price,
                            'selected' => true
                        ];
                    }
                    
                    debug_log("Session cart updated");
                    echo json_encode(['success' => true, 'message' => 'Đã thêm vào giỏ hàng']);
                }
            } else {
                debug_log("Product not found: $sanpham_id");
                echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại']);
            }
            break;
            
        case 'get_cart_count':
            $count = 0;
            
            if (isset($_SESSION['cart_id'])) {
                // Logged in user
                $cart_id = $_SESSION['cart_id'];
                $sql = "SELECT SUM(qty) as total FROM cart_items WHERE card_id = '$cart_id'";
                $result = $conn->query($sql);
                if ($result && $row = $result->fetch_assoc()) {
                    $count = $row['total'] ?: 0;
                }
            } else {
                // Guest user
                if (isset($_SESSION['cart_items'])) {
                    foreach ($_SESSION['cart_items'] as $item) {
                        $count += $item['qty'];
                    }
                }
            }
            
            echo json_encode(['success' => true, 'count' => $count]);
            break;
            
        case 'get_cart_items':
            $items = [];
            
            if (isset($_SESSION['cart_id'])) {
                // Logged in user
                $cart_id = $_SESSION['cart_id'];
                $sql = "SELECT ci.*, sp.ten_sanpham, sp.ma_sp, sp.image, sp.chungloai_id 
                        FROM cart_items ci 
                        JOIN sanpham sp ON ci.sp_id = sp.sanpham_id 
                        WHERE ci.card_id = '$cart_id'";
                $result = $conn->query($sql);
                
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        $row['selected'] = true; // Default selected
                        $items[] = $row;
                    }
                }
            } else {
                // Guest user
                if (isset($_SESSION['cart_items'])) {
                    foreach ($_SESSION['cart_items'] as $item) {
                        $sql = "SELECT ten_sanpham, ma_sp, image, chungloai_id FROM sanpham WHERE sanpham_id = " . $item['sp_id'];
                        $result = $conn->query($sql);
                        if ($result && $product = $result->fetch_assoc()) {
                            $items[] = array_merge($item, $product);
                        }
                    }
                }
            }
            
            echo json_encode(['success' => true, 'items' => $items]);
            break;
            
        case 'update_quantity':
            $item_id = intval($_POST['item_id']);
            $quantity = intval($_POST['quantity']);
            
            if (isset($_SESSION['cart_id'])) {
                // Logged in user
                $cart_id = $_SESSION['cart_id'];
                $sql = "UPDATE cart_items SET qty = '$quantity' WHERE id = '$item_id' AND card_id = '$cart_id'";
                
                if ($conn->query($sql)) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Lỗi cập nhật số lượng: ' . $conn->error]);
                }
            } else {
                // Guest user - update session
                if (isset($_SESSION['cart_items'])) {
                    foreach ($_SESSION['cart_items'] as &$item) {
                        if ($item['sp_id'] == $item_id) {
                            $item['qty'] = $quantity;
                            break;
                        }
                    }
                    echo json_encode(['success' => true]);
                }
            }
            break;
            
        case 'remove_item':
            $item_id = intval($_POST['item_id']);
            
            if (isset($_SESSION['cart_id'])) {
                // Logged in user
                $cart_id = $_SESSION['cart_id'];
                $sql = "DELETE FROM cart_items WHERE id = '$item_id' AND card_id = '$cart_id'";
                
                if ($conn->query($sql)) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Lỗi xóa sản phẩm: ' . $conn->error]);
                }
            } else {
                // Guest user - remove from session
                if (isset($_SESSION['cart_items'])) {
                    foreach ($_SESSION['cart_items'] as $key => $item) {
                        if ($item['sp_id'] == $item_id) {
                            unset($_SESSION['cart_items'][$key]);
                            $_SESSION['cart_items'] = array_values($_SESSION['cart_items']); // Reindex
                            break;
                        }
                    }
                    echo json_encode(['success' => true]);
                }
            }
            break;
            
        case 'update_selection':
            $item_id = intval($_POST['item_id']);
            $selected = $_POST['selected'] === 'true';
            
            if (!isset($_SESSION['cart_id'])) {
                // Guest user - update session
                if (isset($_SESSION['cart_items'])) {
                    foreach ($_SESSION['cart_items'] as &$item) {
                        if ($item['sp_id'] == $item_id) {
                            $item['selected'] = $selected;
                            break;
                        }
                    }
                    echo json_encode(['success' => true]);
                }
            } else {
                // For logged in users, we need to add a selected column to cart_items table
                // For now, use session to store selection state
                if (!isset($_SESSION['cart_selections'])) {
                    $_SESSION['cart_selections'] = [];
                }
                $_SESSION['cart_selections'][$item_id] = $selected;
                echo json_encode(['success' => true]);
            }
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Action không hợp lệ']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Thiếu tham số action']);
}

$conn->close();
?>
