<?php
class Router {
    private $routes = [];
    private $params = [];
    public function add($route, $params = []) {
        $route = preg_replace('/\//', '\\/', $route);
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
        $route = '/^' . $route . '$/i';
        $this->routes[$route] = $params;
    }
    public function match($url) {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }
    public function dispatch($url) {
        $url = $this->removeQueryStringVariables($url);
        if ($this->match($url)) {
            $controller = $this->params['controller'] ?? null;
            $action = $this->params['action'] ?? 'index';
            if ($controller) {
                $controller = $this->convertToStudlyCaps($controller);
                $controller = $this->getNamespace() . $controller;
                if (class_exists($controller)) {
                    $controller_object = new $controller($this->params);
                    $action = $this->convertToCamelCase($action);
                    if (is_callable([$controller_object, $action])) {
                        $controller_object->$action();
                    } else {
                        throw new \Exception("Method $action not found in controller $controller");
                    }
                } else {
                    throw new \Exception("Controller class $controller not found");
                }
            } elseif (isset($this->params['view'])) {
                $this->renderView($this->params['view'], $this->params);
            } else {
                throw new \Exception("No controller or view specified for route");
            }
        } else {
            $this->renderView('404');
        }
    }
    protected function renderView($view, $data = []) {
        extract($data);
        $viewFile = VIEWS . '/' . $view . '.php';
        if (file_exists($viewFile)) {
            ob_start();
            require $viewFile;
            $content = ob_get_clean();
            if (!isset($data['layout']) || $data['layout'] !== false) {
                $layout = $data['layout'] ?? 'layouts/main';
                $layoutFile = VIEWS . '/' . $layout . '.php';
                if (file_exists($layoutFile)) {
                    require $layoutFile;
                } else {
                    echo $content;
                }
            } else {
                echo $content;
            }
        } else {
            throw new \Exception("View $view not found");
        }
    }
    protected function convertToStudlyCaps($string) {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }
    protected function convertToCamelCase($string) {
        return lcfirst($this->convertToStudlyCaps($string));
    }
    protected function removeQueryStringVariables($url) {
        if ($url != '') {
            $parts = explode('&', $url, 2);
            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }
        return $url;
    }
    protected function getNamespace() {
        $namespace = '';
        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }
        return $namespace;
    }
}
?>