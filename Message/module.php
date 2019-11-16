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
	    
        $this->RegisterPropertyBoolean('CheckLogger', false);
    }

    public function ApplyChanges()
    {
        //Never delete this line!
        parent::ApplyChanges();

    }

    /**
     * This function will be available automatically after the module is imported with the module control.
     * Using the custom prefix this function will be callable from PHP and JSON-RPC through:.
     *
     * MESS_Update($id);
     */
    public function Update()
    {
       
      }

    /**
     * This function will be available automatically after the module is imported with the module control.
     * Using the custom prefix this function will be callable from PHP and JSON-RPC through:.
     *
     * MESS_Duration($id, $duration);
     *
     * @param int $duration Wartezeit einstellen.
     */
    public function Duration(int $duration)
    {
        IPS_SetProperty($this->InstanceID, 'UpdateTimer', $duration);
        IPS_ApplyChanges($this->InstanceID);
    }
}
