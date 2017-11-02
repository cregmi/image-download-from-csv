<?php
$path = getcwd();
$row = 1;
$array = array();
$marray = array();
$handle = fopen('file.csv', 'r');
if ($handle !== FALSE) {
    while (($data = fgetcsv($handle, 0, ',')) !== FALSE) {
        if ($row === 1) {
            $num = count($data);
            for ($i = 0; $i < $num; $i++) {
                array_push($array, $data[$i]);
            }
        }
        else {
            $c = 0;
            foreach ($array as $key) {
                $marray[$row - 1][$key] = $data[$c];
                $c++;
            }
        }
        $row++;
    }
}
else
{
    echo '<h2>Error - No /file.csv/ exist</h2>';
    die();
}
fclose('file.csv');

$index = 0; 
$temparray = array();
for($x=1;$x<$row-1;$x++)
{ 
    $sku = $marray[$x]['SKU'];
    $images = $marray[$x]['Images'];
    $html = $marray[$x]['Description'];
    $doc = new DOMDocument();
    $doc->loadHTML($html);
    
    $imageTags = $doc->getElementsByTagName('img');
    foreach($imageTags as $tag) {
        $tmp = $tmp.$tag->getAttribute('src').',';
    }
    $tmp = $tmp.$images;
    $temparray[$sku] = $tmp;
    $tmp = NULL;

}

foreach ($temparray as $sku => $images)
{
    mkdir($path."/".$sku);
    $url = explode(",", $images);
    echo '<h3>Folder created with name "'.$sku.'" , Image URLs found : '.count($url).'</h3>';
    $i = 0;
    $d = 0;
    foreach($url as $key => $value){
        $i = $i + 1;
        if (filter_var($value, FILTER_VALIDATE_URL)){
            $parts = pathinfo($value);
            $filename = $parts['basename'];
            $content = file_get_contents($value);
            echo $i.': '.$value;
            if(!$content){
                echo ' - Error on image fetch';
            }
            else{
                chdir($path."/".$sku); 
                $download = file_put_contents($filename, $content);
                if($download=== FALSE){
                    echo ' - Error on image download';
                }
                else{
                    echo ' - Image downloaded, '.($download/1024).'kb';
                    $d = $d + 1;
                }  
            }
            echo '</br>';
        }
        else{
            echo $i.': '.$value.' is not a valid URL</br>';
        }                      
    }
    echo '<u>'.$d.' images downloaded in folder '.$sku.'</u>';
}

?>
