 <style>
    
  .toastHH {
    position: fixed;
    top: 50px;
    right: 50px; /* Adjust this value to set the distance from the right edge */
    transform: translateX(100%); /* Start off-screen */
    color: white;
    padding: 15px 20px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    z-index: 9999;
    opacity: 0;
    transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
    max-width: 90%; /* Set maximum width */
    width: 300px; /* Set default width */
   background: #D31027;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #EA384D, #D31027);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #EA384D, #D31027); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */



}
@media (max-width: 600px) {
    .toastHH {
        width: 70%; /* Adjust width for smaller screens */
    }
}
.show {
    opacity: 1;
    transform: translateX(0); /* Move onto the screen */
}
  </style>
<div class="toastHH" id="toastHH"><{{ $message }}</div>
	<script>
        document.addEventListener('DOMContentLoaded', function() {
    var toast = document.getElementById('toastHH');

    // Show the toast
    toast.classList.add('show');

    // Hide the toast after 5 seconds (5000 milliseconds)
    setTimeout(function() {
        toast.classList.remove('show');
    }, 5000);
});

    </script>