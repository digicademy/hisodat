<?php
namespace ADWLM\Hisodat\Domain\Model;

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

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * The historical sources
 */
class Sources extends AbstractEntity
{

    /**
     * Identifier for import/export/exchange
     *
     * @var \string $persistentIdentifier
     */
    protected $persistentIdentifier;

    /**
     * The identification of a source object within a corpus
     *
     * @var \string $identifier
     */
    protected $identifier;

    /**
     * The title of a source object
     *
     * @var \string $title
     */
    protected $title;

    /**
     * A short abstract of the source's content
     *
     * @var \string $abstract
     */
    protected $abstract;

    /**
     * A description of the source and/or it's material
     *
     * @var \string $description
     */
    protected $description;

    /**
     * The incipit \string of a source object
     *
     * @var \string $incipit
     */
    protected $incipit;

    /**
     * A transcript of the source's text
     *
     * @var \string $transcription
     */
    protected $transcription;

    /**
     * A textual note on the back of the source
     *
     * @var \string $versoNote
     */
    protected $versoNote;

    /**
     * The translation of the sources text
     *
     * @var \string $translation
     */
    protected $translation;

    /**
     * A detailed summary of the source's content
     *
     * @var \string $summary
     */
    protected $summary;

    /**
     * Qualified scientific commentary of the source
     *
     * @var \string $commentary
     */
    protected $commentary;

    /**
     * Annotations to the sources text
     *
     * @var \string $annotations
     */
    protected $annotations;

    /**
     * Footnotes to the editorial texts
     *
     * @var \string $footnotes
     */
    protected $footnotes;

    /**
     * Secondary literature regarding the source object
     *
     * @var \string $literature
     */
    protected $literature;

    /**
     * The signature \string of a source object
     *
     * @var \string $signature
     */
    protected $signature;

    /**
     * Additional signature information
     *
     * @var \string $signatureAddition
     */
    protected $signatureAddition;

    /**
     * A description of the sources' archival history
     *
     * @var \string $archivalHistory
     */
    protected $archivalHistory;

    /**
     * Images
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $images
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $images;

    /**
     * The last editor of the source record
     *
     * @var \string $editor
     */
    protected $editor;

    /**
     * Editorial comments to the source record
     *
     * @var \string $editorComments
     */
    protected $editorComments;

    /**
     * Date range of the source
     *
     * @var \ADWLM\Hisodat\Domain\Model\DateRanges $dateRange
     * @cascade remove
     */
    protected $dateRange;

    /**
     * Sources are kept within an archive
     *
     * @var \ADWLM\Hisodat\Domain\Model\Archives $archive
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $archive;

    /**
     * Relations with other objects
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\ADWLM\Hisodat\Domain\Model\Relations> $relations
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     * @cascade remove
     */
    protected $relations;

    /**
     * Sources can be associated with keywords
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\ADWLM\Hisodat\Domain\Model\Keywords> $keywords
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $keywords;

    /**
     * Sorting key for manual sorting if activated
     *
     * @var \integer $sorting
     */
    protected $sorting;

    /**
     * Timestamp of last modification
     *
     * @var \integer $tstamp
     */
    protected $tstamp;

    /**
     * Returns the persistentIdentifier
     *
     * @return \string
     */
    public function getPersistentIdentifier()
    {
        return $this->persistentIdentifier;
    }

    /**
     * Sets the persistentIdentifier
     *
     * @param \string $persistentIdentifier
     *
     * @return void
     */
    public function setPersistentIdentifier($persistentIdentifier)
    {
        $this->persistentIdentifier = $persistentIdentifier;
    }

    /**
     * Returns the identifier
     *
     * @return \string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Sets the signature
     *
     * @param \string $identifier
     *
     * @return void
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * Returns the title
     *
     * @return \string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param \string $title
     *
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the abstract
     *
     * @return \string
     */
    public function getAbstract()
    {
        return $this->abstract;
    }

    /**
     * Sets the abstract
     *
     * @param \string $abstract
     *
     * @return void
     */
    public function setAbstract($abstract)
    {
        $this->abstract = $abstract;
    }

    /**
     * Returns the description
     *
     * @return \string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param \string $description
     *
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Returns the incipit
     *
     * @return \string
     */
    public function getIncipit()
    {
        return $this->incipit;
    }

    /**
     * Sets the incipit
     *
     * @param \string $incipit
     *
     * @return void
     */
    public function setIncipit($incipit)
    {
        $this->incipit = $incipit;
    }

    /**
     * Returns the transcription
     *
     * @return \string
     */
    public function getTranscription()
    {
        return $this->transcription;
    }

    /**
     * Sets the transcription
     *
     * @param \string $transcription
     *
     * @return void
     */
    public function setTranscription($transcription)
    {
        $this->transcription = $transcription;
    }

    /**
     * Returns the versoNote
     *
     * @return \string
     */
    public function getVersoNote()
    {
        return $this->versoNote;
    }

    /**
     * Sets the versoNote
     *
     * @param \string $versoNote
     *
     * @return void
     */
    public function setVersoNote($versoNote)
    {
        $this->versoNote = $versoNote;
    }

    /**
     * Returns the translation
     *
     * @return \string $translation
     */
    public function getTranslation()
    {
        return $this->translation;
    }

    /**
     * Sets the translation
     *
     * @param \string $translation
     *
     * @return void
     */
    public function setTranslation($translation)
    {
        $this->translation = $translation;
    }

    /**
     * Returns the summary
     *
     * @return \string $summary
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Sets the summary
     *
     * @param \string $summary
     *
     * @return void
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
    }

    /**
     * Returns the commentary
     *
     * @return \string
     */
    public function getCommentary()
    {
        return $this->commentary;
    }

    /**
     * Sets the commentary
     *
     * @param \string $commentary
     *
     * @return void
     */
    public function setCommentary($commentary)
    {
        $this->commentary = $commentary;
    }

    /**
     * Returns the annotations
     *
     * @return \string
     */
    public function getAnnotations()
    {
        return $this->annotations;
    }

    /**
     * Sets the annotations
     *
     * @param \string $annotations
     *
     * @return void
     */
    public function setAnnotations($annotations)
    {
        $this->annotations = $annotations;
    }

    /**
     * Returns the footnotes
     *
     * @return \string
     */
    public function getFootnotes()
    {
        return $this->footnotes;
    }

    /**
     * Sets the footnotes
     *
     * @param \string $footnotes
     *
     * @return void
     */
    public function setFootnotes($footnotes)
    {
        $this->footnotes = $footnotes;
    }

    /**
     * Returns the literature
     *
     * @return \string
     */
    public function getLiterature()
    {
        return $this->literature;
    }

    /**
     * Sets the literature
     *
     * @param \string $literature
     *
     * @return void
     */
    public function setLiterature($literature)
    {
        $this->literature = $literature;
    }

    /**
     * Returns the signature
     *
     * @return \string
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * Sets the signature
     *
     * @param \string $signature
     *
     * @return void
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;
    }

    /**
     * Returns the signatureAddition
     *
     * @return \string
     */
    public function getSignatureAddition()
    {
        return $this->signatureAddition;
    }

    /**
     * Sets the signatureAddition
     *
     * @param \string $signatureAddition
     *
     * @return void
     */
    public function setSignatureAddition($signatureAddition)
    {
        $this->signatureAddition = $signatureAddition;
    }

    /**
     * Returns the archivalHistory
     *
     * @return \string $archivalHistory
     */
    public function getArchivalHistory()
    {
        return $this->archivalHistory;
    }

    /**
     * Sets the archivalHistory
     *
     * @param \string $archivalHistory
     *
     * @return void
     */
    public function setArchivalHistory($archivalHistory)
    {
        $this->archivalHistory = $archivalHistory;
    }

    /**
     * Returns the image
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $images
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Sets the image
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $images
     *
     * @return void
     */
    public function setImages($images)
    {
        $this->images = $images;
    }

    /**
     * Returns the editor
     *
     * @return \string $editor
     */
    public function getEditor()
    {
        return $this->editor;
    }

    /**
     * Sets the editor
     *
     * @param \string $editor
     *
     * @return void
     */
    public function setEditor($editor)
    {
        $this->editor = $editor;
    }

    /**
     * Returns the editorComments
     *
     * @return \string $editorComments
     */
    public function getEditorComments()
    {
        return $this->editorComments;
    }

    /**
     * Sets the editorComments
     *
     * @param \string $editorComments
     *
     * @return void
     */
    public function setEditorComments($editorComments)
    {
        $this->editorComments = $editorComments;
    }

    /**
     * Returns the dateRange
     *
     * @return \ADWLM\Hisodat\Domain\Model\DateRanges $dateRange
     */
    public function getDateRange()
    {
        return $this->dateRange;
    }

    /**
     * Sets the dateRange
     *
     * @param \ADWLM\Hisodat\Domain\Model\DateRanges $dateRange
     *
     * @return void
     */
    public function setDateRange(\ADWLM\Hisodat\Domain\Model\DateRanges $dateRange)
    {
        $this->dateRange = $dateRange;
    }

    /**
     * Returns the archive
     *
     * @return \ADWLM\Hisodat\Domain\Model\Archives $archive
     */
    public function getArchive()
    {
        return $this->archive;
    }

    /**
     * Sets the archive
     *
     * @param \ADWLM\Hisodat\Domain\Model\Archives $archive
     *
     * @return void
     */
    public function setArchive(\ADWLM\Hisodat\Domain\Model\Archives $archive)
    {
        $this->archive = $archive;
    }

    /**
     * Returns the relations
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\ADWLM\Hisodat\Domain\Model\Relations> $relations
     */
    public function getRelations()
    {
        return $this->relations;
    }

    /**
     * Sets the relations
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\ADWLM\Hisodat\Domain\Model\Relations> $relations
     *
     * @return void
     */
    public function setRelations($relations)
    {
        $this->relations = $relations;
    }

    /**
     * Returns the keywords
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\ADWLM\Hisodat\Domain\Model\Keywords> $keywords
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Sets the keywords
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\ADWLM\Hisodat\Domain\Model\Keywords> $keywords
     *
     * @return void
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     * Returns the tstamp
     *
     * @return \integer
     */
    public function getTstamp()
    {
        return $this->tstamp;
    }

    /**
     * Sets the tstamp
     *
     * @param \integer $tstamp
     *
     * @return void
     */
    public function setTstamp($tstamp)
    {
        $this->tstamp = $tstamp;
    }

    /**
     * Returns the sorting
     *
     * @return \integer
     */
    public function getSorting()
    {
        return $this->sorting;
    }

    /**
     * Sets the sorting
     *
     * @param \integer $sorting
     *
     * @return void
     */
    public function setSorting($sorting)
    {
        $this->sorting = $sorting;
    }

}
