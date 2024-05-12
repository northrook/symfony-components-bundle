<?php

namespace Northrook\Symfony\Components\Field;

use Northrook\Elements\Asset\Icon;
use Northrook\Elements\Element;
use Northrook\Symfony\Components\AbstractComponent;

class Checkbox extends AbstractComponent
{
    protected const TAG = 'field';

    protected string  $id;
    protected string  $name;
    protected ?string $value    = null;
    protected string  $label;
    protected bool    $required = false;

    public function build() : void {

        $this->component->template = <<<HTML
            {input}{label} 
        HTML;

        $label = Element::label(
            for     : $this->id,
            content : [
                          'indicator' => '<i class="indicator">' . Icon::checkmark() . '</i>',
                          'label'     => '<span>' . $this->label . '</span>',
                      ],
        );

        $input = Element::input(
            type     : 'checkbox',
            id       : $this->id,
            name     : $this->name,
            value    : $this->value,
            required : $this->required,
        );

        $this->component->class->add( 'field', 'checkbox' );

        $this->component->content( [ 'label' => $label ] )
                        ->content( [ 'input' => $input ] );
    }

}