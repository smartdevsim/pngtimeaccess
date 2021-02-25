<?php

// Use in the “Post-Receive URLs” section of your GitHub repo.
    $content = "some text here";
    $fp = fopen"/myText.txt","wb");
    fwrite($fp,$content);
    fclose($fp);
    if ( $_POST['payload'] ) {
        $content = "some text here";
        $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/myText.txt","wb");
        fwrite($fp,$content);
        fclose($fp);
        shell_exec( 'cd /var/www/html/pngtimeaccess && git reset –hard HEAD && git pull' );
    }

?>