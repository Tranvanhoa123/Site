<style>
*{
	margin: 0 auto;
	width: 382px;
	font-family: Arial;
}
form{
	margin-top: 50px;
	background: #dfd;
	margin-bottom: 20px;
	padding-top: 20px;
    padding-bottom: 20px;
}
form input{
	text-align: center;
}
input[type="text"], input[type="password"], input[type="submit"]{
	width: 250px;
	padding: 5px;
	margin-top: 2px;
	
}
input:focus{
	border: 1px solid green;
}
input[type="submit"], form span{
	background: green;
	color: yellow;
	padding: 5px;
	
}
.inra{
	margin-top: 10px;
	padding: 8px;
    background: green;
	color: yellow;
	font-size: 12px;
	font-family: Arial;
	font-weight: bold;
	width: 500px;
	word-break: break-word;
}
#footer{
	background: green;
	color: yellow;
	padding: 8px;
	text-align: center;
	font-family: Arial
}
#footer a{
	color: yellow;
	font-weight: bold;
	
}
.thongbao{
	border: 1px solid green;
    color: red;
    padding: 8px;
    
	list-style: decimal;
}
.title{
	background: green;
	color: yellow;
	padding: 8px;
	margin-top: 50px;
	font-weight: bold;
}
.file{
	background: transparent;
	color: blue;
	border: 1px solid green;
	margin-top: 0px;
}
</style>

<?php 
//xử lý dữ liệu
if(isset($_POST["code"])){ $code = $_POST["code"];}

$ToanChinhQuy = "/EAAAAA[a-zA-Z0-9]{5,600}/";
	preg_match($ToanChinhQuy,$code,$ArrayGet);

	/*echo '<pre>';
	print_r($ArrayGet);
	echo '</pre>';*/
	$token = $ArrayGet[0];
//func khiên
echo batkhien($token);
 function batkhien($token){ 
   $idfb = json_decode(file_get_contents("https://graph.facebook.com/me?access_token=".$token),true);
   if(empty($idfb['id']))
   {
	   $ThongBao  = "<p class='title'>Error in turning on guard! Maybe due to the following errors: </p>";
	   $ThongBao .= "<li class='thongbao'>Account name or password is incorrect ! </li>";
	   $ThongBao .= "<li class='thongbao'>Your account is verified with identity please visit and log into facebook to verify and then try again !</li>";
	   	$ThongBao .= "<li class='thongbao'>Your access code has expired.</li>";

   return $ThongBao;
   }
   else
   {
    $headers2 = array();
    $headers2[] = 'Authorization: OAuth '.$token;
    $data = 'variables={"0":{"is_shielded":true,"session_id":"9b78191c-84fd-4ab6-b0aa-19b39f04a6bc","actor_id":"'.$idfb['id'].'","client_mutation_id":"b0316dd6-3fd6-4beb-aed4-bb29c5dc64b0"}}&method=post&doc_id=1477043292367183&query_name=IsShieldedSetMutation&strip_defaults=true&strip_nulls=true&locale=en_US&client_country_code=US&fb_api_req_friendly_name=IsShieldedSetMutation&fb_api_caller_class=IsShieldedSetMutation';
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, "https://graph.facebook.com/graphql");
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($c, CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);  
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_HTTPHEADER, $headers2);
    curl_setopt($c,CURLOPT_POST, 1);
    curl_setopt($c,CURLOPT_POSTFIELDS,$data);
    $page = curl_exec($c);
    curl_close($c);
	$ThongBao = "<p class='thongbao'> Successful ✔️ Please Check Your Facebook </p>";
    return $ThongBao;
}
}
?>

