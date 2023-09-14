<?php

namespace Olcs\XmlTools\Validator;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Class XsdFactory
 * @package Olcs\XmlTools\Validator
 */
class XsdFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): Xsd
    {
        $config = $container->get('Config');

        $validator = new Xsd();

        if (isset($config['xsd_mappings'])) {
            $validator->setMappings($config['xsd_mappings']);
        }

        return $validator;
    }
}
