<?php 


use DI\ContainerBuilder;
use ModernPHP\HelloWorld;
use function DI\create;

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

$helloWorld = $container->get(HelloWorld::class);

$helloWorld->announce();

?>