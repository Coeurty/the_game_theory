<?php

require_once "./Strategy.php";

class NeverCooperate extends Strategy
{
    protected string $name = "NeverCooperate";
    public function playLogic(array $history, string $selfLabel, string $opponentLabel): bool
    {
        $willCooperate = false;
        return $willCooperate;
    }
}