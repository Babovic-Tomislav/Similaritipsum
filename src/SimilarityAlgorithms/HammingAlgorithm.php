<?php

namespace App\SimilarityAlgorithms;

class HammingAlgorithm extends SimilarityAlgorithm
{
    public function compare(): float
    {
        if (!$this->textNormalized) {
            $this->normalizeTexts();
        }

        $diff = 0;
        // take smaller text and discard rest of the bigger one
        $textSize = min(sizeof($this->texts['text1']), sizeof($this->texts['text2']));

        for ($i = 0; $i < $textSize; $i++) {
            $diff += gmp_hamdist($this->texts['text1'][$i], $this->texts['text2'][$i]);
        }

        return $diff;
    }

    protected function prepareTexts()
    {
        //Create array representing every letter of the stream with ascii code and special characters.

        $text1 = unpack('C*', $this->texts['text1']);
        $text2 = unpack('C*', $this->texts['text2']);

        foreach (self::IGNORED_CHARACTERS as $character) {
            $text1 = array_values(array_filter($text1, fn ($m) => $m !=  unpack('C*', $character)[1]));
            $text2 = array_values(array_filter($text2, fn ($m) => $m != unpack('C*',  $character)[1]));
        }

        $this->texts['text1'] = $text1;
        $this->texts['text2'] = $text2;
    }
}

