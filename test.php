<!DOCTYPE html>
<html>

<head>
<script src="https://www.fabelastisch.de/TeeWorkOneServer/jquery-3.1.1.min.js"></script>
<!--<script src="https://www.fabelastisch.de/TeeWorkOneServer/json2.js"></script>-->
</head>
<body>hi
<script>
jQuery(document).ready(function($) {
	var ws_unique_id = "";
	
	//Webservice create Connection
	$.ajax({
		url: "https://www.fabelastisch.de/TeeWorkOneServer/interface.php",
		data: {
			tag: "connect",
			data: JSON.stringify( {
				email: "mptrace@googlemail.com",
				password: "TeeWorkOne",
			}),
		},
		success: function(result) {
			result = JSON.parse(result);
			ws_unique_id = result['data'];
			$("#result").html($("#result").html()+"connection up "+ws_unique_id+"<br>");
		},
		async: false
	});

	//login
	$.ajax({
		url: "https://www.fabelastisch.de/TeeWorkOneServer/interface.php",
		data: {
			tag: "login",
			data: JSON.stringify( {
				ws_unique_id: ws_unique_id,
				email: "mptrace@googlemail.com",
				password: "TeeWorkOne",
			}),
		},
		success: function(result) {
			result = JSON.parse(result);
			tw_unique_id = result['data'];
			$("#result").html($("#result").html()+"login "+tw_unique_id+"<br>");
		},
		async: false
	});

	//add user
	$.ajax({
		url: "https://www.fabelastisch.de/TeeWorkOneServer/interface.php",
		data: {
			tag: "addUser",
			data: JSON.stringify( {
				ws_unique_id: ws_unique_id,
				user: "mmo",
				email: "mptrace@googlemail.com",
				password: "TeeWorkOne",
			}),
		},
		success: function(result) {
			console.log(result);
			result = JSON.parse(result);
			hulu = result['data'];
			$("#result").html($("#result").html()+hulu+"<br>");
		},
		async: false
	});
	//give it another try
	$.ajax({
		url: "https://www.fabelastisch.de/TeeWorkOneServer/interface.php",
		data: {
			tag: "login",
			data: JSON.stringify( {
				ws_unique_id: ws_unique_id,
				email: "mptrace@googlemail.com",
				password: "TeeWorkOne",
			}),
		},
		success: function(result) {
			result = JSON.parse(result);
			tw_unique_id = result['data'];
			$("#result").html($("#result").html()+"2ndlogin "+tw_unique_id+"<br>");
		},
		async: false
	});
	
});
</script>
<div id="result">result<br></div>
</body>
</html>