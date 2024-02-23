<?php

namespace ContainerULd2epz;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_Uga7QBbService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.uga7QBb' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.uga7QBb'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService ??= $container->getService(...), [
            'entityManager' => ['services', 'doctrine.orm.default_entity_manager', 'getDoctrine_Orm_DefaultEntityManagerService', false],
            'serializer' => ['privates', 'debug.serializer', 'getDebug_SerializerService', false],
            'workflows' => ['privates', 'workflow.registry', 'getWorkflow_RegistryService', false],
        ], [
            'entityManager' => '?',
            'serializer' => '?',
            'workflows' => '?',
        ]);
    }
}
