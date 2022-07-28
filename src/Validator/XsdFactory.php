<?php

namespace Olcs\XmlTools\Validator;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

/**
 * Class XsdFactory
 * @package Olcs\XmlTools\Validator
 */
class XsdFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): Xsd
    {
        $config = $container->getServiceLocator()->get('Config');

        $validator = new Xsd();

        if (isset($config['xsd_mappings'])) {
            $validator->setMappings($config['xsd_mappings']);
        }

        return $validator;
    }

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     * @deprecated No longer needed in Laminas 3
     */
    public function createService(ServiceLocatorInterface $serviceLocator): Xsd
    {
        return $this($serviceLocator, Xsd::class);
    }
}
