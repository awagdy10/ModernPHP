<?php 


use DI\ContainerBuilder;
use ModernPHP\HelloWorld;
use FastRoute\RouteCollector;
use Middlewares\FastRoute;
use Middlewares\RequestHandler;
use Relay\Relay;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use function DI\create;
use function DI\get;
use function FastRoute\simpleDispatcher;

require_once dirname(__DIR__) . '/vendor/autoload.php';


$containerBuilder = new ContainerBuilder();

// For using a smiple container
$containerBuilder->useAutowiring(false);
$containerBuilder->useAnnotations(false);

// For the use of the simple container, we have to define the injections ourselves
$containerBuilder->addDefinitions([
    HelloWorld::class => create(HelloWorld::class)
]);

$container = $containerBuilder->build();

$routes = simpleDispatcher(function (RouteCollector $r) {
    $r->get('/hello', HelloWorld::class);
});

$middlewareQueue = [];

$middlewareQueue[] = new FastRoute($routes);
$middlewareQueue[] = new RequestHandler($container);

$requestHandler = new Relay($middlewareQueue);
$response = $requestHandler->handle(ServerRequestFactory::fromGlobals());



?>