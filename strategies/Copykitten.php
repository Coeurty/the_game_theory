<?php

declare(strict_types=1);
require_once "Strategy.php";
class Copykitten extends Strategy
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
    $cheatCountNeeded = 2;
    $opponentCheats = 0;
    $roundNumber = count($history);
    
    static $hasCheatedBack = false;
  
    if ($roundNumber === 0) {
        return true; 
    }
   
    foreach ($history as $round) {
        if ($round[$opponentLabel] === false) {
            $opponentCheats++;
        } else {
            $opponentCheats = 0; 
        }
      
        if ($opponentCheats >= $cheatCountNeeded && !$hasCheatedBack) {
            $hasCheatedBack = true; 
            return false;
        }
    }
   
    if ($hasCheatedBack) {
       
        return true;
    }

    return true;
}


}