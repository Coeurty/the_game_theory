<?php

declare(strict_types=1);
require_once "Strategy.php";
class Simpleton extends Strategy
{
    protected string $name = "Simpleton";
    public function playLogic(array $history, string $selfLabel, string $opponentLabel): bool
    {
        if (empty($history)) {
            return true;
        }

        $lastMove = end($history);
        $selfLastMove = $lastMove[$selfLabel];
        $opponentLastMove = $lastMove[$opponentLabel];

        if ($opponentLastMove === true) {
            return $selfLastMove;
        }

        if ($opponentLastMove === false) {
            return !$selfLastMove;
        }

        return true;
    }
}
