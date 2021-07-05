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
    protected $description = 'Create CodeIgniter Modules (Default path: app/Modules).';

    /**
     * The command's usage.
     *
     * @var string
     */
    protected $usage = 'module:create [ModuleName] [Options]';

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
    protected $options      = [
        '-f' => 'Set module folder other than app/Modules (Example: -f app/Modules/Backend)',
        '-c' => 'Create only [M]odel, [V]iew, [C]ontroller, con[F]ig, [D]atabase, [L]anguage, [O]ther directories'
    ];

    /**
     * Module Name to be Created
     */
    protected $module_name;


    /**
     * Module folder (default /Modules)
     */
    protected $module_folder;
    protected $module_psr4;
    

    /**
     * View folder (default /View)
     */
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

        if(!isset($params[0]))
        {
            CLI::write(CLI::color("Warning: Module name must be set!", "yellow"));
            CLI::write(CLI::color("Usage: ".$this->usage."\n", 'white'));
            return;
        }

        $this->module_name = $params[0];

        if(strlen(preg_replace('/[^A-Za-z0-9]+/','',$this->module_name)) <> mb_strlen($this->module_name))
        {
            CLI::write(CLI::color("Warning: Module name must to be alpha numeric!", "yellow"));
            CLI::write(CLI::color("Usage: Allow characters A-Z or a-z, and can contain numbers 0-9\n", "white"));
            return;
        }

        $this->module_name = ucfirst($this->module_name);
        $module_folder = ucfirst(preg_replace('/[^A-Za-z0-9]+/','',$params['-f'] ?? CLI::getOption('f')));

        $default = 'Modules';
        $default_folder = basename(APPPATH).DIRECTORY_SEPARATOR.$default;
        $default_psr4 = "            '".$this->module_name . "' => ". 'APPPATH . ' ."'{$default}/{$this->module_name}',";
        $this->module_folderOrig = $default_folder;
        $this->module_folder = APPPATH . '..'. DIRECTORY_SEPARATOR. $this->module_folderOrig;
        
        if($module_folder){
            $this->module_folderOrig = $default_folder.DIRECTORY_SEPARATOR.$module_folder;
            $this->module_folder = APPPATH . '..'. DIRECTORY_SEPARATOR. $this->module_folderOrig;
            $default_psr4 = "            '".$this->module_name . "' => ". 'APPPATH . ' ."'{$default}/{$module_folder}/{$this->module_name}',";
        } 

        $this->module_psr4 = $default_psr4;
        
        if (!is_dir($this->module_folder)) {
            mkdir($this->module_folder);
        }

        $this->module_folder = realpath($this->module_folder);

        // CLI::write(CLI::color("Module Name: {$this->module_name}", "yellow"));
        // CLI::write(CLI::color("Module Path: {$this->module_folder}", "yellow"));
        // CLI::write(CLI::color("Module Psr4: {$this->module_psr4}", "yellow"));
        // return;

        CLI::write(CLI::color("Generate CRUD Module {$this->module_folderOrig}". DIRECTORY_SEPARATOR . "{$this->module_name}", "green"));
        
        if (!is_dir($this->module_folder . DIRECTORY_SEPARATOR . $this->module_name)) {
            mkdir($this->module_folder . DIRECTORY_SEPARATOR . $this->module_name, 0777, true);
        }

        try
        {
            if (CLI::getOption('c') == '' || strstr(CLI::getOption('c'),'M')) {
                CLI::write(CLI::color("\nGenerate Model", "green"));
                $this->createModel();
            }
            if (CLI::getOption('c') == '' || strstr(CLI::getOption('c'),'V')) {
                CLI::write(CLI::color("\nGenerate View", "green"));
                $this->createView('list');
                $this->createView('add');
                $this->createView('update');
            }
            if (CLI::getOption('c') == '' || strstr(CLI::getOption('c'),'C')) {
                CLI::write(CLI::color("\nGenerate Controller", "green"));
                $this->createController();
                $this->createController(true);
            }
            if (CLI::getOption('c') == '' || strstr(CLI::getOption('c'),'F')) {
                CLI::write(CLI::color("\nGenerate Config", "green"));
                $this->createConfig();
            }
            if (CLI::getOption('c') == '' || strstr(CLI::getOption('c'),'D')) {
                CLI::write(CLI::color("\nGenerate Database Migration & Seed", "green"));
                $this->createDir('Database', true);
                $this->createMigration();
                $this->createSeed();
            }
            if (CLI::getOption('c') == '' || strstr(CLI::getOption('c'),'L')) {
                CLI::write(CLI::color("\nGenerate Language", "green"));
                $this->createLanguage('en');
                $this->createLanguage('id');
            }
            if (CLI::getOption('c') == '' || strstr(CLI::getOption('c'),'O')) {
                CLI::write(CLI::color("\nGenerate Filter & Validation", "green"));
                $this->createDir('Filters', true);
                $this->createDir('Validation', true);
            }

            CLI::write(CLI::color("\nUpdate Autoload (app/Config/Autoload.php)", "green"));
            $this->updateAutoload();

            CLI::write(CLI::color("", "white"));

        }
        catch (\Exception $e)
        {
            CLI::error($e);
        }
    }

    /**
     * function createConfig
     */
    protected function createConfig()
    {
        $configPath = $this->createDir('Config');

        $src = "{$this->sourcePath}/Builder/Crud/Config/Routes.php";
        $dst = "{$this->module_folder}/".ucfirst($this->module_name)."/Config/Routes.php";

        if (!file_exists($dst))
        {
            $template = file_get_contents($src);
            $template = str_replace('Crud', ucfirst($this->module_name), $template);
            $template = str_replace('crud', strtolower($this->module_name), $template);

            file_put_contents($dst, $template);
        }
        else
        {
            CLI::write(CLI::color("Warning: Config already exists!", "yellow"));
            CLI::write(CLI::color("         --> {$this->module_folderOrig}". DIRECTORY_SEPARATOR . "{$this->module_name}/Config/Routes.php", "white"));
        }
    }

    /**
     * function createController
     */
    protected function createController($api = false)
    {
        $controllerPath = ($api) ? $this->createDir('Controllers/Api') : $this->createDir('Controllers');

        $apiPath = ($api) ? 'Api/' :'';
        $src = "{$this->sourcePath}/Builder/Crud/Controllers/". $apiPath ."Crud.php";
        $dst = "{$this->module_folder}/".ucfirst($this->module_name)."/Controllers/". $apiPath .ucfirst($this->module_name).".php";

        if (!file_exists($dst))
        {
            $template = file_get_contents($src);
            $template = str_replace('Crud', ucfirst($this->module_name), $template);
            $template = str_replace('crud', strtolower($this->module_name), $template);
            
            file_put_contents($dst, $template);
        }
        else
        {
            CLI::write(CLI::color("Warning: Controller already exists!", "yellow"));
            CLI::write(CLI::color("         --> {$this->module_folderOrig}". DIRECTORY_SEPARATOR . "{$this->module_name}/Controllers/{$apiPath}".ucfirst($this->module_name).".php", "white"));
        }
    }

    /**
     * function createModel
     */
    protected function createModel()
    {
        $modelPath = $this->createDir('Models');
        $src = "{$this->sourcePath}/Builder/Crud/Models/CrudModel.php";
        $dst = "{$this->module_folder}/".ucfirst($this->module_name)."/Models/".ucfirst($this->module_name)."Model.php";
        
        if (!file_exists($dst)) 
        {
            $template = file_get_contents($src);
            $template = str_replace('Crud', ucfirst($this->module_name), $template);
            $template = str_replace('crud', strtolower($this->module_name), $template);
            
            file_put_contents($dst, $template);
        }
        else
        {
            CLI::write(CLI::color("Warning: Model already exists!", "yellow"));
            CLI::write(CLI::color("         --> {$this->module_folderOrig}". DIRECTORY_SEPARATOR . "{$this->module_name}/Models/".ucfirst($this->module_name)."Model.php", "white"));
        }

    }

    /**
     * function createView
     */
    protected function createView($view = 'list')
    {
        $viewPath = $this->createDir('Views');
        $src = "{$this->sourcePath}/Builder/Crud/Views/{$view}.php";
        $dst = "{$this->module_folder}/".ucfirst($this->module_name)."/Views/{$view}.php";

        if (!file_exists($dst)) 
        {
            $template = file_get_contents($src);
            $template = str_replace('Crud', ucfirst($this->module_name), $template);
            $template = str_replace('crud', strtolower($this->module_name), $template);
            
            file_put_contents($dst, $template);
        }
        else
        {
            CLI::write(CLI::color("Warning: View already exists!", "yellow"));
            CLI::write(CLI::color("         --> {$this->module_folderOrig}". DIRECTORY_SEPARATOR . "{$this->module_name}/Views/{$view}.php", "white"));
        }
    }
 
    /**
     * function createDatabase
     */
    protected function createMigration()
    {
        $prefix = "2020-01-01-000000";
        $migrationPath = $this->createDir('Database/Migrations');

        $src = "{$this->sourcePath}/Builder/Crud/Database/Migrations/yyyy-mm-dd_Crud.php";
        $dst = "{$this->module_folder}/".ucfirst($this->module_name)."/Database/Migrations/{$prefix}_{$this->module_name}.php";

        if (!file_exists($dst)) 
        {
            $template = file_get_contents($src);
            $template = str_replace('Crud', ucfirst($this->module_name), $template);
            $template = str_replace('crud', strtolower($this->module_name), $template);
            
            file_put_contents($dst, $template);
        }
        else
        {
            CLI::write(CLI::color("Warning: Migration already exists!", "yellow"));
            CLI::write(CLI::color("         --> File: Migration:{$prefix}_{$this->module_name}", "white"));
        }
    }

    protected function createSeed()
    {
        $seedPath = $this->createDir('Database/Seeds');

        $src = "{$this->sourcePath}/Builder/Crud/Database/Seeds/CrudSeeder.php";
        $dst = "{$this->module_folder}/".ucfirst($this->module_name)."/Database/Seeds/{$this->module_name}Seeder.php";

        if (!file_exists($dst)) 
        {
            $template = file_get_contents($src);
            $template = str_replace('Crud', ucfirst($this->module_name), $template);
            $template = str_replace('crud', strtolower($this->module_name), $template);
            
            file_put_contents($dst, $template);
        }
        else
        {
            CLI::write(CLI::color("Warning: Seed already exists!", "yellow"));
            CLI::write(CLI::color("         --> File: Seed:{$this->module_name}Seeder", "white"));
        }
    }

    /**
     * function createLanguage
     */
    protected function createLanguage($lang = 'en')
    {
        $this->createDir('Language', true);

        $langPath = $this->createDir('Language/'.$lang);

        $src = "{$this->sourcePath}/Builder/Crud/Language/{$lang}/Crud.php";
        $dst = "{$this->module_folder}/".ucfirst($this->module_name)."/Language/{$lang}/{$this->module_name}.php";

        if (!file_exists($dst)) 
        {
            $template = file_get_contents($src);
            $template = str_replace('Crud', ucfirst($this->module_name), $template);
            $template = str_replace('crud', strtolower($this->module_name), $template);
            
            file_put_contents($dst, $template);
        }
        else
        {
            CLI::write(CLI::color("Warning: Language already exists!", "yellow"));
            CLI::write(CLI::color("         --> File: Language:{$lang}/{$this->module_name}", "white"));
        }
    }

    /**
     * function updateAutoload
     */
    protected function updateAutoload() {
        $Autoload = new \Config\Autoload;
        $psr4 = $Autoload->psr4; 
        if (isset($psr4[ucfirst($this->module_name)])){
            return false;
        }
        $file = fopen(APPPATH . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR . 'Autoload.php','r');
        if (!$file) {
            CLI::write(CLI::color("Warning: Config/Autoload.php nor readable!", "yellow"));
            return false;
        }

        $newcontent = '';
        $posfound = false;
        $posline = 0;
        
        while (($buffer = fgets($file, 4096)) !== false) {
            if ($posfound && strpos($buffer, ']')) {
                //Last line of $psr4
                $newcontent .= $this->module_psr4 ."\n";
                $posfound = false;
            }
            if ($posfound && $posline > 3 && substr(trim($buffer),-1) != ',') {
                $buffer = str_replace("\n", ",\n", $buffer);
            }
            if (strpos($buffer, 'public $psr4 = [')) {
                $posfound = true;
                $posline = 1;
                //First line off $psr4
            }
            if ($posfound) {
                $posline ++;
            }
            $newcontent .= $buffer;
        }
        
        $file = fopen(APPPATH . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR . 'Autoload.php','w');
        if (!$file) {
            CLI::error("Config/Autoload.php nor writable!");
            CLI::write(CLI::color("Warning: Config/Autoload.php nor writable!", "yellow"));
            return false;
        }
        fwrite($file,$newcontent);
        fclose($file);
        
        return true;
        
    }
    
    /**
     * function createDir
     * 
     * Create directory and set, if required, gitkeep to keep this in git.
     * 
     * @param type $folder
     * @param type $gitkeep
     * @return string
     */
    
    protected function createDir($folder, $gitkeep = false) {
        $dir = $this->module_folder . DIRECTORY_SEPARATOR . ucfirst($this->module_name) . DIRECTORY_SEPARATOR .  $folder;
        if (!is_dir($dir)) {        
            mkdir($dir, 0777, true);
            if ($gitkeep) {
                file_put_contents($dir .  '/.gitkeep', '');
            }
        }
        
        return $dir;
        
    }
    
    /**
     * function updateAutoload
     * 
     * Add a psr4 configuration to Config/Autoload.php file
     * 
     * @return boolean
     */

    protected function determineSourcePath()
    {
        $this->sourcePath = realpath(__DIR__.'/../');

        if ($this->sourcePath == '/' || empty($this->sourcePath)) {
            CLI::error('Unable to determine the correct source directory.');
            exit();
        }
    }

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
