<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Product extends BaseController
{
    // READ - Both Admin and Staff can view
    public function index()
    {
        $model = new ProductModel();
        $data['products'] = $model->findAll();
        $data['is_admin'] = (session()->get('role') === 'admin');
        return view('products/index', $data);
    }
    
    // CREATE - Only Admin
    public function create()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/products')->with('error', 'Only administrators can add products.');
        }
        return view('products/create');
    }
    
    // STORE - Only Admin
    public function store()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/products')->with('error', 'Only administrators can add products.');
        }
        
        $model = new ProductModel();
        
        $model->insert([
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'category' => $this->request->getPost('category')
        ]);
        
        return redirect()->to('/products')->with('success', 'Product added successfully!');
    }
    
    // EDIT - Only Admin
    public function edit($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/products')->with('error', 'Only administrators can edit products.');
        }
        
        $model = new ProductModel();
        $data['product'] = $model->find($id);
        return view('products/edit', $data);
    }
    
    // UPDATE - Only Admin
    public function update($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/products')->with('error', 'Only administrators can update products.');
        }
        
        $model = new ProductModel();
        
        $model->update($id, [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'category' => $this->request->getPost('category')
        ]);
        
        return redirect()->to('/products')->with('success', 'Product updated successfully!');
    }
    
    // DELETE - Only Admin
    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/products')->with('error', 'Only administrators can delete products.');
        }
        
        $model = new ProductModel();
        $model->delete($id);
        return redirect()->to('/products')->with('success', 'Product deleted successfully!');
    }
}