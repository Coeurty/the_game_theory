<?php

require_once "./Strategy.php";

class Allcooperate extends Strategy
{
    protected string $name = "Allcooperate";
    protected function playLogic(array $history, string $selfLabel, string $opponentLabel): bool
    {
        $willCooperate = true;
        return $willCooperate;
    }
}