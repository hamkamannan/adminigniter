<?php

namespace hamkamannan\adminigniter\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Autoload;

/**
 * Class PublishCommand.
 */
class ModuleCreate extends BaseCommand
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
    protected $name = 'module:create';

    /**
     * The command's short description.
     *
     * @var string
     */
    protected $description = 'Create Adminigniter HMVC Modules in app/Adminigniter/Modules folder';

    /**
     * The command's usage.
     *
     * @var string
     */
    protected $usage = 'module:create';

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
    protected $module_folder;
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
            CLI::error("Module name must be set!");
            return;
        }

        $this->module_name = ucfirst($this->module_name);
        $this->module_folder = 'Adminigniter/'.$this->module_name;

        $this->publishMigration();
        $this->publisConfig('Routes');
        $this->publisController();
        $this->publisController(true);
        $this->publisModel();
        $this->publisView('list');
        $this->publisView('add');
        $this->publisView('update');
    }

    protected function publishMigration()
    {
        $file_from = "Sample";
        $file_to = $this->module_name;
        $prefix = date("Y-m-d-His");

        $src = "{$this->sourcePath}/Adminigniter/Database/Migrations/{$file_from}.php";
        $dst = "Adminigniter/Database/Migrations/{$prefix}_{$file_to}.php";
        $content = file_get_contents($src);
        $content = str_replace('Sample', $this->module_name, $content);
        $content = str_replace('sample', strtolower($this->module_name), $content);

        $this->writeFile($dst, $content);
    }

    protected function publisConfig($view = 'Routes')
    {
        $file_from = "Sample";
        $file_to = $this->module_name;

        $src = "{$this->sourcePath}/Adminigniter/Modules/Backend/{$file_from}/Config/{$view}.php";
        $dst = "Adminigniter/Modules/Backend/{$file_to}/Config/{$view}.php";

        $content = file_get_contents($src);
        $content = str_replace('Sample', $this->module_name, $content);
        $content = str_replace('sample', strtolower($this->module_name), $content);

        $this->writeFile($dst, $content);
    }

    protected function publisController($api = false)
    {
        $file_from = "Sample";
        $file_to = $this->module_name;

        if($api){
            $src = "{$this->sourcePath}/Adminigniter/Modules/Backend/{$file_from}/Controllers/Api/{$file_from}.php";
            $dst = "Adminigniter/Modules/Backend/{$file_to}/Controllers/Api/{$file_to}.php";
        } else {
            $src = "{$this->sourcePath}/Adminigniter/Modules/Backend/{$file_from}/Controllers/{$file_from}.php";
            $dst = "Adminigniter/Modules/Backend/{$file_to}/Controllers/{$file_to}.php";
        }

        $content = file_get_contents($src);
        $content = str_replace('Sample', $this->module_name, $content);
        $content = str_replace('sample', strtolower($this->module_name), $content);

        $this->writeFile($dst, $content);
    }

    protected function publisModel()
    {
        $file_from = "Sample";
        $file_to = $this->module_name;

        $src = "{$this->sourcePath}/Adminigniter/Modules/Backend/{$file_from}/Models/{$file_from}Model.php";
        $dst = "Adminigniter/Modules/Backend/{$file_to}/Models/{$file_to}Model.php";

        $content = file_get_contents($src);
        $content = str_replace('Sample', $this->module_name, $content);
        $content = str_replace('sample', strtolower($this->module_name), $content);

        $this->writeFile($dst, $content);
    }

    protected function publisView($view = 'list')
    {
        $file_from = "Sample";
        $file_to = $this->module_name;

        $src = "{$this->sourcePath}/Adminigniter/Modules/Backend/{$file_from}/Views/{$view}.php";
        $dst = "Adminigniter/Modules/Backend/{$file_to}/Views/{$view}.php";

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
}
