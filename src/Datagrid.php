<?php

namespace Hoochicken\Datagrid;

class Datagrid
{

    private array $columns = [];
    private array $rows = [];
    private string $tableClass = '';
    private bool $headerCaps = true;

    const HTML_TABLE = '<table class="{table_class}">{thead}{tbody}</table>';
    const HTML_HTML_THEAD = '<thead>{content}</thead>';
    const HTML_TBODY = '<tbody>{content}</tbody>';
    const HTML_TR = '<tr>{content}</tr>';
    const HTML_TD = '<td class="{class}">{content}</td>';
    const HTML_TH = '<th class="{class}">{content}</th>';


    public function getTable(array $data, array $columns = []): string
    {
        // validation
        if (0 === count($data)) {
            return '';
        }

        // prepare data
        if (0 === count($columns)) {
            $columns = $this->getDefaultColumns($data[0] ?? []);
        }
        $data = array_map(fn($item) => array_intersect_key($item, $columns), $data);

        // generate html
        $html = str_replace('{table_class}', $this->getTableCLass(), static::HTML_TABLE);
        $html = str_replace('{thead}', $this->getTHead($columns), $html);
        $html = str_replace('{tbody}', $this->getTBody($data), $html);
        return $html;
    }

    public function getDefaultColumns(array $firstRow): array
    {
        $columns = [];
        foreach ($firstRow as $column => $content) {
            $columns[$column] = $column;
        }
        return $columns;
    }

    public function getTHead(array $columns): string
    {
        if ($this->headerCaps) {
            array_walk($columns, function(&$item) { $item = ucwords($item); });
        }
        return str_replace('{content}', $this->getTr($columns, true), static::HTML_HTML_THEAD);
    }

    public function getTBody(array $data): string
    {
        $rows = [];
        foreach ($data as $row) {
            $rows[] = $this->getTr($row);
        }
        return str_replace('{content}', $this->concatTags($rows), static::HTML_TBODY);
    }

    public function getCell($content, bool $th = false, string $class = ''): string
    {
        $cell = $th ? static::HTML_TH : static::HTML_TD;
        return str_replace('{content}', $content ?? '', str_replace('{class}', $class, $cell));
    }

    public function getTr(array $row, bool $th = false): string
    {
        $cells = [];
        foreach ($row as $column => $label) {
            $class = strtolower($this->replaceSpecialChars($column));
            $cells[] = $this->getCell($label, $th, $class);
        }
        return str_replace('{content}', $this->concatTags($cells) ,static::HTML_TR);
    }

    public function replaceSpecialChars(string $string = '', string $replacement = '_'): string
    {
        return preg_replace('~([^0-9a-zA-Z])~', $replacement, $string);
    }

    public function concatTags(array $tags): string
    {
        return implode("\n", $tags);
    }

    public function setTableClass(string $tableClass)
    {
        $this->tableClass = $tableClass;
    }

    public function getTableClass(): string
    {
        return $this->tableClass;
    }

    public function setTableHeaderCaps(string $value)
    {
        $this->headerCaps = $value;
    }

    public function getTableHeaderCaps(): string
    {
        return $this->headerCaps;
    }
}
