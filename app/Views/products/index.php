<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Bakeshop System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: #f4f4f4;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background: #2C3E50;
            padding: 15px 0;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
        }
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .card-header {
            background: #ff6b35;
            color: white;
            padding: 15px 20px;
            border-radius: 10px 10px 0 0;
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
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        tr:hover {
            background: #f9f9f9;
        }
        .btn {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 12px;
            margin: 2px;
        }
        .btn-warning { background: #ffc107; color: #333; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-success { background: #28a745; color: white; }
        .btn-info { background: #17a2b8; color: white; }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 11px;
        }
        .badge-success { background: #28a745; color: white; }
        .badge-warning { background: #ffc107; color: #333; }
        .badge-danger { background: #dc3545; color: white; }
        .ingredients-preview {
            max-width: 250px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container" style="display: flex; justify-content: space-between;">
            <a href="<?= base_url('/dashboard') ?>" style="color: #ff6b35; font-size: 24px; text-decoration: none;">🍰 Bakeshop System</a>
            <div>
                <span style="color: white;">👤 <?= session()->get('name') ?> (<?= session()->get('role') ?>)</span>
                <a href="<?= base_url('/dashboard') ?>" style="color: white; margin-left: 20px;">Dashboard</a>
                <a href="<?= base_url('/pos') ?>" style="color: white; margin-left: 20px;">POS</a>
                <?php if(session()->get('role') === 'admin'): ?>
                    <a href="<?= base_url('/products/create') ?>" style="background: #28a745; padding: 5px 15px; border-radius: 5px; color: white; margin-left: 20px;">➕ Add Product</a>
                <?php endif; ?>
                <a href="<?= base_url('/logout') ?>" style="background: #dc3545; padding: 5px 15px; border-radius: 5px; color: white; margin-left: 20px;">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <span>📦 Products Inventory</span>
                <?php if(session()->get('role') === 'admin'): ?>
                    <span style="font-size: 12px;">🔐 Admin Mode - Full Access</span>
                <?php else: ?>
                    <span style="font-size: 12px;">👀 View Only Mode</span>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <?php if(session()->getFlashdata('success')): ?>
                    <div class="alert alert-success" style="background: #d4edda; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                        ✅ <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>
                
                <?php if(session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger" style="background: #f8d7da; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                        ❌ <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <div style="overflow-x: auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Ingredients</th>
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
                                    <td class="text-primary">₱<?= number_format($product['price'], 2) ?></td>
                                    <td><?= $product['stock'] ?></td>
                                    <td class="ingredients-preview" title="<?= $product['ingredients'] ?>">
                                        <?= $product['ingredients'] ?? 'No ingredients listed' ?>
                                    </td>
                                    <td>
                                        <?php if($product['stock'] > 10): ?>
                                            <span class="badge badge-success">In Stock</span>
                                        <?php elseif($product['stock'] > 0): ?>
                                            <span class="badge badge-warning">Low Stock</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger">Out of Stock</span>
                                        <?php endif; ?>
                                    </td>
                                    <?php if(session()->get('role') === 'admin'): ?>
                                    <td class="ingredients-preview" title="<?= isset($product['ingredients']) ? htmlspecialchars($product['ingredients']) : 'No ingredients listed' ?>">
    <?= isset($product['ingredients']) && !empty($product['ingredients']) ? htmlspecialchars($product['ingredients']) : 'No ingredients listed' ?>
</td>
                                    <?php endif; ?>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="<?= session()->get('role') === 'admin' ? '8' : '7' ?>" style="text-align: center;">
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
    </div>
</body>
</html>