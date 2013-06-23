<?php namespace Codebryo\Aidkit\Commands;

use Illuminate\Console\Command;
use \File;

class InstallCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'aidkit:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get started using Aidkit';

    protected static $templatePath;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        static::$templatePath = __DIR__.'/../../../../templates';
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        if(File::exists(app_path().'/views_admin'))
            return $this->error('Aidkit seems to be installed allready!');

        $this->createFolders();
            $this->info('Basic Folder Structure has been created');
        $this->createViews();
            $this->info('Basic Views have been created');
        $this->createControllers();
            $this->info('Basic Controllers have been created');
        $this->createRoutes();
            $this->info('New Administrative Routes have been created');
        $this->createConfig();
            $this->info('Configuration File has been published');

        // Call some other Functions
        $this->call('asset:publish',array('codebryo/aidkit'));

        return $this->info('Aidkit Installation complete!');
    }

    protected function createFolders()
    {
        // Create the admin_views Folder
        File::makeDirectory(app_path().'/views_admin');
        File::makeDirectory(app_path().'/views_admin/layout');
        File::makeDirectory(app_path().'/views_admin/layout/partials');
        File::makeDirectory(app_path().'/views_admin/users');

        File::makeDirectory(app_path().'/controllers/Admin');
    }

    protected function createViews()
    {
        $templatePath = static::$templatePath;
        File::put(app_path().'/views_admin/layout/layout.blade.php',File::get($templatePath.'/views/layout.txt'));
        File::put(app_path().'/views_admin/layout/login.blade.php',File::get($templatePath.'/views/login.txt'));
        File::put(app_path().'/views_admin/layout/partials/navigation.blade.php',File::get($templatePath.'/views/partials/navigation.txt'));
        File::put(app_path().'/views_admin/layout/partials/profile.blade.php',File::get($templatePath.'/views/partials/profile.txt'));

        // Create the User Views

        File::put(app_path().'/views_admin/users/index.blade.php',File::get($templatePath.'/views/users/index.txt'));
        File::put(app_path().'/views_admin/users/show.blade.php',File::get($templatePath.'/views/users/show.txt'));
        File::put(app_path().'/views_admin/users/edit.blade.php',File::get($templatePath.'/views/users/edit.txt'));
        File::put(app_path().'/views_admin/users/create.blade.php',File::get($templatePath.'/views/users/create.txt'));
    }

    protected function createRoutes()
    {
        $templatePath = static::$templatePath;
        File::append(app_path().'/routes.php',File::get($templatePath.'/routes_append.txt'));

        File::put(app_path().'/routes_aidkit.php',File::get($templatePath.'/routes.txt'));

    }

    protected function createConfig()
    {
        $templatePath = static::$templatePath;
        File::makeDirectory(app_path().'/config/packages/codebryo');
        File::makeDirectory(app_path().'/config/packages/codebryo/aidkit');
        File::put(app_path().'/config/packages/codebryo/aidkit/config.php',File::get($templatePath.'/config.txt'));
    }

    protcted function createControllers()
    {
        $templatePath = static::$templatePath;
        File::put(app_path().'/controllers/Admin/AuthController.php',File::get($templatePath.'/controllers/AuthController.txt'));
        File::put(app_path().'/controllers/Admin/HomeController.php',File::get($templatePath.'/controllers/HomeController.txt'));
        File::put(app_path().'/controllers/Admin/UserController.php',File::get($templatePath.'/controllers/UserController.txt'));
    }
}