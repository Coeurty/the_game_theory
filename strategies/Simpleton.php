<?php

declare(strict_types=1);
require_once "Strategy.php";
class Simpleton extends Strategy
{
    private string $name = "Simpleton";
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

        $lastMove = end($history);
        $selfLastMove = $lastMove[$selfLabel];
        $opponentLastMove = $lastMove[$opponentLabel];

        if ($opponentLastMove === true) {
            return $selfLastMove;
        }

        if ($opponentLastMove === false) {
            return !$selfLastMove;
        }

        return true;
    }
}
