<?php
	namespace App\Exceptions;


	class CustomException extends \Exception
	{
    protected $options;
    protected $error;

    public function __construct($msg = null, $error = 500,$options = [])
    { 
      parent::__construct($msg,$error);
      $this->options = $options;
      $this->error = $error;
    }

    public function getOptions(){
      return $this->options;
    }

    public function getStatus(){
      return $this->error;
    }
	}
