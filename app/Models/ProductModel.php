<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'price', 'stock'];
    protected $useTimestamps = false;
    
    // Get all products (no duplicates)
    public function getAllProducts()
    {
        return $this->distinct()
                    ->orderBy('id', 'ASC')
                    ->findAll();
    }
    
    // Get product by name (to prevent duplicates)
    public function getProductByName($name)
    {
        return $this->where('name', $name)->first();
    }
    
    // Check if enough stock is available
    public function hasEnoughStock($product_id, $quantity)
    {
        $product = $this->find($product_id);
        if ($product) {
            return $product['stock'] >= $quantity;
        }
        return false;
    }
    
    // Subtract stock
    public function subtractStock($product_id, $quantity)
    {
        $product = $this->find($product_id);
        if ($product) {
            $newStock = $product['stock'] - $quantity;
            return $this->update($product_id, ['stock' => $newStock]);
        }
        return false;
    }
}