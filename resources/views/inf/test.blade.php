<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<style>
		
	.toast {
    position: fixed;
    top: 50px;
    left: 80%;
    transform: translateX(-50%);
    
    color: #000;
    padding: 15px 20px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    z-index: 9999;
    opacity: 0;
    transition: opacity 0.5s ease-in-out;
    max-width: 90%; /* Set maximum width */
    width: 300px; /* Set default width */

background-color: #FA8BFF;
background-image: linear-gradient(45deg, #FA8BFF 0%, #2BFF88 3%, #2BD2FF 100%);

}

@media (max-width: 600px) {
    .toast {
        width: 70%; /* Adjust width for smaller screens */
    }
}

.show {
    opacity: 1;
}
	</style>
	<script>
		document.addEventListener('DOMContentLoaded', function() {
    var toast = document.getElementById('toast');

    // Show the toast
    toast.classList.add('show');

    // Hide the toast after 5 seconds (5000 milliseconds)
    setTimeout(function() {
        toast.classList.remove('show');
    }, 5000);
});
	</script>
</head>
<body>
	<div class="toast" id="toast">Data added sucessfully</div>
</body>
</html>