<?php

require_once "./Strategy.php";

class Grudger extends Strategy
{
    private string $name = "Grudger";
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
        $willCooperate = true;
        $opponentPlayHistory = array_map(fn($round) => $round[$opponentLabel], $history);
        $opponentHasCheated = in_array(false, $opponentPlayHistory);
        $willCooperate = $opponentHasCheated ? false : true;
        return $willCooperate;
    }
}