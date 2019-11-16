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
        
	// Nachricht
	$this->RegisterPropertyString('Title', "");
	$this->RegisterPropertyString('Text', "");
	    
        // Message Alexa
	$this->RegisterPropertyBoolean('CheckAlexa', false);
        $this->RegisterPropertyString('AlexaID', "");
	$this->RegisterPropertyInteger('AlexaVolume', 40);
	
	// Message Pushover   
        $this->RegisterPropertyBoolean('CheckPushover', false);
	$this->RegisterPropertyString('PushoverID', "");
	    
	// Message Telegram    
        $this->RegisterPropertyBoolean('CheckTelegram', false);
	$this->RegisterPropertyString('TelegramID', "");
	
	// Message Webfront    
        $this->RegisterPropertyBoolean('CheckPushNotification', false);
        $this->RegisterPropertyBoolean('CheckAudioNotification', false);
	
	// Message Enigma
        $this->RegisterPropertyBoolean('CheckEnigma', false);
	$this->RegisterPropertyString('EnigmaID', "");
	
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
	    
	//TTS Alexa Echo Remote Modul    
	$tts = $this->ReadPropertyBoolean('CheckAlexa');
	$AID = $this->ReadPropertyString('AlexaID');   
	$AV = $this->ReadPropertyInteger('AlexaVolume'); 
	
        if ($tts == true){
           	EchoRemote_SetVolume($AID, $AV);
		EchoRemote_TextToSpeech($AID, $text);
	}
	
	//Pushover
	$push = $this->ReadPropertyBoolean('CheckPushover');
	$PID = $this->ReadPropertyString('PushoverID');    
        if ($push == true){
     		UBPO_SendPushoverNotification($PID, $title, $text);
	}
	    
	//Telegram
	$tele = $this->ReadPropertyBoolean('CheckTelegram');
	$TID = $this->ReadPropertyString('TelegramID');    
        if ($tele == true){
     		Telegram_SendTextToAll($TID, $text);
	}
	    
	//IPS Logger
	IPSUtils_Include ("IPSLogger.inc.php", "IPSLibrary::app::core::IPSLogger");
	    
	$log = $this->ReadPropertyBoolean('CheckLogger');
        if ($log == true){
     		IPSLogger_Not($title, $text);
	}
    }
}
