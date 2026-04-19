<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - Bakeshop System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f5f5;
            font-family: 'Courier New', monospace;
        }
        .receipt {
            max-width: 380px;
            margin: 30px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .receipt-header {
            text-align: center;
            border-bottom: 1px dashed #ddd;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        .receipt-header h3 {
            margin: 0;
            color: #ff6b35;
        }
        .receipt-line {
            border-top: 1px dashed #ddd;
            margin: 15px 0;
        }
        .item-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .total-row {
            font-weight: bold;
            font-size: 16px;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 2px solid #333;
        }
        .text-right {
            text-align: right;
        }
        .btn-group {
            text-align: center;
            margin-top: 20px;
        }
        .btn-print {
            background: #ff6b35;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin: 5px;
            cursor: pointer;
        }
        .btn-new {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin: 5px;
            text-decoration: none;
            display: inline-block;
        }
        .stock-update {
            background: #e8f5e9;
            padding: 10px;
            border-radius: 5px;
            margin-top: 15px;
            font-size: 11px;
            color: #2e7d32;
            text-align: center;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                background: white;
            }
            .receipt {
                box-shadow: none;
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
       <div class="receipt-header">
    <h3>🍰 Bensan Bakeshop</h3>
    <p><?= date('Y-m-d H:i:s', strtotime($receipt['date'])) ?></p>
    <p>Cashier: <?= $receipt['staff'] ?></p>
</div>

<!-- Change footer if exists -->
<div class="stock-update">
    ✅ Thank you for shopping at Bensan Bakeshop!
</div>
        
        <?php foreach($receipt['cart'] as $item): ?>
        <div class="item-row">
            <span><?= $item['name'] ?> x <?= $item['quantity'] ?></span>
            <span>₱<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
        </div>
        <?php endforeach; ?>
        
        <div class="receipt-line"></div>
        
        <div class="item-row">
            <span><strong>TOTAL</strong></span>
            <span><strong>₱<?= number_format($receipt['total'], 2) ?></strong></span>
        </div>
        
        <div class="item-row">
            <span>Payment</span>
            <span>₱<?= number_format($receipt['payment'], 2) ?></span>
        </div>
        
        <div class="item-row">
            <span>Change</span>
            <span>₱<?= number_format($receipt['change'], 2) ?></span>
        </div>
        
        <div class="receipt-line"></div>
        
        <div style="text-align: center; margin-top: 15px;">
            <small>Thank you! Please come again</small>
        </div>
        
        <div class="stock-update">
            ✅ Inventory updated automatically
        </div>
        
        <div class="btn-group no-print">
            <button onclick="window.print()" class="btn-print">🖨️ Print Receipt</button>
            <a href="<?= base_url('/pos') ?>" class="btn-new">🆕 New Order</a>
        </div>
    </div>
</body>
</html>