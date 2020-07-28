<!DOCTYPE html>
<html>
    <head>
        <title>Account Transfer</title>
        <?php
            $acc_list = array();
            $myfile = fopen('accounts_json.txt','r');
            while(!feof($myfile)) {
                //global $acc_list;
                $acc = fgets($myfile);
                if($acc != ""){
                    $a1 = json_decode($acc);
                    array_push($acc_list, $a1);
                }
            }
            fclose($myfile);

            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                $amount = test_input($_POST['amount']);

                $accn = test_input($_POST['acc']);
                foreach($acc_list as $x){
                    if($x->name == $accn)
                        $accv = $x->balance;
                }
                //echo $accv."<br>";//From account value

                if(isset($_POST['credit'])){
                    $new_accv = (int)$accv + $amount;
                }
                elseif(isset($_POST['debit'])){
                    $new_accv = (int)$accv - $amount;
                }

                $file_contents = file_get_contents("accounts_json.txt");
                //print_r($file_contents);
                //echo "<br>";
                $new_file_contents = $file_contents;
                foreach($acc_list as $x){
                    if($x->name == $accn){
                        $new_file_contents = str_replace($x->balance, $new_accv, $new_file_contents);
                    }
                    file_put_contents("accounts_json.txt", $new_file_contents);
                }
                //print_r($acc_list);
                //echo "<br>";
              }

              function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
              }

        ?>
    </head>
    <body>
    <?php
        include 'acc_menu.html';
        ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label>Account</label>
            <select name="acc">
                <?php
                foreach($acc_list as $x){
                    echo "<option>$x->name</option><br>";
                }
                ?>
            </select><br>
            <label>Amount</label>
            <input type="number" name="amount"><br><br>
            <input type="submit" name="credit" value="Credit"/>
            <input type="submit" name="debit" value="Debit"/>
        </form>
    </body>
</html>