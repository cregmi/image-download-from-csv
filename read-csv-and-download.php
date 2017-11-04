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
    $html = $marray[$x]['Product_Description_1'];
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

function get_raw_url($url_string){
  $parts = parse_url($url_string);
  $path_parts = array_map('rawurldecode', explode('/', $parts['path']));

  return
    $parts['scheme'] . '://' .
    $parts['host'] .
    implode('/', array_map('rawurlencode', $path_parts))
  ;
}

foreach ($temparray as $sku => $images)
{
    mkdir($path."/".$sku);
    chdir($path."/".$sku);
    $url = explode(",", $images);
    echo '<h4>Folder created with name <u>'.$sku.'</u> , Image URLs found : '.count($url).'</h4>';
    $i = 0;
    $d = 0;
    foreach($url as $key => $value){
        $value = str_replace(' ', '%20',(trim($value,' ')));
        $i = $i + 1;
        echo $i.': '.$value;
        if (filter_var($value, FILTER_VALIDATE_URL)){
            $parts = pathinfo($value);
            $filename = $parts['basename'];
            if (!file_exists($filename)){
                $content = file_get_contents($value);
                if(!$content){
                    echo ' - Error on image fetch';
                }
                else{
                     
                    $download = file_put_contents($filename, $content);
                    if($download=== FALSE){
                        echo ' - Error on image download';
                    }
                    else{
                        echo '<span style = "color:green"> - Image downloaded, '.($download/1024).'kb</span>';
                        $d = $d + 1;
                    }  
                }
                
            }
            else{
                echo '<span style = "color:red"> - Duplicate file, download aborted</span>';
            }

            echo '</br>';
        }
        else{
            echo '<span style = "color:red"> - Not a valid URL</span></br>';
        }                      
    }
    echo '<h5>'.$d.' images downloaded in folder '.$sku.'</h5>';
}

?>
