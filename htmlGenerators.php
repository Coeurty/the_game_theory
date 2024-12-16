<?php

function buildHTMLResultSection(array $results): void
{
    ?>
    <style>
        #results {
            width: 720px;
            background-color: white;
        }

        #results {
            text-align: center;
        }

        #results .turn {
            display: flex;
            flex-direction: column;
        }

        #results .btn-container {
            display: flex;
            justify-content: space-evenly;
        }

        #results .strategies-container {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
    </style>
    <section id="results">
        <?php
        for ($poolNb = 0; $poolNb < count($results); $poolNb++) {
            $poolResults = $results[$poolNb];
            $showPreviousBtn = $poolNb > 0 ? true : false;
            $showNextBtn = $poolNb < count($results) - 1 ? true : false;
            $previousBtnDirection = $poolNb - 1;
            $nextBtnDirection = $poolNb + 1;
            ?>
            <div class="turn" data-turncontainer="<?= $poolNb ?>" style="display: <?= $poolNb === 0 ? "flex;" : "none;" ?>">
                <h2 class="text-3xl m-4">Turn <?= $poolNb ?> result</h2>
                <div class="btn-container m-4">
                    <?php
                    if ($showPreviousBtn) {
                        echo '<button class="p-4 bg-orange-700 text-white py-2 rounded-lg hover:bg-orange-700" data-toturn="' . $previousBtnDirection . '">Previous turn</button>';
                    }
                    if ($showNextBtn) {
                        echo '<button class="p-4 bg-orange-700 text-white py-2 rounded-lg hover:bg-orange-700" data-toturn="' . $nextBtnDirection . '">Next turn</button>';
                    }
                    ?>
                </div>
                <div class="strategies-container">
                    <?php
                    foreach ($poolResults as $strategy) {
                        ?>
                        <div class='strategy' title=" <?= $strategy["score"] ?>">
                            <img src="./assets/images/<?= $strategy["name"] ?>.png" alt="<?= $strategy["name"] ?>">
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        }
        ?>
    </section>
    <script>
        resultButtons = document.querySelectorAll("#results .btn-container>button");
        turnContainers = document.querySelectorAll("#results .turn");
        console.log(turnContainers);

        [...resultButtons].forEach(element => {
            element.addEventListener("click", function () {
                const toTurn = this.dataset.toturn
                turnContainers.forEach((container) => {
                    if (container.dataset.turncontainer === toTurn) {
                        container.style.display = "flex";
                    } else {
                        container.style.display = "none";
                    }
                })
            })
        });
    </script>
    <?php
}