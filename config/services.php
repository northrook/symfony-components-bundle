<?php

declare( strict_types = 1 );

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Northrook\Symfony\Components\LatteComponentPreprocessor;

return static function ( ContainerConfigurator $container ) {

    $services   = $container->services();
    $parameters = $container->parameters();

    /** # ☕
     * Latte Preprocessor
     */
    $services->set( 'components.latte.preprocessor', LatteComponentPreprocessor::class )
             ->args( [ service( 'core.dependencies' ) ] );

};