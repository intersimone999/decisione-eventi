$(document).ready(function() {
	$(".iconCar").click(function() {
		window.location.href = 'cars.php';
	});
	
	$(".iconHome").click(function() {
		window.location.href = 'dispatch.php';
	});
	
	$(".iconLogout").click(function() {
		window.location.href = '../logout.php';
	});
});