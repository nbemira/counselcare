<?php

namespace App\Services;

class ClassificationService
{
    public function classify($score, $type)
    {
        $boundaries = [
            'D' => [5, 7, 10, 14], // boundaries for Depression
            'A' => [4, 6, 8, 10],  // boundaries for Anxiety
            'S' => [7, 9, 13, 17], // boundaries for Stress
        ];

        $labels = ['normal', 'mild', 'moderate', 'severe', 'extremely severe'];

        // Check the boundaries for the given type and return the corresponding label
        foreach ($boundaries[$type] as $index => $boundary) {
            if ($score <= $boundary) {
                return $labels[$index];
            }
        }

        return $labels[count($labels) - 1]; // Return the last label if none of the boundaries match
    }
}