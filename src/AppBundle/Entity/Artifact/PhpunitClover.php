<?php

namespace AppBundle\Entity\Artifact;

class PhpunitClover
{
    /**
     * @var int
     */
    private $files = 0;

    /**
     * @var int
     */
    private $loc = 0;

    /**
     * @var int
     */
    private $ncloc = 0;

    /**
     * @var int
     */
    private $classes = 0;

    /**
     * @var int
     */
    private $methods = 0;

    /**
     * @var int
     */
    private $coveredmethods = 0;

    /**
     * @var int
     */
    private $conditionals = 0;

    /**
     * @var int
     */
    private $coveredconditionals = 0;

    /**
     * @var int
     */
    private $statements = 0;

    /**
     * @var int
     */
    private $coveredstatements = 0;

    /**
     * @var int
     */
    private $elements = 0;

    /**
     * @var int
     */
    private $coveredelements = 0;

    /**
     * @return int
     */
    public function getFiles(): int
    {
        return $this->files;
    }

    /**
     * @param int $files
     *
     * @return PhpunitClover
     */
    public function setFiles(int $files)
    {
        $this->files = $files;

        return $this;
    }

    /**
     * @return int
     */
    public function getLoc(): int
    {
        return $this->loc;
    }

    /**
     * @param int $loc
     *
     * @return PhpunitClover
     */
    public function setLoc(int $loc)
    {
        $this->loc = $loc;

        return $this;
    }

    /**
     * @return int
     */
    public function getNcloc(): int
    {
        return $this->ncloc;
    }

    /**
     * @param int $ncloc
     *
     * @return PhpunitClover
     */
    public function setNcloc(int $ncloc)
    {
        $this->ncloc = $ncloc;

        return $this;
    }

    /**
     * @return int
     */
    public function getClasses(): int
    {
        return $this->classes;
    }

    /**
     * @param int $classes
     *
     * @return PhpunitClover
     */
    public function setClasses(int $classes)
    {
        $this->classes = $classes;

        return $this;
    }

    /**
     * @return int
     */
    public function getMethods(): int
    {
        return $this->methods;
    }

    /**
     * @param int $methods
     *
     * @return PhpunitClover
     */
    public function setMethods(int $methods)
    {
        $this->methods = $methods;

        return $this;
    }

    /**
     * @return int
     */
    public function getCoveredmethods(): int
    {
        return $this->coveredmethods;
    }

    /**
     * @param int $coveredmethods
     *
     * @return PhpunitClover
     */
    public function setCoveredmethods(int $coveredmethods)
    {
        $this->coveredmethods = $coveredmethods;

        return $this;
    }

    /**
     * @return int
     */
    public function getConditionals(): int
    {
        return $this->conditionals;
    }

    /**
     * @param int $conditionals
     *
     * @return PhpunitClover
     */
    public function setConditionals(int $conditionals)
    {
        $this->conditionals = $conditionals;

        return $this;
    }

    /**
     * @return int
     */
    public function getCoveredconditionals(): int
    {
        return $this->coveredconditionals;
    }

    /**
     * @param int $coveredconditionals
     *
     * @return PhpunitClover
     */
    public function setCoveredconditionals(int $coveredconditionals)
    {
        $this->coveredconditionals = $coveredconditionals;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatements(): int
    {
        return $this->statements;
    }

    /**
     * @param int $statements
     *
     * @return PhpunitClover
     */
    public function setStatements(int $statements)
    {
        $this->statements = $statements;

        return $this;
    }

    /**
     * @return int
     */
    public function getCoveredstatements(): int
    {
        return $this->coveredstatements;
    }

    /**
     * @param int $coveredstatements
     *
     * @return PhpunitClover
     */
    public function setCoveredstatements(int $coveredstatements)
    {
        $this->coveredstatements = $coveredstatements;

        return $this;
    }

    /**
     * @return int
     */
    public function getElements(): int
    {
        return $this->elements;
    }

    /**
     * @param int $elements
     *
     * @return PhpunitClover
     */
    public function setElements(int $elements)
    {
        $this->elements = $elements;

        return $this;
    }

    /**
     * @return int
     */
    public function getCoveredelements(): int
    {
        return $this->coveredelements;
    }

    /**
     * @param int $coveredelements
     *
     * @return PhpunitClover
     */
    public function setCoveredelements(int $coveredelements)
    {
        $this->coveredelements = $coveredelements;

        return $this;
    }
}
