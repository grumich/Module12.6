<?php

include "main.php";


//Разбиение 
foreach ($persons_array  as $key=>$val) {
	
    $Fio = $persons_array[$key]['fullname'] . '<br>';
    $seporated = getPartsFromFullname($Fio);

    echo $seporated['surname']." ";
    echo "<br/>";
    echo $seporated['name']." ";
    echo "<br/>";
    echo $seporated['patronomyc'];
    echo "<br/>";
}

//объединение 
foreach ($persons_array  as $key=>$val) {

$Fio = $persons_array[$key]['fullname'] . '<br>';
$seporated = getPartsFromFullname($Fio);
$tr = getFullnameFromParts($seporated['surname'],$seporated['name'],$seporated['patronomyc']);
echo $tr;

}
//Сокращение ФИО
echo '<br>';
foreach ($persons_array  as $key=>$val) {
$Fio = $persons_array[$key]['fullname'] . '<br>';
$shortName=getShortName($Fio);
echo $shortName. '<br>';
}
//Функция определения пола по ФИО
echo '<br>';
foreach ($persons_array  as $key=>$val) {
$Fio = $persons_array[$key]['fullname'];
$Gender=getGenderFromName($Fio);
echo $Gender. '<br>';
}
//Определение возрастно-полового состава
getGenderDescription($persons_array);

//Идеальный подбор пары
getPerfectPartner("АлександРоВ","ГенаДий","ГриГоРьевиЧ",$persons_array);
getPerfectPartner("АлександРоВа","Инна","ГриГоРьевнА",$persons_array);

?>