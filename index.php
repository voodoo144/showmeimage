<?php
require 'vendor/autoload.php';
$types=array('png','jpg','jpeg');
$app = new \Slim\Slim();
$app->config(array(
    'debug' => true,
    'templates.path' => 'templates'
));

$app->get('/', function () use ($app) {
    $app->render('_main.php');
});

$app->post('/',function () use ($app,$types) {
    $path=$app->request->post('image_url');
    if ($path!=""){
        $type = pathinfo($path, PATHINFO_EXTENSION);
        if(in_array($type,$types)){
            $data = file_get_contents($path);
            $image = 'data:image/' . $type . ';base64,' . base64_encode($data);
            $app->render('_image.php',array('image'=>$image));
            }
        }
    else{
        $app->render('_main.php');
    }
});

$app->post('/url',function() use ($app,$types){
    $url=$app->request->post('article_url');
    if($url!=""){
        $html = file_get_contents($url);
        $doc = new DOMDocument();
        $searchPage = mb_convert_encoding($html, 'HTML-ENTITIES', "UTF-8"); 
        @$doc->loadHTML($searchPage);
        $tags = $doc->getElementsByTagName('img');
        foreach ($tags as $tag) {
            $oldSrc= $tag->getAttribute('src');
            if(strpos($oldSrc, "/") === 0){
                continue;
            }
            $type = pathinfo($oldSrc, PATHINFO_EXTENSION);
            $image="";
            if(in_array($type,$types)){
                $data = file_get_contents($oldSrc);
                $image = 'data:image/' . $type . ';base64,' . base64_encode($data);
            }
                
            $tag->setAttribute('src',$image);
        }
        echo $doc->saveHTML();
    }
    else{
        $app->render('_main.php');
    }
});

$app->run();

?>
