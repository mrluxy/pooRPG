<?php
function autoLoadClasses($classe)
{
    require ("classes/".$classe.".php");
}
spl_autoload_register('autoLoadClasses');
function SDL()
{
    echo("<br/>");
}
function fight($C1, $C2)
{
    $i=1;
    while($C1->getHealth() > 0 && $C2->getHealth() > 0)
    {
        echo("<div class='element'>");
        if($i%2 == 0)
        {
            $dmg=$C1->hit();
            $C2->getHit($dmg);
        }
        else
        {
            $dmg=$C2->hit();
            $C1->getHit($dmg);
        }
        $i++;
        echo("</div>");
    }
    echo("<div class='element title'>");
    if($C1->getHealth()>0 && $C2->getHealth()<=0)
    {
        echo("<p>".$C1->getNameHUD()." à gagné !</p>");
    }
    elseif($C2->getHealth()>0 && $C1->getHealth()<=0)
    {
        echo("<p>".$C2->getNameHUD()." à gagné !</p>");
    }
    else
    {
        echo("<p>C'est un match nul, Personne n'a gagné !</p>");
    }
    echo("</div>");
}

//public function __construct($name, $health, $armor, $power, $weapon, $speed)
if(rand(1,2) == 1)
{
    $PNJ1 = new Wizard("Merlin",rand(1000,3500),rand(5,25),rand(25,50),rand(1,4));
}
else
{
    $PNJ1 = new Warrior("Lancelot",rand(1000,3500),rand(5,25),rand(200,400));
}
if(rand(1,2) == 1)
{
    $PNJ2 = new Warrior("Aragorn",rand(1000,3500),rand(5,25),rand(200,400));
}
else
{
    $PNJ2 = new Wizard("Gandalf",rand(1000,3500),rand(5,25),rand(25,50),rand(1,4));
}

//

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles.css">
    <title>Document</title>
</head>
<body>
<div class="container">
<?php
echo("<div class='element title'>");
$PNJ1->getAll();
echo("</div>");
echo("<div class='element title'>");
$PNJ2->getAll();
echo("</div>");

echo("<div class='element title'>");
echo("<p>Un combat commence entre ".$PNJ1->getNameHUD()." et ".$PNJ2->getNameHUD().".<br/><br/><b>QUE LE MEILLEUR GAGNE !</b></p>");
echo("</div>");
fight($PNJ1, $PNJ2);
?>
</div>
</body>
</html>


