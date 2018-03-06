<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

/**
 * get alll equipments
 * @return {Object} all equipments
 */
$app->get('/equipment/list', function(Request $request, Response $response, array  $args) {
//        return $response->withStatus(200)->write('Hello');
        $statement = $this->db->prepare("SELECT * FROM equipment ORDER BY category");
        $statement->execute();
        $equipments = $statement->fetchAll();
        return $this->response->withJson($equipments);
});

/**
 * get a single equipment by its equioment ID
 * @params {Int} id the equipment ID
 * @return {Object} the equipment
 */
$app->get('/equipment/list/{id}', function(Request $request, Response $response, array $args) {
            $id = $args['id'];
            $statement = $this->db->prepare("SELECT * FROM equipment WHERE equipmentID=".$id);
            $statement->execute();
            $equipment = $statement->fetchObject();
            return $this->response->withJson($equipment);
});
