<?php require_once "./pizzaOOP.php";
interface calculatingSomething {
    static function calculateMyWay();
    static function get_usd_course();
}

class calculatingBill implements calculatingSomething{
    static function get_usd_course(){ 
        error_reporting(~E_WARNING); //no warning 404 from the bank's website if the exchange rate address becomes unavailable
        $data = file_get_contents('https://www.nbrb.by/api/exrates/rates/431'); // obtaining the official exchange rate (updated daily)
        if ($data) {
        $courses = json_decode($data, true); // var_dump($courses); // just for testing
        return $courses['Cur_OfficialRate'];
        } else {
        return 2.6; // if there is no access to the bank page
        }
    }
    static function calculateMyWay() { // using MySQL 8.0.28
        $mysqli = new mysqli('localhost','root','','shopee');
        $type = ($_POST['type']) ? $mysqli->real_escape_string(trim($_POST['type'])) : 'Pepperoni';
        $size = ($_POST['size']) ? $mysqli->real_escape_string(trim($_POST['size'])) : 21;
        $sauce = ($_POST['sauce']) ? $mysqli->real_escape_string(trim($_POST['sauce'])) : 'cheesy';
        $resultSeclect = $mysqli->prepare                   // basic SQL injection protection
        ("SELECT `price` FROM `pizzaType` WHERE `name` = ? 
        UNION ALL
        SELECT `price` FROM `pizzaSize` WHERE `size` = ? 
        UNION ALL
        SELECT `price` FROM `pizzaSauce` WHERE `name` = ?");
        $resultSeclect->bind_param('sis', $type, $size, $sauce);
        $resultSeclect->execute();
        $resultSeclect = $resultSeclect->get_result();
        $type = $resultSeclect->fetch_assoc();
        $size = $resultSeclect->fetch_assoc();
        $sauce = $resultSeclect->fetch_assoc();
        $current_exchange_rate = ceil( self::get_usd_course() * 100) / 100;
      //var_dump($type); var_dump($size); var_dump($sauce); // preview for testing
      //$types = ["Pepperoni" => 1, "Country" => 2, "Hawaiian" => 3, "Mushroom" => 4]; $sizes = ["21" => 1, "26" => 2, "31" => 3, "45" => 4]; 
      //$sauces = ["cheesy" => 1, "sweet_and_sour" => 2, "garlic" => 3, "barbecue" => 4]; echo ($types[$_POST['type']] * $sizes[$_POST['size']] + $sauces[$_POST['sauce']]);
        date_default_timezone_set('UTC');
    return '<hr>BILL<br>THE TOTAL COST OF YOUR ORDER IS <b><i>'.($type['price'] * $size['price'] + $sauce['price']) * $current_exchange_rate .' BYN</i></b>:<br><br>'.
    (($_POST['sauce']) ? $mysqli->real_escape_string(trim($_POST['sauce'])) : 'cheesy') . ' sauce costs <b><i>'.$sauce['price'] * $current_exchange_rate.' BYN
    <br>+</i></b><br>' . (($_POST['type']) ? $mysqli->real_escape_string(trim($_POST['type'])) : 'Pepperoni') . ' pizza ' .
    '(' . (($_POST['size']) ? $mysqli->real_escape_string(trim($_POST['size'])) : 21) . ' cm) costs ' . $type['price'] * $current_exchange_rate . '*' . $size['price'] . 
    ' BYN = <b><i>'. ( $type['price'] * $size['price'] * $current_exchange_rate ) . ' BYN</i></b><br><br>
    <i>It was calculated on ' . date('l jS \of F Y h:i:s A') . ' UTC+0<br> 
    Prices was taken from the database in USD and converted into BYN at the exchange rate at the time of bill getting.</i>';
    } // size is just a coefficient to calculate the price
}

$pizzaStore = new Store1();
$pizza = $pizzaStore->orderPizza($_POST['type'], $_POST['size'], $_POST['sauce']);
echo '<p>' . calculatingBill::calculateMyWay() . '</p>';
?>