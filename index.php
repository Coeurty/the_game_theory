<!DOCTYPE html>
<lang="en">
    <html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="./assets/css/Style.css">
        <script defer src="./assets/js/script.js"></script>
        <style>
            .tab-content {
                display: none;
            }

            .tab-content.active {
                display: block;
            }
        </style>
        <title>The game theory</title>
    </head>
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

        $strategyFiles = array_filter(
            scandir("./strategies"),
            fn($file) => pathinfo($file, PATHINFO_EXTENSION) === 'php'
        );


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
        // $tournament1->start();
        ?>
    </pre>

    <body class="bg-black flex items-center justify-start">
        <div class="bg-gray-700 p-6 rounded-lg shadow-lg w-96">
            <!-- Onglets -->
            <div class="flex justify-around mb-4 border-b border-gray-500">
                <button type="button"
                    class="tab-button text-white py-2 px-4 hover:bg-gray-600 focus:outline-none active-tab"
                    data-tab="tab1">Population</button>
                <button type="button" class="tab-button text-white py-2 px-4 hover:bg-gray-600 focus:outline-none"
                    data-tab="tab2">Payoffs</button>
                <button type="button" class="tab-button text-white py-2 px-4 hover:bg-gray-600 focus:outline-none"
                    data-tab="tab3">Rules</button>
            </div>
            <!-- Formulaire -->
            <form method="POST" class="mb-6 bg-gray-700 p-2 rounded-lg shadow-lg w-72 space-y-6">
                <!-- Box blanche -->
                <div class="bg-white p-9 rounded-lg shadow-lg w-80">
                    <!-- Ce qu'il y a dans les onglets -->
                    <div id="tab1" class="tab-content active">
                        <form action="/submit" method="POST" class="space-y-6">
                            <div class="flex flex-col space-y-7">
                                <?php
                                foreach ($strategyFiles as $file) {
                                    $strategyName = basename($file, '.php');
                                    ?>
                                    <div class="flex flex-col space-y-2">
                                        <div class="flex items-center">
                                            <label for="<?= $strategyName ?>" class="text-black text-sm w-24">
                                                <?= $strategyName ?>
                                            </label>

                                            <div>
                                                <img class="size-10 rounded-xl ml-8"
                                                    src="assets/images/<?= $strategyName ?>.png" alt="">
                                            </div>

                                            <span id="<?= $strategyName ?>-value" class="text-black text-sm ml-12 ">1</span>
                                        </div>
                                        <input id="<?= $strategyName ?>" name="<?= $strategyName ?>" type="range" value="1"
                                            min="0" max="50" step="1" class="w-full accent-orange-700"
                                            oninput="document.getElementById('<?= $strategyName ?>-value').textContent = this.value">
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <button type="submit"
                                class="mt-4 w-full bg-orange-700 text-white py-2 rounded-lg hover:bg-orange-700">
                                Confirm
                            </button>
                    </div>
                    <div id="tab2" class="tab-content">

                        <div class="text-black">
                            <label for="Both Cooperated" class="text-sm">Both Cooperated:</label>
                            <input type="number" id="Both Cooperated" name="Both Cooperated"
                                class="w-full mt-2 p-2 rounded bg-gray-600 text-black">
                            <label for="Both Cheated" class="text-sm">Both Cheated:</label>
                            <input type="number" id="Both Cheated" name="Both Cheated"
                                class="w-full mt-2 p-2 rounded bg-gray-600 text-black">
                            <label for="Betrayer" class="text-sm">Betrayer:</label>
                            <input type="number" id="Betrayer" name="Betrayer"
                                class="w-full mt-2 p-2 rounded bg-gray-600 text-black">
                            <label for="Betrayed" class="text-sm">Betrayed:</label>
                            <input type="number" id="Betrayed" name="Betrayed"
                                class="w-full mt-2 p-2 rounded bg-gray-600 text-black">
                        </div>
                        <button type="submit"
                            class="mt-4 w-full bg-orange-700 text-white py-2 rounded-lg hover:bg-orange-700">
                            Confirm
                        </button>

                    </div>
                    <div id="tab3" class="tab-content">
                        <div class="text-white flex flex-col">
                                <div class="flex flex-col space-y-2">
                                    <div class="flex items-center">
                                        <label for="numberOfRounds" class="text-black text-sm w-40">
                                            Rounds: 
                                        </label>
                                        <span id="numberOfRounds-value" class="text-black text-sm ml-20 ">1</span>
                                    </div>
                                    <input id="numberOfRounds" name="numberOfRounds" type="range" value="1"
                                        min="1" max="10" step="1" class="w-full accent-orange-700"
                                        oninput="document.getElementById('numberOfRounds-value').textContent = this.value">
                                </div>
                                <br>
                                <div class="flex flex-col space-y-2">
                                    <div class="flex items-center">
                                        <label for="numberOfReplacement" class="text-black text-sm w-80">
                                        Number of people replaced from top and bottom after each game : 
                                        </label>
                                        <span id="numberOfReplacement-value" class="text-black text-sm ml-20 mt-10 ">1</span>
                                    </div>
                                    <input id="numberOfReplacement" name="numberOfReplacement" type="range" value="1"
                                        min="1" max="10" step="1" class="w-full accent-orange-700"
                                        oninput="document.getElementById('numberOfReplacement-value').textContent = this.value">
                                </div>
                                <br>
                                <div class="flex flex-col space-y-2">
                                    <div class="flex items-center">
                                        <label for="chanceOfMistake" class="text-black text-sm w-40">
                                            Chance of Mistake : 
                                        </label>
                                        <span id="chanceOfMistake-value" class="text-black text-sm ml-20 ">0</span>
                                    </div>
                                    <input id="chanceOfMistake" name="chanceOfMistake" type="range" value="0"
                                        min="0" max="50" step="1" class="w-full accent-orange-700"
                                        oninput="document.getElementById('chanceOfMistake-value').textContent = this.value">
                                </div>
                        </div>
                    </div>

                </div>

            </form>
        </div>
    </body>

    </html>