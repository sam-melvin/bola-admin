<?php
// $apdate = "6/23/2021";
// $apdate = date_create($apdate);
//     $getdate = date_format($apdate,"F j, Y");
//     $getsubject = "Approved appointment";
//     $getmessage = "The request of your appointment on ".$getdate." have been approved";
//     echo $getmessage;


// $personJSON = '[{"betnumber":"123","straight":500,"rumbled":600},{"betnumber":"321","straight":350,"rumbled":300},{"betnumber":"456","straight":650,"rumbled":740},{"betnumber":"789","straight":150,"rumbled":200}]';

// $person = json_decode($personJSON);

// echo $person->betnumber;

// $date = new DateTime('2022-05-22 00:50:44');

// echo $date->format('Y/m/d H:i:s') . "<br>";

// $date->setTime(0,0);

// echo $date->format('Y-m-d H:i:s') . "<br>";

// $profic = (49.00) - (5000.00);

// echo $profic;
// echo $dateNow . "<br />";
// echo $datefrom . "<br />";


// for($x=0;$x < 1000; $x++){
//     $cnt= strlen($x);
//     if($cnt == 1)
//         $x = '00' . $x;
//     else if($cnt == 2)
//         $x = '0'.$x;

//     echo $x."<br />";

// }


echo 'PHP_SELF:' . $_SERVER['PHP_SELF'];
echo "<br>";
echo 'REMOTE_ADDR:' .$_SERVER['REMOTE_ADDR'];
echo "<br>";
echo 'HTTP_HOST:' .$_SERVER['HTTP_HOST'];
echo "<br>";
echo 'HTTP_REFERER:' .$_SERVER['HTTP_REFERER'];
echo "<br>";
echo 'HTTP_USER_AGENT:' .$_SERVER['HTTP_USER_AGENT'];
echo "<br>";
echo 'SCRIPT_NAME:' .$_SERVER['SCRIPT_NAME'];

?>