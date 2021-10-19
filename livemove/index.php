<?php

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../helpers/helper_functions.php');
require_once('../models/ChessRulebook.php');
require_once('../models/ChessBoard.php');
require_once('../models/ChessPiece.php');
require_once('../models/ChessMove.php');
require_once('../models/ChessSquare.php');

$board = new ChessBoard();

/*
if ( isset($_GET['reset']) ) {
	// Skip this conditional. ChessGame's FEN is the default, new game FEN and doesn't need to be set again.
} elseif ( isset($_GET['move']) ) {
	$board->import_fen($_GET['move']);
} elseif ( isset($_GET['surrendermove']) ) {
	$board->import_fen($_GET['surrendermove']);
} elseif ( isset($_GET['endgamemove']) ) {
	$board->import_fen($_GET['endgamemove']);
} elseif ( isset($_GET['fen']) ) {
	$board->import_fen($_GET['fen']);
}
*/

foreach($_GET as $key => $value){
	//echo $key . " : " . $value . "<br />\r\n";
  };
if ( isset($_REQUEST['reset']) ) {
	// Skip this conditional. ChessGame's FEN is the default, new game FEN and doesn't need to be set again.
	rename('livegame.txt', 'livegame_'.date('mdyhisA').'.txt');
} elseif ( isset($_REQUEST['livemove']) ) {
	$board->import_live_fen($_REQUEST['livemove']);
	if(isset($_REQUEST['import_boardtype']))
	$board->setboard($_REQUEST['import_boardtype']);
} elseif ( isset($_REQUEST['surrendermove']) ) {
	$board->import_fen($_REQUEST['surrendermove']);
	if(isset($_REQUEST['import_boardtype']))
	$board->setboard($_REQUEST['import_boardtype']);
} elseif ( isset($_REQUEST['endgamemove']) ) {
	$board->import_fen($_REQUEST['endgamemove']);
	if(isset($_REQUEST['import_boardtype']))
	$board->setboard($_REQUEST['import_boardtype']);
} elseif ( isset($_REQUEST['fen']) ) {
	$board->import_fen($_REQUEST['fen']);
	if(isset($_REQUEST['import_boardtype']))
	$board->setboard($_REQUEST['import_boardtype']);
} else {
	$board->import_live_fen("");
	if(isset($_REQUEST['import_boardtype']))
	$board->setboard($_REQUEST['import_boardtype']);	
}

$legal_moves = ChessRulebook::get_legal_moves_list($board->color_to_move, $board);
//$fen = $board->export_live_fen("1",$legal_moves);
$fen = $board->export_fen();
$side_to_move = $board->get_side_to_move_string();
$who_is_winning = $board->get_who_is_winning_string();
$graphical_board_array = $board->get_graphical_board();

define('VIEWER', true);
require_once('../liveviews/index.php');
