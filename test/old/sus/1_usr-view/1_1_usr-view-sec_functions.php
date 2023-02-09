<?php 

function sanitize_post() {
    $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? NULL;
}