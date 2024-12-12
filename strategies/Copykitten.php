<?php

declare(strict_types=1);
require_once "Strategy.php";
class Copykitten extends Strategy
{
    private string $name = "Copykitten";
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
        $roundNumber = count($history);

        if ($roundNumber < 2) {
            return true;
        }

        $lastTwoRounds = array_slice($history, -2, 2);
        $adversaryCheatedTwice = $lastTwoRounds[0][$opponentLabel] === false && $lastTwoRounds[1][$opponentLabel] === false;

        if ($adversaryCheatedTwice) {
            return false;
        }

        return true;
    }

}