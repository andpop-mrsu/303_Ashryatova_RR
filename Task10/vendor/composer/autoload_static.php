<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit17a906fa79f5bf5e005ff95e11b5033e
{
    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'RedBeanPHP\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'RedBeanPHP\\' => 
        array (
            0 => __DIR__ . '/..' . '/gabordemooij/redbean/RedBeanPHP',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit17a906fa79f5bf5e005ff95e11b5033e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit17a906fa79f5bf5e005ff95e11b5033e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit17a906fa79f5bf5e005ff95e11b5033e::$classMap;

        }, null, ClassLoader::class);
    }
}
