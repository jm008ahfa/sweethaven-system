<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Bensan Bakeshop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f4f4;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background: #3E2723;
            padding: 15px 0;
            color: white;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            cursor: pointer;
            border-bottom: 4px solid #D2691E;
        }
        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #D2691E;
        }
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .card-header {
            background: #D2691E;
            color: white;
            padding: 15px 20px;
            border-radius: 10px 10px 0 0;
        }
        .card-body {
            padding: 20px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            margin: 5px;
        }
        .btn-primary { background: #D2691E; color: white; }
        .btn-success { background: #228B22; color: white; }
        .alert {
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .alert-info {
            background: #E3F2FD;
            color: #0D47A1;
            border-left: 4px solid #2196F3;
        }
        .nav-links a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
        }
        .btn-logout {
            background: #DC143C;
            padding: 5px 15px;
            border-radius: 5px;
        }
        .footer {
            background: #3E2723;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: #3E2723;
            color: white;
            padding: 12px;
            text-align: left;
        }
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #ddd;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 12px;
        }
        .badge-success { background: #228B22; color: white; }
        .badge-warning { background: #FFA500; color: white; }
        .badge-danger { background: #DC143C; color: white; }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container" style="display: flex; justify-content: space-between;">
            <a href="<?= base_url('/dashboard') ?>" style="color: #FFD700; font-size: 24px; text-decoration: none;">🍰 Bensan Bakeshop</a>
            <div class="nav-links">
                <span style="color: white;">👤 <?= session()->get('name') ?></span>
                <a href="<?= base_url('/products') ?>">Products</a>
                <a href="<?= base_url('/pos') ?>">POS</a>
                <?php if(session()->get('role') === 'admin'): ?>
                    <a href="<?= base_url('/products/create') ?>" style="background: #228B22; padding: 5px 15px; border-radius: 5px;">➕ Add Product</a>
                <?php endif; ?>
                <a href="<?= base_url('/logout') ?>" class="btn-logout">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="alert alert-info">
            <strong>👋 Welcome to Bensan Bakeshop, <?= session()->get('name') ?>!</strong><br>
            Quality baked goods made fresh daily since 2024.
        </div>

        <div class="stats">
            <div class="stat-box" onclick="window.location.href='<?= base_url('/products') ?>'">
                <div class="stat-number"><?= $total_products ?? 0 ?></div>
                <div class="stat-label">Total Products</div>
                <small>Click to view →</small>
            </div>
            <div class="stat-box" onclick="window.location.href='<?= base_url('/products') ?>'">
                <div class="stat-number"><?= $total_stock ?? 0 ?></div>
                <div class="stat-label">Total Stock</div>
                <small>Click to view →</small>
            </div>
            <div class="stat-box" onclick="window.location.href='<?= base_url('/products') ?>'">
                <div class="stat-number">₱<?= number_format($total_value ?? 0, 2) ?></div>
                <div class="stat-label">Inventory Value</div>
                <small>Click to view →</small>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Quick Actions</div>
            <div class="card-body">
                <a href="<?= base_url('/products') ?>" class="btn btn-primary">📋 View Products</a>
                <a href="<?= base_url('/pos') ?>" class="btn btn-success">💰 Point of Sale</a>
                <?php if(session()->get('role') === 'admin'): ?>
                    <a href="<?= base_url('/products/create') ?>" class="btn btn-success">➕ Add New Product</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="card">
            <div class="card-header">📦 Recent Products</div>
            <div class="card-body">
                <div style="overflow-x: auto;">
                    <table class="table">
                        <thead>
                            <tr><th>Product Name</th><th>Price</th><th>Stock</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            <?php if(isset($recent_products) && !empty($recent_products)): ?>
                                <?php foreach($recent_products as $product): ?>
                                <tr>
                                    <td><strong><?= $product['name'] ?></strong></td>
                                    <td>₱<?= number_format($product['price'], 2) ?></td>
                                    <td><?= $product['stock'] ?></td>
                                    <td>
                                        <?php if($product['stock'] > 10): ?>
                                            <span class="badge badge-success">In Stock</span>
                                        <?php elseif($product['stock'] > 0): ?>
                                            <span class="badge badge-warning">Low Stock</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger">Out of Stock</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="4" style="text-align: center;">No products yet. <a href="<?= base_url('/products/create') ?>">Add your first product</a></td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p>&copy; <?= date('Y') ?> Bensan Bakeshop. All rights reserved.</p>
            <p><small>Quality Baked Goods Since 2024 | Made with ❤️</small></p>
        </div>
    </footer>
</body>
</html>