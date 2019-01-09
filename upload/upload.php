<?php
$ds          = DIRECTORY_SEPARATOR;  //1
 
$storeFolder = 'productos';   //2
 
if ( !empty( $_FILES ) ) {
     
    $tempFile = $_FILES['file']['tmp_name'];          //3             
      
    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;  //4
    
    $targetFile =  $targetPath. $_FILES['file']['name'];  //5
 	echo $targetFile;
    move_uploaded_file( $tempFile, $targetFile ); //6 
}
?>