<?php

namespace App\Http;

class Request
{
    private string $method;
    private string $path;
    public function __construct(
        private array $body,
        private array $params,
        private array $server,
    ) {
        $this->method = strtolower($server["REQUEST_METHOD"]);
        $this->path = parse_url($server["REQUEST_URI"])["path"];
    }

    public static function createFromGlobal(): self
    {
        return new self($_POST, $_GET, $_SERVER);
    }

    public function getData(): array
    {
        if ($this->method === "get") {
            return $this->params;
        } else if ($this->method === "post") {
            return $this->body;
        } else {
            return json_decode(
            file_get_contents('php://input'),
            true
            );
        }
    }
}