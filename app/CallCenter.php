<?php

namespace App;
use Illuminate\Support\Collection;
use App\Counts;

class CallCenter extends Counts
{
    public static $GENERAL = 1;
    public static $RETURN = 2;
    public static $ALL = 0;
 
    protected $CallCenterMode;

    /**
     * インスタンス作成時、 モードを指定する
     * 
     * @param  $mode    抽出するコールセンターを指定する
     *                  CallCenter::ALL     全て
     *                  CallCenter::GENERAL 一般のコールセンター
     *                  CallCenter::RETURN  帰国者向けのコールセンター
     */
    public function __construct($mode)
    {
        $this->CallCenterMode = $mode;
        $this->OriginalRec = new Collection();
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
            //  相談件数
            if($this->CallCenterMode == CallCenter::$ALL) {
                $gen = is_numeric($rec[4]) ? $rec[4] : 0;
                $ret = is_numeric($rec[5]) ? $rec[5] : 0;
                array_push($dst_rec, $gen +  $ret);
            }
            if($this->CallCenterMode == CallCenter::$GENERAL) {
                array_push($dst_rec, $rec[4]);
            }
            if($this->CallCenterMode == CallCenter::$RETURN) {
                array_push($dst_rec, $rec[5]);
            }
            
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
            '相談件数',
            '備考',
        ];
	}

}