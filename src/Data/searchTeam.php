<?php


namespace App\Data;


use App\Entity\Pokemon;
use App\Entity\Tiers;

class searchTeam
{
    /**
     * @var string
     */
    public $q = '';

    /**
     * @var Tiers
     */
    public $tiers;

    /**
     * @var Pokemon
     */
    public $pokemon;

}
