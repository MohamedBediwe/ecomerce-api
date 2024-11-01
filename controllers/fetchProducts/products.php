<?php
// Include the necessary files
include(base_path("Core/cors.php"));

use Core\App;
use Core\Database;

// Resolve the Database instance
$db = App::resolve(Database::class);

// Pagination parameters
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$pageSize = isset($_GET['pageSize']) ? (int)$_GET['pageSize'] : 10;
$offset = ($page - 1) * $pageSize;


// Check for query parameters
$featured = isset($_GET['featured']) ? $_GET['featured'] === 'true' : null;
$category = isset($_GET['category']) ? $_GET['category'] : null;
$company = isset($_GET['company']) ? $_GET['company'] : null;
$maxPrice = isset($_GET['price']) ? (float)$_GET['price'] : null;
$shipping = isset($_GET['shipping']) ? $_GET['shipping'] === 'true' : null;
$search = isset($_GET['search']) ? $_GET['search'] : null;
$order = isset($_GET['order']) ? $_GET['order'] : 'asc'; // Default to 'asc'
// Start building the query
$query = "SELECT * FROM products WHERE 1=1";
$params = [];

// Add conditions based on parameters
if ($featured !== null) {
  $query .= ' AND featured = ?';
  $params[] = $featured ? 1 : 0;
}
if ($category and $category != "all") {
  $query .= ' AND category = ?';
  $params[] = $category;
}
if ($company and $company != "all") {
  $query .= ' AND company = ?';
  $params[] = $company;
}
if ($maxPrice and $maxPrice != (float)1000) {
  $query .= ' AND price <= ?';
  $params[] = $maxPrice;
}
if ($shipping !== null) {
  $query .= ' AND shipping = ?';
  $params[] = $shipping ? 1 : 0;
}
if ($search and $search != "") {
  $query .= ' AND title LIKE ?';
  $params[] = "%$search%";
}

// Add ordering
switch ($order) {
  case 'a-z':
    $query .= ' ORDER BY title ASC';
    break;
  case 'z-a':
    $query .= ' ORDER BY title DESC';
    break;
  case 'low':
    $query .= ' ORDER BY price ASC';
    break;
  case 'high':
    $query .= ' ORDER BY price DESC';
    break;
}

// Add pagination
$query .= " LIMIT $pageSize OFFSET $offset";

// Execute the query to get products
$products = $db->query($query, $params)->getAll();

// Fetch total number of products for pagination
$totalQuery = "SELECT COUNT(*) as total FROM products WHERE 1=1";
$totalParams = [];

// Add conditions for total count query
if ($featured !== null) {
  $totalQuery .= ' AND featured = ?';
  $totalParams[] = $featured ? 1 : 0;
}
if ($category and $category != "all") {
  $totalQuery .= ' AND category = ?';
  $totalParams[] = $category;
}
if ($company and $company != "all") {
  $totalQuery .= ' AND company = ?';
  $totalParams[] = $company;
}
if ($maxPrice and $maxPrice != (float)1000) {
  $totalQuery .= ' AND price <= ?';
  $totalParams[] = $maxPrice;
}
if ($shipping !== null) {
  $totalQuery .= ' AND shipping = ?';
  $totalParams[] = $shipping ? 1 : 0;
}
if ($search) {
  $totalQuery .= ' AND title LIKE ?';
  $totalParams[] = "%$search%";
}

// Fetch total count
$totalResult = $db->query($totalQuery, $totalParams)->find();
$total = $totalResult['total'];

// Fetch distinct categories and companies
$categories = $db->query("SELECT DISTINCT category FROM products")->getAll();
$companies = $db->query("SELECT DISTINCT company FROM products")->getAll();

// Prepare the response
$response = [
  "data" => $products,
  "meta" => [
    "pagination" => [
      "page" => $page,
      "pageSize" => $pageSize,
      "pageCount" => ceil($total / $pageSize),
      "total" => $total
    ],
    "categories" => array_merge(["all"], array_column($categories, 'category')),
    "companies" => array_merge(["all"], array_column($companies, 'company'))
  ]
];

// Return the response as JSON
echo json_encode($response);

die();
