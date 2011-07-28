<?php

function isLoggedIn(){
    if(isset($_SESSION['valid']) && $_SESSION['valid'])
        return true;
    return false;
}

function startSession(){
	session_start();
	//if the user has not logged in
	if(!isLoggedIn())return false;
	else return true;
}

