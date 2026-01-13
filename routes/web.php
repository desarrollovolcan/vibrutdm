<?php

use App\Controllers\AuthController;
use App\Controllers\BracketController;
use App\Controllers\CategoryController;
use App\Controllers\DashboardController;
use App\Controllers\GroupController;
use App\Controllers\MatchController;
use App\Controllers\PlayerController;
use App\Controllers\QualificationController;
use App\Controllers\RegistrationController;
use App\Controllers\ResultController;
use App\Controllers\TournamentController;
use App\Core\Router;

$router = new Router();

$router->get('/', [AuthController::class, 'loginForm']);
$router->get('/login', [AuthController::class, 'loginForm']);
$router->post('/login', [AuthController::class, 'loginPost']);
$router->get('/logout', [AuthController::class, 'logout']);

$router->get('/dashboard', [DashboardController::class, 'index']);
$router->get('/dashboard/index', [DashboardController::class, 'index']);

$router->get('/tournaments', [TournamentController::class, 'index']);
$router->get('/tournaments/index', [TournamentController::class, 'index']);
$router->get('/tournaments/create', [TournamentController::class, 'create']);
$router->post('/tournaments', [TournamentController::class, 'store']);

$router->get('/categories', [CategoryController::class, 'index']);
$router->get('/categories/index', [CategoryController::class, 'index']);
$router->get('/categories/create', [CategoryController::class, 'create']);
$router->post('/categories', [CategoryController::class, 'store']);

$router->get('/players', [PlayerController::class, 'index']);
$router->get('/players/index', [PlayerController::class, 'index']);
$router->post('/players', [PlayerController::class, 'store']);

$router->get('/registrations', [RegistrationController::class, 'index']);
$router->get('/registrations/index', [RegistrationController::class, 'index']);
$router->post('/registrations', [RegistrationController::class, 'store']);
$router->post('/registrations/delete', [RegistrationController::class, 'delete']);

$router->get('/groups', [GroupController::class, 'index']);
$router->get('/groups/index', [GroupController::class, 'index']);
$router->post('/groups/generate', [GroupController::class, 'generate']);
$router->get('/groups/show', [GroupController::class, 'show']);
$router->post('/groups/recalculate', [GroupController::class, 'recalculate']);

$router->get('/matches', [MatchController::class, 'show']);
$router->get('/matches/show', [MatchController::class, 'show']);

$router->get('/results/edit', [ResultController::class, 'editMatch']);
$router->post('/results/update', [ResultController::class, 'updateMatch']);

$router->post('/qualifications/generate', [QualificationController::class, 'generate']);

$router->get('/brackets', [BracketController::class, 'show']);
$router->get('/brackets/show', [BracketController::class, 'show']);

return $router;
