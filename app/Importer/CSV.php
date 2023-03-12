<?php

namespace App\Importer;

class CSV
{
  public static function rowsFromPath($path, $maxItems = 100)
  {
    $rowIndex = 0;
    $rows = [];

    if (($handle = fopen($path, "r")) !== FALSE) {
      $headers = [];

      try {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
          if ($rowIndex === 0) {
            $headers = static::parseHeaders($data);
          } else {
            $row = static::parseRow($data, $headers);

            $rows[] = $row;

            if (count($rows) >= $maxItems) {
              yield $rows;
              $rows = [];
            }
          }

          $rowIndex++;
        }
      } finally {
        yield $rows;
        fclose($handle);
      }
    }
  }

  protected static function parseHeaders($data)
  {
    $headers = [];

    for ($i = 0; $i < count($data); $i++) {
      $headers[] = $data[$i];
    }

    return $headers;
  }

  protected static function parseRow($data, $headers)
  {
    $row = [];

    for ($i = 0; $i < count($data); $i++) {
      $row[$headers[$i]] = $data[$i];
    }

    return $row;
  }
}
