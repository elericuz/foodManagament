<?php
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Doctrine\DBAL\Connection;

return function (ContainerBuilder $containerBuilder) {

    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        Connection::class => function(ContainerInterface $c) {
            $config = new \Doctrine\DBAL\Configuration();
            $settings = $c->get(SettingsInterface::class);

            $doctrineSettings = $settings->get('doctrine');
            return \Doctrine\DBAL\DriverManager::getConnection($doctrineSettings, $config);
        }
    ]);


//$container['logger'] = function ($c) {
//    $settings = $c->get('settings')['logger'];
//    $logger = new Monolog\Logger($settings['name']);
//    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
//    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
//    return $logger;
//};


//    [
//        Connection::class => function(ContainerInterface $c) {
//            $settings = $c->get(SettingsInterface::class);
//            $configuration = $c->get(('settings')['db']);
////            println($configuration);
////            die();
//            $config = new \Doctrine\ORM\Configuration();
//            return \Doctrine\DBAL\DriverManager::getConnection($configuration, $config);
//        },
//        PDO::class => function (ContainerInterface $c) {
//            return $c->get(\Doctrine\DBAL\Connection::class)->getWrappedConnection();
//        }
//    ]);
};


//$container['em'] = function ($c) {
//    $isDevMode = true;
//
//    $paths = array(__DIR__."/App/Domain/Entity/");
//    $isSimpleMode = false;
//    $proxyDir = __DIR__."/data/DoctrineORMModule/Proxy";
//    $cache = null;
//    $config = Setup::createAnnotationMetadataConfiguration(
//        $paths, $isDevMode, $proxyDir, $cache, $isSimpleMode
//    );
//
//    $conn = array(
//        'driver' => 'pdo_mysql',
//        'host' => 'mysql',
//        'port' => 3306,
//        'dbname' => 'asteria',
//        'user' => 'root',
//        'password' => 'password',
//    );
//
//    $entityManager = EntityManager::create($conn, $config);
//    return $entityManager;
//};