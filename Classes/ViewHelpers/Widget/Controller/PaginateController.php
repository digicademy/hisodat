<?php
namespace ADWLM\Hisodat\ViewHelpers\Widget\Controller;

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

use TYPO3\CMS\Core\Utility\ArrayUtility;

/**
 * Speed optimized pagination controller for source objects
 */

class PaginateController extends \TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetController
{

    /**
     * @var \array
     */
    protected $configuration = array(
        'itemsPerPage' => 10,
        'maxPageNumberElements' => 10,
        'insertAbove' => true,
        'insertBelow' => true,
        'showCount' => false
    );

    /**
     * @var \integer
     */
    protected $currentPage = 1;

    /**
     * @var \integer
     */
    protected $numberOfPages = 1;

    /**
     * @var \integer
     */
    protected $itemsPerPage = 1;

    /**
     * @var \integer
     */
    protected $maxPageNumberElements = 0;

    /**
     * @return void
     */
    public function initializeAction()
    {
        ArrayUtility::mergeRecursiveWithOverrule($this->configuration, $this->widgetConfiguration['configuration'], true);
    }

    /**
     * @param integer $currentPage
     *
     * @return void
     */
    public function indexAction($currentPage = 1)
    {

        // get current query
        $query = $this->widgetConfiguration['objects']->getQuery();

        // determine items shown per page
        $this->itemsPerPage = (integer)$this->configuration['itemsPerPage'];

        // set page elements to show
        $this->maxPageNumberElements = (integer)$this->configuration['maxPageNumberElements'];

        // number of pages
        $count = $this->widgetConfiguration['arguments']['total']; // 0.000s
        $this->numberOfPages = ceil($count / (integer)$this->configuration['itemsPerPage']);

        // set the current page
        $this->currentPage = (integer)$currentPage;
        if ($this->currentPage < 1) {
            $this->currentPage = 1;
        }
        if ($this->currentPage > $this->numberOfPages) {
            $this->currentPage = $this->numberOfPages;
        }

        // query limit
        $query->setLimit($this->itemsPerPage);
        if ($this->currentPage > 1) {
            $query->setOffset((integer)($this->itemsPerPage * ($this->currentPage - 1)));
        }

        // assign template variables
        $this->view->assign('objects', array($this->widgetConfiguration['as'] => $query->execute()));
        $this->view->assign('configuration', $this->configuration);
        $this->view->assign('pagination', $this->buildPagination());
        $this->view->assign('arguments', $this->widgetConfiguration['arguments']);
    }

    /**
     * Returns an array with the keys "pages", "current", "numberOfPages", "nextPage" & "previousPage"
     *
     * @return \array
     */
    protected function buildPagination()
    {

        $pages = array();

        for ($i = 1; $i <= $this->numberOfPages; $i++) {
            $pages[] = array('number' => $i, 'isCurrent' => ($i === $this->currentPage));
        }

        if ($this->maxPageNumberElements > 0) {

            $edgePages = array();

            // find the numbers 'at the edges' of a range
            foreach ($pages as $key => $value) {
                // generally write all keys from which a new range starts into this array
                if (($key % $this->maxPageNumberElements) == 0) {
                    $edgePages[] = $key;
                }
                // determine where the current page fits in - this is the basis for the later range detection
                if ($key == $this->currentPage) {
                    $edgePages[] = $key;
                }
            }

            // necessary if we're on the very last page - this will not yet be in edgePages since the foreach loop stops one short in regard to the values
            if ($this->currentPage > (count($pages) - 1)) {
                $edgePages[] = $this->currentPage;
            }

            $currentPageLocation = array_search($this->currentPage, $edgePages);
            $pageRange = array_slice($pages, $edgePages[$currentPageLocation - 1], $this->maxPageNumberElements);

            $pages = $pageRange;
        }

        $pagination = array(
            'pages' => $pages,
            'current' => $this->currentPage,
            'numberOfPages' => $this->numberOfPages,
            'previousPageRange' => $edgePages[$currentPageLocation - 1],
            'nextPageRange' => ($edgePages[$currentPageLocation + 1] != null) ? $edgePages[$currentPageLocation + 1] + 1 : 0
        );

        if ($this->currentPage < $this->numberOfPages) {
            $pagination['nextPage'] = $this->currentPage + 1;
        }

        if ($this->currentPage > 1) {
            $pagination['previousPage'] = $this->currentPage - 1;
        }

        return $pagination;
    }
}
