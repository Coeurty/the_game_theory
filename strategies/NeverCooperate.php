<?php

require_once "./Strategy.php";

class NeverCooperate extends Strategy
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
    public function play(array $history, string $selfLabel, string $opponentLabel): bool
    {
        $willNotCooperate = false;
        return $willNotCooperate;
    }
}