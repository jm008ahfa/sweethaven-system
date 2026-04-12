<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>📦 Current Stock Report</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Current Stock</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($products as $product): ?>
                <tr>
                    <td><?= $product['name'] ?></td>
                    <td>₱<?= number_format($product['price'], 2) ?></td>
                    <td><?= $product['stock'] ?></td>
                    <td>
                        <?php if($product['stock'] <= 0): ?>
                            <span class="badge bg-danger">Out of Stock</span>
                        <?php elseif($product['stock'] <= 5): ?>
                            <span class="badge bg-warning">Low Stock</span>
                        <?php else: ?>
                            <span class="badge bg-success">In Stock</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>