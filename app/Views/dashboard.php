<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Bakeshop System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f4f4;
            font-family: Arial, sans-serif;
        }
        .navbar {
            background: #333;
            color: white;
            padding: 15px 0;
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
            border-radius: 5px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            cursor: pointer;
        }
        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #ff6b35;
        }
        .card {
            background: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .card-header {
            background: #ff6b35;
            color: white;
            padding: 15px 20px;
            border-radius: 5px 5px 0 0;
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
        .btn-primary { background: #ff6b35; color: white; }
        .btn-success { background: #28a745; color: white; }
        .btn-danger { background: #dc3545; color: white; }
        .alert {
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border-left: 4px solid #17a2b8;
        }
        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 12px;
        }
        .badge-admin { background: #dc3545; color: white; }
        .badge-staff { background: #28a745; color: white; }
        .nav-links a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
        }
        .btn-logout {
            background: #dc3545;
            padding: 5px 15px;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: #333;
            color: white;
            padding: 12px;
            text-align: left;
        }
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #ddd;
        }
        tr:hover {
            background: #f9f9f9;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container" style="display: flex; justify-content: space-between;">
            <a href="<?= base_url('/dashboard') ?>" style="color: #ff6b35; font-size: 24px; text-decoration: none;">🍰 Bakeshop System</a>
            <div class="nav-links">
                <span style="color: white;">👤 <?= session()->get('name') ?></span>
                <a href="<?= base_url('/products') ?>">Products</a>
                <?php if(session()->get('role') === 'admin'): ?>
                    <a href="<?= base_url('/products/create') ?>" style="background: #28a745; padding: 5px 15px; border-radius: 5px;">➕ Add Product</a>
                <?php endif; ?>
                <a href="<?= base_url('/logout') ?>" class="btn-logout">Logout</a>
                <a href="<?= base_url('/pos') ?>">POS</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="alert alert-info">
            <strong>👋 Welcome, <?= session()->get('name') ?>!</strong>
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
                <?php if(session()->get('role') === 'admin'): ?>
                    <a href="<?= base_url('/products/create') ?>" class="btn btn-success">➕ Add New Product</a>
                    <a href="<?= base_url('/pos') ?>" class="btn btn-success" style="background: #17a2b8;">
    🧮 POS System (Sell Products)
</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="card">
            <div class="card-header">📦 Recent Products</div>
            <div class="card-body">
                <div style="overflow-x: auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                            </tr>
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
                                            <span class="badge" style="background: #28a745; color: white; padding: 3px 8px; border-radius: 3px;">In Stock</span>
                                        <?php else: ?>
                                            <span class="badge" style="background: #dc3545; color: white; padding: 3px 8px; border-radius: 3px;">Out of Stock</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" style="text-align: center;">No products yet.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>