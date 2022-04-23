<?php
require_once ("DbConn.php");
session_start();
//if(isset($_SESSION["uname"])){
//} 
//else{
  //header("location:admin_login.php");
//}
?>
<!DOCTYPE html>
<html>
<head>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=PT+Serif:ital,wght@1,400;1,700&display=swap" rel="stylesheet">
<script src="https://kit.fontawesome.com/87f508ba30.js" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="admin_style.css">

<title>Grievance management</title>
<script type="text/javascript">
  function openCity(cityName) {
  var i;
  var x = document.getElementsByClassName("tabcontent");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  document.getElementById(cityName).style.display = "block";  
}
</script>
<script type="text/javascript">
  function log(){
    window.location.replace("http://localhost:8080/Feedback-maintainance-system/admin_login.php");
  }
</script>
</head>
<body onload="openCity('All')">


<div class="image-background">
  <div class="img-container">
    <div class="tab">
  <!--button class="tablinks" onclick="openCity('About')">About</button-->
  <div class="dropdown">
  <button class="tablinks" onclick="openCity('FeedbackCategory')">Reports Category &nbsp;<i class="fa fa-caret-down"></i></button>
    <div class="dropdown-content">
      <button onclick="openCity('Staff')">Staffs</button><br>
      <button onclick="openCity('Canteen')">Canteen Facilities</button><br>
      <button onclick="openCity('Cleanliness')">Cleanliness</button><br>
      <button onclick="openCity('Bus')">Bus Facilities</button><br>
      <button onclick="openCity('Hostel')">Hostel Facilities</button>
    </div>
  </div> 
  <button class="tablinks" onclick="openCity('All')">All reports</button>
  <button class="logout" onclick="log()">Logout &nbsp;<i class="fa-solid fa-right-from-bracket"></i></button>
</div>
  <p class="quote" style="size: 30px;">One of our biggest problem<br> is Delayed reporting<br><br>----- Harry Hall -----</p>
  </div>
  </div>

<?php
	function getCategoryFeedbacks($con,$Category){
    	$query="select students.StudentName,feedbackdetails.PostedOn,feedbackdetails.Feedback,feedbackdetails.Status,feedbackdetails.UpVote_Count,feedbackdetails.DownVote_Count,feedbackdetails.FeedbackId from feedbackdetails INNER JOIN feedback_category ON feedbackdetails.CategoryId=feedback_category.CategoryId INNER JOIN students ON students.StudentId = feedbackdetails.PostedBy WHERE feedback_category.CategoryId=$Category";
	  	$result=mysqli_query($con,$query);
	  	if($result->num_rows>0){

	  		while($row = $result->fetch_assoc()) {
          
          $posted_by=$row['StudentName'];
	  			$queried_name=$row['PostedOn'];
	  			$Status=$row['Status'];
	  			$feedBack=$row['Feedback'];
	  			$Upvote=$row['UpVote_Count'];
	  			$Downvote=$row['DownVote_Count'];
          echo "<br>";
          echo "<div style='margin-left:100px;font-size:14px;'><i class='fa-solid fa-circle-user' style='font-size:25px;'></i> &nbsp&nbsp&nbsp $posted_by &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $queried_name </div>";

          $feedback_id = $row['FeedbackId'];
          $getVotes = "select * from votes WHERE feedbackId= $feedback_id";
          $innerResult=mysqli_query($con,$getVotes);

          $upvoteColor='black';
          $downvoteColor='black';
          $studentUpvote = 0;
          $studentDownvote = 0;

          while ($innerResult && $innerRow = mysqli_fetch_array($innerResult)){
            $studentUpvote = $innerRow['UpVote'];
            $studentDownvote = $innerRow['DownVote'];           
          }

          $getreply = "Select Reply from replies where FeedbackId= $feedback_id";
          $reply_con = mysqli_query($con,$getreply);
          $Found = $reply_con ->num_rows > 0 ? 'yes' : 'no';

          echo "<br>";
	  		
            echo "<div class='Feedback' style='margin-left:170px;font-size:18px;'><p class='feedbackFont'> $feedBack </p></div>";
	      		echo "<div style='float:right;padding-right:350px; padding-left:50pxs;' id='status'> $Status </div>";
            echo "<br>";
            //echo "<label class='switch' style='float:right;margin-right:350px; margin-left:50pxs;font-size:10px;'><input type='checkbox' onclick='echo('HI')'><span class='slider round'></span></label>";
            
            echo "<div class='votes' style='margin-left:240px;'><i id='upvotes".$row['FeedbackId']."' style='color:".$upvoteColor.";font-size:20px' onclick='' class='fas fa-chevron-circle-up' style='font-size:10px;'></i> &nbsp&nbsp $Upvote &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <i id='downvotes".$row['FeedbackId']."' style='color:".$downvoteColor.";font-size:20px' onclick='' class='fas fa-chevron-circle-down'></i> &nbsp&nbsp $Downvote</div><br><br>";

            echo "<form action='save_reply.php' method='Post'>
            <input type='hidden' id='FeedbackId' value='$feedback_id' class='FeedbackId' name='FeedbackId'>";

            if($Found == 'no'){
              echo "<input type='text' id='reply' name='reply' class='reply' placeholder='reply'> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp  <button class='reply-submit'><i class='fa-solid fa-share'></i></button> </form>";
            }
            else{
              $val = $reply_con->fetch_assoc();
              $reply_val=$val['Reply'];
              echo "<input type='text' id='reply' name='reply' class='reply' value='$reply_val'> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp  <button class='reply-submit'><i class='fa-solid fa-share'></i></button> </form>";
            }
            echo "<br>";
            echo "<br>";
            echo "<hr>";
	    	}
	    }
	}
?>

<div id="Staff" class="tabcontent">
	 <?php
	 getCategoryFeedbacks($con,1);
  ?>

</div>


<div id="Canteen" class="tabcontent">
   <?php
   
   getCategoryFeedbacks($con,2);
  ?>

</div>

<div id="Cleanliness" class="tabcontent">
   <?php
   
   getCategoryFeedbacks($con,3);
  ?>
</div>

<div id="Bus" class="tabcontent">
   <?php
   
   getCategoryFeedbacks($con,4);
  ?>
</div>


<div id="Hostel" class="tabcontent">
	 <?php
   
	 getCategoryFeedbacks($con,5);
  ?>
</div>

<?php
function getallfeedbacks($con){
    $query="select students.StudentName,feedbackdetails.PostedOn,feedbackdetails.Feedback,feedbackdetails.Status,feedbackdetails.UpVote_Count,feedbackdetails.DownVote_Count,feedbackdetails.FeedbackId from feedbackdetails INNER JOIN students ON students.StudentId = feedbackdetails.PostedBy";
    $result=mysqli_query($con,$query);
      if($result->num_rows>0){
        while($row = $result->fetch_assoc()) {
          $posted_by=$row['StudentName'];
          $queried_name=$row['PostedOn'];
          $Status=$row['Status'];
          $feedBack=$row['Feedback'];
          $Upvote=$row['UpVote_Count'];
          $Downvote=$row['DownVote_Count'];
          $feedback_id = $row['FeedbackId'];
          $getVotes = "select * from votes WHERE feedbackId=".$feedback_id."";
          $innerResult=mysqli_query($con,$getVotes);

          $upvoteColor='black';
          $downvoteColor='black';
          $studentUpvote = 0;
          $studentDownvote = 0;
          echo "<br>";
          echo "<div style='margin-left:100px;font-size:14px;'><i class='fa-solid fa-circle-user' style='font-size:25px;'></i> &nbsp&nbsp&nbsp $posted_by &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $queried_name </div>";

          while ($innerResult && $innerRow = mysqli_fetch_array($innerResult)){
            $studentUpvote = $innerRow['UpVote'];
            $studentDownvote = $innerRow['DownVote'];           
          }
            echo "<div class='Feedback' style='margin-left:170px;font-size:18px;'><p class='feedbackFont'>".$row['Feedback']."</p></div>";
            echo "<div style='float:right;padding-right:350px; padding-left:50pxs;' id='status'>".$Status."</div>";
            echo "<br>";
            echo "<label class='switch' style='float:right;margin-right:350px; margin-left:50pxs;font-size:10px;'><input type='checkbox'><span class='slider round'></span></label>";
            
            echo "<div class='votes' style='margin-left:200px;'><i id='upvotes".$row['FeedbackId']."' style='color:".$upvoteColor.";font-size:20px' onclick='' class='fas fa-chevron-circle-up' style='font-size:10px;'></i> &nbsp&nbsp $Upvote &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <i id='downvotes".$row['FeedbackId']."' style='color:".$downvoteColor.";font-size:20px' onclick='' class='fas fa-chevron-circle-down'></i> &nbsp&nbsp $Downvote</div>";
            echo "<br>";
            echo "<hr>";
        }
      }
    }
  ?>

<div id="All" class="tabcontent">
  <?php
    getallfeedbacks($con);
  ?>
</div>

</body>
</html> 


