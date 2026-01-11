<?php

declare(strict_types=1);

use App\Core\Router;
use App\Core\Session;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\UsersController;
use App\Controllers\TournamentsController;
use App\Controllers\CategoriesController;
use App\Controllers\AssociationsController;
use App\Controllers\PlayersController;
use App\Controllers\RegistrationsController;
use App\Controllers\GroupsController;
use App\Controllers\MatchesController;
use App\Controllers\BracketsController;

require __DIR__ . '/../app/Core/Helpers.php';

$envPath = __DIR__ . '/../.env';
if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) {
            continue;
        }
        [$key, $value] = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value);
    }
}

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/../app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

Session::start();

$router = new Router();

$router->get('/login', [new AuthController(), 'showLogin']);
$router->post('/login', [new AuthController(), 'login']);
$router->get('/logout', [new AuthController(), 'logout']);

$router->get('/', function (): void {
    if (Session::user()) {
        (new DashboardController())->index();
        return;
    }
    (new AuthController())->showLogin();
});

$router->get('/users', [new UsersController(), 'index'], ['ADMIN']);
$router->get('/users/create', [new UsersController(), 'create'], ['ADMIN']);
$router->post('/users/store', [new UsersController(), 'store'], ['ADMIN']);
$router->get('/users/edit', [new UsersController(), 'edit'], ['ADMIN']);
$router->post('/users/update', [new UsersController(), 'update'], ['ADMIN']);
$router->post('/users/delete', [new UsersController(), 'delete'], ['ADMIN']);

$router->get('/tournaments', [new TournamentsController(), 'index'], ['ADMIN', 'OPERADOR']);
$router->get('/tournaments/create', [new TournamentsController(), 'create'], ['ADMIN', 'OPERADOR']);
$router->post('/tournaments/store', [new TournamentsController(), 'store'], ['ADMIN', 'OPERADOR']);
$router->get('/tournaments/edit', [new TournamentsController(), 'edit'], ['ADMIN', 'OPERADOR']);
$router->post('/tournaments/update', [new TournamentsController(), 'update'], ['ADMIN', 'OPERADOR']);
$router->post('/tournaments/delete', [new TournamentsController(), 'delete'], ['ADMIN']);

$router->get('/categories', [new CategoriesController(), 'index'], ['ADMIN', 'OPERADOR']);
$router->get('/categories/create', [new CategoriesController(), 'create'], ['ADMIN', 'OPERADOR']);
$router->post('/categories/store', [new CategoriesController(), 'store'], ['ADMIN', 'OPERADOR']);
$router->get('/categories/edit', [new CategoriesController(), 'edit'], ['ADMIN', 'OPERADOR']);
$router->post('/categories/update', [new CategoriesController(), 'update'], ['ADMIN', 'OPERADOR']);
$router->post('/categories/delete', [new CategoriesController(), 'delete'], ['ADMIN', 'OPERADOR']);

$router->get('/associations', [new AssociationsController(), 'index'], ['ADMIN', 'OPERADOR']);
$router->get('/associations/create', [new AssociationsController(), 'create'], ['ADMIN', 'OPERADOR']);
$router->post('/associations/store', [new AssociationsController(), 'store'], ['ADMIN', 'OPERADOR']);
$router->get('/associations/edit', [new AssociationsController(), 'edit'], ['ADMIN', 'OPERADOR']);
$router->post('/associations/update', [new AssociationsController(), 'update'], ['ADMIN', 'OPERADOR']);
$router->post('/associations/delete', [new AssociationsController(), 'delete'], ['ADMIN', 'OPERADOR']);

$router->get('/players', [new PlayersController(), 'index'], ['ADMIN', 'OPERADOR']);
$router->get('/players/create', [new PlayersController(), 'create'], ['ADMIN', 'OPERADOR']);
$router->post('/players/store', [new PlayersController(), 'store'], ['ADMIN', 'OPERADOR']);
$router->get('/players/edit', [new PlayersController(), 'edit'], ['ADMIN', 'OPERADOR']);
$router->post('/players/update', [new PlayersController(), 'update'], ['ADMIN', 'OPERADOR']);
$router->post('/players/delete', [new PlayersController(), 'delete'], ['ADMIN', 'OPERADOR']);

$router->get('/registrations', [new RegistrationsController(), 'index'], ['ADMIN', 'OPERADOR']);
$router->post('/registrations/store', [new RegistrationsController(), 'store'], ['ADMIN', 'OPERADOR']);
$router->post('/registrations/delete', [new RegistrationsController(), 'delete'], ['ADMIN', 'OPERADOR']);
$router->post('/registrations/import', [new RegistrationsController(), 'importCsv'], ['ADMIN', 'OPERADOR']);

$router->get('/groups', [new GroupsController(), 'index'], ['ADMIN', 'OPERADOR']);
$router->post('/groups/generate', [new GroupsController(), 'generate'], ['ADMIN', 'OPERADOR']);
$router->get('/groups/show', [new GroupsController(), 'show'], ['ADMIN', 'OPERADOR', 'LECTURA']);
$router->post('/groups/recalc', [new GroupsController(), 'recalc'], ['ADMIN', 'OPERADOR']);

$router->get('/matches/edit', [new MatchesController(), 'edit'], ['ADMIN', 'OPERADOR']);
$router->post('/matches/update', [new MatchesController(), 'update'], ['ADMIN', 'OPERADOR']);

$router->get('/brackets', [new BracketsController(), 'index'], ['ADMIN', 'OPERADOR', 'LECTURA']);
$router->get('/brackets/show', [new BracketsController(), 'show'], ['ADMIN', 'OPERADOR', 'LECTURA']);
$router->post('/brackets/generate', [new BracketsController(), 'generate'], ['ADMIN', 'OPERADOR']);

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
if (!Session::user() && !in_array($path, ['/', '/login'], true)) {
    redirect('/');
}

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
