<?php
require_once('../config.php');

$clientToken = Braintree_ClientToken::generate();
?><?php echo $clientToken ?>
