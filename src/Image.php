<?php

namespace Northrook\Symfony\Components;

use AbstractImage;

class Image extends AbstractImage
{

    public function __construct() {
        dump( static::DIR, self::DIR, __DIR__ );
    }
}