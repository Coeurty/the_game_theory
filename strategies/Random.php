<?php

declare(strict_types=1);
require_once "Strategy.php";
class Random extends Strategy
{
    private string $name = "Random";
    private int $score = 0;
    public function getName(): string
    {
        return $this->name;
    }
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
        $randomAction = rand(0, 1);
        if ($randomAction === 0) {
            return true;
        } else {
            return false;
        }
    }
}
