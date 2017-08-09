<?php

session_start();
if (isset($_GET['page'])){

    if($_GET['page']=="out"){
        $_SESSION['loggedin']=false;
        header("Location: index.php");
    }
}
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin']==false){
    header("Location: index.php");
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="./admincss/adminstyle.css">
    <title>ADMIN | <?php if(isset($_GET['page'])){
        switch($_GET['page']){
            case 'add': echo'ADD'; $homc=''; $addc='my'; $gridc=''; break;
            case 'home': echo 'HOME'; $homc='my'; $addc=''; $gridc=''; break;
            default : echo "CATEGORIES"; $yes='my'; break;
        }}
        else{ echo 'HOME'; $homc='my';}
        ?></title>
</head>
<body>
<div id="container">

    <div id="header">
        <h3>LIBRARY ADMIN PAGE</h3>
        <nav>

            <a id="<?php echo $homc;?>" href="admin.php?page=home&pg=1">HOME</a>
            <a id="<?php echo $addc;?>" href="admin.php?page=add">ADD</a>
            <a id="<?php echo $yes;?>" href="admin.php?page=cat">CATEGORIES</a>
            <a href="admin.php?page=out">LOG OUT</a>

        </nav>
    </div>

    <div id="content">
<?php
    if (isset($_GET['page'])){
        if($_GET['page']=='home'){
            if(isset($_GET['message'])){
                ?><h3 style="text-align: center"><?php echo $_GET['message']?> </h3><?php
            }
            if(isset($_GET['pg']) && $_GET['pg']>0 && ctype_digit($_GET['pg'])){
            $current_page=$_GET['pg'];
            }else $current_page=1;
            $number_of_results_per_page =4;
            $con=mysqli_connect("localhost","root","","library");
            // Check connection
            if (mysqli_connect_errno())
            {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
            $resultg = mysqli_query($con,"SELECT * FROM book_data");
             $number_of_entries=mysqli_num_rows($resultg);
             $number_of_pages= ceil($number_of_entries/$number_of_results_per_page);
             $first_limit=($current_page-1)*$number_of_results_per_page;

             $querypage="SELECT * FROM book_data"." ORDER BY featured DESC LIMIT ".$first_limit . ',' .$number_of_results_per_page;

            $result=mysqli_query($con,$querypage);


            ?>
            <div id="selector">
            <?php
            for($i=1; $i<=$number_of_pages; $i++){
                ?>
                <a href="admin.php?page=home&pg=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php
            }
            ?>

            </div>
            <table id="table" align="center">
                <tr>
                    <th colspan="9">BOOKS AVAILABLE</th>
                </tr>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Author</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Featured</th>
                    <th colspan="2">Action</th>
                </tr>
            <?php

            $counter=$first_limit;
            while($row = mysqli_fetch_array($result))
            {   if($row['featured']==1){
                $f="YES";
            }else{
                $f="NO";
            }
                echo "<tr>";
                echo "<td>" .++$counter. "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['author'] . "</td>";
                echo "<td>" . $row['category'] . "</td>";
                echo "<td>" . $row['price'] . "</td>";
                echo "<td>";?><a href="./<?php echo $row['img'];?>"><img height="50" width="50" src="./<?php echo $row['img'];?>"></a><?php echo "</td>";
                echo "<td>" . $f . "</td>";
                echo "<td>"?><a href="admin.php?action=edit&which=<?php echo $row['id']; ?>" class="actbut">EDIT</a> <?php echo "</td>";
                echo "<td>"?><a href="admin.php?action=delete&which=<?php echo $row['id']; ?>" class="actbut">DELETE</a> <?php echo "</td>";
                echo "</tr>";
            }

            ?>
            </table>

            <?php

        }
        elseif($_GET['page']=='add'){
            $connection=mysqli_connect("localhost","root","","library");
            // Check connection
            if (mysqli_connect_errno())
            {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
            $disablequery="SELECT * FROM book_data WHERE featured = \"1\"";
            $resultdis= mysqli_query($connection,$disablequery);
            if(mysqli_num_rows($resultdis)>=6){
                $disable='disabled';
            }else{
                $disable='';
            }


          ?><h1 style="text-align: center">ADD NEW BOOKS</h1>
            <form method="post" id="addform" action="admin.php?page=add" enctype="multipart/form-data">
                <label>NAME </label>
                <input type="text" name="aname" value="<?php if(isset($_POST['aname'])) { echo $_POST['aname'];}?>"></input></br>
                <label>AUTHOR </label>
                <input type="text" name="aauthor" value="<?php if(isset($_POST['aauthor'])) { echo $_POST['aauthor'];}?>"></input><br>
                <label>CATEGORY </label>
                <select name="category">
                    <option selected="selected" disabled="disabled">Select a Category</option>
                    <?php
                        $catquery="SELECT * FROM category";
                        $getcat=mysqli_query($connection,$catquery);
                        while($row=mysqli_fetch_assoc($getcat)){
                            ?>
                            <option value="<?php echo $row['category'];?>"><?php echo $row['category'];?></option>
                            <?php
                        }
                    ?>


                </select><br>
                <label>PRICE </label>
                <input type="text" name="aprice" value="<?php if(isset($_POST['aprice'])) { echo $_POST['aprice'];}?>"></input><br>
                <label>IMAGE </label>
                <input type="file" name="aimage" ><br>
                <label>FEATURED </label>
                <input type="checkbox" <?php echo $disable?> value="1" name="featured" ><br>
                <input type="submit" value="ADD">

            </form>


            <?php

            if(isset($_POST['aname']) && isset($_POST['aauthor']) && isset($_POST['aprice'])){
                if(!isset($_POST['featured'])){
                    $featuring='0';
                }else{
                    $featuring='1';
                }
                if($_POST['aname']==""){ ?><h3 style="text-align: center">PLEASE ENTER VALID NAME</h3><?php
                exit();
                }
                if($_POST['aauthor']==""){ ?><h3 style="text-align: center">PLEASE ENTER VALID AUTHOR'S NAME</h3><?php
                exit();
                }
                if($_POST['aprice']==""){ ?><h3 style="text-align: center">PLEASE ENTER VALID PRICE</h3><?php
                exit();
                }
                if(!isset($_POST['category'])){ ?><h3 style="text-align: center">PLEASE ENTER VALID CATEGORY</h3><?php
                    exit();
                }

                $con=mysqli_connect("localhost","root","","library");
                // Check connection
                if (mysqli_connect_errno())
                {
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                }
                srand(mktime());
                $pathhelp=rand().$_FILES['aimage']['name'];
                $path="upload/".$pathhelp;

                move_uploaded_file($_FILES['aimage']['tmp_name'],$path);


                $src= $path;
                $dest="thumb/".$pathhelp;

                $desired_width="100";
                make_thumb($src, $dest, $desired_width);




                $addquery="INSERT INTO book_data (name, author, price, img, category, featured) 
             VALUES('".$_POST['aname']."', '".$_POST['aauthor']."', '".$_POST['aprice']."','".$path."','".$_POST['category']."','".$featuring."')";
             $book =   mysqli_query($con,$addquery) or trigger_error(mysqli_error()." in ".$addquery);
                if ($book){
                    header('Location: admin.php?page=home&pg=1&message=BOOK SUCCESSFULLY ADDED');
                }
            }

        }else if($_GET['page']='cat'){ ?><h1 style="text-align: center">ADD NEW CATEGORY</h1><?php

                    if(isset($_GET['message'])){
                        ?><h3 style="text-align: center"><?php echo $_GET['message']?> </h3><?php
                    }
            $con=mysqli_connect("localhost","root","","library");
            // Check connection
            if (mysqli_connect_errno())
            {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
            $result = mysqli_query($con,"SELECT * FROM category");
        ?>


    <table id="table" align="center">
        <tr>
            <th colspan="3">CATEGORIES</th>
        </tr>
        <tr>
            <th>ID</th>
            <th>Category</th>
            <th colspan="1">Action</th>
        </tr>
        <?php

        $counter=0;
        while($row = mysqli_fetch_array($result))
        {
            echo "<tr>";
            echo "<td>" .++$counter. "</td>";
            echo "<td>" . $row['category'] . "</td>";
            echo "<td>"?><a href="admin.php?action=catdelete&which=<?php echo $row['id']; ?>" class="actbut">DELETE</a> <?php echo "</td>";
            echo "</tr>";
        }

        ?>
    </table>
    <br><br>
    <form id="addform" action="admin.php?page=cat" method="post">
        <label>CATEGORY</label>
        <input type="text" name="catname" value="<?php if(isset($_POST['catname'])){echo $_POST['catname'];}?>">
        <input type="submit" value="ADD">
    </form>
    <?php
    if(isset($_POST['catname']) && $_POST['catname']=="" && !is_numeric($_POST['catname'])){ ?><h3 style="text-align: center">PLEASE ENTER VALID CATEGORY</h3><?php
        exit();
    }
    if(isset($_POST['catname'])){
        $addquery="INSERT INTO category(category) VALUES ('".$_POST['catname']."')";

        if($done=mysqli_query($con,$addquery)){
            header('Location: admin.php?page=cat&message=CATEGORY SUCCESSFULLY ADDED');

        }
            }







        }
    }
    if(isset($_GET['action'])){
        if($_GET['action'] == 'delete'){
            $sql = "DELETE FROM book_data WHERE id = ".$_GET['which']."" ;
            $con=mysqli_connect("localhost","root","","library");
            // Check connection
            if (mysqli_connect_errno())
            {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
            $getimg="SELECT img FROM book_data WHERE id='".$_GET['which']."' ";
            $result2= mysqli_query($con,$getimg);
            $im=mysqli_fetch_assoc($result2);
            unlink("".$im['img']."");
            $pathis = explode("/",$im['img']);
            unlink("thumb/".$pathis['1']."");
            $result = mysqli_query($con,$sql);


            if($result && $result2){
                header('Location: admin.php?page=home&pg=1&message=BOOK SUCCESSFULLY DELETED');

            }

        }
        if($_GET['action'] == 'catdelete'){
            $sql = "DELETE FROM category WHERE id = ".$_GET['which']."" ;
            $con=mysqli_connect("localhost","root","","library");
            // Check connection
            if (mysqli_connect_errno())
            {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }

            $result = mysqli_query($con,$sql);


            if($result){
                header('Location: admin.php?page=cat&message=CATEGORY SUCCESSFULLY DELETED');

            }

        }
        elseif ($_GET['action'] == 'edit' && ctype_digit($_GET['which'])){

            $sql = "SELECT * FROM book_data WHERE id = ".$_GET['which']."" ;
            $con=mysqli_connect("localhost","root","","library");
            // Check connection
            if (mysqli_connect_errno())
            {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }

            $result = mysqli_query($con,$sql);
            if($result){
                $info = mysqli_fetch_assoc($result);

            }
            $_SESSION['imgpath']=$info['img'];

            $disablequery="SELECT * FROM book_data WHERE featured = \"1\"";
            $resultdis= mysqli_query($con,$disablequery);
            if(mysqli_num_rows($resultdis)>=6 && $info['featured']=='0'){
                $disable='disabled';

            }else{
                $disable='';
            }

            if($info['featured']=='1'){
                $checked="checked";
            }else{
                $checked="";
            }


            $catquery="SELECT * FROM category";
            $getcat=mysqli_query($con,$catquery);
            ?>
            <h1 style="text-align: center">EDIT BOOK</h1>
            <form method="post" id="addform" action="admin.php?edit=yes&action=editing&id=<?php echo $_GET['which']; ?>" enctype="multipart/form-data">
                <label>NAME </label>
                <input type="text" name="aname" value="<?php echo $info['name'];  ?>"></input></br>
                <label>AUTHOR </label>
                <input type="text" name="aauthor" value="<?php echo $info['author'];  ?>"></input><br>
                <label>CATEGORY </label>
                <select name="category">
                    <option selected="selected" disabled="disabled">Select a Category</option>
                    <?php while($row=mysqli_fetch_assoc($getcat)){

                        ?>
                        <option <?php if($row['category']==$info['category']){echo "selected";} ?> value="<?php echo $row['category'];?>"><?php echo $row['category'];?></option>
                        <?php

                    } ?>
                </select><br>
                <label>PRICE </label>
                <input type="text" name="aprice" value="<?php echo $info['price'];  ?>"></input><br>
                <a href="./<?php echo $info['img'];?>"><img height="50" width="50" src="./<?php echo $info['img'];?>"></a>
                <label>IMAGE </label>
                <input type="file" name="aimage"  ><br>
                <label>FEATURED </label>
                <input type="checkbox" <?php echo $disable." "; echo $checked;?> value="1" name="featured" ><br>
                <input type="submit" value="UPDATE">

            </form>
        <?php


        }elseif ($_GET['action']=='editing'){


        if(isset($_GET['edit'])){

            echo $epath=$_SESSION['imgpath'];
            if($_FILES['aimage']['name'] != '')
            {
                unlink("".$_SESSION['imgpath']."");
                $pathis = explode("/",$_SESSION['imgpath']);
                unlink("thumb/".$pathis[1]."");
                srand(mktime());
                $epathhelp=rand().$_FILES['aimage']['name'];
                $epath="upload/".$epathhelp;
                move_uploaded_file($_FILES['aimage']['tmp_name'],$epath);
                $src= $epath;
                $dest="thumb/".$epathhelp;

                $desired_width="100";
                make_thumb($src, $dest, $desired_width);

            }
            if(isset($_POST['featured'])){
                $data='1';
            }else{
                $data='0';
            }

            $sql = "UPDATE book_data SET name='".$_POST['aname']."', author='".$_POST['aauthor']."',featured='".$data."', category='".$_POST['category']."', price='".$_POST['aprice']."', img='".$epath."' WHERE id = ".$_GET['id']."" ;

            $con=mysqli_connect("localhost","root","","library");
            // Check connection
            if (mysqli_connect_errno())
            {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }

            $result = mysqli_query($con,$sql);


            if($result){

                header('Location: admin.php?page=home&pg=1&message=BOOK SUCCESSFULLY UPDATED');
            }
        }}
        else{
            header('Location: admin.php?page=home&pg=1');
        }
    }

function make_thumb($src, $dest, $desired_width) {

    /* read the source image */
    $source_image = imagecreatefromjpeg($src);
    $width = imagesx($source_image);
    $height = imagesy($source_image);

    /* find the "desired height" of this thumbnail, relative to the desired width  */
    $desired_height = floor($height * ($desired_width / $width));

    /* create a new, "virtual" image */
    $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

    /* copy source image at a resized size */
    imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

    /* create the physical thumbnail image to its destination */
    imagejpeg($virtual_image, $dest);
}
    ?>
    </div>

    <div id="footer">
        © 2017 PURANJAY MOHAN, All rights reserved.
    </div>

</div>
</body>
</html>