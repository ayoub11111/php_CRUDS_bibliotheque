<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $auteur = $_POST['nom_auteur'];

    $stmt = $conn->prepare("INSERT INTO livre (titre, nom_auteur) VALUES (?, ?)");
    $stmt->bind_param("ss", $titre, $auteur);


    if ($stmt->execute() === TRUE) {
        header('Location: afficher.php');
        exit;
    } else {
        echo "Erreur lors de l'ajout du livre : " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un livre</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                Bibliothèque
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="ajouter.php">Ajouter un livre</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Ajouter un livre</h1>
        <form action="ajouter.php" method="post">
            <div class="form-group">
                <label for="titre">Titre :</label>
                <input type="text" id="titre" name="titre" class="form-control">
            </div>
            <div class="form-group">
                <label for="nom_auteur">Auteur :</label>
                <input type="text" id="nom_auteur" name="nom_auteur" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>
</body>
</html>
