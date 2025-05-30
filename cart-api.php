<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'] ?? '';
    $quantity = (int)($_POST['quantity'] ?? 1);
    $action = $_POST['action'] ?? '';
    
    switch($action) {
        case 'add':
            if ($product_id) {
                if (isset($_SESSION['cart'][$product_id])) {
                    $_SESSION['cart'][$product_id] += $quantity;
                } else {
                    $_SESSION['cart'][$product_id] = $quantity;
                }
                echo json_encode([
                    'success' => true,
                    'message' => 'Produk berhasil ditambahkan ke keranjang',
                    'cart' => $_SESSION['cart']
                ]);
            }
            break;
            
        case 'update':
            if ($product_id && isset($_SESSION['cart'][$product_id])) {
                if ($quantity > 0) {
                    $_SESSION['cart'][$product_id] = $quantity;
                }
                echo json_encode([
                    'success' => true,
                    'message' => 'Keranjang berhasil diupdate',
                    'cart' => $_SESSION['cart']
                ]);
            }
            break;
            
        case 'remove':
            if ($product_id && isset($_SESSION['cart'][$product_id])) {
                unset($_SESSION['cart'][$product_id]);
                echo json_encode([
                    'success' => true,
                    'message' => 'Produk berhasil dihapus dari keranjang',
                    'cart' => $_SESSION['cart']
                ]);
            }
            break;
            
        default:
            echo json_encode([
                'success' => false,
                'message' => 'Invalid action'
            ]);
    }
    exit;
} 