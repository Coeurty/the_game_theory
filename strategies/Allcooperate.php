<?php

require "./Strategy.php";

class Allcooperate extends Strategy
{
    private int $score = 0;
    public function getScore(): int
    {
        return $this->score;
    }
    public function updateScore(int $value): int
    {
        $this->score += $value;
        return $this->score;
    }
    public function play(array $history): bool
    {
        $willCooperate = true;
        return $willCooperate;
    }
}