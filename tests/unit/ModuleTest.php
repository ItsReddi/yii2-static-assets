<?php

use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

class ModuleTest extends \Codeception\Test\Unit
{
    /**
     * @var \SamIT\Yii2\StaticAssets\Module
     */
    protected $module;

    public function _before()
    {
        parent::_before();
        $this->module = \Yii::$app->getModule('staticAssets');
        $this->assertInstanceOf(\SamIT\Yii2\StaticAssets\Module::class, $this->module);
    }
}
