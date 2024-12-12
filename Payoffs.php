<?php

class Payoffs
{
    private int $pointsMutualCooperation;
    private int $pointsMutualCheat;
    private int $pointsBetrayer;
    private int $pointsBetrayed;

    public function __construct(
        int $pointsMutualCooperation,
        int $pointsMutualCheat,
        int $pointsBetrayer,
        int $pointsBetrayed
    ) {
        $this->pointsMutualCooperation = $pointsMutualCooperation;
        $this->pointsMutualCheat = $pointsMutualCheat;
        $this->pointsBetrayer = $pointsBetrayer;
        $this->pointsBetrayed = $pointsBetrayed;
    }

    public function getPointsMutualCooperation(): int
    {
        return $this->pointsMutualCooperation;
    }
    public function getPointsMutualCheat(): int
    {
        return $this->pointsMutualCheat;
    }
    public function getPointsBetrayer(): int
    {
        return $this->pointsBetrayer;
    }
    public function getPointsBetrayed(): int
    {
        return $this->pointsBetrayed;
    }


}