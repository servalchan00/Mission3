<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-1</title>
</head>
<body>
    <!--入力フォーム。名前とコメントを入力-->
    <form action="" method="post">
        <input type = "txt" name = "name" placeholder = "お名前" size = "8px" value = "kk">
        <input type = "txt" name = "coment" placeholder = "コメントを入力してください" value = "コメント">
        <input type = "submit" name = "submit">
    </form>
    <?php
    if(!empty($_POST["name"]) && !empty($_POST["coment"])){
        //入力フォームに入力された情報
        $name = $_POST["name"];
        $coment = $_POST["coment"];
        $day = date("Y/m/d H:i:s");
        
        //テキストファイルの行数+1を投稿番号にする。
        $filename = "m3-1.txt";
        /*
        $fp = fopen($filename, "r");
        for($num = 0;fgets($fp);$num++);
        fclose($fp);
        */
        $num = count(file($filename))+1;
 
        
        //テキストファイルへの書き込み
        $data = $num."<>".$name."<>".$coment."<>".$day;
        $fp = fopen($filename, "a");
        fwrite($fp, $data.PHP_EOL);
        fclose($fp);
        
        //テキストファイルをすべて表示
        if(file_exists($filename)){
            $lines = file($filename, FILE_IGNORE_NEW_LINES);
            foreach($lines as $line){
                /*
                //テキストファイルの行数取得
                $fp = fopen( $filename, 'r' );
                fgets($fp, $count);//fgets(どのファイルか, どの行数か)テキストファイルの行数を取得する関数。
                fclose($fp);
                
                //投稿されたコメント全てを表示
                echo $count.$line."<br>";
                
                //fgetsで読みだす行数に+１する。
                $count++;
                */
                echo $line."<br>";
            }
        }
        
    }
    
    ?>
    
</body>
</html>