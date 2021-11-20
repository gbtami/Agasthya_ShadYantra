<?php

if (! defined('VIEWER')) {
    die("This file needs to be included into a viewer.");
}
$gamemode="livemove";

?>

<!DOCTYPE html>
<html lang="en-us">
	<head>
		<meta charset="utf-8">
		<title>	ShadYantra </title>
		<link rel="stylesheet" href="../assets/style.css">
		<!--script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script-->
		<script src="../assets/jquery-3.3.1.min.js"></script>
		<style> 
			span[name="J"]{ -webkit-transform: rotate(90deg);
    -moz-transform: rotate(90deg);
    -o-transform: rotate(90deg);
    -ms-transform: rotate(90deg);
    transform: rotate(90deg); } 
	
	span[name="j"]{ -webkit-transform: rotate(90deg);
    -moz-transform: rotate(90deg);
    -o-transform: rotate(90deg);
    -ms-transform: rotate(90deg);
    transform: rotate(90deg); } 

	</style>
	</head>

	<body>
		
		<div class="two_columns">
			<div name="<?php $boardtypeflag;$boardtype; ?>">
				<div class="status_box" id='<?php echo $board->	color_to_move; ?>'><?php echo $side_to_move; ?>
				</div>
				
				<div class="status_box"><?php echo $who_is_winning; $boardtypeflag=$board->boardtype;echo "</div>";if ($boardtypeflag==1) {
				define('livewhiteboard', true);	$boardtypeflag="white";	
				require_once('../liveviews/livewhiteboard.php');
				} 
				if ($boardtypeflag==2) { define('liveblackboard', true);
					$boardtypeflag="black"; 
					require_once('../liveviews/liveblackboard.php');
					}?>				
				
				<!-- <input type="submit" name="flip" value="Flip The Board"> -->
				<input type="button" onclick="window.location='../.'" value="Local Game">

			</div>
			<div class="center hideform">
    <button id="close" style="float: right;">X</button>
    <!--form action="/blackgamepairing.php"-->
    <form method="post">

        Game ID:<br>
        <input type="text" name="BlackGameID" value="">
        <br>
        <input type="submit" value="Submit">
    </form>
</div>
			<div>
			<input type="hidden" display='none' hidden  id="blackofficerscankill" value="<?php echo $board->blackcankill ?>" disabled readonly>
			<input type="hidden" display='none' hidden  id="whiteofficerscankill" value="<?php echo $board->whitecankill ?>" disabled readonly>

			<input type="hidden" display='none' hidden  id="blackofficerscanmovefull"  value="<?php echo $board->blackcanfullmove ?>" disabled readonly>
			<input type="hidden" display='none' hidden  id="whiteofficerscanmovefull"  value="<?php echo $board->whitecanfullmove ?>" disabled readonly>

			<div>
			<div id="textAreas" style="display:block;"> 
				<!--div style="position: relative" class = "container_row" --> 

				<ul id="tabs">
					  <li><a href="#layer1">Self</a></li>
					    <li><a href="#layer2">Opponent</a></li>
					</ul>
					<div id="layer1" class="layer1" class="tabcoachcontent tabContent tab-panel"> 
							<textarea style="top:0; left:0; z-index: 2;;" disabled readonly id="playerta" rows = "8" cols="50"> </textarea> 
					</div>
					<div id="layer2" class="layer2" class="tabcoachcontent tabContent tab-panel hidden">
							<textarea style="top:0; left:0; z-index: 1 ;;" disabled readonly id="opponentta" rows = "8" cols = "50"> </textarea> 
					</div>
				<!--/div-->
			</div>
			<div  style="display:block;position: relative;top:40px">
			<div id="KingMoves" class="container KingMoves">
				
			<div style="float:left;width:18%;">
				<form id="make_move" name="make_move" hidden disabled readonly style="display:none;"  method="POST">
				<label >Normal:<br/></label>
					<select id="<?php echo $gamemode; ?>" name="<?php echo $gamemode; ?>" size="10"></select>	
					<!--br><span id="move_count"></span> 	Moves : <br-->
					<input id="submitmove" type="submit" value="Make Move">
				</form>
			</div>

				<div style="float:left;width:19%;">
					<form id="king_endgame" name="king_endgame" hidden disabled readonly style="display:none;">
					<label id="lblViraam">Viraam: <br/></label>
						<select id="endgamemove" name="<?php echo $gamemode; ?>" size="10"></select>
							<!--br><span id="endgamemove_count"></span>Moves : <br-->
						<input id="submitendgamemove" type="submit" value="Make Move">
					</form>
				</div>

				<div style="float:left;width:19%;">
					<form id="recall" name="recall" hidden disabled readonly style="display:none;">
					<label id="lblSandhi">Sandhi<br/></label>
						<select id="recallmove" name="<?php echo $gamemode; ?>" size="5"></select>
							<!--br><span id="ReCallmove_count"></span>Moves Count: <br-->
						<input id="submitrecallmove" type="submit" value="Make Move">
					</form>
				</div>
				<div style="float:left;width:17%;">
					<form id="king_Shanti" name="king_Shanti" hidden disabled readonly style="display:none;">
					<label id="lblShanti">	</label>
						<select id="Shantimove" name="livemove" size="5"></select>
							<!--br><span id="ReCallmove_count"></span>Moves Count: <br-->
						<input id="submitShantimove" type="submit" value="Make Move">
					</form>
				</div>				
				<div style="float:left;width:16%;">
					<form id="winninggame" name="winninggame" hidden disabled readonly>
					<label >Winning: <br/></label>
						<select id="winninggamemove" name="livemove" size="8"></select>
							<!--br><span id="winninggamemove_count"></span>Moves : <br-->
						<input type="submit" id="	" value="Make Move">
					</form>
				</div>
				
				<div style="float:right;width:18%;;padding-right:10px;">
					<form id="king_surrender" name="king_surrender" hidden disabled readonly style="display:none;">
					<label >Surrender: <br/></label>
						<select id="surrendermove" name="livemove" size="10"></select>
							<!--br><span id="surrendermove_count"></span>Moves : <br-->	
						<input type="submit" id="submitsurrendermove" value="Make Move">
					</form>
				</div>
			</div>
			</div>
			</div>	
			</div>
			<div >
			<div>

			<div id="textAreasRules" style="display:block"> 
				<!--div style="position: relative" class = "container_row" --> 

				<ul id="tabs2">
					  <li><a href="#player1">Self Rule</a></li>
					    <li><a href="#player2">Common Rule</a></li>
					</ul>
					<div id="player1" class="player1" class="tabcoachcontent tabContent tab-panel"> 
							<textarea style="top:0; left:10px; z-index: 2;" disabled readonly id="player1ta" rows = "12" cols="50"> </textarea> 
					</div>
					<div id="player2" class="player2" class="tabcoachcontent tabContent tab-panel hidden">
							<textarea style="top:0; left:10px; z-index: 1;" disabled readonly id="player2ta" rows = "12" cols = "50"> </textarea> 
					</div>
				<!--/div-->
			</div>

			</div>
			</div>
			<?php if ($legal_moves==null) {?>
			<div id="lookformoves" name="lookformoves" class= "lookformoves" style="display:none;">
				</div>
			<?php } ?>
	
			<?php if ($legal_moves!=null){ ?>
			<div style="display:none;">
				<div id="history_move" name="history_move" style="display:none;"> 	Historical Moves:<br>
					<input id="history" name="history" size="19"></input>
					<br><span id="steps_count"></span> Moves Count: <br>
				</div>
				<?php $matched=0; $exportedfen= $fen; $gametype="old";
				?>
				
				<form id="all_moves" name="all_moves" hidden disabled readonly style="display:none;" method="post" > 	All Legal Moves:<br>
					<select id="moves" name="livemove" size="19">

				<?php if((file_exists($systemgameid))){
					//consider the white and black moves
							$file = fopen($systemgameid,"r");

							while(!feof($file) && $matched<2) {
								$line = rtrim(fgets($file),"\r\n");
			
								if (strpos($line, '$newfen=') !== false) {
									$gametype="new";
									}
							   	else if (strpos($line, '$currentfen=') !== false) {
									$splitted = explode( '$currentfen=',$line);
									$fen = $splitted[1];
									$stringposition=strpos($fen,$exportedfen);
									if (strpos($fen,$exportedfen) !== false) {
										$matched=$matched+1; //New request
										$gametype="old";
									}
									else if ((strpos($line, 'Moved_FEN=Good')!==false)) {
										$matched=$matched+1; //New request
										$gametype="old";
									}
								}
							   	else if (strpos($line, '$gameid=') !== false) {
									$splitted = explode( '$gameid=',$line);
									$gameid = $splitted[1];
									$onlygameid =  explode( ';',$gameid)[0];

									if (isset($_COOKIE['gameid'])) ///check if user already had some pending game // play invitation game if no pending game
									{
										$filewhitecookie=explode(';', explode( ';whitemover=',$gameid)[1])[0];
										$fileblackcookie=explode(';',explode(';blackmover=', $gameid)[1])[0];
										$filewhitegamecookie='$gameid='.$onlygameid.';whitemover='.$filewhitecookie.';';
										$fileblackgamecookie='$gameid='.$onlygameid.';blackmover='.$fileblackcookie.';';

										/*if((isset($_COOKIE['LiveStepType'])==true) &&($_COOKIE['LiveStepType']!="")&&
										((isset($_COOKIE['LiveStepType'])=="white"))) {
											if(strpos($whitegamecookie,$filewhitegamecookie)!== false)
											{
											$ttt=1;
											}
										}
										elseif((isset($_COOKIE['LiveStepType'])!=true) &&($_COOKIE['LiveStepType']!="")&&
										(($_COOKIE['LiveStepType']=="black"))) {
											if(strpos($blackgamecookie,$fileblackgamecookie)!== false)
											{

											}
										}
										else {

										}*/
									}
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
							fclose($file);

							if(($gametype=="old"))  {
								$data = file($systemgameid); // reads an array of lines
			
								$reading = fopen($systemgameid, 'r');
								if($newmove==1)
								$writing = fopen($systemgameid.'.tmp.txt', 'w');
			
								$replaced = false;
								$importedmatched=false;
								while (!feof($reading)&&($importedmatched==false)) {
									$line = rtrim(fgets($reading),"\r\n");
									if(($matched==1)	&&(stristr($line,'$currentfen='))){
										$line = '$currentfen='.explode(';', explode( '$currentfen=',$line)[1])[0];
										$replaced=true;$importedmatched=true;}
									else if ((stristr($line,'$currentfen='))) {
										$replaced = true;
										$importedmatched=true;
									}
									if($newmove==1)
						  				fputs($writing, $line.PHP_EOL);

									  if($importedmatched==true){
										$line = rtrim(fgets($reading),"\r\n");

										if($newmove==1)
										if (stristr($line,'$blackplayer='))
											fputs($writing, $line.PHP_EOL);
									}
								}

								$movecount=0;
								foreach ( $legal_moves as $key => $move ): 	?>
									<option value="<?php $notationvalue=""; $ending_square=$move->ending_square; $movecount=$movecount+1;

									if($move->pushedending_square!=null)
										$ending_square=$move->pushedending_square;
									$move_FEN= $move->board->export_fen_moves($move->starting_square,$move->ending_square); 
									echo $move_FEN;
									$move->ending_square=$ending_square;
									$notationvalue=$move->get_notation();
									if($newmove==1)
									fputs($writing, $movecount.'_Move='.$move_FEN.';'.$movecount.'_Notation='.$notationvalue.PHP_EOL); ?>"
									data-coordinate-notation="<?php echo  $notationvalue;?>" >
									<?php echo $notationvalue;
								endforeach;

								fclose($reading); 
								if($newmove==1)
								fclose($writing);
								if($newmove==1)
								chmod($systemgameid.".tmp.txt", 0755);

								// might as well not overwrite the file if we didn't replace anything
								if($newmove==1){
									try {
										sleep(3);
										if (($replaced) && (file_exists($systemgameid.'.tmp.txt')))
										{
											rename($systemgameid.'.tmp.txt', $systemgameid);
										}else {
											unlink($systemgameid.'.tmp.txt');
										}
									  }
									  //catch exception
									  catch(Exception $e) {
									  }
								}
							}
						}
		
				if($gametype=="new") {
					$file = fopen($systemgameid,"w");
					//$systemgameid;
					//fwrite($file,'$gameid='.'livemove'.str_shuffle("acdefhijkmnprtuvwxyz0123456789").PHP_EOL);
					fwrite($file,'$gameid='.$gameid.PHP_EOL);
					fwrite($file,'$currentfen='.$exportedfen.PHP_EOL);
					fwrite($file,'$blackplayer=0'.PHP_EOL);
					$movecount=0;
					foreach ( $legal_moves as $key => $move ):?>
						<option value="<?php $notationvalue=""; $ending_square=$move->ending_square; $movecount=$movecount+1;

									if($move->pushedending_square!=null)
										$ending_square=$move->pushedending_square;
									$move_FEN= $move->board->export_fen_moves($move->starting_square,$move->ending_square); 
									echo $move_FEN;
									$move->ending_square=$ending_square;
									$notationvalue=$move->get_notation();
									fwrite($file, $movecount.'_Move='.$move_FEN.';'); 
									fwrite($file,$movecount.'_Notation='.$notationvalue.PHP_EOL); ?>"
									data-coordinate-notation="<?php echo  $notationvalue;?>">
									<?php echo $notationvalue;
								echo "</option>"; 
					endforeach;
					fclose($file);
					chmod($systemgameid, 0755);
				}?>
		
					</select><br>
					Move Count:<?php echo count($legal_moves); ?><br>
					<input id="boardtype" name="boardtype" hidden value="">
					
					<?php
					
					$time = microtime();
					$time = explode(' ', $time);
					$time = $time[1] + $time[0];
					$finish = $time;
					$total_time = round(($finish - $start), 4);	
					$total_time *= 1000;
					$total_time = round($total_time);
					?>
					
					Load Time:<?php echo $total_time; ?>ms<br>
				</form>
			</div>
			<?php }?>
		</div>
	
		<div><br/><p> FEN:
		<form id="import_fen" method="post">
				<input id="fen" type="text" name="fen" value="<?php echo explode( ';',$fen)[0]; ?>"></br>
				<input type="submit" value="Import FEN"></br>
				<input type="button" value="Invert" name="" id="Invert" onclick="createDefaultCookie();"/> </br>
				<input id="import_boardtype" name="import_boardtype" hidden>
				<!--input type="button" id="perft" value="Perft"-->
			</p>
		</form>

<?php if(($blackplayerassigned==false) && ($playertype==2))
 {?>

<button id="show" >Enter GameID</button>
<?php }
 if(($blackplayerassigned==false) && ($playertype==0)) // White or Black Game
 {?>

<button id="show" >Enter GameID</button>
<?php }
 if(($blackplayerassigned==false) && ($playertype==1))
 {?>
<button id="WhiteGameID" >Copy GameID to play with Black</button>
<input type="text" size= 42 id="WhiteGameID_Data" readonly value="<?php echo $onlygameid.";"; ?>" style="visibility:hidden;readonly;"></button>

<?php } ?>

		</div>
	</body>
	<script src="../assets/livescripts.js"></script>
</html>