<?php

namespace AgvValidator;

use Zend\Loader\AutoloaderFactory;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\ArrayUtils;
use RuntimeException;

class Bootstrap
{
    protected static $serviceManager;
    protected static $config;

    public static function init()
    {
        error_reporting(E_ALL | E_STRICT);
        chdir(__DIR__);

        // Load the user-defined test configuration file, if it exists; otherwise, load
        if (is_readable(dirname(__DIR__).'/../../config/test.config.php')) {
            $testConfig = include dirname(__DIR__).'/../../config/test.config.php';
        } else {
            throw new \Exception('The file test.config.php doesn\'t exists!');
        }

        if (file_exists(dirname(__DIR__).'/../../config/test.db.config.php')) {
            $testConfig['module_listener_options']['config_static_paths'] = array(
                //$dbConfig
                dirname(__DIR__).'/../../config/test.db.config.php'
            );
        }

        $zf2ModulePaths = array();

        if (isset($testConfig['module_listener_options']['module_paths'])) {
            $modulePaths = $testConfig['module_listener_options']['module_paths'];
            foreach ($modulePaths as $modulePath) {
                if (($path = static::findParentPath($modulePath))) {
                    $zf2ModulePaths[] = $path;
                }
            }
        }

        $zf2ModulePaths = implode(PATH_SEPARATOR,
                $zf2ModulePaths).PATH_SEPARATOR;
        $zf2ModulePaths .= getenv('ZF2_MODULES_TEST_PATHS') ? : (defined('ZF2_MODULES_TEST_PATHS') ? ZF2_MODULES_TEST_PATHS
                    : '');

        static::initAutoloader();

        // use ModuleManager to load this module and it's dependencies
        $baseConfig = array(
            'module_listener_options' => array(
                'module_paths' => explode(PATH_SEPARATOR,
                    $zf2ModulePaths),
            ),
        );

        $config = ArrayUtils::merge($baseConfig,
                $testConfig);

        $serviceManager = new ServiceManager(new ServiceManagerConfig());
        $serviceManager->setService('ApplicationConfig',
            $config);
        $serviceManager->get('ModuleManager')->loadModules();

        \Core\Test\Bootstrap::setConfig($config);
        \Core\Test\Bootstrap::setServiceManager($serviceManager);
    }

    public static function getServiceManager()
    {
        return static::$serviceManager;
    }

    public static function getConfig()
    {
        return static::$config;
    }

    protected static function initAutoloader()
    {
        $vendorPath = static::findParentPath('vendor');

        if (is_readable($vendorPath.'/autoload.php')) {
            include $vendorPath.'/autoload.php';
        } else {
            $zf2Path = getenv('ZF2_PATH') ? : (defined('ZF2_PATH') ? ZF2_PATH : (is_dir($vendorPath.'/ZF2/library') ? $vendorPath.'/ZF2/library'
                            : false));

            if (!$zf2Path) {
                throw new RuntimeException('Unable to load ZF2. Run `php composer.phar install` or define a ZF2_PATH environment variable.');
            }

            include $zf2Path.'/Zend/Loader/AutoloaderFactory.php';
        }

        AutoloaderFactory::factory(array(
            'Zend\Loader\StandardAutoloader' => array(
                'autoregister_zf' => true,
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__.'/'.__NAMESPACE__,
                ),
            ),
        ));
    }

    public static function findParentPath($path)
    {
        $dir = __DIR__;
        $previousDir = '.';
        while (!is_dir($dir.'/'.$path)) {
            $dir = dirname($dir);
            if ($previousDir === $dir) {
                return false;
            }
            $previousDir = $dir;
        }

        return $dir.'/'.$path;
    }

    public static function getModulePath()
    {
        return dirname(__DIR__);
    }
}

\AgvValidator\Bootstrap::init();
