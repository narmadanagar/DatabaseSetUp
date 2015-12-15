<?php
//&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&
//
// file is for custom functions that you dont know where else to put
// 

// The idea here is to look for sql injection techniques and replace them with
// a character which will cause the sql statement to simply fail
function sanitize($string, $spacesAllowed = true, $semiColonAllowed = true) {
    $replaceValue = "Q";

    if (!$semiColonAllowed) {
        $string = str_replace(';', $replaceValue, $string);
    }
    
    if (!$spacesAllowed) {
        $string = str_replace(' ', $replaceValue, $string);
    }
    $string = htmlentities($string, ENT_QUOTES);

    $string = str_replace('%20', $replaceValue, $string);

    return $string;
}

function verifyAlphaNum ($testString) {
	// Check for letters, numbers and dash, period, space and single quote only. 
	return (preg_match ("/^([[:alnum:]]|-|\.| |')+$/", $testString));
}	

function verifyEmail ($testString) {
	// Check for a valid email address http://www.php.net/manual/en/filter.examples.validation.php
	return filter_var($testString, FILTER_VALIDATE_EMAIL);
}

function verifyNumeric ($testString) {
	// Check for numbers and period. 
	return (is_numeric ($testString));
}

function verifyPhone ($testString) {
	// Check for usa phone number http://www.php.net/manual/en/function.preg-match.php
        $regex = '/^(?:1(?:[. -])?)?(?:\((?=\d{3}\)))?([2-9]\d{2})(?:(?<=\(\d{3})\))? ?(?:(?<=\d{3})[.-])?([2-9]\d{2})[. -]?(\d{4})(?: (?i:ext)\.? ?(\d{1,5}))?$/';

	return (preg_match($regex, $testString));
}
