<!DOCTYPE html>
<html>
    <head>
        <title>Account Credit/Debit</title>
        <?php
        
            $acc_list = array();
            function getData(){
                $myfile = fopen('accounts_json.txt','r');
               
                while(!feof($myfile)){
                    global $acc_list;
                    $acc = fgets($myfile);
                    if($acc != ""){
                        $a1 = json_decode($acc);
                        array_push($acc_list, $a1);
                    }
                }
                return $acc_list;
                fclose($myfile);
            }
            $acc_list = getData();

            $acc = $amount = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $acc = test_input($_POST["acc"]);
                $amount = test_input($_POST["amount"]);
                updateAccount($acc, $amount);
            }

            function updateAccount($acc, $amount){
                $dir = "accounts_json.txt";
                $contents = file_get_contents($dir);
                $new_contents = "";
                //$contents_array = preg_split("/\\r\\n|\\r|\\n/", $contents);
                foreach ($contents as &$record) { 
                    // for each line
                    if($record != ""){
                        //echo "before ->".$record."<br>";
                        $d_std = json_decode($record);
                        //echo "after decode ->".$d_std->name."\t";
                        if($d_std->name == $acc){
                            $d_std->balance += $amount;
                            $new_contents .= json_encode($d_std)."\r";
                            //echo json_decode($new_contents)->balance."<br>"; 
                        }
                        else{
                            $new_contents .= $record."\r";
                        }
                    }
                }
                file_put_contents($dir, $new_contents);
            }
            //file_put_contents($dir, $new_contents); // save the records to the file
            //echo json_encode("Successfully updated record!");

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
            <input type="number" name="amount" size="15">
            <input type="submit" name="credit" value="Credit"/>
            <!-- <input type="submit" name="debit" value="Debit"/> -->
        </form>
    </body>
</html>