<?php
//Laravel custom helper functions

use App\Relative;
use Illuminate\Support\Str;

function dateFormat($date){
    if($date == null || $date == '')
        return  'NA';
    else
        return  date('d-m-Y',strtotime($date));
}

function dateTimeFormat($date){
    if($date == null || $date == '')
        return  'NA';
    else
        return  date('d-m-Y H:i',strtotime($date));
}

function timeFormat($date){
    if($date == null || $date == '')
        return  'NA';
    else
        return  date('H:i',strtotime($date));
}

function replaceDocumentByKeyWords($list,$document){
    $find       =   array_keys($list);
    $replace    =   array_values($list);
    return  str_ireplace($find, $replace, $document);
}
function slug($value){
    return Str::slug($value, '-');
}