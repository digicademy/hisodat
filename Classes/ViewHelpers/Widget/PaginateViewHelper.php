<?php
namespace ADWLM\Hisodat\ViewHelpers\Widget;

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

use TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper;

class PaginateViewHelper extends AbstractWidgetViewHelper
{

    /**
     * @var \ADWLM\Hisodat\ViewHelpers\Widget\Controller\PaginateController
     */
    protected $controller;

    /**
     * Use constructor DI and not @inject because it's best
     * @see: https://gist.github.com/NamelessCoder/3b2e5931a6c1af19f9c3f8b46e74f837
     *
     * @param \ADWLM\Hisodat\ViewHelpers\Widget\Controller\PaginateController $controller
     */
    public function __construct(\ADWLM\Hisodat\ViewHelpers\Widget\Controller\PaginateController $controller)
    {
        $this->controller = $controller;
    }

    /**
     * Initialize ViewHelper arguments
     *
     * @return void
     */
    public function initializeArguments(){
        $this->registerArgument(
            'objects',
            '\TYPO3\CMS\Extbase\Persistence\QueryResultInterface',
            'The objects to paginate',
            true
        );
        $this->registerArgument(
            'as',
            'string',
            'The as for the pagination.',
            true
        );
        $this->registerArgument(
            'arguments',
            'array',
            'The arguments for the pagination',
            false,
            array()
        );
        $this->registerArgument(
            'configuration',
            'array',
            'The configuration for the pagination.',
            false,
            array(
                'itemsPerPage' => 10,
                'maxPageNumberElements' => 10,
                'insertAbove' => false,
                'insertBelow' => true,
                'showCount' => false
            )
        );
    }

     /**
     * @return string
     */
    public function render() {
        $objects = $this->arguments['objects'];
        $as = $this->arguments['as'];
        $arguments = $this->arguments['arguments'];
        $configuration = $this->arguments['configuration'];

        return $this->initiateSubRequest();
    }
}
