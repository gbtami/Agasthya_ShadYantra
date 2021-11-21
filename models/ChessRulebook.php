<?php

class ChessRulebook {
	const NORTH = 1; const SOUTH = 2; const EAST = 3; const WEST = 4; const NORTHWEST = 5; const NORTHEAST = 6; const SOUTHWEST = 7; const SOUTHEAST = 8;
	const ALL_DIRECTIONS = array( self::NORTH, self::SOUTH, self::EAST, self::WEST, self::NORTHWEST, self::NORTHEAST, self::SOUTHWEST, self::SOUTHEAST );
	
	// Coordinates are in (rank, file) / (y, x) format
	const OCLOCK_OFFSETS = array(
		1 => array(2,1), 2 => array(1,2), 3 => array(2,0), 4 => array(-1,2),
		5 => array(-2,1), 6 => array(-2,0), 7 => array(-2,-1), 8 => array(-1,-2),
		9 => array(0,-2), 10 => array(1,-2), 11 => array(2,-1), 12 => array(0,2),
		13 => array(2,2), 14 => array(2,-2), 15 => array(-2,2), 16 => array(-2,-2)
	);

	const DIRECTION_OFFSETS = array( self::NORTH => array(1,0), self::SOUTH => array(-1,0), self::EAST => array(0,1), self::WEST => array(0,-1), self::NORTHEAST => array(1,1), self::NORTHWEST => array(1,-1), self::SOUTHEAST => array(-1,1), self::SOUTHWEST => array(-1,-1));
	const Pawn_RBottom_DIRECTIONS = array( self::NORTH, self::NORTHWEST );
	const RBottom_DIRECTIONS = array( self::WEST, self::NORTH, self::NORTHWEST );
	const Pawn_LBottom_DIRECTIONS = array( self::NORTH, self::NORTHEAST );
	const LBottom_DIRECTIONS = array( self::EAST, self::NORTH, self::NORTHEAST );
	const RTop_DIRECTIONS = array( self::WEST, self::SOUTH, self::SOUTHWEST	);
	const Pawn_RTop_DIRECTIONS = array( self::SOUTH, self::SOUTHWEST );
	const LTop_DIRECTIONS = array( self::EAST, self::SOUTH, self::SOUTHEAST );
	const Pawn_LTop_DIRECTIONS = array( self::SOUTH, self::SOUTHEAST );
	const JrisPushingBottom_DIRECTIONS = array( self::SOUTH, self::SOUTHWEST, self::SOUTHEAST );
	const Bottom_DIRECTIONS = array( self::SOUTH, self::SOUTHWEST, self::SOUTHEAST );
	const Pawn_Bottom_DIRECTIONS = array( self::NORTH, self::NORTHEAST, self::NORTHWEST );
	const Pawn_Top_DIRECTIONS = array( self::SOUTH, self::SOUTHEAST, self::SOUTHWEST );
	const Top_DIRECTIONS = array( self::EAST, self::WEST, self::SOUTH, self::SOUTHWEST, self::SOUTHEAST );
	const L_DIRECTIONS = array( self::EAST, self::NORTH, self::SOUTH, self::NORTHEAST, self::SOUTHEAST );
	const R_DIRECTIONS = array( self::WEST, self::NORTH, self::SOUTH, self::NORTHWEST, self::SOUTHWEST );
	const Pawn_L_DIRECTIONS_1 = array( self::NORTH, self::NORTHEAST );
	const Pawn_L_DIRECTIONS_2 = array( self::SOUTH, self::SOUTHEAST );
	const Pawn_MID_DIRECTIONS_1 = array( self::EAST, self::WEST, self::NORTH, self::SOUTH, self::SOUTHEAST, self::SOUTHWEST, self::NORTHEAST, self::NORTHWEST	);

	/* const Pawn_MID_DIRECTIONS_2 = array( self::SOUTH, self::SOUTHEAST, self::SOUTHWEST ); */
	const Pawn_MID_DIRECTIONS_2 = array( self::EAST, self::WEST, self::NORTH, self::SOUTH, self::SOUTHEAST, self::SOUTHWEST, self::NORTHEAST, self::NORTHWEST	);
	const MID_DIRECTIONS = array( self::EAST, self::WEST, self::NORTH, self::SOUTH, self::SOUTHEAST, self::SOUTHWEST, self::NORTHEAST, self::NORTHWEST );
	const Pawn_R_DIRECTIONS_1 = array( self::NORTH, self::NORTHWEST	);
	const Pawn_R_DIRECTIONS_2 = array( self::SOUTH, self::SOUTHWEST );
	const BISHOP_DIRECTIONS = array( self::NORTHWEST, self::NORTHEAST, self::SOUTHWEST, self::SOUTHEAST /*self::NORTH,	//self::SOUTH, //self::EAST, //self::WEST*/ );
	const RETREATING_BISHOP_DIRECTIONS_1 = array( self::SOUTHWEST, self::SOUTHEAST /*self::EAST, //self::WEST*/	);
	const RETREATING_BISHOP_DIRECTIONS_2 = array( self::NORTHWEST, self::NORTHEAST /*self::EAST, //self::WEST*/	);
	const ROOK_DIRECTIONS = array( self::NORTH, self::SOUTH, self::EAST, self::WEST );
	const RETREATING_ROOK_DIRECTIONS_1 = array( self::SOUTH, self::EAST, self::WEST );	
	const RETREATING_ROOK_DIRECTIONS_2 = array(	self::NORTH, self::EAST, self::WEST );
	const GENERAL_DIRECTIONS = array( self::NORTH, self::SOUTH, self::EAST, self::WEST, self::NORTHWEST, self::NORTHEAST, self::SOUTHWEST, self::SOUTHEAST );
	const RETREATING_GENERAL_DIRECTIONS_1 = array( self::SOUTH, self::EAST, self::WEST, self::SOUTHWEST, self::SOUTHEAST );
	const RETREATING_GENERAL_DIRECTIONS_2 = array( self::NORTH, self::EAST, self::WEST, self::NORTHWEST, self::NORTHEAST );
	const KING_DIRECTIONS = array( self::NORTH, self::SOUTH, self::EAST, self::WEST, self::NORTHWEST, self::NORTHEAST, self::SOUTHWEST, self::SOUTHEAST );
	const KNIGHT_DIRECTIONS = array(1, 2, 3,4, 5, 6,7, 8, 9,10, 11,12,13,14,15,16);
	//const BLACK_PAWN_CAPTURE_DIRECTIONS = array(self::SOUTH,self::SOUTHEAST, self::SOUTHWEST);
	//const BLACK_PAWN_MOVEMENT_DIRECTIONS = array(self::SOUTH,self::SOUTHEAST, self::SOUTHWEST);
	//const WHITE_PAWN_CAPTURE_DIRECTIONS = array(self::NORTH,self::NORTHEAST, self::NORTHWEST);
	//const WHITE_PAWN_MOVEMENT_DIRECTIONS = array(self::NORTH,self::NORTHEAST, self::NORTHWEST);

	const BLACK_PAWN_CAPTURE_DIRECTIONS = array(self::NORTH, self::SOUTH, self::EAST, self::WEST, self::NORTHWEST, self::NORTHEAST, self::SOUTHWEST, self::SOUTHEAST);
	const BLACK_PAWN_MOVEMENT_DIRECTIONS = array(self::NORTH, self::SOUTH, self::EAST, self::WEST, self::NORTHWEST, self::NORTHEAST, self::SOUTHWEST, self::SOUTHEAST);
	const WHITE_PAWN_CAPTURE_DIRECTIONS =  array(self::NORTH, self::SOUTH, self::EAST, self::WEST, self::NORTHWEST, self::NORTHEAST, self::SOUTHWEST, self::SOUTHEAST);
	const WHITE_PAWN_MOVEMENT_DIRECTIONS =  array(self::NORTH, self::SOUTH, self::EAST, self::WEST, self::NORTHWEST, self::NORTHEAST, self::SOUTHWEST, self::SOUTHEAST);

	const RETREATING_KNIGHT_DIRECTIONS_1 = array(4, 5, 6,  7,  8,  9, 12,15,16);
	const RETREATING_KNIGHT_DIRECTIONS_2 = array(1, 2, 3, 9, 10, 11, 12,13,14);
	const RETREATING_KNIGHT_DIRECTIONS_11 = array(5, 6,  7,15,16);
	const RETREATING_KNIGHT_DIRECTIONS_22 = array(1, 3, 11,13,14);

	const RETREATING_BLACK_PAWN_CAPTURE_DIRECTIONS =  array(self::NORTH,self::NORTHEAST, self::NORTHWEST);
	const RETREATING_BLACK_PAWN_MOVEMENT_DIRECTIONS = array(self::NORTH,self::NORTHEAST, self::NORTHWEST);
	const RETREATING_WHITE_PAWN_CAPTURE_DIRECTIONS = array(self::SOUTH,self::SOUTHEAST, self::SOUTHWEST);
	const RETREATING_WHITE_PAWN_MOVEMENT_DIRECTIONS = array(self::SOUTH,self::SOUTHEAST, self::SOUTHWEST);
		
	const PROMOTION_PIECES = array( ChessPiece::GENERAL, ChessPiece::ROOK, ChessPiece::BISHOP, ChessPiece::KNIGHT );
	
	const MAX_SLIDING_DISTANCE = 3;
	const MAX_TOUCH = 1;
	static function get_legal_moves_list(
		$color_to_move, // Color changes when we call recursively. Can't rely on $board for color.
		ChessBoard $board, // ChessBoard, not ChessBoard->board. We need the entire board in a couple of methods.
		bool $need_perfect_move_list = TRUE,
		bool $store_board_in_moves = TRUE,
		bool $need_perfect_notation = TRUE
	): array {
		//**echo '<li> ChessRuleBook.php #1 function get_legal_moves_list called </li>';
		$selfbrokencastle =null;
		$foebrokencastle =null;
		$pieces_to_check = self::get_all_pieces_by_color($color_to_move, $board);
		
		$moves = array();
		$king = null;$naard_can_move=true;
		
		// TODO: Iterate through all squares on chessboard, not all pieces. Then I won't need to
		// store each piece's ChessSquare, and I can get rid of that class completely.

				//null means King is Active now
		$board->get_royals_on_Scepters_TruceControl(1);
		$board->get_royals_on_warZone_for_full_move(1);
		$board->get_royals_on_castle_for_full_move(1); //1 means General must be there// 0 means Royal or general //3 means supertight
		$board->get_general_on_warZone_for_full_move(1); //1 means General must be there// 0 means Royal or general //3 means supertight
		$board->get_general_on_castle_for_full_move(1);
		$board->get_generals_on_truce(1);
		$board->get_compromised_castles();
		$get_Killing_Allowed=0;	$nonnaarad_can_move=true;

		if(($board->controller_color!=null) &&(($board->controller_color==$color_to_move)&&($board->controlled_color==3-$color_to_move))){
			$get_Killing_Allowed=0;
			if($board->gametype==1){
				$naard_can_move=true;
				$nonnaarad_can_move=false;
				self::set_naarad_for_fullmoves($board);
				}
			else if($board->gametype==2){
					$naard_can_move=false;
					$nonnaarad_can_move=true;
					//self::set_naarad_for_fullmoves($board);
					}
			}
		else if(($board->controller_color==null)&&($board->controlled_color==null)){
			$naard_can_move=true;
			$nonnaarad_can_move=true;
			self::set_naarad_for_fullmoves($board);
			$board->controller_color=null;$board->controlled_color=null;
			}

		self::set_general_for_elevatedmoves($board);
		
		$get_FullMover=FALSE;//Check if killing allowed

		//public $PinnedWRefugees = array();
		//public $PinnedBRefugees = array();
		//$board->get_PinnedWRefugees(2);

		$get_CASTLEMover=-1;
		if($color_to_move==1) { $selfbrokencastle=  $board->wbrokencastle;$foebrokencastle= $board->bbrokencastle; }
		if($color_to_move==2) { $selfbrokencastle=  $board->bbrokencastle;$foebrokencastle= $board->wbrokencastle; }

		if(($board->Winner=='-1')||($board->Winner=='0')){
			foreach ($pieces_to_check as $piece) {
				$get_CASTLEMover=-1;

				if ($piece->type == ChessPiece::BISHOP){
					$get_FullMover=FALSE;
				}
				if(($piece->group=='ROYAL')||($piece->group=='SEMIROYAL')){
					$get_FullMover=TRUE;
					if(self::get_piece_castle_with_royals($piece,$color_to_move,$board)==1){
						$get_FullMover=TRUE;//peice in its ownself castle
						$get_CASTLEMover=1;
						}
					elseif(self::get_piece_castle_with_royals($piece,$color_to_move,$board)==0){
						$get_CASTLEMover=0;//foe castle has 1 royal
						}
				}
				/*if (($piece->type == ChessPiece::PAWN) &&($color_to_move==2)) {
				$ttt=1;
				}*/

				if(($piece->group=='OFFICER')||($piece->group=='SOLDIER')){
					if($piece->color==1){
						if(($piece->type!=ChessPiece::GENERAL)&&($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0)&&($piece->square->file<9)&&($board->whitecanfullmove==1))
							{
							$get_FullMover=TRUE;
							}
						elseif(($piece->type==ChessPiece::GENERAL)&&($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0)&&($piece->square->file<9)&&($board->whitescanfullmove==1))
							{
							$get_FullMover=TRUE;
							}
						elseif(($piece->square->rank==0)&&($piece->square->file>0)&&($piece->square->file<9))
							{
							$get_FullMover=TRUE;
							}
						elseif(($piece->type!=ChessPiece::GENERAL)&&($piece->square->rank==9)&&($piece->square->file>0)&&($piece->square->file<9)&&(($board->whitecanfullmoveinfoecastle==1)||($board->whitecanfullmove==1)))
							{
							$get_FullMover=TRUE;
							}
						elseif(($piece->type==ChessPiece::GENERAL)&&($piece->square->rank==9)&&($piece->square->file>0)&&($piece->square->file<9)&&(($board->whitecanfullmoveinfoecastle==1)||($board->whitescanfullmove==1)))
							{
							$get_FullMover=TRUE;
							}
						elseif(($piece->square->rank==0)&&($piece->square->file>0)&&($piece->square->file<9)&&($board->whitecanfullmoveinowncastle==1))
							{
							$get_FullMover=TRUE;
							}
						else
							$get_FullMover=FALSE;
						
						if($board->whitecankill==1) 
							$get_Killing_Allowed=1;
						else  $get_Killing_Allowed=0;
						
						if(self::get_piece_castle_with_royals($piece,$color_to_move,$board)==1){
							$get_FullMover=TRUE;//peice in its ownself castle
							$get_CASTLEMover=1;
							}
						elseif(self::get_piece_castle_with_royals($piece,$color_to_move,$board)==0){
							$get_CASTLEMover=0;//foe castle has 1 royal
							$get_FullMover=TRUE;//peice in its ownself castle
							}
						//else -1 means WAR zone should be checked.	
						}
					elseif($piece->color==2){
						if(($piece->type!=ChessPiece::GENERAL)&&($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0)&&($piece->square->file<9)&&($board->blackcanfullmove==1))
							{
								$get_FullMover=TRUE;
							}
						elseif(($piece->type==ChessPiece::GENERAL)&&($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0)&&($piece->square->file<9)&&($board->blackscanfullmove==1))
							{
								$get_FullMover=TRUE;
							}
						elseif(($piece->square->rank==9)&&($piece->square->file>0)&&($piece->square->file<9))
							{
								$get_FullMover=TRUE;
							}
						elseif(($piece->type!=ChessPiece::GENERAL)&&($piece->square->rank==9)&&($piece->square->file>0)&&($piece->square->file<9)&&(($board->blackcanfullmoveinfoecastle==1)||($board->blackcanfullmove==1)))
							{
								$get_FullMover=TRUE;
							}
						elseif(($piece->type==ChessPiece::GENERAL)&&($piece->square->rank==9)&&($piece->square->file>0)&&($piece->square->file<9)&&(($board->blackcanfullmoveinfoecastle==1)||($board->blackscanfullmove==1)))
							{
								$get_FullMover=TRUE;
							}
						elseif(($piece->square->rank==0)&&($piece->square->file>0)&&($piece->square->file<9)&&($board->blackcanfullmoveinowncastle==1))
							{
								$get_FullMover=TRUE;
							}
						else  $get_FullMover=FALSE;

						if($board->blackcankill==1) 
							$get_Killing_Allowed=1;
						else  $get_Killing_Allowed=0;
						if(self::get_piece_castle_with_royals($piece,$color_to_move,$board)==1){
							$get_FullMover=TRUE;//peice in its ownself castle
							$get_CASTLEMover=1;
							}
						elseif(self::get_piece_castle_with_royals($piece,$color_to_move,$board)==0){
							$get_CASTLEMover=0;//foe castle has 1 royal
							$get_FullMover=TRUE;//peice in its ownself castle
							}
						//else -1 means WAR zone should be checked.	
						}
					}

				if(($board->gametype==1)||($board->gametype==2))
					$jumpstyle='3';//1 = Straight, 2 = diagonal , 3= both

					/*if ($piece->type == ChessPiece::KNIGHT)
						$ttt=1;*/
					if(($board->gametype==1) && ($piece->group=="OFFICER")){
						$get_FullMover=self::check_general_royal_neighbours_promotion(self::KING_DIRECTIONS, $piece, $color_to_move, $board);
						}
					else if(($board->gametype==1) && (($piece->group=="ROYAL") ||  ($piece->group=="SEMIROYAL")))
						$get_FullMover=self::has_royal_neighbours(  self::KING_DIRECTIONS, $piece->square, $piece->square, $color_to_move, $board );
				if($naard_can_move==false){
					$get_Killing_Allowed=0;
				};
				if (($nonnaarad_can_move)&&($piece->type == ChessPiece::PAWN)) {
					if ($piece->color == ChessPiece::WHITE) {
						$moves = self::add_slide_moves_to_moves_list(self::WHITE_PAWN_MOVEMENT_DIRECTIONS, 1, $moves, $piece, $color_to_move, $board, $store_board_in_moves,$get_Killing_Allowed,$selfbrokencastle,$foebrokencastle);
						if($get_Killing_Allowed==1){
							$moves = self::add_capture_moves_to_moves_list(self::WHITE_PAWN_CAPTURE_DIRECTIONS, $moves, $piece, $color_to_move, $board, $store_board_in_moves,$get_Killing_Allowed,$selfbrokencastle,$foebrokencastle);
						}
					} elseif ($piece->color == ChessPiece::BLACK) {
						$moves = self::add_slide_moves_to_moves_list(self::BLACK_PAWN_MOVEMENT_DIRECTIONS, 1, $moves, $piece, $color_to_move, $board, $store_board_in_moves,$get_Killing_Allowed,$selfbrokencastle,$foebrokencastle);
						if($get_Killing_Allowed==1){
						$moves = self::add_capture_moves_to_moves_list(self::BLACK_PAWN_CAPTURE_DIRECTIONS, $moves, $piece, $color_to_move, $board, $store_board_in_moves,$get_Killing_Allowed,$selfbrokencastle,$foebrokencastle);
						}
					}
				} elseif (($nonnaarad_can_move)&&($piece->type == ChessPiece::KNIGHT)) {
					$moves = self::add_capture_moves_to_moves_list(self::GENERAL_DIRECTIONS, $moves, $piece, $color_to_move, $board, $store_board_in_moves,$get_Killing_Allowed,$selfbrokencastle,$foebrokencastle);
					if($get_Killing_Allowed==1) 
						$get_Killing_Allowed=2;
					if(($get_CASTLEMover==1) &&	($get_Killing_Allowed==2)){	$get_Killing_Allowed=1;} //knight does not need to mixup in his own castle.
					if($get_FullMover==true)
						$moves = self::add_jump_and_jumpcapture_moves_to_moves_list(1,$jumpstyle,self::KNIGHT_DIRECTIONS, $moves, $piece, $color_to_move, $board, $store_board_in_moves,$get_Killing_Allowed,1,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover,FALSE);
					$moves = self::add_slide_and_slidecapture_moves_to_moves_list(self::BISHOP_DIRECTIONS, 1, $moves, $piece, $color_to_move, $board, $store_board_in_moves,0,1,FALSE,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover,FALSE);
					$moves = self::add_slide_and_slidecapture_moves_to_moves_list(self::ROOK_DIRECTIONS, 1, $moves, $piece, $color_to_move, $board, $store_board_in_moves,0,1,FALSE,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover,FALSE);

				} elseif (($nonnaarad_can_move)&&($piece->type == ChessPiece::BISHOP) ) {
					if($board->gametype==1){ //Classical Agastya
						$moves = self::add_capture_moves_to_moves_list(self::GENERAL_DIRECTIONS, $moves, $piece, $color_to_move, $board, $store_board_in_moves,$get_Killing_Allowed,1,$selfbrokencastle,$foebrokencastle);
						$moves = self::add_slide_and_slidecapture_moves_to_moves_list(self::BISHOP_DIRECTIONS, 2, $moves, $piece, $color_to_move, $board, $store_board_in_moves,$get_Killing_Allowed,1,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover,FALSE);
						$moves = self::add_slide_and_slidecapture_moves_to_moves_list(self::ROOK_DIRECTIONS, 2, $moves, $piece, $color_to_move, $board, $store_board_in_moves,$get_Killing_Allowed,1,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover,FALSE);
					}
					elseif($board->gametype==2){ //Kautilya
						$moves = self::add_capture_moves_to_moves_list(self::BISHOP_DIRECTIONS, $moves, $piece, $color_to_move, $board, $store_board_in_moves,$get_Killing_Allowed,$selfbrokencastle,$foebrokencastle);
						$moves = self::add_slide_and_slidecapture_moves_to_moves_list(self::BISHOP_DIRECTIONS, 2, $moves, $piece, $color_to_move, $board, $store_board_in_moves,$get_Killing_Allowed,1,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover,FALSE);
					}
				} elseif (($nonnaarad_can_move)&&($piece->type == ChessPiece::ROOK)) {
					$moves = self::add_capture_moves_to_moves_list(self::GENERAL_DIRECTIONS, $moves, $piece, $color_to_move, $board, $store_board_in_moves,$get_Killing_Allowed,$selfbrokencastle,$foebrokencastle);
					if($board->gametype==1){
						$moves = self::add_slide_and_slidecapture_moves_to_moves_list(self::BISHOP_DIRECTIONS,  self::MAX_SLIDING_DISTANCE, $moves, $piece, $color_to_move, $board, $store_board_in_moves,$get_Killing_Allowed,1,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover,FALSE);
						$moves = self::add_slide_and_slidecapture_moves_to_moves_list(self::ROOK_DIRECTIONS,  self::MAX_SLIDING_DISTANCE, $moves, $piece, $color_to_move, $board, $store_board_in_moves,$get_Killing_Allowed,1,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover,FALSE);
					}
					elseif($board->gametype==2){
						$moves = self::add_slide_and_slidecapture_moves_to_moves_list(self::ROOK_DIRECTIONS,  self::MAX_SLIDING_DISTANCE, $moves, $piece, $color_to_move, $board, $store_board_in_moves,$get_Killing_Allowed,1,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover,FALSE);
					}
				} elseif (($nonnaarad_can_move)&& ($piece->type == ChessPiece::GENERAL)) {
					$moves = self::add_capture_moves_to_moves_list(self::GENERAL_DIRECTIONS, $moves, $piece, $color_to_move, $board, $store_board_in_moves,$get_Killing_Allowed,$selfbrokencastle,$foebrokencastle);
					//$get_Killing_Allowed=1;
					if($get_FullMover==TRUE)
						$moves= self::add_jump_and_jumpcapture_moves_to_moves_list(1,$jumpstyle,self::KNIGHT_DIRECTIONS, $moves, $piece, $color_to_move, $board, $store_board_in_moves,$get_Killing_Allowed,$get_FullMover,1,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover,FALSE);
					$moves = self::add_slide_and_slidecapture_moves_to_moves_list(self::GENERAL_DIRECTIONS, self::MAX_SLIDING_DISTANCE, $moves, $piece, $color_to_move, $board, $store_board_in_moves,$get_Killing_Allowed,1,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover,FALSE);
				} elseif (($nonnaarad_can_move)&&(($piece->type == ChessPiece::KING)||($piece->type == ChessPiece::INVERTEDKING))) {
					$moves = self::add_capture_moves_to_moves_list(self::GENERAL_DIRECTIONS, $moves, $piece, $color_to_move, $board, $store_board_in_moves,1,$selfbrokencastle,$foebrokencastle);
					$moves = self::add_jump_and_jumpcapture_moves_to_moves_list(2,$jumpstyle,self::KNIGHT_DIRECTIONS, $moves, $piece, $color_to_move, $board, $store_board_in_moves,1,1,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover,FALSE);
					$moves = self::add_slide_and_slidecapture_moves_to_moves_list(self::KING_DIRECTIONS, self::MAX_SLIDING_DISTANCE, $moves, $piece, $color_to_move, $board, $store_board_in_moves,1,1,TRUE,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover,FALSE);				
					 //Set $king here so castling function can use it later.
					$king = $piece;
				} elseif (($nonnaarad_can_move)&&(($piece->type == ChessPiece::ARTHSHASTRI))) {
					if($get_FullMover==true)
						{
						$moves = self::add_jump_and_jumpcapture_moves_to_moves_list(2,$jumpstyle,self::KNIGHT_DIRECTIONS, $moves, $piece, $color_to_move, $board, $store_board_in_moves,0,1,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover,FALSE);
						$moves = self::add_slide_and_slidecapture_moves_to_moves_list(self::KING_DIRECTIONS, self::MAX_SLIDING_DISTANCE, $moves, $piece, $color_to_move, $board, $store_board_in_moves,0,1,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover,FALSE);
						}
					else if($get_FullMover==false)
						$moves = self::add_slide_and_slidecapture_moves_to_moves_list(self::KING_DIRECTIONS, 1, $moves, $piece, $color_to_move, $board, $store_board_in_moves,0,1,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover,FALSE);
// Set $king here so castling function can use it later.
					$ARTHSHASTRI = $piece;
				} elseif (($nonnaarad_can_move)&&($piece->type == ChessPiece::SPY)) {
					if($get_FullMover==true)
						{
						$moves = self::add_jump_and_jumpcapture_moves_to_moves_list(2,$jumpstyle,self::KNIGHT_DIRECTIONS, $moves, $piece, $color_to_move, $board, $store_board_in_moves,0,1,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover,FALSE);
						$moves = self::add_slide_and_slidecapture_moves_to_moves_list(self::KING_DIRECTIONS, self::MAX_SLIDING_DISTANCE, $moves, $piece, $color_to_move, $board, $store_board_in_moves,0,1,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover,FALSE);
						}// Set $king here so castling function can use it later.
					else if($get_FullMover==false)
						$moves = self::add_slide_and_slidecapture_moves_to_moves_list(self::KING_DIRECTIONS, 1, $moves, $piece, $color_to_move, $board, $store_board_in_moves,0,1,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover,FALSE);
					//	
					$SPY = $piece;
				} elseif (($piece->type == ChessPiece::GODMAN) &&($naard_can_move ==true)){
					$moves = self::add_slide_and_slidecontroller_moves_to_moves_list(self::GENERAL_DIRECTIONS,self::MAX_SLIDING_DISTANCE, $moves, $piece, $color_to_move, $board, $store_board_in_moves,true,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover,FALSE);
					$GODMAN = $piece;
				}
			}
		}
		
		if ( $need_perfect_move_list ) {
			if ($king!=null) {
				//$moves = self::eliminate_king_in_check_moves($king, $moves, $color_to_move);
			}
			else if($king==null){
				$moves = null;	$moves = array();
				return $moves;
			}
		}
		
		if ( $need_perfect_notation ) {
			self::clarify_ambiguous_pieces($moves, $color_to_move, $board);			
			//self::mark_checks_and_checkmates($moves, $color_to_move);			
			$moves = self::sort_moves_alphabetically($moves);
		}
		
		return $moves;
	}
	
	static function sort_moves_alphabetically(array $moves): array {
		if ( ! $moves ) {
			return $moves;
		}
		foreach ( $moves as $move ) {
			$temp_array[$move->get_notation()] = $move;
		}
		
		ksort($temp_array);
		return $temp_array;
	}
	
	// Return format is the FIRST DUPLICATE. The second duplicate is deleted.
	// It keeps the original key intact.
	static function get_duplicates(array $array): array {
		return array_unique(array_diff_assoc($array, array_unique($array)));
	}
	
	// Returns void. Just modifies the ChessMoves in the $moves array by reference.
	static function clarify_ambiguous_pieces(array $moves, $color_to_move, ChessBoard $board): void {
		// For GENERALs, rooks, bishops, and knights
		foreach ( self::PROMOTION_PIECES as $type ) {
			// Create list of ending squares that this type of piece can move to
			$ending_squares = array();
			foreach ( $moves as $move ) {//if(ending_squares[])==b5
				$pushed="";
				if ( $move->piece_type == $type ) {
					$pushed="";
					if(($move->board->board[$move->ending_square->rank][$move->ending_square->file]!=null) &&(($move->board->board[$move->ending_square->rank][$move->ending_square->file]->selfpushedpiece!=null)  && 
					($move->board->board[$move->ending_square->rank][$move->ending_square->file]->selfpushed==true)))
						$pushed="p";
					$ending_squares[] = $move->ending_square->get_alphanumeric().$pushed;
				}
			}
			
			// Isolate the duplicate squares
			$duplicates = self::get_duplicates($ending_squares);
			
			foreach ( $moves as $move ) {
				if ( $move->piece_type != $type ) {
					continue;
				}
				/* if(($move->starting_square->rank==5) && ($move->starting_square->file==1))
				$ttt=1;*/
				if ( ! in_array($move->ending_square->get_alphanumeric(), $duplicates) ) {
					continue;
				}
				
				$pieces_on_same_rank = $board->count_pieces_on_rank($move->piece_type, $move->starting_square->rank, $color_to_move);
				$pieces_on_same_file = $board->count_pieces_on_file($move->piece_type, $move->starting_square->file, $color_to_move);
				
				if ( $pieces_on_same_rank > 1 && $pieces_on_same_file > 1 ) {
					// TODO: This isn't perfect. If GENERALs on a8, c8, a6, the move Q8a7 will display as
					// Qa8a7, even though the GENERAL on c8 can't move there. To fix, we probably have to
					// generate a legal move list for each piece.
					$move->disambiguation = $move->starting_square->get_alphanumeric();
				} elseif ( $pieces_on_same_rank > 1 ) {
					$move->disambiguation = $move->starting_square->get_file_letter();
				} elseif ( $pieces_on_same_file > 1 ) {
					$move->disambiguation = $move->starting_square->rank;
				}
			}
		}
	}

	static function square_surrounded_by_anyone(
		ChessSquare $starting_square,
		int $y_delta,int $x_delta,
		$color_to_move,
		ChessBoard $board
	): ?ChessSquare {
		$rank = $starting_square->rank + $y_delta;
		$file = $starting_square->file + $x_delta;
		$minrank=1; $maxrank=8;

		//All royals are exposed in CASTLE.	
		//Proxy Neighbours as CASTLE and WAR are mixed.
		if((($color_to_move==1)&&($board->whitecanfullmoveinfoecastle==1)) || (($color_to_move==2)&&($board->blackcanfullmoveinowncastle==1))){
			$maxrank=9;
		}

		if((($color_to_move==1)&&($board->whitecanfullmoveinowncastle==1)) || (($color_to_move==2)&&($board->blackcanfullmoveinfoecastle==1))){
			$minrank=0;
		}

		$ending_square = self::try_to_make_square_using_rank_and_file_num($rank, $file);

		if ($ending_square) {
			if(($starting_square->file==0)||($starting_square->file==9)){
				if(($starting_square->rank>=$minrank)&&($starting_square->rank<=$maxrank)&&($ending_square->file!=$starting_square->file))
				{//Non-truce zone endpoint but Royal is in Truce-Zone. return
				return null;
				}
			}
		}

		if (!$ending_square) {
			return null;
		} else {
			//Defective.... Check if the WAr-Zone and CASTLE are Mixed.  Incomplete ....
			if ((($starting_square->rank>=$minrank)&&($starting_square->rank<=$maxrank) && ($starting_square->file>=1) && ($starting_square->file<=8)&&
			($ending_square->rank>=$minrank)&&($ending_square->rank<=$maxrank) && ($ending_square->file>=1) && ($ending_square->file<=8))) //Check within War Zone
			{
				if ($board->board[$rank][$file]) {
					if ($board->board[$rank][$file]->color == $color_to_move)
					{
						 //*echo ' Ending square contains a friendly General ';*/
						return $ending_square;
					}
					else
						$ending_square=null;
				}
				else
				  $ending_square=null;
			}
			else
				$ending_square=null;

		}
		return $ending_square;
	}

	static function square_surrounded_by_officers(
		ChessSquare $starting_square,
		int $y_delta,int $x_delta,
		$color_to_move,
		ChessBoard $board
	): ?ChessSquare {

		$rank = $starting_square->rank + $y_delta;
		$file = $starting_square->file + $x_delta;
		$minrank=1; $maxrank=8;

		//All royals are exposed in CASTLE.	
		//Proxy Neighbours as CASTLE and WAR are mixed.
		if((($color_to_move==1)&&($board->whitecanfullmoveinfoecastle==1)) || (($color_to_move==2)&&($board->blackcanfullmoveinowncastle==1))){
			$maxrank=9;
		}

		if((($color_to_move==1)&&($board->whitecanfullmoveinowncastle==1)) || (($color_to_move==2)&&($board->blackcanfullmoveinfoecastle==1))){
			$minrank=0;
		}

		$ending_square = self::try_to_make_square_using_rank_and_file_num($rank, $file);

		if ($ending_square) {
			if(($starting_square->file==0)||($starting_square->file==9)){
				if(($starting_square->rank>=$minrank)&&($starting_square->rank<=$maxrank)&&($ending_square->file!=$starting_square->file))
				{//Non-truce zone endpoint but Royal is in Truce-Zone. return
				return null;
				}
			}
		}

		if (!$ending_square) {
			return null;
		} else {
			//Defective.... Check if the WAr-Zone and CASTLE are Mixed.  Incomplete ....
			if ((($starting_square->rank>=$minrank)&&($starting_square->rank<=$maxrank) && ($starting_square->file>=1) && ($starting_square->file<=8)&&
			($ending_square->rank>=$minrank)&&($ending_square->rank<=$maxrank) && ($ending_square->file>=1) && ($ending_square->file<=8))) //Check within War Zone
			{
				if ($board->board[$rank][$file]) {
					if ( (($board->board[$rank][$file]->color == $color_to_move) && ($board->board[$rank][$file]->group=='OFFICER')))
					{
						 //*echo ' Ending square contains a friendly General ';*/
						return $ending_square;
					}
					else
						$ending_square=null;
				}
				else
				  $ending_square=null;
			}
			else 
				$ending_square=null;
		}
		return $ending_square;
	}

	static function square_surrounded_by_army(
		ChessSquare $starting_square,
		int $y_delta,int $x_delta,
		$color_to_move,
		ChessBoard $board
	): ?ChessSquare {

		$rank = $starting_square->rank + $y_delta;
		$file = $starting_square->file + $x_delta;
		$minrank=1; $maxrank=8;

		//All royals are exposed in CASTLE.
	
		if((($color_to_move==1)&&($board->whitecanfullmoveinfoecastle==1)) || (($color_to_move==2)&&($board->blackcanfullmoveinowncastle==1))){
			$maxrank=9;
		}

		if((($color_to_move==1)&&($board->whitecanfullmoveinowncastle==1)) || (($color_to_move==2)&&($board->blackcanfullmoveinfoecastle==1))){
			$minrank=0;
		}

		$ending_square = self::try_to_make_square_using_rank_and_file_num($rank, $file);

		if ($ending_square) {
			if(($starting_square->file==0)||($starting_square->file==9)){
				if(($starting_square->rank>=$minrank)&&($starting_square->rank<=$maxrank)&&($ending_square->file!=$starting_square->file))
				{//Non-truce zone endpoint but Royal is in Truce-Zone. return
				return null;
				}
			}
		}

		if (!$ending_square) {
			return null;
		} else {
			//Defective.... Check if the WAr-Zone and CASTLE are Mixed.  Incomplete ....
			if ((($starting_square->rank>=$minrank)&&($starting_square->rank<=$maxrank) && ($starting_square->file>=1) && ($starting_square->file<=8)&&
			($ending_square->rank>=$minrank)&&($ending_square->rank<=$maxrank) && ($ending_square->file>=1) && ($ending_square->file<=8))) //Check within War Zone
			{
				if ($board->board[$rank][$file]) {
					if ( (($board->board[$rank][$file]->color == $color_to_move) && (($board->board[$rank][$file]->group=='OFFICER')||($board->board[$rank][$file]->group=='SOLDIER'))))
					{
						 //*echo ' Ending square contains a friendly General ';*/
						return $ending_square;
					}
					else
						$ending_square=null;

				}
				else
				  $ending_square=null;
			}
			else 
				$ending_square=null;
		}
		return $ending_square;
	}

	static function square_surrounded_by_nonroyals_and_naarad(
		ChessSquare $starting_square,
		int $y_delta,int $x_delta,
		$color_to_move,
		ChessBoard $board
	): ?ChessSquare {
	
		$rank = $starting_square->rank + $y_delta;
		$file = $starting_square->file + $x_delta;
		$minrank=1; $maxrank=8;

		//All royals are exposed in CASTLE.
		//Proxy Neighbours as CASTLE and WAR are mixed.
		if((($color_to_move==1)&&($board->bbrokencastle==true)) || (($color_to_move==2)&&($board->bbrokencastle==true))){
			$maxrank=9;
		}

		if((($color_to_move==1)&&($board->wbrokencastle==true)) || (($color_to_move==2)&&($board->wbrokencastle==true))){
			$minrank=0;
		}

		$ending_square = self::try_to_make_square_using_rank_and_file_num($rank, $file);

		if ($ending_square) {
			if(($starting_square->file==0)||($starting_square->file==9)){
				if(($starting_square->rank>=$minrank)&&($starting_square->rank<=$maxrank)&&($ending_square->file!=$starting_square->file))
				{//Non-truce zone endpoint but Royal is in Truce-Zone. return
				return null;
				}
			}

			//No-one Cannot enter uncompromised own CASTLE with lone effort.
			if((($starting_square->rank==8)&&($ending_square->rank==9)&&(($color_to_move==2)&&($board->bbrokencastle==false)))||
			(($starting_square->rank==1)&&($ending_square->rank==0)&&(($color_to_move==1)&&($board->wbrokencastle==false)))){
				return null;
			}
		}

		if (!$ending_square) {
			return null;
		} else {
			//Defective.... Check if the WAr-Zone and CASTLE are Mixed.  Incomplete ....
			if ((($starting_square->rank>=$minrank)&&($starting_square->rank<=$maxrank) && ($starting_square->file>=1) && ($starting_square->file<=8)&&
			($ending_square->rank>=$minrank)&&($ending_square->rank<=$maxrank) && ($ending_square->file>=1) && ($ending_square->file<=8))) //Check within War Zone
			{
				if ($board->board[$rank][$file]) {
					if ( (($board->board[$rank][$file]->color == $color_to_move) && ($board->board[$rank][$file]->type==ChessPiece::GENERAL)))
					{
						 //*echo ' Ending square contains a friendly General ';*/
						//Check if general is elevated
						if($board->gametype==1) 
						return $ending_square;
						else if((($board->elevatedbs==true) && ($color_to_move==2)) || (($board->elevatedws==true) && ($color_to_move==1))) 
						return $ending_square;
						elseif( (($board->elevatedbs==false) && ($color_to_move==2)) || (($board->elevatedws==false) && ($color_to_move==1))) 
						return null;
					}
					elseif (($board->board[$rank][$file]->color == $color_to_move) && ( (($starting_square->rank==0)&&($color_to_move==1)&&($board->whitecanfullmoveinowncastle==1)) || 
					(($starting_square->rank==9)&&($color_to_move==2)&&($board->blackcanfullmoveinowncastle==1))  ))
						return $ending_square;
					//Ending Block is neighhbour to its own compromised castle
					elseif (($board->board[$rank][$file]->color == $color_to_move) && ( (($ending_square->rank==0)&&($ending_square->file>0)&&($ending_square->file<9)&&($starting_square->rank==1)&&($color_to_move==1)&&($board->blackcanfullmoveinfoecastle==1)) || 
						(($ending_square->rank==9)&&($starting_square->rank==8)&&($ending_square->file>0)&&($ending_square->file<9)&&($color_to_move==2)&&($board->whitecanfullmoveinfoecastle==1))  ))
							return $ending_square;
					elseif( (($board->board[$rank][$file]->color == $color_to_move) && (($board->board[$rank][$file]->group=='SOLDIER')||($board->board[$rank][$file]->group=='OFFICER'))))
					{
						 //*echo ' Ending square contains a friendly Royal or Semiroyal ';*/
						return $ending_square;
					}
					else
						$ending_square=null;
				}
				else
				  $ending_square=null;
			}
			else if ((($ending_square->rank==7)&&($starting_square->rank==8) && ($starting_square->file==0) && 	($ending_square->file==0))||
			(($ending_square->rank==7)&&($starting_square->rank==8) && ($starting_square->file==9) && ($ending_square->file==9))||
			(($ending_square->rank==2)&&($starting_square->rank==1) && ($starting_square->file==0) && ($ending_square->file==0))||
			(($ending_square->rank==2)&&($starting_square->rank==1) && ($starting_square->file==9) && ($ending_square->file==9))||
			(($ending_square->rank>=1)&&($starting_square->rank==($ending_square->rank)+1) && ($starting_square->file==0) && ($ending_square->file==0)&&($ending_square->rank<=7))||
			(($ending_square->rank<=8)&&($starting_square->rank==($ending_square->rank)-1) && ($starting_square->file==0) && ($ending_square->file==0)&&($ending_square->rank>=2))||
			(($ending_square->rank>=1)&&($starting_square->rank==($ending_square->rank)+1) && ($starting_square->file==9) && ($ending_square->file==9)&&($ending_square->rank<=7))||
			(($ending_square->rank<=8)&&($starting_square->rank==($ending_square->rank)-1) && ($starting_square->file==9) && ($ending_square->file==9)&&($ending_square->rank>=2))
			) /* Truce Zone neighbors*/
			{
				if ($board->board[$rank][$file]) {
					if (($board->board[$rank][$file]->color == $color_to_move) && (($board->board[$rank][$file]->group=='SOLDIER')||($board->board[$rank][$file]->group=='OFFICER')))					
					{
						 //*echo ' Ending square contains a friendly General ';*/
						return $ending_square;
					}
					else 
						$ending_square=null;
				}
				else
				  $ending_square=null;
			}
			else
				$ending_square=null;
		}
		return $ending_square;
	}

	static function officer_square_surrounded_by_general_royals(
		ChessSquare $starting_square,
		int $y_delta,int $x_delta,
		$color_to_move,
		ChessBoard $board
	): ?ChessSquare {

		$rank = $starting_square->rank + $y_delta;
		$file = $starting_square->file + $x_delta;
		$minrank=1; $maxrank=8;

		//All royals are exposed in CASTLE.
		//Proxy Neighbours as CASTLE and WAR are mixed.
		if((($color_to_move==1)&&($board->bbrokencastle==true)) || (($color_to_move==2)&&($board->bbrokencastle==true))){
			$maxrank=9;
		}

		if((($color_to_move==1)&&($board->wbrokencastle==true)) || (($color_to_move==2)&&($board->wbrokencastle==true))){
			$minrank=0;
		}

		$ending_square = self::try_to_make_square_using_rank_and_file_num($rank, $file);

		if ($ending_square) {
			if(($starting_square->file==0)||($starting_square->file==9)){
				if(($starting_square->rank>=$minrank)&&($starting_square->rank<=$maxrank)&&($ending_square->file!=$starting_square->file))
				{//Non-truce zone endpoint but Royal is in Truce-Zone. return
				return null;
				}
			}

			//No-one Cannot enter uncompromised own CASTLE with lone effort.
			if((($starting_square->rank==8)&&($ending_square->rank==9)&&(($color_to_move==2)&&($board->bbrokencastle==false)))||
			(($starting_square->rank==1)&&($ending_square->rank==0)&&(($color_to_move==1)&&($board->wbrokencastle==false)))){		
				return null;
			}
		}

		if (!$ending_square) {
			return null;
		} else {
			//Defective.... Check if the WAr-Zone and CASTLE are Mixed.  Incomplete ....
			if ((($starting_square->rank>=$minrank)&&($starting_square->rank<=$maxrank) && ($starting_square->file>=1) && ($starting_square->file<=8)&&
			($ending_square->rank>=$minrank)&&($ending_square->rank<=$maxrank) && ($ending_square->file>=1) && ($ending_square->file<=8))) //Check within War Zone
			{
				if ($board->board[$rank][$file]) {
					if ( (($board->board[$rank][$file]->color == $color_to_move) && ($board->board[$rank][$file]->type==ChessPiece::GENERAL)))
					{
						 //*echo ' Ending square contains a friendly General ';*/
						//Check if general is elevated
						if($board->gametype==1) 
							return $ending_square;
						else if((($board->elevatedbs==true) && ($color_to_move==2)) || (($board->elevatedws==true) && ($color_to_move==1))) 
							return $ending_square;
						elseif( (($board->elevatedbs==false) && ($color_to_move==2)) || (($board->elevatedws==false) && ($color_to_move==1))) 
							return null;
					}
					elseif (($board->board[$rank][$file]->color == $color_to_move) && ( (($starting_square->rank==0)&&($color_to_move==1)&&($board->whitecanfullmoveinowncastle==1)) || 
					(($starting_square->rank==9)&&($color_to_move==2)&&($board->blackcanfullmoveinowncastle==1))  ))
						return $ending_square;
					//Ending Block is neighhbour to its own compromised castle
					elseif (($board->board[$rank][$file]->color == $color_to_move) && ( (($ending_square->rank==0)&&($ending_square->file>0)&&($ending_square->file<9)&&($starting_square->rank==1)&&($color_to_move==1)&&($board->blackcanfullmoveinfoecastle==1)) || 
						(($ending_square->rank==9)&&($starting_square->rank==8)&&($ending_square->file>0)&&($ending_square->file<9)&&($color_to_move==2)&&($board->whitecanfullmoveinfoecastle==1))  ))
							return $ending_square;
					elseif( (($board->board[$rank][$file]->color == $color_to_move) && (($board->board[$rank][$file]->group=='ROYAL')||($board->board[$rank][$file]->group=='SEMIROYAL'))))
					{
						 //*echo ' Ending square contains a friendly Royal or Semiroyal ';*/
						return $ending_square;
					}
					else
						$ending_square=null;
				}
				else
				  $ending_square=null;
			}
			else if ((($ending_square->rank==7)&&($starting_square->rank==8) && ($starting_square->file==0) && 	($ending_square->file==0))||
			(($ending_square->rank==7)&&($starting_square->rank==8) && ($starting_square->file==9) && ($ending_square->file==9))||
			(($ending_square->rank==2)&&($starting_square->rank==1) && ($starting_square->file==0) && ($ending_square->file==0))||
			(($ending_square->rank==2)&&($starting_square->rank==1) && ($starting_square->file==9) && ($ending_square->file==9))||
			(($ending_square->rank>=1)&&($starting_square->rank==($ending_square->rank)+1) && ($starting_square->file==0) && ($ending_square->file==0)&&($ending_square->rank<=7))||
			(($ending_square->rank<=8)&&($starting_square->rank==($ending_square->rank)-1) && ($starting_square->file==0) && ($ending_square->file==0)&&($ending_square->rank>=2))||
			(($ending_square->rank>=1)&&($starting_square->rank==($ending_square->rank)+1) && ($starting_square->file==9) && ($ending_square->file==9)&&($ending_square->rank<=7))||
			(($ending_square->rank<=8)&&($starting_square->rank==($ending_square->rank)-1) && ($starting_square->file==9) && ($ending_square->file==9)&&($ending_square->rank>=2))
			) /* Truce Zone neighbors*/
			{
				if ($board->board[$rank][$file]) {
					if (($board->board[$rank][$file]->color == $color_to_move) && ($board->board[$rank][$file]->type==ChessPiece::GENERAL))
					{
						 //*echo ' Ending square contains a friendly General ';*/
						return $ending_square;
					}
					else 
						$ending_square=null;
				}
				else
				  $ending_square=null;
			}
			else
				$ending_square=null;
		}
		return $ending_square;
	}

	static function check_general_royal_neighbours_promotion( /**/
		array $directions_list,
		ChessPiece $piece,
		$color_to_move,
		ChessBoard $board
	): bool {
		$ending_square=null;
		foreach ( $directions_list as $direction ) {
				$current_xy = self::DIRECTION_OFFSETS[$direction];
				$current_xy[0] *= 1;
				$current_xy[1] *= 1;
				$type=0;
				$ending_square = self::officer_square_surrounded_by_general_royals(
					$piece->square,
					$current_xy[0],
					$current_xy[1],
					$color_to_move,
					$board
				);
				if(!$ending_square)
				{ continue;
				}
				if($ending_square!=null)
				{
					return TRUE;
				}
			}
		if(!$ending_square)
		{ return FALSE;
		}
		else
			return TRUE;
	}

	static function has_opponent_neighbours( /**/
		array $directions_list,
		ChessPiece $piece,
		$color_to_move,
		ChessBoard $board
	): bool {
		$ending_square=null;
		foreach ( $directions_list as $direction ) {
				$current_xy = self::DIRECTION_OFFSETS[$direction];
				$current_xy[0] *= 1;
				$current_xy[1] *= 1;
				$type=0;
				$ending_square = self::square_surrounded_by_army(
					$piece->square,
					$current_xy[0],
					$current_xy[1],
					$color_to_move,
					$board
				);
				if(!$ending_square)
				{ continue;
				}
				if($ending_square!=null)
				{
					return TRUE;
				}
			}
		if(!$ending_square)
		{ return FALSE;
		}
		else
			return TRUE;
	}

	static function check_trapped_piece( /**/
		$piece,
		$color_to_move,
		ChessBoard $board,
		$condition
	): void {
	$ending_square=null;
	$pushed_square=null;
	$knightdirections_list=null;
	$directions_list=null;
	$self_directions=null;
	$newpiece=null;
	if(($piece->color==$color_to_move) && ($piece->striker==1)){
		if($piece->type==ChessPiece::GENERAL){
			$self_directions=null; //we will focus on jumping directions later
		}
		if($piece->type==ChessPiece::KING){
				$self_directions=null; //we will focus on jumping directions later
			}
		if($piece->type==ChessPiece::PAWN){
			$self_directions=null; //we will focus on jumping directions later
		}
		if($piece->type==ChessPiece::KNIGHT){
			$self_directions=null; //we will focus on jumping directions later
		}
		//else
		//{
			if(($piece->square->rank==1) && ($piece->square->file==8)){
				$self_directions=self::RBottom_DIRECTIONS;
				}
			else if(($piece->square->rank==1) && ($piece->square->file==1)){
				$self_directions=self::LBottom_DIRECTIONS;
				}
			else if(($piece->square->rank==8) && ($piece->square->file==8)){
				$self_directions=self::RTop_DIRECTIONS;
				}
			else if(($piece->square->rank==8) && ($piece->square->file==1)){
				$self_directions=self::LTop_DIRECTIONS;
				}
			else if(($piece->square->rank==1) && ($piece->square->file>1)&&($piece->square->file<8)){
				$self_directions=self::Bottom_DIRECTIONS;
				}
			else if(($piece->square->rank==8) && ($piece->square->file>1)&&($piece->square->file<8)){
				$self_directions=self::Top_DIRECTIONS;
				}
			else if(($piece->square->file==1) && ($piece->square->rank>1)&&($piece->square->rank<8)){
				$self_directions=self::L_DIRECTIONS;
				}
			else if(($piece->square->file==8) && ($piece->square->rank>1)&&($piece->square->rank<8)){
				$self_directions=self::R_DIRECTIONS;
				}
			else if(($piece->square->file>1) && ($piece->square->file<8) && ($piece->square->rank>1)&&($piece->square->rank<8)){
				$self_directions=self::MID_DIRECTIONS;
				}

			//else if(($piece->square->file>1) && ($piece->square->file<8)&& ($piece->square->rank>1)&&($piece->square->rank<8)){
				//$self_directions=self::ALL_DIRECTIONS;
			//}
		//}

		if($self_directions!=null){
			$pushed_square=null;
			$pushed_y=-1;
			$pushed_x=-1;

			foreach ( $self_directions	as $direction ) {
				$ending_square=null;
				$pushed_x=-1;
				$pushed_y=-1;
				$current_xy = self::DIRECTION_OFFSETS[$direction];
				$ending_square = self::try_to_make_square_using_rank_and_file_num($piece->square->rank+$current_xy[0], $piece->square->file+$current_xy[1]);
				
				if(!$ending_square)
				{ 
					continue;
				}
					$newpiece=$board->board[$ending_square->rank][$ending_square->file];
				$ending_square=null;
				$knightdirections_list=null;
				if($newpiece==null) //only opponent
					continue;
				if($newpiece->color==$piece->color)
					continue;

				/* Left to Right move */
				if( ($newpiece->square->rank==$piece->square->rank) && ($newpiece->square->file==$piece->square->file+1)) 
					{
						$pushed_x=$newpiece->square->file+1;
						$pushed_y=$newpiece->square->rank;
					}
				/* Right to Left move */
				else if( ($newpiece->square->rank==$piece->square->rank) && ($newpiece->square->file==$piece->square->file-1)) 
					{
						$pushed_x=$newpiece->square->file-1;
						$pushed_y=$newpiece->square->rank;
					}

				/* Bottom to Top move */
				else if( ($newpiece->square->rank==$piece->square->rank+1) && ($newpiece->square->file==$piece->square->file)) 
					{
						$pushed_x=$newpiece->square->file;
						$pushed_y=$newpiece->square->rank+1;
					}

				/* Top to Bottom move */
				else if( ($newpiece->square->rank==$piece->square->rank-1) && ($newpiece->square->file==$piece->square->file)) 
					{
						$pushed_x=$newpiece->square->file;
						$pushed_y=$newpiece->square->rank-1;
					}

				/* Bottom diagonal to Top diagonal Left to Right move */
				else if( ($newpiece->square->rank==$piece->square->rank+1) && ($newpiece->square->file==$piece->square->file+1)) 
					{
						$pushed_x=$newpiece->square->file+1;
						$pushed_y=$newpiece->square->rank+1;
					}

				/* Bottom diagonal to Top diagonal Right to Left move */
				else if( ($newpiece->square->rank==$piece->square->rank+1) && ($newpiece->square->file==$piece->square->file-1)) 
					{
						$pushed_x=$newpiece->square->file-1;
						$pushed_y=$newpiece->square->rank+1;
					}
										
				/* Top to Bottom move Left to Right move */
				else if( ($newpiece->square->rank==$piece->square->rank-1) && ($newpiece->square->file==$piece->square->file+1)) 
					{
						$pushed_x=$newpiece->square->file+1;
						$pushed_y=$newpiece->square->rank-1;
					}

				/* Top to Bottom move Right to Left move */
				else if( ($newpiece->square->rank==$piece->square->rank-1) && ($newpiece->square->file==$piece->square->file-1)) 
					{
						$pushed_x=$newpiece->square->file-1;
						$pushed_y=$newpiece->square->rank-1;
					}

				if(($pushed_y<=-1)||($pushed_x<=-1)||($pushed_y>=10)||($pushed_x>=10)){
					$pushed_square=null;
				}
				else
					$pushed_square = self::try_to_make_square_using_rank_and_file_num($pushed_y, $pushed_x);
				
				if(!$pushed_square)
					{
						continue;
					}
				
				/*if($board->board[ $newpiece->square->rank][ $newpiece->square->file]==null)
					$ttt=1;
				if($board->board[ $piece->square->rank][ $piece->square->file]==null)
					$ttt=1;
				*/

					$officerp=self::check_officers_neighbours( /**/
						self::KING_DIRECTIONS,
						$board->board[ $newpiece->square->rank][ $newpiece->square->file],
						abs(3-$color_to_move),
						$board,
						'exclude'
					);
				
				$checkpinnedrefugees=self::checkpinnedrefugees($color_to_move,$board, $newpiece->square,$newpiece->square)==false;
				if( ($officerp==false) && ($board->board[ $newpiece->square->rank][ $newpiece->square->file]->type=="13") &&($checkpinnedrefugees==false)){
						$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpushed=true;
						$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpushedsquare=array ("rank"=>$pushed_square->rank, "file"=>$pushed_square->file);
						$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpushedpiece=clone $newpiece;
						$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpusher=true;
						$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpushersquare=array ("rank"=>$piece->square->rank, "file"=>$piece->square->file);
						$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpusherpiece=clone $piece;
						$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selftrapped=true;
						$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpushersquare=array ("rank"=>$piece->square->rank, "file"=>$piece->square->file);

					continue;
				}

				if(($piece!=null)&&($board->board[ $pushed_square->rank][ $pushed_square->file]!=null)&&
				(($pushed_y<=0)||($pushed_x<=0)||($pushed_y>=9)||($pushed_x>=9))){
						$royalp=false;
							$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selftrapped=true;
							$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpushed=false;
							$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpushedsquare=null;//
							$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpushedpiece=null;//;
							$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpusher=true;
							$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpushersquare=array ("rank"=>$piece->square->rank, "file"=>$piece->square->file);
							$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpusherpiece=clone $piece;
						
					}
				else if(($piece!=null)&&($board->board[ $pushed_square->rank][ $pushed_square->file]!=null)){
					$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpushed=false;
					$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpushedsquare=null;
					$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpushedpiece=null;
					$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpusher=null;
					$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpushersquare=null;
					$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpusherpiece=null;
				}
				
				if( ($piece!=null)&&($board->board[ $pushed_square->rank][ $pushed_square->file]!=null) &&
					( $board->board[ $newpiece->square->rank][ $newpiece->square->file]->type<$board->board[ $piece->square->rank][ $piece->square->file]->type)){
					$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selftrapped=true;
					}
				else if( ($board->board[ $pushed_square->rank][ $pushed_square->file]!=null) &&
					( $board->board[ $newpiece->square->rank][ $newpiece->square->file]->type>=$board->board[ $pushed_square->rank][ $pushed_square->file]->type)){
					$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selftrapped=true;
					}
				else if($board->board[ $pushed_square->rank][ $pushed_square->file]==null){
					if(($pushed_y<=0)||($pushed_x<=0)||($pushed_y>=9)||($pushed_x>=9)){
						$royalp=false;
						//if($board->board[ $newpiece->square->rank][ $newpiece->square->file]->type==ChessPiece::ROOK)
						if(($board->board[ $newpiece->square->rank][ $newpiece->square->file]->group=="OFFICER")
						||(strpos($board->board[ $newpiece->square->rank][ $newpiece->square->file]->group,"ROYAL")!==FALSE))//Can be Royal also
							{
							/*$royalp=self::check_royal_neighbours(
								self::KING_DIRECTIONS,
								$board->board[ $newpiece->square->rank][ $newpiece->square->file],
								abs(3-$color_to_move),
								$board,
								"Zone"
							);
							*/

							$royalp=self::check_general_royal_neighbours_promotion( /**/
								self::KING_DIRECTIONS,
								$board->board[ $newpiece->square->rank][ $newpiece->square->file],
								abs(3-$color_to_move),
								$board
							);
						}

						if($royalp==true) {
							$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selftrapped=false;
							$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpushed=true;
							$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpushedsquare=array ("rank"=>$pushed_square->rank, "file"=>$pushed_square->file);
							$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpushedpiece=clone $newpiece;
							$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpusher=true;
							$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpushersquare=array ("rank"=>$piece->square->rank, "file"=>$piece->square->file);
							$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpusherpiece=clone $piece;
						}
						else{
							$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selftrapped=true;
							$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpushed=false;
							$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpushedsquare=null;//
							$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpushedpiece=null;//;
							$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpusher=true;
							$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpushersquare=array ("rank"=>$piece->square->rank, "file"=>$piece->square->file);
							$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpusherpiece=clone $piece;
						}
					}
					else if($board->board[$pushed_square->rank][$pushed_square->file]==null){
						/*if(($newpiece->square->rank==5) &&( $newpiece->square->file==1)
						&& ($piece->square->rank==4) &&( $piece->square->file==1))
							$test=1;*/
						
						$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selftrapped=false;
						$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpushed=true;
						$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpushedsquare=array ("rank"=>$pushed_square->rank, "file"=>$pushed_square->file);
						$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpushedpiece=clone $newpiece;
						$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpusher=true;
						$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpushersquare=array ("rank"=>$piece->square->rank, "file"=>$piece->square->file);
						$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpusherpiece=clone $piece;

					}
				}
			}
		}
	}
		$ending_square=null;
	}

	static function check_virtual_trapped_piece( /**/
		$piece,
		$endingpiece,
		$color_to_move,
		ChessBoard $board,
		$condition
	): void {
		$pushed_square=null;

		if($piece->type==ChessPiece::GENERAL){
			$self_directions=null; //we will focus on jumping directions later
		}

		if($piece->type==ChessPiece::KNIGHT){
			$self_directions=null; //we will focus on jumping directions later
		}

				$pushed_x=-1; $pushed_y=-1;

				$ending_square=$endingpiece->square;
				$newpiece=$board->board[$ending_square->rank][$ending_square->file];
				if($newpiece==null) //only opponent
					return;
				if($newpiece->color==$piece->color)
					return;

				/* Left to Right move */
				if( ($newpiece->square->rank==$piece->square->rank) && ($newpiece->square->file==$piece->square->file+1)) 
					{
						$pushed_x=$newpiece->square->file+1;
						$pushed_y=$newpiece->square->rank;
					}
				/* Right to Left move */
				else if( ($newpiece->square->rank==$piece->square->rank) && ($newpiece->square->file==$piece->square->file-1)) 
					{
						$pushed_x=$newpiece->square->file-1;
						$pushed_y=$newpiece->square->rank;
					}

				/* Bottom to Top move */
				else if( ($newpiece->square->rank==$piece->square->rank+1) && ($newpiece->square->file==$piece->square->file)) 
					{
						$pushed_x=$newpiece->square->file;
						$pushed_y=$newpiece->square->rank+1;
					}

				/* Top to Bottom move */
				else if( ($newpiece->square->rank==$piece->square->rank-1) && ($newpiece->square->file==$piece->square->file)) 
					{
						$pushed_x=$newpiece->square->file;
						$pushed_y=$newpiece->square->rank-1;
					}

				/* Bottom diagonal to Top diagonal Left to Right move */
				else if( ($newpiece->square->rank==$piece->square->rank+1) && ($newpiece->square->file==$piece->square->file+1)) 
					{
						$pushed_x=$newpiece->square->file+1;
						$pushed_y=$newpiece->square->rank+1;
					}
				/* Bottom diagonal to Top diagonal Right to Left move */
				else if( ($newpiece->square->rank==$piece->square->rank+1) && ($newpiece->square->file==$piece->square->file-1)) 
					{
						$pushed_x=$newpiece->square->file-1;
						$pushed_y=$newpiece->square->rank+1;
					}
				/* Top to Bottom move Left to Right move */
				else if( ($newpiece->square->rank==$piece->square->rank-1) && ($newpiece->square->file==$piece->square->file+1)) 
					{
						$pushed_x=$newpiece->square->file+1;
						$pushed_y=$newpiece->square->rank-1;
					}
				/* Top to Bottom move Right to Left move */
				else if( ($newpiece->square->rank==$piece->square->rank-1) && ($newpiece->square->file==$piece->square->file-1)) 
					{
						$pushed_x=$newpiece->square->file-1;
						$pushed_y=$newpiece->square->rank-1;
					}

				if(($pushed_y<=-1)||($pushed_x<=-1)||($pushed_y>=10)||($pushed_x>=10)){
					$pushed_square=null;
				}
				else
					$pushed_square = self::try_to_make_square_using_rank_and_file_num($pushed_y, $pushed_x);
				
				if(!$pushed_square)
					{ 
						return;
					}
				
				//if Junior is striking Senior
				if( ($board->board[ $pushed_square->rank][ $pushed_square->file]!=null)&&
					( $board->board[ $newpiece->square->rank][ $newpiece->square->file]->type>=$board->board[ $pushed_square->rank][ $pushed_square->file]->type)){
					$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selftrapped=true;
					}
				else if($board->board[ $pushed_square->rank][ $pushed_square->file]==null){
					if(($pushed_y<=0)||($pushed_x<=0)||($pushed_y>=9)||($pushed_x>=9)){
						$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selftrapped=true;
					}
					else if($board->board[$pushed_square->rank][$pushed_square->file]==null){//if senior is striking then selftrapped=true;
						$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selftrapped=false;
						$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpushed=true;
						$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpushedsquare=array ("rank"=>$pushed_square->rank, "file"=>$pushed_square->file);
						$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpushedpiece=clone $newpiece;
						$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpusher=true;
						$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpushersquare=array ("rank"=>$piece->square->rank, "file"=>$piece->square->file);
						$board->board[ $newpiece->square->rank][ $newpiece->square->file]->selfpusherpiece=clone $piece;
					}
				}

	$ending_square=null;
	}

	static function check_uncontrolled_officers_neighbours( /**/
		array $directions_list,
		ChessPiece $piece,
		$color_to_move,
		ChessBoard $board,
		$condition,
		$controlledpiece
		): bool {
		$ending_square=null;
		$uncontrolledofficers=false;
		foreach ( $directions_list as $direction ) {
				$current_xy = self::DIRECTION_OFFSETS[$direction];
				$current_xy[0] *= 1;
				$current_xy[1] *= 1;
				$type=0;
				$ending_square = self::square_surrounded_by_officers(
					$piece->square,
					$current_xy[0],
					$current_xy[1],
					$color_to_move,
					$board
				);
				if(!$ending_square)
				{ continue;
				}
				if($ending_square!=null)
				{
					///General is stuck so pawns it is Not free to instruct the stucked army. Army can listen to other officers

					if(($piece->controlledpiece==true)&&($controlledpiece==true)&&  ($board->board[$ending_square->rank][$ending_square->file]->group=="OFFICER")
					&&($board->board[$ending_square->rank][$ending_square->file]->controlledpiece==true)&& ($uncontrolledofficers==false))
						{ $uncontrolledofficers=false; continue; }
					else if(($piece->controlledpiece==true)&&($controlledpiece==true)&&  ($board->board[$ending_square->rank][$ending_square->file]->group=="OFFICER")
						&&($board->board[$ending_square->rank][$ending_square->file]->controlledpiece==false))
							{ $uncontrolledofficers=true; return TRUE; }

					else if(($condition=='exclude')&&(self::checkpinnedrefugees($color_to_move,$board, $ending_square,$ending_square)==true))
						continue;
					return TRUE;
				}
			}
		return $uncontrolledofficers;
	}

	static function check_officers_neighbours( /**/
		array $directions_list,
		ChessPiece $piece,
		$color_to_move,
		ChessBoard $board,
		$condition	): bool {
		$ending_square=null;
		$pawncanmove=true;
		foreach ( $directions_list as $direction ) {
				$current_xy = self::DIRECTION_OFFSETS[$direction];
				$current_xy[0] *= 1;
				$current_xy[1] *= 1;
				$type=0;
				$ending_square = self::square_surrounded_by_officers(
					$piece->square,
					$current_xy[0],
					$current_xy[1],
					$color_to_move,
					$board
				);
				if(!$ending_square)
				{ continue;
				}
				if($ending_square!=null)
				{
					if(($condition=='exclude')&&(self::checkpinnedrefugees($color_to_move,$board, $ending_square,$ending_square)==true))
						continue;
					return TRUE;
				}
			}
		if(!$ending_square)
		{		return FALSE;
		}
		else
		return TRUE;
	}

	static function royal_square_surrounded_by_royals(
		ChessSquare $actual_square,
		ChessSquare $starting_square,
		int $y_delta,int $x_delta,
		$color_to_move,
		ChessBoard $board,
		bool $sameplace,
		string $check_neighbour_type
	): ?ChessSquare
	{
		$rank = $starting_square->rank + $y_delta;
		$file = $starting_square->file + $x_delta;
		$ending_square = self::try_to_make_square_using_rank_and_file_num($rank, $file);
		if (($sameplace==TRUE)&&($ending_square)){
				if(($actual_square->rank==$ending_square->rank)&& ($actual_square->file==$ending_square->file)){
					return null;
			}
		}

		if ($ending_square) {

			/*if(($ending_square->file==0) &&($ending_square->rank==7))
			{ $ttt=1; }*/

			if (($starting_square->rank==0) &&($starting_square->file==5) && ($ending_square->rank==0)&&($ending_square->file==4)) {
				$starting_square=$starting_square;
			}

			if(($starting_square->file==0)||($starting_square->file==9)){
				if(($starting_square->rank>=1)&&($starting_square->rank<=8)&&($ending_square->file!=$starting_square->file))
				{//Non-truce zone endpoint but Royal is in Truce-Zone. return
				return null;
				}
				else
					$rank;
			}
		}

		if (!$ending_square) {
			return null;
		} else {
			if ((($ending_square->rank==0)&&($starting_square->rank==0) && ($starting_square->file>=1) && ($starting_square->file<=8)&&
			($ending_square->file>=1) && ($ending_square->file<=8))||(($ending_square->rank==9)&&($starting_square->rank==9) && 
			($starting_square->file>=1) && ($starting_square->file<=8)&&($ending_square->file>=1) && ($ending_square->file<=8))||
			(($starting_square->rank>=1)&&($starting_square->rank<=8) && ($starting_square->file>=1) && ($starting_square->file<=8)&&
			($ending_square->rank>=1)&&($ending_square->rank<=8) && ($ending_square->file>=1) && ($ending_square->file<=8))) 
			{
				if ($board->board[$rank][$file]) {
					if (($board->board[$rank][$file]->color == $color_to_move) && (($board->board[$rank][$file]->group=='ROYAL')||($board->board[$rank][$file]->group=='SEMIROYAL')))
					{
						 //*echo ' Ending square contains a friendly royal ';*/
						return $ending_square;
					}
					else
						$ending_square=null;
				}
				else
				  $ending_square=null;
			}
			else if ((($ending_square->rank==7)&&($starting_square->rank==8) && ($starting_square->file==0) && 	($ending_square->file==0))||
			(($ending_square->rank==7)&&($starting_square->rank==8) && ($starting_square->file==9) && ($ending_square->file==9))||
			(($ending_square->rank==2)&&($starting_square->rank==1) && ($starting_square->file==0) && ($ending_square->file==0))||
			(($ending_square->rank==2)&&($starting_square->rank==1) && ($starting_square->file==9) && ($ending_square->file==9))||
			(($ending_square->rank>=1)&&($starting_square->rank==($ending_square->rank)+1) && ($starting_square->file==0) &&	($ending_square->file==0)&&($ending_square->rank<=7))||
			(($ending_square->rank<=8)&&($starting_square->rank==($ending_square->rank)-1) && ($starting_square->file==0) && ($ending_square->file==0)&&($ending_square->rank>=2))||
			(($ending_square->rank>=1)&&($starting_square->rank==($ending_square->rank)+1) && ($starting_square->file==9) && ($ending_square->file==9)&&($ending_square->rank<=7))||
			(($ending_square->rank<=8)&&($starting_square->rank==($ending_square->rank)-1) && ($starting_square->file==9) && ($ending_square->file==9)&&($ending_square->rank>=2))
			) 
			{
				if ($board->board[$rank][$file]) {
					if (($board->board[$rank][$file]->color == $color_to_move) && (($board->board[$rank][$file]->group=='ROYAL')||($board->board[$rank][$file]->group=='SEMIROYAL')))
					{
						 //*echo ' Ending square contains a friendly royal ';*/
						return $ending_square;
					}
					else 
						$ending_square=null;
				}
				else
				  $ending_square=null;
			}
			else
				$ending_square=null;
		}
		
		return $ending_square;
	}

	static function square_surrounded_by_general(
		ChessSquare $actual_square,
		ChessSquare $starting_square,
		int $y_delta,int $x_delta,
		$color_to_move,
		ChessBoard $board,
		bool $sameplace
	): ?ChessSquare 
	{
		$rank = $starting_square->rank + $y_delta;
		$file = $starting_square->file + $x_delta;

		$ending_square = self::try_to_make_square_using_rank_and_file_num($rank, $file);

		if (($sameplace==TRUE)&&($ending_square)){
				if(($actual_square->rank==$ending_square->rank)&& ($actual_square->file==$ending_square->file)){
					return null;
			}
		}

		if ($ending_square) {
			/*if(($ending_square->file==0) &&($ending_square->rank==7))
			{ $tttt=1; }*/

			if (($starting_square->rank==0) &&($starting_square->file==5) && ($ending_square->rank==0)&&($ending_square->file==4)) {
				$starting_square=$starting_square;
			}

			if(($starting_square->file==0)||($starting_square->file==9)){
				if(($starting_square->rank>=1)&&($starting_square->rank<=8)&&($ending_square->file!=$starting_square->file))
				{//Non-truce zone endpoint but Royal is in Truce-Zone. return
					return null;
				}
				else
					$rank;
			}
		}

		if (!$ending_square) {
			return null;
		} else {
			if ((($ending_square->rank==0)&&($starting_square->rank==0) && ($starting_square->file>=1) && ($starting_square->file<=8)&&
			($ending_square->file>=1) && ($ending_square->file<=8))||(($ending_square->rank==9)&&($starting_square->rank==9) && 
			($starting_square->file>=1) && ($starting_square->file<=8)&&($ending_square->file>=1) && ($ending_square->file<=8))||
			(($starting_square->rank>=1)&&($starting_square->rank<=8) && ($starting_square->file>=1) && ($starting_square->file<=8)&&
			($ending_square->rank>=1)&&($ending_square->rank<=8) && ($ending_square->file>=1) && ($ending_square->file<=8))) 
			{
				if ($board->board[$rank][$file]) {
					if (($board->board[$rank][$file]->color == $color_to_move) && (($board->board[$rank][$file]->group=='OFFICER')
					&& ($board->board[$rank][$file]->type== ChessPiece::GENERAL)))
					{
						 //*echo ' Ending square contains a friendly royal ';*/
						return $ending_square;
					}
					else
						$ending_square=null;
				}
				else
				  $ending_square=null;
			}
			else if ((($ending_square->rank==7)&&($starting_square->rank==8) && ($starting_square->file==0) && 	($ending_square->file==0))||
			(($ending_square->rank==7)&&($starting_square->rank==8) && ($starting_square->file==9) && ($ending_square->file==9))||
			(($ending_square->rank==2)&&($starting_square->rank==1) && ($starting_square->file==0) && ($ending_square->file==0))||
			(($ending_square->rank==2)&&($starting_square->rank==1) && ($starting_square->file==9) && ($ending_square->file==9))||
			(($ending_square->rank>=1)&&($starting_square->rank==($ending_square->rank)+1) && ($starting_square->file==0) &&	($ending_square->file==0)&&($ending_square->rank<=7))||
			(($ending_square->rank<=8)&&($starting_square->rank==($ending_square->rank)-1) && ($starting_square->file==0) && ($ending_square->file==0)&&($ending_square->rank>=2))||
			(($ending_square->rank>=1)&&($starting_square->rank==($ending_square->rank)+1) && ($starting_square->file==9) && ($ending_square->file==9)&&($ending_square->rank<=7))||
			(($ending_square->rank<=8)&&($starting_square->rank==($ending_square->rank)-1) && ($starting_square->file==9) && ($ending_square->file==9)&&($ending_square->rank>=2))
			) 
			{
				if ($board->board[$rank][$file]) {
					if (($board->board[$rank][$file]->color == $color_to_move) && (($board->board[$rank][$file]->group=='OFFICER')
					&& ($board->board[$rank][$file]->type== ChessPiece::GENERAL)))
					{
						 //*echo ' Ending square contains a friendly royal ';*/
						return $ending_square;
					}
					else 
						$ending_square=null;
				}
				else
				  $ending_square=null;
			}
			else
				$ending_square=null;
		}
		return $ending_square;
	}

	static function set_naarad_for_fullmoves($board){
			self::populate_opponent_neighbours($board); /**/
	}

	static function set_general_for_elevatedmoves($board):void{
		$ending_square=null;
		$generalsquare=null;
		$board->elevatedws=false;
		$board->elevatedbs=false;
		for($color=1;$color<=2;$color++){
			if($color==1)
				$generalsquare=$board->wssquare;
			elseif($color==2)
				$generalsquare=$board->bssquare;
			
				if($generalsquare==null)
				{
					if($color==1)
						$board->elevatedws=false;
					elseif($color==2)
						$board->elevatedbs=false;
					continue; // Goto next color now
				}
			foreach ( self::KING_DIRECTIONS as $direction ) {
					$current_xy = self::DIRECTION_OFFSETS[$direction];
					$current_xy[0] *= 1;
					$current_xy[1] *= 1;
					$type=0;
					$ending_square = self::officer_square_surrounded_by_general_royals	(
						$generalsquare,
						$current_xy[0],
						$current_xy[1],
						$color,
						$board
					);
					if(!$ending_square)
					{ continue;
					}
					if($ending_square!=null)
					{
						if($color==1)
							$board->elevatedws=true;
						elseif($color==2)
							$board->elevatedbs=true;
						break; // Goto external loop now
					}
				}
			}
		$color;
	}

	static function has_opponent_royal_neighbours( /**/
		array $directions_list,
		ChessSquare $actual_square,
		ChessSquare $starting_square,
		$color_to_move,
		ChessBoard $board
	): bool {
		$ending_square=null;
		foreach ( $directions_list as $direction ) {
				$current_xy = self::DIRECTION_OFFSETS[$direction];
				$current_xy[0] *= 1;
				$current_xy[1] *= 1;

				$ending_square = self::square_surrounded_by_opponent_royals(
					$actual_square,
					$starting_square,
					$current_xy[0],
					$current_xy[1],
					$color_to_move,
					$board,
					TRUE
				);
				if(!$ending_square)
				{ continue;
				}
				if($ending_square!=null)
				{
					return TRUE; //Atleast one Royal/Semi-Royal present
					//return FALSE; //Atleast one opponent Royal/Semi-Royal present
				}
			}
		if(!$ending_square)
		{ 	//return TRUE; //No Opponent Royal/Semi-Royal present
			return FALSE; //No Royal/Semi-Royal present
		}
		else
		{ 	//return TRUE; //No Opponent Royal/Semi-Royal present
			return FALSE; //No Royal/Semi-Royal present
		}
	}


static function check_opponent_neighbours(&$board,int $opponent_colors)
{
	$ending_square=null;
	$starting_square=null;
	$allpieces = null;

	if(($board->controller_color==null)||($board->controller_color!=$board->controlled_color)){
		$board->controller_color=3-$opponent_colors;
		$board->controlled_color=$opponent_colors;
	}

	if($opponent_colors==1)
		$starting_square=$board->bnsquare;

	if($opponent_colors==2)
		$starting_square=$board->wnsquare;

	foreach ( self::KING_DIRECTIONS as $direction ) {
			$current_xy = self::DIRECTION_OFFSETS[$direction];
			$current_xy[0] *= 1;
			$current_xy[1] *= 1;
			
			$ending_square = self::square_surrounded_by_army(
				$starting_square,
				$current_xy[0],
				$current_xy[1],
				$opponent_colors,
				$board
			);
			if(!$ending_square)
				{ continue;
				}
			if($ending_square!=null)
				{
				$allpieces[] = $board->board[$ending_square->rank][$ending_square->file];
				continue;
				}
		}

	if(!$allpieces)
		{
		if($opponent_colors==2) $board->PinnedBRefugees= [];
		if($opponent_colors==1) $board->PinnedWRefugees= [];
		}
	else
		{
		if(($opponent_colors==2) && ($board->whitencanfullmove==1)) $board->PinnedBRefugees= $allpieces; 
		else $board->PinnedBRefugees= [];
		if(($opponent_colors==1)  && ($board->blackncanfullmove==1)) $board->PinnedWRefugees= $allpieces;
		else $board->PinnedWRefugees= [];
		}
}

	static function populate_opponent_neighbours( $board){
		for($opponent_colors=1;$opponent_colors<=2;$opponent_colors++){	
			self::check_opponent_neighbours($board,$opponent_colors);
		}
	}

	//in future, merge this function with has_opponent_royal_neighbours

	static function square_surrounded_by_opponent_royals(
		ChessSquare $actual_square,
		ChessSquare $starting_square,
		int $y_delta,int $x_delta,
		$color_to_move,
		ChessBoard $board,
		bool $sameplace
	): ?ChessSquare 
	{
		$sameplace;
		$royalcolor=3-$color_to_move; //Revert the Color

		$rank = $starting_square->rank + $y_delta;
		$file = $starting_square->file + $x_delta;

		$ending_square = self::try_to_make_square_using_rank_and_file_num($rank, $file);

		if (($sameplace==TRUE)&&($ending_square)){
				if(($actual_square->rank==$ending_square->rank)&& ($actual_square->file==$ending_square->file)){
					return null;
			}
		}

		if ($ending_square) {

			/*if(($ending_square->file==0) &&($ending_square->rank==7))
			{ $tttt=1; 	} */

			if (($starting_square->rank==0) &&($starting_square->file==5) && ($ending_square->rank==0)&&($ending_square->file==4)) {
				$starting_square=$starting_square;
			}

			if(($starting_square->file==0)||($starting_square->file==9)){
				if(($starting_square->rank>=1)&&($starting_square->rank<=8)&&($ending_square->file!=$starting_square->file))
				{//Non-truce zone endpoint but Royal is in Truce-Zone. return
					return null;
				}
				else
					$rank;
			}
		}

		if (!$ending_square) {
			return null;
		} else {
			if ((($ending_square->rank==0)&&($starting_square->rank==0) && ($starting_square->file>=1) && ($starting_square->file<=8)&&
			($ending_square->file>=1) && ($ending_square->file<=8))||(($ending_square->rank==9)&&($starting_square->rank==9) && 
			($starting_square->file>=1) && ($starting_square->file<=8)&&($ending_square->file>=1) && ($ending_square->file<=8))||
			(($starting_square->rank>=1)&&($starting_square->rank<=8) && ($starting_square->file>=1) && ($starting_square->file<=8)&&
			($ending_square->rank>=1)&&($ending_square->rank<=8) && ($ending_square->file>=1) && ($ending_square->file<=8))) 
			{
				if ($board->board[$rank][$file]) {
					if (($board->board[$rank][$file]->color == $royalcolor) && (($board->board[$rank][$file]->group=='ROYAL')||($board->board[$rank][$file]->group=='SEMIROYAL')))
					{
						 //*echo ' Ending square contains a friendly royal ';*/
						return $ending_square;
					}
					else
						$ending_square=null;

				}
				else
				  $ending_square=null;
			}
			else if ((($ending_square->rank==7)&&($starting_square->rank==8) && ($starting_square->file==0) && 	($ending_square->file==0))||
			(($ending_square->rank==7)&&($starting_square->rank==8) && ($starting_square->file==9) && ($ending_square->file==9))||
			(($ending_square->rank==2)&&($starting_square->rank==1) && ($starting_square->file==0) && ($ending_square->file==0))||
			(($ending_square->rank==2)&&($starting_square->rank==1) && ($starting_square->file==9) && ($ending_square->file==9))||
			(($ending_square->rank>=1)&&($starting_square->rank==($ending_square->rank)+1) && ($starting_square->file==0) &&	($ending_square->file==0)&&($ending_square->rank<=7))||
			(($ending_square->rank<=8)&&($starting_square->rank==($ending_square->rank)-1) && ($starting_square->file==0) && ($ending_square->file==0)&&($ending_square->rank>=2))||
			(($ending_square->rank>=1)&&($starting_square->rank==($ending_square->rank)+1) && ($starting_square->file==9) && ($ending_square->file==9)&&($ending_square->rank<=7))||
			(($ending_square->rank<=8)&&($starting_square->rank==($ending_square->rank)-1) && ($starting_square->file==9) && ($ending_square->file==9)&&($ending_square->rank>=2))
			) 
			{
				if ($board->board[$rank][$file]) {
					if (($board->board[$rank][$file]->color == $royalcolor) && (($board->board[$rank][$file]->group=='ROYAL')||($board->board[$rank][$file]->group=='SEMIROYAL')))
					{
						 //*echo ' Ending square contains a friendly royal ';*/
						return $ending_square;
					}
					else 
						$ending_square=null;
				}
				else
				  $ending_square=null;
			}
			elseif ((($ending_square->rank==0)&&($starting_square->rank<=1) && ($starting_square->file>=1) && ($starting_square->file<=8)&&
			($ending_square->file>=1) && ($ending_square->file<=8) &&  ($board->wbrokencastle==true ))||(($ending_square->rank>=8)&&($starting_square->rank==9) && 
			($starting_square->file>=1) && ($starting_square->file<=8)&&($ending_square->file>=1) && ($ending_square->file<=8) && ($board->bbrokencastle==true ))) 
			{
				if ($board->board[$rank][$file]) {
					if (($board->board[$rank][$file]->color == $royalcolor) && (($board->board[$rank][$file]->group=='ROYAL')||($board->board[$rank][$file]->group=='SEMIROYAL')))
					{
						 //*echo ' Ending square contains a friendly royal ';*/
						return $ending_square;
					}
					else
						$ending_square=null;

				}
				else
				  $ending_square=null;
			}
			else
				$ending_square=null;
		}
		return $ending_square;
	}

	static function has_royal_neighbours( /**/
			array $directions_list,
			ChessSquare $actual_square,
			ChessSquare $starting_square,
			$color_to_move,
			ChessBoard $board
		): bool {
			$ending_square=null;
			foreach ( $directions_list as $direction ) {
					$current_xy = self::DIRECTION_OFFSETS[$direction];
					$current_xy[0] *= 1;
					$current_xy[1] *= 1;

					$ending_square = self::royal_square_surrounded_by_royals(
						$actual_square,
						$starting_square,
						$current_xy[0],
						$current_xy[1],
						$color_to_move,
						$board,
						TRUE,
						"Tight"
					);
					if(!$ending_square)
					{ continue;
					}
					if($ending_square!=null)
					{
						return TRUE;
					}
				}
			if(!$ending_square)
			{ return FALSE;
			}
			else
				return TRUE;
		}

	static function has_general_neighbour( /**/
			array $directions_list,
			ChessSquare $actual_square,
			ChessSquare $starting_square,
			$color_to_move,
			ChessBoard $board
		): bool {
			$ending_square=null;
			foreach ( $directions_list as $direction ) {
					$current_xy = self::DIRECTION_OFFSETS[$direction];
					$current_xy[0] *= 1;
					$current_xy[1] *= 1;
					$type=0;

					$ending_square = self::square_surrounded_by_general(
						$actual_square,
						$starting_square,
						$current_xy[0],
						$current_xy[1],
						$color_to_move,
						$board,
						TRUE
					);
					if(!$ending_square)
					{ continue;
					}
					if($ending_square!=null)
					{
						return TRUE;
					}
				}
			if(!$ending_square)
			{ return FALSE;
			}
			else
				return TRUE;
		}

		static function get_piece_castle_with_royals( /**/
			ChessPiece $piece,
			$color_to_move,
			ChessBoard $board
		): int {
			$j=0; $ctype=1;
			//self CASTLE itself is full royal.. Any Officer present in it does not require Royals to be present
			if((($piece->square->rank==0)&&($piece->square->file>0)&&($piece->square->file<9)&&($color_to_move==1)) || (($piece->square->rank==9)&&($piece->square->file>0)&&($piece->square->file<9)&&($color_to_move==2))){
				return 1;
			}
			//inside Foe CASTLE
			if((($piece->square->rank==9)&&($piece->square->file>0)&&($piece->square->file<9)&&($color_to_move==1))) {
				$ctype=2;$j=9;
				}
			//inside Foe castle	
			elseif((($piece->square->rank==0)&&($piece->square->file>0)&&($piece->square->file<9)&&($color_to_move==2))){ 
				$ctype=1;$j=0;
				}
			else{
				return -1; //piece is not in castle
			}

			for ($i = 1; $i <= 8; $i++) { /**Loop through foe castle. Any side can enter castle*/
					if (!$board->board[$j][$i]) {
						continue;
					}

					//Its own royal member is present in foe
					if(($piece->color==$board->board[$j][$i]->color)&&(($board->board[$j][$i]->group=='ROYAL') || ($board->board[$j][$i]->group=='SEMIROYAL'))){
						return 0; //inside foe castle
					}
					else
						continue;
				}
			return -1; //piece is not in castle
		}

		static function get_compromised_castle( /**/
			ChessPiece $piece,
			$color_to_move,
			$castletocheck,
			ChessBoard $board
		): bool {
			$j=0;
			$ctype=1;
			if(abs($color_to_move-$castletocheck)==1){ //foe
				$ctype=$castletocheck;
			}
			else
			if(abs($color_to_move-$castletocheck)!=1){ //self
				$ctype=$color_to_move;
			}

			for ($i = 1; $i <= 8; $i++) { /**Loop through castle . Any side can enter castle*/
				if ($castletocheck==1) {
					$j=0;
					}

				if ($castletocheck==2) {
						$j=9;
					}

					if (!$board->board[$j][$i]) {
						continue;
					}

					if((($board->board[$j][$i]->group=='ROYAL') || ($board->board[$j][$i]->group=='SEMIROYAL') ||
					($board->board[$j][$i]->group=='NOBLE')) &&($board->board[$j][$i]->color!=$ctype)){//Compromised
						return true;
					}
					if(($board->board[$j][$i]->group!='ROYAL')&&($board->board[$j][$i]->group!='SEMIROYAL')&&
					($board->board[$j][$i]->group!='NOBLE')&&($board->board[$j][$i]->color!=$ctype)){//Compromised
						return true;
					}
					else
						continue;
				}			
			return false;
		}

	static function check_royal_neighbours( /* check_neighbour_type = Zonal, Tight*/
		array $directions_list,
		ChessPiece $piece,
		$color_to_move,
		ChessBoard $board,
		string $check_neighbour_type
	): bool {
		$ending_square=null;
		$starting_square=$piece->square;
		$Royals=0;

		if(($check_neighbour_type=="Zone") && (($piece->group=="ROYAL") || ($piece->group=="SEMIROYAL")))
		{
			/*$WZ_Royals=0; $TZ_Royals=0; $Black_ACASTLE_Royals=0; $White_ACASTLE_Royals=0;*/

			if((($piece->color==	$color_to_move)	&& ($piece->square->file>0) && ($piece->square->file<9)&& ($piece->square->rank==9) && ($piece->color==2))||
			(($piece->color==	$color_to_move)	&& ($piece->square->file>0) && ($piece->square->file<9)&& ($piece->square->rank==0) && ($piece->color==1)))
				{
					return true;
				}
			if((($piece->color!=$color_to_move)	&& ($piece->square->file>0) && ($piece->square->file<9)&& ($piece->square->rank==9) && ($piece->color==2)))
				{
				$maxrow=9;$maxcol=8;$minrow=9;$mincol=1;
				}
			if((($piece->color!= $color_to_move)	&& ($piece->square->file>0) && ($piece->square->file<9)&& ($piece->square->rank==0) && ($piece->color==1)))
				$maxrow=0;$maxcol=8;$minrow=0;$mincol=1;
			//no Mans Logic not added yet Oct 2021
			$maxrow=0;$maxcol=0;$minrow=0;$mincol=0;

			if(($starting_square->rank>=1)&&($starting_square->rank<=8)&&($starting_square->file>0)&&($starting_square->file<9)){
			$maxrow=8;$maxcol=8;$minrow=1;$mincol=1;}

			//opponent CASTLE
			if(($starting_square->rank==0)&&($starting_square->file>0)&&($starting_square->file<9)){
				$maxrow=0;$maxcol=8;$minrow=0;$mincol=1;}

			//opponent CASTLE	
			if(($starting_square->rank==9)&&($starting_square->file>0)&&($starting_square->file<9)){
				$maxrow=9;$maxcol=8;$minrow=9;$mincol=1;}

			if(($starting_square->file==0)&&($starting_square->rank>0)&&($starting_square->rank<9)){
				$maxrow=8;$maxcol=0;$minrow=1;$mincol=0;}

			if(($starting_square->file==9)&&($starting_square->rank>0)&&($starting_square->rank<9)){
				$maxrow=8;$maxcol=9;$minrow=1;$mincol=9;}

			for ($rank = $maxrow; $rank >= $minrow; $rank--) {
				if($Royals>=2) break;
				for ($file = $mincol; $file <= $maxcol; $file++) {
					if($Royals>=2) break;
					//war Zone
					if (($board->board[$rank][$file]!=null) && (($board->board[$rank][$file]->color== $color_to_move) ))
						{
							if(($board->board[$rank][$file]->group=="ROYAL") ||($board->board[$rank][$file]->group=="SEMIROYAL"))
							{
								$Royals=$Royals+1;
							}
						}
				}
			}
		}
		if($Royals>=2) return true;
		else return false;
	}

	static function get_LastGeneralRow(ChessPiece $piece,	$color_to_move,	ChessBoard $board,	int $mtype	): int{

		$ksquare=$board->get_king_square(abs($color_to_move-3));
		$gsquare=$board->get_general_square($color_to_move);

		if($ksquare==null) return -1;
		elseif($gsquare==null)  return -1;		

		if((($piece->group=="OFFICER") ||($piece->group=="SOLDIER"))&&($piece->color==1)){
			if((($ksquare->file==0)||($ksquare->file==9))&&(($ksquare->rank>=1)&&($ksquare->rank<=4)&&($piece->square->rank>=1)&&($piece->square->rank<=4))){
				return 4;
			}
			if((($ksquare->file==0)||($ksquare->file==9))&&(($ksquare->rank>=1)&&($ksquare->rank<=4)&&($piece->square->rank>=5)&&($piece->square->rank<=8))){
				return $piece->square->rank-1;
			}
			if((($ksquare->file==0)||($ksquare->file==9))&&($ksquare->rank>=5)&&($ksquare->rank<=8)){
				if(($piece->square->rank>=1)&&($piece->square->rank<=8)&&($piece->square->rank<=$ksquare->rank)){
					return $ksquare->rank;
				}
				else if(($piece->square->rank>=1)&&($piece->square->rank<=8)&&($piece->square->rank>$ksquare->rank)){
					return $piece->square->rank-1; //Can retreat from lower to very lower
				}
			}
		}
		else if((($piece->group=="OFFICER") ||($piece->group=="SOLDIER"))&&($piece->color==2)){
			if((($ksquare->file==0)||($ksquare->file==9))&&(($ksquare->rank>=5)&&($ksquare->rank<=8)&&($piece->square->rank>=5)&&($piece->square->rank<=8))){
				return 5;
				}
			if((($ksquare->file==0)||($ksquare->file==9))&&(($ksquare->rank>=5)&&($ksquare->rank<=8)&&($piece->square->rank>=1)&&($piece->square->rank<=4))){
				return $piece->square->rank+1;
				}
			if((($ksquare->file==0)||($ksquare->file==9))&&($ksquare->rank>=1)&&($ksquare->rank<=4)){
				if(($piece->square->rank>=1)&&($piece->square->rank<=8)&&($piece->square->rank>=$ksquare->rank)){
					return $ksquare->rank;
					}
				else if(($piece->square->rank>=1)&&($piece->square->rank<=8)&&($piece->square->rank<$ksquare->rank)){
					return $piece->square->rank+1; //Can retreat from lower to upper
					}
				}
			}
		return -1;
	}

	static function get_LastKingRow(ChessPiece $piece,	$color_to_move,	ChessBoard $board,	int $mtype	): int 
	{
		//$ksquare=$board->get_king_square($piece->color);
		$ksquare=$board->get_king_square(abs($color_to_move-3));
		$gsquare=$board->get_general_square($color_to_move);

		if($ksquare==null) {
			if($gsquare==null) {
				return -1;
			}
		}

		if((($piece->group=="OFFICER") ||($piece->group=="SOLDIER"))&&($piece->color==1)){

			//KING has primary TRUCE Obligations

			if(($ksquare!=null)&&((($ksquare->file==0)||($ksquare->file==9))&&(($ksquare->rank>=1)&&($ksquare->rank<=4)&&($piece->square->rank>=1)&&($piece->square->rank<=4)))){
				return 4;
			}
			if(($ksquare!=null)&&((($ksquare->file==0)||($ksquare->file==9))&&(($ksquare->rank>=1)&&($ksquare->rank<=4)&&($piece->square->rank>=5)&&($piece->square->rank<=9)))){
				return $piece->square->rank-1;
			}
			if(($ksquare!=null)&&((($ksquare->file==0)||($ksquare->file==9))&&($ksquare->rank>=5)&&($ksquare->rank<=8))){
				if(($piece->square->rank>=1)&&($piece->square->rank<=9)&&($piece->square->rank<=$ksquare->rank)){
					return $ksquare->rank;
				}
				else if(($piece->square->rank>=1)&&($piece->square->rank<=9)&&($piece->square->rank>$ksquare->rank)){
					return $piece->square->rank-1; //Can retreat from lower to very lower
				}
			}

			//General has secondary TRUCE Obligations
			if(($gsquare!=null)&&((($gsquare->file==0)||($gsquare->file==9))&&(($gsquare->rank>=1)&&($gsquare->rank<=4)&&($piece->square->rank>=1)&&($piece->square->rank<=4)))){
				return 4;
			}
			if(($gsquare!=null)&&((($gsquare->file==0)||($gsquare->file==9))&&(($gsquare->rank>=1)&&($gsquare->rank<=4)&&($piece->square->rank>=5)&&($piece->square->rank<=9)))){
				return $piece->square->rank-1;
			}

			if(($gsquare!=null)&&((($gsquare->file==0)||($gsquare->file==9))&&($gsquare->rank>=5)&&($gsquare->rank<=8))){
				if(($piece->square->rank>=1)&&($piece->square->rank<=9)&&($piece->square->rank<=$gsquare->rank)){
					return $gsquare->rank;
				}
				else if(($piece->square->rank>=1)&&($piece->square->rank<=9)&&($piece->square->rank>$gsquare->rank)){
					return $piece->square->rank-1; //Can retreat from lower to very lower
				}
			}
		return 9;
		}
		else if((($piece->group=="OFFICER") ||($piece->group=="SOLDIER"))&&($piece->color==2)){
			if(($ksquare!=null)&&((($ksquare->file==0)||($ksquare->file==9))&&(($ksquare->rank>=5)&&($ksquare->rank<=8)&&($piece->square->rank>=5)&&($piece->square->rank<=8)))){
				return 5;
			}
			if(($ksquare!=null)&&((($ksquare->file==0)||($ksquare->file==9))&&(($ksquare->rank>=5)&&($ksquare->rank<=8)&&($piece->square->rank>=0)&&($piece->square->rank<=4)))){
				return $piece->square->rank+1;
			}
			if(($ksquare!=null)&&((($ksquare->file==0)||($ksquare->file==9))&&($ksquare->rank>=1)&&($ksquare->rank<=4))){
				if(($piece->square->rank>=0)&&($piece->square->rank<=8)&&($piece->square->rank>=$ksquare->rank)){
					return $ksquare->rank;
				}
				else if(($piece->square->rank>=0)&&($piece->square->rank<=8)&&($piece->square->rank<$ksquare->rank)){
					return $piece->square->rank+1; //Can retreat from lower to upper
				}
			}
		
			if(($gsquare!=null)&&((($gsquare->file==0)||($gsquare->file==9))&&(($gsquare->rank>=5)&&($gsquare->rank<=8)&&($piece->square->rank>=5)&&($piece->square->rank<=8)))){
				return 5;
			}
			if(($gsquare!=null)&&((($gsquare->file==0)||($gsquare->file==9))&&(($gsquare->rank>=5)&&($gsquare->rank<=8)&&($piece->square->rank>=1)&&($piece->square->rank<=4)))){
				return $piece->square->rank+1;
			}
			if(($gsquare!=null)&&((($gsquare->file==0)||($gsquare->file==9))&&($gsquare->rank>=1)&&($gsquare->rank<=4))){
				if(($piece->square->rank>=0)&&($piece->square->rank<=8)&&($piece->square->rank>=$gsquare->rank)){
					return $gsquare->rank;
				}
				else if(($piece->square->rank>=0)&&($piece->square->rank<=8)&&($piece->square->rank<$gsquare->rank)){
					return $piece->square->rank+1; //Can retreat from lower to upper
				}
			}
			return 0;
		}
		return -1;
	}

	static function get_corrected_Retreating_Knight_General_directions(
		ChessPiece $piece,
		$color_to_move,
		ChessBoard $board,
		int $mtype,
		int $lastaccessiblerow,
		$tempDirection
	): array {

		$directions_list=[];
			
				if(($piece->color==1)&&($lastaccessiblerow<$piece->square->rank))
					{
						if(($piece->type == ChessPiece::KNIGHT)||($piece->type == ChessPiece::GENERAL)){
							if($mtype==2){
								$directions_list=self::RETREATING_KNIGHT_DIRECTIONS_11;
								}
							return $directions_list;
							}
					}
				elseif(($piece->color==2)&&($lastaccessiblerow>$piece->square->rank))
					{				
						if(($piece->type == ChessPiece::KNIGHT)||($piece->type == ChessPiece::GENERAL)){
							if($mtype==2){
									$directions_list=self::RETREATING_KNIGHT_DIRECTIONS_22;
								}
							return $directions_list;
							}
					}
				
		return $tempDirection;
	}

	//Army can retreat as per King or Generals Order
	static function get_Retreating_ARMY_directions(
		ChessPiece $piece,
		$color_to_move,
		ChessBoard $board,
		int $mtype

	): array {

			$directions_list=[];
			$ksquare=array ("rank"=>0, "file"=>0);
			$ksquare=$board->get_king_square(abs($color_to_move-3));//
			$gsquare=$board->get_general_square($color_to_move);//

			if($ksquare==null) {
				//Check if General is available or not
				if($gsquare==null) {
					return [];
				}
			}

			if($ksquare!=null) {	
				if((($piece->group=="OFFICER") ||($piece->group=="SOLDIER"))&&(($ksquare->file==0)||($ksquare->file==9))&&($ksquare->rank>=1)&&($ksquare->rank<=8))
				{
					if($piece->color==1)
						{
							if((($ksquare->rank>=1)&&($ksquare->rank<=4)&&($piece->square->rank>=1)&&($piece->square->rank<=4))||
							(($ksquare->rank>=5)&&($piece->square->rank<$ksquare->rank))){
								return [];
							}
							else
								{
								if($piece->type == ChessPiece::PAWN){
									$directions_list=self::RETREATING_WHITE_PAWN_MOVEMENT_DIRECTIONS;
									return $directions_list;
									}
								elseif($piece->type == ChessPiece::BISHOP){
									$directions_list=self::RETREATING_BISHOP_DIRECTIONS_1;
									return $directions_list;
									}
								elseif($piece->type == ChessPiece::KNIGHT){
									if($mtype==1){
										$directions_list=self::RETREATING_BISHOP_DIRECTIONS_1;
										}
									elseif($mtype==2){
										$directions_list=self::RETREATING_KNIGHT_DIRECTIONS_1;
										}
									return $directions_list;
									}
								elseif($piece->type == ChessPiece::ROOK){
									if($mtype==1){
										$directions_list=self::RETREATING_BISHOP_DIRECTIONS_1;
										}
									elseif($mtype==2){
										$directions_list=self::RETREATING_KNIGHT_DIRECTIONS_1;
										}
									return $directions_list;
									}
								elseif($piece->type == ChessPiece::GENERAL){
									if($mtype==1){
										$directions_list=self::RETREATING_GENERAL_DIRECTIONS_1;
										}
									elseif($mtype==2){
										$directions_list=self::RETREATING_KNIGHT_DIRECTIONS_1;
										}
									return $directions_list;
									}
								}
						}
					elseif($piece->color==2)
						{
							if((($ksquare->rank>=5)&&($ksquare->rank<=8)&&($piece->square->rank>=5)&&($piece->square->rank<=8))||
							(($ksquare->rank<=4)&&($piece->square->rank>=$ksquare->rank))){
								return [];
							}
							else
								{
								if($piece->type == ChessPiece::PAWN){
									$directions_list=self::RETREATING_BLACK_PAWN_MOVEMENT_DIRECTIONS;
									return $directions_list;
									}
								elseif($piece->type == ChessPiece::BISHOP){
									$directions_list=self::RETREATING_BISHOP_DIRECTIONS_2;
									return $directions_list;
								}
								elseif($piece->type == ChessPiece::KNIGHT){
									if($mtype==1){
										$directions_list=self::RETREATING_BISHOP_DIRECTIONS_2;
									}
									elseif($mtype==2){
										$directions_list=self::RETREATING_KNIGHT_DIRECTIONS_2;
									}
								}
								elseif($piece->type == ChessPiece::ROOK){
									$directions_list=self::RETREATING_BISHOP_DIRECTIONS_2;
									return $directions_list;
								}
								elseif ($piece->type == ChessPiece::GENERAL) {
									if ($mtype==1) {
										$directions_list=self::RETREATING_GENERAL_DIRECTIONS_2;
									} elseif ($mtype==2) {
										$directions_list=self::RETREATING_KNIGHT_DIRECTIONS_2;
									}
									return $directions_list;
									}
								}
						}
				}
			}

			if($gsquare!=null) {
				if((($piece->group=="OFFICER") ||($piece->group=="SOLDIER"))&&(($gsquare->file==0)||($gsquare->file==9))&&($gsquare->rank>=1)&&($gsquare->rank<=8))
				{
					if($piece->color==1)
						{
							if((($gsquare->rank>=1)&&($gsquare->rank<=4)&&($piece->square->rank>=1)&&($piece->square->rank<=4))||
							(($gsquare->rank>=5)&&($piece->square->rank<$gsquare->rank))){
								return [];
							}
							else
								{
								if($piece->type == ChessPiece::PAWN){
									$directions_list=self::RETREATING_WHITE_PAWN_MOVEMENT_DIRECTIONS;
									return $directions_list;
									}
								elseif($piece->type == ChessPiece::BISHOP){
									$directions_list=self::RETREATING_BISHOP_DIRECTIONS_1;
									return $directions_list;
									}
								elseif($piece->type == ChessPiece::KNIGHT){
									if($mtype==1){
										$directions_list=self::RETREATING_BISHOP_DIRECTIONS_1;
										}
									elseif($mtype==2){
										$directions_list=self::RETREATING_KNIGHT_DIRECTIONS_1;
										}
									return $directions_list;
									}
								elseif($piece->type == ChessPiece::ROOK){
									$directions_list=self::RETREATING_ROOK_DIRECTIONS_1;
									return $directions_list;
									}
								elseif($piece->type == ChessPiece::GENERAL){
									if($mtype==1){
										$directions_list=self::RETREATING_GENERAL_DIRECTIONS_1;
										}
									elseif($mtype==2){
										$directions_list=self::RETREATING_KNIGHT_DIRECTIONS_1;
										}
									return $directions_list;
									}
								}
						}
					elseif($piece->color==2)
						{
							if((($gsquare->rank>=5)&&($gsquare->rank<=8)&&($piece->square->rank>=5)&&($piece->square->rank<=8))||
							(($gsquare->rank<=4)&&($piece->square->rank>=$gsquare->rank))){
								return [];
							}
							else
								{
								if($piece->type == ChessPiece::PAWN){
									$directions_list=self::RETREATING_BLACK_PAWN_MOVEMENT_DIRECTIONS;
									return $directions_list;
									}
								elseif($piece->type == ChessPiece::BISHOP){
									$directions_list=self::RETREATING_BISHOP_DIRECTIONS_2;
									return $directions_list;
								}
								elseif($piece->type == ChessPiece::KNIGHT){
									if($mtype==1){
										$directions_list=self::RETREATING_BISHOP_DIRECTIONS_1;
									}
									elseif($mtype==2){
										$directions_list=self::RETREATING_KNIGHT_DIRECTIONS_2;
									}
									return $directions_list;
								}
								elseif($piece->type == ChessPiece::ROOK){
									$directions_list=self::RETREATING_ROOK_DIRECTIONS_2;
									return $directions_list;
								}
								elseif ($piece->type == ChessPiece::GENERAL) {
									if ($mtype==1) {
										$directions_list=self::RETREATING_GENERAL_DIRECTIONS_2;
									} elseif ($mtype==2) {
										$directions_list=self::RETREATING_KNIGHT_DIRECTIONS_2;
									}
									return $directions_list;
									}
								}
						}
				}
			}
			return [];
		}

	static function castle_became_warzone_moves_to_moves_list(
			array $directions_list,
			int $spaces,
			array $moves,
			ChessPiece $piece,
			$color_to_move,
			ChessBoard $board,
			bool $store_board_in_moves,
			int $cankill,
			bool $get_FullMover,
			bool $selfbrokencastle,
			bool $foebrokencastle
		): array {
			return [];
		}

		static function add_slide_and_slidecontroller_moves_to_moves_list(
			array $directions_list,
			int $spaces,
			array $moves,
			ChessPiece $piece,
			$color_to_move,
			&$board,
			bool $store_board_in_moves,
			bool $get_FullMover,
			bool $selfbrokencastle,
			bool $foebrokencastle,
			int $get_CASTLEMover,
			bool $controlled_move
		): array {
	
			/* $boolslide=TRUE; $royalp=FALSE; $candemote=FALSE; $dem=0; $tempDirection=null; $mtype=1;
			$generalaccessiblerow=-1;$movesA=[]; */
			$lastaccessiblerow=-1;$cankill=0;$get_FullMover=true;$new_move=null;

			$capture = FALSE;;$unsecured=false;
			$enemytrapped=false;$moves1=[];
			$controlledpiece=null;$naaradblocks=0;
	
			$naarad_Opponent_royalp=self::has_royal_neighbours( self::KING_DIRECTIONS, $piece->square, $piece->square, 3-$color_to_move, $board );
			$opponent_refuged=self::has_opponent_neighbours( self::KING_DIRECTIONS, $piece, 3-$color_to_move, $board );
			self::checkpinnedrefugees($color_to_move,$board, $piece->square,$piece->square);
			
			//Narad is powerful and can be moved.		//Moving the Narad 

			if(($board->controller_color!=null) &(($controlled_move==false)&&($board->controller_color==$color_to_move)&&($board->controller_color==3-$color_to_move))){
				return $moves;
			}
			if($naarad_Opponent_royalp==false){
				//$spaces=2;
				//$board->color=3-$color_to_move;
				foreach ( $directions_list as $direction ) {
					for ( $dli = 1; $dli <= $spaces; $dli++ ) {
	
							$current_xy = self::DIRECTION_OFFSETS[$direction];
							$current_xy[0] *= $dli;
							$current_xy[1] *= $dli;
							$type=0;
	
							$ending_square = self::square_exists_and_not_occupied_by_friendly_piece(
								$type, '0', $piece->square, $current_xy[0], $current_xy[1], $color_to_move, $board, $cankill, true, $selfbrokencastle, $foebrokencastle					
							);
			
							if ( ! $ending_square ) {
								// square does not exist, or square occupied by friendly piece
								// stop sliding
								break;
								}
	
						if((($lastaccessiblerow!=-1)&&($color_to_move==2)&&($ending_square->rank<$lastaccessiblerow))||
						(($lastaccessiblerow!=-1)&&($color_to_move==1)&&($ending_square->rank>$lastaccessiblerow))){
							continue;
						}
							$new_move=null;
							$new_move = new ChessMove( $piece->square, $ending_square,$ending_square, 1, $piece->color, $piece->type, $capture, $board, $store_board_in_moves, false ,$controlled_move);

							$move2 = clone $new_move;
							$move2->PinnedBRefugees=[]; $move2->PinnedWRefugees=[];
							$move2->board->PinnedBRefugees=[]; $move2->board->PinnedWRefugees=[];
							$unsecured=false;
							$naaradblocks=0; $calculatednaaradblocks=0;
							if($color_to_move==1) {
								$naaradblocks =sizeof($board->PinnedBRefugees);
								$move2->board->wnsquare=$ending_square;
								self::check_opponent_neighbours($move2->board,3-$color_to_move);
								$calculatednaaradblocks=sizeof($move2->board->PinnedBRefugees);
							}
							else if($color_to_move==2) {
								$naaradblocks =sizeof($board->PinnedWRefugees);
								$move2->board->bnsquare=$ending_square;
								self::check_opponent_neighbours($move2->board,3-$color_to_move);
								$calculatednaaradblocks=sizeof($move2->board->PinnedWRefugees);
							}

							if($color_to_move==1) {
								$naaradblocks =sizeof($board->PinnedBRefugees);
								$move2->board->wnsquare=$ending_square;
								$calculatednaaradblocks=sizeof($move2->board->PinnedBRefugees);
							}
							else if($color_to_move==2) {
								$naaradblocks =sizeof($board->PinnedWRefugees);
								$move2->board->bnsquare=$ending_square;
								$calculatednaaradblocks=sizeof($move2->board->PinnedWRefugees);
							}
							if(($calculatednaaradblocks>=0)&& ($naaradblocks>0)&& ($calculatednaaradblocks<$naaradblocks))
								$unsecured=true;
							else if(($calculatednaaradblocks>=0)&& ($naaradblocks==0))
								$unsecured=false;
							//match if count is same then probably squares are not same
							else {
								$maxcount=$naaradblocks;
								$securedcount=0;
								if($calculatednaaradblocks>=$naaradblocks){
									$maxcount=$calculatednaaradblocks;
									for ( $i = 0; $i < $calculatednaaradblocks; $i++ ) {
										for ( $j = 0; $j < $naaradblocks; $j++ ) {
											if($color_to_move==1) {
												if(($move2->board->PinnedBRefugees[$i]->square->rank ==	$board->PinnedBRefugees[$j]->square->rank)&&
												($move2->board->PinnedBRefugees[$i]->square->file ==	$board->PinnedBRefugees[$j]->square->file))
												$securedcount=$securedcount+1;
												$move2->board->PinnedBRefugees[$i]->controlledpiece=true;
												//$move2->board->PinnedBRefugees[$i]->controlledpiece=true;
											}
											else if($color_to_move==2) {
												if(($move2->board->PinnedWRefugees[$i]->square->rank ==	$board->PinnedWRefugees[$j]->square->rank)&&
												($move2->board->PinnedWRefugees[$i]->square->file ==	$board->PinnedWRefugees[$j]->square->file))
												$move2->board->PinnedWRefugees[$i]->controlledpiece=true;

												$securedcount=$securedcount+1;
											}
										}
									}
									if($securedcount>=$naaradblocks)
										$unsecured=false;
									else $unsecured =true;
								}
								else if($calculatednaaradblocks<$naaradblocks){
									$unsecured=true;
								}

								if(($unsecured==false) && ($new_move!=null))
								{	$move2 = clone $new_move;
									$moves[] = $move2;
								}
							}
							//break;
						}
					/*if(($unsecured==false) && ($new_move!=null))
						{	$move2 = clone $new_move;
							$moves[] = $move2;
						}*/
				}
			}
			if($opponent_refuged==false){
				$moves = self::add_slide_and_slidecapture_moves_to_moves_list(self::BISHOP_DIRECTIONS, $spaces, $moves, $piece, $color_to_move, $board, $store_board_in_moves,0,0,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover,False);
				$moves = self::add_slide_and_slidecapture_moves_to_moves_list(self::ROOK_DIRECTIONS,$spaces, $moves, $piece, $color_to_move, $board, $store_board_in_moves,0,0,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover,False);
			}
			//Moving the pinned pieces and then its own pieces
			//$board->color_to_move=$color_to_move;

			$jumpstyle='3';$get_Killing_Allowed=0;

				if($color_to_move==1) {
					$naaradblocks =sizeof($board->PinnedBRefugees);
				}
				else if($color_to_move==2) {
					$naaradblocks =sizeof($board->PinnedWRefugees);
				}
				
				$naaradcolor= $color_to_move;
				$rank=null; $file=null; $controlledpieces=null;

				$new_move = new ChessMove(
					$piece->square, $piece->square,$piece->square,
					0,
					$piece->color, $piece->type, $capture,
					$board,	$store_board_in_moves, TRUE,$controlled_move
				);

				for ( $k = 0; $k < $naaradblocks; $k++ ) {
					if(($naaradcolor==1) &&($board->PinnedBRefugees!=null)&&($board->PinnedBRefugees[$k]!=null)) {
						$rank=$board->PinnedBRefugees[$k]->square->rank;
						$file=$board->PinnedBRefugees[$k]->square->file;
						}
					else if(($naaradcolor==2) &&($board->PinnedWRefugees!=null)&&($board->PinnedWRefugees[$k]!=null)) {
						$rank=$board->PinnedWRefugees[$k]->square->rank;
						$file=$board->PinnedWRefugees[$k]->square->file;
						}
					
					if(($rank!=null) && ($file!=null) &&  (($board->board[$rank][$file]!=null) && ($board->board[$rank][$file]->group=="OFFICER") && ($board->board[$rank][$file]))) {
							$controlledpiece = clone $board->board[$rank][$file];
							if($controlledpiece!=null){
								$controlledpiece->striker=0;
								$color_to_move=3-$naaradcolor;
								$controlledpiece->controlledpiece=true;
								$board->board[$rank][$file]->controlledpiece=true;
								$board->color_to_move=$color_to_move;

								if(($board->gametype==1) && ($controlledpiece->group=="OFFICER")){
									$get_FullMover=self::check_general_royal_neighbours_promotion(self::KING_DIRECTIONS, $controlledpiece, $color_to_move, $board);
									}

								if ($controlledpiece->type == ChessPiece::GENERAL) {
									$moves1 = self::add_jump_and_jumpcapture_moves_to_moves_list(1,$jumpstyle,self::KNIGHT_DIRECTIONS, $moves1, $controlledpiece, $color_to_move, $board, $store_board_in_moves,$get_Killing_Allowed,0,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover,TRUE);
									$moves1 = self::add_slide_and_slidecapture_moves_to_moves_list(self::BISHOP_DIRECTIONS, 3, $moves1, $controlledpiece, $color_to_move, $board, $store_board_in_moves,0,0,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover,TRUE);
									$moves1 = self::add_slide_and_slidecapture_moves_to_moves_list(self::ROOK_DIRECTIONS, 3, $moves1, $controlledpiece, $color_to_move, $board, $store_board_in_moves,0,0,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover,TRUE);
								}
								else if ($controlledpiece->type == ChessPiece::KNIGHT) {
									$moves1 = self::add_jump_and_jumpcapture_moves_to_moves_list(1,$jumpstyle,self::KNIGHT_DIRECTIONS, $moves1, $controlledpiece, $color_to_move, $board, $store_board_in_moves,$get_Killing_Allowed,0,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover,TRUE);
									$moves1 = self::add_slide_and_slidecapture_moves_to_moves_list(self::BISHOP_DIRECTIONS, 2, $moves1, $controlledpiece, $color_to_move, $board, $store_board_in_moves,0,0,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover,TRUE);
									$moves1 = self::add_slide_and_slidecapture_moves_to_moves_list(self::ROOK_DIRECTIONS, 2, $moves1, $controlledpiece, $color_to_move, $board, $store_board_in_moves,0,0,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover,TRUE);
								}
								else if (($controlledpiece->type == ChessPiece::BISHOP) &&($color_to_move==$controlledpiece->color)) {
									$moves1 = self::add_slide_and_slidecapture_moves_to_moves_list(self::BISHOP_DIRECTIONS, 2, $moves1, $controlledpiece, $color_to_move, $board, $store_board_in_moves,0,0,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover,TRUE);
									$moves1 = self::add_slide_and_slidecapture_moves_to_moves_list(self::ROOK_DIRECTIONS, 2, $moves1, $controlledpiece, $color_to_move, $board, $store_board_in_moves,0,0,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover,TRUE);
								}
								else if (($controlledpiece->type == ChessPiece::ROOK) &&($color_to_move==$controlledpiece->color)) {
									$moves1 = self::add_slide_and_slidecapture_moves_to_moves_list(self::BISHOP_DIRECTIONS, 3, $moves1, $controlledpiece, $color_to_move, $board, $store_board_in_moves,0,0,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover,TRUE);
									$moves1 = self::add_slide_and_slidecapture_moves_to_moves_list(self::ROOK_DIRECTIONS, 3, $moves1, $controlledpiece, $color_to_move, $board, $store_board_in_moves,0,0,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover,TRUE);
								}
								else if ($controlledpiece->type == ChessPiece::PAWN) {
									$moves1 = self::add_slide_and_slidecapture_moves_to_moves_list(self::KING_DIRECTIONS, 1, $moves1, $piece, $color_to_move, $board, $store_board_in_moves,0,0,false,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover,TRUE);
								}
							}
						}
				}

				$board->color_to_move=$naaradcolor;

				for ( $k = 0; $k < $naaradblocks; $k++ ) {
					if(($naaradcolor==1) &&($board->PinnedBRefugees!=null)&&($board->PinnedBRefugees[$k]!=null)) {
						$rank=$board->PinnedBRefugees[$k]->square->rank;
						$file=$board->PinnedBRefugees[$k]->square->file;
						}
					else if(($naaradcolor==2) &&($board->PinnedWRefugees!=null)&&($board->PinnedWRefugees[$k]!=null)) {
						$rank=$board->PinnedWRefugees[$k]->square->rank;
						$file=$board->PinnedWRefugees[$k]->square->file;
						}
					
					if(($rank!=null) && ($file!=null) &&  (($board->board[$rank][$file]!=null) && ($board->board[$rank][$file]->group=="SOLDIER") && ($board->board[$rank][$file]))) {
							$controlledpiece = clone $board->board[$rank][$file];
							if($controlledpiece!=null){
								$controlledpiece->striker=0;
								$color_to_move=3-$naaradcolor;
								$controlledpiece->controlledpiece=true;
								$board->color=$color_to_move;
								if ($controlledpiece->type == ChessPiece::PAWN) {
									$uncontrolled_officer=self::check_uncontrolled_officers_neighbours( self::KING_DIRECTIONS, $controlledpiece, $color_to_move, $board, 'exclude' ,$controlledpiece->controlledpiece);
									if($uncontrolled_officer==false)
									$moves1 = self::add_slide_and_slidecapture_moves_to_moves_list(self::KING_DIRECTIONS, 1, $moves1, $piece, $color_to_move, $board, $store_board_in_moves,0,0,false,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover);
									}
								$board->color_to_move=$naaradcolor;
							}
					}
				}
				$board->color_to_move=$naaradcolor;
				$store_board_in_moves=True;

			if(count($moves1)>0){
					$new_move = new ChessMove(
						$piece->square,	$piece->square,$piece->square,
						0,$piece->color,$piece->type,
						$capture,$board,
						$store_board_in_moves, TRUE,$controlled_move
						);
			
					$new_move->controlled_moves=$moves1;
					$new_move->controlled_move=true;
					$moves[]=$new_move;
					$board->naradcmoves[]=$new_move;
				}
			return $moves;//$moves[]=$new_move;
		}

	static function add_slide_and_slidecapture_moves_to_moves_list(
		array $directions_list,
		int $spaces,
		array $moves,
		ChessPiece $piece,
		$color_to_move,
		ChessBoard $board,
		bool $store_board_in_moves,
		int $cankill,
		int $canbepromoted,
		bool $get_FullMover,
		bool $selfbrokencastle,
		bool $foebrokencastle,
		int $get_CASTLEMover,
		bool $controlled_move
	): array {

		$royalp=FALSE; $candemote=FALSE; $capture = FALSE; $dem=0; $tempDirection=null; $mtype=1;//slide //2 jump 
		$lastaccessiblerow=-1;
		/* $generalaccessiblerow=-1; $enemytrapped=false; $boolslide=TRUE; */
		//Create the Array of Move Types.. This will help in deciding the two types of moves in retrating.. Moving back and to the top border

		/*if($controlled_move==true)
		$ttt=1;

		if($piece->type==ChessPiece::GENERAL)
			$debug=1;
	
		if($piece->type==ChessPiece::ROOK)
			$debug=1;
		
		if($piece->type==ChessPiece::KNIGHT)
			$debug=1;

		if($piece->type==ChessPiece::BISHOP)
			$debug=1;
		*/	
		if($piece->type!=ChessPiece::GODMAN)
			{
				$tempDirection=self::get_Retreating_ARMY_directions( $piece, $color_to_move, $board, $mtype	);

				//Retreat or Truce Zone has Either King or General. Check this possibility.
				if (isset($tempDirection) && is_array($tempDirection)){
					$abcd=1;
					if(!empty($tempDirection)) //King is sitting on RestZone within Truce
						{
						$directions_list=$tempDirection;
						}
						$lastaccessiblerow=self::get_LastKingRow( $piece, $color_to_move, $board, $mtype );
				}

				$tempDirection=null;

				if(($piece->square->rank==8)&&($piece->square->file==0)){
					$piece->square->rank;
				}
				$royalp=self::check_royal_neighbours( self::KING_DIRECTIONS, $piece, $color_to_move, $board, "Zone" );

				$royal_royalp=self::has_royal_neighbours( self::KING_DIRECTIONS, $piece->square, $piece->square, $color_to_move, $board );

				if(($get_CASTLEMover==1)&&($selfbrokencastle==FALSE))//&&(($board->$blackcanfullmoveinowncastle == 1)||($board->$whitecanfullmoveinowncastle == 1)))
				{
					$royalp=true;
					//$booljump=true;
				}

				if(($royalp==false)&&($piece->group=='OFFICER'))
					{
						$royalp=self::check_general_royal_neighbours_promotion( /**/
							self::KING_DIRECTIONS,
							$piece,
							$color_to_move,
							$board
					);
				}
			}
		/*else
			{
			$tttt=1;
			}*/

			//Single Royal cannot move out of any zone.
			//if(($royal_royalp==false)&&(strpos($piece->group,"ROYAL")!==FALSE)&&($piece->square->rank<=9)&&($piece->square->rank>=0)&&(($piece->square->file==0)&&($piece->square->file==9))){
				//return $moves;
			//}

			//self-promotion to be added later for semi-royals
			if(($canbepromoted==1)&&($piece->group=="OFFICER")&&($royalp==true) /*&&($piece->square->file>0)&&($piece->square->file<9)*/){ // Check of self promotion can happen but not in TZ without royal
				if($royalp==TRUE) {$dem=-1;}
				else {$dem=0;}
				//$ending_square->file=$piece->square->file;
				//$ending_square->rank=$piece->square->rank;

				$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,$piece->type-1);
		
				if($canpromote==TRUE){// then update the parity with new demoted values
				//$piece->type=$piece->type+1;
					//Force Promotion to add in movelist	
					$new_move1 = new ChessMove(
						$piece->square, $piece->square,$piece->square,
						0,
						$piece->color, $piece->type,
						$capture, $board, $store_board_in_moves,
						TRUE,$controlled_move
						);
		
					$move3 = clone $new_move1;
					$move3-> set_promotion_piece($piece->type+$dem);
					
					$moves[] = $move3;
					}
			}

			//Lsst 2nd Row promotion
			if(($piece->group=="SEMIROYAL") &&
			(($piece->square->rank==8)&&($piece->square->file>0)&&($piece->square->file<9)&&($piece->color==1)||
			($piece->square->rank==1)&&($piece->square->file>0)&&($piece->square->file<9)&&($piece->color==2))
			){

				$new_move = new ChessMove(
					$piece->square, $piece->square,$piece->square,
					0,
					$piece->color,$piece->type,
					$capture,$board, $store_board_in_moves,
					TRUE,$controlled_move
					);

			$move2 = clone $new_move;
			
			$canpromote=false;
			$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,12);

			if($canpromote==TRUE){// then update the parity with new demoted values
				$move2 = clone $new_move;
				$move2-> set_promotion_piece(12);
				$moves[] = $move2;
				}
			}
			else /* Last Row promotion */
			if(($piece->group=="SEMIROYAL") &&
			(($piece->square->rank==9)&&($piece->square->file>0)&&($piece->square->file<9)&&($piece->color==1)||
			($piece->square->rank==0)&&($piece->square->file>0)&&($piece->square->file<9)&&($piece->color==2))
			){

				$new_move = new ChessMove(
					$piece->square, $piece->square,$piece->square,
					0,
					$piece->color, $piece->type,
					$capture, $board, $store_board_in_moves,
					TRUE,$controlled_move
					);

			$canpromote=false;
			$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,12);

			if(($canpromote==TRUE)&&(($color_to_move==1)&&($piece->square->rank==9)||($color_to_move==2)&&($piece->square->rank==0))){// then update the parity with new demoted values
				$move2 = clone $new_move;
				$move2-> set_promotion_piece(12);
				$moves[] = $move2;
				}
			}
		else
		if(($piece->group=="ROYAL") &&($piece->type == ChessPiece::KING) &&
		(($piece->square->file<4)||($piece->square->file>5))&&($piece->square->rank>=0)&&($piece->square->rank<=9)
		){ // give the invertion option in scepter castle meaning lost the game

				$new_move = new ChessMove(
					$piece->square, $piece->square,$piece->square,
					0,
					$piece->color, $piece->type, 
					$capture,$board, $store_board_in_moves,
					TRUE,$controlled_move
				);

					$move2 = clone $new_move;
					if(( $piece->type != ChessPiece::INVERTEDKING)){
						$move2-> set_promotion_piece(2);
					}
					$moves[] = $move2;
					//return $moves; Dont Return but add more moves
			}
		else
		if(($piece->group=="ROYAL") &&($piece->type == ChessPiece::KING) &&
			(($piece->square->file==0)||($piece->square->file==9))&&($piece->square->rank>=0)&&($piece->square->rank<=9)
			){ // give the invertion option in scepter castle meaning lost the game

					$new_move = new ChessMove(
						$piece->square, $piece->square,$piece->square,
						0,
						$piece->color, $piece->type,
						$capture, $board, $store_board_in_moves,
						TRUE,$controlled_move
					);
	
						$move2 = clone $new_move;
						if(( $piece->type != ChessPiece::INVERTEDKING)){
							$move2-> set_promotion_piece(2);
						}
						$moves[] = $move2;
						//return $moves; Dont Return but add more moves
				}
		else
		if(($piece->group=="ROYAL") &&(($piece->type == ChessPiece::KING)) &&
			(($piece->square->rank==0)&&($piece->square->file==4)&&($piece->color==1)||($piece->square->rank==9)&&($piece->square->file==5)&&($piece->color==2))
			){ // give the invertion option in scepter castle meaning lost the game

					$new_move = new ChessMove(
						$piece->square, $piece->square,$piece->square,
						0,
						$piece->color, $piece->type,
						$capture, $board, $store_board_in_moves,
						TRUE,$controlled_move
					);
	
						$move2 = clone $new_move;
							$move2-> set_promotion_piece(2);
						$moves[] = $move2;
						//return $moves; Dont Return but add more moves
				}
		else
		if(($piece->group=="ROYAL") &&(($piece->type == ChessPiece::INVERTEDKING)) &&
			(($piece->square->rank==0)&&($piece->square->file==4)&&($piece->color==1)||($piece->square->rank==9)&&($piece->square->file==5)&&($piece->color==2))
			){ // give the invertion option in scepter castle meaning lost the game

					$new_move = new ChessMove(
						$piece->square, $piece->square,$piece->square,
						0,
						$piece->color, $piece->type,
						$capture, $board, $store_board_in_moves,
						TRUE,$controlled_move
					);
	
						$move2 = clone $new_move;
							$move2-> set_promotion_piece(1);
						$moves[] = $move2;
						//return $moves; Dont Return but add more moves
				}
		else
		if(($piece->group=="ROYAL") &&( $piece->type == ChessPiece::INVERTEDKING) &&
			(($piece->square->rank==0)&&($piece->square->file!=4)&&($piece->color==1)||($piece->square->rank==9)&&($piece->square->file!=5)&&($piece->color==2))
			){ // give the option to become normal in castle
			
					$new_move = new ChessMove(
						$piece->square, $piece->square,$piece->square,
						0,
						$piece->color, $piece->type,
						$capture, $board, $store_board_in_moves,
						TRUE,$controlled_move
					);
	
						$move2 = clone $new_move;
							$move2-> set_promotion_piece(1);
						$moves[] = $move2;
						//return $moves; Dont Return but add more moves
				}
			else
		if(($piece->group=="ROYAL") &&( $piece->type == ChessPiece::KING)&&
		((($piece->square->rank==0)&&($piece->square->file!=4)&&($piece->color==1))||(($piece->square->rank==9)&&($piece->square->file!=5)&&($piece->color==2)))
			){ //give the option to become inverted in castle
			
					$new_move = new ChessMove(
						$piece->square, $piece->square,$piece->square,
						0,
						$piece->color, $piece->type, 
						$capture, $board, $store_board_in_moves,
						TRUE,$controlled_move
					);
	
						$move2 = clone $new_move;
						if(( $piece->type != ChessPiece::INVERTEDKING)){
							$move2-> set_promotion_piece(2);
						}
						$moves[] = $move2;
						//return $moves; Dont Return but add more moves
				}
			else			
			if(($piece->group=="ROYAL") &&( $piece->type == ChessPiece::KING)&&
			(($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0)&&($piece->square->file<9))
			){ //add the war zone inversion mode
			
					$new_move = new ChessMove(
						$piece->square, $piece->square,$piece->square,
						0,
						$piece->color, $piece->type,
						$capture, $board, $store_board_in_moves,
						TRUE,$controlled_move
					);
	
						$move2 = clone $new_move;
						if(( $piece->type != ChessPiece::INVERTEDKING)){
							$move2-> set_promotion_piece(2);
						}
						$moves[] = $move2;
						//return $moves; Dont Return but add more moves
				}
			else
			if(($piece->group=="ROYAL") &&( $piece->type == ChessPiece::INVERTEDKING)&&
				(($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0)&&($piece->square->file<9))
				){ //add the war zone normal mode option
				
						$new_move = new ChessMove(
							$piece->square, $piece->square,$piece->square,
							0,
							$piece->color, $piece->type,
							$capture, $board, $store_board_in_moves,
							TRUE,$controlled_move
						);
		
							$move2 = clone $new_move;
								$move2-> set_promotion_piece(1);
							$moves[] = $move2;
							//return $moves; Dont Return but add more moves
					}
	
			//self::check_trapped_piece($piece,$color_to_move, $board,'exclude');

			if(((strpos($piece->group,"ROYAL")!==FALSE))&&( //cannot get out of no mans
			((($piece->square->file==0)||($piece->square->file==9))&&(($piece->square->rank==0)||($piece->square->rank==9)))
			)){
				$piece->group;//Stop counting moves as royal is stuck
				
				$new_move = new ChessMove(
					$piece->square, $piece->square,$piece->square,
					0,
					$piece->color, $piece->type,
					$capture, $board, $store_board_in_moves,
					TRUE,$controlled_move
				);
				$move2 = clone $new_move;

				if(($piece->group=="ROYAL") &&( $piece->type == ChessPiece::KING)){ //add the war zone inversion mode
							$new_move-> set_promotion_piece(2);
							$moves[] = $new_move;
							//return $moves; Dont Return but add more moves
				}
				else
				if(($piece->group=="ROYAL") &&( $piece->type == ChessPiece::INVERTEDKING) ){ //add the war zone normal mode option
								$new_move-> set_promotion_piece(1);
								$moves[] = $new_move;
								//return $moves; Dont Return but add more moves
				}
				///continue;
			}
			else
			{
				if($get_FullMover==FALSE) 
					$spaces=1;
				foreach ( $directions_list as $direction ) {
					for ( $i = 1; $i <= $spaces; $i++ ) {

						$current_xy = self::DIRECTION_OFFSETS[$direction];
						$current_xy[0] *= $i;
						$current_xy[1] *= $i;
						$type=0;

						$ending_square = self::square_exists_and_not_occupied_by_friendly_piece(
							$type,
							'0',
							$piece->square, $current_xy[0], $current_xy[1], $color_to_move,
							$board, $cankill, $get_FullMover, $selfbrokencastle, $foebrokencastle
						);

						$capture = FALSE;
	
						if ( ! $ending_square ) {
							// square does not exist, or square occupied by friendly piece
							// stop sliding
							break;
							}

						/*if( (($selfbrokencastle==true)&&( $piece->square->rank==9)&&($ending_square->rank<8)&&($color_to_move==2)||
						($foebrokencastle==true)&&($ending_square->rank>1)&&($piece->square->rank==0)&&($color_to_move==2))||  
						(($selfbrokencastle==true)&&( $piece->square->rank==0)&&($ending_square->rank>1)&&($color_to_move==1)||
						($foebrokencastle==true)&&($ending_square->rank<8)&&($piece->square->rank==9)&&($color_to_move==1)))
						{ 
							break;
						}
						*/

					if(($board->refugee!=null) && 
					(($board->refugee->square!=null)&& ($board->refugee->square->rank==$ending_square->rank) && ($board->refugee->square->file==$ending_square->file)))
					{
						continue;
					}

					if(($lastaccessiblerow!=-1)&&($color_to_move==2)&&($ending_square->rank<$lastaccessiblerow)){
						continue;
					}

					if(($lastaccessiblerow!=-1)&&($color_to_move==1)&&($ending_square->rank>$lastaccessiblerow)){
						continue;
					}

					$endpiece=null;

					if ($board->board[$ending_square->rank][$ending_square->file]) {
						//Check the last piece action on Trapped piece or Pushed Piece						
						//$endpiece = clone $board->board[$ending_square->rank][$ending_square->file];
						//knight can push by 1 step.. Pawn can push by 1 step. if no power to kill
						//self::check_virtual_trapped_piece($piece,$board->board[$ending_square->rank][$ending_square->file],$color_to_move, $board,'exclude');

						if ($board->board[$ending_square->rank][$ending_square->file]->color != $color_to_move) {				
							if((($piece->group=='OFFICER')) && ($piece->type<=$board->board[$ending_square->rank][$ending_square->file]->type) && 
							(($board->board[$ending_square->rank][$ending_square->file]->group=='OFFICER') ||($board->board[$ending_square->rank][$ending_square->file]->group=='SEMIROYAL')|| ($board->board[$ending_square->rank][$ending_square->file]->group=='SOLDIER')))
								$capture = true;
							else if((($piece->group=='ROYAL')) && ($piece->type<=$board->board[$ending_square->rank][$ending_square->file]->type) && 
								(($board->board[$ending_square->rank][$ending_square->file]->group=='ROYAL') ||($board->board[$ending_square->rank][$ending_square->file]->group=='SEMIROYAL') 
								||($board->board[$ending_square->rank][$ending_square->file]->group=='OFFICER') || ($board->board[$ending_square->rank][$ending_square->file]->group=='SOLDIER')))
									$capture = true;
							else if((($piece->group=='OFFICER')) && ($piece->type>$board->board[$ending_square->rank][$ending_square->file]->type) && 
								(($board->board[$ending_square->rank][$ending_square->file]->group=='OFFICER') || ($board->board[$ending_square->rank][$ending_square->file]->group=='ROYAL')))
									{//$capture = false; continue;
									
									if( ($ending_square->mediatorrank!=null)&&($ending_square->mediatorfile!=null)){
										$mediatorpiece = clone $piece;
										$endpiece = clone $board->board[$ending_square->rank][$ending_square->file];

										if(($piece->square->mediatorrank!=$ending_square->mediatorrank)&&($piece->square->mediatorfile!=$ending_square->mediatorfile)){
											$mediatorpiece->square->mediatorrank=$ending_square->mediatorrank;
											$mediatorpiece->square->mediatorfile=$ending_square->mediatorfile;
											$mediatorpiece->state="V";
											}
										$sittingpiece=$board->board[$mediatorpiece->square->rank][$mediatorpiece->square->file];
										$board1 = clone $board;
										$board1->board[$mediatorpiece->square->rank][$mediatorpiece->square->file]=$mediatorpiece;
										if($royal_royalp==true)
											$mediatorpiece->elevatedofficer=true;
										else $mediatorpiece->elevatedofficer=false;

										if($i>=2){
											$moves = self::add_running_capture_moves_to_moves_list($moves, $mediatorpiece, $endpiece, $color_to_move, $board1, $store_board_in_moves,1,$selfbrokencastle,$foebrokencastle);
											break;
											}
										}/*
								else {
									$new_move1 = new ChessMove( $piece->square, $ending_square,$ending_square, -1, $piece->color, $piece->type, $capture, $board, $store_board_in_moves, false);
									//$move2 = clone $new_move1;
									//$moves[] = 	$move2;
									$move2 = clone $new_move;
							$move2->set_demotion_piece($piece->type+$dem);
							//check if the king is killed
							if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);
							$moves[] = $move2;
									}
									*/
									break;
									}
							
							//if((($piece->group=='OFFICER')) && (($enemytrapped==true)||($capture==true)))
							//	{ $capture = true;$enemytrapped=false; }
							//else if(($piece->group=='OFFICER') && ($enemytrapped==false))
							//	{ continue; }
							}
					}

					//movement within the opponent castle
					if(($piece->group=="SEMIROYAL") &&(($piece->square->rank==$ending_square->rank))&&((($ending_square->rank==0) &&($color_to_move==2))||(($ending_square->rank==9)&&($color_to_move==1)))&&(
						(($ending_square->file>0)&&($ending_square->file<9))
						)&& ($board->board[$ending_square->rank][$ending_square->file]==null)  ){ // Check of promotion can happen

							if($piece->group=="SEMIROYAL"){
								$new_move = new ChessMove(
									$piece->square, $ending_square,$ending_square,
									0,
									$piece->color, $piece->type, $capture,
									$board, $store_board_in_moves, FALSE,$controlled_move
									);

								$moves[] = $new_move;
								$canpromote=false;
								$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,12);

								if($canpromote==TRUE){
									$move2 = clone $new_move;
									$move2-> set_promotion_piece(12);
									//check if the king is killed
									if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
											$move2->set_killed_king(TRUE);
									$moves[] = $move2;
									}

								if((($foebrokencastle==true)&&((($ending_square->rank==9)&&($color_to_move==1))||(($ending_square->rank==0)&&($color_to_move==2)))) &&(($ending_square->file==4)||($ending_square->file==5)))
									{ 
									continue;
									}
								}
					}

				//***  Self Compromised CASTLE movement in and out without Royal. 2 steps are not allowed */	
				if((($piece->group=="SEMIROYAL")||($piece->group=="ROYAL"))&&($royal_royalp==false)&&($selfbrokencastle==TRUE)&&
				(((abs($ending_square->file-$piece->square->file)>1)&&(($ending_square->file>=0)&&($ending_square->file<=9))) ||
				((abs($ending_square->rank-$piece->square->rank)>1)&&(($ending_square->file>=0)&&($ending_square->file<=9)))))
					{
					continue;
					}

				//classical cannot allow Officers to move to no-mans. Only General is allowed
				if(($board->gametype==1) && (( ($piece->group=="OFFICER") &&($royalp==false)/*&&($piece->type!=ChessPiece::GENERAL)*/)||($piece->group=="SOLDIER"))&&
				(  (($ending_square->file==0)||($ending_square->file==9))&&	 (($ending_square->rank==0)||($ending_square->rank==9))	))
				{
					continue;
				}

				//classical cannot allow Officers to move from Normal CAStle to Truce. Only General is allowed. But General can push Officrs from compromised CasTLE.
				if(($board->gametype==1) && (( ($piece->group=="OFFICER") &&($piece->type!=ChessPiece::GENERAL))||($piece->group=="SOLDIER"))&&
				(  (($ending_square->file==0)||($ending_square->file==9)) &&(($piece->square->rank==0)||($piece->square->rank==9))&&
				 (($ending_square->rank>0)&&($ending_square->rank<9)) &&(($piece->square->file>0)&&($piece->square->file<9)) ))
				{
					continue;
				}

				//classical. Cannot allow General to move from CAStle to Truce without Royal.
				if(($board->gametype==1) && ($piece->type==ChessPiece::GENERAL)&&($royalp==false) &&
				(  (($ending_square->file==0)||($ending_square->file==9)) &&(($piece->square->rank==0)||($piece->square->rank==9))&&
				 (($ending_square->rank>0)&&($ending_square->rank<9)) &&(($piece->square->file>0)&&($piece->square->file<9))))
				{
				continue;
				}

				/*
				//  Self Compromised CASTLE movement in and out without Royal. 2 steps are not allowed *
				if((($piece->group=="SEMIROYAL")||($piece->group=="ROYAL"))&&($royalp==false)&&($selfbrokencastle==TRUE)&&
				(((abs($ending_square->file-$piece->square->file)>1)&&(($ending_square->file>=0)&&($ending_square->file<=9))) ||
				((abs($ending_square->rank-$piece->square->rank)>1)&&(($ending_square->file>=0)&&($ending_square->file<=9)))))
					{
					continue;
					}
				*/
				//classical cannot allow Officers to move to no-mans. Only General is allowed
				if(($board->gametype==1) && ($royalp==false) && (( ($piece->group=="OFFICER") &&($piece->type!=ChessPiece::GENERAL))||($piece->group=="SOLDIER"))&&
				(  (($ending_square->file==0)||($ending_square->file==9))&&	 (($ending_square->rank==0)||($ending_square->rank==9))	))
					{
						continue;
					}

				//classical. Cannot allow Officers to move from CAStle to Truce. Only General is allowed
				if(($board->gametype==1) &&($royalp==false) && (( ($piece->group=="OFFICER") &&($piece->type!=ChessPiece::GENERAL))||($piece->group=="SOLDIER"))&&
				(  (($ending_square->file==0)||($ending_square->file==9)) &&(($piece->square->rank==0)||($piece->square->rank==9))&&
				 (($ending_square->rank>0)&&($ending_square->rank<9)) &&(($piece->square->file>0)&&($piece->square->file<9))))
					{
					continue;
					}

				//classical cannot allow General to move from CAStle to Truce with Royal. Only General is allowed
				if(($board->gametype==1) && ($piece->type==ChessPiece::GENERAL)&&($royalp==false) &&
				(  (($ending_square->file==0)||($ending_square->file==9)) &&(($piece->square->rank==0)||($piece->square->rank==9))&&
				 (($ending_square->rank>0)&&($ending_square->rank<9)) &&(($piece->square->file>0)&&($piece->square->file<9)) ))
				{
				continue;
				}

				if( $board->board[$ending_square->rank][$ending_square->file]!=null ){
					if ( $board->board[$ending_square->rank][$ending_square->file] ) {
						if (( $board->board[$ending_square->rank][$ending_square->file]->color != $color_to_move)) {
							if((($ending_square->rank==0)&& ($ending_square->file==0))||(($ending_square->rank==0)&& ($ending_square->file==9))||
							(($ending_square->rank==9)&& ($ending_square->file==0))||(($ending_square->rank==9)&& ($ending_square->file==9))){
								$capture = FALSE;
								continue; /** ????? */
								}

							//Classical Game. Officers cannot kill in compromised zone or Truce when ArthShashtri is also in idle condition
							if(((strpos($piece->group,"ROYAL")===FALSE))&&($board->gametype==1)&&(
			 				($color_to_move==2)&& (($board->basquare==null) || ( ((($board->basquare->file==5)||($board->basquare->file==4)) &&(($board->basquare->rank==9))))||
			 				((($board->basquare->file==5)||($board->basquare->file==4)) &&(($board->basquare->rank==9)))||
			 				((($board->basquare->file==0)||($board->basquare->file==9)) &&(($board->basquare->rank==4)||($board->basquare->rank==5))) ) ||

							 ( ($color_to_move==1) && (($board->wasquare==null) ||((($board->wasquare->file==5)||($board->wasquare->file==4)) &&(($board->wasquare->rank==0)))||
			 				((($board->wasquare->file==5)||($board->wasquare->file==4)) &&(($board->wasquare->rank==0)))||
			 				((($board->wasquare->file==0)||($board->wasquare->file==9)) &&(($board->wasquare->rank==4)||($board->wasquare->rank==5))) ))
			 				))
								{
								continue;
								}

							//Truce Zone guys cannot be killed
							if(($ending_square->rank>=0)&& ($ending_square->rank<=9)&&(($ending_square->file==0)||
							($ending_square->file==9))){
								continue; /** Cannot Kill anyone in TruceZone */
							}
						}

					if(($capture == TRUE)&&($board->board[$ending_square->rank][$ending_square->file]->mortal!=1)){
						continue; /** Only Mortals can be killed */
					}
				}
				$capture = true;
			}
			else 
				$capture = false;

				//Royals moving from War to CASTLE with royal touch
				if((strpos($piece->group,"ROYAL")!==FALSE) && ($royalp)&&($piece->square->file>1)&&($piece->square->file<9)&&($piece->square->rank>1)&&($piece->square->rank<9)&&(($ending_square->file>0)&&($ending_square->file<9)&&(($ending_square->rank==0)||($ending_square->rank==9)))) {
						if ( $board->board[$ending_square->rank][$ending_square->file] ==null) {
							if(($piece->type == ChessPiece::SPY)||($piece->type == ChessPiece::ARTHSHASTRI)||($piece->type == ChessPiece::KING)||( $piece->type == ChessPiece::INVERTEDKING)){
								if(($ending_square->rank==0)||($ending_square->rank==9)){

									$new_move = new ChessMove( $piece->square, $ending_square, $ending_square, 0, $piece->color, $piece->type, $capture, $board, $store_board_in_moves, FALSE,$controlled_move );
									if($piece->group=="SEMIROYAL"){
										//Trying to enter the Opponent CASTLE
										$move1 = clone $new_move;
										if((($ending_square->rank==9)&&($color_to_move==1))||(($ending_square->rank==0)&&($color_to_move==2))){
											$canpromote=false;
											$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,12);
			
											if($canpromote==TRUE){
												$move2 = clone $new_move;
												$move2-> set_promotion_piece(12);
												$moves[] = $move2;
												}
			
											//if((($foebrokencastle==true)&&((($ending_square->rank==9)&&($color_to_move==1))||(($ending_square->rank==0)&&($color_to_move==2)))) &&(($ending_square->file==4)||($ending_square->file==5)))
												//{ 
												//continue;
												//}
											}
											$moves[] = $move1;
											continue;
										}
									//If royals are entering	
									else if(($piece->group=="ROYAL")&&((($ending_square->rank==9)&&($color_to_move==1))||(($ending_square->rank==0)&&($color_to_move==2)))){
										$move2 = clone $new_move;
										if(($piece->type == ChessPiece::ARTHSHASTRI))
												$move2-> set_promotion_piece(50);
										else
											$move2-> set_promotion_piece(100);
												
										$moves[] = $move2;
										//return $moves; Dont Return but add more moves
										continue;
										}
									else 
										continue; /** Cannot get inside CASTLE piece */
								}
							}

						}
					//Ending CASTLE has value so WAR ppl cannt enter
					elseif (($piece->square->rank>0)&&($piece->square->rank<9))
						continue;
					}


				//single Royal in CASTLE trying to move to No mans
				elseif(((strpos($piece->group,"ROYAL")!==FALSE)&&($royalp==false))&&
					((($piece->square->file>0)&&($piece->square->file<9)&&($piece->square->rank==0) &&
						($ending_square->rank==0)&&(($ending_square->file==0)||($ending_square->file==9)))||
					(($piece->square->file>0)&&($piece->square->file<9)&&($piece->square->rank==9) &&
					($ending_square->rank==9)&&(($ending_square->file==0)||($ending_square->file==9))) 
					)){
					$piece->group;//Stop counting moves as single royal cannot move from castle to no mans
					continue;
				}
				//single Royal in CASTLE trying to enter to WAR
				elseif(((strpos($piece->group,"ROYAL")!==FALSE)&&($royalp==false))&&
					((($piece->square->file>0)&&($piece->square->file<9)&&($piece->square->rank==0) &&
					($ending_square->rank>0)&&($ending_square->rank<9)&&($piece->square->file>0)&&($piece->square->file<9))||
					(($piece->square->file>0)&&($piece->square->file<9)&&($piece->square->rank==9) &&
					($ending_square->rank>0)&&($ending_square->rank<9)&&($piece->square->file>0)&&($piece->square->file<9))
					)){
					$piece->group;//Royal is alone in castle. Cannot move to War Zone

					/*if(($selfbrokencastle==true)&&($piece->square->rank==0)&&($color_to_move==1)||
					($foebrokencastle==true)&&($piece->square->rank==9)&&($color_to_move==1))
					{ // CASTLE has become warzone		}
					else
					if(($selfbrokencastle==true)&&($piece->square->rank==9)&&($color_to_move==2)||
					($foebrokencastle==true)&&($piece->square->rank==0)&&($color_to_move==2))
					{ // CASTLE has become warzone		}
					else */
						continue;
				}
				//single Royal in TRUCE trying to enter to WAR
				else if(((strpos($piece->group,"ROYAL")!==FALSE)&&($royal_royalp==false))&&
					((($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file==0))||
					(($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file==9)))){
					$piece->group;//Stop counting moves as royal is alone in truce and cannot move to war
					continue;
				}
				//single Royal in WAR trying to enter to CASTLE or no mans
				else if((strpos($piece->group,"ROYAL")!==FALSE)&&($royal_royalp==false)&&
					($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0)&&($piece->square->file<9)&&
					((($ending_square->rank==0) &&($selfbrokencastle==false)&&($color_to_move==1))||(($ending_square->rank==9) &&($foebrokencastle==false)&&($color_to_move==1))||
					(($ending_square->rank==9) &&($selfbrokencastle==false)&&($color_to_move==2))||(($ending_square->rank==0) &&($foebrokencastle==false)&&($color_to_move==2))
					||($ending_square->file==0)||($ending_square->file==9)))
					{
					continue;
				}

				if($royalp==TRUE){ 
					/*We can also add the promotion logic*/
					if($board->board[$piece->square->rank][$piece->square->file]==null)
						{/*$ttt=1;*/}
					else if((($board->board[$piece->square->rank][$piece->square->file]->group=='ROYAL')||($board->board[$piece->square->rank][$piece->square->file]->group=='SEMIROYAL'))&&
					((($ending_square->file==0)&&($piece->square->file==0)&&($ending_square->rank==0)&&($piece->square->rank>0)&&($piece->square->rank<9))||
					(($ending_square->file==9)&&($piece->square->file==9)&&($ending_square->rank==0)&&($piece->square->rank>0)&&($piece->square->rank<9))||
					(($ending_square->file==0)&&($piece->square->file==0)&&($ending_square->rank==9)&&($piece->square->rank>0)&&($piece->square->rank<9))||
					(($ending_square->file==9)&&($piece->square->file==9)&&($ending_square->rank==9)&&($piece->square->rank>0)&&($piece->square->rank<9))
					)){
						$royalp=$royalp;
					}
				}
				else
				{
					//only RajRrishi has the right to enter these places

					/*// More than 2 rank jump not allwed rom compromised castle
					if(($selfbrokencastle==true)&&($piece->square->rank==0)&&($ending_square->rank>1)&&($color_to_move==1)||
					($foebrokencastle==true)&&($piece->square->rank==9)&&($ending_square->rank<8)&&($color_to_move==1))
					{ 
					continue;
					}
					else*/if(($selfbrokencastle==true)&&($piece->square->rank==0)&&($ending_square->rank>4)&&($color_to_move==2)||
					($foebrokencastle==true)&&($piece->square->rank==9)&&($ending_square->rank<5)&&($color_to_move==2))
					{ /* More than 4 rank jump not allwed from compromised castle*/
					continue;
					}
					elseif(($selfbrokencastle==true)&&($ending_square->rank==0)&&($color_to_move==1)||
					($foebrokencastle==true)&&($ending_square->rank==9)&&($color_to_move==1))
					{ /*
					* CASTLE has become warzone
					*/
					}
					elseif(($selfbrokencastle==true)&&($ending_square->rank==9)&&($color_to_move==2)||
					($foebrokencastle==true)&&($ending_square->rank==0)&&($color_to_move==2))
					{ /*
					* CASTLE has become warzone
					*/

					}
					elseif((($ending_square->rank==0) &&($ending_square->file>0)&&($ending_square->file<9))||(($ending_square->rank==9) &&($ending_square->file>0)&&($ending_square->file<9))){
						if(($piece->group=='OFFICER')&&($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0)&&($piece->square->file<9)){
						continue;//break;
						}
						//if there is no surrounding royals then break. Create function here.
						//if(($piece->group!=='ROYAL')&&($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0)&&($piece->square->file<9))			
					}
				}

				if ( $board->board[$ending_square->rank][$ending_square->file] ) {
					if (( $board->board[$ending_square->rank][$ending_square->file]->color != $color_to_move)) {
						$capture = TRUE;
						if((($ending_square->rank==0)&& ($ending_square->file==0)||($ending_square->rank==0)&& ($ending_square->file==9))||
						(($ending_square->rank==9)&& ($ending_square->file==0))||(($ending_square->rank==9)&& ($ending_square->file==9))){
							continue; /** no mans already has a piece */
						}

						/** Cannot kill out of the normal castle */
						if( (($selfbrokencastle==false)&&( $piece->square->rank==9)&&($ending_square->rank<=8)&&($color_to_move==2)||
						($foebrokencastle==false)&&($ending_square->rank>=1)&&($piece->square->rank==0)&&($color_to_move==2))||  
						(($selfbrokencastle==false)&&( $piece->square->rank==0)&&($ending_square->rank>=1)&&($color_to_move==1)||
						($foebrokencastle==false)&&($ending_square->rank<=8)&&($piece->square->rank==9)&&($color_to_move==1)))
						{ 
						break;
						}

 						/** Cannot kill out of Truce zone */
						if((($ending_square->rank>=1)&& ($ending_square->file>=1)&&($ending_square->rank<=8)&& ($ending_square->file<=8))&&
						(($piece->square->rank>0)&&($piece->square->rank<9))&&(($piece->square->file==9)|| ($piece->square->file==0))){
							break;
						}

 						/** Cannot kill out of No Mans */
						 if((($ending_square->rank>=0)&& ($ending_square->file>=1)&&($ending_square->rank<=9)&& ($ending_square->file<=8))&&
						 (($piece->square->rank==0)||($piece->square->rank==9))&&(($piece->square->file==9)|| ($piece->square->file==0))){
							 break;
						 }
 						/** Cannot kill inside No Mans */
						 if((($ending_square->rank==0)|| ($ending_square->rank==9)) && (($ending_square->file==0)||($ending_square->file==9))){
							 break;
						 }

						if(($ending_square->rank>=0)&& ($ending_square->rank<=9)&&(($ending_square->file==0)||
						($ending_square->file==9))){
							continue; /** Cannot Kill anyone in TruceZone */
						}
						//else
						//$capture = FALSE;
					}

					if(($capture == TRUE)&&($board->board[$ending_square->rank][$ending_square->file]->mortal!=1)){
						continue; /** Only Mortals can be killed */
					}

					//Check for intermediate square and put it as it is from TRuce to WAR
					if((($piece->square->file==0)&&($piece->square->rank>0)&&($piece->square->rank<9))||
					(($piece->square->file==9)&&($piece->square->rank>0)&&($piece->square->rank<9))){
							if($piece->square->file==0){
								$ending_square->file=1;
								$cancapture=FALSE;
							}
							elseif($piece->square->file==8){
								$ending_square->file=7;
								$cancapture=FALSE;
							}
							else{//invalid slides..
								continue;
							}
					}
				}
				else
				{
					if((($piece->square->file==0)&&($piece->square->rank>0)&&($piece->square->rank<9))||
					(($piece->square->file==9)&&($piece->square->rank>0)&&($piece->square->rank<9))){
						//if ($board->board[$ending_square->rank][$ending_square->file]) {

							if(($piece->square->file==0)&&($ending_square->file==0)&&($piece->square->rank==1)&&($ending_square->rank==0)){
								$ending_square->rank=0;$cancapture=FALSE;
							}
							elseif(($piece->square->file==0)&&($ending_square->file==0)&&($piece->square->rank==8)&&($ending_square->rank==9)){
								$ending_square->rank=9;$cancapture=FALSE;
							}
							elseif(($piece->square->file==9)&&($ending_square->file==9)&&($piece->square->rank==1)&&($ending_square->rank==0)){
								$ending_square->rank=0;$cancapture=FALSE;
							}
							elseif(($piece->square->file==9)&&($ending_square->file==9)&&($piece->square->rank==8)&&($ending_square->rank==9)){
								$ending_square->rank=9;$cancapture=FALSE;
							}
							elseif(($piece->square->file==0)&&($ending_square->file==1)){
								$ending_square->file=1;$cancapture=FALSE;
							}
							elseif(($piece->square->file==9)&&($ending_square->file==8)){
								$ending_square->file=8;$cancapture=FALSE;
							}
							else{//invalid slides..
								continue;
							}

						//}
					}
				//}
				}

				//ArthShashtri and spy cannot kill.. Also if King is idle then also cannot kill
				if(($cankill==0)&&($capture))
					break; 
				$ksqr=$board->get_king_square(abs($color_to_move-3));

				if($ksqr==null) continue;
				if(($capture==TRUE)&&
				(($board->get_king_square(abs($color_to_move-3))->rank==0)&&(($board->get_king_square(abs($color_to_move-3))->file==4)||($board->get_king_square(abs($color_to_move-3))->file==5))&&($color_to_move==1)
				||($board->get_king_square(abs($color_to_move-3))->rank==9)&&(($board->get_king_square(abs($color_to_move-3))->file==4)||($board->get_king_square(abs($color_to_move-3))->file==5))&&($color_to_move==2)))
				{
					if(($piece->type==1)&&($piece->square->rank>0)&&($piece->square->rank<9))
						break; 	//If King is holding scepter then no Capture Allowed
				}

				//Kautilya Demotion of Officers
				if(($piece->group=="OFFICER") &&(($ending_square->file==0)||($ending_square->file==9))&&(
					(($ending_square->rank>=0)&&($ending_square->rank<=9))
					)&&(($royalp==FALSE)&&($board->gametype==2))){ // Check of demotion can happen in Truce or No Mans as per Parity
						
						if($piece->type==12)  $dem=-5; 
						else $dem=1;
						$candemote=$board->checkdemotionparity( $board->export_fen(), $piece,$color_to_move,$board);

						if($candemote==TRUE){// then update the parity with new demoted values
						//$piece->type=$piece->type+1;
		
							$new_move = new ChessMove(
								$piece->square,	$ending_square,$ending_square,
								0,
								$piece->color, $piece->type, 
								$capture, $board, $store_board_in_moves,
								FALSE,$controlled_move
								);

								if(($capture==true) && ($ending_square->mediatorrank!=null)&&($ending_square->mediatorfile!=null)){
									$mediatorpiece = clone $piece;
									$endpiece = clone $board->board[$ending_square->rank][$ending_square->file];

									if(($piece->square->mediatorrank!=$ending_square->mediatorrank)&&($piece->square->mediatorfile!=$ending_square->mediatorfile)){
										$mediatorpiece->square->mediatorrank=$ending_square->mediatorrank;
										$mediatorpiece->square->mediatorfile=$ending_square->mediatorfile;
										$mediatorpiece->state="V";
										}
									$sittingpiece=$board->board[$mediatorpiece->square->rank][$mediatorpiece->square->file];
									$board1 = clone $board;
									$board1->board[$mediatorpiece->square->rank][$mediatorpiece->square->file]=$mediatorpiece;
									if($i>=2){
										$moves = self::add_running_capture_moves_to_moves_list($moves, $mediatorpiece, $endpiece, $color_to_move, $board1, $store_board_in_moves,1,$selfbrokencastle,$foebrokencastle);
										break;
										}
									}
								else {
									$new_move1 = new ChessMove( $piece->square, $ending_square,$ending_square, -1, $piece->color, $piece->type, $capture, $board, $store_board_in_moves, false,$controlled_move);
									//$move2 = clone $new_move1;
									//$moves[] = 	$move2;
									$move2 = clone $new_move;
									$move2->set_demotion_piece($piece->type+$dem);
									//check if the king is killed
									if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
										$move2->set_killed_king(TRUE);
									$moves[] = $move2;
									}
							continue;
							}
					}

			//***  Compromised CASTLE Penetration or Normal CASTLE movement in and out without Royal */	No-mans is neither promotion nor demotion zone.
			if(($piece->group=="SEMIROYAL")&&($royalp==false)&&($foebrokencastle==TRUE)&&((($ending_square->rank>=8)&&(($ending_square->file>0)&&($ending_square->file<9))&&($color_to_move==1))||
			(($ending_square->rank<=1)&&(($ending_square->file>0)&&($ending_square->file<9))&&($color_to_move==2))
			))
			{
				$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,12);
				if((($ending_square->rank==1)&&($color_to_move==2))||(($ending_square->rank==8)&&($color_to_move==1))||(($ending_square->rank==9)&&($color_to_move==1))||(($ending_square->rank==0)&&($color_to_move==2))){
					if(($canpromote==TRUE)){// then update the parity with new ptomoted values
						//Force Promotion to add in movelist
						$new_move1 = new ChessMove(
							$piece->square, $ending_square,$ending_square,
							0,
							$piece->color, $piece->type,
							$capture, $board, $store_board_in_moves,
							FALSE,$controlled_move
							);

					$move3 = clone $new_move1;
					$move3-> set_promotion_piece(12);
					$moves[] = $move3;
					}
				}
				continue;
			}
				
			//***  Foe Compromised CASTLE movement witin itself or out of  it without Royal. */
			if((($piece->group=="ROYAL"))&&($royalp==false)&&($foebrokencastle==TRUE)&&
			((($piece->square->rank==0)&&($ending_square->rank==1)&&(($ending_square->file>0)&&($ending_square->file<9))&&($color_to_move==2))||
			(($ending_square->rank==8)&&($piece->square->rank==9)&&(($ending_square->file>0)&&($ending_square->file<9))&&($color_to_move==1))||
			(($piece->square->rank==0)&&($ending_square->rank==0)&&(($ending_square->file>=0)&&($ending_square->file<=9))&&($color_to_move==2))||
			(($ending_square->rank==9)&&($piece->square->rank==9)&&(($ending_square->file>=0)&&($ending_square->file<=9))&&($color_to_move==1))			
			))
			{
						$new_move1 = new ChessMove(
							$piece->square,	$ending_square,$ending_square,
							0,
							$piece->color, $piece->type,
							$capture, $board, $store_board_in_moves,
							FALSE,$controlled_move
							);

					$move3 = clone $new_move1;
					$moves[] = $move3;

				continue;
			}

			//***  Foe Compromised CASTLE movement witin itself or out of  it without Royal. */	
			if((($piece->group=="SEMIROYAL"))&&($royalp==false)&&($foebrokencastle==TRUE)&&
			((($piece->square->rank==0)&&($ending_square->rank==1)&&(($ending_square->file>0)&&($ending_square->file<9))&&($color_to_move==2))||
			(($ending_square->rank==8)&&($piece->square->rank==9)&&(($ending_square->file>0)&&($ending_square->file<9))&&($color_to_move==1))	
			))
			{
						$new_move1 = new ChessMove(
							$piece->square, $ending_square,$ending_square,
							0,
							$piece->color, $piece->type,
							$capture, $board, $store_board_in_moves,
							FALSE,$controlled_move
							);

					$move3 = clone $new_move1;
				continue;
			}
				//CASTLE to TRUCE  Defective ???
				if((($piece->group=="ROYAL"))&&
					(((($ending_square->rank>0)&&($ending_square->rank<9))&&(($ending_square->file==0)||($ending_square->file==9)))&&		
					((($piece->square->rank==0)||($piece->square->rank==9))&&(($piece->square->file>0)&&($piece->square->file<9)))	
					))
					{
						$new_move = new ChessMove(
							$piece->square, $ending_square,$ending_square,
							1,
							$piece->color,$piece->type,
							$capture, $board, $store_board_in_moves,
							FALSE,$controlled_move
						);
	
						$move2 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);
						
						if(( $piece->type == ChessPiece::INVERTEDKING)){
									//$move2-> set_promotion_piece(1);
									//check if the king is killed
									if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
										$move2->set_killed_king(TRUE);
									$moves[] = $move2;
									$move3 = clone $new_move;
									$move3-> set_promotion_piece(1);
									//check if the king is killed
									if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
										$move3->set_killed_king(TRUE);
									$moves[] = $move3;
								}
						else if(( $piece->type == ChessPiece::KING)){
							//$move2-> set_promotion_piece(1);
							//check if the king is killed
							if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);
							$moves[] = $move2;
							$move3 = clone $new_move;
							$move3-> set_promotion_piece(2);
							//check if the king is killed
							if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);
							$moves[] = $move3;
						}
						elseif(( $piece->type == ChessPiece::ARTHSHASTRI)){
							$moves[] = $move2;
							//$move2-> set_promotion_piece(6);
							//check if the king is killed
							if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);
						}
						/*elseif( $piece->type == ChessPiece::ARTHSHASTRI){
							$moves[] = $move2;
						}
						elseif(( $piece->type == ChessPiece::KING)){ 
							$moves[] = $move2;
							$move3 = clone $new_move;
							$move3-> set_promotion_piece(2);
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);
							$moves[] = $move3;
							}*/
							continue;
					}
				//ROYAL Guys from CASTLE to WAR  Defective ???
				else if((($piece->group=="ROYAL"))&&
					(((($ending_square->rank>0)&&($ending_square->rank<9))&&(($ending_square->file>=0)&&($ending_square->file<=9)))&&		
					((($piece->square->rank==0)||($piece->square->rank==9))&&(($piece->square->file>0)&&($piece->square->file<9)))	
					))
					{
						$new_move = new ChessMove(
							$piece->square,	$ending_square,$ending_square,
							1,					
							$piece->color,	$piece->type,
							$capture, $board, $store_board_in_moves,
							FALSE,$controlled_move
						);
	
						$move2 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);
	
						if(( $piece->type == ChessPiece::KING)){
							//$move2-> set_promotion_piece(1);
							//check if the king is killed
							if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);
							$moves[] = $move2;
							$move3 = clone $new_move;
							$move3-> set_promotion_piece(2);
							//check if the king is killed
							if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);
							$moves[] = $move3;
						}
						elseif(( $piece->type == ChessPiece::ARTHSHASTRI)){
							$moves[] = $move2;
							//$move2-> set_promotion_piece(6);
							//check if the king is killed
							if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);
						}
						/*elseif( $piece->type == ChessPiece::ARTHSHASTRI){
							$moves[] = $move2;
						}
						elseif(( $piece->type == ChessPiece::KING)){ 
							$moves[] = $move2;
							$move3 = clone $new_move;
							$move3-> set_promotion_piece(2);
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);
							$moves[] = $move3;
							}*/
							continue;
					}
				//ROYAL Guys from CASTLE to castle or castle to No Mans
				elseif((($piece->group=="ROYAL"))&&
					(((($ending_square->rank==0)||($ending_square->rank==9))&&(($ending_square->file>=0)&&($ending_square->file<=9)))&&		
					((($piece->square->rank==0)||($piece->square->rank==9))&&(($piece->square->file>0)&&($piece->square->file<9)))	
					))
					{
						$new_move = new ChessMove(
							$piece->square, $ending_square,$ending_square,
							1,					
							$piece->color, $piece->type,
							$capture, $board, $store_board_in_moves,
							FALSE,$controlled_move
						);
	
						$move2 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);
						if(( $piece->type == ChessPiece::ARTHSHASTRI)&&($ending_square->file!=4)&&($ending_square->file!=5)){
							$moves[] = $move2;
						}
						elseif((( $piece->type == ChessPiece::KING))&&($ending_square->file!=4)&&($ending_square->file!=5)){ 
							$moves[] = $move2;
							$move3 = clone $new_move;
							$move3-> set_promotion_piece(2);
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);
							$moves[] = $move3;
							}
						elseif(($ending_square->file==4)||($ending_square->file==5)){
							if(($piece->type == ChessPiece::KING)){
								$moves[] = $move2;
								$move3 = clone $new_move;
								$move3-> set_promotion_piece(2);
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);
								$moves[] = $move3;
								}

							if(($piece->type == ChessPiece::ARTHSHASTRI))
								$moves[] = $move2;

							/*if(($piece->type == ChessPiece::ARTHSHASTRI)){
								$move2-> set_promotion_piece(5);
								$moves[] = $move2;
								}
							*/

							if(($piece->type == ChessPiece::KING)){
									//$move2-> set_promotion_piece(1);
									$moves[] = $move2;
									$move3 = clone $new_move;
									$move3-> set_promotion_piece(2);
									$moves[] = $move3;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);
								}
							}
						elseif(($ending_square->file<4)||($ending_square->file>5)){ 
							if(($piece->type == ChessPiece::KING)){
								//$move2-> set_promotion_piece(1);
								$moves[] = $move2;
								$move3 = clone $new_move;
								$move3-> set_promotion_piece(2);
								//check if the king is killed
								if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
									$move3->set_killed_king(TRUE);
									$moves[] = $move3;
								}

							if(($piece->type == ChessPiece::ARTHSHASTRI))
								$moves[] = $move2;

							/*if(($piece->type == ChessPiece::ARTHSHASTRI)){
								$move2-> set_promotion_piece(6);
								$moves[] = $move2;
								}
								*/

							if(($piece->type == ChessPiece::KING)){
								$moves[] = $move2;
								$move3 = clone $new_move;
								$move3-> set_promotion_piece(2);
								$moves[] = $move3;
								}
							}
						continue;
					}
				//ROYAL Guys from WAR to CASTLE (non-Scepter) or to No mans defective
				elseif(($piece->group=="ROYAL")&&
					((($piece->square->file>0)&&($piece->square->file<9))&&(($piece->square->rank>0)&&($piece->square->rank<9))&&(($ending_square->rank==0)||($ending_square->rank==9))&&(($ending_square->file<4)||($ending_square->file>5))))
					{
						//$moves-> set_promotion_piece(2);
						$new_move = new ChessMove(
							$piece->square, $ending_square,$ending_square,
							1,
							$piece->color, $piece->type,
							$capture, $board, $store_board_in_moves,
							FALSE,$controlled_move
						);
	
						$move2 = clone $new_move;
	
						if(( $piece->type == ChessPiece::INVERTEDKING)&&( $piece->type != ChessPiece::ARTHSHASTRI)&&( $piece->type != ChessPiece::SPY)){
							//$move2-> set_demotion_piece($piece->type+$dem);
							$move2-> set_promotion_piece(1);
						}
						/*elseif(( $piece->type != ChessPiece::KING)&&( $piece->type != ChessPiece::INVERTEDKING)&&( $piece->type == ChessPiece::ARTHSHASTRI)&&( $piece->type != ChessPiece::SPY)){
							//$move2-> set_demotion_piece($piece->type+$dem);
							$move2-> set_promotion_piece(6);
						}
						*/
						$moves[] = $move2;
						$move3 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);

						if(( $piece->type == ChessPiece::KING)&&( $piece->type != ChessPiece::ARTHSHASTRI)&&( $piece->type != ChessPiece::SPY)){
								$move3-> set_promotion_piece(2);
							}

						$moves[] = $move3;
					}
				/* ROYAL Guys  back from any location to CASTLE to own Scepters*/	
				elseif(($piece->group=="ROYAL")&&((((($piece->square->rank==0)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file==4) ||($ending_square->file==5))&&($color_to_move==1)
					)||(($piece->square->rank==9)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file==4)||($ending_square->file==5))&&($color_to_move==2)
					)))|| /*CASTLE KING becoming full king*/
					((($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0) && ($piece->square->file<9))&&(($ending_square->file==4) ||($ending_square->file==5))&&(($ending_square->rank==0)||($ending_square->rank==9)))
					)){
						//$moves-> set_promotion_piece(2);
						$new_move = new ChessMove(
							$piece->square, $ending_square,$ending_square,
							1,
							$piece->color, $piece->type,
							$capture, $board, $store_board_in_moves,
							FALSE,$controlled_move
						);
	
							$move2 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);

							if(( $piece->type == ChessPiece::KING)&&
							(((($piece->square->rank==0)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file==4) ||($ending_square->file==5))&&
							($color_to_move==1))||(($piece->square->rank==9)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file==4)||($ending_square->file==5))&&($color_to_move==2)	)))
							){
								$moves[] = $move2;
								$move3 = clone $new_move;
								$move3-> set_promotion_piece(2);
								//check if the king is killed
								if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
									$move3->set_killed_king(TRUE);
								$moves[] = $move3;
							}
							elseif((( $piece->type == ChessPiece::INVERTEDKING))&&
							((($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0) && ($piece->square->file<9))&&
							(($ending_square->file==4) ||($ending_square->file==5))&&((($ending_square->rank==0)&&($color_to_move==1))||(($ending_square->rank==9)&&($color_to_move==2))))
							){
								//$move2-> set_promotion_piece(1);
								$moves[] = $move2;
								$move3 = clone $new_move;
								//check if the king is killed
								if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
									$move3->set_killed_king(TRUE);
								$move3-> set_promotion_piece(1);
								$moves[] = $move3;
							}
							elseif((( $piece->type == ChessPiece::KING))&&
							((($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0) && ($piece->square->file<9))&&
							(($ending_square->file==4) ||($ending_square->file==5))&&((($ending_square->rank==0)&&($color_to_move==1))||(($ending_square->rank==9)&&($color_to_move==2))))
							){
								//$move2-> set_promotion_piece(1);
								$moves[] = $move2;
								$move3 = clone $new_move;
								//check if the king is killed
								if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
									$move3->set_killed_king(TRUE);
								$move3-> set_promotion_piece(2);
								$moves[] = $move3;
							}
							elseif(( $piece->type == ChessPiece::ARTHSHASTRI)&&
							(((($piece->square->rank==0)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file==4) ||($ending_square->file==5))&&
							($color_to_move==1))||(($piece->square->rank==9)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file==4)||($ending_square->file==5))&&($color_to_move==2)	)))
							){
								$moves[] = $move2;
							}
							elseif(( $piece->type == ChessPiece::ARTHSHASTRI)&&
							((($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0) && ($piece->square->file<9))&&
							(($ending_square->file==4) ||($ending_square->file==5))&&((($ending_square->rank==0)&&($color_to_move==1))||(($ending_square->rank==9)&&($color_to_move==2))))
							){
								//$move2-> set_promotion_piece(5);
								$moves[] = $move2;
							}

					}
			  	/* from CASTLE to non Scepters but within own CASTLE */		
				elseif(($piece->group=="ROYAL")&&((((($piece->square->rank==0)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file!=4) && ($ending_square->file!=5))&&($color_to_move==1)
					)||(($piece->square->rank==9)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file!=4)&&($ending_square->file!=5))&&($color_to_move==2)
					)))
					)){
						//$moves-> set_promotion_piece(2);
						$new_move = new ChessMove(
							$piece->square, $ending_square,$ending_square,
							1,
							$piece->color,$piece->type,
							$capture,$board, $store_board_in_moves,
							FALSE,$controlled_move
						);
	
							$move2 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);

							if(( $piece->type == ChessPiece::KING)&&
							(((($piece->square->rank==0)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file!=4) &&($ending_square->file!=5))&&
							($color_to_move==1))||(($piece->square->rank==9)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file!=4)&&($ending_square->file!=5))&&($color_to_move==2)	)))
							){
								//$move2-> set_promotion_piece(1);
								$moves[] = $move2;
								$move3 = clone $new_move;
								$move3-> set_promotion_piece(2);
								//check if the king is killed
								if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
									$move3->set_killed_king(TRUE);
								$moves[] = $move3;
							}
							elseif(( $piece->type == ChessPiece::KING)&&
							(((($piece->square->rank==0)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file!=4) &&($ending_square->file!=5))&&
							($color_to_move==1))||(($piece->square->rank==9)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file!=4)&&($ending_square->file!=5))&&($color_to_move==2)	)))
							){
								$moves[] = $move2;
								$move3 = clone $new_move;
								$move3-> set_promotion_piece(2);
								//check if the king is killed
								if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
									$move3->set_killed_king(TRUE);
								$moves[] = $move3;
							}
							elseif((($piece->type == ChessPiece::ARTHSHASTRI))&&
							(((($piece->square->rank==0)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file!=4) &&($ending_square->file!=5))&&
							($color_to_move==1))||(($piece->square->rank==9)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file!=4)&&($ending_square->file!=5))&&($color_to_move==2)	)))
							){
								//if($piece->type != ChessPiece::ARTHSHASTRI)
									//$move2-> set_promotion_piece(6);
								$moves[] = $move2;
							}

					}
				/* From Truce to CASTLE or WAR*/
				elseif(($piece->group=="ROYAL")&&(($piece->type == ChessPiece::KING)||  ( $piece->type == ChessPiece::ARTHSHASTRI) )&&
					((($piece->square->rank>0)&&($piece->square->rank<9)&&(($piece->square->file==0) || ($piece->square->file==9)))||
						(($piece->square->file>=0)&&($piece->square->file<=9)&&(($piece->square->rank==0) || ($piece->square->rank==9))&&($ending_square->rank!=$piece->square->rank))||
						(($piece->square->file>=0)&&($piece->square->file<=9)&&(($piece->square->rank==0) || ($piece->square->rank==9))&&($ending_square->rank==$piece->square->rank)&&
						(($ending_square->file<4)||($ending_square->file>5)))
						))
					{
						$new_move = new ChessMove(
							$piece->square,	$ending_square,$ending_square,
							1,
							$piece->color,$piece->type,
							$capture,$board, $store_board_in_moves,
							FALSE,$controlled_move
						);
	
	
						$move3 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);

						if(( $piece->type == ChessPiece::KING)&&( $piece->type != ChessPiece::ARTHSHASTRI)){												
							$moves[] = $move3;
							$move3 = clone $new_move;
							$move3-> set_promotion_piece(2);
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);
								$moves[] = $move3;
							}

						/*if(( $piece->type != ChessPiece::KING)&&( $piece->type == ChessPiece::ARTHSHASTRI)){												
								//$move3-> set_promotion_piece(6);
							}
						*/	

						$moves[] = $move3;
						continue;
					}
				/***** Add for ArthShahstri logoc also */	
				elseif(($piece->group=="ROYAL")&&(($ending_square->file>0)&&($ending_square->file<9)||((($ending_square->rank==0)||($ending_square->rank==9)) &&($ending_square->file!=4) && ($ending_square->file!=5)))&&
					(((( $piece->type == ChessPiece::KING)||( $piece->type == ChessPiece::ARTHSHASTRI))&&
					((($piece->square->rank==0)&&(($piece->square->file==4) ||($piece->square->file==5))&&($color_to_move==1)
					)||(($piece->square->rank==9)&&(($piece->square->file==4)||($piece->square->file==5))&&($color_to_move==2)
					)))|| ((( $piece->type == ChessPiece::KING) ||( $piece->type == ChessPiece::ARTHSHASTRI))&& (($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0) && ($piece->square->file<9)))
					)){
						//$moves-> set_promotion_piece(2);
						$new_move = new ChessMove(
							$piece->square, $ending_square,$ending_square,
							1,
							$piece->color, $piece->type,
							$capture, $board, $store_board_in_moves,
							FALSE,$controlled_move
						);

						$move2 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);

						if((( $piece->type == ChessPiece::KING))&&((($ending_square->rank==0)&&($color_to_move==2))||(($ending_square->rank==9)&&(($color_to_move==1))))
						&&(($ending_square->file==5)||($ending_square->file==4))){	
							$move2-> set_promotion_piece(1);
						}
						/*else
						if(( $piece->type == ChessPiece::ARTHSHASTRI)&&((($ending_square->rank==0)&&($color_to_move==2))||(($ending_square->rank==9)&&(($color_to_move==1))))
						&&(($ending_square->file==5)||($ending_square->file==4))){	
							$move2-> set_promotion_piece(5);
						}
						*/

						$moves[] = $move2;
						$move3 = clone $new_move;
						if( $piece->type == ChessPiece::KING){
								$move3-> set_promotion_piece(2);
							}
						/*else
						if(( $piece->type == ChessPiece::ARTHSHASTRI)&&((($ending_square->rank==0)&&($color_to_move==2))||(($ending_square->rank==9)&&(($color_to_move==1))))
						&&(($ending_square->file!=5)&&($ending_square->file!=4))){
								$move3-> set_promotion_piece(6);
							}
						*/	
						$moves[] = $move3;
					}
				/***** Add for ArthShahstri logoc also */	
				elseif(($piece->group=="ROYAL")&&(($piece->type == ChessPiece::KING)||($piece->type == ChessPiece::ARTHSHASTRI))&&
					(($piece->square->rank>0)&&($piece->square->rank<9)&&(($piece->square->file==0) || ($piece->square->file==9))))
					{
				
						$moves[] = new ChessMove(
							$piece->square, $ending_square,$ending_square,
							0,
							$piece->color, $piece->type,
							$capture, $board, $store_board_in_moves,
							false,$controlled_move);

						$new_move = new ChessMove(
							$piece->square, $ending_square,$ending_square,
							1,					
							$piece->color, $piece->type,
							$capture, $board, $store_board_in_moves,
							FALSE,$controlled_move
						);
	
							$move3 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);

							if(( $piece->type != ChessPiece::INVERTEDKING)){												
								$move3-> set_promotion_piece(2);
							};

							$moves[] = $move3;
					}
				/***** Add for ArthShahstri logoc also */	
				elseif(($piece->group=="ROYAL")&&(( $piece->type == ChessPiece::KING)||( $piece->type == ChessPiece::ARTHSHASTRI))&&
					((($piece->square->rank==0)&&(($piece->square->file==4) ||($piece->square->file==5))&&($color_to_move==1)
					)||(($piece->square->rank==9)&&(($piece->square->file==4)||($piece->square->file==5))&&($color_to_move==2)
					))){
						//$moves-> set_promotion_piece(2);
						$new_move = new ChessMove(
							$piece->square, $ending_square,$ending_square,
							1,
							$piece->color, $piece->type,
							$capture, $board, $store_board_in_moves,
							false,$controlled_move
						);
		
						$move2 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);

						//$move2-> set_demotion_piece($piece->type+$dem);
						if(( $piece->type == ChessPiece::KING)){
							//$move2-> set_promotion_piece(1);
							$moves[] = $move2;
							$move3 = clone $new_move;
							//check if the king is killed
							if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);
							$move3-> set_promotion_piece(2);
							$moves[] = $move3;
						}
							
						if(( $piece->type == ChessPiece::ARTHSHASTRI)){		
							//$move2-> set_promotion_piece(6);
							$moves[] = $move2;
							}
					}
				 /***** Add for ArthShahstri logoc also */	
				elseif(($piece->group=="ROYAL")&&(( $piece->type == ChessPiece::KING)||( $piece->type == ChessPiece::ARTHSHASTRI))&&
					((($piece->square->rank==0)&&(($ending_square->file==4) ||($ending_square->file==5))&&($color_to_move==1)
					)||(($piece->square->rank==9)&&(($ending_square->file==4)||($ending_square->file==5))&&($color_to_move==2)
					))){
						//$moves-> set_promotion_piece(2);
						$new_move = new ChessMove(
							$piece->square, $ending_square,$ending_square,
							1,
							$piece->color, $piece->type,
							$capture, $board, $store_board_in_moves,
							false,$controlled_move
						);
		
						$move2 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);

						//$move2-> set_demotion_piece($piece->type+$dem);
						if( $piece->type == ChessPiece::KING){
							//$move2-> set_promotion_piece(1);
							$moves[] = $move2;
							$move3 = clone $new_move;
							//check if the king is killed
							if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);

							$move3-> set_promotion_piece(2);
							$moves[] = $move3;
						}
						
						if( $piece->type == ChessPiece::ARTHSHASTRI){
							//$move2-> set_promotion_piece(5);
							$moves[] = $move2;
							}
					}
				else{
					/* Classical. Officers can penetrate the compromised CASTLE with royals or with General*/
					if(($piece->group=="OFFICER") &&($board->board[$ending_square->rank][$ending_square->file]==null)&&((($piece->square->rank>0)&&($piece->square->rank<9))&&(($ending_square->file>=0)||($ending_square->file<=9))&&(
						(($ending_square->rank==0)||($ending_square->rank==9))) && (($board->gametype==1)))){ 

							if(($royal_royalp==true)||(($selfbrokencastle==true)&&($ending_square->rank==0)&&($color_to_move==1)) || (($selfbrokencastle==true)&&($ending_square->rank==9)&&($color_to_move==2))||
							(($foebrokencastle==true)&&($ending_square->rank==0)&&($color_to_move==2))||(($foebrokencastle==true)&&($ending_square->rank==9)&&($color_to_move==1))){
								$new_move = new ChessMove(
									$piece->square, $ending_square,$ending_square,
									0,
									$piece->color, $piece->type,
									$capture, $board, $store_board_in_moves,
									FALSE,$controlled_move
									);

								$move2 = clone $new_move;
								$moves[] = $move2;
							}
							continue;
						}
					//Officers cannot jump from CASTLE or No Mans to WAR.But with neighbour Royals, it is possible
					elseif(($piece->group=="OFFICER") &&($board->board[$ending_square->rank][$ending_square->file]==null)&&((($piece->square->file==0)||($piece->square->file==9))&&(($piece->square->rank>=0)&&($piece->square->rank<=9))&&(($ending_square->file>0)||($ending_square->file<9))&&(
							(($ending_square->rank>0)&&($ending_square->rank<9))) && (($board->gametype==1)))){ 
	
								if($royal_royalp==true){
									$new_move = new ChessMove(
										$piece->square, $ending_square,$ending_square,
										0,
										$piece->color, $piece->type,
										$capture, $board, $store_board_in_moves,
										FALSE,$controlled_move
										);
	
									$move2 = clone $new_move;
									$moves[] = $move2;
								}
								break;
							}
					/*Officer Cannot kill anyone from war to  CASTLE*/		
					elseif(($piece->group=="OFFICER") &&($board->board[$ending_square->rank][$ending_square->file]!=null)&&((($piece->square->rank>0)&&($piece->square->rank<9))&&(($ending_square->file>=0)||($ending_square->file<=9))&&(
						(($ending_square->rank==0)||($ending_square->rank==9))))){ 
						}

					/* Classical General or Officer can penetrate the CASTLE with the help of royal. But cannot Kill Inside*/
					if(($piece->group=="OFFICER") &&($board->board[$ending_square->rank][$ending_square->file]!=null)&&((($piece->square->rank>0)&&($piece->square->rank<9))&&(($ending_square->file>=0)&&($ending_square->file<=9))&&(
						((($ending_square->rank==0)&&($selfbrokencastle==false)&&($color_to_move==1))||(($ending_square->rank==9)&&($selfbrokencastle==false)&&($color_to_move==2))||
						(($ending_square->rank==0)&&($foebrokencastle==false)&&($color_to_move==2))||(($ending_square->rank==9)&&($foebrokencastle==false)&&($color_to_move==1)))) && (($royalp==true)&&($board->gametype==1)) /*&& ($piece->type==ChessPiece::GENERAL) */)){
							if ($capture==false) {
								$new_move = new ChessMove(
									$piece->square, $ending_square,$ending_square,
									0,
									$piece->color, $piece->type,
									$capture, $board, $store_board_in_moves,
									false,$controlled_move
								);

								$move2 = clone $new_move;
								$moves[] = $move2;
							}
							continue;
						}

					/* Classical General or Officer can kill inside the compromised castle.*/
					if(($piece->group=="OFFICER") &&($board->board[$ending_square->rank][$ending_square->file]!=null)&&((($piece->square->rank>0)&&($piece->square->rank<9))&&(($ending_square->file>0)&&($ending_square->file<9))&&(
						((($ending_square->rank==0)&&($selfbrokencastle==true)&&($color_to_move==1))||(($ending_square->rank==9)&&($selfbrokencastle==true)&&($color_to_move==2))||
						(($ending_square->rank==0)&&($foebrokencastle==true)&&($color_to_move==2))||(($ending_square->rank==9)&&($foebrokencastle==true)&&($color_to_move==1)))) && (($royalp==true)&&($board->gametype==1)) /*&& ($piece->type==ChessPiece::GENERAL) */)){
							if ($capture==true) {
								$new_move = new ChessMove(
									$piece->square, $ending_square,$ending_square,
									0,
									$piece->color, $piece->type,
									$capture, $board, $store_board_in_moves,
									false,$controlled_move
								);

								$move2 = clone $new_move;
								$moves[] = $move2;
							}
							continue;
						}
					/** Can kill out of the Compromised castle.. Promotion logic not added here */
					if( (($selfbrokencastle==true)&&( $piece->square->rank==9)&&($ending_square->rank<=5)&&($color_to_move==2)||
						($foebrokencastle==true)&&($ending_square->rank>=4)&&($piece->square->rank==0)&&($color_to_move==2))||  
						(($selfbrokencastle==true)&&( $piece->square->rank==0)&&($ending_square->rank>=4)&&($color_to_move==1)||
						($foebrokencastle==true)&&($ending_square->rank<=5)&&($piece->square->rank==9)&&($color_to_move==1)))
						{ 
							$new_move = new ChessMove(
								$piece->square, $ending_square,$ending_square,
								0,
								$piece->color, $piece->type,
								$capture, $board, $store_board_in_moves,
								FALSE,$controlled_move
								);

							$move2 = clone $new_move;
							$moves[] = $move2;
							//break; //Only if captured 
						}
					elseif(($piece->group=="OFFICER") &&($board->board[$ending_square->rank][$ending_square->file]!=null)&&((($piece->square->rank>0)&&($piece->square->rank<9))&&(($ending_square->file>=0)||($ending_square->file<=9))&&(
					(($ending_square->rank==0)||($ending_square->rank==9))))){ /*Cannot kill anyone from war to  CASTLE*/
						}
					elseif(($piece->group=="OFFICER") &&(($ending_square->file==0)||($ending_square->file==9))&&(
							(($ending_square->rank>=0)&&($ending_square->rank<=9))
							)&&(($royalp==FALSE)&&($board->gametype==1))){
								continue; // Check of demotion can happen in Truce or No Mans as per Parity
						}
					/* Classical General can penetrate the TRUCE with the help of royal*/	
					elseif(($piece->type==ChessPiece::GENERAL)&&($piece->group=="OFFICER") &&(($ending_square->file==0)||($ending_square->file==9))&&(
							(($ending_square->rank>=0)&&($ending_square->rank<=9))
							)&&(($royal_royalp==true)&&($board->gametype==1))){
				
									$new_move = new ChessMove(
										$piece->square, $ending_square,$ending_square,
										0,
										$piece->color, $piece->type,
										$capture, $board, $store_board_in_moves,
										FALSE,$controlled_move
										);
		
									$move2 = clone $new_move;
									$moves[] = $move2;
									continue;
							}
					/* Classical Officers can penetrate the TRUCE with the help of royal*/	
					elseif(($piece->type!=ChessPiece::GENERAL)&&($piece->group=="OFFICER") &&(($ending_square->file==0)||($ending_square->file==9))&&(
						(($ending_square->rank>=0)&&($ending_square->rank<=9))
						)&&(($royal_royalp==true)&&($board->gametype==1))){
			
								$new_move = new ChessMove(
									$piece->square, $ending_square,$ending_square,
									0,
									$piece->color, $piece->type,
									$capture, $board, $store_board_in_moves,
									FALSE,$controlled_move
									);
	
								$move2 = clone $new_move;
								$moves[] = $move2;

								if((($piece->group=="OFFICER")&&($piece->square->file>=0)&&($piece->square->file<=9)))
								{ // Check of promotion can happen within warzone or even in compromised
									$skipxy=$piece->square;
									$droyalp=self::has_royal_neighbours( 
										self::KING_DIRECTIONS,
										$skipxy,
										$ending_square,
										$color_to_move,
										$board
										);
				
									$targetpiece=clone $piece;
									$targetpiece->square->file=	$ending_square->file;
									$targetpiece->square->rank=	$ending_square->rank;
				
									$dgeneralp=self::check_general_royal_neighbours_promotion( 
										self::KING_DIRECTIONS,
										$targetpiece,
										$color_to_move,
										$board
										);				
				
									if(($canbepromoted==1)&&(($droyalp==TRUE) ||($dgeneralp==true)))
									{ // Check of demotion can happen
										$dem=-1;
				
										$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,$piece->type-1);
				
										if($canpromote==TRUE){// then update the parity with new demoted values
											//$piece->type=$piece->type+1;
											//Force Promotion to add in movelist	
											$new_move1 = new ChessMove(
												$piece->square,	$ending_square,$ending_square,
												0,
												$piece->color, $piece->type,
												$capture, $board, $store_board_in_moves,
												FALSE,$controlled_move
												);
				
											$move3 = clone $new_move1;
											//check if the king is killed
											if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
												$move3->set_killed_king(TRUE);
											$move3-> set_promotion_piece($piece->type+$dem);
											$moves[] = $move3;
										}
									}
								}

								continue;
						}
						elseif(($piece->group=="OFFICER") &&(($ending_square->file==0)||($ending_square->file==9))&&(
							(($ending_square->rank>=0)&&($ending_square->rank<=9))
							)&&(($royal_royalp==false)&&($board->gametype==1))){
									break;
							}
					else if((($board->controlled_color==$piece->color)&&($piece->color==$board->color_to_move)&&($controlled_move==true)))
					{
						$new_move = new ChessMove(
							$piece->square, $ending_square,$ending_square,
							0,
							$piece->color, $piece->type,
							$capture, $board, $store_board_in_moves,
							false,$controlled_move
						);

							//y$new_move1 = new ChessMove( $piece->square, $ending_square,$ending_square, -1, $piece->color, $piece->type, $capture, $board, $store_board_in_moves, false);
							//$move2 = clone $new_move1;
							//$moves[] = 	$move2;
							$move2 = clone $new_move;
							//check if the king is killed
							if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);
							$moves[] = $move2;
							continue;
					}
					else if(($controlled_move==false))
					{
						$new_move = new ChessMove(
							$piece->square, $ending_square,$ending_square,
							0,
							$piece->color, $piece->type,
							$capture, $board, $store_board_in_moves,
							false,$controlled_move
						);

						if(($capture==true) && ($ending_square->mediatorrank!=null)&&($ending_square->mediatorfile!=null)){
							$mediatorpiece = clone $piece;
							$endpiece = clone $board->board[$ending_square->rank][$ending_square->file];

							if(($piece->square->mediatorrank!=$ending_square->mediatorrank)&&($piece->square->mediatorfile!=$ending_square->mediatorfile)){
								$mediatorpiece->square->mediatorrank=$ending_square->mediatorrank;
								$mediatorpiece->square->mediatorfile=$ending_square->mediatorfile;
								$mediatorpiece->state="V";
								}
							$sittingpiece=$board->board[$mediatorpiece->square->rank][$mediatorpiece->square->file];
							$board1 = clone $board;
							$board1->board[$mediatorpiece->square->rank][$mediatorpiece->square->file]=$mediatorpiece;
							if($i>=2){
								$moves = self::add_running_capture_moves_to_moves_list($moves, $mediatorpiece, $endpiece, $color_to_move, $board1, $store_board_in_moves,1,$selfbrokencastle,$foebrokencastle);
								break;
							}
							//else 
								//continue;
						}
						else {
							//y$new_move1 = new ChessMove( $piece->square, $ending_square,$ending_square, -1, $piece->color, $piece->type, $capture, $board, $store_board_in_moves, false);
							//$move2 = clone $new_move1;
							//$moves[] = 	$move2;
							$move2 = clone $new_move;
							//check if the king is killed
							if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);
							$moves[] = $move2;
							}
					}
				}
		
			if((($piece->group=="OFFICER")&&($piece->square->file>=0)&&($piece->square->file<=9)))
				{ // Check of promotion can happen within warzone or even in compromised
					$skipxy=$piece->square;
					$droyalp=self::has_royal_neighbours( 
						self::KING_DIRECTIONS,
						$skipxy,
						$ending_square,
						$color_to_move,
						$board
						);

					$targetpiece=clone $piece;
					$targetpiece->square->file=	$ending_square->file;
					$targetpiece->square->rank=	$ending_square->rank;

					$dgeneralp=self::check_general_royal_neighbours_promotion( 
						self::KING_DIRECTIONS,
						$targetpiece,
						$color_to_move,
						$board
						);

					if(($canbepromoted==1)&&(($droyalp==TRUE) ||($dgeneralp==true)))
					{ // Check of demotion can happen
						$dem=-1;

						$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,$piece->type-1);

						if($canpromote==TRUE){// then update the parity with new demoted values
							//$piece->type=$piece->type+1;
							//Force Promotion to add in movelist	
							$new_move1 = new ChessMove(
								$piece->square,	$ending_square,$ending_square,
								0,
								$piece->color, $piece->type,
								$capture, $board, $store_board_in_moves,
								FALSE,$controlled_move
								);

							$move3 = clone $new_move1;
							//check if the king is killed
							if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);
							$move3-> set_promotion_piece($piece->type+$dem);
							$moves[] = $move3;
						}
					}
				}

			if ( $capture ) { /* stop sliding*/	break; 	}

				// empty square
				// continue sliding
				// continue;
			}
		}
	}

		return $moves;
	}
	
	static function add_capture_moves_to_moves_list(
		array $directions_list,
		array $moves,
		ChessPiece $piece,
		$color_to_move,
		ChessBoard $board,
		bool $store_board_in_moves,
		int $cankill,
		bool $selfbrokencastle,
		bool $foebrokencastle
	): array {
		$controlled_move=false;
		/*if($piece->type==ChessPiece::KNIGHT)
			$ttt=1;
		if($piece->type==ChessPiece::GENERAL)
			$ttt=1;*/
		
			$tempDirection=null;
			$officerp=TRUE; 
			$mtype=1;//slide //2 jump
			$lastaccessiblerow=-1;
			$tempDirection=self::get_Retreating_ARMY_directions(
				$piece,
				$color_to_move,
				$board,
				$mtype
			);

			if (isset($tempDirection) && is_array($tempDirection)){
				if(!empty($tempDirection))
				$directions_list=$tempDirection;

				$lastaccessiblerow=self::get_LastKingRow(
					$piece,
					$color_to_move,
					$board,
					$mtype
					);
			}
	
			$tempDirection=null;

			if(($piece->square->rank==5)&&($piece->square->file==4)){
				$piece->square->rank;
			}

			$officer_royalp=self::has_royal_neighbours( self::KING_DIRECTIONS, $piece->square, $piece->square, $color_to_move, $board );
	
				$officerp=self::check_officers_neighbours( /**/
					self::KING_DIRECTIONS,
					$piece,
					$color_to_move,
					$board,
					'exclude'	);
				
			$officerp;
			$enemytrapped=false;

			if($piece->controlledpiece==true) $officerp=self::check_uncontrolled_officers_neighbours(self::KING_DIRECTIONS, $piece, $color_to_move, $board, 'exclude',$piece->controlledpiece);

			
		//pawn has no surrounding officer then also it is considered as trapped	
		self::check_trapped_piece($piece,$color_to_move, $board,'exclude');
		if(($officerp==false)&&($piece->type==13)){
			//$board->board[ $piece->square->rank][ $piece->square->file]->selftrapped=true;
		}
	
		if(($officerp==TRUE)||($piece->type<13)){

			foreach ( $directions_list as $direction ) {
				$current_xy = self::DIRECTION_OFFSETS[$direction];
				$type=0;

				$ending_square = self::square_exists_and_not_occupied_by_friendly_piece(
					$type,
					'0',
					$piece->square,
					$current_xy[0],
					$current_xy[1],
					$color_to_move,
					$board,
					$cankill,
					FALSE,
					$selfbrokencastle,
					$foebrokencastle
				);
			
				if ( $ending_square ) {
					$capture = FALSE;
				
					if ( $board->board[$ending_square->rank][$ending_square->file] ) {
						if ( $board->board[$ending_square->rank][$ending_square->file]->color != $color_to_move ) {
							$capture = TRUE;
						}

						if(($capture == TRUE)&&($board->board[$ending_square->rank][$ending_square->file]->mortal!=1)){
						continue; /** Only Mortals can be killed */
						}
					}
					if($board->gametype==1){
						if(($ending_square->rank>=0)&&($ending_square->rank<=9)&&(($ending_square->file==0)||($ending_square->file==9))){
							continue;
						}
					}
					if(($board->refugee!=null) && 
					(($board->refugee->square!=null)&& ($board->refugee->square->rank==$ending_square->rank) && ($board->refugee->square->file==$ending_square->file)))
					{
						continue;
					}
					
					$enemypushed=false;
					$enemytrapped=false;
					if ($board->board[$ending_square->rank][$ending_square->file]) {
						$enemytrapped=$board->board[$ending_square->rank][$ending_square->file]->selftrapped;
						$enemypushed = $board->board[$ending_square->rank][$ending_square->file]->selfpushed;

						if ($board->board[$ending_square->rank][$ending_square->file]->color != $color_to_move) {				
							$capture = false;
							//else if(($piece->group=='SOLDIER') && ($board->board[$ending_square->rank][$ending_square->file]->group=='SOLDIER'))
							//$capture = true;
							if(($piece->type<=$board->board[$ending_square->rank][$ending_square->file]->type)&&($cankill==1))
								{
								$capture = true;
								}
							else if(($officer_royalp==true)&&($piece->type>$board->board[$ending_square->rank][$ending_square->file]->type)&&($cankill==1))
								{
								$capture = true;$enemypushed=true;$enemytrapped=true;
								}
							else if(($piece->type>$board->board[$ending_square->rank][$ending_square->file]->type)&&($cankill==1) &&($enemytrapped==true))
								{$capture = true; $enemypushed=false;}//enemytrapped is main condition for junior Strikers
						
							if((($piece->group=='SOLDIER') ||($piece->group=='OFFICER')||(($piece->group=='ROYAL'))) && (($enemytrapped==true)&&($capture==true)))
								{ $capture = true;$enemytrapped=false; }
							else if((($piece->group=='SOLDIER')  ||($piece->group=='OFFICER'))  && ($enemypushed==false))
								{ continue; }
							}
					}
				
					if ((( $capture )&&($cankill==1))||($enemypushed==true)) {

						if(($enemypushed==true) && ($piece->striker==1)){

							$originalpiece = clone $piece;
							$originalpiece->square->file =  $board->board[$ending_square->rank][$ending_square->file]->selfpushedsquare["file"];
							$originalpiece->square->rank =  $board->board[$ending_square->rank][$ending_square->file]->selfpushedsquare["rank"];
							$originalpiece->square->type =  $board->board[$ending_square->rank][$ending_square->file]->type;

							$originalpiece->square->group =  $board->board[$ending_square->rank][$ending_square->file]->group;

							$board->board[$ending_square->rank][$ending_square->file]->state='endcolor:'.$originalpiece->color.',endtype:'.$originalpiece->type.',endmortal:'.$originalpiece->mortal.',endstriker:'.$originalpiece->striker.',endgroup:'.$originalpiece->group.',endnotation:'.$originalpiece->get_fen_symbol().',endrank:'.$originalpiece->square->rank.',endfile:'.$originalpiece->square->file.";";

							$move = new ChessMove(
								$piece->square,
								$ending_square,$ending_square,
								0,
								$piece->color,
								$piece->type,
								false,
								$board,
								$store_board_in_moves,
								FALSE,$controlled_move
							);
							$moves[] = clone $move;
							$move=null;
						}

						//If King is holding scepter then no Capture Allowed by non-royals
						if(($capture==TRUE)&&
						(($board->get_king_square($piece->color)->rank==0)&&(($board->get_king_square($piece->color)->file==5) ||  ($board->get_king_square($piece->color)->file==4)) &&($piece->color==1)
						||($board->get_king_square($piece->color)->rank==9)&&(($board->get_king_square($piece->color)->file==5) || ($board->get_king_square($piece->color)->file==4))&&($piece->color==2)))
						{
							continue;
						}
						//If King is holding scepter then no Capture Allowed by non-royals
						if(($capture==TRUE)&& ($piece->type==13) &&
						(($board->get_arthshastri_square($piece->color)->rank==0)&&(($board->get_arthshastri_square($piece->color)->file==5) || ($board->get_king_square($piece->color)->file==4))&&($piece->color==1)
						||($board->get_arthshastri_square($piece->color)->rank==9)&&(($board->get_arthshastri_square($piece->color)->file==5) || ($board->get_king_square($piece->color)->file==4)) &&($piece->color==2)))
						{
							continue;
						}
				
						if(($capture==TRUE)&&(($ending_square->rank==0)||($ending_square->rank==9)||($ending_square->file==0)||($ending_square->file==9))){
							//Pieces cannot capture the CASTLE or No-Mans location
							continue;
						}

						if(($lastaccessiblerow!=-1)&&($color_to_move==2)&&($ending_square->rank<$lastaccessiblerow)){
							continue;
						}

						if(($lastaccessiblerow!=-1)&&($color_to_move==1)&&($ending_square->rank>$lastaccessiblerow)){
							continue;
						}

						if (( $capture )&&($cankill==1))
							{

							$move = new ChessMove(
								$piece->square,
								$ending_square,$ending_square,
								0,
								$piece->color,
								$piece->type,
								$capture,
								$board,
								$store_board_in_moves,
								FALSE,$controlled_move
							);

							//check if the king is killed
							if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
								$move->set_killed_king(TRUE);

							$moves[] = clone $move;
						}
					}
				}
			}
		}
		
		return $moves;
	}
	
	static function add_running_capture_moves_to_moves_list(
		array $moves,
		ChessPiece $piece,
		ChessPiece $endpiece,
		$color_to_move,
		ChessBoard $board,
		bool $store_board_in_moves,
		int $cankill,
		bool $selfbrokencastle,
		bool $foebrokencastle
	): array {
			$tempDirection=null;$controlled_move=false;
			$mediatorpiece=null;$originalpiece=null;
			$officerp=TRUE; 
			$mtype=1;//slide //2 jump
			$lastaccessiblerow=-1;
			$tempDirection=self::get_Retreating_ARMY_directions(
				$piece,
				$color_to_move,
				$board,
				$mtype
			);

			if (isset($tempDirection) && is_array($tempDirection)){
				if(!empty($tempDirection))
				$directions_list=$tempDirection;

				$lastaccessiblerow=self::get_LastKingRow(
					$piece,
					$color_to_move,
					$board,
					$mtype
					);
			}
	
			$tempDirection=null;

			if(($piece->square->rank==4)&&($piece->square->file==2)){
				$piece->square->rank;
			}

				$officerp=self::check_officers_neighbours( /**/
					self::KING_DIRECTIONS,
					$piece,
					$color_to_move,
					$board,
					'exclude'
				);
				
			$officerp;
			$enemytrapped=false;
			$originalpiece=null;
			/*if($piece->type==9){
				$ttt=1;	}*/

			if($piece->state=='V'){
				$board->board[$piece->square->rank][$piece->square->file]=null;

				if($piece->square->mediatorfile<=-1){
					$piece->square->mediatorfile=$piece->square->mediatorfile*-1;
					$cankill=0;}
				if ($piece->square->mediatorrank<=-1){
					$piece->square->mediatorrank=$piece->square->mediatorrank*-1;
					$cankill=0;}


				$mediatorpiece=clone $piece;
				$mediatorpiece->square->file=$piece->square->mediatorfile;
				$mediatorpiece->square->rank=$piece->square->mediatorrank;
				$mediatorpiece->square->mediatorfile=null;
				$mediatorpiece->square->mediatorrank=null;

				if($board->board[$mediatorpiece->square->rank][$mediatorpiece->square->file]!=null){
					$originalpiece=clone $board->board[$mediatorpiece->square->rank][$mediatorpiece->square->file];
					$originalpiece->state=$originalpiece->state.';V=color:'.$piece->color.',type:'.$piece->type.',mortal:'.$piece->mortal.',striker:'.$piece->striker.',group:'.$piece->group.',notation:'.$piece->get_fen_symbol().',rank:'.$piece->square->mediatorrank.',file:'.$piece->square->mediatorfile.";";
				}
				else if($board->board[$mediatorpiece->square->rank][$mediatorpiece->square->file]==null){
					$originalpiece = clone $piece;
					//$originalpiece= clone $board->board[$mediatorpiece->square->rank][$mediatorpiece->square->file];
					$originalpiece->state=$originalpiece->state.'Fake=color:'.$piece->color.',type:'.$piece->type.',mortal:'.$piece->mortal.',striker:'.$piece->striker.',group:'.$piece->group.',notation:'.$piece->get_fen_symbol().',rank:'.$piece->square->mediatorrank.',file:'.$piece->square->mediatorfile.";";
					//$originalpiece->state=$originalpiece->state.'EndPiece=color:'.$endpiece->color.',type:'.$endpiece->type.',mortal:'.$endpiece->mortal.',striker:'.$endpiece->striker.',group:'.$endpiece->group.',notation:'.$endpiece->get_fen_symbol().',rank:'.$endpiece->square->mediatorrank.',file:'.$piece->square->mediatorfile.";";
				}
				else 
					$originalpiece = clone $piece;
				$board->board[$mediatorpiece->square->rank][$mediatorpiece->square->file]=$originalpiece;
			}

		//pawn has no surrounding officer then also it is considered as trapped	
		/*if(($piece->square->mediatorfile!=null)  && (($piece->square->mediatorrank!=null) )){
			$piece->square->rank=$piece->square->mediatorrank;
			$piece->square->file=$piece->square->mediatorfile;
		}*/

		self::check_trapped_piece($mediatorpiece,$color_to_move, $board,'exclude');

		if((strpos($piece->state,"V")!==FALSE)&&($endpiece!=null)){

			if(($board->board[$mediatorpiece->square->rank][$mediatorpiece->square->file]!=null) &&
			((strpos($board->board[$mediatorpiece->square->rank][$mediatorpiece->square->file]->state,"VFake")!==FALSE))
			&&($board->board[$endpiece->square->rank][$endpiece->square->file]!=null) && (
				($board->board[$endpiece->square->rank][$endpiece->square->file]->selfpushed==true ) ))
			{
				$originalpiece = clone $endpiece;
				$originalpiece->square->file =  $board->board[$endpiece->square->rank][$endpiece->square->file]->selfpushedsquare["file"];
				$originalpiece->square->rank =  $board->board[$endpiece->square->rank][$endpiece->square->file]->selfpushedsquare["rank"];
				$originalpiece->state=$board->board[$mediatorpiece->square->rank][$mediatorpiece->square->file]->state.'endcolor:'.$originalpiece->color.',endtype:'.$originalpiece->type.',endmortal:'.$originalpiece->mortal.',endstriker:'.$originalpiece->striker.',endgroup:'.$originalpiece->group.',endnotation:'.$originalpiece->get_fen_symbol().',endrank:'.$originalpiece->square->rank.',endfile:'.$originalpiece->square->file.";";

				$board->board[$mediatorpiece->square->rank][$mediatorpiece->square->file]=$originalpiece;
			}
		}

		if(($officerp==false)&&($piece->type==13)){
			//$board->board[ $piece->square->rank][ $piece->square->file]->selftrapped=true;
		}
	
		if(($officerp==TRUE)||($piece->type<13)){
			$ending_square= $endpiece->square;

				if ( $ending_square ) {
					$capture = FALSE;
				
					if ( $board->board[$ending_square->rank][$ending_square->file] ) {
						if ( $board->board[$ending_square->rank][$ending_square->file]->color != $color_to_move ) {
							$capture = TRUE;
						}

						if(($capture == TRUE)&&($board->board[$ending_square->rank][$ending_square->file]->mortal!=1)){
							return $moves;
						}
					}
					if($board->gametype==1){
						if(($ending_square->rank>=0)&&($ending_square->rank<=9)&&(($ending_square->file==0)||($ending_square->file==9))){
							return $moves;
						}
					}

					$enemypushed=false;
					$enemytrapped=false;
					if ($board->board[$ending_square->rank][$ending_square->file]) {
						$enemytrapped=$board->board[$ending_square->rank][$ending_square->file]->selftrapped;
						$enemypushed = $board->board[$ending_square->rank][$ending_square->file]->selfpushed;

						if ($board->board[$ending_square->rank][$ending_square->file]->color != $color_to_move) {				
							$capture = false;
							//else if(($piece->group=='SOLDIER') && ($board->board[$ending_square->rank][$ending_square->file]->group=='SOLDIER'))
							//$capture = true;
							if(($piece->type<=$board->board[$ending_square->rank][$ending_square->file]->type)&&($cankill==1))
								{
								$capture = true;
								}
							else if(($piece->elevatedofficer==true)&&($piece->type>$board->board[$ending_square->rank][$ending_square->file]->type)&&($cankill==1))
								{
									$capture = true;$enemypushed=true;$enemytrapped=true;
								}
							else if(($piece->type>$board->board[$ending_square->rank][$ending_square->file]->type)&&($cankill==1) &&($enemytrapped==true))
								{$capture = true; $enemypushed=false;}//enemytrapped is main condition for junior Strikers
						
							if((($piece->group=='SOLDIER') ||($piece->group=='OFFICER')||(($piece->group=='ROYAL'))) && (($enemytrapped==true)&&($capture==true)))
								{ $capture = true;$enemytrapped=false; }
							else if((($piece->group=='SOLDIER')  ||($piece->group=='OFFICER'))  && ($enemypushed==false))
								{ return $moves; }
							}
					}
				
					if ((( $capture )&&($cankill==1))||($enemypushed==true)) {

						if(($enemypushed==true) && ($piece->striker==1)){
							$move = new ChessMove(
								$piece->square,
								$ending_square,$ending_square,
								0,
								$piece->color,
								$piece->type,
								false,
								$board,
								$store_board_in_moves,
								FALSE,$controlled_move
							);
							$moves[] = clone $move;
							$move=null;
						}

						//If King is holding scepter then no Capture Allowed by non-royals
						if(($capture==TRUE)&& ($board->get_king_square($piece->color)!=null) &&
						(($board->get_king_square($piece->color)->rank==0)&&($board->get_king_square($piece->color)->file==4)&&($piece->color==1)
						||($board->get_king_square($piece->color)->rank==9)&&($board->get_king_square($piece->color)->file==5)&&($piece->color==2)))
						{
							return $moves;;
						}
				
						if(($capture==TRUE)&&(($ending_square->rank==0)||($ending_square->rank==9)||($ending_square->file==0)||($ending_square->file==9))){
							//Pieces cannot capture the CASTLE or No-Mans location
							return $moves;;
						}

						if(($lastaccessiblerow!=-1)&&($color_to_move==2)&&($ending_square->rank<$lastaccessiblerow)){
							return $moves;;
						}

						if(($lastaccessiblerow!=-1)&&($color_to_move==1)&&($ending_square->rank>$lastaccessiblerow)){
							return $moves;;
						}

						if (( $capture )&&($cankill==1))
							{

							$move = new ChessMove(
								$piece->square,
								$ending_square,$ending_square,
								0,
								$piece->color,
								$piece->type,
								$capture,
								$board,
								$store_board_in_moves,
								FALSE,$controlled_move
							);

							//check if the king is killed
							if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
								$move->set_killed_king(TRUE);

							$moves[] = clone $move;
						}
					}
				}
		}
		
		return $moves;
	}

	static function add_slide_moves_to_moves_list(
		array $directions_list,
		int $spaces,
		array $moves,
		ChessPiece $piece,
		$color_to_move,
		ChessBoard $board,
		bool $store_board_in_moves,
		int $cankill,
		bool $selfbrokencastle,
		bool $foebrokencastle
	): array {
			//**echo '<li> ChessRuleBook.php #6 function add_slide_moves_to_moves_list called </li>';
			$tempDirection=null;
			$lastaccessiblerow=-1;
			$controlled_move=false;
			$mtype=1;//slide //2 jump
			//Create the Array of Move Types.. This will help in deciding the two types of moves in retrating.. Moving back and to the top border
			$tempDirection=self::get_Retreating_ARMY_directions(
				$piece,
				$color_to_move,
				$board,
				$mtype
			);

			if (isset($tempDirection) && is_array($tempDirection)){
				if(!empty($tempDirection))
				$directions_list=$tempDirection;

				$lastaccessiblerow=self::get_LastKingRow(
					$piece,
					$color_to_move,
					$board,
					$mtype
					);
			}
	
			$tempDirection=null;
			
			$officerp=TRUE; 

			if(($piece->square->rank==8)&&($piece->square->file==0)){
				$piece->square->rank;
			}

			$officerp=self::check_officers_neighbours( /**/
					self::KING_DIRECTIONS,
					$piece,
					$color_to_move,
					$board,
					'include');
				
			$officerp;
			$enemytrapped=false;
			if ($officerp==true) {
				foreach ($directions_list as $direction) {
					for ($i = 1; $i <= $spaces; $i++) {
						$current_xy = self::DIRECTION_OFFSETS[$direction];
						$current_xy[0] *= $i;
						$current_xy[1] *= $i;
						$type=0;
						$ending_square = self::square_exists_and_not_occupied_by_friendly_piece(
							$type,
							'0',
							$piece->square,
							$current_xy[0],
							$current_xy[1],
							$color_to_move,
							$board,
							$cankill,
							FALSE,
							$selfbrokencastle,
							$foebrokencastle
						);
				
						if (! $ending_square) {
							// square does not exist, or square occupied by friendly piece
							// stop sliding
							break;
						}

						$capture = false;
				
						if ($board->board[$ending_square->rank][$ending_square->file]) {
							if ($board->board[$ending_square->rank][$ending_square->file]->color != $color_to_move) {
								//pawn can kill only if senior trapped
								//$enemytrapped=call Trapped_Seniors(ending_square);
								//call pushed_seniors(ending_square);
								//call pushed_junior(ending_square);

								if(($piece->group=='SOLDIER') && ($board->board[$ending_square->rank][$ending_square->file]->group=='SOLDIER'))
									$capture = true;

								if(($piece->group=='SOLDIER') && (($enemytrapped==true)||($capture==true)))
									{ $capture = true;$enemytrapped=false; }
								else if(($piece->group=='SOLDIER') && ($enemytrapped==false))
									{ continue; }
							}
						}
				
						if($board->gametype==1){
							if(($ending_square->rank>=0)&&($ending_square->rank<=9)&&(($ending_square->file==0)||($ending_square->file==9))){
								continue;
							}
						} 
						if ($capture) {
							// enemy piece in square
							// stop sliding
							break;
						}

						if(($lastaccessiblerow!=-1)&&($color_to_move==2)&&($ending_square->rank<$lastaccessiblerow)){
							continue;
						}

						if(($lastaccessiblerow!=-1)&&($color_to_move==1)&&($ending_square->rank>$lastaccessiblerow)){
							continue;
						}

						if ((($ending_square->rank==0)||($ending_square->rank==9))&&(($ending_square->file>0)&&($ending_square->file<9))) {
							continue;
						}

						$new_move = new ChessMove(
							$piece->square,
							$ending_square,$ending_square,
							0,
							$piece->color,
							$piece->type,
							$capture,
							$board,
							$store_board_in_moves,
							FALSE,$controlled_move
						);
		
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
								$new_move->set_killed_king(TRUE);
						$moves[] = $new_move;

						// empty square
						// continue sliding
						// continue;
					}
				}
			}
		return $moves;
		}	

	static function add_jump_and_jumpcapture_moves_to_moves_list(
		int $type, 
		$jumpstyle,
		array $oclock_list,
		array $moves,
		ChessPiece $piece,
		$color_to_move,
		ChessBoard $board,
		bool $store_board_in_moves,
		int $cankill,
		int $canbepromoted,
		bool $get_FullMover,
		bool $selfbrokencastle,
		bool $foebrokencastle,
		int $get_CASTLEMover,
		bool $controlled_move
	): array 
	{
		//SEMIROYAL  SELF PROMOTION, TOUCH PROMOTION Not done yet
		//breakpointer
		$tempDirection=null;
		$mtype=2;//slide //2 jump
		$lastaccessiblerow=-1;
		$canpromote=false;

		//Create the Array of Move Types.. This will help in deciding the two types of moves in retrating.. Moving back and to the top border
		$tempDirection=self::get_Retreating_ARMY_directions($piece,$color_to_move,$board,	$mtype);

		if (isset($tempDirection) && is_array($tempDirection)){
			if(!empty($tempDirection)){
				$oclock_list=$tempDirection;
			}
			$lastaccessiblerow=self::get_LastKingRow($piece,$color_to_move,$board,$mtype);
			//check if the last accessiblerow is that of knight of general then they cannot strike in same line jumping and thne moving down
			
			if(($piece->type==ChessPiece::KNIGHT)||($piece->type==ChessPiece::GENERAL)){
				$tempDirection=self::get_corrected_Retreating_Knight_General_directions($piece,$color_to_move,$board,$mtype,$lastaccessiblerow,$tempDirection);
					if (isset($tempDirection) && is_array($tempDirection)){
							if(!empty($tempDirection)){
									$oclock_list=$tempDirection;
								}
						}
				}
		}

		$tempDirection=null; $booljump=TRUE; $royalp=FALSE; $cancapture=True; $candemote=FALSE; $capture = FALSE;
		$dem=0; $officer_royalp=FALSE;

		if($get_FullMover==false)
			$booljump=false;
		else
			$booljump=true;
		if($board->gametype==2) 
			$booljump=self::check_royal_neighbours(self::KING_DIRECTIONS, $piece, $color_to_move, $board, "Zone");
		$royal_royalp=self::has_royal_neighbours( self::KING_DIRECTIONS, $piece->square, $piece->square, $color_to_move, $board );

		if((strpos($piece->group,"ROYAL")!==FALSE) &&($piece->square->file>=1) &&($piece->square->file<=8) && 
		((($piece->square->rank==0) && ($color_to_move==1)) || ($piece->square->rank==9)  && ($color_to_move==2)))
		{ 
			$royal_royalp=true;
		}
		if ($type==2) {// Check if royal has royals. if not then cannot jump;

			//can jump within own castle
			if(($get_CASTLEMover==1)&&($selfbrokencastle==FALSE))//&&(($board->$blackcanfullmoveinowncastle == 1)||($board->$whitecanfullmoveinowncastle == 1)))
			{
				$royalp=true;
				$booljump=true;
			}
			else
			$royalp=$booljump;

			if(($royalp==false)&&(strpos($piece->group,"ROYAL")!==FALSE)){
				return $moves;
			}
		}
		elseif ($type==1) 
			{// Check if Officer has royals;
			if(($royalp==false)&&($piece->group=='OFFICER'))
				{
					$booljump=self::check_general_royal_neighbours_promotion( /**/
						self::KING_DIRECTIONS,
						$piece,
						$color_to_move,
						$board
					);
				$officer_royalp=$booljump;
				$booljump=true;
				}

			if(($get_CASTLEMover==1))//&&(($board->$blackcanfullmoveinowncastle == 1)||($board->$whitecanfullmoveinowncastle == 1)))
			{
				$officer_royalp=true;
				$booljump=true;
			}
			else
			//$officer_royalp=$booljump;
			$booljump=true;
		}
		/*if($piece->group=="SEMIROYAL")
		{	$ttt=1; }

		if($piece->type==9)
		{	$ttt=1;	} */

		if(($piece->group=="OFFICER")&&($officer_royalp==TRUE)&&($piece->square->file>0)&&($piece->square->file<9)){ // Check of promotion can happen except NMZ

			if(($piece->type!=9) && ($canbepromoted==1))
			$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,10);
			else
			$canpromote=false;
				
			if(($canpromote==TRUE) && ($canbepromoted==1)){// then update the parity with new demoted values
			//$piece->type=$piece->type+1;
				//Force Promotion to add in movelist	
				$new_move1 = new ChessMove(
					$piece->square,
					$piece->square,$piece->square,
					0,
					$piece->color,
					$piece->type,
					$capture,
					$board,
					$store_board_in_moves,
					TRUE,$controlled_move
					);
	
				$move3 = clone $new_move1;
				$move3-> set_promotion_piece(10);//Knight can become Rook only
				$moves[] = $move3;
				}
		}

			if(($piece->group=="ROYAL")&&( $piece->type == ChessPiece::KING)&&
			(($piece->square->rank==0)&&($piece->square->file==4)&&($piece->color==1)||($piece->square->rank==9)&&($piece->square->file==5)&&($piece->color==2))
			){ // give the invertion option in castle in scep-ter meaning loosing the game
		
					$new_move = new ChessMove(
						$piece->square,
						$piece->square,$piece->square,
						0,
						$piece->color,
						$piece->type,
						$capture,
						$board,
						$store_board_in_moves,
						TRUE,$controlled_move
					);
	
						$move2 = clone $new_move;
							$move2-> set_promotion_piece(2);
						$moves[] = $move2;
						//return $moves; Dont Return but add more moves
				}
			else
			if(($piece->group=="ROYAL")&&( $piece->type == ChessPiece::KING)&&
			(($piece->square->rank==0)&&($piece->square->file!=4)&&($piece->color==1)||($piece->square->rank==9)&&($piece->square->file!=5)&&($piece->color==2))
			){ // give the option to become normal in castle
			
					$new_move = new ChessMove(
						$piece->square,
						$piece->square,$piece->square,
						0,
						$piece->color,
						$piece->type,
						$capture,
						$board,
						$store_board_in_moves,
						TRUE,$controlled_move
					);
	
						$move2 = clone $new_move;
						if(( $piece->type != ChessPiece::INVERTEDKING)){												
							$move2-> set_promotion_piece(2);
						}
						$moves[] = $move2;
						//return $moves; Dont Return but add more moves
				}
			else
			if(($piece->group=="ROYAL") &&($royalp==true)&&( $piece->type == ChessPiece::KING)&&
			(($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0)&&($piece->square->file<9))
			){ //add the war zone inversion mode
			
					$new_move = new ChessMove(
						$piece->square,
						$piece->square,$piece->square,
						0,
						$piece->color,
						$piece->type,
						$capture,
						$board,
						$store_board_in_moves,
						TRUE,$controlled_move
					);
	
						$move2 = clone $new_move;
						if(( $piece->type != ChessPiece::INVERTEDKING)){
							$move2-> set_promotion_piece(2);
						}
						$moves[] = $move2;
						//return $moves; Dont Return but add more moves
				}
			else
			if(($piece->group=="ROYAL") &&($royalp==true)&&( $piece->type == ChessPiece::INVERTEDKING)&&
				(($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0)&&($piece->square->file<9))
				){ //add the war zone inversion mode
				
						$new_move = new ChessMove(
							$piece->square,
							$piece->square,$piece->square,
							0,
							$piece->color,
							$piece->type,
							$capture,
							$board,
							$store_board_in_moves,
							TRUE,$controlled_move
						);
		
							$move2 = clone $new_move;
							$move2-> set_promotion_piece(1);
							$moves[] = $move2;
							//return $moves; Dont Return but add more moves
					}
			else
			if(($piece->group=="ROYAL") &&($royalp==true)&&( $piece->type == ChessPiece::INVERTEDKING)&&
				(($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0)&&($piece->square->file<9))
				){ //add the war zone normal mode option
				
						$new_move = new ChessMove(
							$piece->square,
							$piece->square,$piece->square,
							0,
							$piece->color,
							$piece->type,
							$capture,
							$board,
							$store_board_in_moves,
							TRUE,$controlled_move
						);
		
							$move2 = clone $new_move;
							$move2-> set_promotion_piece(1);
							$moves[] = $move2;
							//return $moves; Dont Return but add more moves
				}

			//booljump true means can change the zone..
			$tcount=0;
			if($get_FullMover==FALSE){ return $moves ;} //It is useless to loop through all possible moves
			if(($jumpstyle=='1')||($jumpstyle=='2'))
				$tcount=1;
			elseif($jumpstyle=='3')
				$tcount=2;
			else
				$tcount=1;
			if ($booljump==TRUE) { 
				foreach ($oclock_list as $oclock) {
					$tempc=1;
					for (; $tempc <= $tcount; $tempc++) {
						$xdelta=self::OCLOCK_OFFSETS[$oclock][1];
						$ydelta=self::OCLOCK_OFFSETS[$oclock][0];
						if(abs($xdelta)==abs($ydelta)){
							$tempc=100;$type=='3'; $jflag='3';//diagonal jump intermediate
						}
					
						if((($jumpstyle=='3')||($jumpstyle=='1'))&&($tempc==1))
							$jflag='1';
					
						if(((($jumpstyle=='3')&&($tempc==2))||(($jumpstyle=='2')&&($tempc==1))))
							$jflag='2';

						$ending_square = self::square_exists_and_not_occupied_by_friendly_piece(
								$type, $jflag, $piece->square, $ydelta, $xdelta, $color_to_move, $board, $cankill, $get_FullMover, $selfbrokencastle, $foebrokencastle );
						if ($ending_square) {
							$capture = false;

							/*if($piece->group=="SEMIROYAL")
							{
							$ttt=1;
							}
							if($piece->group=="ROYAL")
							{
							$ttt=1;
							}*/ 
							//2 steps jump for Royals from normal castle not allowed
							if (($royal_royalp==true)&&(strpos($piece->group,"ROYAL")!==FALSE) && 
							(((($selfbrokencastle==false)&& ($piece->square->rank==0)&&($color_to_move==1) && ($ending_square->rank>1))||
							(($foebrokencastle==false)&&($piece->square->rank==9)&&($color_to_move==1) && ($ending_square->rank<8))) || 
							((($selfbrokencastle==false)&&($piece->square->rank==9)&&($color_to_move==2)&& ($ending_square->rank<8))||
							(($foebrokencastle==false)&&($piece->square->rank==0)&&($color_to_move==2)&& ($ending_square->rank>1))))){
								continue;
							}
							//2 steps jump for Naarad/Officers/Soldiers from normal castle not allowed
							else
							if (($officer_royalp==true)&&(strpos($piece->group,"ROYAL")===FALSE) && (((($selfbrokencastle==false)&&($piece->square->rank==0)&&($color_to_move==1) && ($ending_square->rank>1))||
							(($foebrokencastle==false)&&($piece->square->rank==9)&&($color_to_move==1) && ($ending_square->rank<8))) || 
							((($selfbrokencastle==false)&&($piece->square->rank==9)&&($color_to_move==2)&& ($ending_square->rank<8))||
							(($foebrokencastle==false)&&($piece->square->rank==0)&&($color_to_move==2)&& ($ending_square->rank>1))))){
								continue;
							}

							if(($royalp==true)&&(strpos($piece->group,"ROYAL")!==FALSE)&&((($ending_square->rank==2)&&($piece->square->rank==0))||(($ending_square->rank==7)&&($piece->square->rank==9)))){
							}

							if(($royal_royalp==true)&&(strpos($piece->group,"ROYAL")!==FALSE)&&((($ending_square->file==1)&&($piece->square->file==0))||(($ending_square->file==8)&&($piece->square->file==9))||(($ending_square->file==2)&&($piece->square->file==0))||(($ending_square->file==7)&&($piece->square->file==9)))){
								continue;//2 steps jump from truce not allowed
							}
					
							if(($lastaccessiblerow!=-1)&&($color_to_move==2)&&($ending_square->rank<$lastaccessiblerow)){
								$booljump==FALSE; // Officers / Soldiers cannot go beyond  Retreat.
								continue;
							}

							if(($lastaccessiblerow!=-1)&&($color_to_move==1)&&($ending_square->rank>$lastaccessiblerow)){
								$booljump==FALSE; // Officers / Soldiers cannot go beyond  Retreat.
								continue;
							}

							if ($board->board[$ending_square->rank][$ending_square->file]) {
								// enemy piece
								if ($board->board[$ending_square->rank][$ending_square->file]->color != $color_to_move) {
									$capture = true;
								}
							}

							//  Defective.... I will correct this caode later. Foe Compromised CASTLE movement in and out without Royal. 2 steps are not allowed 
							if( $board->board[$ending_square->rank][$ending_square->file]!=null ){
								if ( $board->board[$ending_square->rank][$ending_square->file] ) {
									if (( $board->board[$ending_square->rank][$ending_square->file]->color != $color_to_move)) {
										if((($ending_square->rank==0)&& ($ending_square->file==0))||(($ending_square->rank==0)&& ($ending_square->file==9))||
										(($ending_square->rank==9)&& ($ending_square->file==0))||(($ending_square->rank==9)&& ($ending_square->file==9))){
											$capture = FALSE;
											continue; /** ????? */
										}

										//Classical Game. Officers cannot kill in compromised zone or Truce when ArthShashtri is also in idle condition
										if(((strpos($piece->group,"ROYAL")===FALSE))&&($board->gametype==1)&&(
							 			($color_to_move==2)&& (($board->basquare==null) || ( ((($board->basquare->file==5)||($board->basquare->file==4)) &&(($board->basquare->rank==9))))||
							 			((($board->basquare->file==5)||($board->basquare->file==4)) &&(($board->basquare->rank==9)))||
							 			((($board->basquare->file==0)||($board->basquare->file==9)) &&(($board->basquare->rank==4)||($board->basquare->rank==5))) ) ||

										 ( ($color_to_move==1) && (($board->wasquare==null) ||((($board->wasquare->file==5)||($board->wasquare->file==4)) &&(($board->wasquare->rank==0)))||
							 			((($board->wasquare->file==5)||($board->wasquare->file==4)) &&(($board->wasquare->rank==0)))||
							 			((($board->wasquare->file==0)||($board->wasquare->file==9)) &&(($board->wasquare->rank==4)||($board->wasquare->rank==5))) ))
			 							))
											{
											continue;
											}

										//Truce Zone guys cannot be killed
										if(($ending_square->rank>=0)&& ($ending_square->rank<=9)&&(($ending_square->file==0)||
										($ending_square->file==9))){
											continue; /** Cannot Kill anyone in TruceZone */
										}
										//else
										//$capture = FALSE;
										if($cancapture==FALSE){
											$capture = FALSE;
											$cancapture=TRUE;
											continue;
										}//cannot capture
									}

									if(($capture == TRUE)&&($board->board[$ending_square->rank][$ending_square->file]->mortal!=1)){
										continue; /** Only Mortals can be killed */
									}
									$booljump=TRUE;
								}
							}

							//ROYAL CASTLE to WAR  Defective. Compromised CASTLE does not require Royal touch ???
							if(($piece->group=="ROYAL")&&
							((($ending_square->file>0)&&($ending_square->file<9))&&		
							(((($piece->square->rank==0)&&($ending_square->rank<=1))||(($piece->square->rank==9) &&(($ending_square->rank>=8)))
							&&($piece->square->file>0)&&($piece->square->file<9)))	
							))
							{
								$new_move = new ChessMove( $piece->square, $ending_square,$ending_square,1, $piece->color, $piece->type, $capture, $board, $store_board_in_moves, FALSE,$controlled_move);
	
								$move2 = clone $new_move;
								//check if the king is killed
								if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
									$move2->set_killed_king(TRUE);

								if(( $piece->type == ChessPiece::KING)){
									//$move2-> set_promotion_piece(1);
									$moves[] = $move2;
									$move3 = clone $new_move;
									//check if the king is killed
									if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
										$move3->set_killed_king(TRUE);
									$move3-> set_promotion_piece(2);
									$moves[] = $move3;
								}
								/*elseif(( $piece->type == ChessPiece::ARTHSHASTRI)){
									$moves[] = $move2;
									$move2-> set_promotion_piece(6);
								}
								*/
								elseif( $piece->type == ChessPiece::ARTHSHASTRI){
									$moves[] = $move2;
								}
								elseif(( $piece->type == ChessPiece::INVERTEDKING)){ 
									$moves[] = $move2;
									$move3 = clone $new_move;
									//check if the king is killed
									if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
										$move3->set_killed_king(TRUE);
										//check if the king is killed
									if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
										$move3->set_killed_king(TRUE);
									$move3-> set_promotion_piece(1);
									$moves[] = $move3;
								}
								continue;
							}
							//CASTLE to CASTLE or CASTLE To No-Mans
							elseif((($piece->group=="ROYAL"))&&
							(((($ending_square->rank==0)||($ending_square->rank==9))&&(($ending_square->file>=0)&&($ending_square->file<=9)))&&		
							((($piece->square->rank==0)||($piece->square->rank==9))&&(($piece->square->file>0)&&($piece->square->file<9)))	
							))
							{
								$new_move = new ChessMove( $piece->square, $ending_square,$ending_square, 1, $piece->color, $piece->type, $capture, $board, $store_board_in_moves, FALSE,$controlled_move );
	
								$move2 = clone $new_move;
								//check if the king is killed
								if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
									$move2->set_killed_king(TRUE);
								if(($ending_square->file<4)||($ending_square->file>5)){
									/*if($piece->type == ChessPiece::ARTHSHASTRI)
										$move2-> set_promotion_piece(6);
									else
									*/	
									if($piece->type == ChessPiece::KING){
										//$move2-> set_promotion_piece(1);
										$moves[] = $move2;
										$move3 = clone $new_move;
										//check if the king is killed
										if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
											$move3->set_killed_king(TRUE);
										$move3-> set_promotion_piece(2);
										$moves[] = $move3;
									}
									elseif(( $piece->type == ChessPiece::INVERTEDKING)){ 
										$moves[] = $move2;
										$move3 = clone $new_move;
										//check if the king is killed
										if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
											$move3->set_killed_king(TRUE);
										$move3-> set_promotion_piece(1);
										$moves[] = $move3;
									}
									$moves[] = $move2;
								}
								if(($ending_square->file==4)||($ending_square->file==5)){
										if(( $piece->type == ChessPiece::KING)){ 
											//$move2-> set_promotion_piece(1);
											$moves[] = $move2;
											$move3 = clone $new_move;
											//check if the king is killed
											if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
												$move3->set_killed_king(TRUE);
											$move3-> set_promotion_piece(2);
											$moves[] = $move3;
										}
										elseif(( $piece->type == ChessPiece::ARTHSHASTRI)){ 
												//$move2-> set_promotion_piece(5);
												$moves[] = $move2;
											}
									}
								continue;
							}
							//WAR to CASTLE (non-Scepter) or to No mans... check royalp
							elseif((($piece->group=="ROYAL"))&&
							(((($piece->square->rank>0)&&($piece->square->rank<9))&&(($ending_square->rank==0)||($ending_square->rank==9))&&(($ending_square->file<4)||($ending_square->file>5)))
							))
							{
								//$moves-> set_promotion_piece(2);
								$new_move = new ChessMove( $piece->square, $ending_square,$ending_square, 1, $piece->color, $piece->type, $capture, $board, $store_board_in_moves,FALSE,$controlled_move	);
	
								$move2 = clone $new_move;
								//check if the king is killed
								if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
									$move2->set_killed_king(TRUE);
								if(( $piece->type == ChessPiece::INVERTEDKING)&&( $piece->type != ChessPiece::ARTHSHASTRI)&&( $piece->type != ChessPiece::SPY)){
									//$move2-> set_demotion_piece($piece->type+$dem);
									$move2-> set_promotion_piece(1);
								}
								$moves[] = $move2;
								$move3 = clone $new_move;
								//check if the king is killed
								if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
										$move3->set_killed_king(TRUE);
								if(( $piece->type == ChessPiece::KING)&&( $piece->type != ChessPiece::ARTHSHASTRI)&&( $piece->type != ChessPiece::SPY)){
										$move3-> set_promotion_piece(2);
									}

								$moves[] = $move3;
							}
		  					/* back from any location to CASTLE to own Scepters*/					
							elseif(($piece->group=="ROYAL")&&((((($piece->square->rank==0)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file==4) ||($ending_square->file==5))&&($color_to_move==1)
							)||(($piece->square->rank==9)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file==4)||($ending_square->file==5))&&($color_to_move==2)
							)))|| /*CASTLE KING becoming full king*/
							((($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0) && ($piece->square->file<9))&&(($ending_square->file==4) ||($ending_square->file==5))&&(($ending_square->rank==0)||($ending_square->rank==9)))
							)){
								//$moves-> set_promotion_piece(2);
								$new_move = new ChessMove( $piece->square, $ending_square,$ending_square, 1, $piece->color, $piece->type, $capture, $board, $store_board_in_moves, FALSE,$controlled_move );
	
								$move2 = clone $new_move;
								//check if the king is killed
								if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
										$move2->set_killed_king(TRUE);

								if((( $piece->type == ChessPiece::KING))&&
									(((($piece->square->rank==0)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file==4) ||($ending_square->file==5))&&
									($color_to_move==1))||(($piece->square->rank==9)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file==4)||($ending_square->file==5))&&($color_to_move==2)	)))
									){
										//$move2-> set_promotion_piece(1);
										$moves[] = $move2;
										$move3 = clone $new_move;
										//check if the king is killed
										if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
											$move3->set_killed_king(TRUE);
										$move3-> set_promotion_piece(2);
										$moves[] = $move3;
									}
								else	
								if((( $piece->type == ChessPiece::INVERTEDKING))&&
									(((($piece->square->rank==0)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file==4) ||($ending_square->file==5))&&
									($color_to_move==1))||(($piece->square->rank==9)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file==4)||($ending_square->file==5))&&($color_to_move==2)	)))
									){
										//$move2-> set_promotion_piece(1);
										$moves[] = $move2;
										$move3 = clone $new_move;
										//check if the king is killed
										if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
											$move3->set_killed_king(TRUE);
										$move3-> set_promotion_piece(1);
										$moves[] = $move3;
									}
								else
								if((( $piece->type == ChessPiece::KING))&&
									((($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0) && ($piece->square->file<9))&&
									(($ending_square->file==4) ||($ending_square->file==5))&&((($ending_square->rank==0)&&($color_to_move==1))||(($ending_square->rank==9)&&($color_to_move==2))))
									){
										//$move2-> set_promotion_piece(1);
										$moves[] = $move2;
										$move3 = clone $new_move;
										//check if the king is killed
										if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
											$move3->set_killed_king(TRUE);
										$move3-> set_promotion_piece(2);
										$moves[] = $move3;
									}
								else
								if((( $piece->type == ChessPiece::INVERTEDKING))&&
									((($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0) && ($piece->square->file<9))&&
									(($ending_square->file==4) ||($ending_square->file==5))&&((($ending_square->rank==0)&&($color_to_move==1))||(($ending_square->rank==9)&&($color_to_move==2))))
									){
										//$move2-> set_promotion_piece(1);
										$moves[] = $move2;
										$move3 = clone $new_move;
										//check if the king is killed
										if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
											$move3->set_killed_king(TRUE);
										$move3-> set_promotion_piece(1);
										$moves[] = $move3;
									}
								else
								if(( $piece->type == ChessPiece::ARTHSHASTRI)&&
									(((($piece->square->rank==0)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file==4) ||($ending_square->file==5))&&
									($color_to_move==1))||(($piece->square->rank==9)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file==4)||($ending_square->file==5))&&($color_to_move==2)	)))
									){
										//$move2-> set_promotion_piece(5);
										$moves[] = $move2;
									}
								else
								if(( $piece->type == ChessPiece::ARTHSHASTRI)&&
									((($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0) && ($piece->square->file<9))&&
									(($ending_square->file==4) ||($ending_square->file==5))&&((($ending_square->rank==0)&&($color_to_move==1))||(($ending_square->rank==9)&&($color_to_move==2))))
									){
										//$move2-> set_promotion_piece(5);
										$moves[] = $move2;
									}
								continue;
							}
							/* from CASTLE to non Scepters but within won CASTLE */					
							elseif(($piece->group=="ROYAL")&&((((($piece->square->rank==0)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file!=4) && ($ending_square->file!=5))&&($color_to_move==1))
								||(($piece->square->rank==9)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file!=4)&&($ending_square->file!=5))&&($color_to_move==2)
								))))){
									//$moves-> set_promotion_piece(2);
									$new_move = new ChessMove( $piece->square, $ending_square,$ending_square,1, $piece->color,$piece->type,	$capture,$board,$store_board_in_moves,FALSE,$controlled_move );
									$move2 = clone $new_move;
									//check if the king is killed
									if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
										$move2->set_killed_king(TRUE);
									if(( $piece->type == ChessPiece::KING)&&
										(((($piece->square->rank==0)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file!=4) &&($ending_square->file!=5))&&
										($color_to_move==1))||(($piece->square->rank==9)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file!=4)&&($ending_square->file!=5))&&($color_to_move==2)	)))
										){
											//$move2-> set_promotion_piece(1);
											$moves[] = $move2;
											$move3 = clone $new_move;
											//check if the king is killed
											if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
												$move3->set_killed_king(TRUE);
											$move3-> set_promotion_piece(2);
											$moves[] = $move3;
										}
									else
									if(( $piece->type == ChessPiece::KING)&&
										(((($piece->square->rank==0)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file!=4) &&($ending_square->file!=5))&&
										($color_to_move==1))||(($piece->square->rank==9)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file!=4)&&($ending_square->file!=5))&&($color_to_move==2)	)))
										){
											$moves[] = $move2;
											$move3 = clone $new_move;
											//check if the king is killed
											if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
												$move3->set_killed_king(TRUE);
											$move3-> set_promotion_piece(2);
											$moves[] = $move3;
										}
									else
									if((( $piece->type == ChessPiece::ARTHSHASTRI))&&
										(((($piece->square->rank==0)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file!=4) &&($ending_square->file!=5))&&
										($color_to_move==1))||(($piece->square->rank==9)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file!=4)&&($ending_square->file!=5))&&($color_to_move==2)	)))
										){
											//$move2-> set_promotion_piece(6);
											$moves[] = $move2;
										}
									continue;
								}
							/* From Truce */
							elseif(($piece->group=="ROYAL")&&(($piece->type == ChessPiece::KING)||  ( $piece->type == ChessPiece::ARTHSHASTRI) )&&
								((($piece->square->rank>0)&&($piece->square->rank<9)&&(($piece->square->file==0) || ($piece->square->file==9)))||
								(($piece->square->file>=0)&&($piece->square->file<=9)&&(($piece->square->rank==0) || ($piece->square->rank==9))&&($ending_square->rank!=$piece->square->rank))||
								(($piece->square->file>=0)&&($piece->square->file<=9)&&(($piece->square->rank==0) || ($piece->square->rank==9))&&($ending_square->rank==$piece->square->rank)&&
								(($ending_square->file<4)||($ending_square->file>5)))
								))
								{
									$new_move = new ChessMove($piece->square, $ending_square,$ending_square,1,$piece->color,$piece->type,$capture,$board,$store_board_in_moves,	FALSE,$controlled_move);
									$move3 = clone $new_move;
									//check if the king is killed
									if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
										$move3->set_killed_king(TRUE);
									if(( $piece->type == ChessPiece::KING)&&( $piece->type != ChessPiece::ARTHSHASTRI)){												
										$move3-> set_promotion_piece(2);
									}
									$moves[] = $move3;
								}
							//WAR To CASTLE movement
							elseif((strpos($piece->group,"ROYAL")!==FALSE) && ($royalp)&&($ending_square->file>0)&&($ending_square->file<9)&&(($ending_square->rank==0)||($ending_square->rank==9))){
								if ( $board->board[$ending_square->rank][$ending_square->file] ==null) {
									if(($piece->type == ChessPiece::SPY)||($piece->type == ChessPiece::KING)||( $piece->type == ChessPiece::INVERTEDKING)||( $piece->type == ChessPiece::ARTHSHASTRI)){
										if(($ending_square->rank==0)||($ending_square->rank==9)){
											if(/*($foebrokencastle==true)&&*/($piece->square->rank<=9)&&($color_to_move==1))
											{
					
												$new_move = new ChessMove($piece->square, $ending_square, $ending_square, 0, $piece->color, $piece->type, $capture, $board, $store_board_in_moves,FALSE,$controlled_move );
												$move1 = clone $new_move;
												//check if the king is killed
												if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
													$move1->set_killed_king(TRUE);
												//doublepromotion of spy logic
												if(($color_to_move==1)&&($ending_square->rank==9)&&($piece->group=="SEMIROYAL")){
													$moves[] = $move1;
													$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,12);
													if($canpromote==TRUE){
														$move2 = clone $new_move;
														//check if the king is killed
														if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
															$move2->set_killed_king(TRUE);
														$move2-> set_promotion_piece(12);
														$moves[] = $move2;
													}
											
													if((($foebrokencastle==true)&&((($ending_square->rank==9)&&($color_to_move==1))||(($ending_square->rank==0)&&($color_to_move==2)))) &&(($ending_square->file==4)||($ending_square->file==5)))
														{ 
														continue;
														}
													//$move1 = clone $new_move;
													//check if the king is killed
													if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
														$move1->set_killed_king(TRUE);
													$moves[] = $move1;
													continue;
												}
												elseif(($color_to_move==1)&&($ending_square->rank==9)){
													if(($piece->type == ChessPiece::ARTHSHASTRI))
														$move1-> set_promotion_piece(50);
													else
														$move1-> set_promotion_piece(100);
												}
												$moves[] = $move1;
												continue;
											}
											else
											if(	/*($foebrokencastle==true)&&*/($piece->square->rank>=0)&&($color_to_move==2))
												{
										
													$new_move = new ChessMove( $piece->square, $ending_square, $ending_square, 0, $piece->color, $piece->type, $capture,$board, $store_board_in_moves,FALSE,$controlled_move );
													//doublepromotion of spy logic
													$move1 = clone $new_move;
													//check if the king is killed
													if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
														$move1->set_killed_king(TRUE);
													if(($piece->group=="SEMIROYAL")&&($color_to_move==2)&&($ending_square->rank==0)){
														$canpromote=false;
														$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,12);
			
														if($canpromote==TRUE){
															$move2 = clone $new_move;
															//check if the king is killed
															if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
																$move2->set_killed_king(TRUE);
															$move2-> set_promotion_piece(12);
															$moves[] = $move2;
														}
			
														if((($foebrokencastle==true)&&((($ending_square->rank==9)&&($color_to_move==1))||(($ending_square->rank==0)&&($color_to_move==2)))) &&(($ending_square->file==4)||($ending_square->file==5)))
															{ 
															continue;
															}
														//$move1 = clone $new_move;
														//check if the king is killed
														if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
															$move1->set_killed_king(TRUE);
														$moves[] = $move1;
														continue;
													}
													else if(($color_to_move==2)&&($ending_square->rank==0)){
														if(( $piece->type == ChessPiece::ARTHSHASTRI))
															$move2-> set_promotion_piece(50);
														else
															$move2-> set_promotion_piece(100);
													}
											
													$moves[] = $move1;
													continue;
												}
											else 
												continue; /** Cannot get inside CASTLE piece */
										}
									}
								}
								else { 	continue;}
							}
							//WAR To WAR movement
							elseif(($piece->group=="ROYAL") && ($royalp)&&(($piece->square->file>0)&&($piece->square->file<9)&&(($piece->square->rank>=1)&&($piece->square->rank<=8))
								&&(($ending_square->file>0)&&($ending_square->file<9)&&($ending_square->rank>=1)&&($ending_square->rank<=8)))){
										//endblock has no data or blank
										if ($board->board[$ending_square->rank][$ending_square->file] ==null) {
												$new_move = new ChessMove( $piece->square, $ending_square,$ending_square, 0, $piece->color, $piece->type, $capture, $board, $store_board_in_moves, FALSE,$controlled_move );

												$move2 = clone $new_move;
												//check if the king is killed
												if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
													$move2->set_killed_king(TRUE);

												if(($piece->type == ChessPiece::ARTHSHASTRI))
													$moves[] = $move2;
												elseif(($piece->type == ChessPiece::KING))
												{
													$moves[] = $move2;
													$move2 = clone $new_move;
													//check if the king is killed
													if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
														$move2->set_killed_king(TRUE);
													$move2-> set_promotion_piece(2);
													$moves[] = $move2;
												}
												elseif(($piece->type == ChessPiece::INVERTEDKING))
												{
													$moves[] = $move2;
													$move2 = clone $new_move;
													//check if the king is killed
													if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
														$move2->set_killed_king(TRUE);
													$move2-> set_promotion_piece(1);
													$moves[] = $move2;
												}
												continue;

										}
										else
										{
											if(($capture==true) && ($ending_square->mediatorrank!=null)&&($ending_square->mediatorfile!=null)){
												$mediatorpiece = clone $piece;
												$endpiece = clone $board->board[$ending_square->rank][$ending_square->file];
		
												if(($piece->square->mediatorrank!=$ending_square->mediatorrank)&&($piece->square->mediatorfile!=$ending_square->mediatorfile)){
													$mediatorpiece->square->mediatorrank=$ending_square->mediatorrank;
													$mediatorpiece->square->mediatorfile=$ending_square->mediatorfile;
													$mediatorpiece->state="V";
													}
												$sittingpiece=$board->board[$mediatorpiece->square->rank][$mediatorpiece->square->file];
												$board1 = clone $board;
												$board1->board[$mediatorpiece->square->rank][$mediatorpiece->square->file]=$mediatorpiece;
												if($tempc>=1){
													$moves = self::add_running_capture_moves_to_moves_list($moves, $mediatorpiece, $endpiece, $color_to_move, $board1, $store_board_in_moves,1,$selfbrokencastle,$foebrokencastle);
													continue;
												}
											}
											else {
												$new_move1 = new ChessMove( $piece->square, $ending_square,$ending_square, -1, $piece->color, $piece->type, $capture, $board, $store_board_in_moves, false,$controlled_move);
												$move2 = clone $new_move1;
												$moves[] = 	$move2;
												}
											//continue;
										 }

									}
							elseif(((strpos($piece->group,"ROYAL")!==FALSE))&&(
								(($piece->square->file==0)&&($piece->square->rank==0))||(($piece->square->file==0)&&($piece->square->rank==9))||
								(($piece->square->file==9)&&($piece->square->rank==0))||(($piece->square->file==9)&&($piece->square->rank==9))
								)){
									$booljump==FALSE; // Royal cannot exit no-mans.
									continue;
								}
							elseif((((strpos($piece->group,"ROYAL")!==FALSE)) &&($royalp)&&($ending_square->file==$piece->square->file)&&($ending_square->rank<=8)
								&&($piece->square->rank>=1)&&($piece->square->rank<=8)&&($ending_square->rank>=1))&&(($ending_square->file==0)||
								($ending_square->file==9))){ //no jumping within truce
									$booljump=FALSE;
									continue;
								}
							elseif((((strpos($piece->group,"ROYAL")!==FALSE) &&($royalp))&&($ending_square->rank==$piece->square->rank)&&($ending_square->rank<=1)&&($piece->square->file>0)&&($piece->square->file<9))||
								((strpos($piece->group,"ROYAL")!==FALSE) &&($royalp)&&($ending_square->rank==$piece->square->rank)&&($ending_square->rank>=8)&&($piece->square->file>0)&&($piece->square->file<9))||
								((strpos($piece->group,"ROYAL")!==FALSE) &&($royalp)&&($ending_square->rank>0)&&($ending_square->rank<9)&&($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0)&&($piece->square->file<9)&&($ending_square->file<=1)&&($piece->square->rank>0)&&($piece->square->rank<9))||
								((strpos($piece->group,"ROYAL")!==FALSE) &&($royalp)&&($ending_square->rank>0)&&($ending_square->rank<9)&&($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0)&&($piece->square->file<9)&&($piece->square->rank>0)&&($piece->square->rank<9))||
								((strpos($piece->group,"ROYAL")!==FALSE) &&($royalp)&&($ending_square->rank==0)&&($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0)&&($piece->square->file<9))||
								((strpos($piece->group,"ROYAL")!==FALSE) &&($royalp)&&($ending_square->rank==9)&&($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0)&&($piece->square->file<9))){
										$booljump==TRUE; //war zone4
								}
							elseif(((strpos($piece->group,"ROYAL")!==FALSE) &&($royal_royalp))&&( //Castle to WAR ZONE
								(($ending_square->rank<$piece->square->rank)&&($ending_square->rank==8)&&($piece->square->file>0)&&($piece->square->file<9)&&($ending_square->file>0)&&($ending_square->file<9))||
								(($ending_square->rank>$piece->square->rank)&&($ending_square->rank==1)&&($piece->square->file>0)&&($piece->square->file<9)&&($ending_square->file>0)&&($ending_square->file<9))||
								(($ending_square->rank==$piece->square->rank)&&($ending_square->rank>=8)&&($piece->square->file>0)&&($piece->square->file<9)&&($ending_square->file>0)&&($ending_square->file<9))
								)){
										$booljump=TRUE;
								}
							elseif(((strpos($piece->group,"ROYAL")!==FALSE) &&($royal_royalp))&&( //Castle to Truce
								(($ending_square->rank>$piece->square->rank)&&($ending_square->rank==1)&&($piece->square->file>1)&&($piece->square->file<8)&&($ending_square->file==0)&&($ending_square->file<9))||
								(($ending_square->rank==$piece->square->rank)&&($ending_square->rank>=8)&&($piece->square->file>1)&&($piece->square->file<8)&&($ending_square->file==0)&&($ending_square->file<9))||
								(($ending_square->rank>$piece->square->rank)&&($ending_square->rank==1)&&($piece->square->file>1)&&($piece->square->file<8)&&($ending_square->file==9)&&($ending_square->file>0))||
								(($ending_square->rank==$piece->square->rank)&&($ending_square->rank>=8)&&($piece->square->file>1)&&($piece->square->file<8)&&($ending_square->file==9)&&($ending_square->file>0))
								)){
										$booljump=TRUE;
								}
							elseif(strpos($piece->group,"ROYAL")===FALSE){
								if($piece->group=="OFFICER"){
									if($officer_royalp==true)
										$piece->elevatedofficer=true;
									else $piece->elevatedofficer=false;

									if(($ending_square->file>=1)&&($ending_square->file<=8)&&(($ending_square->rank==0)||($ending_square->rank==9))){
										//if castle compromised then can jump else not. Compromised castle does need Royal push
										if(((($selfbrokencastle==true)&&($piece->square->rank>=0)&&($color_to_move==1) && ($ending_square->rank==0))||
											(($foebrokencastle==true)&&($piece->square->rank<=9)&&($color_to_move==1) && ($ending_square->rank==9))) || 
											((($selfbrokencastle==true)&&($piece->square->rank<=9)&&($color_to_move==2)&& ($ending_square->rank==9))||
											(($foebrokencastle==true)&&($piece->square->rank>=0)&&($color_to_move==2)&& ($ending_square->rank==0))))
											{ /*
												* CASTLE has become warzone
												*/
												$new_move = new ChessMove($piece->square, $ending_square,$ending_square, 0, $piece->color, $piece->type, $capture, $board, $store_board_in_moves, FALSE,$controlled_move);
												$move2 = clone $new_move;

												if(($officer_royalp==TRUE)&& ($canbepromoted==1))
													{ // Check of promotion can happen
														$dem=-1;
														$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,$piece->type-1);
														if(($canpromote==TRUE)){
															//check if the king is killed
															if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
																$move2->set_killed_king(TRUE);
															$move2-> set_promotion_piece($piece->type+$dem);
				
															//check if the king is killed
															if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
																$move2->set_killed_king(TRUE);
														}
													}

												$moves[] = $move2;
												continue;
											}
										//1= Self CASTLE.. 0 = Foe CASTLE and can be jumped by Officers without royals or General.
										elseif((($get_CASTLEMover==1)&&($piece->square->rank==0)&&($color_to_move==1))||
											(($get_CASTLEMover==1)&&($piece->square->rank==9)&&($color_to_move==2)))
											{ /*
												* CASTLE has become warzone
												*/
												$new_move = new ChessMove($piece->square, $ending_square,$ending_square, 0, $piece->color, $piece->type, $capture, $board, $store_board_in_moves, FALSE,$controlled_move);
												$move2 = clone $new_move;
												$moves[] = $move2;
												continue;
											}
										//if the ending square has blank value in castle
										elseif(($piece->group=="OFFICER") &&($board->board[$ending_square->rank][$ending_square->file]==null)&&
											((($piece->square->rank>0)&&($piece->square->rank<9))&&(($ending_square->file>=0)&&($ending_square->file<=9))&&
											((($ending_square->rank==0)||($ending_square->rank==9))) && (($officer_royalp==true)&&($board->gametype==1)) /*&& ($piece->type==ChessPiece::GENERAL)*/) ){ /* Classical General can penetrate the CASTLE. */
				
												$new_move = new ChessMove($piece->square, $ending_square,$ending_square, 0, $piece->color, $piece->type, $capture, $board, $store_board_in_moves, FALSE,$controlled_move);
				
												$move2 = clone $new_move;
												$moves[] = $move2;
												continue;
											}
										else
											continue; /** Cannot get inside CASTLE piece */
									}
								}

								//No Mans Area. Check if the Pieces not allowed can kill or not.
								if ( $board->board[$ending_square->rank][$ending_square->file] ) {
									if (( $board->board[$ending_square->rank][$ending_square->file]->color != $color_to_move)) {
										if((($ending_square->rank==0)&& ($ending_square->file==0))||(($ending_square->rank==0)&& ($ending_square->file==9))||
										(($ending_square->rank==9)&& ($ending_square->file==0))||(($ending_square->rank==9)&& ($ending_square->file==9))){
											$capture = FALSE;
											continue; /** ????? */
										}

										//Truce Zone guys cannot be killed
										if(($ending_square->rank>=0)&& ($ending_square->rank<=9)&&(($ending_square->file==0)||
											($ending_square->file==9))){
												continue; /** Cannot Kill anyone in TruceZone */
											}
										//else
										//$capture = FALSE;
										if($cancapture==FALSE){
											$capture = FALSE;
											$cancapture=TRUE;
											continue;
										}//cannot capture
									}

									if(($capture == TRUE)&&($board->board[$ending_square->rank][$ending_square->file]->mortal!=1)){
											continue; /** Only Mortals can be killed */
										}

									$booljump=TRUE;
								}
							}
							else{
								$ttt=strpos($piece->group,"ROYAL");
								continue;
							}
		
							if ( $board->board[$ending_square->rank][$ending_square->file] ==null) {
								$capture = FALSE;
							}

							//Movement within  CASTLE with promotion
							if(($piece->group=="OFFICER") &&($officer_royalp==true)&&(($piece->square->rank==$ending_square->rank))&&(($ending_square->rank==0)||($ending_square->rank==9))&&(
								(($ending_square->file>0)&&($ending_square->file<9))))
								{ // Check of promotion can happen

									//officers holding opponent Scepter	wins the game
									if((($foebrokencastle==true)&&((($ending_square->rank==9)&&($color_to_move==1))||(($ending_square->rank==0)&&($color_to_move==2)))) &&(($ending_square->file==4)||($ending_square->file==5)))
										{ /*
											* CASTLE has become warzone
											*/
											$new_move = new ChessMove($piece->square, $ending_square, $ending_square, 0, $piece->color, $piece->type, $capture, $board, $store_board_in_moves, FALSE,$controlled_move );

											$move2 = clone $new_move;
											//check if the king is killed
											if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
												$move2->set_killed_king(TRUE);
											//$move2-> set_promotion_piece(25);
											$moves[] = $move2;
											continue;
										}

									if(($piece->type!=9) && ($canbepromoted==1))//Piece is Knight can be promoted as Rook
										$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,10);
									else
										$canpromote=false;

									$ksqr=$board->get_king_square(abs($color_to_move-3));
									if($ksqr==null) continue;
									//If King is holding scepter then no Capture Allowed
									if(($capture==TRUE)&&($cankill!=0)&&
										(($board->get_king_square(abs($color_to_move-3))->rank==0)&&($board->get_king_square(abs($color_to_move-3))->file==4)&&($color_to_move==1)
										||($board->get_king_square(abs($color_to_move-3))->rank==9)&&($board->get_king_square(abs($color_to_move-3))->file==5)&&($color_to_move==2)))
										{
											continue;
										}

									//non general can be promoted.
									if(($canpromote==TRUE)&& ($canbepromoted==1)){// then update the parity with new demoted values
										//$piece->type=$piece->type+1;
				
										$new_move = new ChessMove($piece->square, $ending_square, $ending_square, 0, $piece->color, $piece->type, $capture, $board, $store_board_in_moves, FALSE ,$controlled_move);

										$move2 = clone $new_move;
										//check if the king is killed
										if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
											$move2->set_killed_king(TRUE);
										if(($officer_royalp==TRUE))
											$move2-> set_promotion_piece(10);

										//check if the king is killed
										if(($capture==TRUE)&&( ($board->get_king_square(abs(3-$color_to_move))->rank==$ending_square->rank) &&($board->get_king_square(3-$color_to_move)->file==$ending_square->file)))
											$move2->set_killed_king(TRUE);

										$moves[] = $move2;
										//return $moves; Dont Return but add more moves									
									}
								}
					
							//classical does not allow the movement of non-officers or no-elevated Officers or non-elevated-royals to truce or no mans
							if(((($piece->group=="OFFICER") &&($piece->type!=="GENERAL")&&($royal_royalp==false)) ||($piece->group=="SOLDIER"))&& (($ending_square->file==0)||($ending_square->file==9))&&(
								$board->gametype==1))
								{
									continue;
								}

							/*if(($piece->group=="OFFICER") &&($piece->type!=="GENERAL")&&( (($board->elevatedws==false)&&($color_to_move==1)&&($officer_royalp==false)) ||
								(($board->elevatedbs==false)&&($color_to_move==2)&&($officer_royalp==false)) )&&($board->gametype==1))
								{
									continue;
								}
							*/
							//movement to TRUCE with demotion as per kautilya or no demotion as per classical (check if this is correct logic)
							if(($piece->group=="OFFICER") &&(($ending_square->file==0)||($ending_square->file==9))&&(
								(($ending_square->rank>0)&&($ending_square->rank<9))&&($get_CASTLEMover==1)
								))
								{ // Check if demotion can happen as per Kautilya
										if((($officer_royalp==TRUE)&&($board->gametype==2))||($board->gametype==1)) {$dem=0;}// Kautilya allows the demotion but Classical had no demotion
										elseif($board->gametype==2) {$dem=1;}

										if((($officer_royalp==TRUE)&&($board->gametype==1))  && ($piece->type!=ChessPiece::GENERAL)) 
											{continue;}// Classical does not allow non-Generals to truce

										if(abs($ending_square->rank-$piece->square->rank)>=2)//only one step allowed
											continue;

										$cankill=0; //Cannot kill from CASTLE to external place
										$candemote=$board->checkdemotionparity( $board->export_fen(), $piece,$color_to_move,$board);
	
										if(($candemote==TRUE)&& ($canbepromoted==1)){// then update the parity with new demoted values
											//$piece->type=$piece->type+1;
											$new_move = new ChessMove( $piece->square, $ending_square,$ending_square, 0, $piece->color, $piece->type, $capture, $board, $store_board_in_moves, FALSE ,$controlled_move);

											$move2 = clone $new_move;
											//check if the king is killed
											if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
												$move2->set_killed_king(TRUE);
											if($officer_royalp==FALSE)
												$move2-> set_demotion_piece($piece->type+$dem);
											$moves[] = $move2;
											continue; //Demotion moves only...Dont Return but add more moves
										}
								}
							elseif(($piece->group=="OFFICER") &&(($ending_square->file==0)||($ending_square->file==9))&&(
								(($ending_square->rank>=0)&&($ending_square->rank<=9))&&($get_CASTLEMover!=1)
								)&&($board->gametype==2))
									{ // Check of demotion can happen as per Kautilya
										if($officer_royalp==TRUE) {$dem=0;}
										else {$dem=1;}
		
										if((($officer_royalp==TRUE)&&($board->gametype==2))||($board->gametype==1)) {$dem=0;}// Kautilya allows the demotion but Classical had no demotion
										elseif($board->gametype==2) {$dem=1;}
	
										if((($officer_royalp==TRUE)&&($board->gametype==1))  && ($piece->type!=ChessPiece::GENERAL)) 
											{continue;}// Classical does not allow non-Generals to truce

										$candemote=$board->checkdemotionparity( $board->export_fen(), $piece,$color_to_move,$board);
		
										if($candemote==TRUE){// then update the parity with new demoted values
											//$piece->type=$piece->type+1;
				
											$new_move = new ChessMove( $piece->square, $ending_square,$ending_square, 0, $piece->color, $piece->type, $capture, $board, $store_board_in_moves, FALSE,$controlled_move );

											$move2 = clone $new_move;
											//check if the king is killed
											if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
												$move2->set_killed_king(TRUE);
											if($officer_royalp==FALSE)
												$move2-> set_demotion_piece($piece->type+$dem);
											$moves[] = $move2;
											continue; //Demotion moves only...Dont Return but add more moves
										}
									}

							$ksqr=$board->get_king_square(abs($color_to_move-3));
							if($ksqr==null) continue;
							//If King is holding scepter then no Capture Allowed
							if(($capture==TRUE)&&($cankill==1)&&
								(($board->get_king_square(abs($color_to_move-3))->rank==0)&&($board->get_king_square(abs($color_to_move-3))->file==4)&&($color_to_move==1)
								||($board->get_king_square(abs($color_to_move-3))->rank==9)&&($board->get_king_square(abs($color_to_move-3))->file==5)&&($color_to_move==2)))
								{
										continue;
								}
				
							if(($cankill==0) &&($capture)){ // Knight logic is required to check the surrounding resource from P to S
									continue;
								}

							//Unelevated Royals or SemiRoyals from WAR to TRUCE
							if(($royal_royalp==false)&&(($piece->group=="ROYAL") || ($piece->group=="SEMIROYAL")) &&((($piece->square->rank>0)&&($piece->square->rank<9))&&(($ending_square->file==0)||($ending_square->file==9)))&&(($ending_square->rank<=9)||($ending_square->rank>=0)))
									{
									continue;
									}

							//Unelevated KING from WAR to CASTLE ZONE But not to Sceptres
							if(($royal_royalp==false)&&($piece->group=="ROYAL")&&(( ($piece->type == ChessPiece::KING)||( $piece->type == ChessPiece::INVERTEDKING))&&
									(((($piece->square->rank>0)&&($piece->square->rank<9))&&(($ending_square->rank==0)||($ending_square->rank==9)))&&(($ending_square->file<4)||($ending_square->file>5))||		
									((($piece->square->rank>0)&&($piece->square->rank<9))&&(($ending_square->rank>0)&&($ending_square->rank<9)))&&(($ending_square->file>=0)&&($ending_square->file<=9))
									)))
									{
										continue;
									}
							//WAR to CASTLE ZONE But not to Sceptres
							if(($royal_royalp==true)&&($piece->group=="ROYAL")&&(( ($piece->type == ChessPiece::KING)||( $piece->type == ChessPiece::INVERTEDKING))&&
								(((($piece->square->rank>0)&&($piece->square->rank<9))&&(($ending_square->rank==0)||($ending_square->rank==9)))&&(($ending_square->file<4)||($ending_square->file>5))||		
								((($piece->square->rank>0)&&($piece->square->rank<9))&&(($ending_square->rank>0)&&($ending_square->rank<9)))&&(($ending_square->file>=0)&&($ending_square->file<=9))
								)))
								{
										//$moves-> set_promotion_piece(2);
										$new_move = new ChessMove( $piece->square, $ending_square,$ending_square, 1, $piece->color, $piece->type, $capture, $board, $store_board_in_moves, FALSE,$controlled_move );
										$move2 = clone $new_move;
										//check if the king is killed
										if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
											$move2->set_killed_king(TRUE);
										if(( $piece->type != ChessPiece::KING)){
											//$move2-> set_demotion_piece($piece->type+$dem);
											$move2-> set_promotion_piece(1);
										}
										$moves[] = $move2;
										$move3 = clone $new_move;
										//check if the king is killed
										if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
											$move3->set_killed_king(TRUE);
										if(( $piece->type != ChessPiece::INVERTEDKING)){
												$move3-> set_promotion_piece(2);
											}
										$moves[] = $move3;
								}
							//CASTLE too CASTLE or CASTLE to WAR
							elseif(($piece->group=="ROYAL")&&(( $piece->type == ChessPiece::KING)&&
								(((($piece->square->rank==0)||($piece->square->rank==9))&&($ending_square->rank!=$piece->square->rank))||
								((($piece->square->rank==0)||($piece->square->rank==9))&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file==0)||($ending_square->file==9)))
								)))
								{
										//$moves-> set_promotion_piece(2);
										$new_move = new ChessMove($piece->square, $ending_square,$ending_square, 1, $piece->color, $piece->type, $capture, $board, $store_board_in_moves, FALSE,$controlled_move );

										$move2 = clone $new_move;
										//check if the king is killed
										if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
											$move2->set_killed_king(TRUE);
										if(( $piece->type != ChessPiece::KING)){
											//$move2-> set_demotion_piece($piece->type+$dem);
											$move2-> set_promotion_piece(1);
											}
										$moves[] = $move2;
										$move3 = clone $new_move;
										//check if the king is killed
										if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
												$move3->set_killed_king(TRUE);
										if(( $piece->type != ChessPiece::INVERTEDKING)){
												$move3-> set_promotion_piece(2);
											}
										$moves[] = $move3;
								}
							
							//CASTLE to No Mans = TRuce ... KING movement not covered....
							elseif(($piece->group=="ROYAL")&&( $piece->type == ChessPiece::KING) && ((
								((($piece->square->rank==0)&&(($ending_square->file==4) ||($ending_square->file==5))&&($color_to_move==1)
								)||(($piece->square->rank==9)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file==4)||($ending_square->file==5))&&($color_to_move==2)
								))) || /*CASTLE KING becoming full king*/	
								(
								(($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0) && ($piece->square->file<9))&&
								(($ending_square->file==4) ||($ending_square->file==5))&&(($ending_square->rank==0)||($ending_square->rank==9)))					
								)){
										//$moves-> set_promotion_piece(2);
										$new_move = new ChessMove( $piece->square, $ending_square,$ending_square, 1, $piece->color, $piece->type, $capture, $board, $store_board_in_moves, FALSE,$controlled_move );

										$move2 = clone $new_move;
										$moves[] = $move2;
										$move3 = clone $new_move;
										//check if the king is killed
										if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
											$move3->set_killed_king(TRUE);
										$move3-> set_promotion_piece(2);
										$moves[] = $move3;
								}
							elseif(($piece->group=="ROYAL")&&($piece->type == ChessPiece::KING)&&
								(($piece->square->rank>0)&&($piece->square->rank<9)&&(($piece->square->file==0) || ($piece->square->file==9))))
								{
										$new_move = new ChessMove( $piece->square, $ending_square,$ending_square, 1, $piece->color, $piece->type, $capture, $board, $store_board_in_moves, FALSE,$controlled_move );
										$moves[] = $move2;
										$move3 = clone $new_move;
										//check if the king is killed
										if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
											$move3->set_killed_king(TRUE);
										if(( $piece->type != ChessPiece::INVERTEDKING)){												
												$move3-> set_promotion_piece(2);
											}
										$moves[] = $move3;
								}
							elseif(($piece->group=="ROYAL")&&((( $piece->type == ChessPiece::KING)&&
								((($piece->square->rank==0)&&(($piece->square->file==4) ||($piece->square->file==5))&&($color_to_move==1)
								)||(($piece->square->rank==9)&&(($piece->square->file==4)||($piece->square->file==5))&&($color_to_move==2)
								)))|| (( $piece->type == ChessPiece::KING)&&
								(($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0) && ($piece->square->file<9)))	
								)){
										//$moves-> set_promotion_piece(2);
										$new_move = new ChessMove( $piece->square, $ending_square,$ending_square, 1, $piece->color, $piece->type, $capture, $board, $store_board_in_moves, FALSE ,$controlled_move);
										if(( $piece->type == ChessPiece::KING)){

											$move2 = clone $new_move;
											//check if the king is 
											/*
											if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
												$move2->set_killed_king(TRUE);
											//$move2-> set_demotion_piece($piece->type+$dem);
											$move2-> set_promotion_piece(1);
											*/
										}
										$moves[] = $move2;
										$move3 = clone $new_move;
										//check if the king is killed
										if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
											$move3->set_killed_king(TRUE);
										if(( $piece->type != ChessPiece::INVERTEDKING)){												
											$move3-> set_promotion_piece(2);
										}
										$moves[] = $move3;
								}
							else
								{
									if(($capture==true) && ($ending_square->mediatorrank!=null)&&($ending_square->mediatorfile!=null)){
										$mediatorpiece = clone $piece;
										$endpiece = clone $board->board[$ending_square->rank][$ending_square->file];

										if(($piece->square->mediatorrank!=$ending_square->mediatorrank)&&($piece->square->mediatorfile!=$ending_square->mediatorfile)){
											$mediatorpiece->square->mediatorrank=$ending_square->mediatorrank;
											$mediatorpiece->square->mediatorfile=$ending_square->mediatorfile;
											$mediatorpiece->state="V";
											}
										$sittingpiece=$board->board[$mediatorpiece->square->rank][$mediatorpiece->square->file];
										$board1 = clone $board;
										$board1->board[$mediatorpiece->square->rank][$mediatorpiece->square->file]=$mediatorpiece;
										if($tempc>=1){
											$moves = self::add_running_capture_moves_to_moves_list($moves, $mediatorpiece, $endpiece, $color_to_move, $board1, $store_board_in_moves,1,$selfbrokencastle,$foebrokencastle);
											continue;
										}
									}
									else {
										$new_move1 = new ChessMove( $piece->square, $ending_square,$ending_square, -1, $piece->color, $piece->type, $capture, $board, $store_board_in_moves, false,$controlled_move);
										$move2 = clone $new_move1;
										$moves[] = 	$move2;
										}
									//continue;
				 				}

							if(($piece->group=="SEMIROYAL")&&((($ending_square->rank>=8)&&(($ending_square->file>0)&&($ending_square->file<9))&&($color_to_move==1))||
								(($ending_square->rank<=1)&&(($ending_square->file>0)&&($ending_square->file<9))&&($color_to_move==2))
								))
								{
									$new_move = new ChessMove( $piece->square, $ending_square,$ending_square, 0, $piece->color, $piece->type, $capture, $board, $store_board_in_moves, FALSE,$controlled_move );
									$moves[] = $new_move;

										$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,12);
						
										if((($ending_square->rank==1)&&($color_to_move==2))||(($ending_square->rank==8)&&($color_to_move==1))){
											if($canpromote==TRUE){// then update the parity with new ptomoted values
												//$piece->type=$piece->type+1;
												//Force Promotion to add in movelist	
												$move3 = clone $new_move;
												//check if the king is killed
												if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
													$move3->set_killed_king(TRUE);
												$move3-> set_promotion_piece(12);
												$moves[] = $move3;
											}
										}

										if((($ending_square->rank==0)&&($color_to_move==2))||(($ending_square->rank==9)&&($color_to_move==1))){
												$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,12);
							
												if($canpromote==TRUE){// then update the parity with new ptomoted values
													//$piece->type=$piece->type+1;
													//Force Promotion to add in movelist	
													$new_move1 = new ChessMove( $piece->square, $ending_square,$ending_square, 0, $piece->color, $piece->type, $capture, $board, $store_board_in_moves, FALSE,$controlled_move );

													if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
														$new_move1->set_killed_king(TRUE);
													$new_move1-> set_promotion_piece(12);
													$moves[] = $new_move1;
								
												$canpromote=false;

												if((($foebrokencastle==true)&&((($ending_square->rank==9)&&($color_to_move==1))||(($ending_square->rank==0)&&($color_to_move==2)))) &&(($ending_square->file==4)||($ending_square->file==5)))
													{ 
														continue;
													}
												$moves[] = $move1;
												continue;
											}
								}
							}
							//***  Process it at th end only */	

							if(($piece->group=="OFFICER")&&($piece->square->file>0)&&($piece->square->file<9)){ // Check of promotion can happen except TZ
								$skipxy=$piece->square;

								$droyalp=self::has_royal_neighbours(  self::KING_DIRECTIONS, $skipxy, $ending_square, $color_to_move, $board );
					
								$targetpiece=clone $piece;
								$targetpiece->square->file=	$ending_square->file;
								$targetpiece->square->rank=	$ending_square->rank;

								$dgeneralp=self::check_general_royal_neighbours_promotion( self::KING_DIRECTIONS, $targetpiece, $color_to_move, $board );
								// Check of destination promotion can happen
								if(($canbepromoted==1)&&(($droyalp==TRUE)||($dgeneralp==TRUE)))
									{ 
										$dem=-1;

										$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,$piece->type-1);

										if(($canpromote==TRUE)&& ($canbepromoted==1)){// then update the parity with new demoted values
											//$piece->type=$piece->type+1;
											//Force Promotion to add in movelist	
											$new_move1 = new ChessMove( $piece->square, $ending_square,$ending_square, 0, $piece->color, $piece->type, $capture, $board, $store_board_in_moves, FALSE,$controlled_move );

											$move3 = clone $new_move1;
											//check if the king is killed
											if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
												$move3->set_killed_king(TRUE);
											$move3-> set_promotion_piece($piece->type+$dem);

											//check if the king is killed
											if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square(abs($color_to_move-3))->file==$ending_square->file)))
													$move3->set_killed_king(TRUE);
											$moves[] = $move3;
										}
									}
								else
									{

									}
							}
						 }
				}
				}
		}
		return $moves;
	}

	static function mark_checks_and_checkmates(array $moves, $color_to_move): void {
		$enemy_color = self::invert_color($color_to_move);		
		foreach ( $moves as $move ) {
			$enemy_king_square = $move->board->get_king_square($enemy_color);
			//if(($move->ending_square->file==3)&&($move->ending_square->rank==3)){
				if(($enemy_king_square==null)&&($move->ending_square->file>=0)&&($move->ending_square->rank>=0)){
					$enemy_king_square=$move->ending_square; // Moving in check condition
				}
			//}

			if ( self::square_is_attacked($color_to_move, $move->board, $enemy_king_square) ) {
				$move->check = TRUE;
				$legal_moves_for_enemy = self::get_legal_moves_list($enemy_color, $move->board, TRUE, TRUE, FALSE);
				
				if ( ! $legal_moves_for_enemy ) {
					$move->checkmate = TRUE;
				}
			}
		}
	}
	
	static function eliminate_king_in_check_moves(ChessPiece $king, array $moves, $color_to_move): array {
		if ( ! $king ) {
			throw new Exception('Invalid FEN - One of the kings is missing');
		}
		
		$enemy_color = self::invert_color($color_to_move);
		$new_moves = array();
		
		foreach ( $moves as $move ) {
			$friendly_king_square = $move->board->get_king_square($color_to_move);
			//self::square_is_attacked($enemy_color, $move->board, $friendly_king_square);
			if (!self::square_is_attacked($enemy_color, $move->board, $friendly_king_square) ) { //Mover's Kings is not under threat
				$new_moves[] = $move;
			}
			else
			if (self::square_is_attacked($enemy_color, $move->board, $friendly_king_square) ) {
				$new_moves[] = $move;
			}
		}
		
		return $new_moves;
	}
		
	static function get_all_pieces_by_color($color_to_move, ChessBoard $board): array {
		$list_of_pieces = array();
		for ( $i = 0; $i <= 9; $i++ ) {
			for ( $j = 0; $j <=9; $j++ ) {
				$piece = $board->board[$i][$j];
				
				if ( $piece ) {
					if ( $piece->color == $color_to_move ) {
						$list_of_pieces[] = $piece;
					}
				}
			}
		}
		return $list_of_pieces;
	}

	static function checkpinnedrefugees($color_to_move,$board,ChessSquare $starting_square,ChessSquare $ending_square):?bool
	{
	
		if($color_to_move==2){
				$pinnedelementscount=count($board->PinnedWRefugees);
		}
		elseif($color_to_move==1){
			$pinnedelementscount=count($board->PinnedBRefugees);
		}
			for($i=0;$i<8;$i++){
				if($i<count($board->PinnedWRefugees)){
						if (($color_to_move==2)&&  (($ending_square->rank==$board->PinnedWRefugees[$i]->square->rank) &&($ending_square->file==$board->PinnedWRefugees[$i]->square->file))){
							//Cannt kill as it is pinned
							return true;
							}

						if (($color_to_move==1)&&(count($board->PinnedWRefugees)>$i)&&(($board->board[$starting_square->rank][$starting_square->file]->group=='OFFICER')
							&&(($starting_square->rank==$board->PinnedWRefugees[$i]->square->rank) &&($starting_square->file==$board->PinnedWRefugees[$i]->square->file)))){
								//Cannt kill as it is pinned
								return true;
							}
					}
				elseif($i<count($board->PinnedBRefugees)){
						if ( ($color_to_move==1)&&(($ending_square->rank==$board->PinnedBRefugees[$i]->square->rank) &&($ending_square->file==$board->PinnedBRefugees[$i]->square->file)) ){
							//Cannt kill as it is pinned
							return true;
						}

						if (($color_to_move==2)&&(count($board->PinnedBRefugees)>$i)&&(($board->board[$starting_square->rank][$starting_square->file]->group=='OFFICER')
						&&(($starting_square->rank==$board->PinnedBRefugees[$i]->square->rank) &&($starting_square->file==$board->PinnedBRefugees[$i]->square->file)))){
							//Cannt kill as it is pinned
							return true;
						}
					}
				}
			return false;
	}				

// positive X = east, negative X = west, positive Y = north, negative Y = south
//Knight can always strike in 1st move. Fix this issue..

	static function square_exists_and_not_occupied_by_friendly_piece(		
		int $type,
		$jumpflag,
		ChessSquare $starting_square,
		int $y_delta,int $x_delta,
		$color_to_move,
		ChessBoard $board,
		int $cankill,
		$get_FullMover,
		$selfbrokencastle,
		$foebrokencastle
	): ?ChessSquare {
		//type = 0 means slide
		$xx=0;$yy=0;
		$rank = $starting_square->rank + $y_delta;
		$file = $starting_square->file + $x_delta;

		$ending_square = self::try_to_make_square_using_rank_and_file_num($rank,$file);
		$intermediate_square = null;


		if(($type!=0)&&(($get_FullMover==false)&&($file==-1)||($file==10))){
			if($file==-1){ //War to Truce
				$file=0;}
			else if($file==10){ 	
				$file=9;}

			$intermediate_square=self::try_to_make_square_using_rank_and_file_num ($starting_square->rank,$file);
			if(!$board->board[$intermediate_square->rank][$intermediate_square->file]){//if intermediate cell is blank data
					return $intermediate_square;
			}
			return null;
		}
		
		// Ending square is off the board
		if ( ! $ending_square ) {	
			return null;
		}


		/*if(($starting_square->rank==8)&&($starting_square->file==6)&&($ending_square->rank==9)&&($ending_square->file==7))
		{$ttt=1;}
		if(($ending_square->rank==9)&&($ending_square->file==1)&&($starting_square->rank==7)&&($starting_square->file==2))
		{$ttt=1;}*/
		if( (($selfbrokencastle==true)&&( $starting_square->rank==9)&&($ending_square->rank<8)&&($color_to_move==2)||
		($foebrokencastle==true)&&($ending_square->rank>1)&&($starting_square->rank==0)&&($color_to_move==2))||  
		(($selfbrokencastle==true)&&( $starting_square->rank==0)&&($ending_square->rank>1)&&($color_to_move==1)||
		($foebrokencastle==true)&&($ending_square->rank<8)&&($starting_square->rank==9)&&($color_to_move==1)))
		{
			$intermediate_square = null;
		}
		if( ((($selfbrokencastle==true)&&( $starting_square->rank==9)&&($ending_square->rank>=6)&&($color_to_move==2)||
		($foebrokencastle==true)&&($ending_square->rank<=3)&&($starting_square->rank==0)&&($color_to_move==2))||  
		(($selfbrokencastle==true)&&( $starting_square->rank==0)&&($ending_square->rank<=3)&&($color_to_move==1)||
		($foebrokencastle==true)&&($ending_square->rank>=6)&&($starting_square->rank==9)&&($color_to_move==1)))  )
		{ /*
			* Enter into WAR Zone from Compromized CASTLE or move within CASTLE
			*/
			if($type==0) {
				$intermediate_square=$ending_square;
				$intermediate_square=null;
			}
			else
			if($type!=0){
				if(($type==2)&&(abs($x_delta)<2) &&(abs($y_delta)<2))
				{
				}
				else
				if ($type>=1){ 
					if ($jumpflag=='1') {
						//$straight jump
		
						// if Intermediate square contains a enemy piece
						if (($starting_square->rank)-($ending_square->rank)==2) {
							$yy=-1; //**echo ' xx_-1 ';
						}
						if (($ending_square->rank)-($starting_square->rank)==2) {
							$yy=1;//**echo ' xx_1 ';
						}
		
						if (($starting_square->file)-($ending_square->file)==2) {
							$xx=-1;//**echo ' yy_-1 ';
						}
						
						if (($ending_square->file)-($starting_square->file)==2) {
							$xx=1;//**echo ' yy_1 ';
						}
					
						if (abs($starting_square->rank-$ending_square->rank)==2) {
							$xx=0;//**echo ' yy ';
						} elseif (abs($starting_square->file-$ending_square->file)==2) {
							$yy=0; 	//**echo ' xx ';
						}
					}
					elseif ($jumpflag>='2') {
						//$diagonal jump
						if ((($starting_square->rank)-($ending_square->rank)==2)||(($starting_square->rank)-($ending_square->rank)==1)) {
							$yy=-1; //**echo ' xx_-1 ';
						}
						if ((($ending_square->rank)-($starting_square->rank)==2)||(($ending_square->rank)-($starting_square->rank)==1)) {
							$yy=1;//**echo ' xx_1 ';
						}
	
						if ((($starting_square->file)-($ending_square->file)==2)||(($starting_square->file)-($ending_square->file)==1)) {
							$xx=-1;//**echo ' yy_-1 ';
						}
					
						if ((($ending_square->file)-($starting_square->file)==2)||(($ending_square->file)-($starting_square->file)==1)) {
							$xx=1;//**echo ' yy_1 ';
						}
					}
					$intermediate_square = self::try_to_make_square_using_rank_and_file_num($starting_square->rank+$yy, $starting_square->file+$xx);
					if ( ! $intermediate_square ) {
						return null;
					}
					
					/* This is doubtfull
					if(  $intermediate_square->rank!=$starting_square->rank ){
						return null;
					}
					*/
		
					if(($board->board[$intermediate_square->rank][$intermediate_square->file]) && 
					(strpos($board->board[$starting_square->rank][$starting_square->file]->group,"OFFICER")!==FALSE)) {//if intermediate cell has King then jumping now allowed
						if (($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='ROYAL')){
								return null;//
							}
						}

					if($board->board[$intermediate_square->rank][$intermediate_square->file]){//if intermediate cell has data
						if (($cankill==2) &&($type==1)&&(abs($board->board[$intermediate_square->rank][$intermediate_square->file]->color - $color_to_move) ==0)) {//Same team-member
							if(($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='ROYAL')||
							($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='SEMIROYAL')||
							($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='OFFICER')||
							($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='SOLDIER')){
							}
						else
							{
								return null;//
							}
						}
					}
		
					if($board->board[$ending_square->rank][$ending_square->file]){//Ending has enemy but intermediate is blank
						if(($jumpflag==1)&&($ending_square->rank!=$intermediate_square->rank)){
							return null;//cannot kill outside of the compromised castle.
						}
						if(!$board->board[$intermediate_square->rank][$intermediate_square->file]){//if intermediate cell is blank data
							if (($cankill==2) &&(abs($board->board[$ending_square->rank][$ending_square->file]->color - $color_to_move) ==1)) {//Enemy team-member
								return null;//
								}
							}
						}
			
					if ( $board->board[$intermediate_square->rank][$intermediate_square->file] ) { //Check Intermediate Block
						if ( $board->board[$intermediate_square->rank][$intermediate_square->file]->color - $color_to_move==0 ) {
							//**echo ' samecolor';							
						}
						else
						if ( abs($board->board[$intermediate_square->rank][$intermediate_square->file]->color - $color_to_move) ==1) {
						//**echo ' diffcolor';
							return null;
						}
						else
						{
							//**echo ' blankcolor';
						}
					}
					else
					if ( $board->board[$rank][$file] ) {//Check Ending block
						if ( $board->board[$rank][$file]->color - $color_to_move==0 ) {
						//**echo ' samecolor';
						return null; 
						}
						else
						if ( $board->board[$rank][$file]->color == $color_to_move ) {
							//**echo ' Ending square contains a friendly piece ';
							return null;
						}
						else
						if ( abs($board->board[$rank][$file]->color - $color_to_move) ==1) {
							//**echo ' diffcolor'; abs($board->board[$rank][$file]->color - $color_to_move)
							//check if no naarad pinned blocks present
							if(self::checkpinnedrefugees($color_to_move,$board, $starting_square,$ending_square)==true)
								return null;
						}
						else
						{
							//**echo ' blankcolor';
						}
					}
				}
			}
		}
		else
		//No movedown in truce
		if((($ending_square->rank>=1)&&($ending_square->rank<=8)&&($starting_square->rank>=1)&&($starting_square->rank<=8))&&
		(($ending_square->file==0)||($ending_square->file==9)||($starting_square->file==0)||($starting_square->file==9))&&(($ending_square->file==$starting_square->file))){
			return null;
		}
		 //should Fix the issue for General also
		elseif((($selfbrokencastle==true)&&($ending_square->rank==0)&&($color_to_move==1)||
		($foebrokencastle==true)&&($ending_square->rank==9)&&($color_to_move==1)) ||(($selfbrokencastle==true)&&($ending_square->rank==9)&&($color_to_move==2)||
		($foebrokencastle==true)&&($ending_square->rank==0)&&($color_to_move==2))  
		||(($ending_square->file>0)&&($ending_square->file<9)&&(($ending_square->rank==9)||($ending_square->rank==0))&&($starting_square->rank>1)&&($starting_square->rank<9)&&($color_to_move==1)&&($board->gametype==1)))

		{ /*
			* Enter into CASTLE as it has become warzone
			*/
			if($type==0) {
				$intermediate_square=$ending_square;
						//$diagonal move
						if ((($starting_square->rank)-($ending_square->rank)>=2)&&(($starting_square->file)-($ending_square->file)>=2)) {
							$yy=-1; $xx=-1 ;
						}
						if ((($starting_square->rank)-($ending_square->rank)>=2)&&(($ending_square->file)-($starting_square->file)>=2)) {
							$yy=-1; $xx=1 ;
						}
						if ((($ending_square->rank)-($starting_square->rank)>=2)&&(($ending_square->file)-($starting_square->file)>=2)) {
							$yy=1; $xx=1 ;
						}
						if ((($ending_square->rank)-($starting_square->rank)>=2)&&(($starting_square->file)-($ending_square->file)>=2)) {
							$yy=1; $xx=-1 ;
						}
					$intermediate_square = self::try_to_make_square_using_rank_and_file_num($starting_square->rank+$yy, $starting_square->file+$xx);
					if ( ! $intermediate_square ) {
						return null;
					}
					if(($board->board[$intermediate_square->rank][$intermediate_square->file]) && 
					(strpos($board->board[$starting_square->rank][$starting_square->file]->group,"OFFICER")!==FALSE)) {//if intermediate cell has King then jumping now allowed
						if (($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='ROYAL')){
								return null;//
							}
						}
				}
			else
			if($type!=0){
				if(($type==2)&&(abs($x_delta)<2) &&(abs($y_delta)<2))
				{
				}
				else
				if ($type>=1){ 
					// if Intermediate square contains a enemy piece 
					if ($jumpflag=='1') {
						//$straight jump
		
						// if Intermediate square contains a enemy piece
						if (($starting_square->rank)-($ending_square->rank)==2) {
							$yy=-1; //**echo ' xx_-1 ';
						}
						if (($ending_square->rank)-($starting_square->rank)==2) {
							$yy=1;//**echo ' xx_1 ';
						}
		
						if (($starting_square->file)-($ending_square->file)==2) {
							$xx=-1;//**echo ' yy_-1 ';
						}
						
						if (($ending_square->file)-($starting_square->file)==2) {
							$xx=1;//**echo ' yy_1 ';
						}
					
						if (abs($starting_square->rank-$ending_square->rank)==2) {
							$xx=0;//**echo ' yy ';
						} elseif (abs($starting_square->file-$ending_square->file)==2) {
							$yy=0; 	//**echo ' xx ';
						}
					}
					elseif ($jumpflag>='2') {
						//$diagonal jump
						if ((($starting_square->rank)-($ending_square->rank)==2)||(($starting_square->rank)-($ending_square->rank)==1)) {
							$yy=-1; //**echo ' xx_-1 ';
						}
						if ((($ending_square->rank)-($starting_square->rank)==2)||(($ending_square->rank)-($starting_square->rank)==1)) {
							$yy=1;//**echo ' xx_1 ';
						}
	
						if ((($starting_square->file)-($ending_square->file)==2)||(($starting_square->file)-($ending_square->file)==1)) {
							$xx=-1;//**echo ' yy_-1 ';
						}
					
						if ((($ending_square->file)-($starting_square->file)==2)||(($ending_square->file)-($starting_square->file)==1)) {
							$xx=1;//**echo ' yy_1 ';
						}
						//$intermediate_square = self::try_to_make_square_using_rank_and_file_num($rank, $file);
					}
					$intermediate_square = self::try_to_make_square_using_rank_and_file_num($starting_square->rank+$yy, $starting_square->file+$xx);
					if ( ! $intermediate_square ) {
						return null;
					}
					if(($board->board[$intermediate_square->rank][$intermediate_square->file]) && 
					(strpos($board->board[$starting_square->rank][$starting_square->file]->group,"OFFICER")!==FALSE)) {//if intermediate cell has King then jumping now allowed
						if (($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='ROYAL')){
								return null;//
							}
						}
					//No jumping of TRUCE
					if(($intermediate_square->rank!=$starting_square->rank) && (($intermediate_square->file==0)||($intermediate_square->file==9))){
						return null;
					}
		
					if($board->board[$intermediate_square->rank][$intermediate_square->file]){//if intermediate cell has data
						if (($cankill==2) &&($type==1)&&(abs($board->board[$intermediate_square->rank][$intermediate_square->file]->color - $color_to_move) ==0)) {//Same team-member
							if(($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='ROYAL')||
							($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='SEMIROYAL')||
							($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='OFFICER')||
							($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='SOLDIER')){
							}
						else
							{
								return null;//
							}
						}
					}
		
					if($board->board[$ending_square->rank][$ending_square->file]){//Ending has enemy but intermediate is blank
						if(!$board->board[$intermediate_square->rank][$intermediate_square->file]){//if intermediate cell is blank data
							if (($cankill==2) &&(abs($board->board[$ending_square->rank][$ending_square->file]->color - $color_to_move) ==1)) {//Enemy team-member
								return null;//
								}
							}
						}
		
					if ((($intermediate_square->file==0 ) ||($intermediate_square->file==9 )) &&($intermediate_square->rank>=0 )&&($intermediate_square->rank<=9 )) {
						return null;
					}
		
					if ( $board->board[$intermediate_square->rank][$intermediate_square->file] ) { //Check Intermediate Block
						if ( $board->board[$intermediate_square->rank][$intermediate_square->file]->color - $color_to_move==0 ) {
						//**echo ' samecolor';
							
						}
						else
						if ( abs($board->board[$intermediate_square->rank][$intermediate_square->file]->color - $color_to_move) ==1) {
						//**echo ' diffcolor';
							return null;
						}
						else
						{
							//**echo ' blankcolor';
						}
					}
					else
					if ( $board->board[$rank][$file] ) {//Check Ending block
						if ( $board->board[$rank][$file]->color - $color_to_move==0 ) {
						//**echo ' samecolor';
						return null; 
						}
						else
						if ( $board->board[$rank][$file]->color == $color_to_move ) {
							//**echo ' Ending square contains a friendly piece ';
							return null;
						}
						else
						if ( abs($board->board[$rank][$file]->color - $color_to_move) ==1) {
							//**echo ' diffcolor'; abs($board->board[$rank][$file]->color - $color_to_move)
							//check if no naarad pinned block
							if(self::checkpinnedrefugees($color_to_move,$board,$starting_square,$ending_square)==true)
								return null;
						}
						else
						{
							//**echo ' blankcolor';
						}
					}
				}
			}
		}
		else
		if(($selfbrokencastle==true)&&($ending_square->rank==9)&&($color_to_move==2)||
		($foebrokencastle==true)&&($ending_square->rank==0)&&($color_to_move==2))
		{ /*
			* Enter into CASTLE as it has become warzone
			*/
			if($type==0) {
				//$intermediate_square=$ending_square;
				$intermediate_square=null;
			}
			else
			if($type!=0){
				if(($type==2)&&(abs($x_delta)<2) &&(abs($y_delta)<2))
				{
				}
				else
				if ($type>=1){ //Horse =1 King or General = 2 
					// if Intermediate square contains a enemy piece 
					if ($jumpflag=='1') {
						//$straight jump
		
						// if Intermediate square contains a enemy piece
						if (($starting_square->rank)-($ending_square->rank)==2) {
							$yy=-1; //**echo ' xx_-1 ';
						}
						if (($ending_square->rank)-($starting_square->rank)==2) {
							$yy=1;//**echo ' xx_1 ';
						}
		
						if (($starting_square->file)-($ending_square->file)==2) {
							$xx=-1;//**echo ' yy_-1 ';
						}
						
						if (($ending_square->file)-($starting_square->file)==2) {
							$xx=1;//**echo ' yy_1 ';
						}
					
						if (abs($starting_square->rank-$ending_square->rank)==2) {
							$xx=0;//**echo ' yy ';
						} elseif (abs($starting_square->file-$ending_square->file)==2) {
							$yy=0; 	//**echo ' xx ';
						}
					}
					elseif ($jumpflag>='2') {
						//$diagonal jump
						if ((($starting_square->rank)-($ending_square->rank)==2)||(($starting_square->rank)-($ending_square->rank)==1)) {
							$yy=-1; //**echo ' xx_-1 ';
						}
						if ((($ending_square->rank)-($starting_square->rank)==2)||(($ending_square->rank)-($starting_square->rank)==1)) {
							$yy=1;//**echo ' xx_1 ';
						}
	
						if ((($starting_square->file)-($ending_square->file)==2)||(($starting_square->file)-($ending_square->file)==1)) {
							$xx=-1;//**echo ' yy_-1 ';
						}
					
						if ((($ending_square->file)-($starting_square->file)==2)||(($ending_square->file)-($starting_square->file)==1)) {
							$xx=1;//**echo ' yy_1 ';
						}
					}
					$intermediate_square = self::try_to_make_square_using_rank_and_file_num($starting_square->rank+$yy, $starting_square->file+$xx);

					//**echo ' <br/> Night Move ';
					if ( ! $intermediate_square ) {
						return null;
					}
	
					if(($board->board[$intermediate_square->rank][$intermediate_square->file]) && 
					(strpos($board->board[$starting_square->rank][$starting_square->file]->group,"OFFICER")!==FALSE)) {//if intermediate cell has King then jumping now allowed
						if (($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='ROYAL')){
								return null;//
							}
						}
						
					if(  $intermediate_square->rank!=$starting_square->rank ){
						return null;
					}
		
					if($board->board[$intermediate_square->rank][$intermediate_square->file]){//if intermediate cell has data
						if ((($cankill==2) && ($type==1))&&(abs($board->board[$intermediate_square->rank][$intermediate_square->file]->color - $color_to_move) ==0)) {//Same team-member
							if(($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='ROYAL')||
							($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='SEMIROYAL')||
							($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='OFFICER')||
							($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='SOLDIER')){
							}
						else
							{
								return null;//knight Cannot kill without intermidetiate.. King or General can still move even if these
							}
						}
						else
						if ((abs($board->board[$intermediate_square->rank][$intermediate_square->file]->color - $color_to_move) !=0)) {
								return null;
						}
					}
		
					if($board->board[$ending_square->rank][$ending_square->file]){//Ending has enemy but intermediate is blank
						if(!$board->board[$intermediate_square->rank][$intermediate_square->file]){//if intermediate cell is blank data
							if (($cankill==2) &&(abs($board->board[$ending_square->rank][$ending_square->file]->color - $color_to_move) ==1)) {//Enemy team-member
								return null;//
								}
							}
						}
		
					if ((($intermediate_square->file==0 ) ||($intermediate_square->file==9 )) &&($intermediate_square->rank>=0 )&&($intermediate_square->rank<=9 )) {
						return null;
					}
		
					if ( $board->board[$intermediate_square->rank][$intermediate_square->file] ) { //Check Intermediate Block
						if ( $board->board[$intermediate_square->rank][$intermediate_square->file]->color - $color_to_move==0 ) {
						//**echo ' samecolor';
							
						}
						else
						if ( abs($board->board[$intermediate_square->rank][$intermediate_square->file]->color - $color_to_move) ==1) {
						//**echo ' diffcolor';
							return null;
						}
						else
						{
							//**echo ' blankcolor';
						}
					}
					else
					if ( $board->board[$rank][$file] ) {//Check Ending block
						if ( $board->board[$rank][$file]->color - $color_to_move==0 ) {
						//**echo ' samecolor';
						return null; 
						}
						else
						if ( $board->board[$rank][$file]->color == $color_to_move ) {
							//**echo ' Ending square contains a friendly piece ';
							return null;
						}
						else
						if ( abs($board->board[$rank][$file]->color - $color_to_move) ==1) {
							//**echo ' diffcolor'; abs($board->board[$rank][$file]->color - $color_to_move)
							//check if no naarad pinned blocks present
							if(self::checkpinnedrefugees($color_to_move,$board,$starting_square,$ending_square)==true)
								return null;
						}
						else
						{
							//**echo ' blankcolor';
						}
					}
				}
			}

		}
		/*elseif(((($ending_square->rank==0)||($ending_square->rank==9))&&($starting_square->rank>=1)&&($starting_square->rank<=8))&&
		(($ending_square->file>0)&&($ending_square->file<9))&&($board->board[$starting_square->rank][$starting_square->file]->group=='OFFICER')){
			return null;// No Officers are allowed to penetrate the CASTLE if not compromised or not pushed by Royal or General
		}*/
		elseif(($board->board[$starting_square->rank][$starting_square->file]!=null)  && (((($ending_square->rank==0)||($ending_square->rank==9))&&($starting_square->rank>=1)&&($starting_square->rank<=8))&&
		(($ending_square->file>0)&&($ending_square->file<9))&&($board->board[$starting_square->rank][$starting_square->file]->group=='SOLDIER'))){
			return null;// No Soldiers are allowed to penetrate the CASTLE  if not compromised
		}
		elseif(((($starting_square->file==0)||($starting_square->file==9))&&(($starting_square->rank==0)||($starting_square->rank==9))
		&&($board->board[$starting_square->rank][$starting_square->file]->group!='NOBLE'))){
			return null;// No-one can escape NoMans except RajRishi and Emperor
		}
		
		$xx=0; $yy=0;
		
		if(($type>=1)&&(abs($x_delta)<2) &&(abs($y_delta)<2))
		{
		}
		elseif ($type>=1){ //Horse
			if ($jumpflag=='1') {
				//$straight jump

				// if Intermediate square contains a enemy piece
				if (($starting_square->rank)-($ending_square->rank)==2) {
					$yy=-1; //**echo ' xx_-1 ';
				}
				if (($ending_square->rank)-($starting_square->rank)==2) {
					$yy=1;//**echo ' xx_1 ';
				}

				if (($starting_square->file)-($ending_square->file)==2) {
					$xx=-1;//**echo ' yy_-1 ';
				}
				
				if (($ending_square->file)-($starting_square->file)==2) {
					$xx=1;//**echo ' yy_1 ';
				}
			
				if (abs($starting_square->rank-$ending_square->rank)==2) {
					$xx=0;//**echo ' yy ';
				} elseif (abs($starting_square->file-$ending_square->file)==2) {
					$yy=0; 	//**echo ' xx ';
				}
			}
			elseif ($jumpflag>='2') {
						//$diagonal jump
						if ((($starting_square->rank)-($ending_square->rank)==2)||(($starting_square->rank)-($ending_square->rank)==1)) {
							$yy=-1; //**echo ' xx_-1 ';
						}
						if ((($ending_square->rank)-($starting_square->rank)==2)||(($ending_square->rank)-($starting_square->rank)==1)) {
							$yy=1;//**echo ' xx_1 ';
						}
	
						if ((($starting_square->file)-($ending_square->file)==2)||(($starting_square->file)-($ending_square->file)==1)) {
							$xx=-1;//**echo ' yy_-1 ';
						}
					
						if ((($ending_square->file)-($starting_square->file)==2)||(($ending_square->file)-($starting_square->file)==1)) {
							$xx=1;//**echo ' yy_1 ';
						}
			}
			//**echo ' <br/> Night Move ';
			$intermediate_square = self::try_to_make_square_using_rank_and_file_num($starting_square->rank+$yy, $starting_square->file+$xx);

			if ( ! $intermediate_square ) {
				return null;
			}

			if(($board->board[$intermediate_square->rank][$intermediate_square->file]) && 
			(strpos($board->board[$starting_square->rank][$starting_square->file]->group,"OFFICER")!==FALSE)) {//if intermediate cell has King then jumping now allowed
				if (($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='ROYAL')){
						return null;//
					}
				}

			if($board->board[$intermediate_square->rank][$intermediate_square->file]){//if intermediate cell has data
				if (/*((($cankill==2) &&($type ==1) ) || ($type==2)) &&*/(abs($board->board[$intermediate_square->rank][$intermediate_square->file]->color - $color_to_move) ==0)) {//Same team-member
					if(($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='ROYAL')||
					($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='SEMIROYAL')||
					($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='OFFICER')||
					($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='SOLDIER')){
					}
				else
					{
						return null;//
					}
				}
			}

			if($board->board[$ending_square->rank][$ending_square->file]){//Ending has enemy but intermediate is blank
				if(!$board->board[$intermediate_square->rank][$intermediate_square->file]){//if intermediate cell is blank data
					if ((($cankill==2)||($cankill==0)) &&(abs($board->board[$ending_square->rank][$ending_square->file]->color - $color_to_move) ==1)) {//Enemy team-member
						$ending_square->mediatorrank=$intermediate_square->rank*-1;
						$ending_square->mediatorfile=$intermediate_square->file*-1;
						//return null;//Horse cannot kill without mixing.... Horse can repel even without mixing
						return $ending_square;//Horse cannot kill without mixing.... Horse can repel even without mixing
						}
					}
				if(($board->board[$intermediate_square->rank][$intermediate_square->file]) &&($cankill==0)){//if intermediate cell also has some data but
					if ((abs($board->board[$ending_square->rank][$ending_square->file]->color - $color_to_move) ==1)) {//Enemy team-member SPY ARTHSHASTRI
							return null;//SPY ARTHSHASTRI cant kill
						}
					}
				}

			if ((($intermediate_square->file==0 ) ||($intermediate_square->file==0 )) &&($intermediate_square->rank>=0 )&&($intermediate_square->rank<=9 )) {
				return null;
			}

			if ( $board->board[$intermediate_square->rank][$intermediate_square->file] ) { //Check Intermediate Block which data
				if ( $board->board[$intermediate_square->rank][$intermediate_square->file]->color - $color_to_move==0 ) {
				//**echo ' samecolor';
				}
				else
				if ( abs($board->board[$intermediate_square->rank][$intermediate_square->file]->color - $color_to_move) ==1) {
				//**echo ' diffcolor';
					return null;
				}
				else
				{
					//**echo ' blankcolor';
				}
			}
			else
			if ( $board->board[$rank][$file] ) {//Check Ending block which has intermediate block but no data
				if ( $board->board[$rank][$file]->color - $color_to_move==0 ) {
				//**echo ' samecolor';
				return null; 
				}
				else
				if ( $board->board[$rank][$file]->color == $color_to_move ) {
					//**echo ' Ending square contains a friendly piece ';
					return null;
				}
				else
				if ( abs($board->board[$rank][$file]->color - $color_to_move) ==1) {
					//**echo ' diffcolor'; abs($board->board[$rank][$file]->color - $color_to_move)
					//check if no naarad pinned blocks present
					if(self::checkpinnedrefugees($color_to_move,$board,$starting_square,$ending_square)==true)
					return null;
				}
				else
				{
					//**echo ' blankcolor';
				}
			}
		}

		if(($type>=1)&&($intermediate_square==null))
			return null;

		if(($type==2)&&($intermediate_square!=null)&&($board->board[$intermediate_square->rank][$intermediate_square->file]!=null)){ //Royals
			if ( $board->board[$intermediate_square->rank][$intermediate_square->file] ) { //Check Intermediate Block
				if ( $board->board[$intermediate_square->rank][$intermediate_square->file]->color - $color_to_move==0 ) {
				//echo ' samecolor';
					
				}
				else
				if ( abs($board->board[$intermediate_square->rank][$intermediate_square->file]->color - $color_to_move) ==1) {
				//echo ' diffcolor';
					return null;
				}
				else
				{
				}
			}
			else
			if ( $board->board[$rank][$file] ) {//Check Ending block

				if ( $board->board[$rank][$file]->color - $color_to_move==0 ) {
				//echo ' samecolor';
				return null; 
				}
				elseif ( $board->board[$rank][$file]->color == $color_to_move ) {
					return null;
				}
				elseif( abs($board->board[$rank][$file]->color - $color_to_move) ==1) {
					//check if no naarad pinned blocks present
					if(self::checkpinnedrefugees($color_to_move,$board,$starting_square,$ending_square)==true)
					return null;
				}
				else
				{
				}
			}
		}
		
		if(($type==1)&&($intermediate_square!=null)&&($board->board[$intermediate_square->rank][$intermediate_square->file]!=null)){
				if ((abs($board->board[$intermediate_square->rank][$intermediate_square->file]->color - $color_to_move) !=0)) {
					return null;
				}
		}

		// Ending square contains a friendly piece
		if ( $board->board[$rank][$file] ) {
			if ( $board->board[$rank][$file]->color - $color_to_move==0 ) {
				//echo ' samecolor';
				return null; 
				}
				elseif ( $board->board[$rank][$file]->color == $color_to_move ) {
					return null;
				}
				elseif( abs($board->board[$rank][$file]->color - $color_to_move) ==1) {
					//check if no naarad pinned blocks present
					if(self::checkpinnedrefugees($color_to_move,$board,$starting_square,$ending_square)==true)
					return null;
				}
		}

		//Check the last piece action on Trapped piece or Pushed Piece
		/*if(($intermediate_square!=null)&&($ending_square!=null) &&(($board->board[$intermediate_square->rank][$intermediate_square->file]==null)
		&& (($board->board[$ending_square->rank][$ending_square->file]!=null))	)){
				$settledpiece = clone $board->board[$starting_square->rank][$starting_square->file];
				$endingpiece =clone $board->board[$ending_square->rank][$ending_square->file];
				$settledpiece->square = $intermediate_square;
				self::check_virtual_trapped_piece($settledpiece,$endingpiece,$color_to_move, $board,'exclude');
			}
		*/	

		if($jumpflag==0) {
			$yy=0;
			$xx=0;
			
			if($starting_square->rank >= $ending_square->rank+2){
				$yy=1;
			}
			if($starting_square->rank <= $ending_square->rank -2 ){
				$yy=-1;
			}
			if($starting_square->file >= $ending_square->file +2 ){
				$xx=1;
			}

			if($starting_square->file <= $ending_square->file-2){
				$xx=-1;
			}

			$intermediate_square = self::try_to_make_square_using_rank_and_file_num($ending_square->rank+$yy, $ending_square->file+$xx);
		}

		if($intermediate_square!=null){ 
					if(($board->board[$intermediate_square->rank][$intermediate_square->file]) && 
					(strpos($board->board[$starting_square->rank][$starting_square->file]->group,"OFFICER")!==FALSE)) {//if intermediate cell has King then jumping now allowed
						if (($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='ROYAL')){
								return null;//
							}
						}
			$ending_square->mediatorfile=$intermediate_square->file;
			$ending_square->mediatorrank=$intermediate_square->rank;
		}
		return $ending_square;
	}
	
	// positive X = east, negative X = west, positive Y = north, negative Y = south
	static function piece_exists_and_not_occupied_by_friendly_piece(		
		int $type,
		$jumpflag,
		ChessSquare $starting_square,
		int $y_delta,int $x_delta,
		$color_to_move,
		ChessBoard $board,
		int $cankill,
		$get_FullMover,
		$selfbrokencastle,
		$foebrokencastle
	): ?ChessSquare {
		$xx=0;$yy=0;
		$rank = $starting_square->rank + $y_delta;
		$file = $starting_square->file + $x_delta;

		$ending_square = self::try_to_make_square_using_rank_and_file_num($rank,$file);
		$intermediate_square = null;

		//if(self::checkpinnedrefugees($color_to_move,$board,$rank,$file)==true){
			//$tttt=1;
		//}

		if(($type!=0)&&(($get_FullMover==false)&&($file==-1)||($file==10))){
			if($file==-1){ //War to Truce
				$file=0;}
			else if($file==10){ 	
				$file=9;}

			$intermediate_square=self::try_to_make_square_using_rank_and_file_num ($starting_square->rank,$file);
			if(!$board->board[$intermediate_square->rank][$intermediate_square->file]){//if intermediate cell is blank data
					return $intermediate_square;
			}
			return null;
		}
		
		// Ending square is off the board
		if ( ! $ending_square ) {	
			return null;
		}

		/*if(($starting_square->rank==8)&&($starting_square->file==6)&&($ending_square->rank==9)&&($ending_square->file==7))
		{$ttt=1;}
		if(($ending_square->rank==9)&&($ending_square->file==1)&&($starting_square->rank==7)&&($starting_square->file==2))
		{$ttt=1;}*/
		if( (($selfbrokencastle==true)&&( $starting_square->rank==9)&&($ending_square->rank<8)&&($color_to_move==2)||
		($foebrokencastle==true)&&($ending_square->rank>1)&&($starting_square->rank==0)&&($color_to_move==2))||  
		(($selfbrokencastle==true)&&( $starting_square->rank==0)&&($ending_square->rank>1)&&($color_to_move==1)||
		($foebrokencastle==true)&&($ending_square->rank<8)&&($starting_square->rank==9)&&($color_to_move==1)))
		{
			$intermediate_square = null;
		}
		if( ((($selfbrokencastle==true)&&( $starting_square->rank==9)&&($ending_square->rank>=6)&&($color_to_move==2)||
		($foebrokencastle==true)&&($ending_square->rank<=3)&&($starting_square->rank==0)&&($color_to_move==2))||  
		(($selfbrokencastle==true)&&( $starting_square->rank==0)&&($ending_square->rank<=3)&&($color_to_move==1)||
		($foebrokencastle==true)&&($ending_square->rank>=6)&&($starting_square->rank==9)&&($color_to_move==1)))  )
		{ /*
			* Enter into WAR Zone from Compromized CASTLE or move within CASTLE
			*/
			if($type==0) {
				$intermediate_square=$ending_square;
				$intermediate_square=null;
			}
			else
			if($type!=0){
				if(($type==2)&&(abs($x_delta)<2) &&(abs($y_delta)<2))
				{
				}
				else
				if ($type>=1){ 
					if ($jumpflag=='1') {
						// $straight jump
						// if Intermediate square contains a enemy piece
						if (($starting_square->rank)-($ending_square->rank)==2) {
							$yy=-1; //**echo ' xx_-1 ';
						}
						if (($ending_square->rank)-($starting_square->rank)==2) {
							$yy=1;//**echo ' xx_1 ';
						}
		
						if (($starting_square->file)-($ending_square->file)==2) {
							$xx=-1;//**echo ' yy_-1 ';
						}
						
						if (($ending_square->file)-($starting_square->file)==2) {
							$xx=1;//**echo ' yy_1 ';
						}
					
						if (abs($starting_square->rank-$ending_square->rank)==2) {
							$xx=0;//**echo ' yy ';
						} elseif (abs($starting_square->file-$ending_square->file)==2) {
							$yy=0; 	//**echo ' xx ';
						}
					}
					elseif ($jumpflag>='2') {
						//$diagonal jump
						if ((($starting_square->rank)-($ending_square->rank)==2)||(($starting_square->rank)-($ending_square->rank)==1)) {
							$yy=-1; //**echo ' xx_-1 ';
						}
						if ((($ending_square->rank)-($starting_square->rank)==2)||(($ending_square->rank)-($starting_square->rank)==1)) {
							$yy=1;//**echo ' xx_1 ';
						}
	
						if ((($starting_square->file)-($ending_square->file)==2)||(($starting_square->file)-($ending_square->file)==1)) {
							$xx=-1;//**echo ' yy_-1 ';
						}
					
						if ((($ending_square->file)-($starting_square->file)==2)||(($ending_square->file)-($starting_square->file)==1)) {
							$xx=1;//**echo ' yy_1 ';
						}
					}
					$intermediate_square = self::try_to_make_square_using_rank_and_file_num($starting_square->rank+$yy, $starting_square->file+$xx);
					if ( ! $intermediate_square ) {
						return null;
					}
					
					/* This is doubtfull
					if(  $intermediate_square->rank!=$starting_square->rank ){
						return null;
					}
					*/
		
					if($board->board[$intermediate_square->rank][$intermediate_square->file]){//if intermediate cell has data
						if (($cankill==2) &&($type==1)&&(abs($board->board[$intermediate_square->rank][$intermediate_square->file]->color - $color_to_move) ==0)) {//Same team-member
							if(($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='ROYAL')||
							($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='SEMIROYAL')||
							($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='OFFICER')||
							($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='SOLDIER')){
							}
						else
							{
								return null;//
							}
						}
					}
		
					if($board->board[$ending_square->rank][$ending_square->file]){//Ending has enemy but intermediate is blank
						if(($jumpflag==1)&&($ending_square->rank!=$intermediate_square->rank)){
							return null;//cannot kill outside of the compromised castle.
						}
						if(!$board->board[$intermediate_square->rank][$intermediate_square->file]){//if intermediate cell is blank data
							if (($cankill==2) &&(abs($board->board[$ending_square->rank][$ending_square->file]->color - $color_to_move) ==1)) {//Enemy team-member
								return null;//
								}
							}
						}
			
					if ( $board->board[$intermediate_square->rank][$intermediate_square->file] ) { //Check Intermediate Block
						if ( $board->board[$intermediate_square->rank][$intermediate_square->file]->color - $color_to_move==0 ) {
						//**echo ' samecolor';
							
						}
						else
						if ( abs($board->board[$intermediate_square->rank][$intermediate_square->file]->color - $color_to_move) ==1) {
						//**echo ' diffcolor';
							return null;
						}
						else
						{
							//**echo ' blankcolor';
						}
					}
					else
					if ( $board->board[$rank][$file] ) {//Check Ending block
						if ( $board->board[$rank][$file]->color - $color_to_move==0 ) {
						//**echo ' samecolor';
						return null; 
						}
						else
						if ( $board->board[$rank][$file]->color == $color_to_move ) {
							//**echo ' Ending square contains a friendly piece ';
							return null;
						}
						else
						if ( abs($board->board[$rank][$file]->color - $color_to_move) ==1) {
							//**echo ' diffcolor'; abs($board->board[$rank][$file]->color - $color_to_move)
							//check if no naarad pinned blocks present
							if(self::checkpinnedrefugees($color_to_move,$board, $starting_square,$ending_square)==true)
								return null;
						}
						else
						{
							//**echo ' blankcolor';
						}
					}
				}
			}
		}
		else
		//No movedown in truce
		if((($ending_square->rank>=1)&&($ending_square->rank<=8)&&($starting_square->rank>=1)&&($starting_square->rank<=8))&&
		(($ending_square->file==0)||($ending_square->file==9)||($starting_square->file==0)||($starting_square->file==9))&&(($ending_square->file==$starting_square->file))){
			return null;
		}
		 //should Fix the issue for General also
		elseif((($selfbrokencastle==true)&&($ending_square->rank==0)&&($color_to_move==1)||
		($foebrokencastle==true)&&($ending_square->rank==9)&&($color_to_move==1)) ||(($selfbrokencastle==true)&&($ending_square->rank==9)&&($color_to_move==2)||
		($foebrokencastle==true)&&($ending_square->rank==0)&&($color_to_move==2))  
		||   (($ending_square->file>0)&&($ending_square->file<9)&&(($ending_square->rank==9)||($ending_square->rank==0))&&($starting_square->rank>1)&&($starting_square->rank<9)&&($color_to_move==1)&&($board->gametype==1)))

		{ /*
			* Enter into CASTLE as it has become warzone
			*/
			if($type==0) {
				$intermediate_square=$ending_square;
						//$diagonal move
						if ((($starting_square->rank)-($ending_square->rank)>=2)&&(($starting_square->file)-($ending_square->file)>=2)) {
							$yy=-1; $xx=-1 ;
						}
						if ((($starting_square->rank)-($ending_square->rank)>=2)&&(($ending_square->file)-($starting_square->file)>=2)) {
							$yy=-1; $xx=1 ;
						}
						if ((($ending_square->rank)-($starting_square->rank)>=2)&&(($ending_square->file)-($starting_square->file)>=2)) {
							$yy=1; $xx=1 ;
						}
						if ((($ending_square->rank)-($starting_square->rank)>=2)&&(($starting_square->file)-($ending_square->file)>=2)) {
							$yy=1; $xx=-1 ;
						}
					$intermediate_square = self::try_to_make_square_using_rank_and_file_num($starting_square->rank+$yy, $starting_square->file+$xx);
					if ( ! $intermediate_square ) {
						return null;
					}
				}
			else
			if($type!=0){
				if(($type==2)&&(abs($x_delta)<2) &&(abs($y_delta)<2))
				{
				}
				else
				if ($type>=1){ 
					// if Intermediate square contains a enemy piece 
					if ($jumpflag=='1') {
						// $straight jump 		
						// if Intermediate square contains a enemy piece
						if (($starting_square->rank)-($ending_square->rank)==2) {
							$yy=-1; //**echo ' xx_-1 ';
						}
						if (($ending_square->rank)-($starting_square->rank)==2) {
							$yy=1;//**echo ' xx_1 ';
						}
		
						if (($starting_square->file)-($ending_square->file)==2) {
							$xx=-1;//**echo ' yy_-1 ';
						}
						
						if (($ending_square->file)-($starting_square->file)==2) {
							$xx=1;//**echo ' yy_1 ';
						}
					
						if (abs($starting_square->rank-$ending_square->rank)==2) {
							$xx=0;//**echo ' yy ';
						} elseif (abs($starting_square->file-$ending_square->file)==2) {
							$yy=0; 	//**echo ' xx ';
						}
					}
					elseif ($jumpflag>='2') {
						//$diagonal jump
						if ((($starting_square->rank)-($ending_square->rank)==2)||(($starting_square->rank)-($ending_square->rank)==1)) {
							$yy=-1; //**echo ' xx_-1 ';
						}
						if ((($ending_square->rank)-($starting_square->rank)==2)||(($ending_square->rank)-($starting_square->rank)==1)) {
							$yy=1;//**echo ' xx_1 ';
						}
	
						if ((($starting_square->file)-($ending_square->file)==2)||(($starting_square->file)-($ending_square->file)==1)) {
							$xx=-1;//**echo ' yy_-1 ';
						}
					
						if ((($ending_square->file)-($starting_square->file)==2)||(($ending_square->file)-($starting_square->file)==1)) {
							$xx=1;//**echo ' yy_1 ';
						}
						//$intermediate_square = self::try_to_make_square_using_rank_and_file_num($rank, $file);
					}
					$intermediate_square = self::try_to_make_square_using_rank_and_file_num($starting_square->rank+$yy, $starting_square->file+$xx);
					if ( ! $intermediate_square ) {
						return null;
					}
					
					//No jumping of TRUCE
					if(($intermediate_square->rank!=$starting_square->rank) && (($intermediate_square->file==0)||($intermediate_square->file==9))){
						return null;
					}
		
					if($board->board[$intermediate_square->rank][$intermediate_square->file]){//if intermediate cell has data
						if (($cankill==2) &&($type==1)&&(abs($board->board[$intermediate_square->rank][$intermediate_square->file]->color - $color_to_move) ==0)) {//Same team-member
							if(($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='ROYAL')||
							($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='SEMIROYAL')||
							($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='OFFICER')||
							($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='SOLDIER')){
							}
						else
							{
								return null;//
							}
						}
					}
		
					if($board->board[$ending_square->rank][$ending_square->file]){//Ending has enemy but intermediate is blank
						if(!$board->board[$intermediate_square->rank][$intermediate_square->file]){//if intermediate cell is blank data
							if (($cankill==2) &&(abs($board->board[$ending_square->rank][$ending_square->file]->color - $color_to_move) ==1)) {//Enemy team-member
								return null;//
								}
							}
						}
		
					if ((($intermediate_square->file==0 ) ||($intermediate_square->file==9 )) &&($intermediate_square->rank>=0 )&&($intermediate_square->rank<=9 )) {
						return null;
					}
		
					if ( $board->board[$intermediate_square->rank][$intermediate_square->file] ) { //Check Intermediate Block
						if ( $board->board[$intermediate_square->rank][$intermediate_square->file]->color - $color_to_move==0 ) {
							//**echo ' samecolor';							
						}
						else
						if ( abs($board->board[$intermediate_square->rank][$intermediate_square->file]->color - $color_to_move) ==1) {
							//**echo ' diffcolor';
							return null;
						}
						else { /*echo ' blankcolor';*/ }
					}
					else
					if ( $board->board[$rank][$file] ) {//Check Ending block
						if ( $board->board[$rank][$file]->color - $color_to_move==0 ) {
						//**echo ' samecolor';
						return null; 
						}
						else
						if ( $board->board[$rank][$file]->color == $color_to_move ) {
							//**echo ' Ending square contains a friendly piece ';
							return null;
						}
						else
						if ( abs($board->board[$rank][$file]->color - $color_to_move) ==1) {
							//**echo ' diffcolor'; abs($board->board[$rank][$file]->color - $color_to_move)
							//check if no naarad pinned block
							if(self::checkpinnedrefugees($color_to_move,$board,$starting_square,$ending_square)==true)
								return null;
						}
						else { /*echo ' blankcolor';*/ }
					}
				}
			}
		}
		else
		if(($selfbrokencastle==true)&&($ending_square->rank==9)&&($color_to_move==2)||
		($foebrokencastle==true)&&($ending_square->rank==0)&&($color_to_move==2))
		{ /*
			* Enter into CASTLE as it has become warzone
			*/
			if($type==0) {
				//$intermediate_square=$ending_square;
				$intermediate_square=null;
			}
			else
			if($type!=0){
				if(($type==2)&&(abs($x_delta)<2) &&(abs($y_delta)<2))
				{
				}
				else
				if ($type>=1){ //Horse =1 King or General = 2 
					// if Intermediate square contains a enemy piece 
					if ($jumpflag=='1') {
						// $straight jump
						// if Intermediate square contains a enemy piece
						if (($starting_square->rank)-($ending_square->rank)==2) {
							$yy=-1; //**echo ' xx_-1 ';
						}
						if (($ending_square->rank)-($starting_square->rank)==2) {
							$yy=1;//**echo ' xx_1 ';
						}
		
						if (($starting_square->file)-($ending_square->file)==2) {
							$xx=-1;//**echo ' yy_-1 ';
						}
						
						if (($ending_square->file)-($starting_square->file)==2) {
							$xx=1;//**echo ' yy_1 ';
						}
					
						if (abs($starting_square->rank-$ending_square->rank)==2) {
							$xx=0;//**echo ' yy ';
						} elseif (abs($starting_square->file-$ending_square->file)==2) {
							$yy=0; 	//**echo ' xx ';
						}
					}
					elseif ($jumpflag>='2') {
						//$diagonal jump
						if ((($starting_square->rank)-($ending_square->rank)==2)||(($starting_square->rank)-($ending_square->rank)==1)) {
							$yy=-1; //**echo ' xx_-1 ';
						}
						if ((($ending_square->rank)-($starting_square->rank)==2)||(($ending_square->rank)-($starting_square->rank)==1)) {
							$yy=1;//**echo ' xx_1 ';
						}
	
						if ((($starting_square->file)-($ending_square->file)==2)||(($starting_square->file)-($ending_square->file)==1)) {
							$xx=-1;//**echo ' yy_-1 ';
						}
					
						if ((($ending_square->file)-($starting_square->file)==2)||(($ending_square->file)-($starting_square->file)==1)) {
							$xx=1;//**echo ' yy_1 ';
						}
					}
					$intermediate_square = self::try_to_make_square_using_rank_and_file_num($starting_square->rank+$yy, $starting_square->file+$xx);

					//**echo ' <br/> Night Move ';
					if ( ! $intermediate_square ) {
						return null;
					}
					if(  $intermediate_square->rank!=$starting_square->rank ){
						return null;
					}
		
					if($board->board[$intermediate_square->rank][$intermediate_square->file]){//if intermediate cell has data
						if ((($cankill==2) && ($type==1))&&(abs($board->board[$intermediate_square->rank][$intermediate_square->file]->color - $color_to_move) ==0)) {//Same team-member
							if(($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='ROYAL')||
							($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='SEMIROYAL')||
							($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='OFFICER')||
							($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='SOLDIER')){
							}
						else
							{
								return null;//knight Cannot kill without intermidetiate.. King or General can still move even if these
							}
						}
						else
						if ((abs($board->board[$intermediate_square->rank][$intermediate_square->file]->color - $color_to_move) !=0)) {
								return null;
						}
					}
		
					if($board->board[$ending_square->rank][$ending_square->file]){//Ending has enemy but intermediate is blank
						if(!$board->board[$intermediate_square->rank][$intermediate_square->file]){//if intermediate cell is blank data
							if (($cankill==2) &&(abs($board->board[$ending_square->rank][$ending_square->file]->color - $color_to_move) ==1)) {//Enemy team-member
								return null;//
								}
							}
						}
		
					if ((($intermediate_square->file==0 ) ||($intermediate_square->file==9 )) &&($intermediate_square->rank>=0 )&&($intermediate_square->rank<=9 )) {
						return null;
					}
		
					if ( $board->board[$intermediate_square->rank][$intermediate_square->file] ) { //Check Intermediate Block
						if ( $board->board[$intermediate_square->rank][$intermediate_square->file]->color - $color_to_move==0 ) {
						//**echo ' samecolor';							
						}
						else
						if ( abs($board->board[$intermediate_square->rank][$intermediate_square->file]->color - $color_to_move) ==1) {
						//**echo ' diffcolor';
							return null;
						}
						else { /*echo ' blankcolor';*/ }
					}
					else
					if ( $board->board[$rank][$file] ) {//Check Ending block
						if ( $board->board[$rank][$file]->color - $color_to_move==0 ) {
						//**echo ' samecolor';
						return null; 
						}
						else
						if ( $board->board[$rank][$file]->color == $color_to_move ) {
							//**echo ' Ending square contains a friendly piece ';
							return null;
						}
						else
						if ( abs($board->board[$rank][$file]->color - $color_to_move) ==1) {
							//**echo ' diffcolor'; abs($board->board[$rank][$file]->color - $color_to_move)
							//check if no naarad pinned blocks present
							if(self::checkpinnedrefugees($color_to_move,$board,$starting_square,$ending_square)==true)
								return null;
						}
						else { /*echo ' blankcolor';*/ }
					}
				}
			}

		}
		/*elseif(((($ending_square->rank==0)||($ending_square->rank==9))&&($starting_square->rank>=1)&&($starting_square->rank<=8))&&
		(($ending_square->file>0)&&($ending_square->file<9))&&($board->board[$starting_square->rank][$starting_square->file]->group=='OFFICER')){
			return null;// No Officers are allowed to penetrate the CASTLE if not compromised or not pushed by Royal or General
		}*/
		elseif(((($ending_square->rank==0)||($ending_square->rank==9))&&($starting_square->rank>=1)&&($starting_square->rank<=8))&&
		(($ending_square->file>0)&&($ending_square->file<9))&&($board->board[$starting_square->rank][$starting_square->file]->group=='SOLDIER')){
			return null;// No Soldiers are allowed to penetrate the CASTLE  if not compromised
		}
		elseif(((($starting_square->file==0)||($starting_square->file==9))&&(($starting_square->rank==0)||($starting_square->rank==9))
		&&($board->board[$starting_square->rank][$starting_square->file]->group!='NOBLE'))){
			return null;// No-one can escape NoMans except RajRishi and Emperor
		}
		
		$xx=0; $yy=0;
		
		if(($type>=1)&&(abs($x_delta)<2) &&(abs($y_delta)<2))
		{
		}
		elseif ($type>=1){ //Horse
			if ($jumpflag=='1') {
				// straight jump
				// if Intermediate square contains a enemy piece
				if (($starting_square->rank)-($ending_square->rank)==2) {
					$yy=-1; //**echo ' xx_-1 ';
				}
				if (($ending_square->rank)-($starting_square->rank)==2) {
					$yy=1;//**echo ' xx_1 ';
				}

				if (($starting_square->file)-($ending_square->file)==2) {
					$xx=-1;//**echo ' yy_-1 ';
				}
				
				if (($ending_square->file)-($starting_square->file)==2) {
					$xx=1;//**echo ' yy_1 ';
				}
			
				if (abs($starting_square->rank-$ending_square->rank)==2) {
					$xx=0;//**echo ' yy ';
				} elseif (abs($starting_square->file-$ending_square->file)==2) {
					$yy=0; 	//**echo ' xx ';
				}
			}
			elseif ($jumpflag>='2') {
						//$diagonal jump
						if ((($starting_square->rank)-($ending_square->rank)==2)||(($starting_square->rank)-($ending_square->rank)==1)) {
							$yy=-1; //**echo ' xx_-1 ';
						}
						if ((($ending_square->rank)-($starting_square->rank)==2)||(($ending_square->rank)-($starting_square->rank)==1)) {
							$yy=1;//**echo ' xx_1 ';
						}
	
						if ((($starting_square->file)-($ending_square->file)==2)||(($starting_square->file)-($ending_square->file)==1)) {
							$xx=-1;//**echo ' yy_-1 ';
						}
					
						if ((($ending_square->file)-($starting_square->file)==2)||(($ending_square->file)-($starting_square->file)==1)) {
							$xx=1;//**echo ' yy_1 ';
						}
			}
			//**echo ' <br/> Night Move ';
			$intermediate_square = self::try_to_make_square_using_rank_and_file_num($starting_square->rank+$yy, $starting_square->file+$xx);

			if ( ! $intermediate_square ) {
				return null;
			}

			if($board->board[$intermediate_square->rank][$intermediate_square->file]){//if intermediate cell has data
				if (/*((($cankill==2) &&($type ==1) ) || ($type==2)) &&*/(abs($board->board[$intermediate_square->rank][$intermediate_square->file]->color - $color_to_move) ==0)) {//Same team-member
					if(($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='ROYAL')||
					($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='SEMIROYAL')||
					($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='OFFICER')||
					($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='SOLDIER')){
					}
				else
					{
						return null;//
					}
				}
			}

			if($board->board[$ending_square->rank][$ending_square->file]){//Ending has enemy but intermediate is blank
				if(!$board->board[$intermediate_square->rank][$intermediate_square->file]){//if intermediate cell is blank data
					if ((($cankill==2)||($cankill==0)) &&(abs($board->board[$ending_square->rank][$ending_square->file]->color - $color_to_move) ==1)) {//Enemy team-member
						return null;//Horse cannot kill without mixing
						}
					}
				if(($board->board[$intermediate_square->rank][$intermediate_square->file]) &&($cankill==0)){//if intermediate cell also has some data but
					if ((abs($board->board[$ending_square->rank][$ending_square->file]->color - $color_to_move) ==1)) {//Enemy team-member SPY ARTHSHASTRI
							return null;//SPY ARTHSHASTRI cant kill
						}
					}
				}

			if ((($intermediate_square->file==0 ) ||($intermediate_square->file==0 )) &&($intermediate_square->rank>=0 )&&($intermediate_square->rank<=9 )) {
				return null;
			}

			if ( $board->board[$intermediate_square->rank][$intermediate_square->file] ) { //Check Intermediate Block which data
				if ( $board->board[$intermediate_square->rank][$intermediate_square->file]->color - $color_to_move==0 ) {
					//**echo ' samecolor';
				}
				else
				if ( abs($board->board[$intermediate_square->rank][$intermediate_square->file]->color - $color_to_move) ==1) {
					//**echo ' diffcolor';
					return null;
				}
				else { /*echo ' blankcolor';*/ }
			}
			else
			if ( $board->board[$rank][$file] ) {//Check Ending block which has intermediate block but no data
				if ( $board->board[$rank][$file]->color - $color_to_move==0 ) {
				//**echo ' samecolor';
				return null; 
				}
				else
				if ( $board->board[$rank][$file]->color == $color_to_move ) {
					//**echo ' Ending square contains a friendly piece ';
					return null;
				}
				else
				if ( abs($board->board[$rank][$file]->color - $color_to_move) ==1) {
					//**echo ' diffcolor'; abs($board->board[$rank][$file]->color - $color_to_move)
					//check if no naarad pinned blocks present
					if(self::checkpinnedrefugees($color_to_move,$board,$starting_square,$ending_square)==true)
					return null;
				}
				else { /*echo ' blankcolor';*/ }
			}
		}

		if(($type>=1)&&($intermediate_square==null))
			return null;

		if(($type==2)&&($intermediate_square!=null)&&($board->board[$intermediate_square->rank][$intermediate_square->file]!=null)){ //Royals
			if ( $board->board[$intermediate_square->rank][$intermediate_square->file] ) { //Check Intermediate Block
				if ( $board->board[$intermediate_square->rank][$intermediate_square->file]->color - $color_to_move==0 ) {
					//echo ' samecolor';
				}
				else
				if ( abs($board->board[$intermediate_square->rank][$intermediate_square->file]->color - $color_to_move) ==1) {
					//echo ' diffcolor';
					return null;
				}
				else { }
			}
			else
			if ( $board->board[$rank][$file] ) {//Check Ending block

				if ( $board->board[$rank][$file]->color - $color_to_move==0 ) {
				//echo ' samecolor';
				return null; 
				}
				elseif ( $board->board[$rank][$file]->color == $color_to_move ) {
					return null;
				}
				elseif( abs($board->board[$rank][$file]->color - $color_to_move) ==1) {
					//check if no naarad pinned blocks present
					if(self::checkpinnedrefugees($color_to_move,$board,$starting_square,$ending_square)==true)
					return null;
				}
				else { }
			}
		}
		
		if(($type==1)&&($intermediate_square!=null)&&($board->board[$intermediate_square->rank][$intermediate_square->file]!=null)){
				if ((abs($board->board[$intermediate_square->rank][$intermediate_square->file]->color - $color_to_move) !=0)) {
					return null;
				}
		}

		// Ending square contains a friendly piece
		if ( $board->board[$rank][$file] ) {
			if ( $board->board[$rank][$file]->color - $color_to_move==0 ) {
				//echo ' samecolor';
				return null; 
				}
				elseif ( $board->board[$rank][$file]->color == $color_to_move ) {
					return null;
				}
				elseif( abs($board->board[$rank][$file]->color - $color_to_move) ==1) {
					//check if no naarad pinned blocks present
					if(self::checkpinnedrefugees($color_to_move,$board,$starting_square,$ending_square)==true)
					return null;
				}
		}

		//Check the last piece action on Trapped piece or Pushed Piece
		/*if(($intermediate_square!=null)&&($ending_square!=null) &&(($board->board[$intermediate_square->rank][$intermediate_square->file]==null)
		&& (($board->board[$ending_square->rank][$ending_square->file]!=null))	)){
				$settledpiece = clone $board->board[$starting_square->rank][$starting_square->file];
				$endingpiece =clone $board->board[$ending_square->rank][$ending_square->file];
				$settledpiece->square = $intermediate_square;
				self::check_virtual_trapped_piece($settledpiece,$endingpiece,$color_to_move, $board,'exclude');
			}
		*/	
		return $ending_square;
	}
		
	static function try_to_make_square_using_rank_and_file_num(int $rank, int $file): ?ChessSquare {
		if ( $rank >= 0 && $rank <=9  && $file >= 0 && $file <= 9 ) {
			return new ChessSquare($rank, $file);
		} else {
			return null;
		}
	}
	
	static function invert_color($color) {
		if ( $color == ChessPiece::WHITE ) {
			return ChessPiece::BLACK;
		} else {
			return ChessPiece::WHITE;
		}
	}
	
	static function get_squares_in_these_directions(
		ChessSquare $starting_square,
		array $directions_list,
		int $spaces
	): array {
		$list_of_squares = array();
		foreach ( $directions_list as $direction ) {
			// $spaces should be 1 for king, 1 or 2 for pawns, 7 for all other sliding pieces
			// 7 is the max # of squares you can slide on a chessboard
			
			$current_xy = self::DIRECTION_OFFSETS[$direction];
			$current_xy[0] =  $current_xy[0] * $spaces + $starting_square->rank;
			$current_xy[1] =  $current_xy[1] * $spaces + $starting_square->file;
			
			$square = self::try_to_make_square_using_rank_and_file_num($current_xy[0], $current_xy[1]);
			
			if ( $square ) {
				$list_of_squares[] = $square;
			}
		}
		
		return $list_of_squares;
	}
	
	static function square_is_attacked(
		$enemy_color,
		ChessBoard $board,
		ChessSquare $square_to_check
	): bool {
		$friendly_color = self::invert_color($enemy_color);
		
		if ( self::square_threatened_by_sliding_pieces($board, $square_to_check, $friendly_color) ) {
			return TRUE;
		}
		
		if ( self::square_threatened_by_jumping_pieces($board, $square_to_check, $friendly_color) ) {
			return TRUE;
		}
				
		return FALSE;
	}

	static function square_threatened_by_sliding_pieces(
		ChessBoard $board,
		ChessSquare $square_to_check,
		$friendly_color
	): bool {
		foreach ( self::ALL_DIRECTIONS as $direction ) {
			for ( $i = 1; $i <= self::MAX_SLIDING_DISTANCE; $i++ ) {
				$current_xy = self::DIRECTION_OFFSETS[$direction];
				$rank = $square_to_check->rank + $current_xy[0] * $i;
				$file = $square_to_check->file + $current_xy[1] * $i;
				
				if ( ! self::square_is_on_board($rank, $file) ) {
					// Square is off the board. Stop sliding in this direction.
					break;
				}
				
				$piece = self::get_piece($rank, $file, $board);
				
				if ( ! $piece ) {
					// Square is empty. Continue sliding in this direction.
					continue;
				}
				
				if ( $piece->color == $friendly_color ) {
					// Sliding is blocked by a friendly piece. Stop sliding in this direction.
					break;
				}
				
				// If this code is reached, piece must be an enemy. No need to double check.				
				// I could probably structure this to be faster, but I did it this way for readability.
				if (( $piece->type == ChessPiece::KING )||( $piece->type == ChessPiece::INVERTEDKING )) {
					if ( $i == 1 ) {
						return TRUE;
					}
				} elseif ( $piece->type == ChessPiece::GENERAL ) {
					if ( $direction == self::NORTH || $direction == self::SOUTH || $direction == self::EAST || $direction == self::WEST || $direction == self::NORTHEAST || $direction == self::NORTHWEST || $direction == self::SOUTHEAST || $direction == self::SOUTHWEST ) {
						return TRUE;
					}
				} elseif ( $piece->type == ChessPiece::ROOK ) {
					if ( $direction == self::NORTH || $direction == self::SOUTH || $direction == self::EAST || $direction == self::WEST ) {
						return TRUE;
					}
				} elseif (( $piece->type == ChessPiece::BISHOP )&&($file==0)) {
					if ( $direction == self::NORTHEAST || $direction == self::NORTHWEST || $direction == self::SOUTHEAST || $direction == self::SOUTHWEST ) {
						return TRUE;
					}
				} elseif ( $piece->type == ChessPiece::PAWN ) {
					if ( $i == 1 ) {
						if ( $piece->color == ChessPiece::BLACK ) {
						if ( $direction == self::NORTH|| $direction == self::NORTHEAST || $direction == self::NORTHWEST ) {
								return TRUE;
							}
							if ( $direction == self::NORTH) {
								return TRUE;
							}
						} elseif ( $piece->color == ChessPiece::WHITE ) {
							if ($direction == self::SOUTH|| $direction == self::SOUTHEAST || $direction == self::SOUTHWEST ) {
								return TRUE;
							}
							if ( $direction == self::SOUTH) {
								return TRUE;
							}
						}
					}
				}
				
				// If this code has been reached, then there is an enemy piece on this square
				// but it is not threatening the test square. Stop sliding in this direction.
				break;
			}
		}
		
		return FALSE;
	}
	
	//Pending http://localhost/pc/?move=1c2ia2c1%2Fcr1esge1rc%2Fcpppppp2c%2F11n1%2F181%2F11N4P1%2F13S1%2FCPPPPPP1P1%2FCR1E1GE1RC%2F1C2AI2C1+b+-+-+1+10
	//Black Queen is erasing data
	static function square_threatened_by_jumping_pieces(
		ChessBoard $board,
		ChessSquare $square_to_check,
		$friendly_color
	): bool {
		foreach ( self::KNIGHT_DIRECTIONS as $oclock ) {
			$current_xy = self::OCLOCK_OFFSETS[$oclock];
			$rank = $square_to_check->rank + $current_xy[0];//Row 3+
			$file = $square_to_check->file + $current_xy[1];
			////**echo  '<br> Night = X '.$current_xy[0].'  Y = '.$current_xy[1].'  Calculated Rank '.$rank.'  Calculated File '.$file ;

			if ( ! self::square_is_on_board($rank, $file) ) {
				// Square is off the board. On to the next test square.
				continue; // Check Next Square
			}
			
			$piece = self::get_piece($rank, $file, $board);
			////**echo ' $piece->type = '.$piece->type;
			if ( ! $piece ) {
				// Square is empty. On to the next test square.
				$mixingsquare='';
				continue;
			}
			
			if ( $piece->color == $friendly_color ) {
				// Square is occupied by a friendly piece. On to the next test square.
				continue;
			}
			
			if (( $piece->type == ChessPiece::KNIGHT ) ||( $piece->type == ChessPiece::GENERAL )) {  //If target piece is enemy and not threatening the opponent under R. Create a function.				
				return TRUE;
			}
			
			// If this code has been reached, then there is an enemy piece on this square
			// but it is not threatening the test square. On to the next square.
			// continue;
			//**echo ' Rank '.$square_to_check->rank.' File '.$square_to_check->file.'  Color '.$friendly_color.' Final Bad ='.$square_to_check->rank.' '.$square_to_check->file.'  '.$friendly_color.'<br/> *** Next Square to be checked <br/>';
		}
		//**echo '<br/>  Rank '.$square_to_check->rank.' File '.$square_to_check->file.'  Color '.$friendly_color.' Final Bad ='.$square_to_check->rank.' '.$square_to_check->file.'  '.$friendly_color;
		return FALSE;
	}	

	static function square_is_on_board(int $rank, int $file): bool {
		if ( $rank >= 0 && $rank <= 9 && $file >= 0 && $file <= 9 ) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	static function get_piece(int $rank, int $file, ChessBoard $board): ?ChessPiece {
		if ( $board->board[$rank][$file] ) {
			return $board->board[$rank][$file];
		} else {
			return NULL;
		}
	}
}
