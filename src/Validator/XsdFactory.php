<?php

namespace Olcs\XmlTools\Validator;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class XsdFactory
 * @package Olcs\XmlTools\Validator
 */
class XsdFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->getServiceLocator()->get('Config');

        $validator = new Xsd();

        if (isset($config['xsd_mappings'])) {
            $validator->setMappings($config['xsd_mappings']);
        }

        return $validator;
    }
}
