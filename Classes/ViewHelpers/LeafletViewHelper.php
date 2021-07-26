<?php
namespace ADWLM\Hisodat\ViewHelpers;

/***************************************************************
 *  Copyright notice
 *
 *  Torsten Schrade <Torsten.Schrade@adwmainz.de>, Academy of Sciences and Literature | Mainz
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class LeafletViewHelper extends AbstractViewHelper
{

    /**
     * Initialize ViewHelper arguments
     * Format for $objects {0 : {0 : {coordinates : 'x,y'}}, 1 : objectStorage}
     *
     * @return void
     */
    public function initializeArguments(){

        $this->registerArgument(
            'objects',
            'array',
            'The objects',
            true
        );
        $this->registerArgument(
            'coordinatesProperty',
            'string',
            'The properties of the coordinates.',
            true
        );
        $this->registerArgument(
            'titleProperty',
            'string',
            'The property of the title.',
            false,
            ''
        );
        $this->registerArgument(
            'setView',
            'string',
            'The (comma separated lat/long) coordinates of the view point.',
            false,
            '50.0,14.0'
        );
        $this->registerArgument(
            'zoom',
            'integer',
            'The zoom value.',
            false,
            10
        );
        $this->registerArgument(
            'mapHeight',
            'intger',
            'The height value of the map.',
            false,
            400
        );
        $this->registerArgument(
            'addHeaderData',
            'boolean',
            'Boolean flag to/if add HTML header data, for importing the CSS and the JS.',
            false,
            true
        );
    }


    /**
     * Format for $objects {0 : {0 : {coordinates : 'x,y'}}, 1 : objectStorage}
     *
     * @return \string
     */
    public function render()
    {
        $objects = $this->arguments['objects'];
        $coordinatesProperty = $this->arguments['coordinatesProperty'];
        $titleProperty = $this->arguments['titleProperty'];
        $setView = $this->arguments['setView'];
        $zoom = $this->arguments['zoom'];
        $mapHeight = $this->arguments['mapHeight'];
        $addHeaderData = $this->arguments['addHeaderData'];

        if ($addHeaderData === true) {
            $GLOBALS['TSFE']->getPageRenderer()->addHeaderData('<link rel="stylesheet" type="text/css" href="http://cdn.leafletjs.com/leaflet-0.5/leaflet.css" media="all">');
            $GLOBALS['TSFE']->getPageRenderer()->addHeaderData('<link rel="stylesheet" type="text/css" href="http://cdn.leafletjs.com/leaflet-0.5/leaflet.ie.css" media="all">');
            $GLOBALS['TSFE']->getPageRenderer()->addHeaderData('<script src="http://cdn.leafletjs.com/leaflet-0.5/leaflet.js" type="text/javascript"></script>');
        }

        $content = '
            <div id="map" style="height : ' . (int)$mapHeight . 'px;"></div>
            <script type="text/javascript">
                var map = L.map(\'map\').setView([' . htmlspecialchars($setView) . '], ' . (int)$zoom . ');
        ';
        foreach ($objects as $object) {
            foreach ($object as $subobjects) {
                if (is_object($subobjects)) {
                    if ($titleProperty) {
                        $getTitle = 'get' . ucfirst($titleProperty);
                        $title = $subobjects->$getTitle();
                    }
                    $getCoordinates = 'get' . ucfirst($coordinatesProperty);
                    if ($coordinates = $subobjects->$getCoordinates()) {
                        $content .= '
                        L.marker([' . htmlspecialchars($coordinates) . '], {\'title\' : \'' . htmlspecialchars($title) . '\'}).addTo(map);
                        ';
                    }
                } else {
                    if ($coordinates = $subobjects[$coordinatesProperty]) {
                        $content .= '
                        L.marker([' . htmlspecialchars($coordinates) . '], {\'title\' : \'' . htmlspecialchars($subobjects[$titleProperty]) . '\'}).addTo(map);
                        ';
                    }
                }
            }
        }
        $content .= '
                L.tileLayer(\'http://{s}.tile.osm.org/{z}/{x}/{y}.png\', {
                attribution: \'&copy; <a href=\"http://osm.org/copyright\">OpenStreetMap</a> contributors\'
                }).addTo(map);
            </script>
        ';

        return $content;
    }
}
