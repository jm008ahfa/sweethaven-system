<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Pos extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        $productModel = new ProductModel();
        // Get unique products only
        $data['products'] = $productModel->distinct()->orderBy('name', 'ASC')->findAll();
        
        // Get cart from session
        $cart = session()->get('cart') ?? [];
        
        // Clean cart - remove any items with quantity 0
        foreach ($cart as $key => $item) {
            if ($item['quantity'] <= 0) {
                unset($cart[$key]);
            }
        }
        session()->set('cart', $cart);
        
        $data['cart'] = $cart;
        
        // Calculate subtotal
        $data['subtotal'] = 0;
        foreach ($cart as $item) {
            $data['subtotal'] += $item['price'] * $item['quantity'];
        }
        
        return view('pos/index', $data);
    }
    
    public function addToCart()
    {
        $product_id = $this->request->getPost('product_id');
        $quantity = $this->request->getPost('quantity') ?: 1;
        
        $productModel = new ProductModel();
        $product = $productModel->find($product_id);
        
        if ($product) {
            $cart = session()->get('cart') ?? [];
            
            // Check if product already in cart
            if (isset($cart[$product_id])) {
                // Update quantity
                $newQty = $cart[$product_id]['quantity'] + $quantity;
                if ($newQty > $product['stock']) {
                    return redirect()->to('/pos')->with('error', 'Not enough stock for ' . $product['name']);
                }
                $cart[$product_id]['quantity'] = $newQty;
            } else {
                // Add new product
                if ($quantity > $product['stock']) {
                    return redirect()->to('/pos')->with('error', 'Not enough stock for ' . $product['name']);
                }
                $cart[$product_id] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => $quantity
                ];
            }
            
            session()->set('cart', $cart);
            return redirect()->to('/pos')->with('success', $product['name'] . ' added!');
        }
        
        return redirect()->to('/pos')->with('error', 'Product not found');
    }
    
    public function updateCart()
    {
        $product_id = $this->request->getPost('product_id');
        $quantity = $this->request->getPost('quantity');
        
        $productModel = new ProductModel();
        $product = $productModel->find($product_id);
        $cart = session()->get('cart') ?? [];
        
        if ($quantity <= 0) {
            unset($cart[$product_id]);
        } else {
            if ($product && $quantity > $product['stock']) {
                return redirect()->to('/pos')->with('error', 'Only ' . $product['stock'] . ' available for ' . $product['name']);
            }
            $cart[$product_id]['quantity'] = $quantity;
        }
        
        session()->set('cart', $cart);
        return redirect()->to('/pos')->with('success', 'Cart updated');
    }
    
    public function removeFromCart($product_id)
    {
        $cart = session()->get('cart') ?? [];
        unset($cart[$product_id]);
        session()->set('cart', $cart);
        return redirect()->to('/pos')->with('success', 'Item removed');
    }
    
    public function clearCart()
    {
        session()->remove('cart');
        return redirect()->to('/pos')->with('success', 'Cart cleared');
    }
    
    public function checkout()
    {
        $cart = session()->get('cart') ?? [];
        
        if (empty($cart)) {
            return redirect()->to('/pos')->with('error', 'Cart is empty');
        }
        
        $productModel = new ProductModel();
        
        // Calculate total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        $payment = $this->request->getPost('payment');
        
        if ($payment < $total) {
            return redirect()->to('/pos')->with('error', 'Insufficient payment');
        }
        
        $change = $payment - $total;
        
        // Subtract stock for each product
        foreach ($cart as $item) {
            $product = $productModel->find($item['id']);
            if ($product) {
                $newStock = $product['stock'] - $item['quantity'];
                $productModel->update($item['id'], ['stock' => $newStock]);
            }
        }
        
        $receipt = [
            'cart' => $cart,
            'total' => $total,
            'payment' => $payment,
            'change' => $change,
            'date' => date('Y-m-d H:i:s'),
            'staff' => session()->get('name')
        ];
        
        session()->remove('cart');
        session()->setFlashdata('receipt', $receipt);
        
        return redirect()->to('/pos/receipt')->with('success', 'Sale completed!');
    }
    
    public function receipt()
    {
        $receipt = session()->getFlashdata('receipt');
        
        if (!$receipt) {
            return redirect()->to('/pos');
        }
        
        return view('pos/receipt', ['receipt' => $receipt]);
    }
}