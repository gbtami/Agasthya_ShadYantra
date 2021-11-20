<?php

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
$fen ="";
$blackplayerassigned=false;
$blackplayer=0;
$playertype=1;

$systemgameid=null;
$filewhitecookie=""; $fileblackcookie="";
$filewhitegamecookie=""; $fileblackgamecookie="";
$whitegamecookie=""; $blackamecookie="";
$newmove=0;
$currentmover="";

error_reporting(E_ALL);
ini_set('display_errors', 1);

//check fake cookie with file name and file 1st line data. Else set as null
if(isset($_COOKIE['gameid'])){
	$unknowngamecookie=htmlspecialchars($_COOKIE['gameid']);
	$splitted = explode( '$gameid=',$unknowngamecookie);
	$gameid = $splitted[1];
	$onlygameid =  explode( ';',$gameid)[0];
	$systemgameid= $onlygameid.';';	

	if(file_exists($systemgameid)==false){
		$_COOKIE['gameid']="";
		unset($_COOKIE['gameid']); 
    	setcookie('gameid', "", 1, '/');
		}
}

if ( isset($_REQUEST['BlackGameID']) /*&&(!isset($_COOKIE['gameid']))*/) {
	$systemgameid=$_REQUEST['BlackGameID']; //if blank
	if(($systemgameid!=null) &&($systemgameid!="") &&(file_exists($systemgameid))){
		//consider the white and black moves
				$file = fopen($systemgameid,"r");
				$matched=0;
				while(!feof($file) && $matched<2) {
					$line = rtrim(fgets($file),"\r\n");

					if (strpos($line, '$newfen=') !== false) {
						$gametype="new";
						$newmove=1;
						}
					else if (strpos($line, '$blackplayer=0') !== false) {
							$blackplayer=1;
							}
					else if (strpos($line, '$blackplayer=1') !== false) {
								$blackplayer=-1;
							}

					else if (strpos($line, '$currentfen=') !== false) {
						$splitted = explode( '$currentfen=',$line);
						$fen = $splitted[1];
							$matched=$matched+1; 
							$gametype="old";
							$currentmover=explode(' ', explode( ' ',$line)[1])[0];
					}
					else if (strpos($line, '$gameid=') !== false) {
						$whiteblackcookie="";
						$blackplayerassigned=true;
						$playertype=2;
							$splitted = explode( '$gameid=',$line);
							$fullgameid = '$gameid='.$splitted[1];
							//$onlygameid =  explode( '$gameid=',$fullgameid)[0];
							$whiteblackcookie='whitemover='.explode( ';whitemover=',$fullgameid)[1];
							$blackcookie='blackmover='.explode( ';blackmover=',$fullgameid)[1];
							$blackgameid='$gameid='.$systemgameid.$blackcookie;

					$fileblackgamecookie=$blackgameid;
					}

					if (strpos($line, '_Move=') !== false) {
						$splittedfen_notation = explode( '=',$line);
						$oldfennotation = $splittedfen_notation[1]; 
						$matchedfen =  explode( ';',$oldfennotation)[0];
						//if (strpos($matchedfen.PHP_EOL, $fen) !== false){
							//$fen=$matchedfen;
							$matched=$matched+1;
						//}
					}
				}

				$whiteblackcookie="";
				$blackplayerassigned=true;
				$playertype=2;
				if(($blackplayer==-1)|| ($blackplayer==0)) {
					$playertype=100;
					$_COOKIE['gameid']='$gameid='.$systemgameid;
					setcookie('gameid', '$gameid='.$systemgameid);
					setcookie('LiveStepType', 'none');
					$_COOKIE['LiveStepType']='none';					  
					}
				else{
					$_COOKIE['gameid']=$blackgameid;
					setcookie('gameid', $blackgameid);

					$_COOKIE['gameid']=$blackgameid;
					setcookie('gameid', $blackgameid);							
					setcookie('LiveStepType', 'black');
					$_COOKIE['LiveStepType']='black';
				}

				fclose($file);

				if(strpos($whiteblackcookie,'whitemover')!== false)
				{
				}
				else if(strpos($whiteblackcookie,'blackmover')!== false)
				{
					$playertype=2;
					//set cookies
				}
				else if($playertype!=100)
				{
					$playertype=2;
				}
	}
	else {
		die("No such game exists. Reviwing the game;");
	}
}
else if((isset($_COOKIE['gameid'])) &&((isset($_REQUEST['lookformoves']))&&(($_REQUEST['lookformoves']!=null) &&($_REQUEST['lookformoves']!="" ))))
	{
		$result="";
		$unknowngamecookie=htmlspecialchars($_COOKIE['gameid']);
			$splitted = explode( '$gameid=',$unknowngamecookie);
			$gameid = $splitted[1];
			$onlygameid =  explode( ';',$gameid)[0];
			$systemgameid= $onlygameid.';';	
			$systemcookie=$unknowngamecookie;
			$whiteblackcookie=explode( ';',$gameid)[1];//'$gameid='.$onlygameid.';whitemover='.$filewhitecookie.';';
		if(file_exists($systemgameid)){
			$data = file($systemgameid); // reads an array of lines
			$reading = fopen($systemgameid, 'r');
			//$writing = fopen($systemgameid.'.tmp.txt', 'w');
			$replaced = false;	$importedmatched=false;
			$newmove=0;	$matched=0;
			$canmove = 0;
			if(strpos($whiteblackcookie,'whitemover')!== false)
			///check if user already had some pending game // play invitation game if no pending game
			{
				while (!feof($reading)) {
					$line = rtrim(fgets($reading),"\r\n");
					if(($matched==1)	&&(stristr($line,'$currentfen='))){
						$line = '$currentfen='.explode(';', explode( '$currentfen=',$line)[1])[0];
						}
					else if ((stristr($line,'$currentfen='))) {
						$replaced = true; $importedmatched=true;
						$fen=explode(';', explode( '$currentfen=',$line)[1])[0];
						$currentmover=explode(' ', explode( ' ',$line)[1])[0];
						}
					//fputs($writing, $line.PHP_EOL);
					else if (strpos($line, '$gameid=') !== false) {
						$splitted = explode( '$gameid=',$line);
					}
					else if (strpos($line, '_Move=') !== false) {
						$canmove = $canmove+1;
					}
				}
			}
			else if(strpos($whiteblackcookie,'blackmover')!== false)
			///check if user already had some pending game // play invitation game if no pending game
			{
					while (!feof($reading)) {
						$line = rtrim(fgets($reading),"\r\n");
						if(($matched==1)	&&(stristr($line,'$currentfen='))){
							$line = '$currentfen='.explode(';', explode( '$currentfen=',$line)[1])[0];
							}
						else if ((stristr($line,'$currentfen='))) {
							$fen=explode(';', explode( '$currentfen=',$line)[1])[0];
							$currentmover=explode(' ', explode( ' ',$line)[1])[0];
						}
						 // fputs($writing, $line.PHP_EOL);
	
						if (strpos($line, '$gameid=') !== false) {
						}
						else if (strpos($line, '_Move=') !== false) {
							$canmove = $canmove+1;
						}	
					}
			}
			else{
				$result= "Watch";
				$result= "100";
			}
			fclose($reading);
			}

			if($canmove==0)
				$result= "0";

			else if( ((($currentmover=='b0') || ($currentmover=='w1')|| ($currentmover=='b2'))))
			{
				$result= "Black To Move";
				$result= "2";

			}
			else if(
			((($currentmover=='w0') || ($currentmover=='b1')|| ($currentmover=='w2')))){
				$result= "White To Move";
				$result= "1";
			}
			echo $result;
			if($result!= "100")
				return $result;
	}
else if (!isset($_COOKIE['gameid'])) ///check if user already had some pending game // play invitation game if no pending game
	{
			$whitegamer=substr(str_shuffle("aAbBcCdDeEfFgGhHiIjJkLmMnNpPqQrRtTuUvVwWxXyYzZ12346789"), 0, 5).substr(md5(time()),1).";";
			$blackgamer=substr(str_shuffle("aAbBcCdDeEfFgGhHiIjJkLmMnNpPqQrRtTuUvVwWxXyYzZ12346789"), 0, 5).substr(md5(time()),1).";";
			$systemgameid='livemove'.str_shuffle("acdefhijkmnprtuvwxyz0123456789").";";

			$systemcookie='$gameid='.$systemgameid . "whitemover=".$whitegamer . "blackmover=".$blackgamer;
			$whitegamecookie='$gameid='.$systemgameid."whitemover=".$whitegamer;
			$blackgamecookie='$gameid='.$systemgameid."blackmover=".$blackgamer;
			setcookie('gameid', $whitegamecookie);
  			$_COOKIE['gameid']= $whitegamecookie;
			setcookie('LiveStepType', 'white');
			$_COOKIE['LiveStepType']='white';
			/*echo $systemgameid;
			echo $whitegamer;
			echo $whitegamecookie;*/

			//if file does not exist create....else check if file exists but no cookies matched then set it to black.
			$file = fopen($systemgameid,"w");
			fwrite($file,$systemcookie.PHP_EOL);
			$fen="1c2ai2c1/cmhgsnghmc/cppppppppc/181/181/181/181/CPPPPPPPPC/CMHGNSGHMC/1C2IA2C1 w0 () - 0 1";
			$currentmover='w0';

			fwrite($file,'$newfen='.$fen.PHP_EOL);
			fwrite($file,'$blackplayer=0;'.PHP_EOL);
			fclose($file);
			$newmove=1;
	}
	else if((isset($_COOKIE['gameid'])) &&((isset($_REQUEST['lookformoves']))&&(($_REQUEST['lookformoves']!=null) &&($_REQUEST['lookformoves']!="" ))))
	{
		$unknowngamecookie=htmlspecialchars($_COOKIE['gameid']);
			$splitted = explode( '$gameid=',$unknowngamecookie);
			$gameid = $splitted[1];
			$onlygameid =  explode( ';',$gameid)[0];
			$systemgameid= $onlygameid.';';	
			$systemcookie=$unknowngamecookie;
			$whiteblackcookie=explode( ';',$gameid)[1];//'$gameid='.$onlygameid.';whitemover='.$filewhitecookie.';';
		if(file_exists($systemgameid)){
			$data = file($systemgameid); // reads an array of lines
			$reading = fopen($systemgameid, 'r');
			//$writing = fopen($systemgameid.'.tmp.txt', 'w');
			$replaced = false;	$importedmatched=false;
			$newmove=0;	$matched=0;
	
			if(strpos($whiteblackcookie,'whitemover')!== false)
			///check if user already had some pending game // play invitation game if no pending game
			{
				while (!feof($reading)) {
					$line = rtrim(fgets($reading),"\r\n");
					if(($matched==1)	&&(stristr($line,'$currentfen='))){
						$line = '$currentfen='.explode(';', explode( '$currentfen=',$line)[1])[0];
						}
					else if ((stristr($line,'$currentfen='))) {
						$replaced = true; $importedmatched=true;
						$fen=explode(';', explode( '$currentfen=',$line)[1])[0];
						$currentmover=explode(' ', explode( ' ',$line)[1])[0];
						}
					//fputs($writing, $line.PHP_EOL);
					else if (strpos($line, '$gameid=') !== false) {
						$splitted = explode( '$gameid=',$line);
					}
				}
			}
			else if(strpos($whiteblackcookie,'blackmover')!== false)
			///check if user already had some pending game // play invitation game if no pending game
			{
					while (!feof($reading)) {
						$line = rtrim(fgets($reading),"\r\n");
						if(($matched==1)	&&(stristr($line,'$currentfen='))){
							$line = '$currentfen='.explode(';', explode( '$currentfen=',$line)[1])[0];
							}
						else if ((stristr($line,'$currentfen='))) {
							$fen=explode(';', explode( '$currentfen=',$line)[1])[0];
							$currentmover=explode(' ', explode( ' ',$line)[1])[0];
						}
						 // fputs($writing, $line.PHP_EOL);
	
						if (strpos($line, '$gameid=') !== false) {
						}
					}
			}
			fclose($reading);
			}
			$result="";
			if( ((($currentmover=='b0') || ($currentmover=='w1')|| ($currentmover=='b2'))))
			{
				$result= "Black To Move";
				$result= "2";

			}
			else if(
			((($currentmover=='w0') || ($currentmover=='b1')|| ($currentmover=='w2')))){
				$result= "White To Move";
				$result= "1";
			}
			echo $result;
			return $result;
	}
else if((isset($_COOKIE['gameid'])) &&((!isset($_REQUEST['livemove']))||(($_REQUEST['livemove']==null) ||($_REQUEST['livemove']=="" ))))
	{
	$unknowngamecookie=htmlspecialchars($_COOKIE['gameid']);
	//fetch the latest current move.
	//echo "else if ".$_COOKIE['gameid'];
		$splitted = explode( '$gameid=',$unknowngamecookie);
		$gameid = $splitted[1];
		$onlygameid =  explode( ';',$gameid)[0];
		$systemgameid= $onlygameid.';';
/*

$splitted = explode( '$gameid=',$unknowngamecookie);
$gameid = $splitted[1];
$onlygameid =  explode( ';',$gameid)[0];
$systemgameid= $onlygameid.';';	
$systemcookie=$unknowngamecookie;
$whiteblackcookie=explode( ';',$gameid)[1];//'$gameid='.$onlygameid.';whitemover='.$filewhitecookie.';';

*/


		$systemcookie=$unknowngamecookie;		
		$whiteblackcookie=explode( ';',$gameid)[1];//'$gameid='.$onlygameid.';whitemover='.$filewhitecookie.';';
		if(file_exists($systemgameid)){
		$data = file($systemgameid); // reads an array of lines
		$reading = fopen($systemgameid, 'r');
		//$writing = fopen($systemgameid.'.tmp.txt', 'w');
		$replaced = false;	$importedmatched=false;
		$newmove=0;	$matched=0;

		if(strpos($whiteblackcookie,'whitemover')!== false)
		///check if user already had some pending game // play invitation game if no pending game
		{
			$playertype=1;
			$whitegamecookie=$systemcookie;
			setcookie('gameid', $whitegamecookie);
  			$_COOKIE['gameid']= $whitegamecookie;
			setcookie('LiveStepType', 'white');
			$_COOKIE['LiveStepType']='white';

			while (!feof($reading)) {
				$line = rtrim(fgets($reading),"\r\n");
				if(($matched==1)	&&(stristr($line,'$currentfen='))){
					$line = '$currentfen='.explode(';', explode( '$currentfen=',$line)[1])[0];
					}
				else if ((stristr($line,'$currentfen='))) {
					$replaced = true; $importedmatched=true;
					$fen=explode(';', explode( '$currentfen=',$line)[1])[0];
					$currentmover=explode(' ', explode( ' ',$line)[1])[0];
					}
				//fputs($writing, $line.PHP_EOL);
				else if (strpos($line, '$gameid=') !== false) {
					$splitted = explode( '$gameid=',$line);
					$fullgameid = '$gameid='.$splitted[1];
					//$onlygameid =  explode( '$gameid=',$fullgameid)[0];
					$whiteblackcookie='whitemover='.explode( ';whitemover=',$fullgameid)[1];
					$blackcookie='blackmover='.explode( ';blackmover=',$fullgameid)[1];
					$whitecookie='whitemover='.explode( ';whitemover=',explode( ';blackmover=',$fullgameid)[0])[1];

					$whitegameid='$gameid='.$systemgameid.$whitecookie;
					$_COOKIE['gameid']=$whitegameid;
					$whiteplayerassigned=true;
					$playertype=1;
					$fileblackgamecookie=$whitegameid;
				}				  
			}

			if((isset($_COOKIE['LiveStepType'])==true) &&($_COOKIE['LiveStepType']!="")&&
			(($_COOKIE['LiveStepType']=="white"))) {
			//check with file cookie and if good then show the current fen
			}else {

			}
		}
		else if(strpos($whiteblackcookie,'blackmover')!== false)
		///check if user already had some pending game // play invitation game if no pending game
		{
			$playertype=2;
			$blackgamecookie=$systemcookie;
			setcookie('gameid', $blackgamecookie);
  			$_COOKIE['gameid']= $blackgamecookie;
			setcookie('LiveStepType', 'black');
			$_COOKIE['LiveStepType']='black';

				while (!feof($reading)) {
					$line = rtrim(fgets($reading),"\r\n");
					if(($matched==1)	&&(stristr($line,'$currentfen='))){
						$line = '$currentfen='.explode(';', explode( '$currentfen=',$line)[1])[0];
						}
					else if ((stristr($line,'$currentfen='))) {
						$fen=explode(';', explode( '$currentfen=',$line)[1])[0];
						$currentmover=explode(' ', explode( ' ',$line)[1])[0];
					}
					 // fputs($writing, $line.PHP_EOL);

					if (strpos($line, '$gameid=') !== false) {
						$splitted = explode( '$gameid=',$line);
						$fullgameid = '$gameid='.$splitted[1];
						//$onlygameid =  explode( '$gameid=',$fullgameid)[0];
						$whiteblackcookie='whitemover='.explode( ';whitemover=',$fullgameid)[1];
						$blackcookie='blackmover='.explode( ';blackmover=',$fullgameid)[1];
						$whitecookie='whitemover='.explode( ';whitemover=',explode( ';blackmover=',$fullgameid)[0])[1];
	
						$blackgameid='$gameid='.$systemgameid.$blackcookie;
						$_COOKIE['gameid']=$blackgameid;
						$blackplayerassigned=true;
						$playertype=2;
						$fileblackgamecookie=$blackgameid;
					}
				}

			if((isset($_COOKIE['LiveStepType'])==true) &&($_COOKIE['LiveStepType']!="")&&
			(($_COOKIE['LiveStepType']=="black"))) {
				if(strpos($blackgamecookie,$fileblackgamecookie)!== false)
				{
				}
			}
			else {

			}
		}
		else
		///check if user already had some pending game // play invitation game if no pending game
		{
			$playertype=2;
		}
		fclose($reading);
		}
		else {
			//do not move board;
		}
	}
//Move was actually placed. Check if genuine move s per the file
else if((isset($_COOKIE['gameid'])) &&(isset($_REQUEST['livemove']))&&(($_REQUEST['livemove']!=null)&&($_REQUEST['livemove']!="" )))
	{
	$newmove=0;

	$unknowngamecookie=htmlspecialchars($_COOKIE['gameid']);
	//fetch the latest current move.
	//echo "else if ".$_COOKIE['gameid'];
	//check the file for that id
		$splitted = explode( '$gameid=',$unknowngamecookie);
		$gameid = $splitted[1];
		$onlygameid =  explode( ';',$gameid)[0];
		$systemgameid= $onlygameid.';';

		$systemcookie=$unknowngamecookie;
		
		$whiteblackcookie=explode( ';',$gameid)[1];//'$gameid='.$onlygameid.';whitemover='.$filewhitecookie.';';
		if(file_exists($systemgameid)){
		$data = file($systemgameid); // reads an array of lines
		$reading = fopen($systemgameid, 'r');
		//$writing = fopen($systemgameid.'.tmp.txt', 'w');
		$replaced = false;	$importedmatched=false;

		if(strpos($whiteblackcookie,'whitemover')!== false)
		///check if user already had some pending game // play invitation game if no pending game
		{
			$playertype=1;
			$whitegamecookie=$systemcookie;
			setcookie('gameid', $whitegamecookie);
  			$_COOKIE['gameid']= $whitegamecookie;
			setcookie('LiveStepType', 'white');
			$_COOKIE['LiveStepType']='white';
			$matched=0;

			while (!feof($reading)) {
				$line = rtrim(fgets($reading),"\r\n");
				if(($matched==1)	&&(stristr($line,'$currentfen='))){
					$line = '$currentfen='.explode(';', explode( '$currentfen=',$line)[1])[0];
					$replaced=true;$importedmatched=true;}
				else if ((stristr($line,'$currentfen='))) {
					$replaced = true; $importedmatched=true;
					$fen=explode(';', explode( '$currentfen=',$line)[1])[0];
					$currentmover=explode(' ', explode( ' ',$line)[1])[0];
				}
				  //fputs($writing, $line.PHP_EOL);
				  if($importedmatched==true){
					//$line = rtrim(fgets($reading),"\r\n");
					if (stristr($line,$_REQUEST['livemove'])) 
						$newmove=1;
					}
				  else if (strpos($line, '$gameid=') !== false) {
					$splitted = explode( '$gameid=',$line);
					$fullgameid = '$gameid='.$splitted[1];
					//$onlygameid =  explode( '$gameid=',$fullgameid)[0];
					$whiteblackcookie='whitemover='.explode( ';whitemover=',$fullgameid)[1];
					$blackcookie='blackmover='.explode( ';blackmover=',$fullgameid)[1];
					$whitecookie='whitemover='.explode( ';whitemover=',explode( ';blackmover=',$fullgameid)[0])[1];

					$whitegameid='$gameid='.$systemgameid.$whitecookie;
					$_COOKIE['gameid']=$whitegameid;
					$whiteplayerassigned=true;
					$playertype=1;

				$fileblackgamecookie=$whitegameid;
				}
			}

			if((isset($_COOKIE['LiveStepType'])==true) &&($_COOKIE['LiveStepType']!="")&&
			(($_COOKIE['LiveStepType']=="white"))) {
			//check with file cookie and if good then show the current fen
				if($newmove==1){$fen=$_REQUEST['livemove'];}
			}else {

			}
		}
		else if(strpos($whiteblackcookie,'blackmover')!== false)
		///check if user already had some pending game // play invitation game if no pending game
		{
			//$filewhitecookie=explode(';', explode( ';whitemover=',$gameid)[1])[0];
			//$fileblackcookie=explode(';',explode(';blackmover=', $gameid)[1])[0];
			//$filewhitegamecookie='$gameid='.$onlygameid.';whitemover='.$filewhitecookie.';';
			//$fileblackgamecookie='$gameid='.$onlygameid.';blackmover='.$fileblackcookie.';';
			$playertype=2;
			$blackgamecookie=$systemcookie;
			setcookie('gameid', $blackgamecookie);
  			$_COOKIE['gameid']= $blackgamecookie;
			setcookie('LiveStepType', 'black');
			$_COOKIE['LiveStepType']='black';
			$matched=0;

				while (!feof($reading)) {
					$line = rtrim(fgets($reading),"\r\n");
					if(($matched==1)	&&(stristr($line,'$currentfen='))){
						$line = '$currentfen='.explode(';', explode( '$currentfen=',$line)[1])[0];
						$replaced=true;$importedmatched=true;}
					else if ((stristr($line,'$currentfen='))) {
						$replaced = true; $importedmatched=true;
						$fen=explode(';', explode( '$currentfen=',$line)[1])[0];
						$currentmover=explode(' ', explode( ' ',$line)[1])[0];
					}
					  //fputs($writing, $line.PHP_EOL);

					  if($importedmatched==true){
						//$line = rtrim(fgets($reading),"\r\n");
						if (stristr($line,$_REQUEST['livemove'])) 
							$newmove=1;
						}
					else if (strpos($line, '$gameid=') !== false) {
						$splitted = explode( '$gameid=',$line);
						$fullgameid = '$gameid='.$splitted[1];
						//$onlygameid =  explode( '$gameid=',$fullgameid)[0];
						$whiteblackcookie='whitemover='.explode( ';whitemover=',$fullgameid)[1];
						$blackcookie='blackmover='.explode( ';blackmover=',$fullgameid)[1];
						$whitecookie='whitemover='.explode( ';whitemover=',explode( ';blackmover=',$fullgameid)[0])[1];
	
						$blackgameid='$gameid='.$systemgameid.$blackcookie;
						$_COOKIE['gameid']=$blackgameid;
						$blackplayerassigned=true;
						$playertype=2;

					$fileblackgamecookie=$blackgameid;
					}
				}

			if((isset($_COOKIE['LiveStepType'])==true) &&($_COOKIE['LiveStepType']!="")&&
			(($_COOKIE['LiveStepType']=="black"))) {
				if(strpos($blackgamecookie,$fileblackgamecookie)!== false)
				{
					if($newmove==1){$fen=$_REQUEST['livemove'];}
				}
			}
			else {

			}
		}
		else
		///check if user already had some pending game // play invitation game if no pending game
		{
			//$filewhitecookie=explode(';', explode( ';whitemover=',$gameid)[1])[0];
			//$fileblackcookie=explode(';',explode(';blackmover=', $gameid)[1])[0];
			//$filewhitegamecookie='$gameid='.$onlygameid.';whitemover='.$filewhitecookie.';';
			//$fileblackgamecookie='$gameid='.$onlygameid.';blackmover='.$fileblackcookie.';';
			$playertype=2;
		}
		fclose($reading);
	}
	else
	{
		//do not move the board
	}
}
require_once('../helpers/helper_functions.php');
require_once('../models/ChessRulebook.php');
require_once('../models/ChessBoard.php');
require_once('../models/ChessPiece.php');
require_once('../models/ChessMove.php');
require_once('../models/ChessSquare.php');

$board = new ChessBoard	();
if( ($playertype==100) || ((($currentmover=='b0') || ($currentmover=='w1')|| ($currentmover=='b2')) && ($playertype==1)) ||
((($currentmover=='w0') || ($currentmover=='b1')|| ($currentmover=='w2')) && ($playertype==2))){
	$board->moveable=false;
	$newmove=0;
}
foreach($_GET as $key => $value){
	//echo $key . " : " . $value . "<br />\r\n";
  };
if ( isset($_REQUEST['reset']) ) {
	// Skip this conditional. ChessGame's FEN is the default, new game FEN and doesn't need to be set again.
	rename($systemgameid, $systemgameid.'_'.date('mdyhisA').'.txt');
} elseif ( isset($_REQUEST['livemove']) ) {
	if($playertype==2)
		$board->setboard('black');
	if(($playertype==1) || ($playertype==100))
		$board->setboard('white');
	$board->import_live_fen($_REQUEST['livemove'],$systemgameid,$playertype,$newmove);
	if(isset($_REQUEST['import_boardtype']))
	$board->setboard($_REQUEST['import_boardtype']);

	$legal_moves=null;
	if(($board->moveable==true)){
		$controlled_color=$board->controlled_color;
		$controller_color=$board->controller_color;
		$legal_moves = ChessRulebook::get_legal_moves_list($board->color_to_move, $board);
		//$fen = $board->export_live_fen("1",$legal_moves);
		$board->controlled_color=$controlled_color;
		$board->controller_color=$controller_color;
			if($fen =="")  $fen= $board->export_fen();
		}
		
		if((file_exists($systemgameid))&&($legal_moves!=null)){
			{
			$data = file($systemgameid);// reads an array of lines
		
			$reading = fopen($systemgameid, 'r');
			$writing = fopen($systemgameid.'.tmp.txt', 'w');
		
			$replaced = false;
			$importedmatched=false;
			while (!feof($reading)&&($importedmatched==false)) {
				$line = rtrim(fgets($reading),"\r\n");
				if ((stristr($line,'$currentfen='))) {
					$line = '$currentfen='.$fen;
					$replaced = true;
					$importedmatched=true;
				}
				fputs($writing, $line.PHP_EOL);
			}

			$movecount=0;
			foreach ( $legal_moves as $key => $move ): 
				$notationvalue=""; $ending_square=$move->ending_square; $movecount=$movecount+1;

				if($move->pushedending_square!=null)
					$ending_square=$move->pushedending_square;
				$move_FEN= $move->board->export_fen_moves($move->starting_square,$move->ending_square); 
				$move->ending_square=$ending_square;
				$notationvalue=$move->get_notation();							
				if($newmove==1)
					fputs($writing, $movecount.'_Move='.$move_FEN.';'.$movecount.'_Notation='.$notationvalue.PHP_EOL); 
			endforeach;

			fclose($reading);fclose($writing);
			chmod($systemgameid.".tmp.txt", 0755);

			// might as well not overwrite the file if we didn't replace anything
			if ($replaced)
				{
				rename($systemgameid.'.tmp.txt', $systemgameid);
				}else {
				unlink($systemgameid.'.tmp.txt');
				}
			}
		}
	$legal_moves=null;
	$board->moveable=false;

} elseif ( isset($_REQUEST['surrendermove']) ) {
	$board->import_fen($_REQUEST['surrendermove']);
	if(isset($_REQUEST['import_boardtype']))
	$board->setboard($_REQUEST['import_boardtype']);
	$board->moveable=false;
} elseif ( isset($_REQUEST['endgamemove']) ) {
	$board->import_fen($_REQUEST['endgamemove']);
	if(isset($_REQUEST['import_boardtype']))
	$board->setboard($_REQUEST['import_boardtype']);
} elseif ( isset($_REQUEST['fen']) ) {
	$board->import_fen($_REQUEST['fen']);
	if(isset($_REQUEST['import_boardtype']))
	$board->setboard($_REQUEST['import_boardtype']);
} elseif  ( isset($_REQUEST['BlackGameID']) && ($systemgameid!=null)&&($systemgameid!="")) {
	//playertype
	$board->setboard('black');
	$board->import_live_fen($fen,$systemgameid,2,$newmove );
	if(isset($_REQUEST['import_boardtype']))
		$board->setboard($_REQUEST['import_boardtype']);	
}
else {
	if($playertype==2)
		$board->setboard('black');
	if(($playertype==1) || ($playertype==100))
		$board->setboard('white');
	$board->import_live_fen($fen,$systemgameid,$playertype ,$newmove);
	if(isset($_REQUEST['import_boardtype']))
	$board->setboard($_REQUEST['import_boardtype']);	
}

$legal_moves=null;
if(($board->moveable==true)){
	$controlled_color=$board->controlled_color;
	$controller_color=$board->controller_color;
	$legal_moves = ChessRulebook::get_legal_moves_list($board->color_to_move, $board);
	//$fen = $board->export_live_fen("1",$legal_moves);
	$board->controlled_color=$controlled_color;
	$board->controller_color=$controller_color;
		if($fen =="")  $fen= $board->export_fen();
	}
$side_to_move = $board->get_side_to_move_string();
$who_is_winning = $board->get_who_is_winning_string();
$graphical_board_array = $board->get_graphical_board();

define('VIEWER', true);
require_once('../liveviews/index.php');
