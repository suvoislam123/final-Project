<?php
include "navbar.php";
include "link.php";
 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Book Request </title>

     <!--................slide navigaton style  -->
     <style>
 body {
   font-family: "Lato", sans-serif;
   background: url('../img/requestbg.jpg');
   background-repeat: no-repeat;
   background-size: cover;
   background-attachment: fixed;
   background-position: center;
   min-height: 800px;


 }

 .sidenav {
   height: 100%;
   width: 0;
   position: fixed;
   z-index: 1;
   margin-top: 70px;
   top: 0;
   left: 0;
   background-color: #000;
   overflow-x: hidden;
   transition: 0.5s;
   padding-top: 60px;
 }

 .sidenav a {
   padding: 8px 8px 8px 32px;
   text-decoration: none;
   font-size: 25px;
   color: #818181;
   display: block;
   transition: 0.3s;
 }

 .sidenav a:hover {
   color: #f1f1f1;
 }

 .sidenav .closebtn {
   position: absolute;
   top: 0;
   right: 25px;
   font-size: 36px;
   margin-left: 50px;
 }

 #main {
   transition: margin-left .5s;
   padding: 16px;
 }

 @media screen and (max-height: 450px) {
   .sidenav {padding-top: 15px;}
   .sidenav a {font-size: 18px;}
 }
 </style>
   </head>
   <body id="book_request">
     <!--...............................side nav...............................-->
<div class="darkoverlay text-light" style="
background: rgba(0,0,0,0.7);

top:0;
left:0;
height:100%;
width:100%;



">
       <div id="mySidenav" class="sidenav">
       <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
       <a href="profile.php">My Profile</a>
       <a href="books.php">Books</a>
       <a href="add_book.php">Add Book</a>
       <a href="book_request.php">Book Request Info</a>
       <a href="issuebook_info.php">Issue Information</a>
       <a href="expired_info.php">Expired Book Information</a>
       </div>

       <div id="main">

       <span style="font-size:30px;cursor:pointer" onclick="openNav()" class="sticky-top">&#9776; More option</span>

       <script>
       function openNav() {
       document.getElementById("mySidenav").style.width = "250px";
       document.getElementById("main").style.marginLeft = "250px";
       }

       function closeNav() {
       document.getElementById("mySidenav").style.width = "0";
       document.getElementById("main").style.marginLeft= "0";
       }
       </script>


       <div class="" style="min-height: 800px;">
         <h2 class="display-5 text-center pt-5"> Panding Issue Book Information </h2>
         <hr class="bg-light">



       <?php

       if(isset($_SESSION['admin_login_user']))
       {
         $sql="SELECT student.username,roll,books.b_id,b_name,approve,authors,edition,issue,returnbook from student inner join issue_book ON student.username=issue_book.username inner join books ON issue_book.b_id=books.b_id where issue_book.approve='Yes' ORDER BY issue_book.returnbook ASC;";

         $query=mysqli_query($dblink,$sql);
         if(mysqli_num_rows($query)==0)
         {
           echo "<h2 class='display-5 py-5'>";
           echo "There is no issued book history";
           echo "</h2>";
         }
         else{
         echo "<table class='table table-bordered scroll  text-light'>";

           echo "<tr style='background-color:#0827AB;'>";
           echo "<th>"; echo "Book Id"; echo "</th>";
           echo "<th>"; echo "Student Username"; echo "</th>";
           echo "<th>"; echo "Roll"; echo "</th>";
           echo "<th>"; echo "Book Name"; echo "</th>";
           echo "<th>"; echo "Authors Name"; echo "</th>";
           echo "<th>"; echo "Edition"; echo "</th>";
           //echo "<th>"; echo "Approve Status"; echo "</th>";
           echo "<th>"; echo "Issue Date"; echo "</th>";
           echo "<th>"; echo "Return date"; echo "</th>";
           echo "<th>"; echo "Take Book"; echo "</th>";

           echo "</tr>";

           $count=0;
           while($row=mysqli_fetch_assoc($query))
           {
             $today=date("Y-m-d");
             if($today>$row['returnbook'])
             {
               //$var='<p style="color:yellow; backgroundcolor:green;">RETURNED</p>';
               $returndate=$row['returnbook'];
               $count=$count+1;
               $sql="UPDATE `issue_book` SET `approve`='Expired' WHERE `approve`='Yes' AND `returnbook`='$returndate' limit $count;";
               mysqli_query($dblink,$sql);
               //echo $row['returnbook']."</br>";
             }

             else{

             }
             echo "<tr>";
             echo "<form action='' method='POST'>";?>
             <td> <input type="hidden" name="hidden_b_id" value="<?php echo $row['b_id'];?>"/> <?php echo $row['b_id']; ?></td>

            <td> <input type="hidden" name="hiddenuser" value="<?php echo $row['username'];?>"/> <?php echo $row['username']; ?></td>

            <td> <input type="hidden" name="hidden_roll" value="<?php echo $row['roll'];?>"/> <?php echo $row['roll']; ?></td>
            <?php echo "<td>";echo $row['b_name']; echo "</td>";
             echo "<td>";echo $row['authors']; echo "</td>";
             echo "<td>";echo $row['edition']; echo "</td>";
             //echo "<td>";echo $row['approve']; echo "</td>";
             echo "<td>";echo $row['issue']; echo "</td>";
             ?>
             <td> <input type="hidden" name="hidden_returndate" value="<?php echo $row['returnbook'];?>"/> <?php echo $row['returnbook']; ?></td>
          <?php
             //echo "<td>";echo $row['returnbook']; echo "</td>";
             if($today>$row['returnbook']){
             echo "<td>";echo "<button class='font-weight-bold btn btn-danger btn-block' name='b_submit1'><i class='fa fa-cart-plus'></i>";echo "</button>"; echo "</td>";
           }
           else{
             echo "<td>";echo "<button class='font-weight-bold btn btn-success btn-block' name='b_submit2'><i class='fa fa-cart-plus'></i>";echo "</button>"; echo "</td>";

           }

             echo "</tr>";
             echo "</form>";
//
 $_name=$row['username'];
 $_bid=$row['b_id'];
 //$returndate=$_GET['returndate'];
 $roll=$row['roll'];
$returndate=$row['returnbook'];
//echo $returndate;
$sql2="SELECT * FROM `books` WHERE b_id='$_bid';";
$run2=mysqli_query($dblink, $sql2);
$row2=mysqli_fetch_assoc($run2);
$present_book= $row2['quantity'];
 if(isset($_POST['b_submit2']))
 {
   $present_book=$present_book+1;
   $sql="UPDATE `issue_book` SET `approve`='Return' WHERE `username`='$_name' and `b_id`='$_bid';";
   mysqli_query($dblink,$sql);

 ?>

   <script type="text/javascript">
   alert("Return Book successfully");

   </script>
   <?php
   if($present_book>0)
   {
     $sql4="UPDATE `books` SET `status`='Available',`quantity`='$present_book' WHERE b_id='$_bid';";
     $run4=mysqli_query($dblink,$sql4);
   }
   else{}
 }

elseif (isset($_POST['b_submit1'])) {
  header("Location :fine_collection.php");
  /*<script type="text/javascript">
window.location="fine_collection.php?hidden_returndate=<?php echo $returndate;?>";
  </script>*/


}

   else{}

           }
           echo "Expired Book = ".$count;
           echo "<hr>";

           echo "</table>";



         }
       }
else{
  ?>
  echo "<h2 class='display-5 py-5'>";
  echo "Please login first, then you can see book request Information";
  echo "</h2>";

  <?php

}
       ?>
</div>
</div>

<footer class="bg-dark text-light text-center">
  <div class="container">
    <div class="row">
      <div class="col">
        <p>Copyright 2021 &copy; library</p>
      </div>
   </body>
 </html>
