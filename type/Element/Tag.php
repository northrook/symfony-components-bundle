<?php

namespace Northrook\Symfony\Components\Type\Element;

use JetBrains\PhpStorm\ExpectedValues;

final class Tag
{

    public const NAMES = [
        'div', 'body', 'html', 'li', 'dropdown', 'menu', 'modal', 'field', 'fieldset', 'legend', 'label', 'option',
        'select', 'input', 'textarea', 'form', 'tooltip', 'section', 'main', 'header', 'footer', 'div', 'span', 'p',
        'ul', 'a', 'img', 'button', 'i', 'strong', 'em', 'sup', 'sub', 'br', 'hr', 'h', 'h1', 'h2', 'h3', 'h4',
    ];

    private const SELF_CLOSING = [
        'area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input', 'keygen', 'link', 'meta', 'param', 'source',
        'track', 'wbr',
    ];

    public function __construct(
        #[ExpectedValues( self::NAMES )]
        public string $name = 'div',
    ) {}

    /**
     * @param string  $name
     *
     * @return Tag
     */
    public function set(
        #[ExpectedValues( self::NAMES )]
        string $name,
    ) : Tag {
        $this->name = $name;
        return $this;
    }

    public function __toString() : string {
        return $this->name;
    }

    public function is(
        #[ExpectedValues( self::NAMES )]
        string $name,
    ) : bool {
        return $this->name === $name;
    }


    public function isSelfClosing() : bool {
        return in_array( $this->name, self::SELF_CLOSING );
    }

}