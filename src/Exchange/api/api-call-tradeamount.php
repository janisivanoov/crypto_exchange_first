<?php
         if(isset($_POST['report'])) {
		 if(!isset($_POST['inputWallet']) || strlen($_POST['inputWallet'])<1)
	{
		die("To which wallet we need to send your new traded coins?");
	}
	if(!isset($_POST['inputAantal']) || strlen($_POST['inputAantal'])<1)
		{
		die("Please set the amount of coins you wish to trade.");
	}
	if(!isset($_POST['inputRefund']) || strlen($_POST['inputRefund'])<1)
	{
		die("In case of any error during the trading proccess, where can we refund your original coins too (your wallet address)?");
	}
	$sendwallet			= strip_tags($_POST['inputWallet']); 
	$amountset			= strip_tags($_POST['inputAantal']); 	 
	$refundaddress		= strip_tags($_POST['inputRefund']); 
    $message = json_encode(
        array('jsonrpc' => '2.0', 'id' => 1, 'method' => 'getExchangeAmount', 'params' => array('from' =>'ltc', 'to' =>'eth', 'amount' => "$amountset"))
    );
    $sign = hash_hmac('sha512', $message, $apiSecret);
    $requestHeaders = [
        'api-key:' . $apiKey,
        'sign:' . $sign,
        'Content-type: application/json'
    ];
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $requestHeaders);
    
    $response = curl_exec($ch);
    curl_close($ch); 

$obj = json_decode($response,true);
$tradeamount = $obj["result"];
$tradeamountshort = number_format($tradeamount, 4);

		 if($minimumtrade >=$amountset )
{
  echo "<b>Mimimum amount ($amountset) is too low</b>. Please try again with the amount set atleast above $minimumtradeshort. <script>setTimeout(function(){ window.location.replace('') }, 4500); </script>"; 
}
if($minimumtrade <=$amountset )
{
		 echo "<h3>$amountset <i class='cc $pairicon'></i> $pairicon trade for $tradeamountshort <i class='cc $pairreceiveicon'></i> $pairreceiveicon.</h3>Your $tradeamountshort $pairreceiveicon receiving wallet address: <b>$sendwallet</b>

		 <br>

<a href='transaction.php?amountset=$amountset&walletreceive=$sendwallet&walletrefund=$refundaddress'><button class='btn btn-lg btn-primary btn-block'>All good! Start the coin trade!</button></a>
<br><br></form>";
		 
           
         }
		 }

?>