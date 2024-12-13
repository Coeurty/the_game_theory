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
        require_once "./strategies/Copykitten.php";
        require_once "./strategies/Grudger.php";
        require_once "./strategies/Detective.php";
        require_once "./strategies/Simpleton.php";
        require_once "./Payoffs.php";
        require_once "./Rules.php";
        require_once "./Tournament.php";

        $participants = [
            new NeverCooperate(),
            new NeverCooperate(),
            new Allcooperate(),
            new Allcooperate(),
            new Random(),
            new Random(),
            new Simpleton(),
            new Simpleton(),
            new Copykitten(),
            new Copykitten(),
            new Copycat(),
            new Copycat(),
            new Grudger(),
            new Grudger(),
            new Detective(),
            new Detective(),
        ];

        $payoffs1 = new Payoffs(
            3,
            1,
            5,
            0
        );

        $rules1 = new Rules(
            rand(10, 10),
            5,
            5
        );

        $tournament1 = new Tournament(
            $participants,
            $payoffs1,
            $rules1
        );
        $tournament1->start();
        ?>
    </pre>
</body>

</html>