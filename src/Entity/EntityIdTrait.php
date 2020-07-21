<?php

namespace App\Entity;

use Symfony\Component\Uid\Uuid;

trait EntityIdTrait
{
    /**
     *
     * @ORM\Id
     * @ORM\Column(type="guid")
     */
    private string $id;

    public function getId(): string
    {
        return $this->id;
    }

    private function generateId()
    {
        $this->id = (string)Uuid::v4();
    }
}