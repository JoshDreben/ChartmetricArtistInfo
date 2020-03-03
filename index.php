<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Spotify Artist Checker</title>
        <link rel="stylesheet" type="text/css" href="style/main.css">
        <?php include "scripts/artist-lookup.php";?>
    </head>

    <?php $artist = new SpotifyChecker(1392148);?>

    <body>
        <div class="artist-info-container">
            <div class="artist-item artist-item-name">
                <?php echo $artist->_artistname; ?>
            </div>
            <div class="artist-item artist-item-followers">
                <?php echo $artist->_artistf; ?>
            </div>
            <div class="artist-item artist-item-monthly-listeners">
                <?php echo $artist->_artistml; ?>
            </div>
        </div>
    </body>
</html>
