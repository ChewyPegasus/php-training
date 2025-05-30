<?php

namespace ContainerH7Lb0U1;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getListControllereditService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.jDCAKJb.App\Controller\ListController::edit()' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.jDCAKJb.App\\Controller\\ListController::edit()'] = (new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService ??= $container->getService(...), [
            'book' => ['privates', '.errored..service_locator.jDCAKJb.App\\Entity\\Book', NULL, 'Cannot autowire service ".service_locator.jDCAKJb": it needs an instance of "App\\Entity\\Book" but this type has been excluded in "config/services.yaml".'],
            'manager' => ['services', 'doctrine.orm.default_entity_manager', 'getDoctrine_Orm_DefaultEntityManagerService', false],
            'slugger' => ['privates', 'slugger', 'getSluggerService', true],
            'dir' => ['privates', '.value.CLnUN3U', 'get_Value_CLnUN3UService', true],
        ], [
            'book' => 'App\\Entity\\Book',
            'manager' => '?',
            'slugger' => '?',
            'dir' => '?',
        ]))->withContext('App\\Controller\\ListController::edit()', $container);
    }
}
