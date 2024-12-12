<?php
require_once "./Strategy.php";
require_once "./Payoffs.php";
require_once "./Rules.php";

class Tournament
{
    private array $history = [];
    private Strategy $strategyA;
    private Strategy $strategyB;
    private Payoffs $payoffs;
    private Rules $rules;
    public function __construct(
        Strategy $strategyA,
        Strategy $strategyB,
        Payoffs $payoffs,
        Rules $rules,
    ) {
        $this->strategyA = $strategyA;
        $this->strategyB = $strategyB;
        $this->payoffs = $payoffs;
        $this->rules = $rules;
    }

    private function newRound(bool $strategyACooperated, bool $strategyBCooperated): array
    {
        $newRound = [
            "strategyA" => $strategyACooperated,
            "strategyB" => $strategyBCooperated,
        ];
        return $newRound;
    }

    public function playARound(): void
    {
        $strategyACooperated = $this->strategyA->play($this->history, "strategyA", "strategyB");
        $strategyBCooperated = $this->strategyB->play($this->history, "strategyB", "strategyA");

        echo PHP_EOL;
        if ($strategyACooperated && $strategyBCooperated) {
            echo "all coop";
            $this->strategyA->updateScore($this->payoffs->getPointsMutualCooperation());
            $this->strategyB->updateScore($this->payoffs->getPointsMutualCooperation());
        } elseif (!$strategyACooperated && !$strategyBCooperated) {
            echo "none coop";
            $this->strategyA->updateScore($this->payoffs->getPointsMutualCheat());
            $this->strategyB->updateScore($this->payoffs->getPointsMutualCheat());
        } else {
            if ($strategyACooperated) {
                echo "a coop";
                $this->strategyA->updateScore($this->payoffs->getPointsBetrayed());
                $this->strategyB->updateScore($this->payoffs->getPointsBetrayer());
            } else {
                echo "b coop";
                $this->strategyA->updateScore($this->payoffs->getPointsBetrayer());
                $this->strategyB->updateScore($this->payoffs->getPointsBetrayed());
            }
        }
        echo PHP_EOL;
        echo "a:" . $strategyACooperated . " " . $this->strategyA->getScore() . PHP_EOL;
        echo "b:" . $strategyBCooperated . " " . $this->strategyB->getScore();
        echo PHP_EOL;
        echo PHP_EOL;

        $this->history[] = $this->newRound(
            $strategyACooperated,
            $strategyBCooperated
        );
    }

    public function start(): void
    {
        for ($i = 0; $i < $this->rules->getNumberOfRounds(); $i++) {
            $this->playARound();
        }
    }

    public function getResult()
    {
        $result = [
            "StrategyA" => $this->strategyA->getScore(),
            "StrategyB" => $this->strategyB->getScore(),
        ];
        return $result;
    }
}