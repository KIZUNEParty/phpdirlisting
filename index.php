<!-- Thanks for icons from https://svgrepo.com -->

<?php
function ext($file)
{
    if (is_dir($file)) {
        return 'dir';
    } else {
        return str_replace('7z', 'sevenz', strtolower(pathinfo($file)['extension']));
    }
}

function human_filesize($file)
{
    $bytes = filesize($file);
    $decimals = 1;
    $factor = floor((strlen($bytes) - 1) / 3);
    if ($factor > 0) $sz = 'KMGT';
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor - 1] . 'B';
}

$files = scandir('.');
$exclude = array(
    '.',
    '..',
    '.DS_Store',
    'index.php',
    'index.html',
    'icon',
    'component',
    '.git',
    '.gitmodules',
    '.gitignore',
    'node_modules'
);

foreach ($exclude as $ex) {
    if (($key = array_search($ex, $files)) !== false) {
        unset($files[$key]);
    }
}

$jsoncall = file_get_contents('component/main.json');
$decode = json_decode($jsoncall, true);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $decode['name'] ?></title>

    <meta name="description" content="<?php echo $decode['desc']; ?>">
    <meta name="author" content="<?php echo $decode['author']; ?>">
    <meta property="og:type" content="<?php echo $decode['ogtype']; ?>">
    <meta property="og:image" content="<?php echo $decode['ogimg']; ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=<?php echo $decode['font'] ?>:wght@<?php echo $decode['weight'] ?>&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="<?php echo $decode['icon'] ?>" type="image/x-icon">
    <link rel="stylesheet" href="component/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <style>
        html,
        body {
            font-family: '<?php echo $decode['font'] ?>', <?php echo $decode['fonttype']; ?>;
        }

        .cover {
            width: 100vw;
            height: 100vh;
            background-image: url('<?php echo $decode['bodybg']; ?>');
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
        }
    </style>
</head>

<body>
    <div class="cover">
        <div class="holder">
            <div class="middle">
                <center>
                    <div class="card bg-dark text-white">
                        <div class="card-body">
                            <div class="card-header">
                                <h1>
                                    <u>
                                        <?php
                                        echo $decode['name'];
                                        ?>
                                    </u>
                                </h1>
                            </div>
                            <div class="card-text">
                                <?php
                                if (!empty($files)) {
                                    foreach ($files as $file) {
                                ?>
                                        <a href="<?php echo "./" . $file; ?>" class="control">
                                            <span>
                                                <img class="icon" src="component/icon/<?php echo ext($file); ?>.svg" alt="">
                                            </span>
                                            <span class="name">
                                                <?php
                                                echo $file;
                                                ?>
                                            </span>
                                        </a>
                                        <span class="filesize">
                                            <?php
                                            if (ext($file) == 'dir') {
                                                echo "";
                                            } else {
                                                echo human_filesize($file);
                                            }
                                            ?>
                                        </span>
                                        <br>
                                <?php
                                    }
                                } else {
                                    echo "<b>NO FILE FOUND HERE!</b>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </center>
            </div>
        </div>
    </div>

    <!-- Script Embed -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
</body>

</html>