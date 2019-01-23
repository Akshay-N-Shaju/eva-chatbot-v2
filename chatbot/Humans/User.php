<?php
/*Developed By : Akshay N Shaju
Developed On : 14/03/18
Last Updated : --*/
require_once "Human.php";

class User extends Human
{
	public function __construct($chatbot, $unique)
    {	
        parent::__construct($chatbot, $unique, "user");
    }
}