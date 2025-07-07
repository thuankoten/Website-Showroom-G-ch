<?php 
session_start();
include("../connect.php"); 
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link href="../foldercss/style.css" rel="stylesheet"/>
    <link href="../foldercss/cart.css" rel="stylesheet"/>
    <script src="../jquery-3.7.1.js"></script>
    <script src="../js/cart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div id="container">
    <div id="include-header"></div>
    <script>
        $(function () {
            $("#include-header").load("header.php");
        });
    </script>

    <div class="cart-container">
        <div class="cart-header">
            <h1><i class="fas fa-shopping-cart"></i> Giỏ hàng</h1>
            <div class="cart-summary">
                <span>Tổng sản phẩm: <span id="total-items">0</span></span>
            </div>
        </div>

        <div class="cart-content">
            <div class="cart-table-container">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th width="5%"><input type="checkbox" id="select-all"></th>
                            <th width="15%">Sản phẩm</th>
                            <th width="25%">Tên sản phẩm</th>
                            <th width="15%">Đơn giá</th>
                            <th width="15%">Số lượng</th>
                            <th width="15%">Thành tiền</th>
                            <th width="10%">Hành động</th>
                        </tr>
                    </thead>
                    <tbody id="cart-items"></tbody>
                </table>
                <div class="empty-cart" id="empty-cart" style="display: none;">
                    <i class="fas fa-shopping-cart"></i>
                    <h3>Giỏ hàng trống</h3>
                    <a href="sanpham.php" class="btn btn-primary">Tiếp tục mua sắm</a>
                </div>
            </div>

            <div class="cart-footer">
                <div class="cart-actions">
                    <button type="button" class="btn btn-danger" id="delete-selected">
                        <i class="fas fa-trash"></i> Xóa đã chọn
                    </button>
                </div>
                <div class="cart-total">
                    <div class="total-info">
                        <div class="total-row">
                            <span>Tạm tính (<span id="selected-count">0</span> sản phẩm):</span>
                            <span class="amount" id="subtotal">0 VNĐ</span>
                        </div>
                        <div class="total-row total-final">
                            <span>Tổng cộng:</span>
                            <span class="amount" id="total">0 VNĐ</span>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success btn-checkout" id="checkout-btn" disabled>
                        <i class="fas fa-credit-card"></i> Thanh toán
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div style="margin: 40px auto; width: fit-content; border: 1px solid #ccc; padding: 15px 25px; border-radius: 8px;">
        <a href="tracuu.php" style="font-size: 18px; text-decoration: none; color: #000; font-weight: bold;">
            🔍 Tra cứu & Theo dõi đơn hàng
        </a>
    </div>

    <div id="include-footer"></div>
    <script>
        $(function () {
            $("#include-footer").load("footer.php");
        });
    </script>
    <script>
        $(document).ready(function() {
            loadCartItems();
            $(document).on('cartUpdated', loadCartItems);

            $('#select-all').change(function() {
                $('.item-checkbox').prop('checked', $(this).is(':checked'));
                updateCartSummary();
            });

            $('#delete-selected').click(function() {
                const selectedItems = $('.item-checkbox:checked');
                if (selectedItems.length === 0) {
                    alert('Vui lòng chọn sản phẩm cần xóa');
                    return;
                }
                if (confirm('Bạn có chắc muốn xóa những sản phẩm đã chọn?')) {
                    selectedItems.each(function() {
                        removeItem($(this).data('item-id'));
                    });
                }
            });

            $('#checkout-btn').click(function() {
                const selectedItems = $('.item-checkbox:checked');
                if (selectedItems.length === 0) {
                    alert('Vui lòng chọn sản phẩm để thanh toán');
                    return;
                }
                window.location.href = 'thanhtoan.php';
            });
        });

        function loadCartItems() {
            $.ajax({
                url: 'cart_api.php',
                method: 'POST',
                data: { action: 'get_cart_items' },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        displayCartItems(response.items);
                        updateCartSummary();
                    } else {
                        console.log('Lỗi tải giỏ hàng:', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Lỗi tải giỏ hàng:', xhr.status, error, xhr.responseText);
                }
            });
        }

        function displayCartItems(items) {
            const cartItems = $('#cart-items');
            const emptyCart = $('#empty-cart');
            if (items.length === 0) {
                cartItems.empty();
                emptyCart.show();
                $('.cart-table-container table').hide();
                $('.cart-footer').hide();
                return;
            }
            emptyCart.hide();
            $('.cart-table-container table').show();
            $('.cart-footer').show();
            cartItems.empty();

            items.forEach(function(item) {
                const itemPrice = parseFloat(item.price) || 0;
                const itemTotal = itemPrice * item.quantity;
                const itemId = item.id;
                const row = `
                    <tr data-item-id="${itemId}">
                        <td><input type="checkbox" class="item-checkbox" data-item-id="${itemId}" ${item.selected ? 'checked' : ''}></td>
                        <td><img src="data:image/jpeg;base64,${item.image || ''}" alt="${item.name || 'Sản phẩm'}" class="product-image" onerror="this.src='placeholder.jpg'"></td>
                        <td><div class="product-info"><h4>${item.name || 'Không rõ'}</h4><p class="product-code">Mã: ${item.ma_sp || 'N/A'}</p></div></td>
                        <td class="price">${formatPrice(itemPrice)} VNĐ</td>
                        <td>
                            <div class="quantity-controls">
                                <button class="qty-btn qty-minus" data-item-id="${itemId}">-</button>
                                <input type="number" class="qty-input" value="${item.quantity}" min="1" data-item-id="${itemId}">
                                <button class="qty-btn qty-plus" data-item-id="${itemId}">+</button>
                            </div>
                        </td>
                        <td class="total-price">${formatPrice(itemTotal)} VNĐ</td>
                        <td><button class="btn btn-danger btn-sm remove-item" data-item-id="${itemId}"><i class="fas fa-trash"></i></button></td>
                    </tr>`;
                cartItems.append(row);
            });

            $('.item-checkbox').off('change').on('change', function() {
                const itemId = parseInt($(this).data('item-id'));
                $.ajax({
                    url: 'cart_api.php',
                    method: 'POST',
                    data: { action: 'update_selection', item_id: itemId, selected: $(this).is(':checked') },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            updateCartSummary();
                        } else {
                            console.log('Lỗi cập nhật lựa chọn:', response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Lỗi cập nhật lựa chọn:', xhr.status, error, xhr.responseText);
                    }
                });
            });

            $('.qty-minus').off('click').on('click', function() {
                const itemId = parseInt($(this).data('item-id'));
                const input = $(`.qty-input[data-item-id="${itemId}"]`);
                let qty = parseInt(input.val());
                if (qty > 1) {
                    console.log('Decrease quantity for item:', itemId, 'to:', qty - 1);
                    updateQuantity(itemId, qty - 1);
                }
            });

            $('.qty-plus').off('click').on('click', function() {
                const itemId = parseInt($(this).data('item-id'));
                const input = $(`.qty-input[data-item-id="${itemId}"]`);
                let qty = parseInt(input.val());
                console.log('Increase quantity for item:', itemId, 'to:', qty + 1);
                updateQuantity(itemId, qty + 1);
            });

            $('.qty-input').off('change').on('change', function() {
                const itemId = parseInt($(this).data('item-id'));
                let qty = parseInt($(this).val());
                if (qty >= 1) {
                    console.log('Change quantity for item:', itemId, 'to:', qty);
                    updateQuantity(itemId, qty);
                } else {
                    $(this).val(1);
                }
            });

            $('.remove-item').off('click').on('click', function() {
                const itemId = parseInt($(this).data('item-id'));
                if (confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
                    console.log('Remove item:', itemId);
                    removeItem(itemId);
                }
            });
        }

        function updateQuantity(itemId, quantity) {
            $.ajax({
                url: 'cart_api.php',
                method: 'POST',
                data: { action: 'update_quantity', item_id: itemId, quantity: quantity },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        console.log('Quantity updated for item:', itemId, 'to:', quantity);
                        loadCartItems();
                        if (window.updateCartCount) window.updateCartCount();
                    } else {
                        console.log('Lỗi cập nhật số lượng:', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Lỗi cập nhật số lượng:', xhr.status, error, xhr.responseText);
                }
            });
        }

        function removeItem(itemId) {
            $.ajax({
                url: 'cart_api.php',
                method: 'POST',
                data: { action: 'remove_item', item_id: itemId },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        console.log('Item removed:', itemId);
                        loadCartItems();
                        if (window.updateCartCount) window.updateCartCount();
                    } else {
                        console.log('Lỗi xóa sản phẩm:', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Lỗi xóa sản phẩm:', xhr.status, error, xhr.responseText);
                }
            });
        }

        function updateCartSummary() {
            let totalItems = 0, selectedCount = 0, subtotal = 0;
            $('#cart-items tr').each(function() {
                const qty = parseInt($(this).find('.qty-input').val()) || 0;
                totalItems += qty;
                if ($(this).find('.item-checkbox').is(':checked')) {
                    selectedCount += qty;
                    const price = parseFloat($(this).find('.price').text().replace(/[^\d]/g, '')) || 0;
                    subtotal += price * qty;
                }
            });
            $('#total-items').text(totalItems);
            $('#selected-count').text(selectedCount);
            $('#subtotal').text(formatPrice(subtotal) + ' VNĐ');
            $('#total').text(formatPrice(subtotal) + ' VNĐ');
            $('#checkout-btn').prop('disabled', selectedCount === 0);
            const totalCheckboxes = $('.item-checkbox').length;
            const checkedCheckboxes = $('.item-checkbox:checked').length;
            $('#select-all').prop('indeterminate', checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes)
                           .prop('checked', checkedCheckboxes === totalCheckboxes && totalCheckboxes > 0);
        }

        function formatPrice(price) {
            return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    </script>
</body>
</html>