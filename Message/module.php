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
        $this->RegisterPropertyInteger('AlexaID', null);
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
			} elseif (($ausloeser == false) or ($ausloeser == 0)) {
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
			} elseif (($ausloeser == false) or ($ausloeser == 0)) {
				UBPO_SendPushoverNotification($PID, $title, $text2);
			}
		}
		
		//Telegram
		$tele = $this->ReadPropertyBoolean('CheckTelegram');
		$TID = $this->ReadPropertyInteger('TelegramID');    
		if ($tele == true){
			If (($ausloeser == true) or ($ausloeser == 1)) {
				Telegram_SendTextToAll($TID, $text);
			} elseif (($ausloeser == false) or ($ausloeser == 0)) {
				Telegram_SendTextToAll($TID, $text2);
			}
		}
		
		//Push Notification
		$web = $this->ReadPropertyBoolean('CheckPushNotification');
		$WID = $this->ReadPropertyInteger('WebfrontID');    
		if ($web == true){
			If (($ausloeser == true) or ($ausloeser == 1)) {
				WFC_PushNotification($WID, $title, $text, '', 0);
			} elseif (($ausloeser == false) or ($ausloeser == 0)) {
				WFC_PushNotification($WID, $title, $text2, '', 0);
			}
		}
		
	} else {
		//TTS Alexa Echo Remote Modul    
		$tts = $this->ReadPropertyBoolean('CheckAlexa');
		$AID = $this->ReadPropertyInteger('AlexaID');   
		$AV = $this->ReadPropertyInteger('AlexaVolume'); 
		
		if ($tts == true){
			EchoRemote_SetVolume($AID, $AV);
			EchoRemote_TextToSpeech($AID, $text);
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
		
	}	
    }
}
