function openForm() {
  document.getElementById("popupForm").style.display = "block";
}
function closeForm() {
  document.getElementById("popupForm").style.display = "none";
}

$(window).onscroll (function() {
  $(tab).toggleClass('scrolled',$(this).ScrollTop()>50);
});

/*var navbar = document.getElementsByClassName("tab");
var sticky = navbar.offsetTop;

function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}
*/

function downvote(x,feedback_id,student_id) {
  var a=document.getElementById('downvotes'+feedback_id);
  var b=document.getElementById('upvotes'+feedback_id);
  var color1 = a.style.color;
  if(color1=="#EE5E3F"){
    a.style.color = "black";
    decrementVote(feedback_id,student_id,0,1);

  }
  else{
    a.style.color = "#EE5E3F";
    b.style.color = "black";
    incrementVote(feedback_id,student_id,0,1);
  }
}

function upvote(x,feedback_id,student_id) {
  var a=document.getElementById('upvotes'+feedback_id);
  var b=document.getElementById('downvotes'+feedback_id);
  var color1 = a.style.color;
  if(color1=="#EE5E3F"){
    a.style.color = "black";
    decrementVote(feedback_id,student_id,1,0);
  }
  else{
    a.style.color = "#EE5E3F";
    b.style.color = "black";
    incrementVote(feedback_id,student_id,1,0);
  }
}

function incrementVote(feedback_id,student_id,upvotes,downvotes){
  $.ajax({
    url:'insertvotes.php',
    type:'post',
    data:{feedback_id:feedback_id,student_id:student_id,upvotes:upvotes,downvotes:downvotes},
    success:function(response){
    },
    error:function(xhr,status,error){
    }
  })
}


function decrementVote(feedback_id,student_id,upvotes,downvotes){
  $.ajax({
    url:'deletevotes.php',
    type:'post',
    data:{feedback_id:feedback_id,student_id:student_id,upvotes:upvotes,downvotes:downvotes},
    success:function(response){
    },
    error:function(xhr,status,error){
    }
  })
}

function openCity(tabPage) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  if(tabPage=="NewFeedback"){
   openForm();
  }
  else{
    document.getElementById(tabPage).style.display = "block";   
  }
  evt.currentTarget.className += " active";
}

function myFunction(){
    var url_string = window.location.href
    var url = new URL(url_string);
    var inserted = url.searchParams.get("inserted");
    if(inserted==1){
    	openCity('YourFeedback');
    }
    else{
    	openCity('About');
    }
}

 $(".switch").onclick(function () {
  var text = document.getElementById('status');
  alert(text);
 });