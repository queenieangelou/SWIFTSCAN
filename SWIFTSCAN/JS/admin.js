let menuIcon = document.querySelector('#menu-icon');
let navbar = document.querySelector('.navbar');

menuIcon.onclick = () => {
    navbar.classList.toggle('open');
};

// Close the menu if the user clicks outside of it
window.addEventListener('click', function (event) {
    let target = event.target;

    if (!target.matches('#menu-icon') && !target.closest('.navbar')) {
        navbar.classList.remove('open');
    }
});

// Show or hide Faculty and Student on hover or click
let navbarLinks = document.querySelectorAll('.navbar a');

navbarLinks.forEach((link) => {
    link.addEventListener('click', () => {
        // Check if the clicked link is Faculty or Student
        if (link.classList.contains('faculty') || link.classList.contains('student')) {
            // Toggle the visibility of Faculty and Student links
            link.classList.toggle('active');
        }
    });
});

function logout() {
    // Perform any necessary logout operations (clearing session, etc.)

    // Redirect to login.php
    window.location.href = 'adminlogin.php';
}

