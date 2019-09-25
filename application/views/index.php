<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />

    <title><?=$title?></title>
    <link href="/media/bootstrap/css/bootstrap-reboot.css" rel="stylesheet" />
    <link href="/media/bootstrap/css/bootstrap.css" rel="stylesheet" />
    <link href="/media/css/common.css" rel="stylesheet" />
    
    <script src="/media/js/jquery-3.4.1.min.js"></script>
    <script src="/media/bootstrap/js/bootstrap.bundle.min.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header >
        <div class="container-fluid">
            <div class="container d-flex flex-row">
                <h1 class="flex-grow-1"><?=$title?></h1>
                <div>
                    <?php if(isset($_SESSION["guard"])):?>
                        <a class="btn btn-info" href="/admin/logout">logout</a>
                    <?php else:?>
                        <a class="btn btn-info" href="/admin/login">Login</a>
                    <?php endif;?>

                    
                </div>
            </div>
        </div>
    </header>
    <section class="container-fluid">
        <div class="container">
            <?=$content?>
        </div>
    </section>
    
</body>
</html>