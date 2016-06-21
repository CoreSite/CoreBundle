<?php
/**
 * Project CoreSite.
 * @author: Dmitriy Shuba <sda@sda.in.ua>
 * @link: http://maxi-soft.net/ Maxi-Soft
 */

namespace CoreSite\CoreBundle\Service;


use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

abstract class CoreService
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var \Symfony\Component\HttpKernel\KernelInterface
     */
    private $kernel;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;

    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    /**
     * @var AuthorizationChecker
     */
    private $authorizationChecker;

    /**
     * @var Router
     */
    private $router;

    public function __construct(Container $container)
    {
        $this->container = $container;

        $this->kernel = $this->container->get('kernel');
        $this->entityManager = $this->container->get('doctrine.orm.entity_manager');
        $this->eventDispatcher = $this->container->get('event_dispatcher');
        $this->tokenStorage = $this->container->get('security.token_storage');
        $this->authorizationChecker = $this->container->get('security.authorization_checker');
        $this->router = $this->container->get('router');
    }

    /**
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @return EventDispatcher
     */
    protected function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }

    /**
     * @return TokenStorage
     */
    protected function getTokenStorage()
    {
        return $this->tokenStorage;
    }

    /**
     * @return AuthorizationChecker
     */
    protected function getAuthorizationChecker()
    {
        return $this->authorizationChecker;
    }

    protected function getParameter($name)
    {
        return $this->container->getParameter($name);
    }

    /**
     * @return \Symfony\Component\HttpKernel\KernelInterface
     */
    protected function getKernel()
    {
        return $this->kernel;
    }

    /**
     * @return Router
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * @param Router $router
     */
    public function setRouter($router)
    {
        $this->router = $router;
    }


}