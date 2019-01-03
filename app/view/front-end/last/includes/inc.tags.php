<?php 
if($_GET['cat']){?>
<br/>
<div id="tags"> <?php 

    if(is_array($obj_categoria->__get("_tags")) ){
        //$totags = count($obj_categoria->__get("_tags"));
        $i = 0; 
        //mt_srand(time());
        foreach ($obj_categoria->__get("_tags") as $key => $value) {            
            $r = mt_rand(1,9);
            echo "<a href='".$_config['server']['url']."?q=".str_replace(" ","+",utf8_decode($value["texto"]))."' class='t".$r."' > ". utf8_decode($value["texto"]) ."</a> -  ";
            $i++;
        }        
    }
    //print_r($obj_categoria)
    ?>
    </div>    
<br/>
<?php 
}
?>