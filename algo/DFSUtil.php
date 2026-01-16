<?php

class DFSUtil
{
    /**
     * @var array Tableau des données en entrée
     */
    private array $tabData;

    /**
     * @var array Tableau des données en sortie
     */
    private array $tabResult = [];

    /**
     * @param array $tabData
     */
    public function __construct(array $tabData)
    {
        $this->tabData = $tabData;
    }

    public function getTabResult(): array
    {
        return $this->tabResult;
    }

    public function buildResult(): void
    {
    }
}