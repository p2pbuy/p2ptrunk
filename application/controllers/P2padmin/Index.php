<?php
class P2padmin_IndexController extends P2padmin_AbstractController{
	public function hookAction(){
		echo 'I am p2padmin';
		return true;
	}
}