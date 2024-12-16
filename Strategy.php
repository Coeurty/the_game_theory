<?php

abstract class Strategy
{
    protected string $name = "";
    protected int $score = 0;
    protected function applyChanceOfMistake(bool $willCooperate, int $chanceOfMistake): bool
    {
        $rand = rand(1, 100);
        if ($rand < $chanceOfMistake) {
            return !$willCooperate;
        }
        return $willCooperate;
    }
    public final function getName(): string
    {
        return $this->name;
    }
    public final function getScore(): int
    {
        return $this->score;
    }
    public final function ResetScore(): void
    {
        $this->score = 0;
    }
    public final function updateScore(int $value): int
    {
        $this->score += $value;
        return $this->score;
    }
    public final function play(array $history, int $chanceOfMistake, string $selfLabel, string $opponentLabel): bool
    {
        $willCooperate = $this->playLogic($history, $selfLabel, $opponentLabel);
        return $this->applyChanceOfMistake($willCooperate, $chanceOfMistake);
    }

    abstract protected function playLogic(array $history, string $selfLabel, string $opponentLabel): bool;
}