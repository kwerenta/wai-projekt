<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit06d69d7aaf72a22cca9f2e30e065aa3d
{
    public static $prefixLengthsPsr4 = array (
        'a' => 
        array (
            'app\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit06d69d7aaf72a22cca9f2e30e065aa3d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit06d69d7aaf72a22cca9f2e30e065aa3d::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}