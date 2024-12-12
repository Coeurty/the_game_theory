<?php

declare(strict_types=1);
require_once "Strategy.php";
class Copycat extends Strategy
{
    private string $name = "Copycat";
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
        if (empty($history)) {
            return true;
        }
        $lastRound = end($history);
        return $lastRound[$opponentLabel];
    }
}