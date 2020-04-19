<?php

namespace App;

use Illuminate\Support\Collection;

abstract class Counts 
{
    protected $OriginalRec ;
    protected $DstRec ;

    public function __construct()
    {
        $this->OriginalRec = new Collection();
    }

    public function push($rec)
    {
        $this->OriginalRec->push($rec);
    }

    public function all()
    {
        return $this->OriginalRec->all();
    }

    abstract public function convert();
    abstract public function headings();

    /**
     * 変換後のデータをCSV形式で出力
     */
    public function create_file($filename)
    {
        $this->convert();
        $fp = fopen($filename, 'w');
        if($fp == FALSE) {
            throw new Exception('Error: Failed to open file (' . $filename . ')');
        }

        $length = fputcsv($fp, $this->headings());
        foreach($this->DstRec->toArray() as $rec) 
        {
            $length += fputcsv($fp, $rec);
        }

        fclose($fp);

        return $length;
    }
}