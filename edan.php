<?php
error_reporting(0);
ini_set('display_errors', 0);

if ($argc < 3) {
    echo "\nUsage: edan [encode|decode] \"string\" [shift]\n";
    exit;
}

$mode  = strtolower($argv[1]);
$input = $argv[2];
$shift = isset($argv[3]) ? (int)$argv[3] : 3;

// Master list untuk menjaga urutan tetap konsisten
$keys = [
    "Base64", "Base64URL", "URL Encode", "Hexadecimal", "Decimal", 
    "Binary", "Base32", "ROT13", "Morse Code", "Caesar", 
    "UUEncode", "JSON", "SHA256", "MD5", "Reversed"
];

$results = [];

if ($mode == 'encode') {
    $results["Base64"]      = base64_encode($input);
    $results["Base64URL"]   = str_replace(['+','/','='], ['-','_',''], base64_encode($input));
    $results["URL Encode"]  = urlencode($input);
    $results["Hexadecimal"] = bin2hex($input);
    $results["Decimal"]     = implode(' ', array_map('ord', str_split($input)));
    $results["Binary"]      = binary_encode($input);
    $results["Base32"]      = base32_encode($input);
    $results["ROT13"]       = str_rot13($input);
    $results["Morse Code"]  = morse_encode($input);
    $results["Caesar"]      = caesar_encode($input, $shift);
    $results["UUEncode"]    = convert_uuencode($input);
    $results["JSON"]        = json_encode($input);
    $results["SHA256"]      = hash('sha256', $input);
    $results["MD5"]         = md5($input);
    $results["Reversed"]    = strrev($input);
} else {
    $results["Base64"]      = @base64_decode($input);
    $results["Base64URL"]   = @base64_decode(str_replace(['-','_'], ['+','/'], $input));
    $results["URL Encode"]  = urldecode($input);
    $results["Hexadecimal"] = (@hex2bin($input) ?: "");
    $results["Decimal"]     = decimal_decode($input);
    $results["Binary"]      = @binary_decode($input);
    $results["Base32"]      = @base32_decode($input);
    $results["ROT13"]       = str_rot13($input);
    $results["Morse Code"]  = morse_decode($input);
    $results["Caesar"]      = caesar_decode($input, $shift);
    $results["UUEncode"]    = @convert_uudecode($input);
    $results["JSON"]        = @json_decode($input) ? "Decoded successfully" : ""; 
    $results["SHA256"]      = "[One-way Hash]";
    $results["MD5"]         = "[One-way Hash]";
    $results["Reversed"]    = strrev($input);
}

echo "\n ".strtoupper($mode)." by. EDAN (Encode Decode Automation Nih)\n\n";
foreach ($keys as $key) {
    $val = trim($results[$key]);
    if ($val !== "" && $val !== "[One-way Hash]") {
        printf(" %-15s : %s\n", $key, $val);
    } elseif ($val === "[One-way Hash]") {
        printf(" %-15s : %s\n", $key, $val);
    }
}

// --- CORE FUNCTIONS (Silent) ---
function base32_encode($d){
    $a='ABCDEFGHIJKLMNOPQRSTUVWXYZ234567'; $b=''; $e='';
    foreach(str_split($d) as $c) $b.=str_pad(decbin(ord($c)),8,'0',STR_PAD_LEFT);
    $b=str_pad($b,ceil(strlen($b)/5)*5,'0',STR_PAD_RIGHT);
    for($i=0;$i<strlen($b);$i+=5) $e.=$a[bindec(substr($b,$i,5))];
    return $e;
}
function base32_decode($d){
    $a='ABCDEFGHIJKLMNOPQRSTUVWXYZ234567'; $b=''; $e='';
    foreach(str_split(strtoupper($d)) as $c){
        $p=strpos($a,$c); if($p!==false) $b.=str_pad(decbin($p),5,'0',STR_PAD_LEFT);
    }
    for($i=0;$i<strlen($b);$i+=8){
        $k=substr($b,$i,8); if(strlen($k)==8) $e.=chr(bindec($k));
    }
    return $e;
}
function binary_encode($d){
    $r=''; foreach(str_split($d) as $c) $r.=str_pad(decbin(ord($c)),8,'0',STR_PAD_LEFT).' ';
    return trim($r);
}
function binary_decode($d){
    $b=preg_replace('/[^01]/','',$d); $r='';
    for($i=0;$i<strlen($b);$i+=8){
        $k=substr($b,$i,8); if(strlen($k)==8) $r.=chr(@bindec($k));
    }
    return $r;
}
function decimal_decode($d){
    $r=''; foreach(explode(' ',trim($d)) as $p) if(is_numeric($p)) $r.=chr((int)$p);
    return $r;
}
function morse_encode($d){
    $m=['A'=>".-",'B'=>"-...",'C'=>"-.-.",'D'=>"-..",'E'=>".",'F'=>"..-.",'G'=>"--.",'H'=>"....",'I'=>"..",'J'=>".---",'K'=>"-.-",'L'=>".-..",'M'=>"--",'N'=>"-.",'O'=>"---",'P'=>".--.",'Q'=>"--.-",'R'=>".-.",'S'=>"...",'T'=>"-",'U'=>"..-",'V'=>"...-",'W'=>".--",'X'=>"-..-",'Y'=>"-.--",'Z'=>"--..",'0'=>'-----','1'=>'.----','2'=>'..---','3'=>'...--','4'=>'....-','5'=>'.....','6'=>'-....','7'=>'--...','8'=>'---..','9'=>'----.',' '=>'/'];
    $r=[]; foreach(str_split(strtoupper($d)) as $c) if(isset($m[$c])) $r[]=$m[$c];
    return implode(' ', $r);
}
function morse_decode($d){
    $m=array_flip(['A'=>".-",'B'=>"-...",'C'=>"-.-.",'D'=>"-..",'E'=>".",'F'=>"..-.",'G'=>"--.",'H'=>"....",'I'=>"..",'J'=>".---",'K'=>"-.-",'L'=>".-..",'M'=>"--",'N'=>"-.",'O'=>"---",'P'=>".--.",'Q'=>"--.-",'R'=>".-.",'S'=>"...",'T'=>"-",'U'=>"..-",'V'=>"...-",'W'=>".--",'X'=>"-..-",'Y'=>"-.--",'Z'=>"--..",'0'=>'-----','1'=>'.----','2'=>'..---','3'=>'...--','4'=>'....-','5'=>'.....','6'=>'-....','7'=>'--...','8'=>'---..','9'=>'----.',' '=>'/']);
    $r=''; foreach(explode(' ',$d) as $c) if(isset($m[$c])) $r.=$m[$c];
    return $r;
}
function caesar_encode($i,$s){
    $r=""; foreach(str_split($i) as $c){
        if(ctype_alpha($c)){
            $b=ctype_upper($c)?65:97; $r.=chr(($s+ord($c)-$b)%26+$b);
        } else $r.=$c;
    } return $r;
}
function caesar_decode($i,$s){ return caesar_encode($i,26-($s%26)); }
