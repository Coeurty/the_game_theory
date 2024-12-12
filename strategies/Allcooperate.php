<?php

require_once "./Strategy.php";

class Allcooperate extends Strategy
{
    private string $name = "Allcooperate";
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
    public function play(array $history, string $selfLabel ,string $opponentLabel): bool
    {
        $willCooperate = true;
        return $willCooperate;
    }
}