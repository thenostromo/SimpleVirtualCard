<?php
spl_autoload_register ('autoload');

/**
 * @param string $className
 * @return string|null
 */
function autoload ($className)
{
    $className = str_replace("\\", "/", $className);if ($className === "v") {var_dump(12); exit();}
    require "core/" . $className . '.php';
}
