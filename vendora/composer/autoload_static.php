<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit96f168928bc8e1b7a3da0a17f50d5b71
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit96f168928bc8e1b7a3da0a17f50d5b71::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit96f168928bc8e1b7a3da0a17f50d5b71::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit96f168928bc8e1b7a3da0a17f50d5b71::$classMap;

        }, null, ClassLoader::class);
    }
}