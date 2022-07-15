<?php
interface settingAdditionalPizzaParameters {
    function __construct($size, $sauceType);
}

abstract class Pizza {
    public $name;
    public $size;
    public $sauce;
    function prepare() {
        echo '<br>Preparing '.$this->name.'<br>with size is '.$this->size.' cm and sauce is '.str_replace('_', ' ', $this->sauce);
        }
}

abstract class PizzaStore {
    abstract function createPizza($type, $size, $sauceType);
    public function orderPizza($type, $size, $sauceType) {
     $pizza = $this->createPizza($type, $size, $sauceType);
     $pizza->prepare();
     return $pizza;
    }
}

class Store1 extends PizzaStore {
    function createPizza($type, $size, $sauceType) {
        if($type == 'Country') {
            return new Store1CountryPizza($size, $sauceType);
        } elseif ($type == 'Pepperoni') {
            return new Store1PepperoniPizza($size, $sauceType);
        } elseif ($type == 'Hawaiian') {
            return new Store1HawaiianPizza($size, $sauceType);
        } elseif ($type == 'Mushroom') {
            return new Store1MushroomPizza($size, $sauceType);
        }
    }
}

class Store1CountryPizza extends Pizza implements settingAdditionalPizzaParameters  {
    function __construct($size, $sauceType) {
		$this->name = 'Store1 Country Pizza';
        $this->size = $size;
        $this->sauce = $sauceType;
	}
}

class Store1PepperoniPizza extends Pizza implements settingAdditionalPizzaParameters  {
    function __construct($size, $sauceType) {
		$this->name = 'Store1 Pepperoni Pizza';
        $this->size = $size;
        $this->sauce = $sauceType;
	}
}

class Store1HawaiianPizza extends Pizza implements settingAdditionalPizzaParameters  {
    function __construct($size, $sauceType) {
		$this->name = 'Store1 Hawaiian Pizza';
        $this->size = $size;
        $this->sauce = $sauceType;
	}
}

class Store1MushroomPizza extends Pizza implements settingAdditionalPizzaParameters  {
    function __construct($size, $sauceType) {
		$this->name = 'Store1 Mushroom Pizza';
        $this->size = $size;
        $this->sauce = $sauceType;
	}
}
?>