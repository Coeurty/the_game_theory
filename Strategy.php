<?php

abstract class Strategy
{
    protected int $score = 0;
    abstract protected function getScore(): int;
    abstract protected function updateScore(int $value): int;
    abstract protected function play(array $history): bool;
}