<?php


namespace App\Lib;


use Illuminate\Support\Facades\Log;
use Laravel\Lumen\Application;

class ModuleInjector
{
    protected $coreServices = [];
    protected $modulesServices = [];
    protected $application = null;

    protected $pathToConfigs = null;

    public function __construct(Application $application){
        try {
            $this->application = $application;
            $this->pathToConfigs = base_path() . "/config/service_providers.php";
            $tmp = include($this->pathToConfigs);

            $this->coreServices = !empty($tmp['core']) ? $tmp['core'] : [];
            foreach ($this->coreServices as $coreService) {
                $application->register($coreService);
            }

            $this->modulesServices = !empty($tmp['modules']) ? $tmp['modules'] : [];
            foreach ($this->modulesServices as $moduleService) {
                $application->register($moduleService);
            }

            $this->application->injector = $this;
        }catch (\Throwable $t){
            Log::error($t);
        }
    }

    public function getModuleProvider(string $moduleName) {
        return !empty($this->modulesServices[$moduleName]) ? $this->modulesServices[$moduleName] : null;
    }

    public function getModules(): array
    {
        return $this->modulesServices;
    }

    public function importModule(){

    }

    public function addModule(string $alias, string $path, string $className){
        $providerName = "{$path}{$className}";
        $this->modulesServices[$alias] = $providerName;
        $this->saveProviders();
    }

    protected function saveProviders(){
        file_put_contents($this->pathToConfigs,
            "<?php return ".var_export(['core' => $this->coreServices, 'modules' => $this->modulesServices], true).";");
    }

}
