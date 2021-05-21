<?php

/*
nom de la fonction : enregistrerFichierEnvoye
paramètre en entrée : array $infoFichier
paramètre en sortie : string
*/
function enregistrerFichierEnvoye(array $infoFichier): string
{
    // récupère dans la variable $timestamp, sous forme de string, l'heure courante mesurée en seconde depuis le 1er janvier 1970 00:00:00 GMT
    $timestamp = strval(time());


    // récupère dans la variable $extension l'extension du nom du fichier correspondant à $infoFichier
    $extension = pathinfo(basename($infoFichier["name"]), PATHINFO_EXTENSION);

    // concatène dans la variable $nomDuFichier le suffixe produit_ + $timestamp + $extension
    $nomDuFichier = 'produit_' . $timestamp . '.' . $extension;

    // concatène dans la variable $dossierStockage le chemin du dossier courant + le dossier /uploads/
    $dossierStockage = __DIR__ . '/uploads/';


    // vérifie si le dossier $dossierStockage existe déjà
    if (file_exists($dossierStockage) === false)
    {
        // dans le cas où le dossier $dossierStockage n'existe pas, il crée ce dossier
        mkdir($dossierStockage);
    }

    // déplace le fichier téléchargé $infoFichier["tmp_name"] dans le dossier $dossierStockage avec le nom $nomDuFichier
    move_uploaded_file($infoFichier["tmp_name"], $dossierStockage . $nomDuFichier);

    //la fonction retourne la concatènation /uploads/ + $nomDuFichier
    return '/uploads/' . $nomDuFichier;
}


/*
nom de la fonction : onVaRediriger
paramètre en entrée : string $path
*/
function onVaRediriger(string $path)
{
    // envoie un en-tête " /router.php + $path " de type Location 
    // Le type "Location" (avec un statut (302) vers le navigateur tant qu'un code statut 201 ou 3xx n'a pas été envoyé)
    header('LOCATION: /produit-crud/router.php' . $path);
    // termine le programme
    die();
}