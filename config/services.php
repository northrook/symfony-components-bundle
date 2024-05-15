<?php

declare( strict_types = 1 );

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Northrook\Support\File;
use Northrook\Symfony\Components\LatteComponentPreprocessor;

return static function ( ContainerConfigurator $container ) {

    $services   = $container->services();
    $parameters = $container->parameters();

    $parameters->set( 'dir.components.templates', File::parameterDirname( '../../templates' ) );

    /** # ☕
     * Latte Preprocessor
     */
    $services->set( 'components.latte.preprocessor', LatteComponentPreprocessor::class )
             ->args( [ service( 'core.dependencies' ) ] );

};