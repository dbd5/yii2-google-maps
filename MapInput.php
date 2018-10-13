<?php

namespace voime\GoogleMaps;

use Yii;

class MapInput extends \yii\base\Widget {

    const MAP_TYPE_ROADMAP = 'ROADMAP';
    const MAP_TYPE_HYBRID = 'HYBRID';
    const MAP_TYPE_SATELLITE = 'SATELLITE';
    const MAP_TYPE_TERRAIN = 'TERRAIN';

    public $sensor = false;
    public $mapCanvas = 'map_canvas';
    public $mapLoaded = true;
    public $language = 'en';
    public $width = '100%';
    public $height = '100%';
    public $center = 'Riia 184, Tartu, Tartu linn, Estonia';
    public $zoom = 12;
    public $mapType = 'ROADMAP';
    public $mapOptions = [];
    public $markerOptions = [];
    public $apiKey = null;
    public $apiKeyParamsKey = null;

    public $countryInput = null;
    public $addressInput = 'address-input';
    public $latInput = 'lat-input';
    public $lngInput = 'lng-input';

    public function init() {
        if ($this->apiKey === null && isset(\Yii::$app->params[$this->apiKeyParamsKey])) {
            $this->apiKey = \Yii::$app->params[$this->apiKeyParamsKey];
        }
        $this->sensor = $this->sensor ? 'true' : 'false';
        parent::init();
    }

    public function run() {
        return $this->render('mapInput');
    }

}
