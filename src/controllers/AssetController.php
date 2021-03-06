<?php


namespace SamIT\Yii2\StaticAssets\controllers;


use SamIT\Yii2\StaticAssets\helpers\AssetHelper;
use SamIT\Yii2\StaticAssets\Module;
use yii\console\Controller;
use yii\helpers\Console;
use yii\web\AssetManager;

/**
 * Class AssetController
 * @package SamIT\Yii2\StaticAssets\controllers
 * @property Module $module
 */
class AssetController extends Controller
{
    /**
     * @var string The default asset bundle
     * If not explicitly set will take its default from module config.
     */
    public $defaultBundle;

    public $baseUrl;

    /**
     * @var string The location of your entry script inside the PHPFPM container.
     * Must be absolute, does not support aliases.
     */
    public $entryScript;


    /** @var array List of fnmatch patterns with file names to skip. */
    public $excludedPatterns = [];


    public function init()
    {
        parent::init();
        $this->defaultBundle = $this->module->defaultBundle;
        $this->baseUrl = $this->module->baseUrl;
        $this->excludedPatterns = $this->module->excludedPatterns;
    }


    public function actionPublish($path)
    {
        $assetManager = $this->getAssetManager($path);
        $this->stdout("Publishing application assets... ", Console::FG_CYAN);
        AssetHelper::publishAssets($assetManager, \Yii::getAlias('@app'), $this->excludedPatterns);
        $this->stdout("OK\n", Console::FG_GREEN);

        $this->stdout("Publishing vendor assets... ", Console::FG_CYAN);
        AssetHelper::publishAssets($assetManager, \Yii::getAlias('@vendor'), $this->excludedPatterns);
        $this->stdout("OK\n", Console::FG_GREEN);


        $this->stdout("Compressing assets... ", Console::FG_CYAN);
        AssetHelper::createGzipFiles($path);
        $this->stdout("OK\n", Console::FG_GREEN);
    }

    protected function getAssetManager($fullPath): AssetManager
    {
        $this->stdout("Creating asset path: $fullPath... ", Console::FG_CYAN);
        \mkdir($fullPath, 0777, true);
        $this->stdout("OK\n", Console::FG_GREEN);
        // Override some configuration.
        $assetManagerConfig = $this->module->getComponents()['assetManager'];
        $assetManagerConfig['basePath'] = $fullPath;
        $assetManagerConfig['baseUrl'] = $this->baseUrl;
        $this->module->set('assetManager', $assetManagerConfig);
        return $this->module->get('assetManager');
    }
}