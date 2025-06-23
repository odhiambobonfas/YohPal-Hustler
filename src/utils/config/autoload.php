<?php

/*
|--------------------------------------------------------------------------
| Application Autoloader Configuration
|--------------------------------------------------------------------------
| This section defines the PSR-4 autoloading rules for the Yohpal Marketplace
| Web Application, handcrafted and maintained by Bernard Kung'u Wang'ang'a.
| 
| Each namespace path mapping under this section is carefully structured
| to reflect the project's modular architecture — separating concerns
| across Application Core, Utilities, Models, and both Web & API controllers.
| 
| These mappings ensure that classes are automatically discovered and loaded
| without the need for manual require/include calls. To reflect any updates 
| to this mapping, always execute: `composer dump-autoload`
| 
| Bernard Kung'u Wang'ang'a retains full authorship and architectural rights 
| over this structure as part of the broader Yohpal system framework. 
| This autoload section is a foundational part of the system’s 
| dependency resolution and developer experience.
|
| © 2025 Bernard Kung'u Wang'ang'a — All rights reserved.
*/

try {
    function findClassInDirectory($class, $directory) {
        // Normalize the class to file format by replacing the namespace with directory separators
        $classFile = str_replace('\\', '/', $class) . '.php'; 
        
        // Use DirectoryIterator to open the directory
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory));

        // Loop through the directory and subdirectories
        foreach ($iterator as $file) { 
            if (!$file->isDir() && $file->getFilename() === basename($classFile)) {
                return $file->getRealPath();
            }
        }

        // Return false if the file is not found
        return false;
    }

    function my_autoloader($class) {
        // Get the namespaces and directories mapping from the config
        $namespace_map = config('SPL_NAMESPACING', 'system');

        // Loop through the namespace map to search for the class
        foreach ($namespace_map as $namespace => $directory) { 
            if (strpos($class, $namespace) == 0) { 
                $classWithoutNamespace = str_replace($namespace, '', $class); 
                $classFile = str_replace('\\', '/', $classWithoutNamespace) . '.php'; 
                $filePath = getcwd() . '/' . $directory . $classFile;  
                $filePath = findClassInDirectory($class, getcwd() . DIRECTORY_SEPARATOR . $directory);

                if ($filePath) {
                    require_once $filePath;
                    return;
                }
            }
        } 
        
        throw new \Exception("Class $class not found!");
    }

    // Register the autoloader
    spl_autoload_register('my_autoloader');
} catch (\Throwable $th) {
    echo $th->getMessage();
    exit;
}