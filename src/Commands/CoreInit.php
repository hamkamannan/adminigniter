<?php

namespace hamkamannan\adminigniter\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Autoload;

/**
 * Class PublishCommand.
 */
class CoreInit extends BaseCommand
{
    /**
     * The group the command is lumped under
     * when listing commands.
     *
     * @var string
     */
    protected $group = 'adminigniter';

    /**
     * The command's name.
     *
     * @var string
     */
    protected $name = 'core:init';

    /**
     * The command's short description.
     *
     * @var string
     */
    protected $description = 'Initialize Adminigniter Core.';

    /**
     * The command's usage.
     *
     * @var string
     */
    protected $usage = 'core:init';

    /**
     * The commamd's argument.
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The command's options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * The path to hamkamannan\adminigniter\src directory.
     *
     * @var string
     */
    protected $sourcePath;

    //--------------------------------------------------------------------

    /**
     * Displays the help for the spark cli script itself.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $this->determineSourcePath();

        CLI::write(CLI::color("Info: Adminigniter Initialization", "green"));

        //Config
        $this->publishConfig();

        // Migration
        $this->publishMigration();

        // Seed
        $this->publishMigration();
    }

    protected function publishConfig()
    {
        $configPath = "{$this->sourcePath}/Config";

        $src = "{$this->configPath}/Auth.php";
        $dst = APPPATH. "Config/Auth.php";

        if (!file_exists($dst))
        {
            $template = file_get_contents($src);
            $template = str_replace('namespace hamkamannan\adminigniter\Config', 'namespace Config', $template);

            file_put_contents($dst, $template);
        }
        else
        {
            CLI::write(CLI::color("Error: Auth Config already exists!\n", "red"));
        }
    }

    protected function publishMigration()
    {
        $map = directory_map($this->sourcePath.'/Database/Migrations');
        $migrationPath = "{$this->sourcePath}/Database/Migrations";

        foreach ($map as $file) {
            $src = "{$this->sourcePath}/Database/Migrations/{$file}";
            $dst = APPPATH. "Database/Migrations/{$file}";

            if (!file_exists($dst))
            {
                $template = file_get_contents($src);
                $template = str_replace('namespace hamkamannan\adminigniter\Database\Migrations', 'namespace '.APP_NAMESPACE.'\Database\Migrations', $template);
    
                file_put_contents($dst, $template);
            }
            else
            {
                CLI::write(CLI::color("\nError: Migration File already exists!", "red"));
                CLI::write(CLI::color("File: Migration:{$file}", "white"));
            }
        }
    }

    protected function publishSeed()
    {
        $map = directory_map($this->sourcePath.'/Database/Seeds');
        $seedPath = "{$this->sourcePath}/Database/Seeds";

        foreach ($map as $file) {
            $src = "{$this->seedPath}/{$file}";
            $dst = APPPATH. "Database/Seeds/{$file}";
            
            if (!file_exists($dst))
            {    
                $template = file_get_contents($src);
                $template = str_replace('namespace hamkamannan\adminigniter\Database\Seeds', 'namespace '.APP_NAMESPACE.'\Database\Seeds', $template);
    
                file_put_contents($dst, $template);
            }
            else
            {
                CLI::write(CLI::color("Error: Seed File already exists!\n", "red"));
                CLI::write(CLI::color("File: ".$file."\n", "white"));
            }
        }
    }

    //--------------------------------------------------------------------
    // Utilities
    //--------------------------------------------------------------------

    /**
     * Replaces the Myth\Auth namespace in the published
     * file with the applications current namespace.
     *
     * @param string $contents
     * @param string $originalNamespace
     * @param string $newNamespace
     *
     * @return string
     */
    protected function replaceNamespace(string $contents, string $originalNamespace, string $newNamespace): string
    {
        $appNamespace = APP_NAMESPACE;
        $originalNamespace = "namespace {$originalNamespace}";
        $newNamespace = "namespace {$appNamespace}\\{$newNamespace}";

        return str_replace($originalNamespace, $newNamespace, $contents);
    }

    /**
     * Determines the current source path from which all other files are located.
     */
    protected function determineSourcePath()
    {
        $this->sourcePath = realpath(__DIR__.'/../');

        if ($this->sourcePath == '/' || empty($this->sourcePath)) {
            CLI::error('Unable to determine the correct source directory. Bailing.');
            exit();
        }
    }

    /**
     * Write a file, catching any exceptions and showing a
     * nicely formatted error.
     *
     * @param string $path
     * @param string $content
     */
    protected function writeFile(string $path, string $content)
    {
        $config = new Autoload();
        $appPath = $config->psr4[APP_NAMESPACE];

        $directory = dirname($appPath.$path);

        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        try {
            if(file_exists()){
                write_file($appPath.$path, $content);
                CLI::write(CLI::color('  created: ', 'green').$path);
            } else {
                CLI::write(CLI::color('  file already exist: ', 'yellow').$path);
            }
        } catch (\Exception $e) {
            $this->showError($e);
            exit();
        }

        $path = str_replace($appPath, '', $path);
    }

    /**
     * Copy a folder
     *
     * @param string $src
     * @param string $dst
     * @param string $childFolder
     */

    protected function recurseCopy($src,$dst, $childFolder='') 
    { 
        if(is_dir($dst)){
            CLI::write(CLI::color('  directory already exist: ', 'yellow').$dst);
            exit();
        } 

        $dir = opendir($src); 
        @mkdir($dst);
        if ($childFolder!='') {
            @mkdir($dst.'/'.$childFolder);
    
            while(false !== ( $file = readdir($dir)) ) { 
                if (( $file != '.' ) && ( $file != '..' )) { 
                    if ( is_dir($src . '/' . $file) ) { 
                        $this->recurseCopy($src . '/' . $file,$dst.'/'.$childFolder . '/' . $file); 
                    } 
                    else { 
                        copy($src . '/' . $file, $dst.'/'.$childFolder . '/' . $file); 
                    }  
                } 
            }
        }else{
                // return $cc; 
            while(false !== ( $file = readdir($dir)) ) { 
                if (( $file != '.' ) && ( $file != '..' )) { 
                    if ( is_dir($src . '/' . $file) ) { 
                        $this->recurseCopy($src . '/' . $file,$dst . '/' . $file); 
                    } 
                    else { 
                        copy($src . '/' . $file, $dst . '/' . $file); 
                    }  
                } 
            } 
        }
        
        closedir($dir); 

        CLI::write(CLI::color('  created: ', 'green').$dst);
    }
}
