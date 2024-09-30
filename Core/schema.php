<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;

$productType = new ObjectType([
  'name' => 'Product',
  'fields' => [
    'id' => Type::id(),
    'title' => Type::string(),
    'company' => Type::string(),
    'description' => Type::string(),
    'featured' => Type::boolean(),
    'category' => Type::string(),
    'image' => Type::string(),
    'price' => Type::float(),
    'shipping' => Type::boolean(),
    'colors' => Type::listOf(Type::string()),
  ],
]);

$queryType = new ObjectType([
  'name' => 'Query',
  'fields' => [
    // Existing products query
    'products' => [
      'type' => new ObjectType([
        'name' => 'ProductsResult',
        'fields' => [
          'items' => Type::listOf($productType),
          'total' => Type::int(),
          'page' => Type::int(),
          'pageSize' => Type::int(),
          'pageCount' => Type::int(),
        ]
      ]),
      'args' => [
        'page' => Type::int(),
        'pageSize' => Type::int(),
        'category' => Type::string(),
        'company' => Type::string(),
        'minPrice' => Type::float(),
        'maxPrice' => Type::float(),
        'featured' => Type::boolean(),
      ],
      'resolve' => function ($root, $args, $context) {
        return $context['productsController']->getProducts($args);
      },
    ],
    // New query for a single product
    'product' => [
      'type' => $productType,
      'args' => [
        'id' => Type::nonNull(Type::id()),
      ],
      'resolve' => function ($root, $args, $context) {
        return $context['productsController']->getProductById($args['id']);
      },
    ],
    // New query for companies
    'companies' => [
      'type' => Type::listOf($companyType),
      'resolve' => function ($root, $args, $context) {
        return $context['companiesController']->getAllCompanies();
      },
    ],
    // New query for categories
    'categories' => [
      'type' => Type::listOf($categoryType),
      'resolve' => function ($root, $args, $context) {
        return $context['categoriesController']->getAllCategories();
      },
    ],
    // New query for featured products
    'featuredProducts' => [
      'type' => Type::listOf($productType),
      'args' => [
        'limit' => Type::int(),
      ],
      'resolve' => function ($root, $args, $context) {
        $limit = $args['limit'] ?? 5; // Default to 5 if not provided
        return $context['productsController']->getFeaturedProducts($limit);
      },
    ],
  ],
]);

$schema = new Schema([
  'query' => $queryType,
]);

return $schema;
