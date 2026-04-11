<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - Bakeshop System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f0f2f5;
            font-family: 'Courier New', monospace;
        }
        .receipt-container {
            max-width: 400px;
            margin: 50px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        .receipt-header {
            background: #2C3E50;
            color: white;
            text-align: center;
            padding: 20px;
        }
        .receipt-body {
            padding: 20px;
        }
        .receipt-footer {
            background: #f8f9fa;
            padding: 15px;
            text-align: center;
        }
        .receipt-line {
            border-top: 1px dashed #ddd;
            margin: 15px 0;
        }
        .total-line {
            border-top: 2px solid #333;
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
            padding-top: 10px;
        }
        .btn-print {
            background: #ff6b35;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
        }
        .btn-new {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
            text-decoration: none;
            display: inline-block;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                background: white;
            }
            .receipt-container {
                box-shadow: none;
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="receipt-header">
            <h3>🍰 Sweet Haven Bakeshop</h3>
            <p>Order Receipt</p>
        </div>
        
        <div class="receipt-body">
            <div style="text-align: center; margin-bottom: 15px;">
                <small>Date: <?= $receipt['date'] ?></small><br>
                <small>Cashier: <?= $receipt['staff'] ?></small>
            </div>
            
            <div class="receipt-line"></div>
            
            <table style="width: 100%; font-size: 14px;">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($receipt['cart'] as $item): ?>
                    <tr>
                        <td><?= $item['name'] ?></td>
                        <td style="text-align: center;"><?= $item['quantity'] ?></td>
                        <td style="text-align: right;">₱<?= number_format($item['price'], 2) ?></td>
                        <td style="text-align: right;">₱<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div class="receipt-line"></div>
            
            <div style="text-align: right;">
                <p><strong>Subtotal:</strong> ₱<?= number_format($receipt['total'], 2) ?></p>
                <p><strong>Payment:</strong> ₱<?= number_format($receipt['payment'], 2) ?></p>
                <p><strong>Change:</strong> ₱<?= number_format($receipt['change'], 2) ?></p>
            </div>
            
            <div class="total-line"></div>
            
            <div style="text-align: center; margin-top: 20px;">
                <p>Thank you for your purchase!<br>Please come again</p>
            </div>
        </div>
        
        <div class="receipt-footer no-print">
            <button onclick="window.print()" class="btn-print">🖨️ Print Receipt</button>
            <a href="<?= base_url('/pos') ?>" class="btn-new">🆕 New Order</a>
        </div>
    </div>
</body>
</html>