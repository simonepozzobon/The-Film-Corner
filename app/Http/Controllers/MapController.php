<?php

namespace App\Http\Controllers;


use Ivory\GoogleMap\Base\Bound;
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Control\ControlPosition;
use Ivory\GoogleMap\Control\MapTypeControl;
use Ivory\GoogleMap\Control\MapTypeControlStyle;
use Ivory\GoogleMap\MapTypeId;
use Ivory\GoogleMap\Layer\GeoJsonLayer;
use Ivory\GoogleMap\Helper\Builder\ApiHelperBuilder;
use Ivory\GoogleMap\Helper\Builder\MapHelperBuilder;
use Ivory\GoogleMap\Helper\Builder\PlaceAutocompleteHelperBuilder;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Place\Autocomplete;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
      $map = new Map();
      $map->setVariable('map');

      dd($map);
      $map->setHtmlId('map_canvas');
      // Disable the auto zoom flag (disabled by default)
      $map->setAutoZoom(false);

      // Sets the center
      $map->setCenter(new Coordinate(45.464072, 9.190453));

      // Set map option
      $map->setMapOption('zoom', 14);
      $map->setMapOption('streetViewControl', false);

      $map->setMapOption('styles', "[
        {elementType: 'geometry', stylers: [{color: '#242f3e'}]},
        {elementType: 'labels.text.stroke', stylers: [{color: '#242f3e'}]},
        {elementType: 'labels.text.fill', stylers: [{color: '#746855'}]},
        {
          featureType: 'administrative.locality',
          elementType: 'labels.text.fill',
          stylers: [{color: '#d59563'}]
        },
        {
          featureType: 'poi',
          elementType: 'labels.text.fill',
          stylers: [{color: '#d59563'}]
        },
        {
          featureType: 'poi.park',
          elementType: 'geometry',
          stylers: [{color: '#263c3f'}]
        },
        {
          featureType: 'poi.park',
          elementType: 'labels.text.fill',
          stylers: [{color: '#6b9a76'}]
        },
        {
          featureType: 'road',
          elementType: 'geometry',
          stylers: [{color: '#38414e'}]
        },
        {
          featureType: 'road',
          elementType: 'geometry.stroke',
          stylers: [{color: '#212a37'}]
        },

      ]");

      $map->setStylesheetOption('width', '100%');
      $map->setStylesheetOption('height', '100%');

      // Create control options
      $mapTypeControl = new MapTypeControl(
          [MapTypeId::ROADMAP],
          ControlPosition::TOP_RIGHT,
          MapTypeControlStyle::DEFAULT_
      );
      // Append to map object
      $map->getControlManager()->setMapTypeControl($mapTypeControl);

      $autocomplete = new Autocomplete();
      $autocompleteHelper = PlaceAutocompleteHelperBuilder::create()->build();
      $autocompleteRender = $autocompleteHelper->render($autocomplete);

      // build the map
      $mapHelper = MapHelperBuilder::create()->build();

      // Set The Api
      $apiHelper = ApiHelperBuilder::create()->setKey('AIzaSyBm2lmdXnrE3nfANgjfV_7d_cE35A0iGos')->build();
      $apiHelperRender = $apiHelper->render([$autocomplete]);

      $mapRender = $mapHelper->render($map);
      echo $apiHelper->render([$map]);


      return view('map.index')
            ->with('map', $mapRender);
    }

}
