<?php 

require_once dirname(__DIR__) . '/vendor/autoload.php';


$containerBuilder = new \DI\ContainerBuilder();

// For using a smiple container
$containerBuilder->useAutowiring(false);
$containerBuilder->useAnnotations(false);

// For the use of the simple container, we have to define the injections ourselves
$containerBuilder->addDefinitions([
    \ModernPHP\HelloWorld::class => \DI\create(\ModernPHP\HelloWorld::class)
]);

$container = $containerBuilder->build();

$helloWorld = $container->get(\ModernPHP\HelloWorld::class);

$helloWorld->announce();

?>