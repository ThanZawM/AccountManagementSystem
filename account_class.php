<?php
    class Account {
        public $name;
        public $balance;
        function __construct($name, $balance){
            $this->name = $name;
            $this->balance = $balance;
        }
        function getName(){
            return $this->name;
        }
        function getBalance(){
            return $this->balance;
        }
        function showInfo(){
            echo "<h4>".$this->name."'s Information</h4>";
            echo $this->name.", ".$this->balance."<br>";
        }
        function credit($amount){
            $this->balance += $amount;
            echo "<br>$amount is added to $this->name!";
            return $this->balance;
        }
        function debit($amount){
            if($this->balance >= $amount){
                $this->balance -= $amount;
                echo "<br>$amount is subtracted! from $this->name!";
                return $this->balance;
            }
            else {
                echo "Insufficient amount!<br>";
                return $this->balance;
            }   
        }
    }
?>