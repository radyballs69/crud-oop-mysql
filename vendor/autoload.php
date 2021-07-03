<?php

if (! function_exists('env')) {
    function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return $default;
        }

        return $value;
    }
}

if (file_exists($env_file = 'env.php')) {
    require_once $env_file;
} else die("Error: Missing $env_file.");

if (file_exists($helpers_file = 'app/Helpers/functions.php')) {
    require_once $helpers_file;
} else die("Error: Missing $helpers_file.");

spl_autoload_register(function($class) {
    $class_file = $class .'.php';

    if (file_exists($class_file)) 
        include_once $class_file;
    else 
        die("Error : Can't locate specified class ($class_file).");

    //class directories
    // $directories = array(
    //     '/',
    //     'app/',
    //     'app/Controller/',
    //     'app/Database/',
    //     'app/Database/Traits'
    // );
   
    // //for each directory
    // foreach($directories as $directory)
    // {
    //     //see if the file exsists
    //     if(file_exists($directory . $class . '.php'))
    //     {
    //         require_once($directory.$class . '.php');
    //         //only require the class once, so quit after to save effort (if you got more, then name them something else
    //         return;
    //     }           
    // }
});


?>