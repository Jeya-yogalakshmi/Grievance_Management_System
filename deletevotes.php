<?php

require_once ("DbConn.php");
session_start();

$feedback_id=$_POST['feedback_id'];
$student_id=$_POST['student_id'];
$upvotes=$_POST['upvotes'];
$downvotes=$_POST['downvotes'];

 $query="delete from votes where feedbackId=$feedback_id and StudentId=$student_id and UpVote=$upvotes and DownVote=$downvotes";
 $result=mysqli_query($con,$query);
if($con->error){
	echo $con->error;
}

$query="select FeedbackId,UpVote_Count,DownVote_Count from feedbackdetails where FeedbackId=$feedback_id";
$result=mysqli_query($con,$query);
$updated_upvote=0;
$updated_downvote=0;
if($result->num_rows>0){
	while($row=mysqli_fetch_array($result)){
		$updated_upvote=$row['UpVote_Count']-$upvotes;
		$updated_downvote=$row['DownVote_Count']-$downvotes;
	}
}

$query="update feedbackdetails set UpVote_Count=$updated_upvote,DownVote_Count=$updated_downvote";
$result=mysqli_query($con,$query);

?>
