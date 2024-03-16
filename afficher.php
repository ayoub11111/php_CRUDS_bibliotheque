<?php
require 'config.php';

if (isset($_GET['auteur']) && !empty($_GET['auteur'])) {
    $auteur = $_GET['auteur'];
    $sql = "SELECT * FROM livre WHERE nom_auteur LIKE '%$auteur%'";
} else {
    $sql = "SELECT * FROM livre";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $livres = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $livres = []; 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql_delete = "DELETE FROM livre WHERE id = $id";
    if ($conn->query($sql_delete) === TRUE) {
        header('Location: afficher.php');
        exit;
    } else {
        echo "Erreur lors de la suppression du livre : " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Afficher les livres</title>
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
        <form action="" method="GET" class="mb-4">
            <div class="form-group">
                <label for="auteur">Rechercher par l'auteur :</label>
                <input type="text" id="auteur" name="auteur" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Rechercher</button>
        </form>
        
        <h1>Liste des livres</h1>
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th>Id</th>
                    <th>Titre du livre</th>
                    <th>Auteur(s)</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($livres as $livre): ?>
                    <tr>
                        <td><?= $livre['id'] ?></td>
                        <td><?= $livre['titre'] ?></td>
                        <td><?= $livre['nom_auteur'] ?></td>
                        <td>
                            <a href="modifier.php?id=<?= $livre['id'] ?>" class="btn btn-sm btn-primary">Modifier</a>
                        </td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="id" value="<?= $livre['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
