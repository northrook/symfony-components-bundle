<?php

namespace Northrook\Symfony\Components\Component;

use Northrook\Core\Interface\Printable;

class Image implements Printable
{

    public function __toString() : string {
        return '<div class="image">Image</div>';
    }

    public function print() : string {
        return (string) $this;
    }
}