<?php
require_once "./Strategy.php";
require_once "./Payoffs.php";
require_once "./Rules.php";

class Tournament
{
    private array $participants = [];
    private Payoffs $payoffs;
    private Rules $rules;
    public function __construct(
        array $participants,
        Payoffs $payoffs,
        Rules $rules,
    ) {
        $this->participants = $participants;
        $this->payoffs = $payoffs;
        $this->rules = $rules;
    }

    private function newRound(bool $strategyACooperated, bool $strategyBCooperated): array
    {
        return [
            "strategyA" => $strategyACooperated,
            "strategyB" => $strategyBCooperated,
        ];
    }

    public function playMatch(Strategy $strategyA, Strategy $strategyB, array &$history)
    {
        $chanceOfMistake = $this->rules->getChanceOfMistake();
        $strategyACooperated = $strategyA->play($history, $chanceOfMistake, "strategyA", "strategyB");
        $strategyBCooperated = $strategyB->play($history, $chanceOfMistake, "strategyB", "strategyA");

        $strategyAName = $strategyA->getName();
        $strategyBName = $strategyB->getName();
        $strategyACooperatedToStr = $strategyACooperated ? "cooperated" : "cheated";
        $strategyBCooperatedToStr = $strategyBCooperated ? "cooperated" : "cheated";

        echo PHP_EOL;
        if ($strategyACooperated && $strategyBCooperated) {
            $strategyAPointsThisRound = $this->payoffs->getPointsMutualCooperation();
            $strategyBPointsThisRound = $this->payoffs->getPointsMutualCooperation();
            $strategyA->updateScore($strategyAPointsThisRound);
            $strategyB->updateScore($strategyBPointsThisRound);
        } elseif (!$strategyACooperated && !$strategyBCooperated) {
            $strategyAPointsThisRound = $this->payoffs->getPointsMutualCheat();
            $strategyBPointsThisRound = $this->payoffs->getPointsMutualCheat();
            $strategyA->updateScore($strategyAPointsThisRound);
            $strategyB->updateScore($strategyBPointsThisRound);
        } else {
            if ($strategyACooperated) {
                $strategyAPointsThisRound = $this->payoffs->getPointsBetrayed();
                $strategyBPointsThisRound = $this->payoffs->getPointsBetrayer();
                $strategyA->updateScore($strategyAPointsThisRound);
                $strategyB->updateScore($strategyBPointsThisRound);
            } else {
                $strategyAPointsThisRound = $this->payoffs->getPointsBetrayer();
                $strategyBPointsThisRound = $this->payoffs->getPointsBetrayed();
                $strategyA->updateScore($strategyAPointsThisRound);
                $strategyB->updateScore($strategyBPointsThisRound);
            }
        }
        echo PHP_EOL;
        echo "$strategyAName $strategyACooperatedToStr: +($strategyAPointsThisRound) | Total: " . $strategyA->getScore();
        echo PHP_EOL;
        echo "$strategyBName $strategyBCooperatedToStr: +($strategyBPointsThisRound) | Total: " . $strategyB->getScore();
        echo PHP_EOL;

        $history[] = $this->newRound(
            $strategyACooperated,
            $strategyBCooperated
        );
    }

    private function replaceTheWorstWithTheBest(): void
    {
        usort($this->participants, fn($a, $b) => $a->getScore() - $b->getScore());

        $numberOfReplacements = $this->rules->getNumberOfReplacement();
        $bestParticipants = array_slice($this->participants, -$numberOfReplacements);
        $this->participants = array_slice($this->participants, $numberOfReplacements);

        foreach ($bestParticipants as $best) {
            $this->participants[] = clone $best;
        }
    }

    public function start(): void
    {
        for ($poolNb = 0; $poolNb < 10; $poolNb++) {
            echo PHP_EOL;
            echo "---- Pool $poolNb start ----";
            echo PHP_EOL;
            $participants = $this->participants;

            for ($i = 0; $i < count($participants); $i++) {
                $participantA = $participants[$i];
                for ($j = 0; $j < count($participants); $j++) {
                    if ($i === $j) {
                        continue;
                    }
                    $participantB = $participants[$j];
                    $history = [];
                    echo PHP_EOL;
                    echo "-- Match start --";
                    for ($k = 0; $k < $this->rules->getNumberOfRounds(); $k++) {
                        $this->playMatch($participantA, $participantB, $history);
                    }
                    echo PHP_EOL;
                    echo "-- Match end --";
                    echo PHP_EOL;
                }

            }


            echo PHP_EOL;
            echo "---- Pool end ----";
            echo PHP_EOL;
            $this->getResult();
            $this->replaceTheWorstWithTheBest();
        }
    }

    public function getResult()
    {
        echo PHP_EOL;
        echo "---- Results ----";
        usort($this->participants, fn($a, $b) => strcmp(get_class($a), get_class($b)));
        foreach ($this->participants as $strategy) {
            echo PHP_EOL;
            echo $strategy->getName() . ":" . $strategy->getScore();
        }
        echo PHP_EOL;
    }
}