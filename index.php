<?php
/**
 * EvaCloudImage
 * light-weight url based image transformation php library
 *
 * @link      https://github.com/AlloVince/EvaCloudImage
 * @copyright Copyright (c) 2012 AlloVince (http://avnpc.com/)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @author    AlloVince
 */

error_reporting(E_ALL);

// Check php version
if( version_compare(phpversion(), '5.3.0', '<') ) {
    die(printf('PHP 5.3.0 is required, you have %s', phpversion()));
}


$dir = __DIR__;
$autoloader = $dir . '/vendor/autoload.php';
$localConfig = $dir . '/config.local.php';

if (file_exists($autoloader)) {
    $loader = include $autoloader;
} else {
    die('Dependent library not found, run "composer install" first.');
}

/** Debug functions */
function p($r, $usePr = false)
{
    echo sprintf("<pre>%s</pre>", var_export($r));
}

$loader->add('EvaThumber', $dir . '/src');

$config = new EvaThumber\Config\Config(include $dir . '/config.default.php');
if(file_exists($localConfig)){
    $localConfig = new EvaThumber\Config\Config(include $localConfig);
    $config = $config->merge($localConfig);
}

$thumber = new EvaThumber\Thumber($config);

try {
    $thumber->show();
} catch(Exception $e){
    throw $e;
    //header('location:' . $config->error_url . '?msg=' . urlencode($e->getMessage()));
}

