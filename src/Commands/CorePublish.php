<?php

namespace hamkamannan\adminigniter\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Autoload;

/**
 * Class PublishCommand.
 */
class CorePublish extends BaseCommand
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
    protected $name = 'core:publish';

    /**
     * The command's short description.
     *
     * @var string
     */
    protected $description = 'Publish Adminigniter Assets (Libraries, Uigniter Themes and Views).';

    /**
     * The command's usage.
     *
     * @var string
     */
    protected $usage = 'core:publish';

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
    protected $options      = [
        '-c' => '(L)ibrary for DataTables, [U]igniter assets and themes, (V)iews Layout Backend'
    ];

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

        CLI::write(CLI::color("Info: Adminigniter Publish", "green"));

        try
        {
            if (CLI::getOption('c') == '' || strstr(CLI::getOption('c'),'L')) {
                CLI::write(CLI::color("\nPublish for Libraries", "green"));

                $src = $this->sourcePath."/Asset/library/DataTables";
                $dst = APPPATH ."/Libraries/DataTables";
                $this->publish($src, $dst);
            }
            if (CLI::getOption('c') == '' || strstr(CLI::getOption('c'),'U')) {
                CLI::write(CLI::color("\nPublish for Uigniter", "green"));

                $src = $this->sourcePath."/Asset/public/assets";
                $dst = ROOTPATH ."/public/assets";
                $this->publish($src, $dst);

                $src = $this->sourcePath."/Asset/public/themes/uigniter";
                $dst = ROOTPATH ."/public/themes/uigniter";
                $this->publish($src, $dst);
            }
            if (CLI::getOption('c') == '' || strstr(CLI::getOption('c'),'V')) {
                CLI::write(CLI::color("\nPublish for Views", "green"));

                $src = $this->sourcePath."/Views/layout/backend";
                $dst = APPPATH ."/Views/layout/backend";
                $this->publish($src, $dst);
            }

            CLI::write(CLI::color("", "white"));

        }
        catch (\Exception $e)
        {
            CLI::error($e);
        }
    }

    protected function publish($src, $dst)
    {
        if (!file_exists($dst))
        {
            $this->recurseCopy($src, $dst);
        }
        else
        {
            CLI::write(CLI::color("Warning: Directory already exists!", "yellow"));
            CLI::write(CLI::color("         --> {$dst}", "white"));
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
