<?php
$url = "https://twitter.com/search?f=tweets&vertical=default&q=%23SPARSAISTS&src=typd";
$ch = curl_init();
curl_setopt($ch  , CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
$data = curl_exec($ch); 
curl_close($ch);  
libxml_use_internal_errors(TRUE);
$doc = new DOMDocument();
$doc->loadHTML($data);
libxml_clear_errors();
$xpath = new DOMXpath($doc);

$elements = $xpath->query("//div[@id='timeline']");
$a=array(); 
if (!is_null($elements)) {
    foreach ($elements as $element) {
        $nodes = $element->childNodes;
        $bad = array("More","Copy link to Tweet","Embed Tweet","Reply","Retweet","· Details");
        foreach ($nodes as $node) {
            if(trim($node->nodeValue) == ""){
            }else{
                $r = explode(chr(10), $node->nodeValue);

                $nodeData = "";
                $skip = false;
                foreach ($r as $node) {
                    if(trim($node) != ""){
                        //echo $node;
                        if($skip==True){
                            $skip = False;
                            continue;            
                        }
                        if(trim($node) == "Retweeted"){
                            array_push($a,$nodeData);
                            $nodeData = "";
                        }elseif(in_array(trim($node),$bad) == TRUE){
                            continue;     
                        }elseif(in_array(trim($node),array("Like","Liked")) == TRUE){
                            $skip=True;
                            continue;                              
                        }else{

                            $nodeData .= trim($node) . "\n";
                        }
                    }
                }      
            }
        }
    }
}
echo '<div id="tweets" width=30px;>';
$gotSomething = False;
foreach($a as $node){
    $t = explode(chr(10),$node);

    if(mb_strpos($t[1],'@') === False){
        array_shift ( $t );
 	array_shift ( $t );
    }
    $t[1] = mb_substr($t[1],2,mb_strlen($t[1]));
    $out1 = strpos($t[2],'m');
    $out2 = strpos($t[2],'h');
    $out3 = strpos($t[2],'d');
    $out1 = $out1 + $out2 + $out3;
    $t[2] =  substr($t[2],0,$out1+1);
    echo '<div id="tweet">';
    echo '  <div id="image"><img width=28px height=28px style="float:left;" src="images/globe.png"></div>';
    echo '  <div style="float:left;" id="tweetText">';
        echo '<b>'.$t[0].' </b><br>' ;
        echo '<i>' . $t[1] . ' ' . $t[2] . '</i><br>' ;
        echo wordwrap($t[3],25,"<br>",TRUE);
    echo '  </div><br><br>';
    echo '</div><br><br><br>';
    if(!empty($t[3])){
	$gotSomething = True;
    }
}
if(!$gotSomething){
echo "Sorry no Tweets";
}
?>
