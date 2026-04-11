<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Bakeshop System</title>
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="<?= base_url('/dashboard') ?>" class="navbar-brand">🍰 Bakeshop System</a>
            <div class="nav-links">
                <span style="color: white;">Hi, <?= session()->get('name') ?></span>
                <a href="<?= base_url('/products') ?>">Products</a>
                <a href="<?= base_url('/products/create') ?>">Add Product</a>
                <a href="<?= base_url('/logout') ?>" class="btn-logout">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="alert alert-info clickable" onclick="window.location.href='<?= base_url('/products') ?>'">
            👋 Welcome back, <?= session()->get('name') ?>! Click here to manage products.
        </div>

        <div class="stats">
            <div class="stat-box clickable" onclick="window.location.href='<?= base_url('/products') ?>'">
                <div class="stat-number"><?= $total_products ?? 0 ?></div>
                <div class="stat-label">Total Products</div>
                <small>Click to view →</small>
            </div>
            <div class="stat-box clickable" onclick="window.location.href='<?= base_url('/products') ?>'">
                <div class="stat-number"><?= $total_stock ?? 0 ?></div>
                <div class="stat-label">Total Stock</div>
                <small>Click to view →</small>
            </div>
            <div class="stat-box clickable" onclick="window.location.href='<?= base_url('/products') ?>'">
                <div class="stat-number">₱<?= number_format($total_value ?? 0, 2) ?></div>
                <div class="stat-label">Inventory Value</div>
                <small>Click to view →</small>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Quick Actions</div>
            <div class="card-body">
                <div class="action-buttons">
                    <a href="<?= base_url('/products') ?>" class="btn btn-primary">📋 View All Products</a>
                    <a href="<?= base_url('/products/create') ?>" class="btn btn-success">➕ Add New Product</a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">📦 Recent Products</div>
            <div class="card-body">
                 <table>
                    <thead>
                        <tr><th>Product</th><th>Price</th><th>Stock</th><th>Status</th><th>Action</th></tr>
                    </thead>
                    <tbody>
                        <?php if(isset($recent_products) && !empty($recent_products)): ?>
                            <?php foreach($recent_products as $product): ?>
                            <tr>
                                <td><strong><?= $product['name'] ?></strong></td>
                                <td>₱<?= number_format($product['price'], 2) ?></td>
                                <td><?= $product['stock'] ?></td>
                                <td>
                                    <?php if($product['stock'] > 0): ?>
                                        <span class="badge badge-success">In Stock</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Out of Stock</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('/products/edit/'.$product['id']) ?>" class="btn btn-warning" style="padding: 3px 10px; font-size: 12px;">Edit</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" style="text-align: center;">No products yet. <a href="<?= base_url('/products/create') ?>">Add your first product</a></td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2024 Bakeshop System - Click any card to navigate</p>
    </footer>

    <script>
        // Add click animation to all clickable elements
        document.querySelectorAll('.clickable, .btn, .stat-box').forEach(el => {
            el.addEventListener('click', function(e) {
                if(this.tagName === 'A' || this.tagName === 'BUTTON') return;
                this.style.transform = 'scale(0.98)';
                setTimeout(() => { this.style.transform = ''; }, 150);
            });
        });
    </script>
</body>
</html>