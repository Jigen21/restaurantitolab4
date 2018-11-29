import { Component, OnInit } from '@angular/core';

import OlMap from 'ol/Map';
import OlXYZ from 'ol/source/XYZ';
import OlTileLayer from 'ol/layer/Tile';
import OlView from 'ol/View';

import { fromLonLat } from 'ol/proj';

declare var ol: any;
@Component({
  selector: 'lib-mapa',
  templateUrl: './mapa.component.html',
  styleUrls: ['./mapa.component.css']
})
export class MapaComponent implements OnInit {

  constructor() { }

  map: OlMap;
  source: OlXYZ;
  layer: OlTileLayer;
  view: OlView;

  latitude: number = 18.5204;
  longitude: number = 73.8567;

  ngOnInit() {

    var mousePositionControl = new ol.control.MousePosition({
      coordinateFormat: ol.coordinate.createStringXY(4),
      projection: 'EPSG:4326',
      // comment the following two lines to have the mouse position
      // be placed within the map.
      className: 'custom-mouse-position',
      target: document.getElementById('mouse-position'),
      undefinedHTML: '&nbsp;'
    });


    this.map = new ol.Map({
      target: 'map',
      controls: ol.control.defaults({
        attributionOptions: {
          collapsible: false
        }
      }).extend([mousePositionControl]),
      layers: [
        new ol.layer.Tile({
          source: new ol.source.OSM()
        })
      ],
      view: new ol.View({
        center: ol.proj.fromLonLat([73.8567, 18.5204]),
        zoom: 8
      })
    });

    //this.map.on('click', function (args) {
    this.map.on('click', (args) => {
      console.log(args.coordinate);
      var lonlat = ol.proj.transform(args.coordinate, 'EPSG:3857', 'EPSG:4326');
      console.log(lonlat);

      var lon = lonlat[0];
      var lat = lonlat[1];
      alert(`lat: ${lat} long: ${lon}`);

      this.agregar(lon, lat);

    });
  }

  setCenter() {
    var view = this.map.getView();
    view.setCenter(ol.proj.fromLonLat([this.longitude, this.latitude]));
    view.setZoom(8);
  }

  agregar(uno, dos) {

    var iconFeature1 = new ol.Feature({
      geometry: new ol.geom.Point(ol.proj.fromLonLat([uno, dos])),
      name: 'Somewhere',
    });

    var iconFeature2 = new ol.Feature({
      geometry: new ol.geom.Point(ol.proj.fromLonLat([uno, dos])),
      name: 'Somewhere else'
    });

    // specific style for that one point
    iconFeature2.setStyle(new ol.style.Style({
      image: new ol.style.Icon({
        anchor: [0.5, 46],
        anchorXUnits: 'fraction',
        anchorYUnits: 'pixels',
        src: 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/93/Map_marker_font_awesome.svg/200px-Map_marker_font_awesome.svg.png',
      })
    }));

    const iconLayerSource = new ol.source.Vector({
      features: [iconFeature1, iconFeature2]
    });

    const iconLayer = new ol.layer.Vector({
      source: iconLayerSource,
      // style for all elements on a layer
      style: new ol.style.Style({
        image: new ol.style.Icon({
          anchor: [0.5, 46],
          anchorXUnits: 'fraction',
          anchorYUnits: 'pixels',
          src: 'https://openlayers.org/en/v4.6.4/examples/data/icon.png'
        })
      })
    });

    this.map.addLayer(iconLayer);
    //this.map.layers[iconLayer]="";
    //this.map.layers[iconLayer]=iconLayer;

  }

}



