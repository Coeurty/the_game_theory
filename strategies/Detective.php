<?php

declare(strict_types=1);
require_once "Strategy.php";
class Detective extends Strategy
{
    protected string $name = "Detective";
    public function playLogic(array $history, string $selfLabel, string $opponentLabel): bool
    {
        $initialSequence = [true, false, true, true];
        $roundNumber = count($history);

        if ($roundNumber < count($initialSequence)) {
            return $initialSequence[$roundNumber];
        }

        $opponentCheated = false;
        foreach ($history as $round) {
            if ($round[$opponentLabel] === false) {
                $opponentCheated = true;
                break;
            }
        }

        if ($opponentCheated) {

            $lastRound = end($history);
            return $lastRound[$opponentLabel];
        }

        return false;
    }
}
