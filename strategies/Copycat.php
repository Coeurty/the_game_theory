<?php

declare(strict_types=1);
require_once "Strategy.php";
class Copycat extends Strategy
{
    protected string $name = "Copycat";
    public function playLogic(array $history, string $selfLabel, string $opponentLabel): bool
    {
        if (empty($history)) {
            return true;
        }
        $lastRound = end($history);
        return $lastRound[$opponentLabel];
    }
}