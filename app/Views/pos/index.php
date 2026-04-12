<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS - Bakeshop System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            background: #2c3e50;
            padding: 12px 0;
        }
        
        .navbar a {
            color: white;
            text-decoration: none;
        }
        
        .container {
            max-width: 1400px;
            margin: 20px auto;
            padding: 0 20px;
        }
        
        .products-panel {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            max-height: 550px;
            overflow-y: auto;
        }
        
        .product-item {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .product-item:hover {
            background: #fff3e6;
            border-color: #ff6b35;
            transform: translateY(-3px);
        }
        
        .product-name {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 8px;
            color: #333;
        }
        
        .product-price {
            color: #ff6b35;
            font-size: 18px;
            font-weight: bold;
        }
        
        .product-stock {
            font-size: 12px;
            color: #666;
            margin-top: 8px;
        }
        
        .stock-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 10px;
            margin-top: 5px;
        }
        
        .stock-available {
            background: #28a745;
            color: white;
        }
        
        .stock-low {
            background: #ffc107;
            color: #333;
        }
        
        .stock-out {
            background: #dc3545;
            color: white;
        }
        
        .product-disabled {
            opacity: 0.5;
            cursor: not-allowed;
            background: #e9ecef;
        }
        
        .order-panel {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 20px;
        }
        
        .order-header {
            background: #ff6b35;
            color: white;
            padding: 15px 20px;
            border-radius: 10px 10px 0 0;
        }
        
        .order-body {
            padding: 20px;
            min-height: 300px;
        }
        
        .empty-cart {
            text-align: center;
            padding: 50px 20px;
            color: #999;
        }
        
        .cart-table {
            width: 100%;
            font-size: 14px;
        }
        
        .cart-table th {
            text-align: left;
            padding: 10px 5px;
            border-bottom: 2px solid #eee;
        }
        
        .cart-table td {
            padding: 12px 5px;
            border-bottom: 1px solid #eee;
        }
        
        .quantity-control {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .quantity-btn {
            width: 28px;
            height: 28px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        
        .btn-minus {
            background: #dc3545;
            color: white;
        }
        
        .btn-plus {
            background: #28a745;
            color: white;
        }
        
        .remove-btn {
            background: none;
            border: none;
            color: #dc3545;
            cursor: pointer;
        }
        
        .order-footer {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 0 0 10px 10px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-top: 15px;
            border-top: 2px solid #dee2e6;
        }
        
        .total-amount {
            font-size: 28px;
            font-weight: bold;
            color: #ff6b35;
        }
        
        .payment-input {
            width: 100%;
            padding: 12px;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        
        .change-row {
            background: #e8f5e9;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }
        
        .btn-checkout {
            background: #28a745;
            color: white;
            border: none;
            padding: 14px;
            width: 100%;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            margin-bottom: 10px;
        }
        
        .btn-clear {
            background: #dc3545;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 8px;
            cursor: pointer;
        }
        
        .alert {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }
        
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }
        
        @media (max-width: 768px) {
            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container" style="display: flex; justify-content: space-between;">
            <a href="<?= base_url('/pos') ?>" style="font-size: 20px; font-weight: bold;">🍰 Bakeshop POS</a>
            <div>
                <span>👤 <?= session()->get('name') ?></span>
                <a href="<?= base_url('/dashboard') ?>" style="margin-left: 20px;">Dashboard</a>
                <a href="<?= base_url('/logout') ?>" style="background: #dc3545; padding: 5px 12px; border-radius: 5px; margin-left: 15px;">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success">✅ <?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">❌ <?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-7">
                <div class="products-panel">
                    <h4><i class="fas fa-cake-candles"></i> Products</h4>
                    <div class="product-grid">
                        <?php foreach($products as $product): ?>
                            <?php if($product['stock'] > 0): ?>
                                <div class="product-item" onclick="addToCart(<?= $product['id'] ?>, 1)">
                                    <div class="product-name"><?= $product['name'] ?></div>
                                    <div class="product-price">₱<?= number_format($product['price'], 2) ?></div>
                                    <div class="product-stock">
                                        Stock: <?= $product['stock'] ?>
                                        <?php if($product['stock'] <= 5): ?>
                                            <span class="stock-badge stock-low">Low Stock!</span>
                                        <?php else: ?>
                                            <span class="stock-badge stock-available">Available</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="product-item product-disabled">
                                    <div class="product-name"><?= $product['name'] ?></div>
                                    <div class="product-price">₱<?= number_format($product['price'], 2) ?></div>
                                    <div class="product-stock">
                                        <span class="stock-badge stock-out">Out of Stock</span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="order-panel">
                    <div class="order-header">
                        <h4><i class="fas fa-shopping-cart"></i> Current Order</h4>
                    </div>
                    
                    <div class="order-body">
                        <?php if(empty($cart)): ?>
                            <div class="empty-cart">
                                <i class="fas fa-shopping-basket" style="font-size: 48px;"></i>
                                <p>Cart is empty</p>
                                <small>Click on products to add</small>
                            </div>
                        <?php else: ?>
                            <table class="cart-table">
                                <thead>
                                    <tr><th>Item</th><th>Qty</th><th>Total</th><th></th></tr>
                                </thead>
                                <tbody>
                                    <?php foreach($cart as $item): ?>
                                    <tr>
                                        <td><?= $item['name'] ?><br><small>₱<?= number_format($item['price'], 2) ?> ea</small></td>
                                        <td>
                                            <div class="quantity-control">
                                                <button class="quantity-btn btn-minus" onclick="updateQuantity(<?= $item['id'] ?>, <?= $item['quantity'] - 1 ?>)">-</button>
                                                <span><?= $item['quantity'] ?></span>
                                                <button class="quantity-btn btn-plus" onclick="updateQuantity(<?= $item['id'] ?>, <?= $item['quantity'] + 1 ?>)">+</button>
                                            </div>
                                        </td>
                                        <td class="item-total">₱<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                        <td><button class="remove-btn" onclick="removeItem(<?= $item['id'] ?>);">🗑️</button></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                    
                    <div class="order-footer">
                        <div class="total-row">
                            <span><strong>TOTAL</strong></span>
                            <span class="total-amount">₱<?= number_format($subtotal, 2) ?></span>
                        </div>
                        
                        <?php if(!empty($cart)): ?>
                            <form action="<?= base_url('/pos/checkout') ?>" method="post">
                                <input type="number" step="0.01" name="payment" class="payment-input" 
                                       placeholder="Enter payment amount" required oninput="calculateChange(this.value, <?= $subtotal ?>)">
                                <div class="change-row" id="changeRow" style="display: none;">
                                    <span>Change:</span>
                                    <span id="changeAmount">₱0.00</span>
                                </div>
                                <button type="submit" class="btn-checkout">✅ Complete Sale</button>
                            </form>
                            <button onclick="clearCart()" class="btn-clear">🗑️ Clear Cart</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addToCart(product_id, quantity) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?= base_url('/pos/addToCart') ?>';
            form.innerHTML = `<input type="hidden" name="product_id" value="${product_id}">
                             <input type="hidden" name="quantity" value="${quantity}">`;
            document.body.appendChild(form);
            form.submit();
        }
        
        function updateQuantity(product_id, quantity) {
            if (quantity < 0) return;
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?= base_url('/pos/updateCart') ?>';
            form.innerHTML = `<input type="hidden" name="product_id" value="${product_id}">
                             <input type="hidden" name="quantity" value="${quantity}">`;
            document.body.appendChild(form);
            form.submit();
        }
        
        function removeItem(product_id) {
            if (confirm('Remove this item?')) {
                window.location.href = '<?= base_url('/pos/removeFromCart/') ?>' + product_id;
            }
        }
        
        function clearCart() {
            if (confirm('Clear entire cart?')) {
                window.location.href = '<?= base_url('/pos/clearCart') ?>';
            }
        }
        
        function calculateChange(payment, total) {
            const changeRow = document.getElementById('changeRow');
            const changeAmount = document.getElementById('changeAmount');
            payment = parseFloat(payment);
            
            if (!isNaN(payment) && payment >= total) {
                const change = payment - total;
                changeAmount.innerHTML = '₱' + change.toFixed(2);
                changeRow.style.display = 'flex';
            } else {
                changeRow.style.display = 'none';
            }
        }
    </script>
</body>
</html>