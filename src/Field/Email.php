<?php

namespace Northrook\Symfony\Components\Field;

use Northrook\Elements\Element;
use Northrook\Symfony\Components\AbstractComponent;

class Email extends AbstractComponent
{
    protected string  $id;
    protected string  $name;
    protected ?string $value        = null;
    protected string  $label;
    protected bool    $autofocus    = false;
    protected ?string $autocomplete = null;
    protected bool    $required     = false;

    public function build() : void {
        
        $this->component->template = <<<HTML
            <div class="label">{label}</div>
            <div class="input">{input}</div>
        HTML;

        $label = Element::label(
            for     : $this->id,
            content : $this->label,
        );
        $input = Element::input(
            type         : 'email',
            id           : $this->id,
            name         : $this->name,
            value        : $this->value,
            autocomplete : $this->properties( 'autocomplete' ),
            required     : $this->required,
        );

        $this->component->class->add( 'field', 'email' );

        $this->component->content( [ 'label' => $label ] )
                        ->content( [ 'input' => $input ] );
    }

}