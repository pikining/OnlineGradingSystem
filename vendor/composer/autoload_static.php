<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3e64c0ab622c107e48dcf929ffbc8a3f
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit3e64c0ab622c107e48dcf929ffbc8a3f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3e64c0ab622c107e48dcf929ffbc8a3f::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3e64c0ab622c107e48dcf929ffbc8a3f::$classMap;

        }, null, ClassLoader::class);
    }
}
