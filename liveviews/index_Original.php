<?php

if (! defined('VIEWER')) {
    die("This file needs to be included into a viewer.");
}

?>

<!DOCTYPE html>
<html lang="en-us">
	<head>
		<meta charset="utf-8">
		<title>	PHP Chess - Red Dragon Web Design </title>
		<link rel="stylesheet" href="assets/style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="assets/scripts.js"></script>
	</head>

	<body>
		
		<div class="two_columns">
			<div>
				<div class="status_box"> <?php echo $side_to_move; ?>
				</div>
				
				<div class="status_box"> <?php echo $who_is_winning; ?>
				</div>
				
				<table id="graphical_board" width="60%" height="90%">
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
											class="<?php echo $column['square_color']; ?>" style ="height:40px;width:40px"
										>
										<span class="draggable_piece" draggable="true" style ="display:inline-block;" name="<?php echo $column['name']; ?>"> <?php echo $column['piece']; ?>
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
				<input type="button" onclick="window.location='.'" value="Reset The Board">
			</div>
			
			<div>
				<form id="make_move">
					Legal Moves:<br>
					<select name="move" size="19">
						<?php foreach ( $legal_moves as $key => $move ): ?>
							
							<option
								value="<?php echo $move->board->export_fen(); ?>"
								data-coordinate-notation="<?php echo $move->get_notation(); ?>"
							>
								<?php echo $move->get_notation(); ?>
								
							</option>
						<?php endforeach; ?>
						
					</select><br>
					Move Count: <?php echo count($legal_moves); ?><br>
					
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
					<input type="submit" value="Make Move">
				</form>
			</div>
		</div>
		
		<form id="import_fen">
			<p>
				FEN:<br>
				<input id="fen" type="text" name="fen" value="<?php echo $fen; ?>"><br>
				<input type="submit" value="Import FEN">
				<input type="button" id="perft" value="Perft">
			</p>
		</form>
		
		<p>
		Want to report a bug or request a feature? <a href="https://github.com/RedDragonWebDesign/php-chess/issues">Create an issue</a> on our GitHub.
		</p>
	</body>
</html>