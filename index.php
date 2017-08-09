<?php
$con=mysqli_connect("localhost","root","","library");
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$getimg="SELECT img FROM book_data WHERE featured = TRUE";
$result=mysqli_query($con,$getimg);
$i=0;
$image= array();
while($row=mysqli_fetch_array($result)){
    $image[$i]=$row['img']; ?><br><?php


    ++$i;
}



?>
<!DOCTYPE html>
<html>
<title>Indian Library</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="./css/style.css">
<link rel="stylesheet" href="./css/style2.css">
<style>
    body,h1,h2,h3,h4,h5 {font-family: "Poppins", sans-serif}
    body {font-size:16px;}
    .w3-half img{margin-bottom:-6px;margin-top:16px;opacity:0.8;cursor:pointer}
    .w3-half img:hover{opacity:1}
</style>
<body>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-red w3-collapse w3-top w3-large w3-padding" style="z-index:3;width:300px;font-weight:bold;" id="mySidebar"><br>
    <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">Close Menu</a>
    <div class="w3-container">
        <h3 class="w3-padding-64" style="font-size: 40px"><b>INDIAN<br>LIBRARY</b></h3>
    </div>
    <div class="w3-bar-block">
        <a href="#" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Home</a>
        <a href="#showcase" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Showcase</a>
        <a href="#services" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Books</a>
        <a href="#designers" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Magazines</a>
        <a href="#packages" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Register</a>
        <a href="#contact" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Contact</a>
    </div>
</nav>

<!-- Top menu on small screens -->
<header class="w3-container w3-top w3-hide-large w3-red w3-xlarge w3-padding">
    <a href="javascript:void(0)" class="w3-button w3-red w3-margin-right" onclick="w3_open()">☰</a>
    <span>Indian Library</span>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">

    <!-- Header -->
    <div class="w3-container" style="margin-top:80px" id="showcase">
        <h1 class="w3-jumbo"><b>Books To make Friends With</b></h1>
        <h1 class="w3-xxxlarge w3-text-red"><b>Showcase.</b></h1>
        <hr style="width:50px;border:5px solid red" class="w3-round">
    </div>

    <!-- Photo grid (modal) -->
    <div class="w3-row-padding">
        <div class="w3-half">
            <img src="admin/<?php echo $image[0];?>" style="width:100%" onclick="onClick(this)" >
            <img src="admin/<?php echo $image[1];?>" style="width:100%" onclick="onClick(this)" >
            <img src="admin/<?php echo $image[2];?>" style="width:100%" onclick="onClick(this)" >
        </div>

        <div class="w3-half">
            <img src="admin/<?php echo $image[3];?>" style="width:100%" onclick="onClick(this)" >
            <img src="admin/<?php echo $image[4];?>" style="width:100%" onclick="onClick(this)" >
            <img src="admin/<?php echo $image[5];?>" style="width:100%" onclick="onClick(this)" >
        </div>
    </div>

    <!-- Modal for full size images on click-->
    <div id="modal01" class="w3-modal w3-black" style="padding-top:0" onclick="this.style.display='none'">
        <span class="w3-button w3-black w3-xxlarge w3-display-topright">×</span>
        <div class="w3-modal-content w3-animate-zoom w3-center w3-transparent w3-padding-64">
            <img id="img01" class="w3-image">
            <p id="caption"></p>
        </div>
    </div>

    <!-- Services -->
    <div class="w3-container" id="services" style="margin-top:75px">
        <h1 class="w3-xxxlarge w3-text-red"><b>Books.</b></h1>
        <hr style="width:50px;border:5px solid red" class="w3-round">
        <p>We are a interior design service that focus on what's best for your home and what's best for you!</p>
        <p>Some text about our services - what we do and what we offer. We are lorem ipsum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
            dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
        </p>
    </div>

    <!-- Designers -->
    <div class="w3-container" id="designers" style="margin-top:75px">
        <h1 class="w3-xxxlarge w3-text-red"><b>Magazines</b></h1>
        <hr style="width:50px;border:5px solid red" class="w3-round">
        <p>The best team in the world.</p>
        <p>We are lorem ipsum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
            dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor
            incididunt ut labore et quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
        </p>
    </div>


    <!-- Packages / Pricing Tables -->
    <div class="w3-container" id="packages" style="margin-top:75px">
        <h1 class="w3-xxxlarge w3-text-red"><b>Register.</b></h1>
        <hr style="width:50px;border:5px solid red" class="w3-round">
        <p>Some text our prices. Lorem ipsum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure</p>
    </div>

    <div class="w3-row-padding">
        <div class="w3-half w3-margin-bottom">
            <ul class="w3-ul w3-light-grey w3-center">
                <li class="w3-dark-grey w3-xlarge w3-padding-32">Basic</li>
                <li class="w3-padding-16">Can issue All magazines and selected Books</li>
                <li class="w3-padding-16">6 hours time</li>
                <li class="w3-padding-16">Photocopier service</li>
                <li class="w3-padding-16">Air conditioned rooms</li>
                <li class="w3-padding-16">Snacks</li>
                <li class="w3-padding-16">
                    <h2>&#8377; 2500</h2>
                    <span class="w3-opacity">per person</span>
                </li>
                <li class="w3-light-grey w3-padding-24">
                    <button class="w3-button w3-white w3-padding-large w3-hover-black">Sign Up</button>
                </li>
            </ul>
        </div>

        <div class="w3-half">
            <ul class="w3-ul w3-light-grey w3-center">
                <li class="w3-red w3-xlarge w3-padding-32">Pro</li>
                <li class="w3-padding-16">Can issue All books and All Magazines</li>
                <li class="w3-padding-16">12 hours time</li>
                <li class="w3-padding-16">Photocopier and internet facility</li>
                <li class="w3-padding-16">Air conditioned rooms</li>
                <li class="w3-padding-16">Snacks at 10% off</li>
                <li class="w3-padding-16">
                    <h2>&#8377; 5000</h2>
                    <span class="w3-opacity">per person</span>
                </li>
                <li class="w3-light-grey w3-padding-24">
                    <button class="w3-button w3-red w3-padding-large w3-hover-black">Sign Up</button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Contact -->
    <div class="w3-container" id="contact" style="margin-top:75px">
        <h1 class="w3-xxxlarge w3-text-red"><b>Contact.</b></h1>
        <hr style="width:50px;border:5px solid red" class="w3-round">
        <p>Do you love books and want to join a library for reading , then Indian Library is the best choice in the city.</p>
        <form action="/action_page.php" target="_blank">
            <div class="w3-section">
                <label>Name</label>
                <input class="w3-input w3-border" type="text" name="Name" required>
            </div>
            <div class="w3-section">
                <label>Email</label>
                <input class="w3-input w3-border" type="text" name="Email" required>
            </div>
            <div class="w3-section">
                <label>Message</label>
                <input class="w3-input w3-border" type="text" name="Message" required>
            </div>
            <button type="submit" class="w3-button w3-block w3-padding-large w3-red w3-margin-bottom">Send Message</button>
        </form>
    </div>

    <!-- End page content -->
</div>


<script>
    // Script to open and close sidebar
    function w3_open() {
        document.getElementById("mySidebar").style.display = "block";
        document.getElementById("myOverlay").style.display = "block";
    }

    function w3_close() {
        document.getElementById("mySidebar").style.display = "none";
        document.getElementById("myOverlay").style.display = "none";
    }

    // Modal Image Gallery
    function onClick(element) {
        document.getElementById("img01").src = element.src;
        document.getElementById("modal01").style.display = "block";
        var captionText = document.getElementById("caption");
        captionText.innerHTML = element.alt;
    }
</script>

</body>
</html>
