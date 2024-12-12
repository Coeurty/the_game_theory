<?php

class Rules
{
    private int $numberOfRounds;
    private int $numberOfReplacement;
    private int $chanceOfMistake;

    public function __construct(int $numberOfRounds, int $numberOfReplacement, int $chanceOfMistake)
    {
        $this->numberOfRounds = $numberOfRounds;
        $this->numberOfReplacement = $numberOfReplacement;
        $this->chanceOfMistake = $chanceOfMistake;
    }

    public function getNumberOfRounds(): int
    {
        return $this->numberOfRounds;
    }

    public function getNumberOfReplacement(): int
    {
        return $this->numberOfReplacement;
    }

    public function getChanceOfMistake(): int
    {
        return $this->chanceOfMistake;
    }
}