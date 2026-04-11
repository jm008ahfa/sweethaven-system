<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Bakeshop System</title>
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
            <div class="card-header" style="background: #ffc107; color: #333;">✏️ Edit Product</div>
            <div class="card-body">
                <form action="<?= base_url('/products/update/'.$product['id']) ?>" method="post">
                    <div class="form-group">
                        <label>Product Name *</label>
                        <input type="text" name="name" value="<?= $product['name'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select name="category">
                            <option value="Cakes" <?= ($product['category'] ?? '') == 'Cakes' ? 'selected' : '' ?>>🍰 Cakes</option>
                            <option value="Muffins" <?= ($product['category'] ?? '') == 'Muffins' ? 'selected' : '' ?>>🧁 Muffins</option>
                            <option value="Pastries" <?= ($product['category'] ?? '') == 'Pastries' ? 'selected' : '' ?>>🥐 Pastries</option>
                            <option value="Cookies" <?= ($product['category'] ?? '') == 'Cookies' ? 'selected' : '' ?>>🍪 Cookies</option>
                            <option value="Breads" <?= ($product['category'] ?? '') == 'Breads' ? 'selected' : '' ?>>🍞 Breads</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Price (₱) *</label>
                        <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Stock Quantity *</label>
                        <input type="number" name="stock" value="<?= $product['stock'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" rows="3"><?= $product['description'] ?? '' ?></textarea>
                    </div>
                    <div class="action-buttons">
                        <button type="submit" class="btn btn-warning">💾 Update Product</button>
                        <a href="<?= base_url('/products') ?>" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>