<?php 
// Naslijeđujemo od baznog controllera i automatski vodimo na hotels.
class IndexController extends BaseController
{
	public function index() 
	{
		header( 'Location: ' . __SITE_URL . '/hotels' );
	}
}