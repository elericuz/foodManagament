<?php
namespace Controller;
use Doctrine\DBAL\Connection;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;

class MainController
{
    private $container;
    private $logger;
    private $connection;

    public function __construct(Connection $connection, LoggerInterface $logger, ContainerInterface $container)
    {
        $this->container = $container;
        $this->logger = $logger;
        $this->connection = $connection;
    }

    public function home(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        $this->logger->warning("hola");

        return $view->render($response, 'dashboard.phtml');
    }
}
