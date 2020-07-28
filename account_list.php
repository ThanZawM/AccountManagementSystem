<!DOCTYPE html>
<html>
    <head>
        <title>Account List</title>
        <?php
            $acc_list = array();
            function showStudentFromJson(){
                $myfile = fopen('accounts_json.txt','r');
               
                while(!feof($myfile)) {
                    global $acc_list;
                    $acc = fgets($myfile);
                    if($acc != ""){
                        $a1 = json_decode($acc, true);
                        array_push($acc_list, $a1);
                    }
                }
                return $acc_list;
                fclose($myfile);
            }
           $acc_list = showStudentFromJson();
        ?>
    </head>
    <body>
        <?php
        include 'acc_menu.html';
        ?>
        <h3>Account List</h3>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Balance</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(count($acc_list)>0){
                        foreach($acc_list as $acc){
                            //echo "acc type = ".$acc."<br>";
                            echo('<tr>');
                            if(is_array($acc) || is_object($acc) || !empty($acc)){
                                foreach($acc as $cell) {
                                    echo('<td>' . $cell . '</td>');
                                }
                            }
                            else{
                                echo "Unfortunately, an error occured.";
                            }
                            echo('</tr>');
                        }
                    }
                    else{
                        echo "No Array Elements!";
                    }  
                ?>
            </tbody>
        </table>
    </body>
</html>