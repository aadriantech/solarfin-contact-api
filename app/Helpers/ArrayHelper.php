<?php
declare(strict_types=1);

namespace App\Helpers;


class ArrayHelper
{
    /**
     * Removes commas from values within an array
     *
     * @param array $items
     * @return array
     */
    public static function removeCommas(array $items): array
    {
        // remove commas from data
        return array_map(function ($value) {
            return str_replace(',', '', $value);
        },
            $items
        );
    }
}
