<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-3</title>
</head>
<body>
    <!--入力フォーム。名前とコメントを入力-->
    <form action="" method="post">
        <!--コメント入力フォーム-->
        <input type = "txt" name = "name" placeholder = "お名前" size = "8px" value = "kk">
        <input type = "txt" name = "coment" placeholder = "コメントを入力してください" value = "コメント">
        <input type = "submit" name = "submit">
        <br>
        <!--削除フォーム-->
        <input type = "number" name = "del_num" placeholder = "削除番号を入力">
        <input type = "submit" name = "del_submit" placeholder = "削除">
        
    </form>
    <?php
    
    if(!empty($_POST["del_num"])){
        //削除フォームに入力された場合
        $del_num = $_POST["del_num"];
        $filename = "m3-3.txt";
        
        //ファイルの読み込みと投稿番号の取得
        if(file_exists($filename)){
            //ファイル読み込み関数で、ファイルの中身を1行1要素として配列変数にする
            $lines = file($filename, FILE_IGNORE_NEW_LINES);
            //ファイルを書き出しで開く
            $fp = fopen($filename, "w");
            //配列の要素の分ループさせる
            foreach($lines as $line){
                $volume = explode("<>", $line);
                $del_txt_num = $volume[0]; 
                $txt_num = $volume[0];
                $txt_name = $volume[1];
                $txt_coment = $volume[2];
                $txt_day = $volume[3];
                
                //削除番号と投稿番号の比較
                if($del_num != $del_txt_num){
                    //投稿番号(del_txt_num)が削除番号(del_num)より小さかったら-1して番号を修正する
                    if($del_num < $del_txt_num){
                        $del_txt_num = $del_txt_num -1;
                    }
                    //ファイルへの書き込み
                    $ex_post = $del_txt_num."<>".$txt_name."<>".$txt_coment."<>".$txt_day;
                    fwrite($fp, $ex_post.PHP_EOL);
                }
            }
            fclose($fp);
        }
        
    }else{
        //削除フォームに入力されなかった場合
        if(!empty($_POST["name"]) && !empty($_POST["coment"])){
            //入力フォームに入力された情報
            $name = $_POST["name"];
            $coment = $_POST["coment"];
            $day = date("Y/m/d H:i:s");
            
            //テキストファイルの行数+1を投稿番号にする。
            $filename = "m3-3.txt";
            $num = count(file($filename))+1;
     
            
            //テキストファイルへの書き込み
            $data = $num."<>".$name."<>".$coment."<>".$day;
            $fp = fopen($filename, "a");
            fwrite($fp, $data.PHP_EOL);
            fclose($fp);
            
        }
    }
    
    //テキストファイルをブラウザ表示
    if(file_exists($filename)){
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        
        foreach($lines as $line){
            $volume =  explode("<>", $line);
            $txt_num = $volume[0];
            $txt_name = $volume[1];
            $txt_coment = $volume[2];
            $txt_day = $volume[3];
            
            $ex_post = $txt_num." ".$txt_name." ".$txt_coment." ".$txt_day;
            
            echo $ex_post."<br>";
        }
    }

    ?>
    
</body>
</html>