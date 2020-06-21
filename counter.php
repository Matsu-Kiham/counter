<?php
header('Content-Type: text/html; charset=UTF-8');/*文字コードの指定*/
?>



<head>

<title>カウンター</title>


</head>

<body>
<?PHP
  $file_name = "data/title.txt"; /*タイトルファイルの指定*/

  $title = file( $file_name ); /*タイトルファイルを全て配列に入れる*/
  $title_num = count($title); /*タイトル数を取得*/

  $title_trim_counter = 1;
  $replacements3 = array(0 => rtrim($title{0})); /*タイトルの末尾の改行コードを除くための置換配列の作成
  （はじめに一つ要素を入れないとarray_pushが使えない）*/

  while ($title_trim_counter < $title_num):
    array_push($replacements3, rtrim($title{$title_trim_counter})); /*タイトルの末尾の改行コードを除いては配列に追加*/
    $title_trim_counter++;
  endwhile;

  $title = array_replace($title, $replacements3); /*タイトルの配列を改行コードなしの配列と入れ替える*/
?>

<?php
$text = $_POST['control']; /*入力フォームから送信された内容を取得*/
$uf = substr($text, 0, 2); /*先頭のコマンド部分を切り取る*/
$user_input = substr($text, 2); /*コマンド部分以降を切り取る*/
if ($uf == 'N:') { /*新規作成コマンドが送信された時の処理*/
  array_push($title, rtrim($user_input)); /*タイトルの配列にユーザーが入力したタイトルを追加*/
  $title_num = count($title); /*タイトル数を再取得*/

  $n_write_counter = 0; /*タイトルをタイトルファイルに上書き*/
  $fpn = fopen($file_name, 'w');
  while ($n_write_counter < $title_num):
    fwrite($fpn, $title{$n_write_counter} . "\n");
    $n_write_counter++;
  endwhile;
  fclose($fpn);

  $n_file_num = $title_num; /*新規タイトル用のファイル作成*/
  $n_file_num_string = (string) $n_file_num;
if ($n_file_num < 10) {
    $n_file_num_string = "0" . $n_file_num_string;
}
  $n_file_name = "data/" . $n_file_num_string . ".txt";
  if (file_exists($n_file_name)) {
} else {
  touch($n_file_name);
}
  $fpn2 = fopen($n_file_name, 'w');
  fwrite($fpn2, $title{$n_file_num - 1} . "\n");
  fwrite($fpn2, "0" . "\n");
  fclose($fpn2);
}

if ($uf == 'E:') { /*編集コマンドが送信された時の処理*/
  $change = explode(' ', $user_input); /*上に来る数字と下に来る数字を分ける*/
  
  if ($change{0} != 1) {
    if ($change{1} != 1) {

      $change_counter = 0;
  if ($change{0} < $change{1}) { /*上に来る数字が下に来る数字より小さい場合*/
    while ($change_counter < ($change{1} - $change{0} - 1)):
      $next_file_num = $change{0} + 1 + $change_counter; /*一つ大きい数字*/
      $now_file_num = $change{0} + $change_counter; /*今の数字*/
      $next_file_num_string = (string) $next_file_num;
      $now_file_num_string = (string) $now_file_num;
      if ($next_file_num < 10) {
        $next_file_num_string = "0" . $next_file_num_string;
      }
      if ($now_file_num < 10) {
        $now_file_num_string = "0" . $now_file_num_string;
      }

      $next_file_name = "data/" . $next_file_num_string . ".txt"; /*一つ大きい数字のファイルの指定*/
      $next_file_contents = file( $next_file_name ); /*一つ大きい数字のファイルの内容を配列に入れる*/
      $next_file_contents_num = count($next_file_contents);
      $next_file_contents_trim_counter = 1;
      $replacements4 = array(0 => rtrim($next_file_contents{0}));
      while ($next_file_contents_trim_counter < $next_file_contents_num):
        array_push($replacements4, rtrim($next_file_contents{$next_file_contents_trim_counter}));
        $next_file_contents_trim_counter++;
      endwhile;
      $next_file_contents = array_replace($next_file_contents, $replacements4);
      

      $now_file_name = "data/" . $now_file_num_string . ".txt"; /*今の数字のファイルの指定*/
      $now_file_contents = file( $now_file_name ); /*今の数字のファイルの内容を配列に入れる*/
      $now_file_contents_num = count($now_file_contents);
      $now_file_contents_trim_counter = 1;
      $replacements5 = array(0 => rtrim($now_file_contents{0}));
      while ($now_file_contents_trim_counter < $now_file_contents_num):
        array_push($replacements5, rtrim($now_file_contents{$now_file_contents_trim_counter}));
        $now_file_contents_trim_counter++;
      endwhile;
      $now_file_contents = array_replace($now_file_contents, $replacements5);
      $now_file_write_counter = 0; /*今の数字のファイルの内容を一つ大きい数字のファイルに上書き*/
      $fpn3 = fopen($next_file_name, 'w');
      while ($now_file_write_counter < $now_file_contents_num):
        fwrite($fpn3, $now_file_contents{$now_file_write_counter} . "\n");
        $now_file_write_counter++;
      endwhile;
      fclose($fpn3);

      $next_file_write_counter = 0; /*一つ大きい数字のファイルの内容を今の数字のファイルに上書き*/
      $fpn4 = fopen($now_file_name, 'w');
      while ($next_file_write_counter < $next_file_contents_num):
        fwrite($fpn4, $next_file_contents{$next_file_write_counter} . "\n");
        $next_file_write_counter++;
      endwhile;
      fclose($fpn4);

      $change_counter++;
    endwhile;

    $title_change_counter = 1; /*タイトルのファイルを上書き*/
    $title_change_counter2 = 1;
    if ($change{0} == 1) { /*上に来る数字が1かそれ以上かで分ける*/
      $replacements6 = array(0 => $title{1});
      $title_change_counter2++;
    }
    if ($change{0} > 1) {
      $replacements6 = array(0 => $title{0});
    }
    
    while ($title_change_counter < ($change{0} - 1)): /*上に来る数字の手前までの処理*/
      array_push($replacements6, $title{$title_change_counter});
      $title_change_counter++;
    endwhile;

    

    while (($change{0} + $title_change_counter2) < ($change{1})): /*下に来る数字の手前までの処理*/
      array_push($replacements6, $title{$change{0} + $title_change_counter2 - 1});
      $title_change_counter2++;
    endwhile;

    array_push($replacements6, $title{$change{0} - 1}); /*上に来る数字の処理*/

    $title_change_counter3 = 0; /*下に来る数字以降の処理*/
    while (($change{1} + $title_change_counter3) < ($title_num + 1)):
      array_push($replacements6, $title{$change{1} + $title_change_counter3 - 1});
      $title_change_counter3++;
    endwhile;

    $title = array_replace($title, $replacements6);

    $e_write_counter = 0; /*タイトルをファイルに上書き*/
    $fpn5 = fopen($file_name, 'w');
    while ($e_write_counter < $title_num):
    fwrite($fpn5, $title{$e_write_counter} . "\n");
    $e_write_counter++;
    endwhile;
    fclose($fpn5);

  }
  
  if ($change{0} > $change{1}) { /*上に来る数字が下に来る数字より大きい場合*/
    while ($change_counter < ($change{0} - $change{1})):
      $next_file_num = $change{0} - 1 - $change_counter; /*一つ小さい数字*/
      $now_file_num = $change{0} - $change_counter; /*今の数字*/
      $next_file_num_string = (string) $next_file_num;
      $now_file_num_string = (string) $now_file_num;
      if ($next_file_num < 10) {
        $next_file_num_string = "0" . $next_file_num_string;
      }
      if ($now_file_num < 10) {
        $now_file_num_string = "0" . $now_file_num_string;
      }

      $next_file_name = "data/" . $next_file_num_string . ".txt"; /*読込ファイルの指定*/
      $next_file_contents = file( $next_file_name );
      $next_file_contents_num = count($next_file_contents);
      $next_file_contents_trim_counter = 1;
      $replacements4 = array(0 => rtrim($next_file_contents{0}));
      while ($next_file_contents_trim_counter < $next_file_contents_num):
        array_push($replacements4, rtrim($next_file_contents{$next_file_contents_trim_counter}));
        $next_file_contents_trim_counter++;
      endwhile;
      $next_file_contents = array_replace($next_file_contents, $replacements4);
      

      $now_file_name = "data/" . $now_file_num_string . ".txt"; /*読込ファイルの指定*/
      $now_file_contents = file( $now_file_name );
      $now_file_contents_num = count($now_file_contents);
      $now_file_contents_trim_counter = 1;
      $replacements5 = array(0 => rtrim($now_file_contents{0}));
      while ($now_file_contents_trim_counter < $now_file_contents_num):
        array_push($replacements5, rtrim($now_file_contents{$now_file_contents_trim_counter}));
        $now_file_contents_trim_counter++;
      endwhile;
      $now_file_contents = array_replace($now_file_contents, $replacements5);
      $now_file_write_counter = 0;
      $fpn3 = fopen($next_file_name, 'w');
      while ($now_file_write_counter < $now_file_contents_num):
        fwrite($fpn3, $now_file_contents{$now_file_write_counter} . "\n");
        $now_file_write_counter++;
      endwhile;
      fclose($fpn3);

      $next_file_write_counter = 0;
      $fpn4 = fopen($now_file_name, 'w');
      while ($next_file_write_counter < $next_file_contents_num):
        fwrite($fpn4, $next_file_contents{$next_file_write_counter} . "\n");
        $next_file_write_counter++;
      endwhile;
      fclose($fpn4);

      $change_counter++;
    endwhile;

    $title_change_counter = 1;
    $title_change_counter2 = 1;
    if ($change{1} == 1) { /*下に来る数字が1かそれ以上かで分ける*/
      $replacements6 = array(0 => $title{$change{0} - 1});
      $title_change_counter4 = 0;
      while ($title_change_counter4 < $title_num):
        if ($title_change_counter4 != ($change{0} - 1)) { /*上に来る数字以外なら配列に追加*/
          array_push($replacements6, $title{$title_change_counter4});
        }
        $title_change_counter4++;
      endwhile;
    }
    if ($change{1} > 1) {
      $replacements6 = array(0 => $title{0});
      $title_change_counter5 = 1;
      while ($title_change_counter5 < $title_num):
        if ($title_change_counter5 == ($change{1} - 1)) { /*下に来る数字に来たら上に来る数字を配列に追加*/
          array_push($replacements6, $title{$change{0} - 1});
        }
        if ($title_change_counter5 != ($change{0} - 1)) { /*上に来る数字以外なら配列に追加*/
          array_push($replacements6, $title{$title_change_counter5});
        }
        $title_change_counter5++;
      endwhile;
    }
    
    

    $title = array_replace($title, $replacements6);

    $e_write_counter = 0;
    $fpn5 = fopen($file_name, 'w');
    while ($e_write_counter < $title_num):
    fwrite($fpn5, $title{$e_write_counter} . "\n");
    $e_write_counter++;
    endwhile;
    fclose($fpn5);

  }

    }
  }
  

}

if ($uf == 'D:') { /*削除コマンドが送信された時の処理*/
  if ($user_input != 1) {
    $d_counter = 1;
    if ($user_input == 1) { /*削除する行が1行目かどうかで分ける*/
      $replacements7 = array(0 => $title{1});
      $d_counter++;
    }
    else {
      $replacements7 = array(0 => $title{0});
    }
    while ($d_counter < $title_num):
      if ($d_counter != ($user_input - 1)) {
        array_push($replacements7, $title{$d_counter});
      }
      $d_counter++;
    endwhile;
    $title = array_replace($title, $replacements7);
    array_pop($title); /*タイトルの配列の末尾の要素を削除*/
    $title_num = count($title);
    $d_write_counter = 0;
    $fpn6 = fopen($file_name, 'w');
    while ($d_write_counter < $title_num):
      fwrite($fpn6, $title{$d_write_counter} . "\n");
      $d_write_counter++;
    endwhile;
    fclose($fpn6);
    
    $d_file_counter = $user_input;
    while ($d_file_counter < ($title_num + 1)):
      $n_file_num = $d_file_counter + 1; /*一つ大きい数字*/
      $d_file_num = $d_file_counter; /*今の数字*/
      $n_file_num_string = (string) $n_file_num;
      $d_file_num_string = (string) $d_file_num;
      if ($n_file_num < 10) {
        $n_file_num_string = "0" . $n_file_num_string;
      }
      if ($d_file_num < 10) {
        $d_file_num_string = "0" . $d_file_num_string;
      }

      $n_file_name = "data/" . $n_file_num_string . ".txt"; /*読込ファイルの指定*/
      $n_file_contents = file( $n_file_name );
      $n_file_contents_num = count($n_file_contents);
      $n_file_contents_trim_counter = 1;
      $replacements8 = array(0 => rtrim($n_file_contents{0}));
      while ($n_file_contents_trim_counter < $n_file_contents_num):
        array_push($replacements8, rtrim($n_file_contents{$n_file_contents_trim_counter}));
        $n_file_contents_trim_counter++;
      endwhile;
      $n_file_contents = array_replace($n_file_contents, $replacements8);
      
      $d_file_name = "data/" . $d_file_num_string . ".txt";
      $n_file_write_counter = 0;
      $fpn7 = fopen($d_file_name, 'w');
      while ($n_file_write_counter < $n_file_contents_num):
        fwrite($fpn7, $n_file_contents{$n_file_write_counter} . "\n");
        $n_file_write_counter++;
      endwhile;
      fclose($fpn7);
      $d_file_counter++;
    endwhile;
    $unlink_file_num = $title_num + 1; /*最後のファイルを削除*/
    $unlink_file_num_string = (string) $unlink_file_num;
    if ($unlink_file_num < 10) {
      $unlink_file_num_string = "0" . $unlink_file_num_string;
    }
    $unlink_file_name = "data/" . $unlink_file_num_string . ".txt";
    unlink($unlink_file_name);
  }
}
?>

<div style="text-align:center;">
<font size="5">
    <a href="../index.html">戻る</a><br><br>
    <div style="background: #EFEFEF; width:630px; border: 1px solid #000000; height:400px; padding-left:10px; padding-right:10px; padding-top:10px; padding-bottom:10px; overflow: scroll; margin: 0px auto; text-align:left;">
    <?PHP
    $list_counter = 0; /*タイトルとボタンを表示*/
    $button_value = 1;
    while ($list_counter < $title_num):
        echo <<<HTML
        
        <form action="" method="post">
        <font size="5">
        <label for="{$list_counter}">{$button_value}: {$title{$list_counter}}</label>
        <button id = "{$list_counter}" type="submit" name="addone" value="{$button_value}" style="background-color:#fff0f5; position: relative; left: 30px; top: 0px; width:30px;height:25px" ><font size="2">+</font></button>
        </font>
        </form>
HTML;
        $list_counter++;
        $button_value = $list_counter + 1;
    endwhile;
    ?>
    </div>
    <br>
    新規作成(N:X)，編集(E:X Y, D:X)，詳細(O:X)
    <br><br>
    <form action="" method="post">
        <input type="text" name="control" style="width: 300px; height: 50px; font-size: 100%;">
        <input type="submit" name="datapost" style ="font-size: 100%;">
    </form>
    <br>
  </font>
</div>

<?php
date_default_timezone_set('Asia/Tokyo'); /*タイムゾーンの設定*/
$file_num = $_POST["addone"]; /*押されたボタンの値を取得*/
if ($file_num > 0) {
    $file_num_string = (string) $file_num;
if ($file_num < 10) {
    $file_num_string = "0" . $file_num_string;
}


  $addone_file_name = "data/" . $file_num_string . ".txt"; /*読込ファイルの指定*/

  $addone_data = file( $addone_file_name ); /*ファイルを全て配列に入れる*/
  $addone_data_num = count($addone_data);

  $addone_data_replace = $addone_data{1} + 1; /*押された回数に1プラス*/
  $addone_data_replace_string = (string) $addone_data_replace;

  $replacements = array(1 => $addone_data_replace_string, $addone_data_num => date("Y/m/d H:i:s")); /*押された回数と時刻を配列に入れる*/
  $addone_data = array_replace($addone_data, $replacements);
  $addone_data_num = count($addone_data);

  $trim_counter = 1;
  $replacements2 = array(0 => rtrim($addone_data{0}));

  while ($trim_counter < $addone_data_num):
    array_push($replacements2, rtrim($addone_data{$trim_counter}));
    $trim_counter++;
  endwhile;

  $addone_data = array_replace($addone_data, $replacements2);

  unlink($addone_file_name); /*押されたタイトルのファイルをいったん削除*/
  touch($addone_file_name);
  $fp = fopen($addone_file_name, 'w');
  $fwrite_counter = 0;
  while ($fwrite_counter < $addone_data_num):
    fwrite($fp, $addone_data{$fwrite_counter} . "\n");
    $fwrite_counter++;
  endwhile;
  fclose($fp);
} 

?>

<?php
if ($uf == 'O:') { /*詳細コマンドが送信された時の処理*/
    if ($user_input != 1) {
      $o_file_num = $user_input;
      $o_file_num_string = (string) $o_file_num;
      if ($o_file_num < 10) {
        $o_file_num_string = "0" . $o_file_num_string;
      }
      $o_file_name = "data/" . $o_file_num_string . ".txt"; /*読込ファイルの指定*/
      $o_file_contents = file( $o_file_name );
      $o_file_contents_num = count($o_file_contents);
      $o_file_contents_trim_counter = 1;
      $replacements9 = array(0 => rtrim($o_file_contents{0}));
      while ($o_file_contents_trim_counter < $o_file_contents_num):
        array_push($replacements9, rtrim($o_file_contents{$o_file_contents_trim_counter}));
        $o_file_contents_trim_counter++;
      endwhile;
      $o_file_contents = array_replace($o_file_contents, $replacements9);

      echo <<<HTML
        
        <div style="text-align:center;">
        <font size="5">
        {$title{$user_input - 1}} <br>
        起こった回数：{$o_file_contents{1}}回 <br>
        </font>
        </div>
HTML;

      if ($o_file_contents_num > 3) {
        $time_split_counter = 2; /*時間を単位に分けて配列に格納*/
        while ($time_split_counter < $o_file_contents_num):
          $date_time = explode(' ', $o_file_contents{$time_split_counter});
          $date = explode('/', $date_time{0});
          $time = explode(':', $date_time{1});
          $chlono[] = [$date{0},$date{1},$date{2},$time{0},$time{1},$time{2}];
          $time_split_counter++;
        endwhile;


        /*起こった期間の計算*/
        $start_day = $chlono{0}{0} . "-" . $chlono{0}{1} . "-" . $chlono{0}{2};
        $final_day = $chlono{$o_file_contents_num - 3}{0} . "-" . $chlono{$o_file_contents_num - 3}{1} . "-" . $chlono{$o_file_contents_num - 3}{2};
        $datetime1 = date_create($start_day);
        $datetime2 = date_create($final_day);
        $delta_day = date_diff($datetime1, $datetime2);
        $delta_day = $delta_day->format('%a');

        $start_sec = $chlono{0}{3}*3600 + $chlono{0}{4}*60 + $chlono{0}{5};
        $final_sec = $chlono{$o_file_contents_num - 3}{3}*3600 + $chlono{$o_file_contents_num - 3}{4}*60 + $chlono{$o_file_contents_num - 3}{5};
        $delta_sec = $final_sec - $start_sec;
        if ($delta_sec < 0) {
          $delta_sec = 86400 + $delta_sec;
        }
        $delta_time = $delta_day*86400 + $delta_sec;
        $delta_time_hour = $delta_time/3600;
        $delta_time_day = $delta_time/86400;
        $delta_time_month = $delta_time/2592000;
        $delta_time_year = $delta_time/31536000;

        /*1秒あたりの確率の計算*/
        $prob = $o_file_contents{1}/$delta_time;

        /*時間あたりに少なくとも1回起こる確率の計算*/
        $prob_hour = 1 - (1 - $prob)**3600;
        $prob_3hour = 1 - (1 - $prob)**10800;
        $prob_6hour =  1 - (1 - $prob)**21600;
        $prob_12hour =  1 - (1 - $prob)**43200;

        $prob_day = 1 - (1 - $prob)**86400;
        $prob_3day = 1 - (1 - $prob)**259200;
        $prob_7day = 1 - (1 - $prob)**604800;
        $prob_14day = 1 - (1 - $prob)**1209600;
        
        $prob_month = 1 - (1 - $prob)**2592000;
        $prob_3month = 1 - (1 - $prob)**7862400;
        $prob_6month = 1 - (1 - $prob)**15811200;

        $prob_year = 1 - (1 - $prob)**31536000;
        $prob_3year = 1 - (1 - $prob)**94608000;
        $prob_10year = 1 - (1 - $prob)**315360000;
        $prob_30year = 1 - (1 - $prob)**946080000;
        $prob_50year = 1 - (1 - $prob)**1576800000;
        
        /*時間あたりに起こる平均回数の計算*/
        $expec_hour = $prob*3600;
        $expec_3hour = $prob*10800;
        $expec_6hour = $prob*21600;
        $expec_12hour = $prob*43200;

        $expec_day = $prob*86400;
        $expec_3day = $prob*259200;
        $expec_7day = $prob*604800;
        $expec_14day = $prob*1209600;

        $expec_month = $prob*2592000;
        $expec_3month = $prob*7862400;
        $expec_6month = $prob*15811200;
        
        $expec_year = $prob*31536000;
        $expec_3year = $prob*94608000;
        $expec_10year = $prob*315360000;
        $expec_30year = $prob*946080000;
        $expec_50year = $prob*1576800000;

        echo <<<HTML
        
        <div style="text-align:center;">
        <font size="5">
        起こった期間（秒）：{$delta_time} 秒<br>
        起こった期間（時間）：{$delta_time_hour} 時間<br>
        起こった期間（日）：{$delta_time_day} 日<br>
        起こった期間（月）：{$delta_time_month} 月<br>
        起こった期間（年）：{$delta_time_year} 年<br><br>
        1秒あたりに起こる確率：{$prob} <br><br><br>
        x時間以内に少なくとも1回起こる確率<br>
        x時間：　　確率<br>
        1時間：{$prob_hour}<br>
        3時間：{$prob_3hour}<br>
        6時間：{$prob_6hour}<br>
        12時間：{$prob_12hour}<br><br>
        x日以内に少なくとも1回起こる確率<br>
        x日：　　確率<br>
        1日：{$prob_day}<br>
        3日：{$prob_3day}<br>
        7日：{$prob_7day}<br>
        14日：{$prob_14day}<br><br>
        x月以内に少なくとも1回起こる確率<br>
        x月：　　確率<br>
        1月：{$prob_month}<br>
        3月：{$prob_3month}<br>
        6月：{$prob_6month}<br><br>
        x年以内に少なくとも1回起こる確率<br>
        x年：　　確率<br>
        1年：{$prob_year}<br>
        3年：{$prob_3year}<br>
        10年：{$prob_10year}<br>
        30年：{$prob_30year}<br>
        50年：{$prob_50year}<br><br><br>
        x時間以内に起こる平均回数<br>
        x時間：　　回数<br>
        1時間：{$expec_hour}<br>
        3時間：{$expec_3hour}<br>
        6時間：{$expec_6hour}<br>
        12時間：{$expec_12hour}<br><br>
        x日以内に起こる平均回数<br>
        x日：　　回数<br>
        1日：{$expec_day}<br>
        3日：{$expec_3day}<br>
        7日：{$expec_7day}<br>
        14日：{$expec_14day}<br><br>
        x月以内に起こる平均回数<br>
        x月：　　回数<br>
        1月：{$expec_month}<br>
        3月：{$expec_3month}<br>
        6月：{$expec_6month}<br><br>
        x年以内に起こる平均回数<br>
        x年：　　回数<br>
        1年：{$expec_year}<br>
        3年：{$expec_3year}<br>
        10年：{$expec_10year}<br>
        30年：{$expec_30year}<br>
        50年：{$expec_50year}<br><br>
        以下ログ<br><br>

        </font>
        </div>
HTML;

        $log_counter = 2; /*ログの表示*/
        while ($log_counter < $o_file_contents_num):
        echo <<<HTML
        <div style="text-align:center;">
        <font size="5">
          {$o_file_contents{$log_counter}}
          </font>
          </div>
HTML;
        $log_counter++;
        endwhile;
      }
    }
}


?>


</body>
</html>

