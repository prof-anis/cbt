<?php
namespace App\Controllers;

use App\Utilities\DB\QueryBuilder;

class Payment{

    public function payMe(){
		$courses = new Courses;
		$courses = $courses->getCourses();
		// 
		$email = $_SESSION['name'];
		return render('Payment/payment', ['email'=>$email, 'courses'=>$courses]);
	}
	
    public function Pay($price){
    $qb = new QueryBuilder;
    $status = $qb->select('is_premium', 'package')->from("accounts")->where([['email', $_SESSION['name']]])->get();
    if($status['is_premium'] == true){
        $_SESSION['package_status'] = "You are already a premium user on our ".$status['package']." plan";
        header("Location: ".route("pay_me")."");exit;
    }
    $url = "https://api.paystack.co/transaction/initialize";

	$fields = [

		'email' => $_SESSION['name'],

		'amount' => $price,

		'callback_url' => route('callback_url', ['price'=>$price]),

	];

	$fields_string = http_build_query($fields);

	//open connection

	$ch = curl_init();

	

	//set the url, number of POST vars, POST data

	curl_setopt($ch,CURLOPT_URL, $url);

	curl_setopt($ch,CURLOPT_POST, true);

	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

	curl_setopt($ch, CURLOPT_HTTPHEADER, array(

		"Authorization: Bearer sk_test_9a47279feea55a32f77687f0a5eaf6a81729f255",

		"Cache-Control: no-cache",

	));

	

	//So that curl_exec returns the contents of the cURL; rather than echoing it

	curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 

	

	//execute post

	$result = curl_exec($ch);

	$result = json_decode($result,true);
	$auth_url = $result['data']['authorization_url'];
	header("Location: ".$auth_url);


	}

	public function paymentSuccess($price){
        
        $qb = new QueryBuilder;
        if ($price == 7500000) {
            $package = "business";
        }elseif ($price == 12500000) {
            $package = "premium";
        }
		$update_status = $qb->update("accounts", ["is_premium"=>"true", "package"=>$package])->get();
		if ($update_status == 1) {
			echo "Payment Successful, you can now enjoy all our products at no extra or hidden charges";
        }
        echo "<br>".$package;
	}

}

?>