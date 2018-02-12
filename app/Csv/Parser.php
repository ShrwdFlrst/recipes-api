<?php

namespace App\Csv;

/**
 * Class Parser
 * @package App\Csv
 */
class Parser
{
    /**
     * @param string $path
     * @return array
     */
    public function toArray($path)
    {
        // See: http://php.net/manual/en/function.str-getcsv.php#117692
        $csv = array_map('str_getcsv', file($path));
        array_walk($csv, function(&$a) use ($csv) {
            $a = array_combine($csv[0], $a);
        });
        array_shift($csv);

        return $csv;
    }
}