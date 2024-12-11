<?php

declare(strict_types=1);
require "Strategy.php";
class Random extends Strategy
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
        $randomAction = rand(0, 1);
        if ($randomAction === 0) {
            return true;
        } else {
            return false;
        }
    }
}
