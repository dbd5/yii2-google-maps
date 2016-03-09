<?php

namespace tugmaks\GoogleMaps;

use Yii;

class Map extends \yii\base\Widget {

    const MAP_TYPE_ROADMAP = 'ROADMAP';
    const MAP_TYPE_HYBRID = 'HYBRID';
    const MAP_TYPE_SATELLITE = 'SATELLITE';
    const MAP_TYPE_TERRAIN = 'TERRAIN';

    public $sensor = false;
    public $width = '600px';
    public $height = '600px';
    public $center = 'Riia 184, Tartu, Tartu linn, Estonia';
    public $zoom = 12;
    public $mapType = 'ROADMAP';
    public $markers = [];
    public $apiKey = null;
    public $markerFitBounds = false;

    public function init() {
        if ($this->apiKey === null) {
            $this->apiKey = Yii::$app->params['GOOGLE_API_KEY'];
        }
        $this->sensor = $this->sensor ? 'true' : 'false';
        parent::init();
    }

    public function run() {

        return $this->render('map');
    }

}
