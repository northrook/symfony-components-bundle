<?php

namespace Northrook\Symfony\Components\Field;

use Northrook\Symfony\Components\AbstractComponent;

class Input extends AbstractComponent
{
    protected const TAG = 'field';

    public string $name;
    public string $type;
    public string $value;
    public array  $inputAttributes = [];
    public string $label;

    protected function build() : void {
        $this->component->template = <<<HTML
            {input}
            {label}
        HTML;
    }

}