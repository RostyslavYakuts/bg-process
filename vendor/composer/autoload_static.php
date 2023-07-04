<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit95234b9f7df19ffea41ed52396185db6
{
    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'BGP\\Classes\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'BGP\\Classes\\' => 
        array (
            0 => __DIR__ . '/../..' . '/admin/classes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit95234b9f7df19ffea41ed52396185db6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit95234b9f7df19ffea41ed52396185db6::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit95234b9f7df19ffea41ed52396185db6::$classMap;

        }, null, ClassLoader::class);
    }
}
