<?php
namespace Core;
class Route {
    public string $method;
    public string $uri;
    public $action;
    public array $middleware = [];
    public ?string $name = null;
    public function __construct(string $method, string $uri, $action) {
        $this->method = $method;
        $this->uri = $uri;
        $this->action = $action;
    }
    public function middleware($mw): static {
        $this->middleware = is_array($mw) ? $mw : [$mw];
        return $this;
    }
    public function name(string $name): static {
        $this->name = $name;
        return $this;
    }
    public function getAction() {
        return $this->action;
    }
    public function getMethod() {
        return $this->method;
    }
    public function getUri() {
        return $this->uri;
    }
    public function getMiddleware() {
        return $this->middleware;
    }
}
