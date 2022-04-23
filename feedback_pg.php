<?php
require_once ("DbConn.php");
session_start();
if(isset($_SESSION["uname"])){
} 
else{
  header("location:home_page.php");
}
$uname = $_SESSION["uname"];
$studentId = $_SESSION["studentid"];
//echo $uname;
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
<link rel="stylesheet" type="text/css" href="feedback_style.css">
<script src="javascript.js"></script>
<title>Grievance management</title>
</head>
<body onload="openCity('YourFeedback');">


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
  <button class="tablinks" onclick="openCity('YourFeedback')">Your Grievances</button>
  <button class="tablinks" onclick="openCity('NewFeedback')">Post New Report</button>
  <!--button class="tablinks" onclick="openCity('Rating')">Add feedback</button-->
  <button class="logout" onclick="location.href = 'logout.php'">Logout &nbsp;<i class="fa-solid fa-right-from-bracket"></i></button>
</div>
  <p class="quote" style="size: 30px;">One of our biggest problem<br> is Delayed reporting<br><br>----- Harry Hall -----</p>
  </div>
</div>



<!--div id="About" class="tabcontent" style="border: none;">
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
</div-->

<?php
	function getCategoryFeedbacks($con,$Category,$studentId){
    	$query="select students.StudentName,feedbackdetails.PostedOn,feedbackdetails.Feedback,feedbackdetails.Status,feedbackdetails.UpVote_Count,feedbackdetails.DownVote_Count,feedbackdetails.FeedbackId from feedbackdetails INNER JOIN 
	  	feedback_category ON feedbackdetails.CategoryId=feedback_category.CategoryId and feedbackdetails.visibility='1'
      INNER JOIN students ON students.StudentId = feedbackdetails.PostedBy WHERE feedback_category.CategoryId=$Category";
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
	  			//echo "<br>"; &nbsp&nbsp&nbsp Upvote Count : $Upvote &nbsp&nbsp&nbsp Downvote Count : $Downvote
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
	  				$upvoteColor="#EE5E3F";
	  			}
	  			else{
	  				$upvoteColor="black";
	  			}
	  			if($studentDownvote==1){
	  				$downvoteColor="#EE5E3F";
	  			}
	  			else{
	  				$downvoteColor="black";
	  			}

	  			//echo $StatuS.$sql;
          /*
	      		echo "<div class='votes' style='margin-left:200px;'>
	      		<div class='Upvotes'>
	      		<i id='upvotes".$row['FeedbackId']."' style='color:".$upvoteColor.";font-size:24px' onclick='upvote(this,".$row['FeedbackId'].",".$studentId.")' class='fas fa-chevron-circle-up'></i>
	      		</div>
	      		<div class='downvotes'>
	      		<i id='downvotes".$row['FeedbackId']."' style='color:".$downvoteColor.";font-size:24px' onclick='downvote(this,".$row['FeedbackId'].",".$studentId.")' class='fas fa-chevron-circle-down'></i></div>
	      		</div>
            */
            echo "<div class='Feedback' style='margin-left:200px;font-size:18px;'><p class='feedbackFont'>".$row['Feedback']."</p></div>";
	      		echo "<div style='float:right;padding-right:350px; padding-left:50pxs;'>".$Status."</div>";
            echo "<br>";
            echo "<div class='votes' style='margin-left:240px;'><i id='upvotes".$row['FeedbackId']."' style='color:".$upvoteColor.";font-size:20px' onclick='upvote(this,".$row['FeedbackId'].",".$studentId.")' class='fas fa-chevron-circle-up' style='font-size:10px;'></i> &nbsp&nbsp $Upvote &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <i id='downvotes".$row['FeedbackId']."' style='color:".$downvoteColor.";font-size:20px' onclick='downvote(this,".$row['FeedbackId'].",".$studentId.")' class='fas fa-chevron-circle-down'></i> &nbsp&nbsp $Downvote</div>";
            if($Status == ' Addressed'){
              echo "<svg width='15' height='10' viewBox='0 0 42 25'>
                    <path d='M3 3L21 21L39 3' stroke='white' stroke-width='7' stroke-linecap='round'/>
                    </svg>
                    <div class='feedback_reply'>
                    <p value='replied'></p>
                    </div>";
            }
            echo "<br>";
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


<div id="YourFeedback" class="tabcontent">
  <?php
  	$query="select feedbackdetails.PostedOn,feedbackdetails.Feedback,feedbackdetails.Status from feedbackdetails INNER JOIN 
  	students ON feedbackdetails.PostedBy=students.StudentId WHERE StudentId=$studentId";
  	$result=mysqli_query($con,$query);
  	if($result->num_rows>0){
  		while($row = $result->fetch_assoc()) {
  			$queried_name=$row['PostedOn'];
  			$sql=$row['Status'];
  			$feedBack=$row['Feedback'];
  			echo "<br>";
  			echo "<div style='margin-left:180px;'> Posted On : ".$queried_name."</div>";
  			echo "<br>";
  			
  			//echo $StatuS.$sql;
      		echo "<div class='Feedback' style='margin-left:200px;'><p class='feedbackFont'>".$row['Feedback']."</p></div>";
      		echo "<div  style='float:right;padding-right:350px; padding-left:50pxs;'>".$sql."</div>";
      		echo "<hr>";
    }
    }
  ?>
</div>

<div id="NewFeedback" class="tabContent">
    <div class="formPopup" id="popupForm">
        <form action="save_feedback.php" class="formContainer" method="Post">
          <div class="form-container">
          <h1>Add New Report</h1>
        <label for="feedback">
          <strong>Grievance</strong>
        </label></div><br>
        <div class="form-container">
        <textarea rows='4' id="feedback" placeholder="Your Feedback" name="feedback" required></textarea>
        <div class="row">
          <div class="radiobtn">
        <p><strong>Category</strong></p>
  			<input type="radio" class="radio" id="Staff" name="Category" value="1">
  			<label for="Staff">Staff</label><br>
  			<input type="radio" class="radio" id="Canteen" name="Category" value="2">
  			<label for="Canteen">Canteen</label><br>
  			<input type="radio" class="radio" id="Cleanliness" name="Category" value="3">
  			<label for="Cleanliness">Cleanliness</label><br>
  			<input type="radio" class="radio" id="Bus" name="Category" value="4">
  			<label for="Bus">Bus Facilities</label><br>
  			<input type="radio" class="radio" id="Hostel" name="Category" value="5">
  			<label for="Hostel">Hostel Facilities</label><br><br></div></div>
        <p><strong>Visibility</strong></p>
        <div class="dropdown1">
        <select class="dropbox" placeholder="Visibility" name="Visibility" value="1">
          <option value="1" class="drop-text">Visible to all</option>
          <option value="2" class="drop-text">Visible without name</option>
          <option value="0" class="drop-text">Management only</option>
        </select>
        </div>
        <br>
        </div>
        <br>
        <br><br>
        <button type="submit" class="btn">Post</button>
        <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
        </form>
    </div>
</div>

<!--div id="Rating" class="tabcontent" style="border: none;">
  <div class="scene">
    <div class="cube">
      <nav class="steps">
        <div class="dot step_1 done"></div>
        <div class="dot step_2"></div>
        <div class="dot step_3"></div>
        <div class="dot step_4"></div>
        <div class="dot step_5"></div>
      </nav>
      <div class="whole-box">
      <div class="cube__face--front" id="step__1">
        <div class="container">
          <h3>Staffs</h3>
          <div class="box">
            <div class="emoji">
              <div id="emoji-1">
                <img src="images/poor.png">
                <img src="images/bad.png">
                <img src="images/okay.png">
                <img src="images/good.png">
                <img src="images/excellent.png">
              </div>
            </div>
            <div class="rating">
              <i class="star fa-solid fa-star"></i>
              <i class="star fa-solid fa-star"></i>
              <i class="star fa-solid fa-star"></i>
              <i class="star fa-solid fa-star"></i>
              <i class="star fa-solid fa-star"></i>
            </div>
          </div>
        </div>
        <input type="button" name="btn1" value="Continue" class="btn1" onclick="whole-box.style">
      </div>

      <div class="cube__face--front" id="step__2">
        <div class="container">
          <h3>Canteen facility</h3>
          <div class="box">
            <div class="emoji">
              <div id="emoji-1">
                <img src="images/poor.png">
                <img src="images/bad.png">
                <img src="images/okay.png">
                <img src="images/good.png">
                <img src="images/excellent.png">
              </div>
            </div>
            <div class="rating">
              <i class="star fa-solid fa-star"></i>
              <i class="star fa-solid fa-star"></i>
              <i class="star fa-solid fa-star"></i>
              <i class="star fa-solid fa-star"></i>
              <i class="star fa-solid fa-star"></i>
            </div>
          </div>
        </div>
      </div>

      <div class="cube__face--front" id="step__3">
        <div class="container">
          <h3>Cleanliness</h3>
          <div class="box">
            <div class="emoji">
              <div id="emoji-1">
                <img src="images/poor.png">
                <img src="images/bad.png">
                <img src="images/okay.png">
                <img src="images/good.png">
                <img src="images/excellent.png">
              </div>
            </div>
            <div class="rating">
              <i class="star fa-solid fa-star"></i>
              <i class="star fa-solid fa-star"></i>
              <i class="star fa-solid fa-star"></i>
              <i class="star fa-solid fa-star"></i>
              <i class="star fa-solid fa-star"></i>
            </div>
          </div>
        </div>
      </div>

      <div class="cube__face--front" id="step__4">
        <div class="container">
          <h3>Bus facility</h3>
          <div class="box">
            <div class="emoji">
              <div id="emoji-1">
                <img src="images/poor.png">
                <img src="images/bad.png">
                <img src="images/okay.png">
                <img src="images/good.png">
                <img src="images/excellent.png">
              </div>
            </div>
            <div class="rating">
              <i class="star fa-solid fa-star"></i>
              <i class="star fa-solid fa-star"></i>
              <i class="star fa-solid fa-star"></i>
              <i class="star fa-solid fa-star"></i>
              <i class="star fa-solid fa-star"></i>
            </div>
          </div>
        </div>
      </div>

      <div class="cube__face--front" id="step__5">
        <div class="container">
          <h3>Hostel facility</h3>
          <div class="box">
            <div class="emoji">
              <div id="emoji-1">
                <img src="images/poor.png">
                <img src="images/bad.png">
                <img src="images/okay.png">
                <img src="images/good.png">
                <img src="images/excellent.png">
              </div>
            </div>
            <div class="rating">
              <i class="star fa-solid fa-star"></i>
              <i class="star fa-solid fa-star"></i>
              <i class="star fa-solid fa-star"></i>
              <i class="star fa-solid fa-star"></i>
              <i class="star fa-solid fa-star"></i>
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  var stars = document.getElementsByClassName("fa-solid");
  var emoji = document.getElementById("emoji-1");

  stars[0].onclick = function(){
    stars[0].style.color = "#EE5E3F";
    stars[1].style.color = "#333333";
    stars[2].style.color = "#333333";
    stars[3].style.color = "#333333";
    stars[4].style.color = "#333333";
    emoji.style.transform = "translateX(0)"
  }

  stars[1].onclick = function(){
    stars[0].style.color = "#EE5E3F";
    stars[1].style.color = "#EE5E3F";
    stars[2].style.color = "#333333";
    stars[3].style.color = "#333333";
    stars[4].style.color = "#333333";
    emoji.style.transform = "translateX(-100px)"
  }

  stars[2].onclick = function(){
    stars[0].style.color = "#EE5E3F";
    stars[1].style.color = "#EE5E3F";
    stars[2].style.color = "#EE5E3F";
    stars[3].style.color = "#333333";
    stars[4].style.color = "#333333";
    emoji.style.transform = "translateX(-200px)"
  }

  stars[3].onclick = function(){
    stars[0].style.color = "#EE5E3F";
    stars[1].style.color = "#EE5E3F";
    stars[2].style.color = "#EE5E3F";
    stars[3].style.color = "#EE5E3F";
    stars[4].style.color = "#333333";
    emoji.style.transform = "translateX(-300px)"
  }

  stars[4].onclick = function(){
    stars[0].style.color = "#EE5E3F";
    stars[1].style.color = "#EE5E3F";
    stars[2].style.color = "#EE5E3F";
    stars[3].style.color = "#EE5E3F";
    stars[4].style.color = "#EE5E3F";
    emoji.style.transform = "translateX(-400px)"
  }


const btn = document.querySelectorAll(".btn1 span");

for (let i = 0; i < btn.length; i++) {
  btn[i].addEventListener("click", function() {
    document
      .querySelector(
        "nav .dot.step_" + (parseInt(this.getAttribute("data-step")) + 1) + ""
      )
      .classList.add("done");
    turn(parseInt(this.getAttribute("data-step")));
  });
}

function turn(step) {
  if (!!document.querySelector("#step__" + (step - 1))) {
    document.querySelector("#step__" + (step - 1)).classList.add("hidden");
  }

  document.querySelector("#step__" + step).classList.add("cube__face--top");
  document.querySelector("#step__" + step).classList.remove("cube__face--front");

  step += 1;
  if (!!document.querySelector("#step__" + step)) {
    document.querySelector("#step__" + step).classList.add("cube__face--front");
    if (!!document.querySelector("#step__" + step + " input")) {
      document.querySelector("#step__" + step + " input").focus();
    }
    document
      .querySelector("#step__" + step)
      .classList.remove("cube__face--bottom");
  }

  step += 1;
  if (!!document.querySelector("#step__" + step)) {
    document.querySelector("#step__" + step).classList.add("cube__face--bottom");
  }
}
</script-->

</body>
</html> 
