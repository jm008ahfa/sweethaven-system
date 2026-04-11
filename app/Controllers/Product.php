<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Product extends BaseController
{
    public function index()
    {
        $model = new ProductModel();
        $data['products'] = $model->findAll();
        return view('products/index', $data);
    }
    
    public function create()
    {
        return view('products/create');
    }
    
    public function store()
    {
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
    
    public function edit($id)
    {
        $model = new ProductModel();
        $data['product'] = $model->find($id);
        return view('products/edit', $data);
    }
    
    public function update($id)
    {
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
    
    public function delete($id)
    {
        $model = new ProductModel();
        $model->delete($id);
        return redirect()->to('/products')->with('success', 'Product deleted successfully!');
    }
}