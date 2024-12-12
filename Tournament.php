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
        $strategyACooperated = $strategyA->play($history, "strategyA", "strategyB");
        $strategyBCooperated = $strategyB->play($history, "strategyB", "strategyA");

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

    public function start(): void
    {
        for ($i = 0; $i < 5; $i++) {
            echo PHP_EOL;
            echo "---- Pool $i start ----";
            echo PHP_EOL;
            $shuffledParticipants = $this->participants;
            shuffle($shuffledParticipants);

            for ($j = 0; $j < count($shuffledParticipants); $j += 2) {
                $strategyA = $shuffledParticipants[$j];

                $strategyB = null;
                $strategyB = $shuffledParticipants[$j + 1];

                if ($strategyB === null) {
                    break;
                }

                $history = [];
                echo PHP_EOL;
                echo "-- Match start --";
                for ($k = 0; $k < $this->rules->getNumberOfRounds(); $k++) {
                    $this->playMatch($strategyA, $strategyB, $history);
                }
                echo PHP_EOL;
                echo "-- Match end --";
                echo PHP_EOL;
            }
            echo PHP_EOL;
            echo "---- Pool end ----";
            echo PHP_EOL;
        }
    }

    public function getResult()
    {
        echo PHP_EOL;
        echo "---- Results ----";
        foreach ($this->participants as $strategy) {
            echo PHP_EOL;
            echo $strategy->getName() . ":" . $strategy->getScore();
        }
    }
}