<?php

namespace AppBundle\Security;

class Security
{

	/**
	*	Secure inputs before sending to the database
	*
	**/
	public function clean($text)
	{
		
		$text = strip_tags(html_entity_decode($text), '<br><p><strong><em><u>');
		
	    return ($text); //output clean text
	}
}