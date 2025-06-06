<?php

namespace ContainerH7Lb0U1;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getListControllerdeleteService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.b5CEtmN.App\Controller\ListController::delete()' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.b5CEtmN.App\\Controller\\ListController::delete()'] = (new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService ??= $container->getService(...), [
            'book' => ['privates', '.errored..service_locator.b5CEtmN.App\\Entity\\Book', NULL, 'Cannot autowire service ".service_locator.b5CEtmN": it needs an instance of "App\\Entity\\Book" but this type has been excluded in "config/services.yaml".'],
            'manager' => ['services', 'doctrine.orm.default_entity_manager', 'getDoctrine_Orm_DefaultEntityManagerService', false],
        ], [
            'book' => 'App\\Entity\\Book',
            'manager' => '?',
        ]))->withContext('App\\Controller\\ListController::delete()', $container);
    }
}
