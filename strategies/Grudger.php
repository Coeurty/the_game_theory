<?php

require_once "./Strategy.php";

class Grudger extends Strategy
{
    protected string $name = "Grudger";
    public function playLogic(array $history, string $selfLabel, string $opponentLabel): bool
    {
        $willCooperate = true;
        $opponentPlayHistory = array_map(fn($round) => $round[$opponentLabel], $history);
        $opponentHasCheated = in_array(false, $opponentPlayHistory);
        $willCooperate = $opponentHasCheated ? false : true;
        return $willCooperate;
    }
}