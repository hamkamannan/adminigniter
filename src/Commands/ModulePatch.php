<?php

namespace hamkamannan\adminigniter\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Autoload;

/**
 * Class PublishCommand.
 */
class ModulePatch extends BaseCommand
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
    protected $name = 'module:patch';

    /**
     * The command's short description.
     *
     * @var string
     */
    protected $description = 'Patch Module to HMVC Pattern.';

    /**
     * The command's usage.
     *
     * @var string
     */
    protected $usage = 'module:patch';

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

        // Module Patch (HMVC)
        if (CLI::prompt('Patching Igniter Module to HMVC?', ['y', 'n']) == 'y')
        {
            $this->publishPatch();
        }
    }
 
    protected function publishPatch()
    {
        $src = $this->sourcePath . '/Asset/patch/View.php.bak';
        $dst = ROOTPATH . 'vendor/codeadminigniter4/framework/system/View/View.php';

        $content = file_get_contents($src);

        write_file($dst, $content);

        CLI::write(CLI::color('  created: ', 'green').$dst);
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
