<?php


namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function ( ContainerConfigurator $container ) {

    $fromRoot = static fn ( string $set = '' ) => $set ? trim(
        '%kernel.project_dir%' . DIRECTORY_SEPARATOR . trim(
            str_replace( [ '\\', '/' ], DIRECTORY_SEPARATOR, $set ), DIRECTORY_SEPARATOR,
        ) . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR,
    ) : $set;

    $set = static fn ( string $bundle ) => trim(
        dirname( __DIR__, 2 ) . DIRECTORY_SEPARATOR . trim(
            str_replace( [ '\\', '/' ], DIRECTORY_SEPARATOR, $bundle ), DIRECTORY_SEPARATOR,
        ) . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR,
    );

    // Parameters
    $container->parameters()
              ->set(
                  'dir.components', $set( 'src/Components' ),
              )
    ;

};
