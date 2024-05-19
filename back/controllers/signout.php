<?php
class Signout extends CI_Controller
{
    function index()
    {
		session_start();
		session_destroy();
		header("Location:".ROOT_DIR );
	}
}