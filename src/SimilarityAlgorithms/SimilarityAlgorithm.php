<?php

namespace App\SimilarityAlgorithms;

use App\Exception\MissingTextException;

abstract class SimilarityAlgorithm
{
    protected const IGNORED_CHARACTERS = [
        ' ', '.', ',', '!', '?', ':', ';', '-'
    ];

    protected bool $textNormalized = false;

    protected array $rawTexts = [
        'text1' => null,
        'additional_text1' => null,
        'text2' => null,
        'additional_text2' => null,
    ];

    protected array $texts = [
        'text1' => null,
        'text2' => null
    ];

    public function normalizeTexts()
    {
        $this->texts['text1'] = isset($this->rawTexts['additional_text1']) ? $this->rawTexts['text1'] . ' ' . $this->rawTexts['additional_text1'] : $this->rawTexts['text1'];
        $this->texts['text2'] = isset($this->rawTexts['additional_text2']) ? $this->rawTexts['text2'] . ' ' . $this->rawTexts['additional_text2'] : $this->rawTexts['text2'];

        $this->prepareTexts();
        $this->textNormalized = true;
    }

    /**
     * @param array $texts
     * @return void
     * @throws MissingTextException
     */
    public function setTexts(array $texts)
    {
        if (!array_key_exists('text1', $texts) || !array_key_exists('text2', $texts)) {
            throw new MissingTextException();
        }

        $this->rawTexts = $texts;
    }

    abstract protected function prepareTexts();
    abstract public function compare(): float;
}

