<?php

namespace App;

use Illuminate\Support\Collection;

class Patients 
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

    /**
     * オリジナルレコードを元に、変換後のデータを作成する。
     */
    public function convert()
    {
        $this->DstRec =  new Collection();

        foreach($this->OriginalRec as $rec)
        {
            $dst_rec = array();

            //  Byte Order Markを削除
            if(strncmp(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $rec[0]), "No",2) == 0) 
            {
                continue;
            }
            //  No 
            array_push($dst_rec, $rec[0]);
            // 　自治体コード(富山県固定)
            array_push($dst_rec, "16000");
            //  都道府県名(富山県固定)
            array_push($dst_rec, "富山県");
            //  市区町村名
            array_push($dst_rec, $rec[1]);
            //  公表年月日
            array_push($dst_rec, $rec[2]);
            //  発症日
            array_push($dst_rec, $rec[3]);
            //  患者居住地
            array_push($dst_rec, $rec[4]);
            //  患者年代

            if($rec[5] == '10代未満') {     //  富山県のサイトでは10代未満となっている
                array_push($dst_rec, '10歳未満');
            } else {
                array_push($dst_rec, $rec[5]);
            }
            //  患者性別
            if($rec[6] != '男性' && $rec[6] != '女性') {
                array_push($dst_rec, 'その他');
            } else {
                array_push($dst_rec, $rec[6]);
            }
            //  患者職業
            array_push($dst_rec, $rec[7]);
            //  患者状態                        症状欄を充てるのが妥当
            array_push($dst_rec, $rec[9]);
            //  症状                            富山県では入っていないため、空欄とする
            array_push($dst_rec, '');
            //  渡航歴の有無
            if($rec[10] == 'x') {               //  なし
                array_push($dst_rec, 0);
            } else if($rec[10] == 'o') {        //  あり
                array_push($dst_rec, 1);
            } else {                            //  不明は空欄
                array_push($dst_rec, '');
            }
            //  退院済みフラグ(富山はまだ退院済みが無いので不明につきそのまま入れる)
            if($rec[8] == "入院中") {
                array_push($dst_rec, 0);
            } elseif($rec[8] == "退院済") {
                array_push($dst_rec, 1);
            } else {
                array_push($dst_rec, '');
            }

            //  備考
            array_push($dst_rec, $rec[11]);
            
            $this->DstRec->push($dst_rec);

        }
    }
    
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

	public function headings():array
	{
		return [
            pack('C*',0xEF,0xBB,0xBF).'No', 
            '全国地方公共団体コード',
            '都道府県名',
            '市区町村名',
            '公表_年月日',
            '発症_年月日',
            '患者_居住地',
            '患者_年代',
            '患者_性別',
            '患者_職業',
            '患者_状態',
            '患者_症状',
            '患者_渡航歴の有無フラグ',
            '患者_退院済フラグ',
            '備考',
        ];
	}

}