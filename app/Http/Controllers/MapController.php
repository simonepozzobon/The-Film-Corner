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
      $map->setHtmlId('map_canvas');
      // Disable the auto zoom flag (disabled by default)
      $map->setAutoZoom(false);

      // Sets the center
      $map->setCenter(new Coordinate(0, 0));

      // Sets the zoom
      $map->setMapOption('zoom', 3);

      $map->setStylesheetOption('width', '100%');
      $map->setStylesheetOption('height', '100%');

      // Create control options
      $mapTypeControl = new MapTypeControl(
          [MapTypeId::ROADMAP, MapTypeId::SATELLITE],
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
