<?php

declare(strict_types=1);
require_once "Strategy.php";
class Random extends Strategy
{
    protected string $name = "Random";
    public function playLogic(array $history, string $selfLabel, string $opponentLabel): bool
    {
        $randomAction = rand(0, 1);
        if ($randomAction === 0) {
            return true;
        } else {
            return false;
        }
    }
}
