<?php
// Include the necessary files
include(base_path("Core/cors.php"));

use Core\App;
use Core\Database;

// Resolve the Database instance
$db = App::resolve(Database::class);

// Get the product ID from the matched parameters
$id = isset($_GET['params'][0]) ? (int)$_GET['params'][0] : null;

if ($id) {
  // Fetch product by ID
  $query = 'SELECT * FROM products WHERE id = :id';
  $product = $db->query($query, ['id' => $id])->find();
  if (isset($product['colors']) && is_string($product['colors'])) {
    $product['colors'] = json_decode($product['colors'], true);
  }
  // Return the product as JSON
  echo json_encode($product);
  die();
}

// If no ID is provided, return an error
echo json_encode(['message' => 'Product not found']);
die();
