<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Product extends BaseController
{
    public function index()
    {
        $model = new ProductModel();
        $data['products'] = $model->getAllProducts(); // Use safe method
        $data['is_admin'] = (session()->get('role') === 'admin');
        return view('products/index', $data);
    }
    
    public function create()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/products')->with('error', 'Only admin can add products.');
        }
        return view('products/create');
    }
    
    public function store()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/products')->with('error', 'Only admin can add products.');
        }
        
        $model = new ProductModel();
        
        $rules = [
            'name' => 'required|min_length[2]',
            'price' => 'required|numeric|greater_than[0]',
            'stock' => 'required|integer|greater_than_equal_to[0]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', 'Please check your inputs');
        }
        
        // Get ingredients, default if empty
        $ingredients = $this->request->getPost('ingredients');
        if (empty($ingredients)) {
            $ingredients = 'No ingredients listed';
        }
        
        $model->insert([
            'name' => $this->request->getPost('name'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'ingredients' => $ingredients,
            'category' => $this->request->getPost('category')
        ]);
        
        return redirect()->to('/products')->with('success', 'Product added successfully!');
    }
    
    public function edit($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/products')->with('error', 'Only admin can edit products.');
        }
        
        $model = new ProductModel();
        $data['product'] = $model->getProduct($id); // Use safe method
        
        if (!$data['product']) {
            return redirect()->to('/products')->with('error', 'Product not found');
        }
        
        return view('products/edit', $data);
    }
    
    public function update($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/products')->with('error', 'Only admin can update products.');
        }
        
        $model = new ProductModel();
        
        $ingredients = $this->request->getPost('ingredients');
        if (empty($ingredients)) {
            $ingredients = 'No ingredients listed';
        }
        
        $model->update($id, [
            'name' => $this->request->getPost('name'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'ingredients' => $ingredients,
            'category' => $this->request->getPost('category')
        ]);
        
        return redirect()->to('/products')->with('success', 'Product updated successfully!');
    }
    
    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/products')->with('error', 'Only admin can delete products.');
        }
        
        $model = new ProductModel();
        $model->delete($id);
        return redirect()->to('/products')->with('success', 'Product deleted successfully!');
    }
    
    public function view($id)
    {
        $model = new ProductModel();
        $data['product'] = $model->getProduct($id);
        
        if (!$data['product']) {
            return redirect()->to('/products')->with('error', 'Product not found');
        }
        
        return view('products/view', $data);
    }
}