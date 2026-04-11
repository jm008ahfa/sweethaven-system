<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $products = $productModel->findAll();
        
        $total_products = count($products);
        $total_stock = 0;
        $total_value = 0;
        
        foreach($products as $p) {
            $total_stock += $p['stock'];
            $total_value += $p['price'] * $p['stock'];
        }
        
        $recent_products = array_slice($products, -5);
        
        $data = [
            'total_products' => $total_products,
            'total_stock' => $total_stock,
            'total_value' => $total_value,
            'recent_products' => $recent_products
        ];
        
        return view('dashboard', $data);
    }
}