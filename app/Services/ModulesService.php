<?php


namespace App\Services;


use App\Lib\CodeexInsider;
use App\Lib\ModuleInjector;

class ModulesService
{

    public function importModule(string $vendor, string $moduleName, string $path, bool $autoMerging = true){
        $pathToPackages = base_path()."/packages/";
        $pathToVendor = $pathToPackages.$vendor;
        $pathToModule = "{$pathToVendor}/{$moduleName}";

        $this->prepareEnvironment($pathToVendor, $pathToModule);
        $this->cloneModule($pathToModule, $path);
        $additionalData = $this->startIntegration($vendor, $moduleName, $pathToModule);
        $this->composerDump();
        /** @var ModuleInjector $injector */
        if(!$additionalData){
            throw new \Exception("Fatal error on module intergation related with loading/validating additional.json file of module");
        }
        $injector = app()->injector;
        $injector->addModule($additionalData['provider']['alias'],
            $additionalData['namespace'],
            $additionalData['provider']['class']);

        if($autoMerging){
            // Start migrations and etc
            $this->mergeMigrations($vendor, $moduleName);
            $this->runSeeders($vendor, $moduleName);
        }
    }

    public function validateAdditionalData(array $data){
        return (!empty($data['provider']) &&
            !empty($data['provider']['alias']) &&
            !empty($data['provider']['class']) &&
            !empty($data['namespace']));
    }

    protected function loadJson(string $jsonFilePath){
        return json_decode(file_get_contents($jsonFilePath), true);
    }

    protected function saveJson(string $jsonFilePath, array $data){
        file_put_contents($jsonFilePath, json_encode($data));
    }

    /**
     * @param string $pathToModule - where should be cloned
     * @param $path - from where should be cloned
     */
    protected function cloneModule(string $pathToModule, $path){
        $command = "cd {$pathToModule} & git clone {$path} {$pathToModule}";
        echo $command;
        shell_exec($command);
    }

    protected function prepareEnvironment(string $pathToVendor, $pathToModule){
        if(!is_dir($pathToVendor)){
            mkdir($pathToVendor);
        }
        if(!is_dir($pathToModule)){
            mkdir($pathToModule);
        }
    }

    protected function startIntegration(string $vendor, string $moduleName, string $pathToModule)
    {
        // Read additional.json to merge with composer and injector
        $additionalData = $this->loadJson("{$pathToModule}/additional.json");
        if ($this->validateAdditionalData($additionalData)) {
            echo "Valid, go to update composer\n";
            $composerJsonPath = base_path() . "/composer.json";

            $composerData = $this->loadJson($composerJsonPath);
            if (empty($composerData['autoload'])) {
                $composerData['autoload'] = [];
            }
            if (empty($composerData['autoload']['psr-4'])) {
                $composerData['autoload']['psr-4'] = [];
            }
            $relativePath = "packages/{$vendor}/{$moduleName}/";
            $composerData['autoload']['psr-4'][$additionalData['namespace']] = "{$relativePath}src/";
            $this->saveJson($composerJsonPath, $composerData);
            return $additionalData;
        }
        return null;
    }

    protected function composerDump(){
        shell_exec("composer dump-autoload");
        sleep(20);
    }

    public function mergeMigrations(string $vendor, string $moduleName){
        $relativePath = "packages/{$vendor}/{$moduleName}/";
        shell_exec("php artisan migrate --path={$relativePath}src/database/migrations");
    }

    public function runSeeders(string $vendor, string $moduleName){
        $this->composerDump();
        $relativePath = "{$vendor}\\{$moduleName}\\Services\\Insider";
        /** @var CodeexInsider */
        (new $relativePath)->runSeeds();
    }
}
