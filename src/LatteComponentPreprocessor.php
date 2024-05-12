<?php

namespace Northrook\Symfony\Components;

use Northrook\Core\Interface\Printable;
use Northrook\Support\Html;
use Northrook\Symfony\Components\Component\Button;
use Northrook\Symfony\Components\Component\Icon;
use Northrook\Symfony\Core\DependencyInjection\CoreDependencies;
use Northrook\Symfony\Latte\Preprocessor\Preprocessor;
use Northrook\Symfony\Latte\Preprocessor\PreprocessorInterface;

final class LatteComponentPreprocessor extends Preprocessor
{
    private const COMPONENTS = [
        'button' => Button::class,
        'icon'   => Icon::class,
    ];

    private const FIELDS = [
        'field:password' => Field\Password::class,
        'field:email'    => Field\Email::class,
        'field:checkbox' => Field\Checkbox::class,
        'field:toggle'   => Field\Toggle::class,
    ];

    private array $components = [];

    public function __construct( private readonly CoreDependencies $get ) {}

    public function process() : PreprocessorInterface {

        $this->prepareContent( false )
             ->matchFields()
             ->proccessElements();


        foreach ( $this->components as $name => $components ) {

            if ( !isset( LatteComponentPreprocessor::FIELDS[ $name ] ) || empty( $components ) ) {
                continue;
            }

            /** @var AbstractComponent $component */
            $class = LatteComponentPreprocessor::FIELDS[ $name ];

            if ( !is_subclass_of( $class, \Northrook\Symfony\Components\AbstractComponent::class ) ) {
                $this->logger->error(
                    message : "{object} is not a subclass of {component}.",
                    context : [
                                  '$object'   => $name,
                                  'component' => $class,
                              ],
                );
                continue;
            }

            foreach ( $components as $data ) {
                $component = new ( $class )();
                $component->setComponentDependencies( $data, $this->get );
                $this->updateContent( $component->data( 'source', true ), $component->print( true ) );
            }
        }

        return $this;
    }

    private function matchFields() : self {

        $count = preg_match_all(
        /** @lang PhpRegExp */
            pattern : '/<(?<component>(\w*?):.*?)>/ms',
            subject : $this->content,
            matches : $fields,
            flags   : PREG_SET_ORDER,
        );

        if ( $count === 0 ) {
            return $this;
        }

        foreach ( $fields as $element ) {
            $component = $this->getComponentNamespace( $element[ 'component' ] );
            [ $tag, $type ] = explode( ':', $component, 2 );
            $source = $element[ 0 ];

            if ( str_contains( $this->content, "</$component>" )
                 && false === str_ends_with( trim( $source ), '/>' ) ) {

                preg_match( "/<$component.*?>.*?<\/$component>/ms", $this->content, $closingTag );

                $source = $closingTag[ 0 ];
            }

            $this->components[ $component ][] = [
                'source'     => $source,
                'properties' => Html::extractAttributes( $element[ 0 ] ),
                'tag'        => $tag,
                'type'       => $type,
            ];
        }

        return $this;
    }

    private function proccessElements() : void {

        foreach ( LatteComponentPreprocessor::COMPONENTS as $tag => $parser ) {

            $count = preg_match_all(
            /** @lang PhpRegExp */
                pattern : "/<(?<component>$tag).*?>/ms",
                subject : $this->content,
                matches : $components,
                flags   : PREG_SET_ORDER,
            );

            if ( !$count ) {
                return;
            }

            foreach ( $components as $component ) {
                $source  = $component[ 0 ];
                $element = new( $parser )( ... Html::extractAttributes( $source ) );

                if ( !$element instanceof Printable ) {
                    $this->logger->error(
                        message : "Element does not implement {class}. This is unexpected behaviour, please check the template file. Skipping.",
                        context : [
                                      'source'  => $source,
                                      'element' => $element,
                                      'class'   => Printable::class,
                                  ],
                    );
                    continue;
                }

                if ( isset( $element->tag ) ) {
                    $element->tag->isSelfClosing = str_ends_with( $source, '/>' );
                }

                $this->updateContent( $source, $element->print() );
            }
        }
    }

    private function getComponentNamespace( string $string ) : string {
        if ( str_contains( $string, ' ' ) ) {
            $string = explode( ' ', $string, 2 )[ 0 ];
        }

        return trim( $string );
    }
}