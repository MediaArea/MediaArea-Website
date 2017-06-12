<?php
if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    echo $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    echo $_SERVER['SERVER_ADDR'];
}
?>
