<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ConfirmNegative;


class ConfirmNegativeController extends Controller
{
    protected $RemoteCSV = '16000_toyama_covid19_confirm_negative.csv';
    protected $LocalCSV = 'toyama_counts.';
    protected $OpendataPath = 'http://opendata.pref.toyama.jp/files/covid19/20200403/toyama_counts.csv';

    /**
     * 陽性患者属性以外を富山県オープンデータサイトから取得し、
     * 新型コロナウイルス感染症対策に関するオープンデータ項目定義書に準拠したCSVを作成し
     * ダウンロードする。
     */
    public function get_confirm_negative()
    {
        //  県のオープンデータを取得し、一旦、保存する
        $csv = file_get_contents($this->OpendataPath); //ファイルの保存先
        $filename = tempnam ('./', $this->LocalCSV);
        file_put_contents($filename,$csv);

        //  CSVファイルを読み込み
        $fp = fopen($filename, 'r');
        if($fp == FALSE) {
            throw new Exception('Error: Failed to open file (' . $filename . ')');
        }

        $ConfirmNegative = new ConfirmNegative();
        while (($rec = fgetcsv($fp)) != FALSE) {
            $ConfirmNegative->push($rec);
        }

        fclose($fp);
        unlink($filename);

        //  出力用のCSV作成
        $outfilename = tempnam ('./', $this->LocalCSV);
        $length = $ConfirmNegative->create_file($outfilename);

        //  ヘッダ部の出力
        $this->output_header($length);

        //  ファイルの出力
        $this->output_patients($outfilename);
        unlink($outfilename);

        //-- 最後に終了させるのを忘れない
        exit;
    }

    /**
     * 新型コロナウイルス感染症対策に関するオープンデータ項目定義書に準拠したCSVを作成し、ダウンロードさせる
     */
    private function output_patients($filename)
    {
        //  ヘッダ出力

        //-- readfile()の前に出力バッファリングを無効化する ※詳細は後述
        while (ob_get_level()) { ob_end_clean(); }

        //-- 出力
        readfile($filename);
    }

    /**
     * ヘッダ部の出力
     */
    private function output_header($length)
    {
        $mimeType = 'text/csv';

        //-- Content-Type
        header('Content-Type: ' . $mimeType);

        //-- ウェブブラウザが独自にMIMEタイプを判断する処理を抑止する
        header('X-Content-Type-Options: nosniff');

        //-- ダウンロードファイルのサイズ
        header('Content-Length: ' . $length);

        //-- ダウンロード時のファイル名
        header('Content-Disposition: attachment; filename="' . $this->RemoteCSV . '"');

        //-- keep-aliveを無効にする
        header('Connection: close');

    }
}
