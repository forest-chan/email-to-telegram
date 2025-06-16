<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Entity\Trait\IdAwareEntityTrait;
use App\Domain\Entity\Trait\TimestampableEntityTrait;

abstract class AbstractEntity
{
    use IdAwareEntityTrait;
    use TimestampableEntityTrait;
}
