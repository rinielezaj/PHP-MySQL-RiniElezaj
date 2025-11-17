<?php

// $num=1;

// if($num<0){
//     echo "$num is less than 0";
// }

// $age=15;
// if($age<0){
//     echo "You are under 20";
// }else{
//     echo "You are an adult";
// }

// $age=15;
// if(($age<12) && ($age<20)){
//     echo "You are a teenager";
// }

// if (($age<12) || ($age<20)){
//     echo "You are an adult";
// }

// $num1=23;
// $num2=23;

// if ($num1==$num2){
//     echo "Yes";
// }else{
//     echo "No";
// }


// $age=15;
// switch($age){
//     case($age>=0 && $age<18):
//         echo "You are a minor";
//         break;
//     case($age>=18 && $age<25):
//         echo "You are a young adult";
//         break;
//     case($age>=25):
//         echo "You are an adult";
//         break;

//     default:
//         echo "Invalid age";
//         break;
// }


// $x=1;

// while($x<=5){
//     echo "The number is:$x <br>";

//     $x=$x+1;
// }

// do{
//     echo "The number is:$x <br>";
//     // $x=$x+1;
//     $x++;
// }while($x<=5);

for ($x=0;$x<=10;$x++){
    // echo "The number is:$x <br>";
}

$cars=['BMW','Audi','VW','Tesla'];
foreach($cars as $value){
    // echo "$value <br>"
}

$age=["John"=>'18','Geat'=>'12','Rini'=>'16'];

foreach($age as $x=>$val){
    echo "$x=$val <br>";
}



?>