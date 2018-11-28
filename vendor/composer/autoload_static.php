<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit428e1ec00f723269f32019e541b48d9e
{
    public static $prefixLengthsPsr4 = array (
        'K' => 
        array (
            'Klein\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Klein\\' => 
        array (
            0 => __DIR__ . '/..' . '/klein/klein/src/Klein',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit428e1ec00f723269f32019e541b48d9e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit428e1ec00f723269f32019e541b48d9e::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
