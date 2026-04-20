<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Product extends BaseController
{
    // READ - Display all products
    public function index()
    {
        $model = new ProductModel();
        $data['products'] = $model->findAll();
        $data['is_admin'] = (session()->get('role') === 'admin');
        return view('products/index', $data);
    }
    
    // CREATE - Show add product form
    public function create()
    {
        // Check if user is admin
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/products')->with('error', 'Only admin can add products.');
        }
        return view('products/create');
    }
    
    // CREATE - Save product to database
    public function store()
    {
        // Check if user is admin
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/products')->with('error', 'Only admin can add products.');
        }
        
        $model = new ProductModel();
        
        // Validation rules
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
        
        // Insert product
        $model->insert([
            'name' => $this->request->getPost('name'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'ingredients' => $ingredients,
            'category' => $this->request->getPost('category')
        ]);
        
        return redirect()->to('/products')->with('success', 'Product added successfully!');
    }
    
    // UPDATE - Show edit form
    public function edit($id)
    {
        // Check if user is admin
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/products')->with('error', 'Only admin can edit products.');
        }
        
        $model = new ProductModel();
        $data['product'] = $model->find($id);
        
        if (!$data['product']) {
            return redirect()->to('/products')->with('error', 'Product not found');
        }
        
        return view('products/edit', $data);
    }
    
    // UPDATE - Save changes to database
    public function update($id)
    {
        // Check if user is admin
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/products')->with('error', 'Only admin can update products.');
        }
        
        $model = new ProductModel();
        
        // Check if product exists
        $product = $model->find($id);
        if (!$product) {
            return redirect()->to('/products')->with('error', 'Product not found');
        }
        
        // Get ingredients
        $ingredients = $this->request->getPost('ingredients');
        if (empty($ingredients)) {
            $ingredients = 'No ingredients listed';
        }
        
        // Update product
        $model->update($id, [
            'name' => $this->request->getPost('name'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'ingredients' => $ingredients,
            'category' => $this->request->getPost('category')
        ]);
        
        return redirect()->to('/products')->with('success', 'Product updated successfully!');
    }
    
    // DELETE - Remove product from database
    public function delete($id)
    {
        // Check if user is admin
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/products')->with('error', 'Only admin can delete products.');
        }
        
        $model = new ProductModel();
        
        // Check if product exists
        $product = $model->find($id);
        if (!$product) {
            return redirect()->to('/products')->with('error', 'Product not found');
        }
        
        // Delete product
        $model->delete($id);
        
        return redirect()->to('/products')->with('success', 'Product "' . $product['name'] . '" deleted successfully!');
    }
}