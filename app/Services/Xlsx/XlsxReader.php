<?php

namespace App\Services\Xlsx;

use RuntimeException;
use SimpleXMLElement;
use ZipArchive;

/**
 * Pembaca file .xlsx minimal tanpa dependensi eksternal. Membaca sheet
 * pertama pada workbook, mendukung shared strings (format umum yang
 * dihasilkan Excel/Google Sheets) maupun inline string, serta mengembalikan
 * data sebagai array baris (array of array) yang sudah rata (sel kosong
 * tetap ada sebagai string kosong) sesuai lebar header.
 */
class XlsxReader
{
    /**
     * @return array<int, array<int, string>>
     */
    public static function read(string $path): array
    {
        if (! is_file($path)) {
            throw new RuntimeException('File tidak ditemukan.');
        }

        $zip = new ZipArchive();

        if ($zip->open($path) !== true) {
            throw new RuntimeException('File bukan berkas .xlsx yang valid.');
        }

        $sharedStrings = self::readSharedStrings($zip);
        $sheetPath = self::resolveFirstSheetPath($zip);

        $sheetXml = $zip->getFromName($sheetPath);
        $zip->close();

        if ($sheetXml === false) {
            throw new RuntimeException('Tidak dapat membaca isi sheet pada file .xlsx.');
        }

        return self::parseSheet($sheetXml, $sharedStrings);
    }

    /**
     * @return array<int, string>
     */
    protected static function readSharedStrings(ZipArchive $zip): array
    {
        $content = $zip->getFromName('xl/sharedStrings.xml');

        if ($content === false) {
            return [];
        }

        $xml = @simplexml_load_string($content);

        if ($xml === false) {
            return [];
        }

        $strings = [];

        foreach ($xml->si as $si) {
            $strings[] = self::extractSharedStringText($si);
        }

        return $strings;
    }

    protected static function extractSharedStringText(SimpleXMLElement $si): string
    {
        if (isset($si->t)) {
            return (string) $si->t;
        }

        $text = '';
        if (isset($si->r)) {
            foreach ($si->r as $run) {
                $text .= (string) $run->t;
            }
        }

        return $text;
    }

    protected static function resolveFirstSheetPath(ZipArchive $zip): string
    {
        $workbookXml = $zip->getFromName('xl/workbook.xml');
        $relsXml = $zip->getFromName('xl/_rels/workbook.xml.rels');

        if ($workbookXml === false || $relsXml === false) {
            return 'xl/worksheets/sheet1.xml';
        }

        $workbook = @simplexml_load_string($workbookXml);
        $rels = @simplexml_load_string($relsXml);

        if ($workbook === false || $rels === false || ! isset($workbook->sheets->sheet[0])) {
            return 'xl/worksheets/sheet1.xml';
        }

        $firstSheet = $workbook->sheets->sheet[0];
        $rId = (string) $firstSheet->attributes('r', true)->id;

        if ($rId === '') {
            $rId = (string) $firstSheet->attributes('http://schemas.openxmlformats.org/officeDocument/2006/relationships')->id;
        }

        if ($rId === '') {
            return 'xl/worksheets/sheet1.xml';
        }

        foreach ($rels->Relationship as $rel) {
            if ((string) $rel['Id'] === $rId) {
                $target = (string) $rel['Target'];
                $target = ltrim($target, '/');

                return str_starts_with($target, 'xl/') ? $target : 'xl/'.$target;
            }
        }

        return 'xl/worksheets/sheet1.xml';
    }

    /**
     * @param  array<int, string>  $sharedStrings
     * @return array<int, array<int, string>>
     */
    protected static function parseSheet(string $sheetXml, array $sharedStrings): array
    {
        $xml = @simplexml_load_string($sheetXml);

        if ($xml === false || ! isset($xml->sheetData->row)) {
            return [];
        }

        $rows = [];
        $maxCol = 0;
        $autoRowIndex = 0;

        foreach ($xml->sheetData->row as $row) {
            $rAttr = (string) $row['r'];
            $rowIndex = $rAttr !== '' ? ((int) $rAttr - 1) : $autoRowIndex;
            $autoRowIndex = $rowIndex + 1;
            $rowData = [];

            $autoColIndex = 0;
            foreach ($row->c as $cell) {
                $ref = (string) $cell['r'];
                $colIndex = $ref !== '' ? self::columnIndexFromRef($ref) : $autoColIndex;
                $autoColIndex = $colIndex + 1;
                $type = (string) $cell['t'];

                $value = self::cellValue($cell, $type, $sharedStrings);
                $rowData[$colIndex] = $value;

                if ($colIndex > $maxCol) {
                    $maxCol = $colIndex;
                }
            }

            $rows[$rowIndex] = $rowData;
        }

        if (empty($rows)) {
            return [];
        }

        $lastRow = max(array_keys($rows));
        $result = [];

        for ($r = 0; $r <= $lastRow; $r++) {
            $line = [];
            $rowData = $rows[$r] ?? [];

            for ($c = 0; $c <= $maxCol; $c++) {
                $line[$c] = $rowData[$c] ?? '';
            }

            $result[] = $line;
        }

        return $result;
    }

    protected static function cellValue(SimpleXMLElement $cell, string $type, array $sharedStrings): string
    {
        if ($type === 's') {
            $index = (int) $cell->v;

            return $sharedStrings[$index] ?? '';
        }

        if ($type === 'inlineStr') {
            return isset($cell->is->t) ? (string) $cell->is->t : '';
        }

        if ($type === 'str' || $type === 'b') {
            return (string) $cell->v;
        }

        // Numeric (termasuk serial tanggal Excel) atau kosong.
        return isset($cell->v) ? (string) $cell->v : '';
    }

    protected static function columnIndexFromRef(string $ref): int
    {
        preg_match('/^([A-Z]+)/', $ref, $matches);
        $letters = $matches[1] ?? 'A';

        $index = 0;
        foreach (str_split($letters) as $char) {
            $index = $index * 26 + (ord($char) - 64);
        }

        return $index - 1;
    }
}
