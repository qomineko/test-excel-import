<?php

declare(strict_types=1);

namespace App\Services\UserImport;

use Generator;
use OpenSpout\Common\Exception\IOException;
use OpenSpout\Reader\Exception\ReaderNotOpenedException;
use OpenSpout\Reader\XLSX\Reader;

final class SpoutUserExcelReader
{
    /**
     * @param string $path
     * @return Generator
     * @throws IOException
     * @throws ReaderNotOpenedException
     */
    public function read(string $path): Generator
    {
        $reader = new Reader();
        $reader->open($path);

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $index => $row) {
                if ($index === 0) {
                    continue;
                }

                yield array_map(fn($cell) => trim((string) $cell->getValue()), $row->getCells());
            }
        }

        $reader->close();
    }
}
