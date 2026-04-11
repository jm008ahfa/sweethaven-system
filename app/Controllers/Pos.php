<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Pos extends BaseController
{
    public function index()
    {
        // Check if logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        $productModel = new ProductModel();
        $data['products'] = $productModel->findAll();
        
        // Get cart from session
        $data['cart'] = session()->get('cart') ?? [];
        
        // Calculate totals
        $data['subtotal'] = 0;
        foreach ($data['cart'] as $item) {
            $data['subtotal'] += $item['price'] * $item['quantity'];
        }
        
        return view('pos/index', $data);
    }
    
    // Add item to cart
    public function addToCart()
    {
        $product_id = $this->request->getPost('product_id');
        $quantity = $this->request->getPost('quantity') ?: 1;
        
        $productModel = new ProductModel();
        $product = $productModel->find($product_id);
        
        if ($product) {
            $cart = session()->get('cart') ?? [];
            
            if (isset($cart[$product_id])) {
                // Update quantity if already in cart
                $cart[$product_id]['quantity'] += $quantity;
            } else {
                // Add new item to cart
                $cart[$product_id] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => $quantity
                ];
            }
            
            session()->set('cart', $cart);
            return redirect()->to('/pos')->with('success', $product['name'] . ' added to cart!');
        }
        
        return redirect()->to('/pos')->with('error', 'Product not found');
    }
    
    // Update cart item quantity
    public function updateCart()
    {
        $product_id = $this->request->getPost('product_id');
        $quantity = $this->request->getPost('quantity');
        
        $cart = session()->get('cart') ?? [];
        
        if ($quantity <= 0) {
            unset($cart[$product_id]);
        } else {
            $cart[$product_id]['quantity'] = $quantity;
        }
        
        session()->set('cart', $cart);
        return redirect()->to('/pos')->with('success', 'Cart updated');
    }
    
    // Remove item from cart
    public function removeFromCart($product_id)
    {
        $cart = session()->get('cart') ?? [];
        unset($cart[$product_id]);
        session()->set('cart', $cart);
        
        return redirect()->to('/pos')->with('success', 'Item removed from cart');
    }
    
    // Clear entire cart
    public function clearCart()
    {
        session()->remove('cart');
        return redirect()->to('/pos')->with('success', 'Cart cleared');
    }
    
    // Checkout - calculate total and payment
    public function checkout()
    {
        $cart = session()->get('cart') ?? [];
        
        if (empty($cart)) {
            return redirect()->to('/pos')->with('error', 'Cart is empty');
        }
        
        // Calculate total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        $payment = $this->request->getPost('payment');
        $change = $payment - $total;
        
        // Here you can save to database if needed
        // For now, just show receipt
        
        session()->setFlashdata('receipt', [
            'cart' => $cart,
            'total' => $total,
            'payment' => $payment,
            'change' => $change,
            'date' => date('Y-m-d H:i:s'),
            'staff' => session()->get('name')
        ]);
        
        // Clear cart after checkout
        session()->remove('cart');
        
        return redirect()->to('/pos/receipt');
    }
    
    // Show receipt
    public function receipt()
    {
        $receipt = session()->getFlashdata('receipt');
        
        if (!$receipt) {
            return redirect()->to('/pos');
        }
        
        return view('pos/receipt', ['receipt' => $receipt]);
    }
}