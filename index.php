<?php
session_start();
$con= mysqli_connect("localhost","root","","e");
if(!$con){
    die("connection failed". mysqli_connect_error());
}
if(isset($_POST['upload'])){

   // $file=rand(1000,100000)."-".$_FILES['file']['name']; this can we use for unique name for every repeatative image
   $file=$_FILES['file']['name'];
    $file_loc=$_FILES['file']['tmp_name'];
    $file_size= $_FILES['file']['size'];
    $file_type=$_FILES['file']['type'];
    $folder="upload/";
    //new file size in KB
    $new_size=$file_size/1024;

    //make file name in lower case
    $new_file_name=strtolower($file);


    $final_file=str_replace(' ','-',$new_file_name);


    if(move_uploaded_file($file_loc,$folder.$final_file)){
        //$sql=;
        $res=mysqli_query($con,"INSERT INTO img(file_name,type,size) VALUES('$final_file','$file_type','$new_size')");
        if($res){
        echo "<h4>successfully uploaded.....!!</h4>";
        
        }
        
    }
    //else{
      //  echo "Error";
    //}
    header("location: index.php");
exit;
    $con->close();   
}


?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>image</title>
    <style>
        .container{
    width: 40%;
    text-align: center;
    
    margin:13px auto;
    background-color: aquamarine;
    padding:20px;

}
    </style>

</head>
<body>
    <div class="container">
        <h2>Adding Image</h2>
        <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="file" id="name">
        <button type="submit" name="upload">upload</button>
        </form>
    </div>

    <div class="container">
        <h3>Showing Images from database</h3>
        <div class="img-box">
    <?php
        $con= mysqli_connect("localhost","root","","e");
        if(!$con){
            die("connection failed". mysqli_connect_error());
        }

    $file_path = 'upload/';
        
        $image_query = mysqli_query($con,"select file_name from img");
        while($rows = mysqli_fetch_array($image_query))
        {
            $file_name = $rows['file_name'];
            //$img_src = $rows['img_path'];
        ?>

        <div class="img-block">
        <img src="<?php echo $file_path.$file_name; ?>" alt="" title="<?php echo $file_name; ?>" width="300" height="200" class="img-responsive" />
        <p><strong><?php echo $file_name; ?></strong></p>
        </div>

        <?php
        }
        $con->close();
    ?>
        </div>
    </div>
    
</body>
</html>