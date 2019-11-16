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

        // Outdoor variables
        $this->RegisterPropertyInteger('TempOutdoor', 0);
        $this->RegisterPropertyInteger('HumyOutdoor', 0);
        $this->RegisterPropertyInteger('DewPointOutdoor', 0);
        $this->RegisterPropertyInteger('WaterContentOutdoor', 0);
        
        // Indoor variables
        $this->RegisterPropertyInteger('TempIndoor', 0);
        $this->RegisterPropertyInteger('HumyIndoor', 0);
        $this->RegisterPropertyFloat('TempDiffWallIndoor', 0);
        
         // Window variables
        $this->RegisterPropertyInteger('WindowValue', 0);
        $this->RegisterPropertyBoolean('CreateAir', false);
        $this->RegisterPropertyInteger('DiffLimit', 5);
        $this->RegisterPropertyBoolean('TTSAlexa', false);
        $this->RegisterPropertyString('AlexaID', "");
	$this->RegisterPropertyInteger('AlexaVolume', 40);
        $this->RegisterPropertyString('NameRoom', "");
        
        // Settings
        $this->RegisterPropertyInteger('UpdateTimer', 5);
        $this->RegisterPropertyBoolean('CreateDewPoint', false);
        $this->RegisterPropertyBoolean('CreateWaterContent', false);
        $this->RegisterPropertyBoolean('CreateTF70', false);
        $this->RegisterPropertyBoolean('CreateTF80', false);
        $this->RegisterPropertyBoolean('CreateAWValue', false);
        $this->RegisterPropertyBoolean('CreateMould', false);
        
        // Message
        $this->RegisterPropertyBoolean('CheckPushover', false);
        $this->RegisterPropertyBoolean('CheckTelegram', false);
        $this->RegisterPropertyBoolean('CheckAlexa', false);
        $this->RegisterPropertyBoolean('CheckPushNotification', false);
        $this->RegisterPropertyBoolean('CheckAudioNotification', false);
        $this->RegisterPropertyBoolean('CheckEnigma', false);
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
