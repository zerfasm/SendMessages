<?php

require_once __DIR__.'/../libs/traits.php';  // Allgemeine Funktionen

// CLASS ClimateCalculation
class SendMessages extends IPSModule
{
    use ProfileHelper, DebugHelper;

    public function Create()
    {
        //Never delete this line!
        parent::Create();
	    
	// Alarmanlage
	$this->RegisterPropertyBoolean('CheckAlarm', false);
	$this->RegisterPropertyInteger('AlarmID', null); 
	$this->RegisterPropertyInteger('AlarmSensor', null); 
	$this->RegisterPropertyBoolean('CheckAnruf', false);
	$this->RegisterPropertyString('AnrufNr', "");   
	$this->RegisterPropertyInteger('VOIPID', null);      
        
	// Nachricht
	$this->RegisterPropertyString('Title', "");
	$this->RegisterPropertyString('Text', "");
	$this->RegisterPropertyString('Text2', "");
	    
	// Auslöser
	$this->RegisterPropertyInteger('Ausloeser', 0);   
	    
        // Message Alexa
	$this->RegisterPropertyBoolean('CheckAlexa', false);
        $this->RegisterPropertyInteger('AlexaID_1', null);
	$this->RegisterPropertyInteger('AlexaID_2', null);
	$this->RegisterPropertyInteger('AlexaVolume', 40);
	
	// Message Pushover   
        $this->RegisterPropertyBoolean('CheckPushover', false);
	$this->RegisterPropertyInteger('PushoverID', null);
	    
	// Message Telegram    
        $this->RegisterPropertyBoolean('CheckTelegram', false);
	$this->RegisterPropertyInteger('TelegramID', null);
	
	// Message Webfront    
        $this->RegisterPropertyBoolean('CheckPushNotification', false);
	$this->RegisterPropertyInteger('WebfrontID', null);
	    
	// Message Enigma
        $this->RegisterPropertyBoolean('CheckEnigma', false);
	$this->RegisterPropertyInteger('EnigmaID', null);
	
	//Message IPS Logger
        $this->RegisterPropertyBoolean('CheckLogger', false);
	        
	// Update trigger
        $this->RegisterTimer('UpdateTrigger', 0, "MESS_Update(\$_IPS['TARGET']);");
    }

    public function ApplyChanges() 
    {
 	//Never delete this line!
        parent::ApplyChanges();
    }
	
    public function Update()
    {
	$title = $this->ReadPropertyString('Title');
	$text = $this->ReadPropertyString('Text');
	$text2 = $this->ReadPropertyString('Text2');
	
	//Auslöser    
	$ausloeser = $this->ReadPropertyInteger('Ausloeser');
	    
        if ($ausloeser != 0) {
		$ausloeser = GetValue($ausloeser);
		
		//TTS Alexa Echo Remote Modul    
		$tts = $this->ReadPropertyBoolean('CheckAlexa');
		$AID = $this->ReadPropertyInteger('AlexaID');   
		$AV = $this->ReadPropertyInteger('AlexaVolume'); 

		if ($tts == true){
			If (($ausloeser == true) or ($ausloeser == 1)) {
				EchoRemote_SetVolume($AID, $AV);
				EchoRemote_TextToSpeech($AID, $text);
			} else {
				EchoRemote_SetVolume($AID, $AV);
				EchoRemote_TextToSpeech($AID, $text2);
			}
		}
		
		//Pushover
		$push = $this->ReadPropertyBoolean('CheckPushover');
		$PID = $this->ReadPropertyInteger('PushoverID');    
		if ($push == true){
			If (($ausloeser == true) or ($ausloeser == 1)) {
				UBPO_SendPushoverNotification($PID, $title, $text);
			} else {
				UBPO_SendPushoverNotification($PID, $title, $text2);
			}
		}
		
		//Telegram
		$tele = $this->ReadPropertyBoolean('CheckTelegram');
		$TID = $this->ReadPropertyInteger('TelegramID');    
		if ($tele == true){
			If (($ausloeser == true) or ($ausloeser == 1)) {
				Telegram_SendTextToAll($TID, $text);
			} else {
				Telegram_SendTextToAll($TID, $text2);
			}
		}
		
		//Push Notification
		$web = $this->ReadPropertyBoolean('CheckPushNotification');
		$WID = $this->ReadPropertyInteger('WebfrontID');    
		if ($web == true){
			If (($ausloeser == true) or ($ausloeser == 1)) {
				WFC_PushNotification($WID, $title, $text, '', 0);
			} else {
				WFC_PushNotification($WID, $title, $text2, '', 0);
			}
		}
		
		//Enigma
		$enig = $this->ReadPropertyBoolean('CheckEnigma');
		$EID = $this->ReadPropertyInteger('EnigmaID');   
		if ($enig == true){
			If (($ausloeser == true) or ($ausloeser == 1)) {
				Enigma2BY_SendMsg($EID, $text, 1, 5);
			} else {
				Enigma2BY_SendMsg($EID, $text2, 1, 5);
			}
		}
		
		//IPS Logger
		IPSUtils_Include ("IPSLogger.inc.php", "IPSLibrary::app::core::IPSLogger");

		$log = $this->ReadPropertyBoolean('CheckLogger');
		if ($log == true){
			If (($ausloeser == true) or ($ausloeser == 1)) {
				IPSLogger_Not($title, $text);;
			} else {
				IPSLogger_Not($title, $text2);
			}
		}
	} else {
		//TTS Alexa Echo Remote Modul    
		$tts = $this->ReadPropertyBoolean('CheckAlexa');
		$AID_1 = $this->ReadPropertyInteger('AlexaID_1');   
		$AID_2 = $this->ReadPropertyInteger('AlexaID_2');  
		$AV = $this->ReadPropertyInteger('AlexaVolume'); 
		
		if ($tts == true){
			EchoRemote_SetVolume($AID_1, $AV);
			EchoRemote_SetVolume($AID_2, $AV);
			EchoRemote_TextToSpeech($AID_1, $text);
			EchoRemote_TextToSpeech($AID_2, $text);
		}
		
		//Pushover
		$push = $this->ReadPropertyBoolean('CheckPushover');
		$PID = $this->ReadPropertyInteger('PushoverID');    
		
		if ($push == true){
			UBPO_SendPushoverNotification($PID, $title, $text);
		}
		
		//Telegram
		$tele = $this->ReadPropertyBoolean('CheckTelegram');
		$TID = $this->ReadPropertyInteger('TelegramID');    
		
		if ($tele == true){
			Telegram_SendTextToAll($TID, $text);
		}
		
		//Webfront Push Notification
		$web = $this->ReadPropertyBoolean('CheckPushNotification');
		$WID = $this->ReadPropertyInteger('WebfrontID');    
		
		if ($web == true){
			WFC_PushNotification($WID, $title, $text, '', 0);
		}
		
		//Enigma
		$enig = $this->ReadPropertyBoolean('CheckEnigma');
		$EID = $this->ReadPropertyInteger('EnigmaID');    
		
		if ($enig == true){
			Enigma2BY_SendMsg($EID, $text, 1, 5);
		}
			
		//IPS Logger
		IPSUtils_Include ("IPSLogger.inc.php", "IPSLibrary::app::core::IPSLogger");
		
		$log = $this->ReadPropertyBoolean('CheckLogger');
		if ($log == true){
			IPSLogger_Not($title, $text);
		}
	}	
    }
}
