<?php


namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class DatalistType extends AbstractType {

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    public function getParent() {
        return EntityType::class;
    }
}
