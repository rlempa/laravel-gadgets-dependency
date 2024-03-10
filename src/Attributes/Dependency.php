<?php

namespace Rlempa\Gadgets\Dependency\Attributes;

use Attribute;

/**
 * Class Dependency handles attribute to add dependency using service container.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class Dependency
{
}
