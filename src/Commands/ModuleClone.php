<?php

namespace hamkamannan\adminigniter\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Autoload;

/**
 * Class PublishCommand.
 */
class ModuleClone extends BaseCommand
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
    protected $name = 'module:clone';

    /**
     * The command's short description.
     *
     * @var string
     */
    protected $description = 'Clone Adminigniter HMVC Modules in app/Adminigniter/Modules folder (Available for Dashboard, Report, Banner, Page)';

    /**
     * The command's usage.
     *
     * @var string
     */
    protected $usage = 'module:clone';

    /**
     * The commamd's argument.
     *
     * @var array
     */
    protected $arguments = [ 'ModuleName' => 'Module name to be created' ];

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
    protected $module_name;
    protected $view_folder;
    protected $sourcePath;

    //--------------------------------------------------------------------

    /**
     * Displays the help for the spark cli script itself.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        helper('inflector');
        $this->determineSourcePath();

        $this->module_name = $params[0];

        if(!isset($this->module_name))
        {
            CLI::write(CLI::color('  error: ', 'red')."Module name must be set");
            return;
        }

        $this->module_name = ucfirst($this->module_name);

        $this->publishModule('Backend');
    }

    protected function publishModule($module_type = 'Backend')
    {
        $src = "{$this->sourcePath}/Adminigniter/Modules/{$module_type}/{$this->module_name}";
        $dst = APPPATH . "Adminigniter/Modules/{$module_type}/{$this->module_name}";

        if (!file_exists($dst)) {
            $this->recurseCopy($src, $dst);
            CLI::write(CLI::color('  info: ', 'blue')."Module {$this->module_name} has been cloned");

            if($this->module_name == 'Banner' || $this->module_name == 'Page'){
                $this->publishMigration();
            }
        } else {
            CLI::write(CLI::color('  error: ', 'red')."Module {$this->module_name} already exist");
        }
    }

    protected function publishMigration()
    {
        $prefix = date("Y-m-d-His");

        $src = "{$this->sourcePath}/Adminigniter/Database/Migrations/{$this->module_name}.php";
        $dst = "Adminigniter/Database/Migrations/{$prefix}_{$this->module_name}.php";
        $content = file_get_contents($src);
        $content = str_replace('Sample', $this->module_name, $content);
        $content = str_replace('sample', strtolower($this->module_name), $content);

        $this->writeFile($dst, $content);
    }

    //--------------------------------------------------------------------
    // Utilities
    //--------------------------------------------------------------------

    /**
     * Determines the current source path from which all other files are located.
     */
    protected function determineSourcePath()
    {
        $this->sourcePath = realpath(__DIR__.'/../');

        if ($this->sourcePath == '/' || empty($this->sourcePath)) {
            CLI::error('Unable to determine the correct source directory.');
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
            write_file($appPath.$path, $content);
        } catch (\Exception $e) {
            $this->showError($e);
            exit();
        }

        $path = str_replace($appPath, '', $path);

        CLI::write(CLI::color('  created: ', 'green').$path);
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
