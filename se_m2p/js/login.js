function display_class(target_class, display_type) {
    const classes = document.querySelectorAll('.' + target_class);
    classes.forEach((item) => {
        item.style.display = display_type;
    });
}

function set_visibility_log(direction) { // Showing elements user should see based on their login status
    console.log('Executing set_visibility_log("' + direction + '")');
    // document.getElementById('grid_container_nav').insertAdjacentHTML('afterbegin', 'Logged in');

    if (direction == "in") { // logged in
        display_class('display_block_if_logged_in', 'block');
        display_class('display_block_if_logged_out', 'none');
        display_class('display_grid_if_logged_in', 'grid');
        display_class('display_grid_if_logged_out', 'none');
    } else { // logged out
        display_class('display_block_if_logged_in', 'none');
        display_class('display_block_if_logged_out', 'block');
        display_class('display_grid_if_logged_in', 'none');
        display_class('display_grid_if_logged_out', 'grid');
    }
}

function set_js_username_log(direction) { // fetch username from PHP to LS and view it
    if (direction == "in") {
        $.ajax({
            url: "/fetch_username.php",
            type: "POST",
            success: function (result) {
                console.log('Executing set_js_username_log("' + direction + '") with Ajax. Result: ' + result);
                localStorage.setItem('logged_in_user', result);
                document.getElementById('nav_username').innerHTML = localStorage.getItem('logged_in_user');
            }
        });
    } else { // direction = "out" = logout
        localStorage.removeItem('logged_in_user');
    }
}

function view_user_logged(direction) { // Sets the website elements to be viewed for logged-in user as well as for logged-out user
    set_visibility_log(direction); // log"in" or log"out"
    set_js_username_log(direction);
}