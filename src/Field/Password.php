<?php

namespace Northrook\Symfony\Components\Field;

use Northrook\Elements\Asset\Icon;
use Northrook\Elements\Asset\SVG;
use Northrook\Elements\Element;
use Northrook\Symfony\Components\AbstractComponent;

class Password extends AbstractComponent
{
    protected const TAG = 'field';

    protected string  $id;
    protected string  $name;
    protected string  $label;
    protected ?string $value    = null;
    protected bool    $required = false;

    public function build() : void {

        $this->component->template = <<<HTML
            <div class="label">{label}</div>
            <div class="input">{input}{reveal}</div>
        HTML;

        $label  = Element::label(
            for     : $this->id,
            content : $this->label,
        );
        $input  = Element::input(
            type         : 'password',
            id           : $this->id,
            name         : $this->name,
            value        : $this->value,
            autocomplete : $this->properties( 'autocomplete' ),
            required     : $this->required,
        );
        $reveal = $this->revealPassword( $this->properties( 'timeout' ) ?? 3000 );

        $this->component->class->add( 'field', 'password' );

        $this->component->content( [ 'label' => $label ] )
                        ->content( [ 'input' => $input ] )
                        ->content( [ 'reveal' => $reveal ] );
    }

    private function revealPassword( int | string $duration ) : string {

        $tooltip = '<tooltip>Reveal Password' . Element::keybind( 'alt+R' ) . '</tooltip>';
        $icon    = new SVG( 'reveal-password:ui', 'indicator' );
        $timeout = Icon::circle( 'timeout' );

        $duration = is_int( $duration ) ? " timeout=\"$duration\"" : '';

        return <<<HTML
			<button type="button" class="reveal-password" role="switch" $duration aria-checked="false" tooltip-placement="top">
				$tooltip
				$icon
			    $timeout
			</button>
		HTML;
    }
}