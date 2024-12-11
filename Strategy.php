<?php

abstract class Strategy
{
    abstract protected function getScore(): int;
    abstract protected function updateScore(int $value): int;
    abstract protected function play(array $history): bool;
}