<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Code for Toyama City 新型コロナ関連サイト</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link href="css/app.css" rel="stylesheet">

    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="container">
                <div class="container-fluid" style="margin-top:1rem">
                    <h2> 
                    富山県オープンデータ(新型コロナウィルス関連)変換データ提供サイト
                    </h2>
                </div>
                <div class="container-fluid" style="margin-top:3rem">
                    <h4>
                    このサイトでは、富山県オープンデータサイトに掲載されているオープンデータを、Code for Japanが作成・公開している「新型コロナウイルス感染症対策に関するオープンデータ項目定義書」に準拠した形式で変換したデータを提供しています。
                    </h4>
                </div>
                <div class="container-fluid" style="margin-top:1rem">
                    富山県のオープンデータについては、<a href="http://opendata.pref.toyama.jp/dataset?q=%E3%82%B3%E3%83%AD%E3%83%8A" target="_blank">こちら</a>をご覧ください。
                </div>
                <div class="container-fluid" style="margin-top:0.1rem">
                    新型コロナウイルス感染症対策に関するオープンデータ項目定義書については、<a href="https://www.code4japan.org/activity/stopcovid19#doc" target="_blank">こちら</a>をご覧ください。
                </div>
                <div style="margin-top:1rem">
                    <div class="container bg-primary" > 
                        <h3>
                            <a href={{url('/opendata/get_patients')}} style="color: #ffffff;">陽性患者属性情報</a>
                        </h3>
                        <h6>
                        <a href={{url('/opendata/get_patients')}} style="color: #ffffff;">{{url('/opendata/get_patients')}}</a>
                        </h6>
                    </div>
                    <div class="container-fluid" style="margin-top:1rem">
                        <h5>
                        <p>
                            上のリンクから陽性患者属性情報(新型コロナウイルス感染症対策に関するオープンデータ項目定義書準拠)ダウンロードが可能です。呼び出されたタイミングで、富山県のオープンデータサイトから最新データを取得・データ変換します。
                        </p>
                        <p>
                            【注意事項】
                        </p>
                        <p>
                            患者_属性については、現状では「入院中」のみ設定されています。このため、このサイトではデータを設定しておりません(退院済フラグに反映しています)。
                        </p>
                        <p>
                            富山県においては、入院中/退院済の情報は、提供されない見通しです。
                        </p>
                        <p>
                            市区町村名は、富山県オープンデータには「富山市」のみ設定されています。
                        </p>
                        </h5>
                    </div>
                    <div class="container bg-primary" > 
                        <h3>
                            <a href={{url('/opendata/get_inspected')}} style="color: #ffffff;">検査実施人数</a>
                        </h3>
                        <h6>
                        <a href={{url('/opendata/get_inspected')}} style="color: #ffffff;">{{url('/opendata/get_inspected')}}</a>
                        </h6>
                    </div>
                    <h5>
                    <p>
                        上のリンクから検査実施人数(新型コロナウイルス感染症対策に関するオープンデータ項目定義書準拠)ダウンロードが可能です。呼び出されたタイミングで、富山県のオープンデータサイトから最新データを取得・データ変換します。
                    </p>
                    <p>
                        【注意事項】
                    </p>
                    <p>
                        先頭カラムの年月日は、富山県の場合「結果判明_年月日」としています。
                    </p>
                    </h5>
                    <div class="container bg-primary" > 
                        <h3>
                            <a href={{url('/opendata/get_confirm_negative')}} style="color: #ffffff;">陰性確認数</a>
                        </h3>
                        <h6>
                            <a href={{url('/opendata/get_confirm_negative')}} style="color: #ffffff;">{{url('/opendata/get_confirm_negative')}}</a>
                        </h6>
                    </div>
                    <h5>
                    <p>
                        上のリンクから陰性確認数(新型コロナウイルス感染症対策に関するオープンデータ項目定義書準拠)ダウンロードが可能です。呼び出されたタイミングで、富山県のオープンデータサイトから最新データを取得・データ変換します。
                    </p>
                    </h5>

                    <div class="container bg-primary" > 
                    <h3>
                            <a href={{url('/opendata/get_call_center')}} style="color: #ffffff;">コールセンター相談件数(全件)</a>
                        </h3>
                        <h6>
                            <a href={{url('/opendata/get_call_center')}} style="color: #ffffff;">{{url('/opendata/get_call_center')}}</a>
                        </h6>
                        <h3>
                            <a href={{url('/opendata/get_call_center?mode=general')}} style="color: #ffffff;">コールセンター相談件数(一般相談件数のみ)</a>
                        </h3>
                        <h6>
                            <a href={{url('/opendata/get_call_center?mode=general')}} style="color: #ffffff;">{{url('/opendata/get_call_center?mode=general')}}</a>
                        </h6>
                        <h3>
                            <a href={{url('/opendata/get_call_center?mode=return')}} style="color: #ffffff;">コールセンター相談件数(帰国者相談件数のみ)</a>
                        </h3>
                        <h6>
                            <a href={{url('/opendata/get_call_center?mode=return')}} style="color: #ffffff;">{{url('/opendata/get_call_center?mode=return')}}</a>
                        </h6>
                    </div>
                    <h5>
                    <p>
                        上のリンクからコールセンター相談件数(新型コロナウイルス感染症対策に関するオープンデータ項目定義書準拠)ダウンロードが可能です。呼び出されたタイミングで、富山県のオープンデータサイトから最新データを取得・データ変換します。
                    </p>
                    <p>
                        【注意事項】
                    </p>
                    <p>
                        富山県では、一般相談と帰国者相談の二つの相談窓口があります。全件、一般相談及び帰国者相談の件数をダウンロードが可能です。
                    </p>
                    </h5>

                    <div class="container bg-warning" > 
                        <h3>
                            <a style="color: #ffffff;">検査実施件数(工事中)</a>
                        </h3>
                    </div>
                    <h5>
                    <p>
                        富山県では、検査人数は公表されていますが、検査件数の公表はされていません。このデータの提供時期は、未定です。
                    </p>



                    <div class="container" style="margin-top:3rem"> 
                        <p>
                            <h3>Code for Toyama Cityの新型コロナ対策サイトでは、開発、デザインやご意見を出していただける方を募集しています。</h3>
                        </p>
                        開発にご協力いただけるかたは、Githubをご覧ください。
                    </div>
                    <div class="container bg-primary"> 
                        <h3>
                            <a href="https://github.com/codefortoyama/covid19" style="color: #ffffff;">GitHub</a>
                        </h3>
                    </div>
                    <div class="container" > 
                    <a href="https://join.slack.com/t/codefortoyama/shared_invite/zt-dnexhi6s-yavCx3dO0YlsBi_BjfechQ" style="color: #000000;">また、こちらからslackに参加できます。</a>
                    </div> 
                    
                    <div class="container" style="margin-top:1rem"> 
                        ご意見・ご要望は、Code for Toayma CityのWEBサイトやFacebookページからお願いします。
                    </div>
                    <div class="container bg-primary"> 
                        <h3>
                            <a href="https://codefortoyama.jimdofree.com/" style="color: #ffffff;">Code for Toyama City WEBサイト</a>
                        </h3>
                    </div>
                    <div class="container bg-primary"> 
                        <h3>
                            <a href="https://www.facebook.com/codefortoyama/" style="color: #ffffff;">Code for Toyama City Facebook ページ</a>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
