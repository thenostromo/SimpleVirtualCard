<?php
spl_autoload_register ('autoload');
function autoload ($className) {
    $className = str_replace("\\", "/", $className);if ($className === "v") {var_dump(12); exit();}
    require "core/" . $className . '.php';
}
