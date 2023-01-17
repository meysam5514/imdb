<?php
error_reporting(0);
header('Content-type: application/json;');
if($_GET['name'] !== null){
$getname = $_GET['name'];

$rep = str_replace([" "],["+"],$getname);               
$get=file_get_contents("https://www.imdb.com/find?q=$rep&ref_=nv_sr_sm");
//========================================================= 
preg_match_all('#class="primary_photo"> <a href="/title/(.*?)/?ref_=fn_al_tt_1" >#',$get,$names);
$filmid = str_replace(["/?"],[""],$names[1][0]);   
//========================================================= 
$get1=file_get_contents("https://www.imdb.com/title/$filmid/?ref_=fn_al_tt_1");
//========================================================= 
preg_match_all('#<title>(.*?)- IMDb</title>#',$get1,$filmname1);
$film= explode("(", $filmname1[1][0]);   
$filmname= $film[0];
$type_year=$film[1];
//========================================================= 
preg_match_all('#{"plotText":{"plainText":"(.*?)","__typename":"Markdown"},"#',$get1,$description1);
$description=$description1[1][0];
//========================================================= 
preg_match_all('#"ratingValue":(.*?)}#',$get1,$rate1);
$rate=$rate1[1][1];
//========================================================= 
preg_match_all('#class="ipc-metadata-list-item__list-content-item">(.*?)</span>#',$get1,$time1);
$time=$time1[1][4];
//========================================================= 
preg_match_all('#"image":"(.*?)",#',$get1,$image1);
$image=$image1[1][0];
//========================================================= 
preg_match_all('#ipc-focusable" href="(.*?)"#',$get1,$trailer1);
$trailer= 'https://www.imdb.com'.$trailer1[1][1];
//========================================================= 
preg_match_all('#"name\":\"(.*?)\"}#',$get1,$creator1);
$creator= $creator1[1][3];
//========================================================= 
preg_match_all('#"genre":(.*?)],#',$get1,$genre1);
$genre3 = str_replace(['","'],["|"],$genre1[1][0]);   
$genre2 = str_replace(['["'],[""],$genre3);   
$genre = str_replace(['"'],[""],$genre2); 
//========================================================= 
preg_match_all('#{"@type":"Person","url":"/name/(.*?)/","name":"(.*?)"}#',$get1,$actor1);
$actor=$actor1[2];
//=========================================================
$filmid = str_replace(["/?"],[""],$names[1][0]);   
$filmname= $film[0];
$type_year=$film[1];
$description=$description1[1][0];
$rate=$rate1[1][1];
$time=$time1[1][4];
$image=$image1[1][0];
$trailer= 'https://www.imdb.com'.$trailer1[1][1];
$creator= $creator1[1][3];
$genre = str_replace(['"'],[""],$genre2); 
$actor=$actor1[2];

//=========================================================
$actorarray = array();   
for($i=1;$i<=count($actor);$i++){
$j=$i-1;
$actorarray["actor$i"]= $actor["$j"];  
}
//========================================================= 
$result = array();    
$result['name']= $filmname;  
$result['id']= $filmid;    
$result['type_year']= $type_year;    
$result['rate']= $rate;    
$result['time']= $time;  
$result['genre']= $genre;  
$result['creator']= $creator;    
$result['actor']= $actorarray; 
$result['description']= $description; 
$result['image']= $image;  
$result['trailer']= $trailer;  
//========================================================= 
echo json_encode(['ok' => true, 'channel' => '@SIDEPATH','writer' => '@meysam_s71',  'Results' =>$result], 448);
//========================================================= 
}else{
echo "inviled parameters ! use 'name' parameter in essential.";
}



