<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="wrapper">
        <h1>Purchase</h1>
        <?php
        if (isset($_GET['msg'])) {
            $message = $_GET['msg'];
        }else if(isset($_GET['username']) && isset($_GET['password'])) {
            $message = "";
            $username = $_GET['username'];
            $password = $_GET['password'];
        }else {
            $message = "";
            $username = "";
            $password = "";
        }
        
        ?>
        
        
        
        <h4><?php echo $message ?></h4>
        <h4><?php echo $username ?></h4>
        <h4><?php echo $password ?></h4>
    
</body>
</html>