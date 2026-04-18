<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Bakeshop System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        .form-header {
            background: #ffc107;
            color: #333;
            padding: 20px;
            text-align: center;
        }
        .form-body {
            padding: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }
        input, select, textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #ffc107;
        }
        textarea {
            resize: vertical;
            min-height: 100px;
        }
        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            margin: 5px;
        }
        .btn-warning {
            background: #ffc107;
            color: #333;
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h2><i class="fas fa-edit"></i> Edit Product</h2>
        </div>
        <div class="form-body">
            <form action="<?= base_url('/products/update/'.$product['id']) ?>" method="post">
                <div class="form-group">
                    <label>Product Name *</label>
                    <input type="text" name="name" value="<?= $product['name'] ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Category *</label>
                    <select name="category" required>
                        <option value="Cakes" <?= ($product['category'] ?? '') == 'Cakes' ? 'selected' : '' ?>>🍰 Cakes</option>
                        <option value="Muffins" <?= ($product['category'] ?? '') == 'Muffins' ? 'selected' : '' ?>>🧁 Muffins</option>
                        <option value="Pastries" <?= ($product['category'] ?? '') == 'Pastries' ? 'selected' : '' ?>>🥐 Pastries</option>
                        <option value="Cookies" <?= ($product['category'] ?? '') == 'Cookies' ? 'selected' : '' ?>>🍪 Cookies</option>
                        <option value="Breads" <?= ($product['category'] ?? '') == 'Breads' ? 'selected' : '' ?>>🍞 Breads</option>
                        <option value="Loaves" <?= ($product['category'] ?? '') == 'Loaves' ? 'selected' : '' ?>>🍞 Loaves</option>
                    </select>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Price (₱) *</label>
                            <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Stock Quantity *</label>
                            <input type="number" name="stock" value="<?= $product['stock'] ?>" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Ingredients</label>
                    <textarea name="ingredients" placeholder="List all ingredients..."><?= $product['ingredients'] ?? '' ?></textarea>
                    <div class="ingredients-hint" style="font-size: 12px; color: #666; margin-top: 5px;">
                        <i class="fas fa-info-circle"></i> Example: Flour, Sugar, Eggs, Butter, Baking Powder
                    </div>
                </div>
                
                <div style="text-align: center;">
                    <button type="submit" class="btn btn-warning">💾 Update Product</button>
                    <a href="<?= base_url('/products') ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>