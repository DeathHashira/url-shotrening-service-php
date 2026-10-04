<?php

use App\Http\Request;
use Controllers\UrlController;
use Dotenv\Dotenv;
use Models\DataBase;
use Models\Urls;
use Services\ShortningService;
use Src\Router;

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once __DIR__ . "/../vendor/autoload.php";

$dotenv = Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

$conn = DataBase::createFromEnv()->getConnection();

$request = Request::createFromGlobal();

$urlController = new UrlController(
    $request,
    new ShortningService(new Urls($conn))
);

Router::post("/shorten", [$urlController, "createNewLink"]);

Router::get("/shorten/{shortCode}", [$urlController, "getUrl"], "/^/shorten/([^/]+)$/");

Router::patch("/shorten/{shortCode}", [$urlController, "updateShort"], "/^/shorten/([^/]+)$/");

Router::delete("/shorten/{shortCode}", [$urlController, "deleteShort"], "/^/shorten/([^/]+)$/");

Router::get("/shorten/{shortCode}/stats", [$urlController, "getStats"], "/^/shorten/([^/]+)/stats$/");

Router::resolve();