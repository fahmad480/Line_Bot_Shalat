<?php
/*
copyright @ medantechno.com
2017

*/

require_once('./line_class.php');
require_once('./unirest-php-master/src/Unirest.php');

$channelAccessToken = 'KSqC4L4DQB5o2uk3eZTIwSNQgUGKoMF451X9VIkgmlzzDTEw+yCoA1eknDJ8HQM/IK0aLhJYABpYBZZpInVA7tksnVvLen2MUIDGwR8MtG1DBnz9LFcip99gZJ0zqCaezrR3tQlGlK8Xhb7Gz3nPMAdB04t89/1O/w1cDnyilFU='; //sesuaikan 
$channelSecret = 'd735bbd21936b39f05224829eaed6f50';//sesuaikan

$client = new LINEBotTiny($channelAccessToken, $channelSecret);

$userId 	= $client->parseEvents()[0]['source']['userId'];
$groupId 	= $client->parseEvents()[0]['source']['groupId'];
$replyToken = $client->parseEvents()[0]['replyToken'];
$timestamp	= $client->parseEvents()[0]['timestamp'];
$type 		= $client->parseEvents()[0]['type'];

$message 	= $client->parseEvents()[0]['message'];
$messageid 	= $client->parseEvents()[0]['message']['id'];

$profil = $client->profil($userId);

$pesan_datang = explode(" ", $message['text']);

$command = $pesan_datang[0];
$options = $pesan_datang[1];
if (count($pesan_datang) > 2) {
    for ($i = 2; $i < count($pesan_datang); $i++) {
        $options .= '+';
        $options .= $pesan_datang[$i];
    }
}

#-------------------------[Function]-------------------------#
function urb_dict($keyword) {
    $uri = "http://api.urbandictionary.com/v0/define?term=" . $keyword;

    $response = Unirest\Request::get("$uri");


    $json = json_decode($response->raw_body, true);
    $result = $json['list'][0]['definition'];
    $result .= "\n\nExamples : \n";
    $result .= $json['list'][0]['example'];
    return $result;
}
#-------------------------[Function]-------------------------#

# require_once('./src/function/search-1.php');
# require_once('./src/function/download.php');
# require_once('./src/function/random.php');
# require_once('./src/function/search-2.php');
# require_once('./src/function/hard.php');

//show menu, saat join dan command /menu
if ($type == 'join' || $command == '/menu') {
    $text = "Kenapa gua diundang ke grup lu? ketik /keyword kalau mau tahu gua berguna gk buat nie grup\n\nKlo lu gk suka ama gua, usir aja gua dari sini, ketik \keluar";
    $balas = array(
        'replyToken' => $replyToken,
        'messages' => array(
            array(
                'type' => 'text',
                'text' => $text
            )
        )
    );
}

//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'def') {


        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => 'Definition : ' . urb_dict($options)
                )
            )
        );
    }
	else
	if($pesan_datang=='1') {
		
		
		$balas = array(
							'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Halo '.$profil->displayName.', Anda memilih menu 1,'
									)
							)
						);
				
	}
	else
	if($pesan_datang=='2')
	{
		$get_sub = array();
		$aa =   array(
						'type' => 'image',									
						'originalContentUrl' => 'https://medantechno.com/line/images/bolt/1000.jpg',
						'previewImageUrl' => 'https://medantechno.com/line/images/bolt/240.jpg'	
						
					);
		array_push($get_sub,$aa);	

		$get_sub[] = array(
									'type' => 'text',									
									'text' => 'Halo '.$profil->displayName.', Anda memilih menu 2, harusnya gambar muncul.'
								);
		
		$balas = array(
					'replyToken' 	=> $replyToken,														
					'messages' 		=> $get_sub
				 );	
	}
	else
	if($pesan_datang=='3')
	{
		
		$balas = array(
							'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Fungsi PHP base64_encode medantechno.com :'. base64_encode("medantechno.com")
									)
							)
						);
				
	}
	else
	if($pesan_datang=='4')
	{
		
		$balas = array(
							'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Jam Server Saya : '. date('Y-m-d H:i:s')
									)
							)
						);
				
	}
	else
	if($pesan_datang=='6')
	{
		
		$balas = array(
							'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'location',					
										'title' => 'Lokasi Saya.. Klik Detail',					
										'address' => 'Medan',					
										'latitude' => '3.521892',					
										'longitude' => '98.623596' 
									)
							)
						);
				
	}
	else
	if($pesan_datang=='7')
	{
		
		$balas = array(
							'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Testing PUSH pesan ke anda'
									)
							)
						);
						
		$push = array(
							'to' => $userId,									
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Pesan ini dari medantechno.com'
									)
							)
						);
						
		
		$client->pushMessage($push);
				
	}

	else{

		$balas = array(
							'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Halo.. Selamat datang di medantechno.com .        Untuk testing menu pilih 1,2,3,4,5 ... atau stiker'
									)
							)
						);
						
	}

}else if($message['type']=='sticker')
{	
	$balas = array(
							'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',									
										'text' => 'Terimakasih stikernya... '										
									
									)
							)
						);
						
}
if (isset($balas)) {
    $result = json_encode($balas);
//$result = ob_get_clean();

    file_put_contents('./balasan.json', $result);


    $client->replyMessage($balas);
}
?>
