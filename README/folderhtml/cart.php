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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div id="container">
        <!-- Gọi header -->
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
                                <th width="5%">
                                    <input type="checkbox" id="select-all">
                                </th>
                                <th width="15%">Sản phẩm</th>
                                <th width="25%">Tên sản phẩm</th>
                                <th width="15%">Đơn giá</th>
                                <th width="15%">Số lượng</th>
                                <th width="15%">Thành tiền</th>
                                <th width="10%">Hành động</th>
                            </tr>
                        </thead>
                        <tbody id="cart-items">
                            <!-- Cart items will be loaded here -->
                        </tbody>
                    </table>
                    
                    <div class="empty-cart" id="empty-cart" style="display: none;">
                        <i class="fas fa-shopping-cart"></i>
                        <h3>Giỏ hàng của bạn đang trống</h3>
                        <p>Hãy thêm sản phẩm vào giỏ hàng để tiếp tục mua sắm</p>
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

        <!-- Gọi footer -->
        <div id="include-footer"></div>
        <script>
        $(function () {
            $("#include-footer").load("footer.php");
        });
        </script>
    </div>

    <script>
        $(document).ready(function() {
            loadCartItems();
            
            // Select all checkbox
            $('#select-all').change(function() {
                const isChecked = $(this).is(':checked');
                $('.item-checkbox').prop('checked', isChecked);
                updateItemSelections();
            });
            
            // Delete selected items
            $('#delete-selected').click(function() {
                const selectedItems = $('.item-checkbox:checked');
                if (selectedItems.length === 0) {
                    alert('Vui lòng chọn sản phẩm cần xóa');
                    return;
                }
                
                if (confirm('Bạn có chắc muốn xóa những sản phẩm đã chọn?')) {
                    selectedItems.each(function() {
                        const itemId = $(this).data('item-id');
                        removeItem(itemId);
                    });
                }
            });
            
            // Checkout button
            $('#checkout-btn').click(function() {
                const selectedItems = $('.item-checkbox:checked');
                if (selectedItems.length === 0) {
                    alert('Vui lòng chọn sản phẩm để thanh toán');
                    return;
                }
                
                // Redirect to checkout page
                window.location.href = 'checkout.php';
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
                    }
                },
                error: function() {
                    console.error('Error loading cart items');
                }
            });
        }

        function displayCartItems(items) {
            const cartItemsContainer = $('#cart-items');
            const emptyCart = $('#empty-cart');
            
            if (items.length === 0) {
                cartItemsContainer.empty();
                emptyCart.show();
                $('.cart-table-container table').hide();
                $('.cart-footer').hide();
                return;
            }
            
            emptyCart.hide();
            $('.cart-table-container table').show();
            $('.cart-footer').show();
            
            cartItemsContainer.empty();
            
            items.forEach(function(item) {
                const itemPrice = parseFloat(item.price) || 0;
                const itemTotal = itemPrice * item.qty;
                const imagePath = getImagePath(item.chungloai_id);
                
                const row = `
                    <tr data-item-id="${item.sp_id || item.id}">
                        <td>
                            <input type="checkbox" class="item-checkbox" 
                                   data-item-id="${item.sp_id || item.id}" 
                                   ${item.selected ? 'checked' : ''}>
                        </td>
                        <td>
                            <img src="../foldercss/Anhsp/${imagePath}/${item.image}" 
                                 alt="${item.ten_sanpham}" class="product-image">
                        </td>
                        <td>
                            <div class="product-info">
                                <h4>${item.ten_sanpham}</h4>
                                <p class="product-code">Mã: ${item.ma_sp}</p>
                            </div>
                        </td>
                        <td class="price">${formatPrice(itemPrice)} VNĐ</td>
                        <td>
                            <div class="quantity-controls">
                                <button type="button" class="qty-btn qty-minus" data-item-id="${item.sp_id || item.id}">-</button>
                                <input type="number" class="qty-input" value="${item.qty}" min="1" 
                                       data-item-id="${item.sp_id || item.id}">
                                <button type="button" class="qty-btn qty-plus" data-item-id="${item.sp_id || item.id}">+</button>
                            </div>
                        </td>
                        <td class="total-price">${formatPrice(itemTotal)} VNĐ</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-item" 
                                    data-item-id="${item.sp_id || item.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                
                cartItemsContainer.append(row);
            });
            
            // Bind events
            bindCartEvents();
            updateCartSummary();
        }

        function bindCartEvents() {
            // Checkbox change
            $('.item-checkbox').off('change').on('change', function() {
                const itemId = $(this).data('item-id');
                const isSelected = $(this).is(':checked');
                
                $.ajax({
                    url: 'cart_api.php',
                    method: 'POST',
                    data: { 
                        action: 'update_selection',
                        item_id: itemId,
                        selected: isSelected
                    },
                    dataType: 'json',
                    success: function(response) {
                        updateCartSummary();
                    }
                });
            });
            
            // Quantity controls
            $('.qty-minus').off('click').on('click', function() {
                const itemId = $(this).data('item-id');
                const input = $(`.qty-input[data-item-id="${itemId}"]`);
                const currentQty = parseInt(input.val());
                
                if (currentQty > 1) {
                    updateQuantity(itemId, currentQty - 1);
                }
            });
            
            $('.qty-plus').off('click').on('click', function() {
                const itemId = $(this).data('item-id');
                const input = $(`.qty-input[data-item-id="${itemId}"]`);
                const currentQty = parseInt(input.val());
                
                updateQuantity(itemId, currentQty + 1);
            });
            
            $('.qty-input').off('change').on('change', function() {
                const itemId = $(this).data('item-id');
                const newQty = parseInt($(this).val());
                
                if (newQty >= 1) {
                    updateQuantity(itemId, newQty);
                } else {
                    $(this).val(1);
                }
            });
            
            // Remove item
            $('.remove-item').off('click').on('click', function() {
                const itemId = $(this).data('item-id');
                
                if (confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
                    removeItem(itemId);
                }
            });
        }

        function updateQuantity(itemId, quantity) {
            $.ajax({
                url: 'cart_api.php',
                method: 'POST',
                data: { 
                    action: 'update_quantity',
                    item_id: itemId,
                    quantity: quantity
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        loadCartItems();
                        if (window.updateCartCount) {
                            window.updateCartCount();
                        }
                    }
                }
            });
        }

        function removeItem(itemId) {
            $.ajax({
                url: 'cart_api.php',
                method: 'POST',
                data: { 
                    action: 'remove_item',
                    item_id: itemId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        loadCartItems();
                        if (window.updateCartCount) {
                            window.updateCartCount();
                        }
                    }
                }
            });
        }

        function updateCartSummary() {
            let totalItems = 0;
            let selectedCount = 0;
            let subtotal = 0;
            
            $('#cart-items tr').each(function() {
                const qty = parseInt($(this).find('.qty-input').val()) || 0;
                totalItems += qty;
                
                const checkbox = $(this).find('.item-checkbox');
                if (checkbox.is(':checked')) {
                    selectedCount += qty;
                    const priceText = $(this).find('.price').text().replace(/[^\d]/g, '');
                    const price = parseFloat(priceText) || 0;
                    subtotal += price * qty;
                }
            });
            
            $('#total-items').text(totalItems);
            $('#selected-count').text(selectedCount);
            $('#subtotal').text(formatPrice(subtotal) + ' VNĐ');
            $('#total').text(formatPrice(subtotal) + ' VNĐ');
            
            // Enable/disable checkout button
            $('#checkout-btn').prop('disabled', selectedCount === 0);
            
            // Update select all checkbox
            const totalCheckboxes = $('.item-checkbox').length;
            const checkedCheckboxes = $('.item-checkbox:checked').length;
            
            if (totalCheckboxes === 0) {
                $('#select-all').prop('indeterminate', false).prop('checked', false);
            } else if (checkedCheckboxes === totalCheckboxes) {
                $('#select-all').prop('indeterminate', false).prop('checked', true);
            } else if (checkedCheckboxes > 0) {
                $('#select-all').prop('indeterminate', true);
            } else {
                $('#select-all').prop('indeterminate', false).prop('checked', false);
            }
        }

        function updateItemSelections() {
            $('.item-checkbox').each(function() {
                const itemId = $(this).data('item-id');
                const isSelected = $(this).is(':checked');
                
                $.ajax({
                    url: 'cart_api.php',
                    method: 'POST',
                    data: { 
                        action: 'update_selection',
                        item_id: itemId,
                        selected: isSelected
                    },
                    dataType: 'json'
                });
            });
            
            updateCartSummary();
        }

        function getImagePath(chungloaiId) {
            switch(parseInt(chungloaiId)) {
                case 1:
                    return 'cloai3030/Latnen';
                case 2:
                    return 'cloai6060/Latnen';
                case 3:
                    return 'cloai8080/Latnen';
                default:
                    return 'cloai6060/Latnen';
            }
        }

        function formatPrice(price) {
            return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    </script>
</body>
</html>
