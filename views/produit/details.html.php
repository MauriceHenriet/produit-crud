<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
</head>

<body>

    <div class="container">
        <h1 class="display-4 text-center"><?php echo $produit->nom; ?></h1>
        <div class="row">
            <div class="col">
                <?php echo $produit->description; ?>

            </div>
            <div class="col">
                <img class="w-100" src="/produit-crud/<?php echo $produit->image ?>" />
                
            </div>
            <div class="col">
                <?php echo $produit->prix; ?> euros

            </div>
            <div class="col">
                <div class="m-3">
                    <a href="https://www.paypal.com/paypalme/galaxylinq/<?php echo $produit->prix ?>" class="btn btn-primary" target="_blank">Acheter maintenant</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous">
    </script>
</body>

</html>