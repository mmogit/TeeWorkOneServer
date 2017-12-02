<!DOCTYPE html>
<html>

<head>
<script src="https://tee.fabelastisch.de/TeeWorkOneServer/jquery-3.1.1.min.js"></script>
<!--<script src="https://www.fabelastisch.de/TeeWorkOneServer/json2.js"></script>-->
</head>
<body>hi
<script>
jQuery(document).ready(function($) {
	console.log("drin");
	var USERNAME = "TeeWork1";
	var PASSWORD = "MyTeePW";
    $.ajax({
		url: "https://tee.fabelastisch.de/TeeWorkOneServer/interface.php",
		data: {
			action: "getRatings",
			data: JSON.stringify( {
			}),
		},

		//username: USERNAME,
		//password: PASSWORD,
		success: function(result) {
			console.log(result);
			result = JSON.parse(result);
			res = result['data'];
			$("#result").html($("#result").html()+res+"<br>");
		},
		async: false
	});
	$.ajax({
		url: "https://tee.fabelastisch.de/TeeWorkOneServer/interface.php",
		data: {
			action: "getTeas",
			data: JSON.stringify( {
			}),
		},

		//username: USERNAME,
		//password: PASSWORD,
		success: function(result) {
			console.log(result);
			result = JSON.parse(result);
			res = result['data'];
			$("#result").html($("#result").html()+res+"<br>");
		},
		async: false
	});
	$.ajax({
		url: "https://tee.fabelastisch.de/TeeWorkOneServer/interface.php",
		data: {
			action: "getUser",
			data: JSON.stringify( {
				email: "mptrace@googlemail.com",
				password: "TeeWorkOne",
			}),
		},

		//username: USERNAME,
		//password: PASSWORD,
		success: function(result) {
			console.log(result);
			result = JSON.parse(result);
			res = result['data'];
			$("#result").html($("#result").html()+res+"<br>");
		},
		async: false
	});
	
	//add user
	/*$.ajax({
		url: "https://tee.fabelastisch.de/TeeWorkOneServer/interface.php",
		data: {
			action: "addUser",
			data: JSON.stringify( {
				register_username: "mmo",
				register_email: "mptrace@googlemail.com",
				register_password: "TeeWorkOne",
			}),
		},
		success: function(result) {
			console.log(result);
			result = JSON.parse(result);
			res = result['data'];
			$("#result").html($("#result").html()+res+"<br>");
		},
		async: false
	});
	/*
	//add rating unit
	$.ajax({
		url: "https://tee.fabelastisch.de/TeeWorkOneServer/interface.php",
		data: {
			action: "addRatingUnit",
			data: JSON.stringify( {
				title: "4",
			}),
		},
		success: function(result) {
			console.log(result);
			result = JSON.parse(result);
			res = result['data'];
			$("#result").html($("#result").html()+res+"<br>");
		},
		async: false
	});
	//add tea
	$.ajax({
		url: "https://tee.fabelastisch.de/TeeWorkOneServer/interface.php",
		data: {
			action: "addTea",
			data: JSON.stringify( {
				brand: "Teekanne",
				name: "Granatapfel",
				steeping_time: "5-8",
			}),
		},
		success: function(result) {
			console.log(result);
			result = JSON.parse(result);
			res = result['data'];
			$("#result").html($("#result").html()+res+"<br>");
		},
		async: false
	});
	//add rating
	//add tea
	$.ajax({
		url: "https://tee.fabelastisch.de/TeeWorkOneServer/interface.php",
		data: {
			action: "addRating",
			data: JSON.stringify( {
				id_tea: "1",
				id_user: "1",
				id_rating_unit: "2",
				taste: "1",
				smell: "1",
			}),
		},
		success: function(result) {
			console.log(result);
			result = JSON.parse(result);
			res = result['data'];
			$("#result").html($("#result").html()+res+"<br>");
		},
		async: false
	});
    */
		
});
</script>
<div id="result">result<br></div>
</body>
</html>