<?php

declare(strict_types=1);
require_once "Strategy.php";
class Copykitten extends Strategy
{
    protected string $name = "Copykitten";
    public function playLogic(array $history, string $selfLabel, string $opponentLabel): bool
    {
        $roundNumber = count($history);

        if ($roundNumber < 2) {
            return true;
        }

        $lastTwoRounds = array_slice($history, -2, 2);
        $adversaryCheatedTwice = $lastTwoRounds[0][$opponentLabel] === false && $lastTwoRounds[1][$opponentLabel] === false;

        if ($adversaryCheatedTwice) {
            return false;
        }

        return true;
    }

}