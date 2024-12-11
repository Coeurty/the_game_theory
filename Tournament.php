<?php
require_once "./Strategy.php";

class Tournament
{
    private array $history = [];
    private Strategy $strategyA;
    private Strategy $strategyB;
    private int $numberOfRounds;
    private int $pointsMutualCooperation;
    private int $pointsMutualCheat;
    private int $pointsBetrayer;
    private int $pointsBetrayed;
    public function __construct(
        Strategy $strategyA,
        Strategy $strategyB,
        int $numberOfRounds,
        int $pointsMutualCooperation,
        int $pointsMutualCheat,
        int $pointsBetrayer,
        int $pointsBetrayed
    ) {
        $this->strategyA = $strategyA;
        $this->strategyB = $strategyB;
        $this->numberOfRounds = $numberOfRounds;
        $this->pointsMutualCooperation = $pointsMutualCooperation;
        $this->pointsMutualCheat = $pointsMutualCheat;
        $this->pointsBetrayer = $pointsBetrayer;
        $this->pointsBetrayed = $pointsBetrayed;
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
            $this->strategyA->updateScore($this->pointsMutualCooperation);
            $this->strategyB->updateScore($this->pointsMutualCooperation);
        } elseif (!$strategyACooperated && !$strategyBCooperated) {
            echo "none coop";
            $this->strategyA->updateScore($this->pointsMutualCheat);
            $this->strategyB->updateScore($this->pointsMutualCheat);
        } else {
            if ($strategyACooperated) {
                echo "a coop";
                $this->strategyA->updateScore($this->pointsBetrayed);
                $this->strategyB->updateScore($this->pointsBetrayer);
            } else {
                echo "b coop";
                $this->strategyA->updateScore($this->pointsBetrayer);
                $this->strategyB->updateScore($this->pointsBetrayed);
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
        for ($i = 0; $i < $this->numberOfRounds; $i++) {
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