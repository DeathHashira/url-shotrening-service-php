<?php

namespace App\Http;

class Response
{
    private int $statusCode;
    private array $headers;
    private string $content;
    public function __construct() {
        $this->statusCode = 200;
        $this->headers = [];
        $this->content = '';
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getContent(): ?array
    {
        return json_decode($this->content, true);
    }

    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function setContent(array $content): self
    {
        $this->content = json_encode($content);
        return $this;
    }

    public function setHeader(string $name, string $value): self
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function send(): void
    {
        http_response_code($this->statusCode);

        foreach($this->headers as $name => $value) {
            header("$name: $value");
        }

        echo $this->content;
    }
}