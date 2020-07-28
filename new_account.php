<!DOCTYPE html>
<html>
    <head>
        <title>New Account</title>
        <?php include 'account_class.php';
            $name = $balance = "";
            
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
              $name = test_input($_POST["name"]);
              $balance = test_input($_POST["balance"]);
              saveFileWithJson($name, $balance);
            }
            
            function test_input($data) {
              $data = trim($data);
              $data = stripslashes($data);
              $data = htmlspecialchars($data);
              return $data;
            }

            function saveFileWithJson($name, $balance){
                $acc_obj = new Account($name, $balance);
                $acc_arr = array("name"=>$acc_obj->name, "balance"=>$acc_obj->balance);
                $fp = fopen('accounts_json.txt', 'a'); //opens file in write-only mode  
                fwrite($fp, json_encode($acc_arr)."\n");
                fclose($fp); 
            }
        ?>
    </head>
    <body>
        <?php
            include 'acc_menu.html';
        ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label for="name">Name</label>
            <input type="text" name="name" /><br>
            <label for="balance">Balance</label>
            <input type="number" name="balance" /><br>
            <input type="submit" value="Create Account" />
        </form>
    </body>
</html>