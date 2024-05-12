<?php

declare( strict_types = 1 );

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Northrook\Symfony\Components\LatteComponentPreprocessor;
use Northrook\Symfony\Core\File;

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