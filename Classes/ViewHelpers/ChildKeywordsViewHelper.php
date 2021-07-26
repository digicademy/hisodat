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

class ChildKeywordsViewHelper extends AbstractViewHelper
{

    /**
     * keywordsRepository
     *
     * @var \ADWLM\Hisodat\Domain\Repository\KeywordsRepository
     */
    protected $keywordsRepository;

    /**
     * Use constructor DI and not @inject because it's best
     * @see: https://gist.github.com/NamelessCoder/3b2e5931a6c1af19f9c3f8b46e74f837
     *
     * @param \ADWLM\Hisodat\Domain\Repository\KeywordsRepository $keywordsRepository
     */
    public function __construct(\ADWLM\Hisodat\Domain\Repository\KeywordsRepository $keywordsRepository)
    {
        $this->keywordsRepository = $keywordsRepository;
    }

    /**
     * Initialize ViewHelper arguments
     *
     * @return void
     */
    public function initializeArguments(){

        $this->registerArgument(
            'keyword',
            '\ADWLM\Hisodat\Domain\Model\Keywords',
            'The keyword parent.',
            true
        );
        $this->registerArgument(
            'settings',
            'array',
            'The settings for this request.',
            true
        );
    }

    /**
     * Retrieves child keywords for a keyword
     *
     * @return object
     */
    public function render()
    {
        $keyword = $this->arguments['keyword'];
        $settings = $this->arguments['settings'];

        $result = $this->keywordsRepository->findChildrenForParent($keyword, $settings);
        return $result;
    }

}
