<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The game theory</title>
</head>

<body>
    <pre>
        <?php
        require_once "./strategies/Allcooperate.php";
        require_once "./strategies/NeverCooperate.php";
        require_once "./strategies/Random.php";
        require_once "./strategies/Copycat.php";
        require_once "./strategies/Grudger.php";
        require_once "./Payoffs.php";
        require_once "./Rules.php";
        require_once "./Tournament.php";

        $strat1 = new Allcooperate();
        $strat2 = new NeverCooperate();
        $strat3 = new Random();
        $strat4 = new Copycat();
        $strat5 = new Grudger();
        
        $payoffs1 = new Payoffs(
            3,
            2,
            5,
            0
        );

        $rules1 = new Rules(
            rand(3, 7),
            5,
            5
        );

        $tournament1 = new Tournament(
            $strat3,
            $strat5,
            $payoffs1,
            $rules1
        );
        $tournament1->start();
        $tournamentResult = $tournament1->getResult();
        var_dump($tournamentResult);

        ?>
    </pre>
</body>

</html>