<?php

if (! defined('VIEWER')) {
    die("This file needs to be included into a viewer.");
}
$gametype="livemove";

?>

<!DOCTYPE html>
<html lang="en-us">
	<head>
		<meta charset="utf-8">
		<title>	ShadYantra </title>
		<link rel="stylesheet" href="../assets/style.css">
		<!--script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script-->
		<script src="../assets/jquery-3.3.1.min.js"></script>
		<script src="../assets/livescripts.js"></script>
	</head>

	<body>
		
		<div class="two_columns">
			<div>
				<div class="status_box" id='<?php echo $board->	color_to_move; ?>'> <?php echo $side_to_move; ?>
				</div>
				
				<div class="status_box"> <?php echo $who_is_winning; ?>
				</div>
				
				<table id="graphical_board" width="30%" height="90%">
					<tbody>
							<tr>
								<?php $style='gray';
									 echo '<td id ="x0" style="background-color:white;height:40px;width:40px;"></td>';
								for ( $i = 0; $i < 10; $i++ ) {
								 if ($i==0) {
									$x=ord('x');
									$style='gray;height:40px;width:40px';
								 }
								 if (($i>0) && ($i<9))
								 {
									$x=$i+ord('a')-1;
									$style='gray;height:40px;width:40px';
								 }
								 if($i==9){
								  $x=ord('y');
									$style='gray;height:40px;width:40px';
								 } 
									 echo '<td id ="'.chr($x).$i.'" style="background-color:'.$style.'"> <span class="nondraggable_piece" draggable="false" >'.chr($x).'</span></td>';
								}
									 echo '<td id ="y0" style="background-color:white;height:40px;width:40px"></td>';
								?>
							</tr>
	
						<?php $col=9;foreach ( $graphical_board_array as $rank => $row ): ?>
	
							<tr>
								 <?php
										echo '<td id ='.$col.' class="truce" style="height:40px;width:40px;background-color:gray">
										<span class="nondraggable" draggable="false">'.$col.'</span></td>';
										foreach ( $row as $file => $column ): ?>

										<td	id ="<?php echo $column['id']; ?>"
											class="<?php echo $column['square_color']; if(($column['id']=='x4')||($column['id']=='x5')||($column['id']=='y4')||($column['id']=='y5')||($column['id']=='d0')||($column['id']=='e0')||($column['id']=='d9')||($column['id']=='e9')) {
                                                echo ' octagonWrap';
                                            }?>" style ="height:40px;width:40px" 
										>
										<span class="draggable_piece<?php if(($column['id']=='x4')||($column['id']=='x5')||($column['id']=='y4')||($column['id']=='y5')) { echo ' octagonT';} if(($column['id']=='d0')||($column['id']=='e0')||($column['id']=='d9')||($column['id']=='e9')){ echo ' octagonC';}?>" draggable="true" style ="display:inline-block;" name="<?php echo $column['name']; ?>"> <?php echo $column['piece']; ?>
										</span>
									</td>
								<?php endforeach;
									echo '<td id ='.$col.' class="truce" style="background-color:gray;height:40px;width:40px">
										<span class="nondraggable" draggable="false">'.$col.'</span></td>';
									?>
							</tr>
							
						<?php $col--; endforeach; ?>
						<tr>
								<?php 
									 echo '<td id ="x9" style="background-color:white;height:40px;width:40px;"></td>';
									for ( $i = 0; $i < 10; $i++ ) {
									$style='gray';
								 if ($i==0) {
									$x=ord('x');
									$style='gray;height:40px;width:40px';
								 }
								 if (($i>0) && ($i<9))
								 {
									$x=$i+ord('a')-1;
									$style='gray;height:40px;width:40px';
								 }
								 if($i==9){
								  $x=ord('y');
									$style='gray;height:40px;width:40px';
								 }
									 echo '<td id ="'.chr($x).$i.'" style="background-color:'.$style.'"> <span class="nondraggable_piece" draggable="false" >'.chr($x).'</span></td>';
								}
								 echo '<td id ="y9" style="background-color:white;height:40px;width:40px;"></td>';
								
								?>
							</tr>
					</tbody>
				</table>
				<!-- <input type="submit" name="flip" value="Flip The Board"> -->
				<input type="button" onclick="window.location='../.'" value="Local Game">
				
			</div>

			<div>
			<input type="hidden" display='none' hidden  id="blackofficerscankill" value="<?php echo $board->blackcankill ?>" disabled readonly>
			<input type="hidden" display='none' hidden  id="whiteofficerscankill" value="<?php echo $board->whitecankill ?>" disabled readonly>

			<input type="hidden" display='none' hidden  id="blackofficerscanmovefull"  value="<?php echo $board->blackcanfullmove ?>" disabled readonly>
			<input type="hidden" display='none' hidden  id="whiteofficerscanmovefull"  value="<?php echo $board->whitecanfullmove ?>" disabled readonly>

			<div>
			<div id="textAreas" style="display:block"> 
				<div style="position: relative" class = "container_row"> 
					<div id="layer1" class="layer1" style="position: relative;top:10px"> 
					<label> Self </label>
						<div>
							<textarea style="top:0; left:0; z-index: 2;" disabled readonly id="playerta" rows = "8" cols="60"> </textarea> 
						</div>	
					</div>
					<div id="layer2" class="layer2" style="position: relative;top:30px">
					<label> Opponent </label>
						<div>
							<textarea style="top:0; left:0; z-index: 1;" disabled readonly id="opponentta" rows = "8" cols = "60"> </textarea> 
						</div>
					</div>
				</div>
			</div>
			<div  style="display:block;position: relative;top:40px">
			<div id="KingMoves" class="container" class="KingMoves">
				
			<div style="float:left;width:18%;">
				<form id="make_move" name="make_move" hidden disabled readonly style="display:none;"  method="POST">
				<label >Normal:<br/></label>
					<select id="<?php echo $gametype; ?>" name="<?php echo $gametype; ?>" size="10"></select>	
					<!--br><span id="move_count"></span> 	Moves : <br-->
					<input id="submitmove" type="submit" value="Make Move">
				</form>
			</div>

				<div style="float:left;width:19%;">
					<form id="king_endgame" name="king_endgame" hidden disabled readonly style="display:none;">
					<label id="lblViraam">Viraam: <br/></label>
						<select id="endgamemove" name="<?php echo $gametype; ?>" size="10"></select>
							<!--br><span id="endgamemove_count"></span>Moves : <br-->
						<input id="submitendgamemove" type="submit" value="Make Move">
					</form>
				</div>

				<div style="float:left;width:19%;">
					<form id="recall" name="recall" hidden disabled readonly style="display:none;">
					<label id="lblSandhi">Sandhi<br/></label>
						<select id="recallmove" name="<?php echo $gametype; ?>" size="5"></select>
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
			<div id="textAreasRules"> 
				<div style="position: relative" class = "container_row"> 
					<div id="player1" class="layer1" style="position: relative;top:10px;padding:10px;"> 
					<label> Self Rule </label>
						<div>
							<textarea style="top:0; left:0; z-index: 2;" disabled readonly id="player1ta" rows = "12" cols="50	"> </textarea> 
						</div>	
					</div>
					<div id="player2" class="layer2" style="position: relative;top:30px;padding:10px;">
					<label> Common Rule </label>
						<div>
							<textarea style="top:0; left:0; z-index: 1;" disabled readonly id="player2ta" rows = "12" cols = "50"> </textarea> 
						</div>
					</div>
				</div>
			</div>


			</div>
			</div>
			<div style="display:none;">
				<div id="history_move" name="history_move" style="display:none;"> 	Historical Moves:<br>
					<input id="history" name="history" size="19"></input>
					<br><span id="steps_count"></span> Moves Count: <br>
				</div>
				<form id="all_moves" name="all_moves" hidden disabled readonly style="display:none;" > 	All Legal Moves:<br>
					<select id="moves" name="livemove" size="19">
					<?php foreach ( $legal_moves as $key => $move ): ?>							
							<option
								value="<?php $notationvalue=""; $ending_square=$move->ending_square;
								if($move->pushedending_square!=null)
									$ending_square=$move->pushedending_square;
									echo $move->board->export_fen_moves($move->starting_square,$move->ending_square); 
									$move->ending_square=$ending_square;
									$notationvalue=$move->get_notation();?>"
								data-coordinate-notation="<?php echo  $notationvalue;?>" pushed-value="<?php echo  $notationvalue;?>"
							>
								<?php echo $notationvalue; ?>
							</option>
						<?php endforeach; ?>

					</select><br>
					Move Count: <?php echo count($legal_moves); ?><br>
					<!--input type="submit" display='none' hidden value="Make Move"-->
					
					<?php
					
					$time = microtime();
					$time = explode(' ', $time);
					$time = $time[1] + $time[0];
					$finish = $time;
					$total_time = round(($finish - $start), 4);	
					$total_time *= 1000;
					$total_time = round($total_time);
					?>
					
					Load Time: <?php echo $total_time; ?> ms<br>
				</form>				
			</div>
		</div>
		
		<form id="import_fen">
			<p>
				FEN:<br>
				<input id="fen" type="text" name="fen" value="<?php echo $fen; ?>"><br>
				<input type="submit" value="Import FEN">
				<!--input type="button" id="perft" value="Perft"-->
			</p>
		</form>
	</body>
</html>