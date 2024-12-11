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
        require_once "./Tournament.php";

        $strat1 = new Allcooperate();
        $strat2 = new NeverCooperate();
        $strat3 = new Random();

        $tournament1 = new Tournament(
            $strat1,
            $strat2,
            5,
            3,
            1,
            5,
            0
        );
        $tournament1->start();
        $tournamentResult = $tournament1->getResult();
        var_dump($tournamentResult);

        ?>
    </pre>
</body>

</html>