<?php

namespace App;
use Illuminate\Support\Collection;
use App\Counts;

class ConfirmNegative extends Counts
{
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
            if(strcmp(preg_replace('/^\xEF\xBB\xBF/', '', $rec[0]), "年月日") == 0) 
            {
                continue;
            }
            //  年月日
            array_push($dst_rec, $rec[0]);
            // 　自治体コード(富山県固定)
            array_push($dst_rec, "16000");
            //  都道府県名(富山県固定)
            array_push($dst_rec, "富山県");
            //  市区町村名(県発表のため、空白)
            array_push($dst_rec, "");
            //  陰性確認_件数
            array_push($dst_rec, $rec[2]);
            //  備考
            array_push($dst_rec, $rec[7]);

            $this->DstRec->push($dst_rec);
        }
    }
    
	public function headings():array
	{
		return [
            pack('C*',0xEF,0xBB,0xBF).'完了_年月日', 
            '全国地方公共団体コード',
            '都道府県名',
            '市区町村名',
            '陰性確認_件数',
            '備考',
        ];
	}

}