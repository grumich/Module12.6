<?
//Разбиение 
function getPartsFromFullname($fio){
    $exploted = explode(" ", $fio);
    $seporated = [
        'surname' => $exploted[0],
        'name' => $exploted[1],
        'patronomyc' => $exploted[2],
    ];
    return $seporated;
}

//объединение 
function getFullnameFromParts($surname, $name, $patronomyc){
    $fullName = [$surname, $name, $patronomyc];
    return implode(' ', $fullName);
}
//Сокращение ФИО
function getShortName($fio){
    $seporated = getPartsFromFullname($fio);
    $shortName = $seporated['name']." ".mb_substr($seporated['surname'],0,1).".";
    return $shortName;
  }
//Функция определения пола по ФИО
  function getGenderFromName($fio){
    $seporated = getPartsFromFullname($fio);
    $gender = 0;
        
    // detedt gender by surname
    $surnameGenderV1 = mb_substr($seporated["surname"],-2,2) ;
    $surnameGenderV2 = mb_substr($seporated["surname"],-1,1);
    if ($surnameGenderV1== "ва"){
        $gender1 = -1;
    } elseif ($surnameGenderV2 == "в"){
        $gender1 = 1;
    } else {
        $gender1 = 0;
    }
    
    // detect gender by name
    $genderNameV1 = mb_substr($seporated["name"],-1,1);
        if ($genderNameV1 == "a"){
        $gender2 = -1;
    } elseif ($genderNameV1 == "й" || $genderNameV1 == "н"){
        $gender2 = 1;
    } else {
        $gender2 = 0;
    }


    // detect gender by patronomyc
    $genderPatronomycV1=mb_substr($seporated["patronomyc"],-3,3);
    $genderPatronomycV2=mb_substr($seporated["patronomyc"],-2,2);
    
    if ($genderPatronomycV1 =="вна"){
          $gender3 = -1;
    } elseif ($genderPatronomycV2 == "ич"){
         $gender3 = 1;
    } else {
          $gender3 = 0;
    }
    $gender = $gender1+$gender2+$gender3;
       if ($gender > 0){
        return "Мужской";
    } elseif ($gender < 0){
        return "Женский";
    } else {
        return "Неопределенный пол";
    }

}
//Функция Определение возрастно-полового состава
function getGenderDescription($array){

    $male = array_filter($array, function($array) {
        return (getGenderFromName($array['fullname']) == "Мужской");
    });
    
    $female = array_filter($array, function($array) {
        return (getGenderFromName($array['fullname']) == "Женский");
    });

    $und = array_filter($array, function($array) {
        return (getGenderFromName($array['fullname']) == "Неопределенный пол");
    });

   
    $sum = count($male) + count($female) + count($und);
    $maleCheck =  round(count($male) / $sum * 100,2);
    $femaleCheck = round(count($female) / $sum * 100, 2);
    $undCheck = round(count($und) / $sum  * 100,2);
    
    echo <<<HEREDOC
    <br>
    Гендерный состав аудитории:<br>
    ---------------------------<br>
    Мужчины - $maleCheck%<br>
    Женщины - $femaleCheck%<br>
    Не удалось определить - $undCheck%<br>
HEREDOC;
}
// Функция Идеальный подбор пары
function getPerfectPartner($surname, $name, $patronomyc, $array){

    $fullName = getFullnameFromParts($surname, $name, $patronomyc);

    $fullName = mb_convert_case($fullName, MB_CASE_TITLE );
    $mainGender = getGenderFromName($fullName);   


    $randPerson = $array[rand(0,count($array)-1)]["fullname"];
    $randGender = getGenderFromName($randPerson);
    
   
    while ($mainGender == $randGender || $randGender === "Неопределенный пол"){
        $randPerson = $array[rand(0,count($array)-1)]["fullname"];
        $randGender = getGenderFromName($randPerson);
    }


    $shMainPerson = getShortName($fullName);
    $shRandPerson = getShortName($randPerson);
    $percent = rand(50,100)+rand(0,99)/100;


    echo <<<HEREDOC
    <br><br>
    $shMainPerson + $shRandPerson <br>
    ♡ Идеально на $percent% ♡
HEREDOC;
}
?>