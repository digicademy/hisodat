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

class ZoteroViewHelper extends AbstractViewHelper
{

    /**
     * Initialize ViewHelper arguments
     *
     * @return void
     */
    public function initializeArguments(){
        $this->registerArgument(
            'id',
            'integer',
            'The id of the user/group on zotero.org.',
            true
        );
        $this->registerArgument(
            'tags',
            'array',
            'A list of tags to retrieve items for (AND)',
            false,
            array()
        );
        $this->registerArgument(
            'mode',
            'string',
            'User or group library',
            false,
            'users'
        );
        $this->registerArgument(
            'format',
            'string',
            'The return format for items',
            false,
            'json'
        );
        $this->registerArgument(
            'style',
            'string',
            'CSL style string',
            false,
            ''
        );
        $this->registerArgument(
            'apiBaseUrl',
            'string',
            'The base URL of the Zotero API',
            false,
            'https://api.zotero.org'
        );
    }

    /**
     * Retrieves items from a Zotero library using the Zotero API. No authentication supported, library must be public.
     * For more information about the Zotero API @see: https://www.zotero.org/support/dev/web_api/v3/basics#search_syntax
     *
     * @return mixed The API response
     */
    public function render() {

        $id = $this->arguments['id'];
        $tags = $this->arguments['tags'];
        $mode = $this->arguments['mode'];
        $format = $this->arguments['format'];
        $style = $this->arguments['style'];
        $apiBaseUrl = $this->arguments['apiBaseUrl'];

        // build request
        $requestUri = $apiBaseUrl . '/' . $mode . '/' . $id . '/' . 'items?format=' . $format . '&style=' . $style . '&v=3';
        if (count($tags) > 0) {
            foreach ($tags as $tag) {
                $requestUri .= '&tag=' . $tag;
            }
        }

        // fire request
        $zoteroApiResponse = \TYPO3\CMS\Core\Utility\GeneralUtility::getUrl($requestUri);

        return $zoteroApiResponse;
    }
}
