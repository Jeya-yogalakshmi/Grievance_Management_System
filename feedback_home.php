<!DOCTYPE html>
<html>
<head>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital@1&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="feedback_style.css">
	<script src="javascript.js"></script>
</head>
<body onload='myFunction()'>
	<div class="image-background">
  <div class="img-container">
    <div class="tab">
  <button class="tablinks" onclick="openCity('About')">About</button>
  <div class="dropdown">
  <button class="tablinks" onclick="openCity('FeedbackCategory')">Feedback Category<i class="fa fa-caret-down"></i></button>
    <div class="dropdown-content">
      <button onclick="openCity('Staff')">Staffs</button><br>
      <button onclick="openCity('Canteen')">Canteen Facilities</button><br>
      <button onclick="openCity('Cleanliness')">Cleanliness</button><br>
      <button onclick="openCity('Bus')">Bus Facilities</button><br>
      <button onclick="openCity('Hostel')">Hostel Facilities</button>
    </div>
  </div> 
  <button class="tablinks" onclick="location.href = 'login_pg.php';">Login</button>
</div>
  <p class="quote" style="size: 30px;">The key to learning is feedback.It is<br>nearly impossible to learn anything<br>without it.<br><br>----- Steven Levitt -----</p>
  </div>
</div>

<div id="About" class="tabcontent" style="border: none;">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header" align="center"><font color="#e6e600"><style="background-color:#C0C0C0">STUDENT FEEDBACK SYSTEM</font> </h1>
    </div>
  </div>
  <div class="row" style="margin-bottom:100px;margin-left:100px;margin-right:100px;">            
    <P style="background-color:#e6ffcc">  
      The Student Feedback System aims at providing a platform for the students of our college to rate and analyse various facilities provided by the college.<br>This system helps in maintaining the views of the students and also gives a clear picure about different issues, which in turn helps in the enhancement and development of the college.
    </P>
    <P style="background-color:#ccffcc">
      You can start the development from the login page, where there is an module given to login as student.<br>you'll have to enter the student user and password, and it will let you enter the feedback based on the category.
    </P>
  </div>
</div>

<?php
	function getCategoryFeedbacks($con,$Category,$studentId){
	  	$query="select feedbackdetails.PostedOn,feedbackdetails.Feedback,feedbackdetails.Status,feedbackdetails.UpVote_Count,feedbackdetails.DownVote_Count,feedbackdetails.FeedbackId from feedbackdetails INNER JOIN 
	  	feedback_category ON feedbackdetails.CategoryId=feedback_category.CategoryId WHERE feedback_category.CategoryId=$Category";
	  	$result=mysqli_query($con,$query);
      echo "$result";
	  	if($result->num_rows>0){
	  		while($row = $result->fetch_assoc()) {
	  			$queried_name=$row['PostedOn'];
	  			$Status=$row['Status'];
	  			$feedBack=$row['Feedback'];
	  			$Upvote=$row['UpVote_Count'];
	  			$Downvote=$row['DownVote_Count'];
	  			echo "<br>";
	  			echo "Posted On : $queried_name &nbsp&nbsp&nbsp Upvote Count : $Upvote &nbsp&nbsp&nbsp Downvote Count : $Downvote";
	  			echo "<br>";
	  			echo"<br>";
	  			$feedback_id = $row['FeedbackId'];
	  			$getVotes = "select * from votes WHERE StudentId=".$studentId." and feedbackId=".$feedback_id."";
	  			$innerResult=mysqli_query($con,$getVotes);

	  			$upvoteColor='black';
	  			$downvoteColor='black';
	  			$studentUpvote = 0;
	  			$studentDownvote = 0;

	  			while ($innerResult && $innerRow = mysqli_fetch_array($innerResult)){
		  			$studentUpvote = $innerRow['UpVote'];
		  			$studentDownvote = $innerRow['DownVote'];	  				
	  			}
	  			
	  			if($studentUpvote==1){
	  				$upvoteColor="blue";
	  			}
	  			else{
	  				$upvoteColor="black";
	  			}
	  			if($studentDownvote==1){
	  				$downvoteColor="blue";
	  			}
	  			else{
	  				$downvoteColor="black";
	  			}

	  			//echo $StatuS.$sql;
	      		echo "<div class='votes'>
	      		<div class='Upvotes'>
	      		<i id='upvotes".$row['FeedbackId']."' style='color:".$upvoteColor.";font-size:24px' onclick='upvote(this,".$row['FeedbackId'].",".$studentId.")' class='fas fa-chevron-circle-up'></i>
	      		</div>
	      		<div class='downvotes'>
	      		<i id='downvotes".$row['FeedbackId']."' style='color:".$downvoteColor.";font-size:24px' onclick='downvote(this,".$row['FeedbackId'].",".$studentId.")' class='fas fa-chevron-circle-down'></i></div>
	      		</div>
	      		<div class='Feedback'><p class='feedbackFont'>".$row['Feedback']."</p></div>";
	      		echo $Status;
	      		echo "<hr>";
	    	}
	    }
	}
?>

<div id="Staff" class="tabcontent">
	 <?php
	 getCategoryFeedbacks($con,1,$studentId)
  ?>

</div>
<div id="Canteen" class="tabcontent">
	 <?php
	 getCategoryFeedbacks($con,2,$studentId);
  ?>
</div>

<div id="Cleanliness" class="tabcontent">
	 <?php
	 getCategoryFeedbacks($con,3,$studentId);
  ?>
</div>



<div id="Bus" class="tabcontent">
	<?php
		getCategoryFeedbacks($con,4,$studentId);
	?>
</div>

<div id="Hostel" class="tabcontent">
	 <?php
	 getCategoryFeedbacks($con,5,$studentId);
  ?>
</div>


</body>
</html>