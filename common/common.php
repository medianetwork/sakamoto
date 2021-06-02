<?php

function gengo($seireki)
{
    if(1868 <= $seireki && $seireki <= 1911)
    {
        $gengo = '明治';
    }

    if(1912 <= $seireki && $seireki <= 1925)
    {
        $gengo = '大正';
    }

    if(1926 <= $seireki && $seireki <= 1988)
    {
        $gengo = '明和';
    }

    if(1989 <= $seireki)
    {
        $gengo = '平成';
    }

    return($gengo);
}

function sanitize($before)
{
    foreach($before as $key => $value)
    {
        $after[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
    return $after;
}



function pulldown_year()
{
    print '<select name = "year">';
        print '<option value = "2017">2017</option>';
        print '<option value = "2018">2018</option>';
        print '<option value = "2019">2019</option>';
        print '<option value = "2020">2020</option>';
        print '<option value = "2021">2021</option>';
    print '</select>';
}

function pulldown_month()
{
    print '<select name ="month">';
    
        for($i = 1; $i <= 12; $i++): 
    
            print '<option value = "'.$i.'">'.$i.'</option>';

        endfor;
    print '</select>';
}

function pulldown_day()
{
    print '<select name = "day">';
    
        for($i = 1; $i <= 31; $i++): 
            print '<option value= "'.$i.'"> '.$i.'</option>';
        endfor;
    print '</select>';
}
?>