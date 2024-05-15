<?php

declare( strict_types = 1 );

namespace Northrook\Symfony\Components;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

/**
 * @version 1.0 ☑️
 * @author  Martin Nielsen <mn@northrook.com>
 *
 * @link    https://github.com/northrook Documentation
 * @todo    Update URL to documentation : root of symfony-latte-bundle
 */
final class SymfonyComponentsBundle extends AbstractBundle
{
    public function loadExtension(
        array                 $config,
        ContainerConfigurator $container,
        ContainerBuilder      $builder,
    ) : void {
        $container->import( '../config/services.php' );
    }

    public function build( ContainerBuilder $container ) : void {
        $container->addCompilerPass( new Compiler\LatteEnvironmentPass() );
    }

    public function getPath() : string {
        return dirname( __DIR__ );
    }

}