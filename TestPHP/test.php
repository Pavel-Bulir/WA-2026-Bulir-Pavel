<?php
$name = "";
$message = "";
$age = 0;


if($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["my-name"];
    if($name == "Pavel") {
        $message = "Ahoj Pavle";
        $age = $_POST["my-age"];
    }
    else {
        $message = "Neznám tě";

    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Test formuláře</h1>  
    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nostrum repudiandae excepturi praesentium eligendi eaque recusandae error eum veritatis accusamus officia et nisi quidem nihil illum, numquam optio dignissimos odio temporibus.</p>
    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Laudantium distinctio amet ipsum deleniti facilis sunt labore deserunt temporibus omnis et autem, explicabo doloremque dolore accusantium, quod ipsam illum pariatur voluptate!</p>
    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sed necessitatibus labore possimus similique cupiditate quam officia quibusdam a voluptas facere ab aspernatur omnis, exercitationem laboriosam eos mollitia, natus in placeat!</p>
    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sequi ipsam accusamus expedita voluptatum, fugit quae amet aperiam quis assumenda neque sunt. Quia libero debitis sunt aspernatur ex pariatur quidem soluta?</p>
    <form method="post">
        <input type="text" name ="my-name" placeholder="Zadejte jméno">
        <input type="number" name = "my-age" placeholder="Zadejte věk">
        <button type="submit">Odeslat</button>
    </form>

    <p>
        <?php  
        echo "Výstup";
        echo $message;
         ?>
    </p>
    <p>
        <?php
        echo "Tvůj věk: ";
        echo $age;
        
        ?>

    </p>

</body>
</html>