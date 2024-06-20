document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('signUpForm');
    form.addEventListener('submit', function(event) {
        var password = document.getElementById('password').value;
        var confirm_password = document.getElementById('confirm_password').value;

        if (password !== confirm_password) {
            event.preventDefault();
            alert('Passwords do not match. Please try again.');
        }
    });
});
