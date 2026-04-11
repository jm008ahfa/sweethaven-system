<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Bakeshop System</title>
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="<?= base_url('/dashboard') ?>" class="navbar-brand">🍰 Bakeshop System</a>
            <div class="nav-links">
                <a href="<?= base_url('/products') ?>" class="btn-logout" style="background: #6c757d;">← Back to Products</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card" style="max-width: 600px; margin: 0 auto;">
            <div class="card-header">➕ Add New Product</div>
            <div class="card-body">
                <?php if(session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>
                
                <form action="<?= base_url('/products/store') ?>" method="post">
                    <div class="form-group">
                        <label>Product Name *</label>
                        <input type="text" name="name" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select name="category">
                            <option value="Cakes">🍰 Cakes</option>
                            <option value="Muffins">🧁 Muffins</option>
                            <option value="Pastries">🥐 Pastries</option>
                            <option value="Cookies">🍪 Cookies</option>
                            <option value="Breads">🍞 Breads</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Price (₱) *</label>
                        <input type="number" step="0.01" name="price" required>
                    </div>
                    <div class="form-group">
                        <label>Stock Quantity *</label>
                        <input type="number" name="stock" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" rows="3" placeholder="Product description..."></textarea>
                    </div>
                    <div class="action-buttons">
                        <button type="submit" class="btn btn-primary">💾 Save Product</button>
                        <a href="<?= base_url('/products') ?>" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>