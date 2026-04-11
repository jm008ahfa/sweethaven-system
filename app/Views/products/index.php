<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Bakeshop System</title>
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="<?= base_url('/dashboard') ?>" class="navbar-brand">🍰 Bakeshop System</a>
            <div class="nav-links">
                <span style="color: white;"><?= session()->get('name') ?></span>
                <a href="<?= base_url('/dashboard') ?>">Dashboard</a>
                <a href="<?= base_url('/products/create') ?>">Add Product</a>
                <a href="<?= base_url('/logout') ?>" class="btn-logout">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                <span>📦 Products List</span>
                <a href="<?= base_url('/products/create') ?>" class="btn btn-success" style="padding: 5px 15px;">➕ Add Product</a>
            </div>
            <div class="card-body">
                <?php if(session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">✅ <?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>
                
                 <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($products)): ?>
                            <?php foreach($products as $product): ?>
                            <tr class="clickable" onclick="window.location.href='<?= base_url('/products/edit/'.$product['id']) ?>'">
                                <td><?= $product['id'] ?></td>
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
                                <td>
                                    <a href="<?= base_url('/products/edit/'.$product['id']) ?>" class="btn btn-warning" style="padding: 3px 10px; font-size: 12px;">✏️ Edit</a>
                                    <a href="<?= base_url('/products/delete/'.$product['id']) ?>" class="btn btn-danger" style="padding: 3px 10px; font-size: 12px;" onclick="event.stopPropagation(); return confirm('Delete this product?')">🗑️ Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center;">No products found. <a href="<?= base_url('/products/create') ?>">Add your first product</a></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script>
        // Prevent row click when clicking on buttons
        document.querySelectorAll('.btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    </script>
</body>
</html>