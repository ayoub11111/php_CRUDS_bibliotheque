<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $titre = $_POST['titre'];
    $auteur = $_POST['nom_auteur'];

    $stmt = $conn->prepare("UPDATE livre SET titre = ?, nom_auteur = ? WHERE id = ?");
    $stmt->bind_param("ssi", $titre, $auteur, $id);

    if ($stmt->execute() === TRUE) {
        header('Location: afficher.php');
        exit;
    } else {
        echo "Erreur lors de la modification du livre : " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}

$id = $_GET['id'];
$query = "SELECT * FROM livre WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$livre = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un livre</title>
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
        <h1>Modifier un livre</h1>
        <form action="modifier.php" method="post">
            <input type="hidden" name="id" value="<?= $livre['id'] ?>">
            <div class="form-group">
                <label for="titre">Titre :</label>
                <input type="text" id="titre" name="titre" value="<?= $livre['titre'] ?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="nom_auteur">Auteur :</label>
                <input type="text" id="nom_auteur" name="nom_auteur" value="<?= $livre['nom_auteur'] ?>" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Modifier</button>
        </form>
    </div>
</body>
</html>
