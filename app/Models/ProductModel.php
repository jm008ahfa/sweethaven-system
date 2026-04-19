<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'price', 'stock', 'ingredients', 'category'];
    protected $useTimestamps = false;
    protected $defaults = [
        'ingredients' => 'No ingredients listed'
    ];
    
    // Get all products with safe ingredients
    public function getAllProducts()
    {
        $products = $this->orderBy('name', 'ASC')->findAll();
        
        // Ensure ingredients is never null
        foreach ($products as &$product) {
            if (!isset($product['ingredients']) || $product['ingredients'] === null || $product['ingredients'] === '') {
                $product['ingredients'] = 'No ingredients listed';
            }
        }
        
        return $products;
    }
    
    // Get single product with safe ingredients
    public function getProduct($id)
    {
        $product = $this->find($id);
        if ($product && (!isset($product['ingredients']) || $product['ingredients'] === null || $product['ingredients'] === '')) {
            $product['ingredients'] = 'No ingredients listed';
        }
        return $product;
    }
    
    // Get products by category
    public function getByCategory($category)
    {
        $products = $this->where('category', $category)->findAll();
        foreach ($products as &$product) {
            if (!isset($product['ingredients']) || $product['ingredients'] === null) {
                $product['ingredients'] = 'No ingredients listed';
            }
        }
        return $products;
    }
    
    // Get low stock products
    public function getLowStock($threshold = 10)
    {
        $products = $this->where('stock <=', $threshold)->findAll();
        foreach ($products as &$product) {
            if (!isset($product['ingredients']) || $product['ingredients'] === null) {
                $product['ingredients'] = 'No ingredients listed';
            }
        }
        return $products;
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
    
    // Search products
    public function search($keyword)
    {
        $products = $this->like('name', $keyword)
                    ->orLike('ingredients', $keyword)
                    ->findAll();
        foreach ($products as &$product) {
            if (!isset($product['ingredients']) || $product['ingredients'] === null) {
                $product['ingredients'] = 'No ingredients listed';
            }
        }
        return $products;
    }
}