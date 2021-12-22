<?php
    if(isset($_POST['submit'])){
        $name = $_POST['name'];
        $mailFrom = $_POST['mail'];
        $question = $_POST['question'];
        $subject = "Запитване";

        $mailTo = "atanashristozov@abv.bg";
        $headers = "From".$mailFrom;
        $txt = "You have received an e-mail from ".$name.".\n.\n".$question ;
        mail($mailTo, $subject, $txt, $headers);
        header("Location: Contacts.php?mailsend");
    }
?>