<?php  
include 'function.php';


function referral($ref) {
	$fake_name = get('https://fakenametool.net/generator/random/id_ID/indonesia');
	preg_match_all('/<td>(.*?)<\/td>/s', $fake_name, $result);

	$name = $result[1][0];
	$user = explode(' ', $name);
	$alamat = $result[1][2];
	$base = ['0878', '0813', '0838', '0851', '0853'];
	$rand_base = array_rand($base);
	$number = $base[$rand_base].number(7);
	$domain = ['carpin.org', 'novaemail.com'];
	$rand = array_rand($domain);
	$email = str_replace(' ', '', strtolower($name)).number(2).'@'.$domain[$rand];
	$username = explode('@', $email);
	$password = random(8);


	$headers = [

		'Host: wp.smlxt.com',
		'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:83.0) Gecko/20100101 Firefox/83.0',
		'Accept: */*',
		'Accept-Language: id,en-US;q=0.7,en;q=0.3',
		'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
		'X-Requested-With: XMLHttpRequest',

	];

	echo "\nTry to register\n";
	$register = post('http://wp.smlxt.com/index/login/register.html', 'utel='.$number.'&upwd='.$password.'&upwd2='.$password.'&oid='.$ref, $headers);

	if (stripos($register, '"data":"Operation successful!"')) {
		echo "Success to register\n";
		echo "Try to login\n";
		$login = post('http://wp.smlxt.com/index/login/login.html', 'utel='.$number.'&upwd='.$password, $headers);
		$cookies = getcookies($login);

		if (stripos($login, 'Login successful')) {

			$header = [

				'Host: wp.smlxt.com',
				'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:83.0) Gecko/20100101 Firefox/83.0',
				'Accept: */*',
				'Accept-Language: id,en-US;q=0.7,en;q=0.3',
				'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
				'X-Requested-With: XMLHttpRequest',
				'Cookie: PHPSESSID='.$cookies['PHPSESSID'].'; think_var=en-us'

			];

			$buy = post('http://wp.smlxt.com/index/ore/buy/id/1.html', 'buytime=24', $header);

			if (stripos($buy, '"code":1,"msg":"Operation successful!"')) {
				echo "Success to buy miner | ".$cookies['PHPSESSID']."\n";
			} else {
				echo "Failed to buy miner\n";
			}

		} else {
			echo "Login failed\n";
		}
	} else {
		echo "Failed to register\n";
	}
}


echo "Referral code : ";
$ref = trim(fgets(STDIN));

if ($ref != "") {
	while (true) {
	    referral($ref);
	}
}

