<?php
// Hide raw errors from users
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Log errors to file
ini_set("log_errors", 1);
ini_set("error_log", __DIR__ . "/error.log");

// Custom error handler
function customError($errno, $errstr, $errfile, $errline) {
    error_log("Error [$errno] $errstr in $errfile on line $errline");

    echo "
    <div class='error-box'>
        ⚠️ Something went wrong. Please try again.
    </div>
    ";

    return true;
}

// Exception handler
function customException($exception) {
    error_log("Exception: " . $exception->getMessage());

    echo "
    <div class='error-box'>
        ❌ System error occurred. Contact admin.
    </div>
    ";
}

set_error_handler("customError");
set_exception_handler("customException");
?>