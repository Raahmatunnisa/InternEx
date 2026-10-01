<?php

namespace App\Services\Xlsx;

use ZipArchive;

/**
 * Penulis file .xlsx minimal tanpa dependensi eksternal (tidak ada akses
 * internet di lingkungan ini untuk composer require paket seperti
 * phpoffice/phpspreadsheet atau maatwebsite/excel). Kelas ini menghasilkan
 * berkas Office Open XML (.xlsx) yang valid dan bisa dibuka Excel/Sheets,
 * cukup untuk kebutuhan ekspor tabel sederhana (rekap & detail kehadiran).
 */
class XlsxWriter
{
    /** @var array<int, array<int, string|int|float|null>> */
    protected array $rows = [];

    protected string $sheetName = 'Sheet1';

    public function setSheetName(string $name): static
    {
        $this->sheetName = $this->sanitizeSheetName($name);

        return $this;
    }

    /**
     * Tambahkan baris header (akan ditulis dengan gaya tebal).
     *
     * @param  array<int, string>  $headers
     */
    public function setHeader(array $headers): static
    {
        $this->rows[0] = ['__header__' => true, 'cells' => $headers];

        return $this;
    }

    /**
     * @param  array<int, string|int|float|null>  $cells
     */
    public function addRow(array $cells): static
    {
        $this->rows[] = ['__header__' => false, 'cells' => array_values($cells)];

        return $this;
    }

    /**
     * Simpan sebagai file .xlsx pada path yang diberikan.
     */
    public function save(string $path): bool
    {
        $zip = new ZipArchive();

        if ($zip->open($path, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return false;
        }

        $zip->addEmptyDir('_rels');
        $zip->addEmptyDir('xl');
        $zip->addEmptyDir('xl/_rels');
        $zip->addEmptyDir('xl/worksheets');

        $zip->addFromString('[Content_Types].xml', $this->contentTypesXml());
        $zip->addFromString('_rels/.rels', $this->rootRelsXml());
        $zip->addFromString('xl/workbook.xml', $this->workbookXml());
        $zip->addFromString('xl/_rels/workbook.xml.rels', $this->workbookRelsXml());
        $zip->addFromString('xl/styles.xml', $this->stylesXml());
        $zip->addFromString('xl/worksheets/sheet1.xml', $this->sheetXml());

        return $zip->close();
    }

    protected function contentTypesXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
            .'<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
            .'<Default Extension="xml" ContentType="application/xml"/>'
            .'<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
            .'<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
            .'<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>'
            .'</Types>';
    }

    protected function rootRelsXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            .'<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'
            .'</Relationships>';
    }

    protected function workbookXml(): string
    {
        $name = $this->escape($this->sheetName);

        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            .'<sheets><sheet name="'.$name.'" sheetId="1" r:id="rId1"/></sheets>'
            .'</workbook>';
    }

    protected function workbookRelsXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            .'<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>'
            .'<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>'
            .'</Relationships>';
    }

    protected function stylesXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            .'<fonts count="2">'
            .'<font><sz val="11"/><name val="Calibri"/></font>'
            .'<font><b/><sz val="11"/><name val="Calibri"/><color rgb="FFFFFFFF"/></font>'
            .'</fonts>'
            .'<fills count="3">'
            .'<fill><patternFill patternType="none"/></fill>'
            .'<fill><patternFill patternType="gray125"/></fill>'
            .'<fill><patternFill patternType="solid"><fgColor rgb="FF4F46E5"/><bgColor indexed="64"/></patternFill></fill>'
            .'</fills>'
            .'<borders count="1"><border/></borders>'
            .'<cellStyleXfs count="1"><xf/></cellStyleXfs>'
            .'<cellXfs count="2">'
            .'<xf fontId="0" fillId="0" borderId="0" xfId="0"/>'
            .'<xf fontId="1" fillId="2" borderId="0" xfId="0" applyFont="1" applyFill="1"/>'
            .'</cellXfs>'
            .'</styleSheet>';
    }

    protected function sheetXml(): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
        $xml .= '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">';
        $xml .= '<sheetData>';

        $rowIndex = 1;
        foreach ($this->rows as $row) {
            $isHeader = $row['__header__'];
            $cells = $row['cells'];
            $xml .= '<row r="'.$rowIndex.'">';

            foreach ($cells as $colIndex => $value) {
                $ref = $this->columnLetter($colIndex).$rowIndex;
                $style = $isHeader ? ' s="1"' : '';

                if ($value === null || $value === '') {
                    $xml .= '<c r="'.$ref.'"'.$style.'/>';
                } elseif (is_numeric($value) && ! is_string($value)) {
                    $xml .= '<c r="'.$ref.'"'.$style.'><v>'.$value.'</v></c>';
                } else {
                    $xml .= '<c r="'.$ref.'" t="inlineStr"'.$style.'><is><t xml:space="preserve">'.$this->escape((string) $value).'</t></is></c>';
                }
            }

            $xml .= '</row>';
            $rowIndex++;
        }

        $xml .= '</sheetData>';
        $xml .= '</worksheet>';

        return $xml;
    }

    protected function columnLetter(int $index): string
    {
        $letter = '';
        $index++;

        while ($index > 0) {
            $mod = ($index - 1) % 26;
            $letter = chr(65 + $mod).$letter;
            $index = (int) (($index - $mod) / 26);
        }

        return $letter;
    }

    protected function escape(string $value): string
    {
        $value = str_replace(
            ['&', '<', '>', '"', "'"],
            ['&amp;', '&lt;', '&gt;', '&quot;', '&apos;'],
            $value
        );

        // Buang karakter kontrol yang tidak valid dalam XML 1.0.
        return preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F]/', '', $value) ?? '';
    }

    protected function sanitizeSheetName(string $name): string
    {
        $name = preg_replace('/[\[\]\*\/\\\\\?:]/', '', $name) ?? 'Sheet1';
        $name = trim($name);

        return $name === '' ? 'Sheet1' : substr($name, 0, 31);
    }
}
