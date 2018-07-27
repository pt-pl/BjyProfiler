<?php
/**
 * Created by Inditel Meedia OÜ
 * User: Oliver Leisalu
 */

namespace BjyProfiler\Db\Adapter;


use BjyProfiler\Db\Profiler\Profiler;

class ProfilingAdapterFactory implements \Zend\ServiceManager\Factory\FactoryInterface
{
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\Factory\FactoryInterface::__invoke()
	 */
	public function __invoke(\Interop\Container\ContainerInterface $serviceLocator, $requestedName, array $options = null)
	{
        $config = $serviceLocator->get('Configuration');
        $dbParams = $config['db'];
        $adapter = new ProfilingAdapter($dbParams);

        $adapter->setProfiler(new Profiler);
        if (isset($dbParams['options']) && is_array($dbParams['options'])) {
            $options = $dbParams['options'];
        } else {
            $options = array();
        }
        $adapter->injectProfilingStatementPrototype($options);
        return $adapter;
    }
}