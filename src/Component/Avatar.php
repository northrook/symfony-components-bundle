<?php

namespace Northrook\Symfony\Components\Component;

use Northrook\Core\Interface\Printable;

class Avatar implements Printable
{

    public function __toString() : string {
        return '<div class="avatar">Avatar</div>';
    }

    public function print() : string {
        return (string) $this;
    }
}