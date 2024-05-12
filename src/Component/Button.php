<?php

namespace Northrook\Symfony\Components\Component;

use Northrook\Elements\Asset as Asset;
use Northrook\Elements\Element;

class Button extends Element
{

    protected array $attributes = [
        'type' => 'button',
    ];

    public function __construct( ...$set ) {

        $this->class->add( 'button' );

        if ( array_key_exists( 'icon', $set ) ) {
            $icon                    = $set[ 'icon' ];
            $this->content[ 'icon' ] = new Asset\Icon( $icon );
            $this->class->add( 'icon' );
            unset( $set[ 'icon' ] );
        }

        parent::__construct( ...$set );
    }

    public static function close(
        string $label = 'Close',
        bool   $tooltip = false,
    ) : self {
        $button = new static( class : 'icon close' );

        if ( $tooltip ) {
            $button->tooltip = $label;
        }
        else {
            $button->set( 'aria-label', $label );
        }

        return $button;
    }
}