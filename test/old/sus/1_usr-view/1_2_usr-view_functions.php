<?php

function show_default_or_fetched() {
    $result = $_SESSION['result'] ?? NULL;
    if ($result === NULL) {
        $default = "default view";
        $result = $default;
    }
    echo $result;
}