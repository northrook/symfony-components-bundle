<?php

namespace Northrook\Symfony\Components\Type;

use Northrook\Types\Interfaces\Printable;
use Northrook\Types\Traits\PrintableTypeTrait;
use stdClass;

class AbstractElement extends stdClass implements Printable
{
    use PrintableTypeTrait;
}