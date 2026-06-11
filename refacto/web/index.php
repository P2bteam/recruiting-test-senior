<?php
include("classes.inc.php");

use Repository\Repository;

// Actions de la page
if ($_REQUEST["action"] === "submitPlace") {
    $objRepo = new Repository(Place::class);
    $objPlace = new Place();
    $objPlace->setName($_REQUEST["name"]);
    $objPlace->setCreatedAt(new \DateTime());
    $objRepo->insert($objPlace);
}
if ($_REQUEST["action"] === "submitUser") {
    $objRepo = new Repository(User::class);
    $objUser = new User();
    $objUser->setName($_REQUEST["name"]);
    $objPlace->setCreatedAt(new \DateTime());
    $objRepo->insert($objUser);
}
if ($_REQUEST["action"] === "submitComment") {
    $objRepo = new Repository(Comment::class);
    $objComment = new Comment();
    $objComment->setComment($_REQUEST["comment"]);
    $objPlace = new Place();
    $objPlace->setId($_REQUEST["place"]);
    $objComment->setObjPlace($objPlace);
    $objUser = new User();
    $objUser->setId($_REQUEST["user"]);
    $objComment->setCreatedBy($objUser);
    $objComment->setCreatedAt(new \DateTime());
    $objRepo->insert($objComment);
}

// Récupération des informations
$tabData = json_decode(file_get_contents(__DIR__ . "/../src/Repository/db.json"), true, 512, JSON_THROW_ON_ERROR);
$tabLastComment = array_slice($tabData["comments"], -3);
$tabPlacesCount = [];
$tabUserCount = [];
foreach ($tabData["comments"] as $comment) {
    $tabPlacesCount[$comment["place"]]++;
    $tabUserCount[$comment["createdBy"]]++;
}
krsort($tabPlacesCount);
$tabPlaces = [];
foreach ($tabPlacesCount as $idPlace => $rien) {
    foreach ($tabData["places"] as $place) {
        if ($place["id"] === $idPlace) {
            $tabPlaces[] = $place;
        }
    }
}
krsort($tabUserCount);
$tabUsers = [];
foreach ($tabUserCount as $idUser => $rien) {
    foreach ($tabData["users"] as $user) {
        if ($user["id"] === $idUser) {
            $tabUsers[] = $user;
        }
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Avis de lieux insolites</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
<div class="container-fluid">
    <div>
        <h1>Les derniers avis</h1>
        <div class="d-flex flex-wrap">
            <?php foreach ($tabLastComment as $comment) { ?>
                <div class="col-12"
                     style="border: thin solid black; border-radius: 5px;padding: 10px; margin-bottom: 5px;">
                    <b><?= $tabData["places"][$comment["place"] - 1]["name"] ?></b>
                    <br>
                    <?= $comment["comment"] ?>
                    <br>
                    <i><?= $tabData["users"][$comment["createdBy"] - 1]["name"] ?></i>
                </div>
            <?php } ?>
        </div>
    </div>
    <div>
        <h1>Les lieux les plus célèbres</h1>
        <div class="d-flex flex-wrap">
            <?php foreach ($tabPlaces as $place) { ?>
                <div class="col-12"
                     style="border: thin solid black; border-radius: 5px;padding: 10px; margin-bottom: 5px;">
                    <i><?= $place["name"] ?></i>
                </div>
            <?php } ?>
        </div>
    </div>
    <div>
        <h1>Top aventuriers</h1>
        <div class="d-flex flex-wrap">
            <?php foreach ($tabUsers as $user) { ?>
                <div class="col-12"
                     style="border: thin solid black; border-radius: 5px;padding: 10px; margin-bottom: 5px;">
                    <i><?= $user["name"] ?></i>
                </div>
            <?php } ?>
        </div>
    </div>
    <div>
        <h1>Nouveautés</h1>
        <div class="d-flex">
            <div class="col-4 p-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ajouter un lieu</h5>
                        <form action="./index.php?action=submitPlace" method="post">
                            <div class="d-flex">
                                <label class="col-3">Nom</label>
                                <div class="col-9">
                                    <input name="name" class="form-control" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-4 p-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ajouter un utilisateur</h5>
                        <form action="./index.php?action=submitUser" method="post">
                            <div class="d-flex">
                                <label class="col-3">Nom</label>
                                <div class="col-9">
                                    <input name="name" class="form-control" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-4 p-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ajouter un avis</h5>
                        <form action="./index.php?action=submitComment" method="post">
                            <div class="d-flex flex-wrap">
                                <label class="col-3">Avis</label>
                                <div class="col-9">
                                    <textarea name="comment" class="form-control" required></textarea>
                                </div>
                                <label class="col-3">Utilisateur</label>
                                <div class="col-9">
                                    <select name="user" class="form-select">
                                        <?php foreach ($tabData["users"] as $user) { ?>
                                            <option value="<?= $user["id"] ?>">
                                                <?= $user["name"] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <label class="col-3">Lieu</label>
                                <div class="col-9">
                                    <select name="place" class="form-select">
                                        <?php foreach ($tabData["places"] as $place) { ?>
                                            <option value="<?= $place["id"] ?>">
                                                <?= $place["name"] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>
</html>