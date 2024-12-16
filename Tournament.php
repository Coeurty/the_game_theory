<?php
require_once "./Strategy.php";
require_once "./Payoffs.php";
require_once "./Rules.php";

class Tournament
{
    private array $results = [];
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

        // echo PHP_EOL;
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
        $this->saveResult();
        for ($poolNb = 0; $poolNb < 10; $poolNb++) {
            $participants = $this->participants;

            for ($i = 0; $i < count($participants); $i++) {
                $participantA = $participants[$i];
                for ($j = 0; $j < count($participants); $j++) {
                    if ($i === $j) {
                        continue;
                    }
                    $participantB = $participants[$j];
                    $history = [];
                    for ($k = 0; $k < $this->rules->getNumberOfRounds(); $k++) {
                        $this->playMatch($participantA, $participantB, $history);
                    }
                }
            }

            $this->saveResult();
            $this->replaceTheWorstWithTheBest();
            $this->resetScores();
        }
    }

    private function resetScores(): void
    {
        foreach ($this->participants as $strategy)
            $strategy->resetScore();
    }

    private function saveResult(): void
    {
        usort($this->participants, fn($a, $b) => strcmp(get_class($a), get_class($b)));
        $poolResult = array_map(function ($strategy) {
            return [
                "name" => $strategy->getName(),
                "score" => $strategy->getScore()
            ];
        }, $this->participants);
        $this->results[] = $poolResult;
    }

    public function getResult(): array
    {
        return $this->results;
    }
}