<?php

abstract class Strategy
{
    abstract public function getName(): string;
    abstract public function getScore(): int;
    abstract public function updateScore(int $value): int;
    abstract public function play(array $history, string $selfLabel, string $opponentLabel): bool;
}