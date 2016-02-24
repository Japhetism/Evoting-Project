// jQuery to collapse the navbar on scroll
$(window).scroll(function() {
    if ($(".navbar").offset().top > 50) {
        $(".navbar-fixed-top").addClass("top-nav-collapse");
    } else {
        $(".navbar-fixed-top").removeClass("top-nav-collapse");
    }
});

// jQuery for page scrolling feature - requires jQuery Easing plugin
$(function() {
		$('a.page-scroll').bind('click', function(event) {
			var $anchor = $(this);
			$('html, body').stop().animate({
				scrollTop: $($anchor.attr('href')).offset().top
			}, 1500, 'easeInOutExpo');
			event.preventDefault();
		});
	
		$("#formSubmit").click(function(e){
			e.preventDefault();
			$.ajax({
				type: 'POST',
				url: '../php/join.php',
				data: $("#thatForm").serialize(),
				success: function(msg) {
					console.log(msg);
					var success=document.getElementById('output');
					
					success.innerHTML=msg;
                    success.style.color="red";
				},
				error:function(msg){
					console.log(msg+"error");
				}
			});
		});
});

// Closes the Responsive Menu on Menu Item Click
$('.navbar-collapse ul li a').click(function() {
    $('.navbar-toggle:visible').click();
});

// swaps between the login and signup divs
/* function showLogin(){
    var login= document.getElementById('login');
    var signup= document.getElementById('signup');

    signup.style.display='none';
    login.style.display='block';
}

function showSignup(){
    var login= document.getElementById('login');
    var signup= document.getElementById('signup');

    signup.style.display='block';
    login.style.display='none';
} */


//show or hide a div
function showOrHideDiv(div_id){
	var div=document.getElementById(div_id);
	var div_visibility=div.style.display;
	if (div_visibility=='none'){
		div.style.display='block';
	}else{
		div.style.display='none';
	}
}

//toggles password types from text and password 
function showPassword(element_id,eye_id){
	var eye=document.getElementById(eye_id);
	var eyeicon=eye.getAttribute('class');
	var password=document.getElementById(element_id);
	if (eyeicon=="fa fa-eye"){
	password.setAttribute("type","text");
	eye.setAttribute("class","fa fa-eye-slash");
	}else{
	password.setAttribute("type","password");	
	eye.setAttribute("class","fa fa-eye");
	}
}

//clears modal on joining an election successfully 
function  joinSuccess(){
	document.getElementById('input').innerHTML="Election joined successfully"; 
	document.getElementById('input2').innerHTML=" "; 
	document.getElementById('myModalLabel').innerHTML="";  
}

//show posts for editing
function displayPosts(div_id){
	var posts=document.getElementById(div_id);
	var editPosts=posts.style.display;
	if(editPosts=="none"){
	posts.style.display="block";
	}else{
	posts.style.display="none";
	}
}
		
//show textboxes for posts input		
function myfunction(){
	var text = "";
	var text2="";
	text = document.getElementById('number_of_posts').value;
	if(text>20|| text<1){
		document.getElementById('dem').innerHTML = 'Enter a value between 1 and 20';
		document.getElementById('dem1').innerHTML = '';
	}else{
		document.getElementById('dem').innerHTML = 'Post(s)<br>';
		document.getElementById('dem1').innerHTML = 'Pin(s)<br>';


		for(var i=1; i<=text; i++) {
			var currentPost='post'+i;
			var currentPin='pin'+i;
//                    text2 += "<input type='text'><br>";
			document.getElementById('dem').innerHTML  += "<input type='text' name="+currentPost+" required><br>";
			document.getElementById('dem1').innerHTML  += "<input type='text' name="+currentPin+" required><br>";
		}

	}
}


//change list class to active
function showBar(list_item,n){
	var x=n;
	for(var i=0;i<n;i++){
		var listitem=document.getElementById(x);
		listitem.setAttribute('class','active');
		x--;
	}
	document.getElementById(list_item).setAttribute('class','active active1');
}


