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
            background: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background: #2C3E50;
            padding: 15px 0;
            color: white;
        }
        .container {
            max-width: 1400px;
            margin: 20px auto;
            padding: 0 20px;
        }
        .product-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            background: #fff9f5;
        }
        .product-name {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 10px;
        }
        .product-price {
            color: #ff6b35;
            font-size: 20px;
            font-weight: bold;
        }
        .cart-table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .cart-table th {
            background: #ff6b35;
            color: white;
            padding: 12px;
        }
        .cart-table td {
            padding: 12px;
            vertical-align: middle;
        }
        .total-row {
            background: #f8f9fa;
            font-weight: bold;
            font-size: 18px;
        }
        .quantity-input {
            width: 60px;
            text-align: center;
            padding: 5px;
        }
        .btn-add {
            background: #28a745;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-add:hover {
            background: #218838;
        }
        .checkout-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: sticky;
            top: 20px;
        }
        .amount-display {
            font-size: 32px;
            font-weight: bold;
            color: #ff6b35;
            text-align: center;
            margin: 20px 0;
        }
        .alert {
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }
        .btn-checkout {
            background: #ff6b35;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            font-size: 18px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-checkout:hover {
            background: #e55a2b;
        }
        .btn-clear {
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        .quantity-control {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .quantity-control button {
            width: 30px;
            height: 30px;
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
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            max-height: 500px;
            overflow-y: auto;
            padding: 10px;
        }
        @media (max-width: 768px) {
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container" style="display: flex; justify-content: space-between;">
            <a href="<?= base_url('/pos') ?>" style="color: #ff6b35; font-size: 24px; text-decoration: none;">
                🧮 POS System
            </a>
            <div>
                <span style="color: white;">👤 <?= session()->get('name') ?></span>
                <a href="<?= base_url('/dashboard') ?>" style="color: white; margin-left: 20px; text-decoration: none;">Dashboard</a>
                <a href="<?= base_url('/logout') ?>" style="background: #dc3545; padding: 5px 15px; border-radius: 5px; color: white; text-decoration: none; margin-left: 20px;">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success">✅ <?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-error">❌ <?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <div class="row">
            <!-- Products Section -->
            <div class="col-md-7">
                <div class="cart-table" style="margin-bottom: 20px; padding: 15px;">
                    <h5><i class="fas fa-search"></i> Click on any product to add</h5>
                    <div class="products-grid">
                        <?php foreach($products as $product): ?>
                            <div class="product-card" onclick="addToCart(<?= $product['id'] ?>, 1)">
                                <div class="product-name"><?= $product['name'] ?></div>
                                <div class="product-price">₱<?= number_format($product['price'], 2) ?></div>
                                <small>Stock: <?= $product['stock'] ?></small>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Cart Section -->
            <div class="col-md-5">
                <div class="checkout-card">
                    <h4><i class="fas fa-shopping-cart"></i> Current Order</h4>
                    <hr>
                    
                    <?php if(empty($cart)): ?>
                        <p class="text-muted text-center">Cart is empty. Click on products to add.</p>
                    <?php else: ?>
                        <div style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($cart as $item): ?>
                                    <tr>
                                        <td><?= $item['name'] ?></td>
                                        <td>
                                            <div class="quantity-control">
                                                <button class="btn-minus" onclick="updateQuantity(<?= $item['id'] ?>, <?= $item['quantity'] - 1 ?>)">-</button>
                                                <span style="width: 30px; text-align: center;"><?= $item['quantity'] ?></span>
                                                <button class="btn-plus" onclick="updateQuantity(<?= $item['id'] ?>, <?= $item['quantity'] + 1 ?>)">+</button>
                                            </div>
                                        </td>
                                        <td>₱<?= number_format($item['price'], 2) ?></td>
                                        <td>₱<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-danger" onclick="removeItem(<?= $item['id'] ?>)">✕</button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="total-row">
                                        <td colspan="3"><strong>SUBTOTAL</strong></td>
                                        <td><strong>₱<?= number_format($subtotal, 2) ?></strong></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
                        <hr>
                        
                        <form action="<?= base_url('/pos/checkout') ?>" method="post" id="checkoutForm">
                            <div class="form-group">
                                <label>Payment Amount (₱)</label>
                                <input type="number" step="0.01" id="payment" name="payment" class="form-control" required 
                                       oninput="calculateChange()" placeholder="Enter payment amount">
                            </div>
                            <div class="form-group">
                                <label>Change (₱)</label>
                                <input type="text" id="change" class="form-control" readonly style="background: #e9ecef; font-size: 20px; font-weight: bold;">
                            </div>
                            <div class="amount-display" id="totalDisplay">
                                Total: ₱<?= number_format($subtotal, 2) ?>
                            </div>
                            <button type="submit" class="btn-checkout">
                                <i class="fas fa-check-circle"></i> Complete Sale
                            </button>
                            <a href="<?= base_url('/pos/clearCart') ?>" class="btn-clear" style="display: block; text-align: center; margin-top: 10px; text-decoration: none;">
                                <i class="fas fa-trash"></i> Clear Cart
                            </a>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add to cart function
        function addToCart(product_id, quantity) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?= base_url('/pos/addToCart') ?>';
            
            const productInput = document.createElement('input');
            productInput.type = 'hidden';
            productInput.name = 'product_id';
            productInput.value = product_id;
            
            const quantityInput = document.createElement('input');
            quantityInput.type = 'hidden';
            quantityInput.name = 'quantity';
            quantityInput.value = quantity;
            
            form.appendChild(productInput);
            form.appendChild(quantityInput);
            document.body.appendChild(form);
            form.submit();
        }
        
        // Update quantity function
        function updateQuantity(product_id, quantity) {
            if (quantity < 0) return;
            
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?= base_url('/pos/updateCart') ?>';
            
            const productInput = document.createElement('input');
            productInput.type = 'hidden';
            productInput.name = 'product_id';
            productInput.value = product_id;
            
            const quantityInput = document.createElement('input');
            quantityInput.type = 'hidden';
            quantityInput.name = 'quantity';
            quantityInput.value = quantity;
            
            form.appendChild(productInput);
            form.appendChild(quantityInput);
            document.body.appendChild(form);
            form.submit();
        }
        
        // Remove item function
        function removeItem(product_id) {
            if (confirm('Remove this item from cart?')) {
                window.location.href = '<?= base_url('/pos/removeFromCart/') ?>' + product_id;
            }
        }
        
        // Calculate change function
        function calculateChange() {
            const total = <?= $subtotal ?>;
            const payment = document.getElementById('payment').value;
            const change = payment - total;
            
            if (change >= 0) {
                document.getElementById('change').value = '₱' + change.toFixed(2);
            } else {
                document.getElementById('change').value = 'Insufficient payment';
            }
        }
        
        // Auto-calculate on page load
        document.addEventListener('DOMContentLoaded', function() {
            const paymentInput = document.getElementById('payment');
            if (paymentInput) {
                paymentInput.addEventListener('input', calculateChange);
            }
        });
    </script>
</body>
</html>