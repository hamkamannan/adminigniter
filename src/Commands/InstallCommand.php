<?php

namespace hamkamannan\adminigniter\Commands;

use CodeIgniter\CLI\BaseCommand;
use Config\Database;

/**
 * Class InstallCommand.
 */
class InstallCommand extends BaseCommand
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
    protected $name = 'adminigniter:install';

    /**
     * The command's short description.
     *
     * @var string
     */
    protected $description = 'Db install for basic adminigniter data.';

    /**
     * The command's usage.
     *
     * @var string
     */
    protected $usage = 'adminigniter:install';

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

    //--------------------------------------------------------------------

    /**
     * Displays the help for the spark cli script itself.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        try {
            $this->call('adminigniter:publish');
            // migrate all first
            $this->call('migrate -n "hamkamannan\adminigniter" ');
            // then seed data
            $seeder = Database::seeder();
            $seeder->call('hamkamannan\adminigniter\Database\Seeds\AdminigniterSeeder');
        } catch (\Exception $e) {
            $this->showError($e);
        }
    }
}
