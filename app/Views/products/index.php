<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Bakeshop System</title>
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
        .card {
            background: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .card-header {
            background: #ff6b35;
            color: white;
            padding: 15px 20px;
            border-radius: 5px 5px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card-body {
            padding: 20px;
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
        .btn {
            display: inline-block;
            padding: 5px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 12px;
        }
        .btn-warning {
            background: #ffc107;
            color: #333;
        }
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        .btn-success {
            background: #28a745;
            color: white;
        }
        .btn-primary {
            background: #ff6b35;
            color: white;
        }
        .alert {
            padding: 12px 15px;
            border-radius: 5px;
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
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 12px;
        }
        .badge-success { background: #28a745; color: white; }
        .badge-warning { background: #ffc107; color: #333; }
        .badge-danger { background: #dc3545; color: white; }
        .badge-info { background: #17a2b8; color: white; }
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
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container" style="display: flex; justify-content: space-between;">
            <a href="<?= base_url('/dashboard') ?>" style="color: #ff6b35; font-size: 24px; text-decoration: none;">🍰 Bakeshop System</a>
            <div class="nav-links">
                <span style="color: white;">👤 <?= session()->get('name') ?> (<?= session()->get('role') ?>)</span>
                <a href="<?= base_url('/dashboard') ?>">Dashboard</a>
                <?php if(session()->get('role') === 'admin'): ?>
                    <a href="<?= base_url('/products/create') ?>" style="background: #28a745; padding: 5px 15px; border-radius: 5px;">➕ Add Product</a>
                <?php endif; ?>
                <a href="<?= base_url('/logout') ?>" class="btn-logout">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <span>📦 Products List</span>
                <?php if(session()->get('role') === 'admin'): ?>
                    <span style="font-size: 12px;">🔐 Admin Mode - You can edit/delete products</span>
                <?php else: ?>
                    <span style="font-size: 12px;">👀 View Only Mode - Contact admin for changes</span>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <?php if(session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">✅ <?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>
                
                <?php if(session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">❌ <?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>
                
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <?php if(session()->get('role') === 'admin'): ?>
                                <th>Actions</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($products)): ?>
                            <?php foreach($products as $product): ?>
                            <tr>
                                <td><?= $product['id'] ?></td>
                                <td><strong><?= $product['name'] ?></strong></td>
                                <td><?= $product['category'] ?? 'Uncategorized' ?></td>
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
                                 </noscript>
                                <?php if(session()->get('role') === 'admin'): ?>
                                    <td>
                                        <a href="<?= base_url('/products/edit/'.$product['id']) ?>" class="btn btn-warning">✏️ Edit</a>
                                        <a href="<?= base_url('/products/delete/'.$product['id']) ?>" class="btn btn-danger" onclick="return confirm('Delete this product permanently?')">🗑️ Delete</a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="<?= session()->get('role') === 'admin' ? '7' : '6' ?>" style="text-align: center;">
                                    No products found. 
                                    <?php if(session()->get('role') === 'admin'): ?>
                                        <a href="<?= base_url('/products/create') ?>">Add your first product</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>