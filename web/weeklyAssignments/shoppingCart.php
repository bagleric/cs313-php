<?php
class Item {
    function Item() {
        $this->name = "Donut";
        $this->price =5;
    }
    public function display(){
        echo "$this->name is the donut of the century. It costs only $this->price"; 
    }
    
}

// create an object
$herbie = new Item();

// show object properties
echo $herbie->price;
$herbie->display();
$items = array(1, $herbie);
echo $items[1];
?>