<?php

namespace Northrook\Symfony\Components\Type\Element;

use Northrook\Logger\Log;
use Northrook\Types\Type\Record;
use Stringable;

final class Attribute extends Record
{

    public function __construct(
        string | array | null   $value,
        private readonly string $type,
    ) {
        $this->clear( $this->cast( $value ) );
    }

    public function __set( string $name, array | string | Stringable $value ) : void {
        if ( $this->isSequential() ) {
            Log::Warning(
                'The Record {class} is {type}, and does not accept dynamic properties.', [
                'class' => strstr( $this::class, '\\' ),
                'type'  => 'sequential',
                'name'  => $name,
                'value' => $value,
            ],
            );
        }
        else {
            $this->set( $name, $value );
        }
    }

    private function cast( $value ) : array {
        return is_string( $value ) ? explode( $this->separator(), $value ) : $value ?? [];
    }

    private function separator() : string {
        return match ( $this->type ) {
            'class' => ' ',
            'style' => ';',
            default => ',',
        };
    }

}