<?php

namespace Northrook\Symfony\Components;

use Northrook\Core\Get\ClassNameMethods;
use Northrook\Core\Interface\Printable;
use Northrook\Elements\Element;
use Northrook\Elements\Element\Attribute;
use Northrook\Support\Html;
use Northrook\Symfony\Core\DependencyInjection\CoreDependencies;

abstract class AbstractComponent implements Printable
{
    use ClassNameMethods;

    protected const TAG     = 'component';
    protected const CLASSES = null;

    private ?string $string = null;

    protected string           $id;
    protected readonly Element $component;

    protected array                     $data;
    protected readonly string           $className;
    protected readonly CoreDependencies $get;


    /**
     * Build the {@see Component}.
     *
     * Called whenever the {@see Component} is {@see print}ed or rendered {@see __toString}.
     *
     * This method _should_:
     * * Be the final method in the chain.
     * * Return the {@see Component} in string format when valid.
     * * Return null on error.
     * * Not be called directly.
     *
     * The above guidelines can be bent, I'm not the boss of you.
     *
     */
    abstract protected function build() : void;

    final public function matchPattern() : string {
        $tag = $this->getObjectClassName();
        return "/<(?<component>$tag).*?/>/ms";
    }

    /**
     * @param bool  $pretty
     *
     * @return string
     */
    final public function print( bool $pretty = true ) : string {
        $string = $this->__toString();

        return $pretty ? Html::pretty( $string ) : $string;
    }

    /**
     * @return string
     */
    final public function __toString() : string {

        $this->build();

        $this->componentValidation();

        $this->string = $this->component->print( true );

        $this->get->stopwatch?->stop( $this->className );

        if ( !$this->string ) {
            $this->get->logger?->error(
                'Component {className} failed to build.',
                [ 'className' => $this->className ],
            );
            return '';
        }

        return $this->string;
    }

    public function setComponentDependencies(
        array            $data,
        CoreDependencies $get,
    ) : void {
        $this->data = $data;
        $this->get  = $get;
        $this->get->stopwatch?->start( $this->className, 'Component' );

        $this->className = $this->getObjectClassName();
        $this->component = new Element( tag : $this::TAG, class : $this::CLASSES );
        // $this->component->template = $this->template();
        $this->assignProperties();
    }


    private function assignProperties() : void {

        if ( property_exists( $this, 'id' ) ) {
            $this->id = $this->properties( 'name' );
        }

        foreach ( $this->data[ 'properties' ] ?? [] as $name => $value ) {
            if ( property_exists( $this, $name ) ) {
                $this->$name = $value;
                unset( $this->data[ 'properties' ][ $name ] );
            }
        }

        $this->component->addAttributes( $this->data[ 'properties' ] ?? [] );
    }

    final protected function properties( string | array $get ) : null | string | array {

        if ( is_string( $get ) ) {
            return $this->data[ 'properties' ][ $get ] ?? null;
        }

        $properties = [];

        foreach ( $get as $key => $value ) {

            $name = is_string( $key ) ? $key : $value;

            if ( is_string( $key ) ) {
                $properties[ $name ] = $this->data[ 'properties' ][ $name ] ?? $value ?? null;
            }
            else {
                $properties[ $value ] = $this->data[ 'properties' ][ $value ] ?? null;
            }

        }

        return $properties;
    }

    private function componentValidation() : void {
        if ( !$this->component->has( 'id' ) ) {
            $id = $this->getExtendingClasses() ?? [] + [ $this->id, 'field' ];
            $this->component->set( 'id', Attribute::id( $id, true ) );
        }
    }
}