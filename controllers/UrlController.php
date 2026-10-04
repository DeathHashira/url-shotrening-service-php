<?php

namespace Controllers;

use App\Http\Request;
use App\Http\Response;
use Services\ShortningService;

class UrlController
{
    public function __construct(
        private Request $request,
        private ShortningService $shortService
    ) {}

    public function createNewLink(): Response
    {
        [$url] = $this->getValues(["url"]);
        $result = $this->shortService->createNewShort($url);

        if ($result["success"]) {
            return (new Response())
            ->setStatusCode(201);
        } else {
            return (new Response())
            ->setStatusCode(400);
        }
    }

    public function getUrl(string $shortCode): Response
    {
        $result = $this->shortService->getUrl($shortCode);

        if ($result["success"]) {
            return (new Response())
            ->setStatusCode(200)
            ->setContent($result["content"]);
        } else {
            return (new Response())
            ->setStatusCode(404);
        }
    }

    public function updateShort(string $shortCode): Response
    {
        [$newUrl] = $this->getValues(["url"]);
        $result = $this->shortService->updateLink($newUrl, $shortCode);

        if ($result["success"]) {
            return (new Response())
            ->setStatusCode(200);
        } else if ($result["error"] === "not found") {
            return (new Response())
            ->setStatusCode(404);
        } else {
            return (new Response())
            ->setStatusCode(400);
        }
    }

    public function deleteShort(string $shortCode): Response
    {
        $result = $this->shortService->deleteLink($shortCode);

        if ($result["success"]) {
            return (new Response())
            ->setStatusCode(204);
        } else {
            return (new Response())
            ->setStatusCode(404);
        }
    }

    public function getStats(string $shortCode): Response
    {
        $result = $this->shortService->getStatics($shortCode);

        if ($result["success"]) {
            return (new Response())
            ->setStatusCode(200)
            ->setContent($result["content"]);
        } else {
            return (new Response())
            ->setStatusCode(404);
        }
    }

    private function getValues(array $keys)
    {
        $params = $this->request->getData();
        $result = [];

        foreach ($keys as $key) {
            $result[] = $params[$key];
        }

        return $result;
    }
}
