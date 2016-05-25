// jQuery for asynhronous form submission
$(function() {
		$("#submitThatForm").click(function(e){
			e.preventDefault();
			$.ajax({
				type: 'POST',
				url: '../html/createelection2.php',
				data: $("#thatForm").serialize(),
				success: function(msg) {
					console.log(msg);
				},
				error:function(msg){
					console.log(msg+"error");
				}
			});
		});
});
function genFields(posts){
	var text = "";
	var text2="";
	console.log(posts);
	text = posts;
	if(text>20|| text<1){
		document.getElementById('dem').innerHTML = '<span style="color:red;float:left;">Enter a value between 1 and 20</span>';
		document.getElementById('dem1').innerHTML = '';
	}else{
		document.getElementById('dem').innerHTML = 'Post(s)<br>';
		document.getElementById('dem1').innerHTML = 'Pin(s)<br>';


		for(var i=0; i<text; i++) {
			var currentPost='post'+i;
			var currentPin='pin'+i;
//                    text2 += "<input type='text'><br>";
			document.getElementById('dem').innerHTML  += "<input class='form-control' type='text' name="+currentPost+" required><br>";
			document.getElementById('dem1').innerHTML  += "<input class='form-control' type='text' name="+currentPin+" required><br>";
		}

	}
}