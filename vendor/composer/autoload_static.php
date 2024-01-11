<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9e3b7d10e99aa12c4726a65d79c7d5ba
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Markgersaliaph\\LaravelCrudGenerate\\' => 35,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Markgersaliaph\\LaravelCrudGenerate\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9e3b7d10e99aa12c4726a65d79c7d5ba::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9e3b7d10e99aa12c4726a65d79c7d5ba::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit9e3b7d10e99aa12c4726a65d79c7d5ba::$classMap;

        }, null, ClassLoader::class);
    }
}