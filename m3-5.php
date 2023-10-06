<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-5</title>
</head>
<body>
    パスワード、名前、コメントを記入して送信するとコメントを投稿することができます。<br>
    パスワードと投稿番号を入力し、削除ボタンを押すことでコメントを削除することができます。<br>
    パスワードと投稿番号を入力し、編集ボタンを押すことでコメントを編集することができます。<br><br>
    
    <?php
    $filename = "m3-5.txt";
    
    if(!empty($_POST["del_num"])){
        //削除フォームに入力された場合
        $del_num = $_POST["del_num"];
        $del_pass = $_POST["del_pass"];
        
        //ファイルの読み込みと投稿番号の取得
        if(file_exists($filename)){
            //ファイル読み込み関数で、ファイルの中身を1行1要素として配列変数にする
            $lines = file($filename, FILE_IGNORE_NEW_LINES);
            //ファイルを書き出しで開く
            $fp = fopen($filename, "w");
            //パスワード確認用
            $pass_chack = 0;
            //配列の要素の分ループさせる          
            foreach($lines as $line){
                $volume = explode("<>", $line);
                $del_txt_num = $volume[0]; 
                $txt_num = $volume[0];
                $txt_name = $volume[1];
                $txt_coment = $volume[2];
                $txt_day = $volume[3];
                $txt_pass = $volume[4];
                

                //削除番号と投稿番号の比較
                if($del_num != $del_txt_num){
                    //投稿番号(del_txt_num)が削除番号(del_num)より小さかったら-1して番号を修正する
                    if($del_num < $del_txt_num && $pass_chack == 0){
                        $del_txt_num = $del_txt_num -1;
                    }
                    //ファイルへの書き込み
                    $ex_post = $del_txt_num."<>".$txt_name."<>".$txt_coment."<>".$txt_day."<>".$txt_pass."<>";
                    fwrite($fp, $ex_post.PHP_EOL);
                }else{
                    //パスワードがない際、削除できないようにする
                    if($txt_pass != ""){
                        //パスワードが違う場合
                        if($del_pass != $txt_pass){
                            //パスワードが違う場合は書き込む。
                            $ex_post = $del_txt_num."<>".$txt_name."<>".$txt_coment."<>".$txt_day."<>".$txt_pass."<>";
                            fwrite($fp, $ex_post.PHP_EOL);
                            $pass_chack++;
                            echo "パスワードが違います";
                        }    
                    }else{
                        $ex_post = $del_txt_num."<>".$txt_name."<>".$txt_coment."<>".$txt_day."<>".$txt_pass."<>";
                        fwrite($fp, $ex_post.PHP_EOL);
                        $pass_chack++;
                        echo "この投稿は削除できません";
                    }
                }
            }
            fclose($fp);
        }
    }elseif(!empty($_POST["edit_num"])){
        //編集フォームに入力された場合
        $edit_num = $_POST["edit_num"];
        $edit_pass = $_POST["edit_pass"];
        
        if(file_exists($filename)){
            //ファイル読み込み関数で、ファイルの中身を1行1要素として配列変数にする
            $edit_lines = file($filename, FILE_IGNORE_NEW_LINES);
            //ファイルを開く
            $fp = fopen($filename, "r");
            
            foreach($edit_lines as $edit_line){
                $volume = explode("<>", $edit_line); 
                $edit_txt_num = $volume[0];
                $edit_txt_pass = $volume[4];
                
                //名前とコメントを新規投稿フォームに表示する。
                if($edit_num == $edit_txt_num && $edit_pass == $edit_txt_pass){
                    if($edit_pass != ""){
                    //番号とpassがあっているとき
                    $edit_txt_name = $volume[1];
                    $edit_txt_coment = $volume[2];
                    echo $edit_txt_name."さんの投稿を編集中<br>";
                    echo "編集内容を記載してください";
                    
                    }else{
                        $edit_txt_name = "";
                        $edit_txt_coment = "";
                        echo "この投稿は編集できません";
                    }
                    
                }elseif($edit_num == $edit_txt_num){
                    //passが違うとき
                    $edit_txt_name = "";
                    $edit_txt_coment = "";
                    echo "パスワードが違います";
                }
            }
            fclose($fp);
        }
        
    }else{
       
        //編集済み番号に入力があった場合
        if(!empty($_POST["edited_num"])){
            $edited_num = $_POST["edited_num"];
            $edited_name = $_POST["name"];
            $edited_coment = $_POST["coment"];
            $edited_pass = $_POST["pass"];
            
            if($edited_pass != ""){
                if(file_exists($filename)){
                    //ファイルを配列変数に代入し、ファイルを開く
                    $edited_lines = file($filename, FILE_IGNORE_NEW_LINES);
                    $fp = fopen($filename, "w");
                    
                    foreach($edited_lines as $edited_line){
                        $volume = explode("<>", $edited_line);
                        $edited_txt_num = $volume[0];
                        $edited_txt_name = $volume[1];
                        $edited_txt_coment = $volume[2];
                        $edited_txt_day = $volume[3];
                        $edited_txt_pass = $volume[4];
                        
                        if($edited_num == $edited_txt_num  && $edited_pass == $edited_txt_pass){
                            //編集するコメントへの処理
                            $edited_post = $edited_txt_num."<>".$edited_name."<>".$edited_coment."<>".$edited_txt_day."<>".$edited_txt_pass."<>";
                            fwrite($fp, $edited_post.PHP_EOL);
                        }elseif($edited_num == $edited_txt_num  && $edited_pass != $edited_txt_pass){
                            //パスワードが違う編集コメントの処理
                            $comon_post = $edited_txt_num."<>".$edited_txt_name."<>".$edited_txt_coment."<>".$edited_txt_day."<>".$edited_txt_pass."<>";
                            fwrite($fp, $comon_post.PHP_EOL);
                            echo "パスワードが違います。";
                        }else{
                            //対象外のコメントの処理。
                            $comon_post = $edited_txt_num."<>".$edited_txt_name."<>".$edited_txt_coment."<>".$edited_txt_day."<>".$edited_txt_pass."<>";
                            fwrite($fp, $comon_post.PHP_EOL);

                        }
                    }
                    fclose($fp);
                }
            }else{
                echo "パスワードを入力してください。";
            }
            
        }else{
        
            //新規投稿フォーム(編集済み番号、削除、編集フォームに入力されなかった場合)
            if(!empty($_POST["name"]) && !empty($_POST["coment"])){
                //入力フォームに入力された情報
                $name = $_POST["name"];
                $coment = $_POST["coment"];
                $pass = $_POST["pass"];
                $day = date("Y/m/d H:i:s");
                
                //テキストファイルがあれば、テキストファイルの行数+1を投稿番号にする。
                if(file_exists($filename)){
                    $num = count(file($filename))+1;
                }else{
                    $num = 1;
                }

                //テキストファイルへの書き込み
                $data = $num."<>".$name."<>".$coment."<>".$day."<>".$pass."<>";
                $fp = fopen($filename, "a");
                fwrite($fp, $data.PHP_EOL);
                fclose($fp);
                
            }
        }
    }
    ?>
    
    <?php
    if(empty($_POST["edit_num"])){
    
    $edit_num = "";    
    $edit_txt_name = "";
    $edit_txt_coment = "";
    }
    ?>
    <!--入力フォーム。名前とコメントを入力-->
    <form action="" method="post">
        <!--コメント入力フォーム-->
        <input type = "hidden" name = "edited_num" value= <?= $edit_num ?>>
        <input type = "txt" name = "pass" placeholder = "パスワード" size = "8px">
        <input type = "txt" name = "name" placeholder = "お名前" size = "8px" value =<?= $edit_txt_name ?>>
        <input type = "txt" name = "coment" placeholder = "コメントを入力してください" size = "25px" value = <?= $edit_txt_coment ?>>
        <input type = "submit" name = "submit">
        <br>
        <!--削除フォーム-->
        <input type = "txt" name = "del_pass" placeholder = "パスワード" size = "8px">
        <input type = "number" name = "del_num" placeholder = "削除番号を入力">
        <input type = "submit" name = "del_submit" value = "削除">
        <br>
        <!--編集フォーム-->
        <input type = "txt" name = "edit_pass" placeholder = "パスワード" size = "8px">
        <input type = "number" name = "edit_num" placeholder = "編集番号を入力">
        <input type = "submit" name = "edit_submit" value = "編集">
        
    </form>

    <?php
    //テキストファイルをブラウザ表示
    if(file_exists($filename)){
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        
        foreach($lines as $line){
            $volume =  explode("<>", $line);
            $txt_num = $volume[0];
            $txt_name = $volume[1];
            $txt_coment = $volume[2];
            $txt_day = $volume[3];
            //後で消す
            $txt_pass = $volume[4];
            
            $ex_post = $txt_num."  ".$txt_name."  ".$txt_coment."  ".$txt_day;
            
            echo $ex_post."<br>";
        }
    }
    ?>

</body>
</html>