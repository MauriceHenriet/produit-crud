<?php
include DOSSIER_MODELS.'/Produit.php';

function verifierPayload(array $data, array $file)
{
    if (!isset($data['product-name']) || $data['product-name'] === '')
    {
        return "Vous devez spécifier un nom de produit";
    }

    if (!isset($data['product-price']) || $data['product-price'] === '')
    {
        return "Vous devez spécifier un prix de produit";
    }

    if (!is_numeric($data['product-price']))
    {
        return "Le prix doit être numérique";
    }

    if (!isset($data['product-type']) || $data['product-type'] === '')
    {
        return "Vous devez spécifier un prix de produit";
    }

    if (isset($file['product-photo-file']) && $file['product-photo-file']['name'] !== '')
    {
        if (!in_array($file['product-photo-file']['type'], ['image/webp', 'image/png', 'image/jpg', 'image/jpeg']))
        {
            return "Le type de fichier " . $file['product-photo-file']['type'] . " n'est pris en charge";
        }

        if ($file['product-photo-file']['size'] > 10000000)
        {
            return "Le fichier est trop gros: il fait " . $file['product-photo-file']['size']. ' octets';
        }
    }

    return null;
}

function convertirPayloadEnObjet(array $data, array $file)
{
    $fichier = enregistrerFichierEnvoye($file["product-photo-file"]);
    $produit = new Produit();
    $produit->nom = $data['product-name'];
    $produit->prix = $data['product-price'];
    $produit->image = $fichier;
    $produit->type = $data['product-type'];
    $produit->description = $data['product-description'];

    return $produit;
}

function mettreAJourPayload(Produit $prod, array $data, array $file)
{
    //on récupère le chemin vers l'ancienne image
    $ancienneImage = $prod->image;
    if($_FILES["product-photo-file"]["name"] != ""){
        // si lors de la modification on a uploadé une nouvelle image on supprime l'ancienne image
        unlink(__DIR__ .'/../..'.$ancienneImage);
        // on charge la nouvelle image
        $fichier = enregistrerFichierEnvoye($file["product-photo-file"]);
        $prod->image = $fichier;
    }else{
        $prod->image = $ancienneImage;
    }

    $fichier = enregistrerFichierEnvoye($file["product-photo-file"]);
    $prod->nom = $data['product-name'];
    $prod->prix = $data['product-price'];
    $prod->type = $data['product-type'];
    $prod->description = $data['product-description'];

    return $prod;
}

// ACTIONS ------------------------------------------------

function create()
{
    $produit = new Produit();
    $messageErreur = null;
    if (isset($_POST['btn-valider']))
    {
        $messageErreur = verifierPayload($_POST, $_FILES);
        if ($messageErreur === null)
        {
            $produit = convertirPayloadEnObjet($_POST, $_FILES);
            $produit->save();
            onVaRediriger('/catalogue');
        }
    }

    include DOSSIER_VIEWS.'/produit/ajouter.html.php';
}

function index()
{
    $tableau = Produit::all();
    include DOSSIER_VIEWS.'/produit/catalog.html.php';
}

function show()
{
    if (!isset($_GET['id']))
    {
        die();
    }

    $produit = Produit::retrieveByPK($_GET['id']);
    include DOSSIER_VIEWS.'/produit/details.html.php';
}

function delete()
{
    if (!isset($_GET['id']))
    {
        die();
    }

    $produit = Produit::retrieveByPK($_GET['id']);
    $produit->delete();
    onVaRediriger('/catalogue');
}

function update()
{
    

    // si il n'y a pas d'id de produit à modifier dans l'url ...
    if (!isset($_GET['id']))
    {
        // ...le programme se termine.
        die();
    }

    // on récupère le produit à modifier depuis la base de donnée
    $produitModif = Produit::retrieveByPK($_GET['id']);
    $messageErreur = null;

    // si on clique sur le bouton Modifier le produit
    if (isset($_POST['btn-valider-modification']))
    {
        // on retourne le resultat de la fonction verifierPayload dans $messageErreur
        $messageErreur = verifierPayload($_POST, $_FILES);
        
        // si toutes les informations sont fournies
        if ($messageErreur === null)
        {
            // on modifie les propriétés du produit
            $produitModif = mettreAJourPayload($produitModif, $_POST, $_FILES);
            // on met à jour les modifications dans la base de donnée
            $produitModif->save();
            onVaRediriger('/catalogue');
        }
    }
   
// on inclut ici la vue pour pouvoir afficher le $produit à modifier
include DOSSIER_VIEWS.'/produit/modifier.html.php';

}