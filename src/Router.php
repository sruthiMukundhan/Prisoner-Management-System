<?php

class Router {

    protected $routes = [];
    protected $auth;

    public function __construct() {
        global $auth;
        $this->auth = $auth;
    }

    /* =======================
       REGISTER ROUTES
    ======================= */

    public function add($method, $uri, $controller, $options = []) {
        $this->routes[] = [
            'uri'           => trim($uri),
            'controller'    => $controller,
            'method'        => strtoupper($method),
            'requires_auth' => $options['requires_auth'] ?? false,
            'required_role' => $options['required_role'] ?? null,
        ];
    }

    public function get($uri, $controller, $options = []) {
        $this->add('GET', $uri, $controller, $options);
        return $this;
    }

    public function post($uri, $controller, $options = []) {
        $this->add('POST', $uri, $controller, $options);
        return $this;
    }

    public function auth($required_role = null) {
        $last = count($this->routes) - 1;
        $this->routes[$last]['requires_auth'] = true;
        $this->routes[$last]['required_role'] = $required_role;
        return $this;
    }

    /* =======================
       DISPATCH REQUEST
    ======================= */

    public function dispatch() {

        $page   = $_GET['page'] ?? 'home';
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {

            if ($route['uri'] === $page && $route['method'] === $method) {

                /* 🔐 AUTH CHECK */
                if ($route['requires_auth']) {

                    // Check if user logged in with required role
                    if (
                        !$this->auth ||
                        !$this->auth->isLoggedIn($route['required_role'])
                    ) {
                        redirect('signin-' . $route['required_role']);
                        exit;
                    }
                }

                require SRC_PATH . '/' . $route['controller'];
                return;
            }
        }

        /* ❌ 404 */
        require SRC_PATH . '/views/components/error.php';
    }
}