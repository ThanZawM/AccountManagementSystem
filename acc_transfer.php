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

                $faccn = test_input($_POST['facc']);
                foreach($acc_list as $x){
                    if($x->name == $faccn)
                        $faccv = $x->balance;
                }
                echo $faccv."<br>";//From account value

                $taccn = test_input($_POST['tacc']);
                foreach($acc_list as $x){
                    if($x->name == $taccn)
                        $taccv = $x->balance;
                }
                echo $taccv."<br>";// To account value
                
                $new_faccv = (int)$faccv - $amount;
                $new_taccv = (int)$taccv + $amount;

                $file_contents = file_get_contents("accounts_json.txt");
                //print_r($file_contents);
                //echo "<br>";
                $new_file_contents = $file_contents;
                foreach($acc_list as $x){
                    if($x->name == $faccn){
                        $new_file_contents = str_replace($x->balance, $new_faccv, $new_file_contents);
                    }
                    if($x->name == $taccn){
                        $new_file_contents = str_replace($x->balance, $new_taccv, $new_file_contents);
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
            <label size="15">From Account</label>
            <select name="facc">
                <?php
                if(empty($acc_list)){
                    echo "<option>No Account List.</option>";
                }
                else{
                    foreach($acc_list as $x){
                        echo "<option>$x->name</option>";
                    }
                }
                ?>
            </select><br><br>
            <label style="width: 200px">To Account</label>
            <select name="tacc">
            <?php
                if(empty($acc_list)){
                    echo "<option>hello</option>";
                }
                else{
                    foreach($acc_list as $x){
                        echo "<option>$x->name</option>";
                    }
                }
                ?>
            </select><br><br>
            <label>Transfer Amount</label><br>
            <input type="number" name="amount"><br><br>
            <input type="submit" value="Transfer" />
        </form>
    </body>
</html>