<?php

declare(strict_types=1);
require_once "Strategy.php";
class Copycat extends Strategy
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
        var_dump($history);
        if (empty($history)) {
            return true;
        }
        $lastRound = end($history);

        $opponentLabel = ($selfLabel === 'strategyA') ? 'strategyB' : 'strategyA';

        return $lastRound[$opponentLabel];
    }
}