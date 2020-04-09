<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/book.css">
    <title>Checkpoint PHP 1</title>
</head>
<body>

<?php include 'header.php'; ?>

<main class="container">

    <section class="desktop">
        <img src="image/whisky.png" alt="a whisky glass" class="whisky"/>
        <div class="pages">
            <div class="page leftpage">
                Add a bribe
                <!-- requête pour add un bribe dans la bdd -->
                <!-- J'ai pas eu le temps de faire les validations :( -->
                <?php
                require_once 'connec.php';

                $pdo = new PDO(DSN, USER, PASS);

                $name = trim($_POST['name']);
                $payment = trim($_POST['payment']);

                $query = "INSERT INTO bribe (name, payment) VALUES ('$name', '$payment')";
                $statement = $pdo->prepare($query);

                $statement->bindValue(':name', $_POST['name'], \PDO::PARAM_STR);
                $statement->bindValue(':payment', $_POST['payment'], \PDO::PARAM_STR);
                $statement->execute();

                $bribe = $statement->fetchAll();
                ?>

                <!-- TODO : Form -->
                <form method="post">
                    <div>
                        <label  for="name">Name :</label><br>
                        <input  type="text"  id="name"  name="name">
                    </div>
                    <div>
                        <label  for="payment">Payment :</label><br>
                        <input  type="text"  id="payment"  name="payment">
                    </div>
                    <div  class="button">
                        <button  type="submit">Add</button>
                    </div>
                </form>
            </div>

            <div class="page rightpage">
                <!-- TODO : Display bribes and total paiement -->
                <!-- requête pour afficher les éléments de la bdd -->
                <table>
                    <td>
                        <?php

                        require_once 'connec.php';

                        $pdo = new PDO(DSN, USER, PASS);

                        $query = "SELECT * FROM bribe ORDER BY name";
                        $statement = $pdo->query($query);
                        $bribes = $statement->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($bribes as $bribes) {
                            echo "<tr>" . $bribes['name'] . ' ' . $bribes['payment'] . "</tr>" . "<br>";
                        }
                        ?>
                    </td>
                </table>
                <tfoot>
                <!-- requête pour additionner les champs de la colonne payment -->
                <!-- Je n'arrive pas à afficher la requête "SELECT SUM(payment) FROM bribe" :( -->
                    <?php

                    require_once 'connec.php';

                    $pdo = new PDO(DSN, USER, PASS);

                    $query = "SELECT SUM(payment) FROM bribe";
                    $statement = $pdo->query($query);
                    $payments = $statement->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($payments as $payments) {
                        echo $payments['payment'];
                    }
                    ?>
                </tfoot>
            </div>
        </div>
        <img src="image/inkpen.png" alt="an ink pen" class="inkpen"/>
    </section>
</main>
</body>
</html>

