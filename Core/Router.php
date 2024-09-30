<?php

namespace Core;

class Router
{
  protected $routes = [];

  public function add($method, $uri, $controller)
  {
    // Convert dynamic route segments (e.g., {id}) into regex patterns
    $uri = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([a-zA-Z0-9_]+)', $uri);

    $this->routes[] = [
      'uri' => $uri,
      'method' => $method,
      'controller' => $controller,
    ];
    return $this;
  }

  public function get($uri, $controller)
  {
    return $this->add('GET', $uri, $controller);
  }

  public function post($uri, $controller)
  {
    return $this->add('POST', $uri, $controller);
  }

  public function patch($uri, $controller)
  {
    return $this->add('PATCH', $uri, $controller);
  }

  public function delete($uri, $controller)
  {
    return $this->add('DELETE', $uri, $controller);
  }

  public function put($uri, $controller)
  {
    return $this->add('PUT', $uri, $controller);
  }

  public function route($uri, $method)
  {
    foreach ($this->routes as $route) {
      // Check if the request method matches
      if ($route['method'] == strtoupper($method)) {
        // Match the request URI against the registered route's URI pattern
        if (preg_match("#^" . $route['uri'] . "$#", $uri, $matches)) {
          // Remove the full match from $matches
          array_shift($matches);

          // Make the matched parameters available to the controller
          $_GET['params'] = $matches;

          // Include the appropriate controller file
          return require base_path("controllers/{$route['controller']}");
        }
      }
    }

    // If no match is found, trigger a 404
    abort();
  }
}
