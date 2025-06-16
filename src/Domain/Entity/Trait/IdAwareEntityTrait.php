<?php

declare(strict_types=1);

namespace App\Domain\Entity\Trait;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait IdAwareEntityTrait
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: Types::BIGINT, nullable: false, options: ['unsigned' => true])]
    #[ORM\GeneratedValue]
    protected int $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }
}
