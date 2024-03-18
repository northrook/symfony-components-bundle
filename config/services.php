<?php


namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Northrook\Symfony\Core\Support\Str;

return static function ( ContainerConfigurator $container ) {


    // Parameters
    $container->parameters()
              ->set(
                  'dir.components', Str::parameterDirname( '../../src/' ),
              )
    ;

};
