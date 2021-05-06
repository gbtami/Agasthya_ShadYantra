<?php

class ChessRulebook {
	const NORTH = 1;
	const SOUTH = 2;
	const EAST = 3;
	const WEST = 4;
	const NORTHWEST = 5;
	const NORTHEAST = 6;
	const SOUTHWEST = 7;
	const SOUTHEAST = 8;
	
	const ALL_DIRECTIONS = array(
		self::NORTH,
		self::SOUTH,
		self::EAST,
		self::WEST,
		self::NORTHWEST,
		self::NORTHEAST,
		self::SOUTHWEST,
		self::SOUTHEAST
	);
	
	// Coordinates are in (rank, file) / (y, x) format
	const OCLOCK_OFFSETS = array(
		1 => array(2,1),		
		2 => array(1,2),
		3 => array(2,0),		
		4 => array(-1,2),
		5 => array(-2,1),
		6 => array(-2,0),
		7 => array(-2,-1),
		8 => array(-1,-2),
		9 => array(0,-2),		
		10 => array(1,-2),
		11 => array(2,-1),
		12 => array(0,2),
		13 => array(2,2),
		14 => array(2,-2),
		15 => array(-2,2),
		16 => array(-2,-2)
	);

	const DIRECTION_OFFSETS = array(
		self::NORTH => array(1,0),
		self::SOUTH => array(-1,0),
		self::EAST => array(0,1),
		self::WEST => array(0,-1),
		self::NORTHEAST => array(1,1),
		self::NORTHWEST => array(1,-1),
		self::SOUTHEAST => array(-1,1),
		self::SOUTHWEST => array(-1,-1)
	);
	
	const BISHOP_DIRECTIONS = array(
		self::NORTHWEST,
		self::NORTHEAST,
		self::SOUTHWEST,
		self::SOUTHEAST
		//self::NORTH,
		//self::SOUTH,
		//self::EAST,
		//self::WEST	
	);


	const RETREATING_BISHOP_DIRECTIONS_1 = array(
		self::SOUTHWEST,
		self::SOUTHEAST
		//self::EAST,
		//self::WEST
	);

	const RETREATING_BISHOP_DIRECTIONS_2 = array(
		self::NORTHWEST,
		self::NORTHEAST
		//self::EAST,
		//self::WEST		
	);

	const ROOK_DIRECTIONS = array(
		self::NORTH,
		self::SOUTH,
		self::EAST,
		self::WEST
	);

	const RETREATING_ROOK_DIRECTIONS_1 = array(
		self::SOUTH,
		self::EAST,
		self::WEST
	);
	
	const RETREATING_ROOK_DIRECTIONS_2 = array(
		self::NORTH,
		self::EAST,
		self::WEST
	);

	const GENERAL_DIRECTIONS = array(
		self::NORTH,
		self::SOUTH,
		self::EAST,
		self::WEST,
		self::NORTHWEST,
		self::NORTHEAST,
		self::SOUTHWEST,
		self::SOUTHEAST
	);

	const RETREATING_GENERAL_DIRECTIONS_1 = array(
		self::SOUTH,
		self::EAST,
		self::WEST,
		self::SOUTHWEST,
		self::SOUTHEAST
	);
	
	const RETREATING_GENERAL_DIRECTIONS_2 = array(
		self::NORTH,
		self::EAST,
		self::WEST,
		self::NORTHWEST,
		self::NORTHEAST
	);

	const KING_DIRECTIONS = array(
		self::NORTH,
		self::SOUTH,
		self::EAST,
		self::WEST,
		self::NORTHWEST,
		self::NORTHEAST,
		self::SOUTHWEST,
		self::SOUTHEAST
	);


	const KNIGHT_DIRECTIONS = array(1, 2, 3,4, 5, 6,7, 8, 9,10, 11,12,13,14,15,16);
	const BLACK_PAWN_CAPTURE_DIRECTIONS = array(self::SOUTH,self::SOUTHEAST, self::SOUTHWEST);
	const BLACK_PAWN_MOVEMENT_DIRECTIONS = array(self::SOUTH,self::SOUTHEAST, self::SOUTHWEST);
	const WHITE_PAWN_CAPTURE_DIRECTIONS = array(self::NORTH,self::NORTHEAST, self::NORTHWEST);
	const WHITE_PAWN_MOVEMENT_DIRECTIONS = array(self::NORTH,self::NORTHEAST, self::NORTHWEST);

	const RETREATING_KNIGHT_DIRECTIONS_1 = array(4, 5, 6,  7,  8,  9, 12,15,16);
	const RETREATING_KNIGHT_DIRECTIONS_2 = array(1, 2, 3, 9, 10, 11, 12,13,14);
	const RETREATING_KNIGHT_DIRECTIONS_11 = array(5, 6,  7,15,16);
	const RETREATING_KNIGHT_DIRECTIONS_22 = array(1, 3, 11,13,14);	

	const RETREATING_BLACK_PAWN_CAPTURE_DIRECTIONS =  array(self::NORTH,self::NORTHEAST, self::NORTHWEST);
	const RETREATING_BLACK_PAWN_MOVEMENT_DIRECTIONS = array(self::NORTH,self::NORTHEAST, self::NORTHWEST);
	const RETREATING_WHITE_PAWN_CAPTURE_DIRECTIONS = array(self::SOUTH,self::SOUTHEAST, self::SOUTHWEST);
	const RETREATING_WHITE_PAWN_MOVEMENT_DIRECTIONS = array(self::SOUTH,self::SOUTHEAST, self::SOUTHWEST);
		
	const PROMOTION_PIECES = array(
		ChessPiece::GENERAL,
		ChessPiece::ROOK,
		ChessPiece::BISHOP,
		ChessPiece::KNIGHT
	);
	
	const MAX_SLIDING_DISTANCE = 4;
	const MAX_TOUCH = 1;
	static function get_legal_moves_list(
		$color_to_move, // Color changes when we call recursively. Can't rely on $board for color.
		ChessBoard $board, // ChessBoard, not ChessBoard->board. We need the entire board in a couple of methods.
		bool $need_perfect_move_list = TRUE,
		bool $store_board_in_moves = TRUE,
		bool $need_perfect_notation = TRUE
	): array {
		//**echo '<li> ChessRuleBook.php #1 function get_legal_moves_list called </li>';	

		$pieces_to_check = self::get_all_pieces_by_color($color_to_move, $board);
		
		$moves = array();
		$king = null;
		
		// TODO: Iterate through all squares on chessboard, not all pieces. Then I won't need to
		// store each piece's ChessSquare, and I can get rid of that class completely.

				//null means King is Active now
		$board->get_royals_on_Scepters_TruceControl(1);
		$board->get_royals_on_warZone_for_full_move(1);
		$board->get_royals_on_castle_for_full_move(1);
		$board->get_general_on_warZone_for_full_move(1);
		$board->get_general_on_castle_for_full_move(1);
		$board->get_generals_on_truce(1);

		//$board->get_royals_on_Scepters(2);

		$get_Killing_Allowed=0;
		$get_FullMover=FALSE;//Check if killing allowed
		$get_CASTLEMover=-1;
		$selfbrokencastle=false;
		$foebrokencastle=false;
		if(($board->Winner=='-1')||($board->Winner=='0')){
        	foreach ($pieces_to_check as $piece) {
				$get_CASTLEMover=-1;
				/*if(!$board->get_royals_on_warZone($piece->color)){ 
					$get_FullMover=FALSE;}
				else {$get_FullMover=TRUE;}
				*/
				
				//null means King is Active now
				/*if($board->get_royals_on_Scepters($piece->color)==FALSE){ 
					$get_Killing_Allowed=1;}
				else {$get_Killing_Allowed=0;}
				*/
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

				if(($piece->group=='OFFICER')||($piece->group=='OFFICER')){
					if($piece->color==1){
						if(($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0)&&($piece->square->file<9)&&($board->whitecanfullmove==1))
							{
							$get_FullMover=TRUE;
							}
						elseif(($piece->square->rank==0)&&($piece->square->file>0)&&($piece->square->file<9))
							{
							$get_FullMover=TRUE;
							}
						elseif(($piece->square->rank==9)&&($piece->square->file>0)&&($piece->square->file<9)&&($board->whitecanfullmoveinfoecastle==1))
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
						if(($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0)&&($piece->square->file<9)&&($board->blackcanfullmove==1))
							{
								$get_FullMover=TRUE;
							}
						elseif(($piece->square->rank==9)&&($piece->square->file>0)&&($piece->square->file<9))
							{
								$get_FullMover=TRUE;
							}
						elseif(($piece->square->rank==0)&&($piece->square->file>0)&&($piece->square->file<9)&&($board->blackcanfullmoveinfoecastle==1))
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

				$selfbrokencastle= self::get_compromised_castle( /**/
					$piece,
					$color_to_move,
					$color_to_move, //SelfCASTLE 
					$board
				);

				$foebrokencastle= self::get_compromised_castle( /**/
					$piece,					
					$color_to_move,
					(3-$color_to_move), //FOE CASTLE
					$board
				);

				$selfbrokencastle;
				$foebrokencastle;
				$jumpstyle='3';//1 = Straight, 2 = diagonal , 3= both

				if ($piece->type == ChessPiece::PAWN) {
                	if ($piece->color == ChessPiece::WHITE) {
                    	$moves = self::add_slide_moves_to_moves_list(self::WHITE_PAWN_MOVEMENT_DIRECTIONS, 1, $moves, $piece, $color_to_move, $board, $store_board_in_moves,1,$selfbrokencastle,$foebrokencastle);
						if($get_Killing_Allowed==1){
                    		$moves = self::add_capture_moves_to_moves_list(self::WHITE_PAWN_CAPTURE_DIRECTIONS, $moves, $piece, $color_to_move, $board, $store_board_in_moves,1,$selfbrokencastle,$foebrokencastle);
						}
                	} elseif ($piece->color == ChessPiece::BLACK) {
                    	$moves = self::add_slide_moves_to_moves_list(self::BLACK_PAWN_MOVEMENT_DIRECTIONS, 1, $moves, $piece, $color_to_move, $board, $store_board_in_moves,1,$selfbrokencastle,$foebrokencastle);
						if($get_Killing_Allowed==1){
                    	$moves = self::add_capture_moves_to_moves_list(self::BLACK_PAWN_CAPTURE_DIRECTIONS, $moves, $piece, $color_to_move, $board, $store_board_in_moves,1,$selfbrokencastle,$foebrokencastle);
						}
                	}
            	} elseif ($piece->type == ChessPiece::KNIGHT) {
					if($get_Killing_Allowed==1) 
						$get_Killing_Allowed=2;
						if(($get_CASTLEMover==1) &&	($get_Killing_Allowed==2)){	$get_Killing_Allowed=1;} //knight does not need to mixup in his own castle.

                	$moves = self::add_jump_and_jumpcapture_moves_to_moves_list(1,$jumpstyle,self::KNIGHT_DIRECTIONS, $moves, $piece, $color_to_move, $board, $store_board_in_moves,$get_Killing_Allowed,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover);
                	$moves = self::add_slide_and_slidecapture_moves_to_moves_list(self::BISHOP_DIRECTIONS, 1, $moves, $piece, $color_to_move, $board, $store_board_in_moves,0,FALSE,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover);

            	} elseif ($piece->type == ChessPiece::BISHOP) {
					if($board->gametype==1){ //Classical Agastya
						$moves = self::add_slide_and_slidecapture_moves_to_moves_list(self::BISHOP_DIRECTIONS, 2, $moves, $piece, $color_to_move, $board, $store_board_in_moves,$get_Killing_Allowed,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover);
						$moves = self::add_slide_and_slidecapture_moves_to_moves_list(self::ROOK_DIRECTIONS, 2, $moves, $piece, $color_to_move, $board, $store_board_in_moves,$get_Killing_Allowed,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover);
					}
					elseif($board->gametype==2){ //Kautilya
                		$moves = self::add_slide_and_slidecapture_moves_to_moves_list(self::BISHOP_DIRECTIONS, 2, $moves, $piece, $color_to_move, $board, $store_board_in_moves,$get_Killing_Allowed,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover);
					}
            	} elseif ($piece->type == ChessPiece::ROOK) {
                	$moves = self::add_slide_and_slidecapture_moves_to_moves_list(self::ROOK_DIRECTIONS, self::MAX_SLIDING_DISTANCE, $moves, $piece, $color_to_move, $board, $store_board_in_moves,$get_Killing_Allowed,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover);
					if($board->gametype==1){
                		$moves = self::add_slide_and_slidecapture_moves_to_moves_list(self::BISHOP_DIRECTIONS,  self::MAX_SLIDING_DISTANCE, $moves, $piece, $color_to_move, $board, $store_board_in_moves,$get_Killing_Allowed,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover);
						$moves = self::add_slide_and_slidecapture_moves_to_moves_list(self::ROOK_DIRECTIONS,  self::MAX_SLIDING_DISTANCE, $moves, $piece, $color_to_move, $board, $store_board_in_moves,$get_Killing_Allowed,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover);
					}
					elseif($board->gametype==2){
						$moves = self::add_slide_and_slidecapture_moves_to_moves_list(self::ROOK_DIRECTIONS,  self::MAX_SLIDING_DISTANCE, $moves, $piece, $color_to_move, $board, $store_board_in_moves,$get_Killing_Allowed,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover);
					}            	
				} elseif ($piece->type == ChessPiece::GENERAL) {
                	if($get_FullMover==TRUE)
						$moves= self::add_jump_and_jumpcapture_moves_to_moves_list(1,$jumpstyle,self::KNIGHT_DIRECTIONS, $moves, $piece, $color_to_move, $board, $store_board_in_moves,$get_Killing_Allowed,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover);	
               		$moves = self::add_slide_and_slidecapture_moves_to_moves_list(self::GENERAL_DIRECTIONS, self::MAX_SLIDING_DISTANCE, $moves, $piece, $color_to_move, $board, $store_board_in_moves,$get_Killing_Allowed,$get_FullMover,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover);
            	} elseif (($piece->type == ChessPiece::KING)||($piece->type == ChessPiece::ANGRYKING)||
				($piece->type == ChessPiece::ANGRYINVERTEDKING)||($piece->type == ChessPiece::INVERTEDKING)) {
                	$moves = self::add_jump_and_jumpcapture_moves_to_moves_list(2,$jumpstyle,self::KNIGHT_DIRECTIONS, $moves, $piece, $color_to_move, $board, $store_board_in_moves,1,TRUE,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover);
                	$moves = self::add_slide_and_slidecapture_moves_to_moves_list(self::KING_DIRECTIONS, 1, $moves, $piece, $color_to_move, $board, $store_board_in_moves,1,TRUE,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover);            	
					// Set $king here so castling function can use it later.
                	$king = $piece;
            	} elseif (($piece->type == ChessPiece::ARTHSHASTRI)||($piece->type == ChessPiece::ANGRYARTHSHASTRI)) {
                	$moves = self::add_jump_and_jumpcapture_moves_to_moves_list(2,$jumpstyle,self::KNIGHT_DIRECTIONS, $moves, $piece, $color_to_move, $board, $store_board_in_moves,0,TRUE,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover);
                	$moves = self::add_slide_and_slidecapture_moves_to_moves_list(self::KING_DIRECTIONS, 1, $moves, $piece, $color_to_move, $board, $store_board_in_moves,0,TRUE,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover);
                	// Set $king here so castling function can use it later.
                	$ARTHSHASTRI = $piece;
            	} elseif ($piece->type == ChessPiece::SPY) {
                	$moves = self::add_jump_and_jumpcapture_moves_to_moves_list(2,$jumpstyle,self::KNIGHT_DIRECTIONS, $moves, $piece, $color_to_move, $board, $store_board_in_moves,0,TRUE,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover);
                	$moves = self::add_slide_and_slidecapture_moves_to_moves_list(self::KING_DIRECTIONS, 1, $moves, $piece, $color_to_move, $board, $store_board_in_moves,0,TRUE,$selfbrokencastle,$foebrokencastle,$get_CASTLEMover);
                	// Set $king here so castling function can use it later.
                	$SPY = $piece;
            	} elseif ($piece->type == ChessPiece::GODMAN) {
                	//$moves = self::add_slide_and_slidecapture_moves_to_moves_list(self::KING_DIRECTIONS, 1, $moves, $piece, $color_to_move, $board, $store_board_in_moves,0,TRUE);
                	// Set $king here so castling function can use it later.
                	$GODMAN = $piece;
            	}
        	}
		}
		
		if ( $need_perfect_move_list ) {
            if ($king!=null) {
                //$moves = self::eliminate_king_in_check_moves($king, $moves, $color_to_move);
            }
			else if($king==null){
				$moves = null;
				$moves = array();
				return $moves;

			}
			$ttttttttttttttttt=1;
			//$moves = self::add_warring_moves_to_moves_list($moves, $king, $board);
			//$moves = self::add_hostile_moves_to_moves_list($moves, $king, $board);
			//$moves = self::add_sceptremixed_moves_to_moves_list($moves, $king, $board);

		}
		
		if ( $need_perfect_notation ) {
			self::clarify_ambiguous_pieces($moves, $color_to_move, $board);
			
			//self::mark_checks_and_checkmates($moves, $color_to_move);
			
			$moves = self::sort_moves_alphabetically($moves);
		}
		
		return $moves;
	}
	
	static function sort_moves_alphabetically(array $moves): array {
				//**echo '<li> ChessRuleBook.php #2 function sort_moves_alphabetically called </li>';	
		
		if ( ! $moves ) {
			return $moves;
		}
		foreach ( $moves as $move ) {
			$temp_array[$move->get_notation()] = $move;
			/*	$tnotation=null; $tnotation=$move->get_notation();
			if($tnotation=="Na2a2=R"){notation(); }
			$temp_array[$tnotation] = $move;*/
		}
		
		ksort($temp_array);
		
		return $temp_array;
	}
	
	// Return format is the FIRST DUPLICATE. The second duplicate is deleted.
	// It keeps the original key intact.
	static function get_duplicates(array $array): array {
				//**echo '<li> ChessRuleBook.php #2 function get_duplicates called </li>';	
		
		return array_unique(array_diff_assoc($array, array_unique($array)));
	}
	
	// Returns void. Just modifies the ChessMoves in the $moves array by reference.
	static function clarify_ambiguous_pieces(array $moves, $color_to_move, ChessBoard $board): void {
			//**echo '<li> ChessRuleBook.php #3 function clarify_ambiguous_pieces called </li>';	
		
		// For GENERALs, rooks, bishops, and knights
		foreach ( self::PROMOTION_PIECES as $type ) {
			// Create list of ending squares that this type of piece can move to
			$ending_squares = array();
			foreach ( $moves as $move ) {//if(ending_squares[])==b5
				if ( $move->piece_type == $type ) {
					$ending_squares[] = $move->ending_square->get_alphanumeric();
				}
			}
			
			// Isolate the duplicate squares
			$duplicates = self::get_duplicates($ending_squares);
			
			foreach ( $moves as $move ) {
				if ( $move->piece_type != $type ) {
					continue;
				}
				
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
			$a=1;
		}
	}



	static function square_surrounded_by_officers(
		ChessSquare $starting_square,
		int $y_delta,int $x_delta,
		$color_to_move,
		ChessBoard $board
	): ?ChessSquare {
        //$rank = $starting_square->rank + $x_delta;
        //$file = $starting_square->file + $y_delta;

		$rank = $starting_square->rank + $y_delta;
		$file = $starting_square->file + $x_delta;

        $ending_square = self::try_to_make_square_using_rank_and_file_num($rank, $file);


		if ($ending_square) {
			if(($starting_square->file==0)||($starting_square->file==9)){
				if(($starting_square->rank>=1)&&($starting_square->rank<=8)&&($ending_square->file!=$starting_square->file))
				{//Non-truce zone endpoint but Royal is in Truce-Zone. return
				return null;
				}
			}
		}

        if (!$ending_square) {
            return null;
        } else {
            if ((($starting_square->rank>=1)&&($starting_square->rank<=8) && ($starting_square->file>=1) && ($starting_square->file<=8)&&
			($ending_square->rank>=1)&&($ending_square->rank<=8) && ($ending_square->file>=1) && ($ending_square->file<=8))) //Check within War Zone
			{
                if ($board->board[$rank][$file]) {
                    if (($board->board[$rank][$file]->color == $color_to_move) && ($board->board[$rank][$file]->group=='OFFICER'))
					{
						 //*echo ' Ending square contains a friendly Officer ';*/
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
                    if (($board->board[$rank][$file]->color == $color_to_move) && ($board->board[$rank][$file]->group=='OFFICER'))
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

	static function add_officer_neighbours_moves_to_moves_list( /**/
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
					return TRUE;
				}
            }
	if(!$ending_square)
	{ return FALSE;
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
		bool $sameplace
	): ?ChessSquare {
		$sameplace;

        //$rank = $starting_square->rank + $y_delta;
        //$file = $starting_square->file + $x_delta;

		$rank = $starting_square->rank + $y_delta;
		$file = $starting_square->file + $x_delta;

        $ending_square = self::try_to_make_square_using_rank_and_file_num($rank, $file);

		if (($sameplace==TRUE)&&($ending_square)){
				if(($actual_square->rank==$ending_square->rank)&& ($actual_square->file==$ending_square->file)){
					return null;
			}
		}

		if ($ending_square) {
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
					$type=0;

					$ending_square = self::royal_square_surrounded_by_royals(
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


	static function add_royal_neighbours_moves_to_moves_list( /**/
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
                $ending_square = self::royal_square_surrounded_by_royals(
					$piece->square,
                    $piece->square,
                    $current_xy[0],
                    $current_xy[1],
                    $color_to_move,
                    $board,
					FALSE
                );
				if(!$ending_square)
				{ 					
					continue;				
				}
				if($ending_square!=null)
				{
					if(($piece->group=='OFFICER')&&((($piece->type!=ChessPiece::GENERAL)&&($board->gametype==1))||($board->gametype==2))&&(($ending_square->file==0)||($ending_square->file==9)))
					{
						return false;
					}
					else					
						return TRUE;
				}
            }
	if(!$ending_square)
	{ return FALSE;
	}
	else				
		return TRUE;
	}


	static function get_LastGeneralRow(ChessPiece $piece,	$color_to_move,	ChessBoard $board,	int $mtype	): int 
	{

	$ksquare=$board->get_king_square($color_to_move);
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
	$ksquare=$board->get_king_square($color_to_move);
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
		return 9	;
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
		return 0	;
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
			$ksquare=$board->get_king_square($color_to_move);//
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
		bool $get_FullMover,
		bool $selfbrokencastle,
		bool $foebrokencastle,
		int $get_CASTLEMover
	): array {

        $boolslide=TRUE; $royalp=FALSE;  $candemote=FALSE; $capture = FALSE; $dem=0; $tempDirection=null; $mtype=1;//slide //2 jump 
		$lastaccessiblerow=-1;
		$generalaccessiblerow=-1;
		//Create the Array of Move Types.. This will help in deciding the two types of moves in retrating.. Moving back and to the top border
		$tempDirection=self::get_Retreating_ARMY_directions(
			$piece,
			$color_to_move,
			$board,
			$mtype
		);

		//Retreat or Truce Zone has Either King or General. Check this possibility.
		if (isset($tempDirection) && is_array($tempDirection)){
			$abcd=1;
			if(!empty($tempDirection)) //King is sitting on RestZone within Truce
				{
					$directions_list=$tempDirection;				
				}
				$lastaccessiblerow=self::get_LastKingRow(
					$piece,
					$color_to_move,
					$board,
					$mtype
					);
		}

		$tempDirection=null;

		if(($piece->square->rank==8)&&($piece->square->file==0)){
			$piece->square->rank;
		}
            $royalp=self::add_royal_neighbours_moves_to_moves_list( /**/
                self::KING_DIRECTIONS,
                $piece,
                $color_to_move,
                $board
            );


			if(($get_CASTLEMover==1)&&($selfbrokencastle==FALSE))//&&(($board->$blackcanfullmoveinowncastle == 1)||($board->$whitecanfullmoveinowncastle == 1)))
			{
				$royalp=true;
				$booljump=true;
			}				

			//Single Royal cannot move out of any zone.
			
			if(($royalp==false)&&(strpos($piece->group,"ROYAL")!==FALSE)&&($piece->square->rank<=9)&&($piece->square->rank>=0)&&(($piece->square->file==0)&&($piece->square->file==9))){
				return $moves;
			}			

			//self-promotion to be added later for semi-royals

			if(($piece->group=="OFFICER")&&($royalp==true)&&($piece->square->file>0)&&($piece->square->file<9)){ // Check of self promotion can happen but not in TZ
				if($royalp==TRUE) {$dem=-1;}
				else {$dem=0;}
				//$ending_square->file=$piece->square->file;
				//$ending_square->rank=$piece->square->rank;

				$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,$piece->type-1);
		
				if($canpromote==TRUE){// then update the parity with new demoted values
				//$piece->type=$piece->type+1;
					//Force Promotion to add in movelist	
					$new_move1 = new ChessMove(
						$piece->square,
						$piece->square,
						0,					
						$piece->color,
						$piece->type,
						$capture,
						$board,
						$store_board_in_moves,
						TRUE
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
					$piece->square,
					$piece->square,
					0,					
					$piece->color,
					$piece->type,
					$capture,
					$board,
					$store_board_in_moves,
					TRUE
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
					$piece->square,
					$piece->square,
					0,					
					$piece->color,
					$piece->type,
					$capture,
					$board,
					$store_board_in_moves,
					TRUE
					);

			$move2 = clone $new_move;
			$moves[] = $move2;
			$canpromote=false;	
			$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,12);

			if(($canpromote==TRUE)&&(($color_to_move==1)&&($piece->square->rank==9)||($color_to_move==2)&&($piece->square->rank==0))){// then update the parity with new demoted values
				$move2 = clone $new_move;				
				$move2-> set_promotion_piece(12);
				$moves[] = $move2;
				}
	
			$canpromote=false;	
			$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,11);

			if(($canpromote==TRUE)&&((($color_to_move==1)&&($piece->square->rank==9)||($color_to_move==2)&&($piece->square->rank==0))  )){// then update the parity with new demoted values
				$move2 = clone $new_move;
				$move2-> set_promotion_piece(11);
				$moves[] = $move2;
				}
			}
		else
		if(($piece->group=="ROYAL") &&($piece->type == ChessPiece::ANGRYKING) &&
		(($piece->square->file<4)||($piece->square->file>5))&&($piece->square->rank>=0)&&($piece->square->rank<=9)
		){ // give the invertion option in scepter castle meaning lost the game

				$new_move = new ChessMove(
					$piece->square,
					$piece->square,
					0,					
					$piece->color,
					$piece->type,
					$capture,
					$board,
					$store_board_in_moves,
					TRUE
				);

					$move2 = clone $new_move;
					if(( $piece->type != ChessPiece::ANGRYINVERTEDKING)){												
						$move2-> set_promotion_piece(4);
					}
					$moves[] = $move2;
					//return $moves; Dont Return but add more moves
			}
		else
		if(($piece->group=="ROYAL") &&($piece->type == ChessPiece::ANGRYKING) &&
			(($piece->square->file==0)||($piece->square->file==9))&&($piece->square->rank>=0)&&($piece->square->rank<=9)
			){ // give the invertion option in scepter castle meaning lost the game

					$new_move = new ChessMove(
						$piece->square,
						$piece->square,
						0,					
						$piece->color,
						$piece->type,
						$capture,
						$board,
						$store_board_in_moves,
						TRUE
					);
	
						$move2 = clone $new_move;
						if(( $piece->type != ChessPiece::ANGRYINVERTEDKING)){												
							$move2-> set_promotion_piece(4);
						}
						$moves[] = $move2;
						//return $moves; Dont Return but add more moves
				}
		else
		if(($piece->group=="ROYAL") &&(($piece->type == ChessPiece::KING)||($piece->type == ChessPiece::ANGRYKING)||
			($piece->type == ChessPiece::ANGRYINVERTEDKING)||($piece->type == ChessPiece::INVERTEDKING)) &&
			(($piece->square->rank==0)&&($piece->square->file==4)&&($piece->color==1)||($piece->square->rank==9)&&($piece->square->file==5)&&($piece->color==2))
			){ // give the invertion option in scepter castle meaning lost the game

					$new_move = new ChessMove(
						$piece->square,
						$piece->square,
						0,					
						$piece->color,
						$piece->type,
						$capture,
						$board,
						$store_board_in_moves,
						TRUE
					);
	
						$move2 = clone $new_move;
							$move2-> set_promotion_piece(2);
						$moves[] = $move2;
						//return $moves; Dont Return but add more moves
				}
		else			
		if(($piece->group=="ROYAL") &&( $piece->type == ChessPiece::ANGRYINVERTEDKING)&&
			(($piece->square->rank==0)&&($piece->square->file!=4)&&($piece->color==1)||($piece->square->rank==9)&&($piece->square->file!=5)&&($piece->color==2))
			){ // give the option to become normal in castle
			
					$new_move = new ChessMove(
						$piece->square,
						$piece->square,
						0,					
						$piece->color,
						$piece->type,
						$capture,
						$board,
						$store_board_in_moves,
						TRUE
					);
	
						$move2 = clone $new_move;
							$move2-> set_promotion_piece(3);
						$moves[] = $move2;
						//return $moves; Dont Return but add more moves
				}
			else
		if(($piece->group=="ROYAL") &&( $piece->type == ChessPiece::ANGRYKING)&&
		((($piece->square->rank==0)&&($piece->square->file!=4)&&($piece->color==1))||(($piece->square->rank==9)&&($piece->square->file!=5)&&($piece->color==2)))
			){ //give the option to become inverted in castle
			
					$new_move = new ChessMove(
						$piece->square,
						$piece->square,
						0,					
						$piece->color,
						$piece->type,
						$capture,
						$board,
						$store_board_in_moves,
						TRUE
					);
	
						$move2 = clone $new_move;
						if(( $piece->type != ChessPiece::ANGRYINVERTEDKING)){												
							$move2-> set_promotion_piece(4);
						}						
						$moves[] = $move2;
						//return $moves; Dont Return but add more moves
				}
			/*	else			
			if(($piece->group=="ROYAL") &&( $piece->type == ChessPiece::ANGRYKING)&&
			(($piece->square->rank==0)&&($piece->square->file!=4)&&($piece->color==1)||($piece->square->rank==9)&&($piece->square->file!=5)&&($piece->color==2))
			){ //give the option to become inverted in castle
			
					$new_move = new ChessMove(
						$piece->square,
						$piece->square,
						0,					
						$piece->color,
						$piece->type,
						$capture,
						$board,
						$store_board_in_moves,
						TRUE
					);
	
						$move2 = clone $new_move;
							$move2-> set_promotion_piece(4);
						$moves[] = $move2;
						//return $moves; Dont Return but add more moves
				}*/
			else			
			if(($piece->group=="ROYAL") &&( $piece->type == ChessPiece::ANGRYKING)&&
			(($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0)&&($piece->square->file<9))
			){ //add the war zone inversion mode
			
					$new_move = new ChessMove(
						$piece->square,
						$piece->square,
						0,					
						$piece->color,
						$piece->type,
						$capture,
						$board,
						$store_board_in_moves,
						TRUE
					);
	
						$move2 = clone $new_move;
						if(( $piece->type != ChessPiece::ANGRYINVERTEDKING)){												
							$move2-> set_promotion_piece(4);
						}
						$moves[] = $move2;
						//return $moves; Dont Return but add more moves
				}
			else
			if(($piece->group=="ROYAL") &&( $piece->type == ChessPiece::ANGRYINVERTEDKING)&&
				(($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0)&&($piece->square->file<9))
				){ //add the war zone normal mode option
				
						$new_move = new ChessMove(
							$piece->square,
							$piece->square,
							0,					
							$piece->color,
							$piece->type,
							$capture,
							$board,
							$store_board_in_moves,
							TRUE
						);
		
							$move2 = clone $new_move;
								$move2-> set_promotion_piece(3);
							$moves[] = $move2;
							//return $moves; Dont Return but add more moves
					}	

	
					if(((strpos($piece->group,"ROYAL")!==FALSE))&&( //cannot get out of no mans
		(($piece->square->file==0)&&($piece->square->rank==0))||(($piece->square->file==0)&&($piece->square->rank==9))||
		(($piece->square->file==9)&&($piece->square->rank==0))||(($piece->square->file==9)&&($piece->square->rank==9))
		)){
			$piece->group;//Stop counting moves as royal is stuck
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
					$piece->square,
					$current_xy[0],
					$current_xy[1],
					$color_to_move,
					$board,
					$cankill,
					$get_FullMover,
					$selfbrokencastle,
					$foebrokencastle					
				);

				$capture = FALSE;
	
				if ( ! $ending_square ) {
					// square does not exist, or square occupied by friendly piece
					// stop sliding
					break;
				}

				if( (($selfbrokencastle==true)&&( $piece->square->rank==9)&&($ending_square->rank<8)&&($color_to_move==2)||
				($foebrokencastle==true)&&($ending_square->rank>1)&&($piece->square->rank==0)&&($color_to_move==2))||  
				(($selfbrokencastle==true)&&( $piece->square->rank==0)&&($ending_square->rank>1)&&($color_to_move==1)||
				($foebrokencastle==true)&&($ending_square->rank<8)&&($piece->square->rank==9)&&($color_to_move==1)))
				{ 
					break;
				}				

				if(($lastaccessiblerow!=-1)&&($color_to_move==2)&&($ending_square->rank<$lastaccessiblerow)){
					continue;
				}

				if(($lastaccessiblerow!=-1)&&($color_to_move==1)&&($ending_square->rank>$lastaccessiblerow)){
					continue;
				}


			//movement within the opponent castle


					if(($piece->group=="SEMIROYAL") &&(($piece->square->rank==$ending_square->rank))&&((($ending_square->rank==0) &&($color_to_move==2))||(($ending_square->rank==9)&&($color_to_move==1)))&&(
						(($ending_square->file>0)&&($ending_square->file<9))
						)){ // Check of promotion can happen

							if($piece->group=="SEMIROYAL"){
								$new_move = new ChessMove(
									$piece->square,
									$ending_square,
									0,					
									$piece->color,
									$piece->type,
									$capture,
									$board,
									$store_board_in_moves,
									FALSE
									);

								$canpromote=false;	
								$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,12);

								if($canpromote==TRUE){
									$move2 = clone $new_move;
									$move2-> set_promotion_piece(12);
									//check if the king is killed
									if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
											$move2->set_killed_king(TRUE);										
									$moves[] = $move2;
									}
							
								$canpromote=false;	
								$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,11);

								if($canpromote==TRUE){
									$move3 = clone $new_move;
									$move3 = clone $new_move;
									$move3-> set_promotion_piece(11);
									//check if the king is killed
									if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
										$move3->set_killed_king(TRUE);										
									$moves[] = $move3;
									}

								if((($foebrokencastle==true)&&((($ending_square->rank==9)&&($color_to_move==1))||(($ending_square->rank==0)&&($color_to_move==2)))) &&(($ending_square->file==4)||($ending_square->file==5)))
									{ 
									continue;
									}									
								$move1 = clone $new_move;
								//check if the king is killed
								if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
									$move1->set_killed_king(TRUE);									
								$moves[] = $move1;									
								continue;											
								}
					}



		//***  Self Compromised CASTLE movement in and out without Royal. 2 steps are not allowed */	
		if((($piece->group=="SEMIROYAL")||($piece->group=="ROYAL"))&&($royalp==false)&&($selfbrokencastle==TRUE)&&
		(((abs($ending_square->file-$piece->square->file)>1)&&(($ending_square->file>=0)&&($ending_square->file<=9))) ||
		((abs($ending_square->rank-$piece->square->rank)>1)&&(($ending_square->file>=0)&&($ending_square->file<=9)))
		
		))
		{			
			continue;
		}

		//classical cannot allow Officers to move to no-mans. Only General is allowed
		if(($board->gametype==1) && (( ($piece->group=="OFFICER") &&($piece->type!=ChessPiece::GENERAL))||($piece->group=="SOLDIER"))&&
		(  (($ending_square->file==0)||($ending_square->file==9))&&	 (($ending_square->rank==0)||($ending_square->rank==9))
		))
		{			
			continue;
		}

		//classical cannot allow Officers to move from CAStle to Truce. Only General is allowed
		if(($board->gametype==1) && (( ($piece->group=="OFFICER") &&($piece->type!=ChessPiece::GENERAL))||($piece->group=="SOLDIER"))&&
		(  (($ending_square->file==0)||($ending_square->file==9)) &&(($piece->square->rank==0)||($piece->square->rank==9))&&
		 (($ending_square->rank>0)&&($ending_square->rank<9)) &&(($piece->square->file>0)&&($piece->square->file<9))
		))
		{			
			continue;
		}

		//classical cannot allow General to move from CAStle to Truce with Royal. Only General is allowed
		if(($board->gametype==1) && ($piece->type==ChessPiece::GENERAL)&&($royalp==false) &&
		(  (($ending_square->file==0)||($ending_square->file==9)) &&(($piece->square->rank==0)||($piece->square->rank==9))&&
		 (($ending_square->rank>0)&&($ending_square->rank<9)) &&(($piece->square->file>0)&&($piece->square->file<9))
		))
		{			
			continue;
		}	


			//***  Self Compromised CASTLE movement in and out without Royal. 2 steps are not allowed */	
			if((($piece->group=="SEMIROYAL")||($piece->group=="ROYAL"))&&($royalp==false)&&($selfbrokencastle==TRUE)&&
			(((abs($ending_square->file-$piece->square->file)>1)&&(($ending_square->file>=0)&&($ending_square->file<=9))) ||
			((abs($ending_square->rank-$piece->square->rank)>1)&&(($ending_square->file>=0)&&($ending_square->file<=9)))
			
			))
			{			
				continue;
			}

			//classical cannot allow Officers to move to no-mans. Only General is allowed
			if(($board->gametype==1) && (( ($piece->group=="OFFICER") &&($piece->type!=ChessPiece::GENERAL))||($piece->group=="SOLDIER"))&&
			(  (($ending_square->file==0)||($ending_square->file==9))&&	 (($ending_square->rank==0)||($ending_square->rank==9))
			))
			{			
				continue;
			}

			//classical cannot allow Officers to move from CAStle to Truce. Only General is allowed
			if(($board->gametype==1) && (( ($piece->group=="OFFICER") &&($piece->type!=ChessPiece::GENERAL))||($piece->group=="SOLDIER"))&&
			(  (($ending_square->file==0)||($ending_square->file==9)) &&(($piece->square->rank==0)||($piece->square->rank==9))&&
			 (($ending_square->rank>0)&&($ending_square->rank<9)) &&(($piece->square->file>0)&&($piece->square->file<9))
			))
			{			
				continue;
			}

			//classical cannot allow General to move from CAStle to Truce with Royal. Only General is allowed
			if(($board->gametype==1) && ($piece->type==ChessPiece::GENERAL)&&($royalp==false) &&
			(  (($ending_square->file==0)||($ending_square->file==9)) &&(($piece->square->rank==0)||($piece->square->rank==9))&&
			 (($ending_square->rank>0)&&($ending_square->rank<9)) &&(($piece->square->file>0)&&($piece->square->file<9))
			))
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
						if(((strpos($piece->group,"ROYAL")==FALSE))&&($board->gametype==1)&&(
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
			}

			/*					
				//Duplcate of above movement within foe castle	
				if(($piece->group=="SEMIROYAL")&&((($piece->square->rank==9)&&($ending_square->rank==9)&&($ending_square->file>0)&&($ending_square->file<9)&&($color_to_move==1))||
				(($piece->square->rank==0)&&($ending_square->rank==0)&&($ending_square->file>0)&&($ending_square->file<9)&&($color_to_move==2))))
				{
			
					if($piece->group=="SEMIROYAL"){
						$new_move = new ChessMove(
						$piece->square,
						$ending_square,
						0,					
						$piece->color,
						$piece->type,
						$capture,
						$board,
						$store_board_in_moves,
						FALSE
						);

					$canpromote=false;	
					$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,12);

					if($canpromote==TRUE){
						$move2 = clone $new_move;
						$move2-> set_promotion_piece(12);
						$moves[] = $move2;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);							
						}
				
					$canpromote=false;	
					$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,11);

					if($canpromote==TRUE){
						$move3 = clone $new_move;
						$move3 = clone $new_move;
						$move3-> set_promotion_piece(11);
						$moves[] = $move3;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);							
						}

					if((($foebrokencastle==true)&&((($ending_square->rank==9)&&($color_to_move==1))||(($ending_square->rank==0)&&($color_to_move==2)))) &&(($ending_square->file==4)||($ending_square->file==5)))
						{ 
						continue;
						}									
					$move1 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move1->set_killed_king(TRUE);						
					$moves[] = $move1;									
					continue;											
					}

				}				
*/
				//War to CASTLE with royal touch
				if((strpos($piece->group,"ROYAL")!==FALSE) && ($royalp)&&($piece->square->rank>1)&&($piece->square->rank<9)&&(($ending_square->file>0)&&($ending_square->file<9)&&(($ending_square->rank==0)||($ending_square->rank==9)))) {
						if ( $board->board[$ending_square->rank][$ending_square->file] ==null) {
							if(($piece->type == ChessPiece::SPY)||($piece->type == ChessPiece::ANGRYARTHSHASTRI)||($piece->type == ChessPiece::ARTHSHASTRI)||($piece->type == ChessPiece::ANGRYKING)||( $piece->type == ChessPiece::ANGRYINVERTEDKING)){
								if(($ending_square->rank==0)||($ending_square->rank==9)){

										$new_move = new ChessMove(
										$piece->square,
										$ending_square,
										0,					
										$piece->color,
										$piece->type,
										$capture,
										$board,
										$store_board_in_moves,
										FALSE
										);
	
									if($piece->group=="SEMIROYAL"){
										//Trying to enter the Opponent CASTLE
										if((($ending_square->rank==9)&&($color_to_move==1))||(($ending_square->rank==0)&&($color_to_move==2))){
											$move1 = clone $new_move;
											$canpromote=false;	
											$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,12);
			
											$canpromote=false;	
											$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,12);
			
											if($canpromote==TRUE){
												$move2 = clone $new_move;
												$move2-> set_promotion_piece(12);
												//check if the king is killed.. Not possible from War to CASTLE.

												//if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
													//$move2->set_killed_king(TRUE);													
												$moves[] = $move2;
												}
										
											$canpromote=false;	
											$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,11);
			
											if($canpromote==TRUE){
												$move3 = clone $new_move;
												$move3-> set_promotion_piece(11);
												//check if the king is killed
												//if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
													//$move3->set_killed_king(TRUE);
												$moves[] = $move3;
												}
			
											//if((($foebrokencastle==true)&&((($ending_square->rank==9)&&($color_to_move==1))||(($ending_square->rank==0)&&($color_to_move==2)))) &&(($ending_square->file==4)||($ending_square->file==5)))
												//{ 
												//continue;
												//}
											}	
											$move1 = clone $new_move;
											//check if the king is killed
											//if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
												//$move1->set_killed_king(TRUE);												
											$moves[] = $move1;									
											continue;											
											}
										//If royals are entering	
										else if(($piece->group=="ROYAL")&&((($ending_square->rank==9)&&($color_to_move==1))||(($ending_square->rank==0)&&($color_to_move==2)))){
											$move2 = clone $new_move;
											if(($piece->type == ChessPiece::ANGRYARTHSHASTRI)||($piece->type == ChessPiece::ARTHSHASTRI))
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
				else if(((strpos($piece->group,"ROYAL")!==FALSE)&&($royalp==false))&&
					((($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file==0))||
					(($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file==9)))){
					$piece->group;//Stop counting moves as royal is alone in truce and cannot move to war
					continue;
				}
				//single Royal in WAR trying to enter to CASTLE or no mans
				else if((strpos($piece->group,"ROYAL")!==FALSE)&&($royalp==false)&&
					($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0)&&($piece->square->file<9)&&
					((($ending_square->rank==0) &&($selfbrokencastle==false)&&($color_to_move==1))||(($ending_square->rank==9) &&($foebrokencastle==false)&&($color_to_move==1))||
					(($ending_square->rank==9) &&($selfbrokencastle==false)&&($color_to_move==2))||(($ending_square->rank==0) &&($foebrokencastle==false)&&($color_to_move==2))
					||($ending_square->file==0)||($ending_square->file==9)))
					{
					continue;
				}

				if($royalp==TRUE){ /*We can also add the promotion logic*/
					if((($board->board[$piece->square->rank][$piece->square->file]->group=='ROYAL')||($board->board[$piece->square->rank][$piece->square->file]->group=='SEMIROYAL'))&&
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

					if(($selfbrokencastle==true)&&($piece->square->rank==0)&&($ending_square->rank>1)&&($color_to_move==1)||
					($foebrokencastle==true)&&($piece->square->rank==9)&&($ending_square->rank<8)&&($color_to_move==1))
					{ /* More than 2 rank jump not allwed rom compromised castle*/
					continue;
					}
					elseif(($selfbrokencastle==true)&&($piece->square->rank==0)&&($ending_square->rank>1)&&($color_to_move==2)||
					($foebrokencastle==true)&&($piece->square->rank==9)&&($ending_square->rank<8)&&($color_to_move==2))
					{ /* More than 2 rank jump not allwed rom compromised castle*/
					continue;
					}
					elseif(($selfbrokencastle==true)&&($ending_square->rank==0)&&($color_to_move==1)||
					($foebrokencastle==true)&&($ending_square->rank==9)&&($color_to_move==1))
					{ /*
					* CASTLE has become warzone
					*/
					}
					else
					if(($selfbrokencastle==true)&&($ending_square->rank==9)&&($color_to_move==2)||
					($foebrokencastle==true)&&($ending_square->rank==0)&&($color_to_move==2))
					{ /*
					* CASTLE has become warzone
					*/

					}
					else				
					if((($ending_square->rank==0) &&($ending_square->file>0)&&($ending_square->file<9))||(($ending_square->rank==9) &&($ending_square->file>0)&&($ending_square->file<9))){
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

						if((($ending_square->rank>=1)&& ($ending_square->file>=1)&&($ending_square->rank<=8)&& ($ending_square->file<=8))&&
						(($piece->square->rank==9)|| ($piece->square->rank==0))||(($piece->square->file==9)|| ($piece->square->file==0))){
							break; /** Cannot kill out of the zone */
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
							else
							if($piece->square->file==8){
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
							else
							if(($piece->square->file==0)&&($ending_square->file==0)&&($piece->square->rank==8)&&($ending_square->rank==9)){
								$ending_square->rank=9;$cancapture=FALSE;
							}
							else
							if(($piece->square->file==9)&&($ending_square->file==9)&&($piece->square->rank==1)&&($ending_square->rank==0)){
								$ending_square->rank=0;$cancapture=FALSE;
							}
							else
							if(($piece->square->file==9)&&($ending_square->file==9)&&($piece->square->rank==8)&&($ending_square->rank==9)){
								$ending_square->rank=9;$cancapture=FALSE;
							}
							else							
							if(($piece->square->file==0)&&($ending_square->file==1)){
								$ending_square->file=1;$cancapture=FALSE;
							}
							else
							if(($piece->square->file==9)&&($ending_square->file==8)){
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
				$ksqr=$board->get_king_square($color_to_move);

				if($ksqr==null) continue;
				if(($capture==TRUE)&&
				(($board->get_king_square($color_to_move)->rank==0)&&(($board->get_king_square($color_to_move)->file==4)||($board->get_king_square($color_to_move)->file==5))&&($color_to_move==1)
				||($board->get_king_square($color_to_move)->rank==9)&&(($board->get_king_square($color_to_move)->file==4)||($board->get_king_square($color_to_move)->file==5))&&($color_to_move==2)))
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
								$piece->square,
								$ending_square,
								0,					
								$piece->color,
								$piece->type,
								$capture,
								$board,
								$store_board_in_moves,
								FALSE
								);

							$move2 = clone $new_move;
							$move2-> set_demotion_piece($piece->type+$dem);
							//check if the king is killed
							if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);								
							$moves[] = $move2;
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
							$piece->square,
							$ending_square,
							0,
							$piece->color,
							$piece->type,
							$capture,
							$board,
							$store_board_in_moves,
							FALSE
							);

					$move3 = clone $new_move1;			
					$move3-> set_promotion_piece(12);
					$moves[] = $move3;
					}
				}

				if((($ending_square->rank==0)&&($color_to_move==2))||(($ending_square->rank==9)&&($color_to_move==1))){

					$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,11);

					if(($canpromote==TRUE)){// then update the parity with new ptomoted values
						//Force Promotion to add in movelist	
						$new_move1 = new ChessMove(
							$piece->square,
							$ending_square,
							0,					
							$piece->color,
							$piece->type,
							$capture,
							$board,
							$store_board_in_moves,
							FALSE
							);

						$move3 = clone $new_move1;
						$move3-> set_promotion_piece(11);
						$moves[] = $move3;
					}
				}
				continue;
			}
				

			//***  Foe Compromised CASTLE movement witin itself or out of  it without Royal. */	

			if((($piece->group=="SEMIROYAL")||($piece->group=="ROYAL"))&&($royalp==false)&&($foebrokencastle==TRUE)&&
			((($piece->square->rank==0)&&($ending_square->rank==1)&&(($ending_square->file>0)&&($ending_square->file<9))&&($color_to_move==2))||
			(($ending_square->rank==8)&&($piece->square->rank==9)&&(($ending_square->file>0)&&($ending_square->file<9))&&($color_to_move==1))||
			(($piece->square->rank==0)&&($ending_square->rank==0)&&(($ending_square->file>=0)&&($ending_square->file<=9))&&($color_to_move==2))||
			(($ending_square->rank==9)&&($piece->square->rank==9)&&(($ending_square->file>=0)&&($ending_square->file<=9))&&($color_to_move==1))			
			))
			{

						$new_move1 = new ChessMove(
							$piece->square,
							$ending_square,
							0,
							$piece->color,
							$piece->type,
							$capture,
							$board,
							$store_board_in_moves,
							FALSE
							);

					$move3 = clone $new_move1;			
					if($piece->group=="SEMIROYAL")
						$move3-> set_promotion_piece(12);
					$moves[] = $move3;

				continue;
			}

				//CASTLE to WAR  Defective ???
				if((($piece->group=="ROYAL"))&&
					(((($ending_square->rank>0)&&($ending_square->rank<9))&&(($ending_square->file>=0)&&($ending_square->file<=9)))&&		
					((($piece->square->rank==0)||($piece->square->rank==9))&&(($piece->square->file>0)&&($piece->square->file<9)))	
					))
					{
						$new_move = new ChessMove(
							$piece->square,
							$ending_square,
							1,					
							$piece->color,
							$piece->type,
							$capture,
							$board,
							$store_board_in_moves,
							FALSE
						);
	
						$move2 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);							
	
						if(( $piece->type == ChessPiece::KING)){
							$move2-> set_promotion_piece(3);
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);								
							$moves[] = $move2;
							$move3 = clone $new_move;
							$move3-> set_promotion_piece(4);
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);								
							$moves[] = $move3;
						}
						elseif(( $piece->type == ChessPiece::ARTHSHASTRI)){
							$moves[] = $move2;
							$move2-> set_promotion_piece(6);
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);								
						}
						elseif( $piece->type == ChessPiece::ANGRYARTHSHASTRI){
							$moves[] = $move2;
						}
						elseif(( $piece->type == ChessPiece::ANGRYKING)){ 
							$moves[] = $move2;
							$move3 = clone $new_move;
							$move3-> set_promotion_piece(4);
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);								
							$moves[] = $move3;
							}
							continue;							
					}	
				//CASTLE to castle or castle to No Mans
				elseif((($piece->group=="ROYAL"))&&
					(((($ending_square->rank==0)||($ending_square->rank==9))&&(($ending_square->file>=0)&&($ending_square->file<=9)))&&		
					((($piece->square->rank==0)||($piece->square->rank==9))&&(($piece->square->file>0)&&($piece->square->file<9)))	
					))
					{
						$new_move = new ChessMove(
							$piece->square,
							$ending_square,
							1,					
							$piece->color,
							$piece->type,
							$capture,
							$board,
							$store_board_in_moves,
							FALSE
						);
	
						$move2 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);							
						if(( $piece->type == ChessPiece::ANGRYARTHSHASTRI)&&($ending_square->file!=4)&&($ending_square->file!=5)){
							$moves[] = $move2;
						}
						elseif((( $piece->type == ChessPiece::ANGRYKING))&&($ending_square->file!=4)&&($ending_square->file!=5)){ 
							$moves[] = $move2;
							$move3 = clone $new_move;
							$move3-> set_promotion_piece(4);
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);								
							$moves[] = $move3;
							}
						elseif(($ending_square->file==4)||($ending_square->file==5)){
							if(($piece->type == ChessPiece::KING)){
								$moves[] = $move2;
								$move3 = clone $new_move;
								$move3-> set_promotion_piece(2);
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);									
								$moves[] = $move3;								
								}

							if(($piece->type == ChessPiece::ARTHSHASTRI))
								$moves[] = $move2;

							if(($piece->type == ChessPiece::ANGRYARTHSHASTRI)){
								$move2-> set_promotion_piece(5);
								$moves[] = $move2;
								}

							if(($piece->type == ChessPiece::ANGRYKING)){
									$move2-> set_promotion_piece(1);
									$moves[] = $move2;
									$move3 = clone $new_move;
									$move3-> set_promotion_piece(2);
									$moves[] = $move3;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);										
								}
							}
						elseif(($ending_square->file<4)||($ending_square->file>5)){ 
							if(($piece->type == ChessPiece::KING)){
								$move2-> set_promotion_piece(3);
								$moves[] = $move2;
								$move3 = clone $new_move;
								$move3-> set_promotion_piece(4);
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);									
								$moves[] = $move3;								
								}

							if(($piece->type == ChessPiece::ANGRYARTHSHASTRI))
								$moves[] = $move2;

							if(($piece->type == ChessPiece::ARTHSHASTRI)){
								$move2-> set_promotion_piece(6);
								$moves[] = $move2;
								}

							if(($piece->type == ChessPiece::ANGRYKING)){
								$moves[] = $move2;
								$move3 = clone $new_move;
								$move3-> set_promotion_piece(4);
								$moves[] = $move3;
								}
							}
						continue;
					}
				//WAR to CASTLE (non-Scepter) or to No mans defective
				elseif(($piece->group=="ROYAL")&&
					((($piece->square->file>0)&&($piece->square->file<9))&&(($piece->square->rank>0)&&($piece->square->rank<9))&&(($ending_square->rank==0)||($ending_square->rank==9))&&(($ending_square->file<4)||($ending_square->file>5))))
					{
						//$moves-> set_promotion_piece(2);
						$new_move = new ChessMove(
							$piece->square,
							$ending_square,
							1,					
							$piece->color,
							$piece->type,
							$capture,
							$board,
							$store_board_in_moves,
							FALSE
						);
	
						$move2 = clone $new_move;
	
						if(( $piece->type == ChessPiece::ANGRYINVERTEDKING)&&( $piece->type != ChessPiece::ANGRYARTHSHASTRI)&&( $piece->type != ChessPiece::ARTHSHASTRI)&&( $piece->type != ChessPiece::SPY)){
							//$move2-> set_demotion_piece($piece->type+$dem);
							$move2-> set_promotion_piece(3);
						}
						else
						if(( $piece->type != ChessPiece::ANGRYKING)&&( $piece->type != ChessPiece::ANGRYINVERTEDKING)&&( $piece->type == ChessPiece::ANGRYARTHSHASTRI)&&( $piece->type != ChessPiece::SPY)){
							//$move2-> set_demotion_piece($piece->type+$dem);
							$move2-> set_promotion_piece(6);
						}						
						$moves[] = $move2;
						$move3 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);	

						if(( $piece->type == ChessPiece::ANGRYKING)&&( $piece->type != ChessPiece::ANGRYARTHSHASTRI)&&( $piece->type != ChessPiece::ARTHSHASTRI)&&( $piece->type != ChessPiece::SPY)){
								$move3-> set_promotion_piece(4);
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
						$new_move = new ChessMove(
							$piece->square,
							$ending_square,
							1,
							$piece->color,
							$piece->type,
							$capture,
							$board,
							$store_board_in_moves,
							FALSE
						);
	
							$move2 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);	

							if(( $piece->type == ChessPiece::KING)&&
							(((($piece->square->rank==0)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file==4) ||($ending_square->file==5))&&
							($color_to_move==1))||(($piece->square->rank==9)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file==4)||($ending_square->file==5))&&($color_to_move==2)	)))
							){
								$moves[] = $move2;
								$move3 = clone $new_move;
								$move3-> set_promotion_piece(2);
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);									
								$moves[] = $move3;
							}
							else							
							if((( $piece->type == ChessPiece::ANGRYKING)||( $piece->type == ChessPiece::ANGRYINVERTEDKING))&&
							((($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0) && ($piece->square->file<9))&&
							(($ending_square->file==4) ||($ending_square->file==5))&&((($ending_square->rank==0)&&($color_to_move==1))||(($ending_square->rank==9)&&($color_to_move==2))))
							){
								$move2-> set_promotion_piece(1);
								$moves[] = $move2;
								$move3 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);									
								$move3-> set_promotion_piece(2);
								$moves[] = $move3;
							}
							else
							if(( $piece->type == ChessPiece::ARTHSHASTRI)&&
							(((($piece->square->rank==0)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file==4) ||($ending_square->file==5))&&
							($color_to_move==1))||(($piece->square->rank==9)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file==4)||($ending_square->file==5))&&($color_to_move==2)	)))
							){
								$moves[] = $move2;
							}
							else							
							if(( $piece->type == ChessPiece::ANGRYARTHSHASTRI)&&
							((($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0) && ($piece->square->file<9))&&
							(($ending_square->file==4) ||($ending_square->file==5))&&((($ending_square->rank==0)&&($color_to_move==1))||(($ending_square->rank==9)&&($color_to_move==2))))
							){
								$move2-> set_promotion_piece(5);
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
							$piece->square,
							$ending_square,
							1,
							$piece->color,
							$piece->type,
							$capture,
							$board,
							$store_board_in_moves,
							FALSE
						);
	
							$move2 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);	

							if(( $piece->type == ChessPiece::KING)&&
							(((($piece->square->rank==0)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file!=4) &&($ending_square->file!=5))&&
							($color_to_move==1))||(($piece->square->rank==9)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file!=4)&&($ending_square->file!=5))&&($color_to_move==2)	)))
							){
								$move2-> set_promotion_piece(3);
								$moves[] = $move2;
								$move3 = clone $new_move;
								$move3-> set_promotion_piece(4);
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);									
								$moves[] = $move3;							
							}
							else
							if(( $piece->type == ChessPiece::ANGRYKING)&&
							(((($piece->square->rank==0)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file!=4) &&($ending_square->file!=5))&&
							($color_to_move==1))||(($piece->square->rank==9)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file!=4)&&($ending_square->file!=5))&&($color_to_move==2)	)))
							){
								$moves[] = $move2;
								$move3 = clone $new_move;
								$move3-> set_promotion_piece(4);
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);									
								$moves[] = $move3;
							}
							else
							if((( $piece->type == ChessPiece::ARTHSHASTRI)||($piece->type == ChessPiece::ANGRYARTHSHASTRI))&&
							(((($piece->square->rank==0)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file!=4) &&($ending_square->file!=5))&&
							($color_to_move==1))||(($piece->square->rank==9)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file!=4)&&($ending_square->file!=5))&&($color_to_move==2)	)))
							){
								if($piece->type != ChessPiece::ANGRYARTHSHASTRI)
									$move2-> set_promotion_piece(6);
								$moves[] = $move2;
							}

					}
				/* From Truce to CASTLE or WAR*/						
				elseif(($piece->group=="ROYAL")&&(($piece->type == ChessPiece::ANGRYKING)||  ( $piece->type == ChessPiece::ANGRYARTHSHASTRI) )&&
					((($piece->square->rank>0)&&($piece->square->rank<9)&&(($piece->square->file==0) || ($piece->square->file==9)))||
						(($piece->square->file>=0)&&($piece->square->file<=9)&&(($piece->square->rank==0) || ($piece->square->rank==9))&&($ending_square->rank!=$piece->square->rank))||
						(($piece->square->file>=0)&&($piece->square->file<=9)&&(($piece->square->rank==0) || ($piece->square->rank==9))&&($ending_square->rank==$piece->square->rank)&&
						(($ending_square->file<4)||($ending_square->file>5)))
						))
					{
						$new_move = new ChessMove(
							$piece->square,
							$ending_square,
							1,					
							$piece->color,
							$piece->type,
							$capture,
							$board,
							$store_board_in_moves,
							FALSE
						);
	
	
						$move3 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);	

						if(( $piece->type == ChessPiece::ANGRYKING)&&( $piece->type != ChessPiece::ANGRYARTHSHASTRI)){												
							$moves[] = $move3;
							$move3 = clone $new_move;
							$move3-> set_promotion_piece(4);
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);								
								$moves[] = $move3;
							}

						if(( $piece->type != ChessPiece::ANGRYKING)&&( $piece->type == ChessPiece::ANGRYARTHSHASTRI)){												
								//$move3-> set_promotion_piece(6);
							}

						$moves[] = $move3;
						continue;
					}
				/***** Add for ArthShahstri logoc also */	
				elseif(($piece->group=="ROYAL")&&(($ending_square->file>0)&&($ending_square->file<9)||((($ending_square->rank==0)||($ending_square->rank==9)) &&($ending_square->file!=4) && ($ending_square->file!=5)))&&
					(((( $piece->type == ChessPiece::KING)||( $piece->type == ChessPiece::ARTHSHASTRI))&&
					((($piece->square->rank==0)&&(($piece->square->file==4) ||($piece->square->file==5))&&($color_to_move==1)
					)||(($piece->square->rank==9)&&(($piece->square->file==4)||($piece->square->file==5))&&($color_to_move==2)
					)))|| ((( $piece->type == ChessPiece::ANGRYKING) ||( $piece->type == ChessPiece::ANGRYARTHSHASTRI))&& (($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0) && ($piece->square->file<9)))
					)){
						//$moves-> set_promotion_piece(2);
						$new_move = new ChessMove(
							$piece->square,
							$ending_square,
							1,					
							$piece->color,
							$piece->type,
							$capture,
							$board,
							$store_board_in_moves,
							FALSE
						);

						$move2 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);	

						if((( $piece->type == ChessPiece::ANGRYKING))&&((($ending_square->rank==0)&&($color_to_move==2))||(($ending_square->rank==9)&&(($color_to_move==1))))
						&&(($ending_square->file==5)||($ending_square->file==4))){	
							$move2-> set_promotion_piece(1);
						}
						else
						if(( $piece->type == ChessPiece::ANGRYARTHSHASTRI)&&((($ending_square->rank==0)&&($color_to_move==2))||(($ending_square->rank==9)&&(($color_to_move==1))))
						&&(($ending_square->file==5)||($ending_square->file==4))){	
							$move2-> set_promotion_piece(5);
						}

						$moves[] = $move2;
						$move3 = clone $new_move;
						if(( $piece->type == ChessPiece::ANGRYKING)||( $piece->type == ChessPiece::KING)){
								$move3-> set_promotion_piece(4);
							}
						else
						if(( $piece->type == ChessPiece::ARTHSHASTRI)&&((($ending_square->rank==0)&&($color_to_move==2))||(($ending_square->rank==9)&&(($color_to_move==1))))
						&&(($ending_square->file!=5)&&($ending_square->file!=4))){
								$move3-> set_promotion_piece(6);
							}
						$moves[] = $move3;	
					}
				/***** Add for ArthShahstri logoc also */	
				elseif(($piece->group=="ROYAL")&&(($piece->type == ChessPiece::ANGRYKING)||($piece->type == ChessPiece::ANGRYARTHSHASTRI))&&
					(($piece->square->rank>0)&&($piece->square->rank<9)&&(($piece->square->file==0) || ($piece->square->file==9))))
					{
				
						$moves[] = new ChessMove(
							$piece->square,
							$ending_square,
							0,
							$piece->color,
							$piece->type,
							$capture,
							$board,
							$store_board_in_moves,
							false);

						$new_move = new ChessMove(
							$piece->square,
							$ending_square,
							1,					
							$piece->color,
							$piece->type,
							$capture,
							$board,
							$store_board_in_moves,
							FALSE
						);
	
							$move3 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);	

							if(( $piece->type != ChessPiece::ANGRYINVERTEDKING)){												
								$move3-> set_promotion_piece(4);
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
                            $piece->square,
                            $ending_square,
                            1,
                            $piece->color,
                            $piece->type,
                            $capture,
                            $board,
                            $store_board_in_moves,
                            false
                        );
        
                        $move2 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);	

                        //$move2-> set_demotion_piece($piece->type+$dem);
						if(( $piece->type == ChessPiece::KING)){	    
                        $move2-> set_promotion_piece(3);
                        $moves[] = $move2;
                        $move3 = clone $new_move;		
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);																
						$move3-> set_promotion_piece(4);
						$moves[] = $move3;
						}

						if(( $piece->type == ChessPiece::ARTHSHASTRI)){	    
							$move2-> set_promotion_piece(6);
							$moves[] = $move2;
							}

                    }
				 /***** Add for ArthShahstri logoc also */	
				elseif(($piece->group=="ROYAL")&&(( $piece->type == ChessPiece::ANGRYKING)||( $piece->type == ChessPiece::ANGRYARTHSHASTRI))&&
					((($piece->square->rank==0)&&(($ending_square->file==4) ||($ending_square->file==5))&&($color_to_move==1)
					)||(($piece->square->rank==9)&&(($ending_square->file==4)||($ending_square->file==5))&&($color_to_move==2)
					))){
                        //$moves-> set_promotion_piece(2);
                        $new_move = new ChessMove(
                            $piece->square,
                            $ending_square,
                            1,
                            $piece->color,
                            $piece->type,
                            $capture,
                            $board,
                            $store_board_in_moves,
                            false
                        );
        
                        $move2 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);	

                        //$move2-> set_demotion_piece($piece->type+$dem);
						if( $piece->type == ChessPiece::ANGRYKING){
                        $move2-> set_promotion_piece(1);
                        $moves[] = $move2;
                        $move3 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);	

                        $move3-> set_promotion_piece(2);
                        $moves[] = $move3;
						}
						if( $piece->type == ChessPiece::ANGRYARTHSHASTRI){
							$move2-> set_promotion_piece(5);
							$moves[] = $move2;
							}						
                    }					
				else{
					/* Classical officers cannot penetrate the CASTLE without royals*/
					if(($piece->group=="OFFICER") &&($board->board[$ending_square->rank][$ending_square->file]==null)&&((($piece->square->rank>0)&&($piece->square->rank<9))&&(($ending_square->file>=0)||($ending_square->file<=9))&&(
						(($ending_square->rank==0)||($ending_square->rank==9))) && (($board->gametype==1)))){ 

							if(($royalp==true)||(($selfbrokencastle==true)&&($ending_square->rank==0)&&($color_to_move==1)) || (($selfbrokencastle==true)&&($ending_square->rank==9)&&($color_to_move==2))||
							(($foebrokencastle==true)&&($ending_square->rank==0)&&($color_to_move==2))||(($foebrokencastle==true)&&($ending_square->rank==9)&&($color_to_move==1))){
								$new_move = new ChessMove(
									$piece->square,
									$ending_square,
									0,					
									$piece->color,
									$piece->type,
									$capture,
									$board,
									$store_board_in_moves,
									FALSE
									);

								$move2 = clone $new_move;
								$moves[] = $move2;
							}
							continue;
						}
						//officers cannot jump from CASTLE or No Mans to WAR.But with neighbour Royals, it is possible
						elseif(($piece->group=="OFFICER") &&($board->board[$ending_square->rank][$ending_square->file]==null)&&((($piece->square->file==0)||($piece->square->file==9))&&(($piece->square->rank>=0)&&($piece->square->rank<=9))&&(($ending_square->file>0)||($ending_square->file<9))&&(
							(($ending_square->rank>0)&&($ending_square->rank<9))) && (($board->gametype==1)))){ 
	
								if($royalp==true){
									$new_move = new ChessMove(
										$piece->square,
										$ending_square,
										0,					
										$piece->color,
										$piece->type,
										$capture,
										$board,
										$store_board_in_moves,
										FALSE
										);
	
									$move2 = clone $new_move;
									$moves[] = $move2;
								}
								continue;
							}						
					elseif(($piece->group=="OFFICER") &&($board->board[$ending_square->rank][$ending_square->file]!=null)&&((($piece->square->rank>0)&&($piece->square->rank<9))&&(($ending_square->file>=0)||($ending_square->file<=9))&&(
						(($ending_square->rank==0)||($ending_square->rank==9))))){ /*Cannot kill anyone from war to  CASTLE*/
						}
					if(($piece->group=="OFFICER") &&($board->board[$ending_square->rank][$ending_square->file]!=null)&&((($piece->square->rank>0)&&($piece->square->rank<9))&&(($ending_square->file>=0)||($ending_square->file<=9))&&(
						(($ending_square->rank==0)||($ending_square->rank==9))) && (($royalp==true)&&($board->gametype==1)) && ($piece->type==ChessPiece::GENERAL) )){ /* Classical General can penetrate the CASTLE */

							$new_move = new ChessMove(
								$piece->square,
								$ending_square,
								0,					
								$piece->color,
								$piece->type,
								$capture,
								$board,
								$store_board_in_moves,
								FALSE
								);

							$move2 = clone $new_move;
							$moves[] = $move2;
							continue;							
						}					
					elseif(($piece->group=="OFFICER") &&($board->board[$ending_square->rank][$ending_square->file]!=null)&&((($piece->square->rank>0)&&($piece->square->rank<9))&&(($ending_square->file>=0)||($ending_square->file<=9))&&(
						(($ending_square->rank==0)||($ending_square->rank==9))))){ /*Cannot kill anyone from war to  CASTLE*/
						}
					elseif(($piece->group=="OFFICER") &&($board->board[$ending_square->rank][$ending_square->file]!=null)&&((($piece->square->rank>0)&&($piece->square->rank<9))&&(($ending_square->file>=0)||($ending_square->file<=9))&&(
					(($ending_square->rank==0)||($ending_square->rank==9))))){ /*Cannot kill anyone from war to  CASTLE*/
						}
					elseif(($piece->group=="OFFICER") &&(($ending_square->file==0)||($ending_square->file==9))&&(
							(($ending_square->rank>=0)&&($ending_square->rank<=9))
							)&&(($royalp==FALSE)&&($board->gametype==1))){
								continue; // Check of demotion can happen in Truce or No Mans as per Parity
						}
					elseif(($piece->type==ChessPiece::GENERAL)&&($piece->group=="OFFICER") &&(($ending_square->file==0)||($ending_square->file==9))&&(
							(($ending_square->rank>=0)&&($ending_square->rank<=9))
							)&&(($royalp==true)&&($board->gametype==1))){
				
									$new_move = new ChessMove(
										$piece->square,
										$ending_square,
										0,					
										$piece->color,
										$piece->type,
										$capture,
										$board,
										$store_board_in_moves,
										FALSE
										);
		
									$move2 = clone $new_move;
									$moves[] = $move2;
									continue;
							}
					else{
						
                        $new_move = new ChessMove(
                        	$piece->square,
                        	$ending_square,
                        	0,
                        	$piece->color,
                        	$piece->type,
                        	$capture,
                        	$board,
                        	$store_board_in_moves,
                        	false
                    	);

						$move2 = clone $new_move;

						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);							
						$moves[] = $move2;

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

					if($droyalp==TRUE)
					{ // Check of demotion can happen
						$dem=-1;

						$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,$piece->type-1);

						if($canpromote==TRUE){// then update the parity with new demoted values
							//$piece->type=$piece->type+1;
							//Force Promotion to add in movelist	
							$new_move1 = new ChessMove(
								$piece->square,
								$ending_square,
								0,					
								$piece->color,
								$piece->type,
								$capture,
								$board,
								$store_board_in_moves,
								FALSE
								);

							$move3 = clone $new_move1;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);								
							$move3-> set_promotion_piece($piece->type+$dem);
							$moves[] = $move3;
							}
						}
			}	

				if ( $capture ) {
					// stop sliding
					break;
				}

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
			//**echo '<li> ChessRuleBook.php #5 function add_capture_moves_to_moves_list called </li>';				
			$tempDirection=null;
			$officerp=TRUE;  
			$mtype=1;//slide //2 jump
			$lastaccessiblerow=-1;
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

			if(($piece->square->rank==8)&&($piece->square->file==0)){
				$piece->square->rank;
			}

				$officerp=self::add_officer_neighbours_moves_to_moves_list( /**/
					self::KING_DIRECTIONS,
					$piece,
					$color_to_move,
					$board
				);
				
			$officerp;
			
		if($officerp==TRUE){


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
						continue; /** Only Mortals can be created */
					}					
				}

				//If King is holding scepter then no Capture Allowed
				if(($capture==TRUE)&&
				(($board->get_king_square($piece->color)->rank==0)&&($board->get_king_square($piece->color)->file==4)&&($piece->color==1)
				||($board->get_king_square($piece->color)->rank==9)&&($board->get_king_square($piece->color)->file==5)&&($piece->color==2)))
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

				/*  Check the neighbouring Officers	
				if($board->board[$intermediate_square->rank][$intermediate_square->file]){//if intermediate cell has data
					if (($cankill==2) &&(abs($board->board[$intermediate_square->rank][$intermediate_square->file]->color - $color_to_move) ==0)) {//Same team-member
						if(($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='ROYAL')||
						($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='OFFICER')||
						($board->board[$intermediate_square->rank][$intermediate_square->file]->group=='SOLDIER')){
						}
					else
						{
							return null;//
						}
					}
				}
				*/
								
				if (( $capture )&&($cankill==1)) {
					$move = new ChessMove(
						$piece->square,
						$ending_square,
						0,
						$piece->color,
						$piece->type,
						$capture,
						$board,
						$store_board_in_moves,
						FALSE
					);				

						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move->set_killed_king(TRUE);	

						$moves[] = $move;
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

			$officerp=self::add_officer_neighbours_moves_to_moves_list( /**/
					self::KING_DIRECTIONS,
					$piece,
					$color_to_move,
					$board
				);
				
			$officerp;
			
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
                            	$capture = true;
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
                        	$ending_square,
                        	0,
                        	$piece->color,
                        	$piece->type,
                        	$capture,
                        	$board,
                        	$store_board_in_moves,
							FALSE
                    	);
        
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move->set_killed_king(TRUE);							
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
		bool $get_FullMover,
		bool $selfbrokencastle,
		bool $foebrokencastle,
		int $get_CASTLEMover

	): array 
	{
		//SEMIROYAL  SELF PROMOTION, TOUCH PROMOTION Not done yet
        //breakpointer

		$tempDirection=null;
		$mtype=2;//slide //2 jump
		$lastaccessiblerow=-1;

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

		$tempDirection=null;
        $booljump=TRUE;
		$royalp=FALSE; 
		$cancapture=True;
		$candemote=FALSE;
		$capture = FALSE;
		$dem=0;
		$officer_royalp=FALSE;

            $booljump=self::add_royal_neighbours_moves_to_moves_list( /**/
                self::KING_DIRECTIONS,
                $piece,
                $color_to_move,
                $board
            );

		if ($type==2) {/* Check if royal has royals. if not then cannot jump*/

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
		else if ($type==1) {/* Check if Officer has royals*/
			if(($get_CASTLEMover==1))//&&(($board->$blackcanfullmoveinowncastle == 1)||($board->$whitecanfullmoveinowncastle == 1)))
			{
				$officer_royalp=true;
				$booljump=true;
			}
			else
			$officer_royalp=$booljump;
			$booljump=true;
		}

		if(($piece->group=="OFFICER")&&($officer_royalp==TRUE)&&($piece->square->file>0)&&($piece->square->file<9)){ // Check of promotion can happen except TZ

			if($piece->type!=9)
			$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,10);
			else
			$canpromote=false;
				
			if($canpromote==TRUE){// then update the parity with new demoted values
			//$piece->type=$piece->type+1;
				//Force Promotion to add in movelist	
				$new_move1 = new ChessMove(
					$piece->square,
					$piece->square,
					0,					
					$piece->color,
					$piece->type,
					$capture,
					$board,
					$store_board_in_moves,
					TRUE
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
						$piece->square,
						0,					
						$piece->color,
						$piece->type,
						$capture,
						$board,
						$store_board_in_moves,
						TRUE
					);
	
						$move2 = clone $new_move;
							$move2-> set_promotion_piece(2);
						$moves[] = $move2;
						//return $moves; Dont Return but add more moves
				}
			else			
			if(($piece->group=="ROYAL")&&( $piece->type == ChessPiece::ANGRYKING)&&
			(($piece->square->rank==0)&&($piece->square->file!=4)&&($piece->color==1)||($piece->square->rank==9)&&($piece->square->file!=5)&&($piece->color==2))
			){ // give the option to become normal in castle
			
					$new_move = new ChessMove(
						$piece->square,
						$piece->square,
						0,					
						$piece->color,
						$piece->type,
						$capture,
						$board,
						$store_board_in_moves,
						TRUE
					);
	
						$move2 = clone $new_move;
						if(( $piece->type != ChessPiece::ANGRYINVERTEDKING)){												
							$move2-> set_promotion_piece(4);
						}
						$moves[] = $move2;
						//return $moves; Dont Return but add more moves
				}
			else
			if(($piece->group=="ROYAL") &&($royalp==true)&&( $piece->type == ChessPiece::ANGRYKING)&&
			(($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0)&&($piece->square->file<9))
			){ //add the war zone inversion mode
			
					$new_move = new ChessMove(
						$piece->square,
						$piece->square,
						0,					
						$piece->color,
						$piece->type,
						$capture,
						$board,
						$store_board_in_moves,
						TRUE
					);
	
						$move2 = clone $new_move;
						if(( $piece->type != ChessPiece::ANGRYINVERTEDKING)){												
							$move2-> set_promotion_piece(4);
						}
						$moves[] = $move2;
						//return $moves; Dont Return but add more moves
				}
				else
				if(($piece->group=="ROYAL") &&($royalp==true)&&( $piece->type == ChessPiece::ANGRYINVERTEDKING)&&
				(($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0)&&($piece->square->file<9))
				){ //add the war zone inversion mode
				
						$new_move = new ChessMove(
							$piece->square,
							$piece->square,
							0,					
							$piece->color,
							$piece->type,
							$capture,
							$board,
							$store_board_in_moves,
							TRUE
						);
		
							$move2 = clone $new_move;
								$move2-> set_promotion_piece(3);
							$moves[] = $move2;
							//return $moves; Dont Return but add more moves
					}
				else
				if(($piece->group=="ROYAL") &&($royalp==true)&&( $piece->type == ChessPiece::ANGRYINVERTEDKING)&&
				(($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0)&&($piece->square->file<9))
				){ //add the war zone normal mode option
				
						$new_move = new ChessMove(
							$piece->square,
							$piece->square,
							0,					
							$piece->color,
							$piece->type,
							$capture,
							$board,
							$store_board_in_moves,
							TRUE
						);
		
							$move2 = clone $new_move;
								$move2-> set_promotion_piece(3);
							$moves[] = $move2;
							//return $moves; Dont Return but add more moves
					}

		//booljump true means can change the zone..
        $tcount=0;
		if($get_FullMover==FALSE){ return $moves ;} //It is useless to loop through all possible moves
		if($jumpstyle=='1')
		 $tcount=1;
		elseif($jumpstyle=='2')
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

					if((($jumpstyle=='3')||($jumpstyle=='1'))&&($tempc==1))
						$jflag='1';
					
					if(((($jumpstyle=='3')&&($tempc==2))||(($jumpstyle=='2')&&($tempc==1))))
						$jflag='2';

			       	$ending_square = self::square_exists_and_not_occupied_by_friendly_piece(
                	$type,
					$jflag,
                	$piece->square,
                	$ydelta,
                	$xdelta,
					$color_to_move,
                	$board,
					$cankill,
					$get_FullMover,
					$selfbrokencastle,
					$foebrokencastle
            		);
            
            	if ($ending_square) {
                	$capture = false;

					if(($royalp==true)&&(strpos($piece->group,"ROYAL")!==FALSE)&&((($ending_square->rank==2)&&($piece->square->rank==0))||(($ending_square->rank==7)&&($piece->square->rank==9)))){
						continue;//2 steps jump to castle not allowed
					}

					if(($royalp==true)&&(strpos($piece->group,"ROYAL")!==FALSE)&&((($ending_square->file==1)&&($piece->square->file==0))||(($ending_square->file==8)&&($piece->square->file==9))||(($ending_square->file==2)&&($piece->square->file==0))||(($ending_square->file==7)&&($piece->square->file==9)))){
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


			//***  Self Compromised CASTLE movement in and out without Royal. 2 steps are not allowed */	

			if((($piece->group=="SEMIROYAL")||($piece->group=="ROYAL"))&&($royalp==false)&&($selfbrokencastle==TRUE)&&
			(((abs($ending_square->file-$piece->square->file)>1)&&(($ending_square->file>=0)&&($ending_square->file<=9))) ||
			((abs($ending_square->rank-$piece->square->rank)>1)&&(($ending_square->file>=0)&&($ending_square->file<=9)))
			
			))
			{			
				continue;
			}			

			//Officers cannot jump two ranks out-of or wintin Self Compromised Castle.
			if((($piece->group=="OFFICER"))&&($selfbrokencastle==TRUE)&&
			(((abs($ending_square->rank-$piece->square->rank)>1)&&(($ending_square->file>=0)&&($ending_square->file<=9)))			
			))
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
						if(((strpos($piece->group,"ROYAL")==FALSE))&&($board->gametype==1)&&(
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

						

					//CASTLE to WAR  Defective ???
					if((($piece->group=="ROYAL"))&&
					(((($ending_square->rank>0)&&($ending_square->rank<9))&&(($ending_square->file>=0)&&($ending_square->file<=9)))&&		
					((($piece->square->rank==0)||($piece->square->rank==9))&&(($piece->square->file>0)&&($piece->square->file<9)))	
					))
					{
						$new_move = new ChessMove(
							$piece->square,
							$ending_square,
							1,					
							$piece->color,
							$piece->type,
							$capture,
							$board,
							$store_board_in_moves,
							FALSE
						);
	
						$move2 = clone $new_move;
							//check if the king is killed
							if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
							$move2->set_killed_king(TRUE);	

						if(( $piece->type == ChessPiece::KING)){
							$move2-> set_promotion_piece(3);
							$moves[] = $move2;
							$move3 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);								
							$move3-> set_promotion_piece(4);
							$moves[] = $move3;
						}
						elseif(( $piece->type == ChessPiece::ARTHSHASTRI)){
							$moves[] = $move2;
							$move2-> set_promotion_piece(6);
						}
						elseif( $piece->type == ChessPiece::ANGRYARTHSHASTRI){
							$moves[] = $move2;
						}
						elseif(( $piece->type == ChessPiece::ANGRYKING)){ 
							$moves[] = $move2;
							$move3 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);								
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);								
							$move3-> set_promotion_piece(4);
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
						$new_move = new ChessMove(
							$piece->square,
							$ending_square,
							1,					
							$piece->color,
							$piece->type,
							$capture,
							$board,
							$store_board_in_moves,
							FALSE
						);
	
						$move2 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);							
						if(($ending_square->file<4)||($ending_square->file>5)){
							if($piece->type == ChessPiece::ARTHSHASTRI)
								$move2-> set_promotion_piece(6);
							else	
							if($piece->type == ChessPiece::KING){
								$move2-> set_promotion_piece(3);
								$moves[] = $move2;
								$move3 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);									
								$move3-> set_promotion_piece(4);
								$moves[] = $move3;
								}
							elseif(( $piece->type == ChessPiece::ANGRYKING)){ 
								$moves[] = $move2;
								$move3 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);									
								$move3-> set_promotion_piece(4);
								$moves[] = $move3;
								}									
							$moves[] = $move2;
						}
						if(($ending_square->file==4)||($ending_square->file==5)){
							if(( $piece->type == ChessPiece::ANGRYKING)){ 
								$move2-> set_promotion_piece(1);
								$moves[] = $move2;
								$move3 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);									
								$move3-> set_promotion_piece(2);
								$moves[] = $move3;
								}
							elseif(( $piece->type == ChessPiece::ANGRYARTHSHASTRI)){ 
									$move2-> set_promotion_piece(5);
									$moves[] = $move2;
									}
							}
							continue;
					}					
					//WAR to CASTLE (non-Scepter) or to No mans
					elseif((($piece->group=="ROYAL"))&&
					(((($piece->square->rank>0)&&($piece->square->rank<9))&&(($ending_square->rank==0)||($ending_square->rank==9))&&(($ending_square->file<4)||($ending_square->file>5)))
					))
					{
						//$moves-> set_promotion_piece(2);
						$new_move = new ChessMove(
							$piece->square,
							$ending_square,
							1,					
							$piece->color,
							$piece->type,
							$capture,
							$board,
							$store_board_in_moves,
							FALSE
						);
	
						$move2 = clone $new_move;
							//check if the king is killed
							if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
							$move2->set_killed_king(TRUE);	
						if(( $piece->type == ChessPiece::ANGRYINVERTEDKING)&&( $piece->type != ChessPiece::ANGRYARTHSHASTRI)&&( $piece->type != ChessPiece::ARTHSHASTRI)&&( $piece->type != ChessPiece::SPY)){
							//$move2-> set_demotion_piece($piece->type+$dem);
							$move2-> set_promotion_piece(3);
						}
						else
						if(( $piece->type != ChessPiece::ANGRYKING)&&( $piece->type != ChessPiece::ANGRYINVERTEDKING)&&( $piece->type == ChessPiece::ANGRYARTHSHASTRI)&&( $piece->type != ChessPiece::SPY)){
							//$move2-> set_demotion_piece($piece->type+$dem);
							$move2-> set_promotion_piece(6);
						}						
						$moves[] = $move2;
						$move3 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);							
						if(( $piece->type == ChessPiece::ANGRYKING)&&( $piece->type != ChessPiece::ANGRYARTHSHASTRI)&&( $piece->type != ChessPiece::ARTHSHASTRI)&&( $piece->type != ChessPiece::SPY)){
								$move3-> set_promotion_piece(4);
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
						$new_move = new ChessMove(
							$piece->square,
							$ending_square,
							1,
							$piece->color,
							$piece->type,
							$capture,
							$board,
							$store_board_in_moves,
							FALSE
						);
	
							$move2 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);	

							if((( $piece->type == ChessPiece::ANGRYKING))&&
							(((($piece->square->rank==0)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file==4) ||($ending_square->file==5))&&
							($color_to_move==1))||(($piece->square->rank==9)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file==4)||($ending_square->file==5))&&($color_to_move==2)	)))
							){
								$move2-> set_promotion_piece(1);
								$moves[] = $move2;
								$move3 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);									
								$move3-> set_promotion_piece(2);
								$moves[] = $move3;
							}
							else							
							if((( $piece->type == ChessPiece::ANGRYKING)||( $piece->type == ChessPiece::ANGRYINVERTEDKING))&&
							((($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0) && ($piece->square->file<9))&&
							(($ending_square->file==4) ||($ending_square->file==5))&&((($ending_square->rank==0)&&($color_to_move==1))||(($ending_square->rank==9)&&($color_to_move==2))))
							){
								$move2-> set_promotion_piece(1);
								$moves[] = $move2;
								$move3 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);									
								$move3-> set_promotion_piece(2);
								$moves[] = $move3;
							}
							else
							if(( $piece->type == ChessPiece::ANGRYARTHSHASTRI)&&
							(((($piece->square->rank==0)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file==4) ||($ending_square->file==5))&&
							($color_to_move==1))||(($piece->square->rank==9)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file==4)||($ending_square->file==5))&&($color_to_move==2)	)))
							){
								$move2-> set_promotion_piece(5);
								$moves[] = $move2;
							}
							else
							if(( $piece->type == ChessPiece::ANGRYARTHSHASTRI)&&
							((($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0) && ($piece->square->file<9))&&
							(($ending_square->file==4) ||($ending_square->file==5))&&((($ending_square->rank==0)&&($color_to_move==1))||(($ending_square->rank==9)&&($color_to_move==2))))
							){
								$move2-> set_promotion_piece(5);
								$moves[] = $move2;
							}
							continue;
					}
					/* from CASTLE to non Scepters but within won CASTLE */					
					elseif(($piece->group=="ROYAL")&&((((($piece->square->rank==0)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file!=4) && ($ending_square->file!=5))&&($color_to_move==1)
					)||(($piece->square->rank==9)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file!=4)&&($ending_square->file!=5))&&($color_to_move==2)
					)))
					)){
						//$moves-> set_promotion_piece(2);
						$new_move = new ChessMove(
							$piece->square,
							$ending_square,
							1,
							$piece->color,
							$piece->type,
							$capture,
							$board,
							$store_board_in_moves,
							FALSE
						);
	
							$move2 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);	
							if(( $piece->type == ChessPiece::KING)&&
							(((($piece->square->rank==0)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file!=4) &&($ending_square->file!=5))&&
							($color_to_move==1))||(($piece->square->rank==9)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file!=4)&&($ending_square->file!=5))&&($color_to_move==2)	)))
							){
								$move2-> set_promotion_piece(3);
								$moves[] = $move2;
								$move3 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);									
								$move3-> set_promotion_piece(4);
								$moves[] = $move3;
							}
							else
							if(( $piece->type == ChessPiece::ANGRYKING)&&
							(((($piece->square->rank==0)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file!=4) &&($ending_square->file!=5))&&
							($color_to_move==1))||(($piece->square->rank==9)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file!=4)&&($ending_square->file!=5))&&($color_to_move==2)	)))
							){
								$moves[] = $move2;
								$move3 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);									
								$move3-> set_promotion_piece(4);
								$moves[] = $move3;
							}
							else
							if((( $piece->type == ChessPiece::ARTHSHASTRI)||( $piece->type == ChessPiece::ANGRYARTHSHASTRI))&&
							(((($piece->square->rank==0)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file!=4) &&($ending_square->file!=5))&&
							($color_to_move==1))||(($piece->square->rank==9)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file!=4)&&($ending_square->file!=5))&&($color_to_move==2)	)))
							){
								$move2-> set_promotion_piece(6);
								$moves[] = $move2;
							}
							continue;
					}	
					/* From Truce */									
					elseif(($piece->group=="ROYAL")&&(($piece->type == ChessPiece::ANGRYKING)||  ( $piece->type == ChessPiece::ANGRYARTHSHASTRI) )&&
					((($piece->square->rank>0)&&($piece->square->rank<9)&&(($piece->square->file==0) || ($piece->square->file==9)))||
						(($piece->square->file>=0)&&($piece->square->file<=9)&&(($piece->square->rank==0) || ($piece->square->rank==9))&&($ending_square->rank!=$piece->square->rank))||
						(($piece->square->file>=0)&&($piece->square->file<=9)&&(($piece->square->rank==0) || ($piece->square->rank==9))&&($ending_square->rank==$piece->square->rank)&&
						(($ending_square->file<4)||($ending_square->file>5)))
						))
					{
						$new_move = new ChessMove(
							$piece->square,
							$ending_square,
							1,					
							$piece->color,
							$piece->type,
							$capture,
							$board,
							$store_board_in_moves,
							FALSE
						);
	
	
						$move3 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);							
						if(( $piece->type == ChessPiece::ANGRYKING)&&( $piece->type != ChessPiece::ANGRYARTHSHASTRI)){												
								$move3-> set_promotion_piece(4);
							}

							if(( $piece->type != ChessPiece::ANGRYKING)&&( $piece->type == ChessPiece::ANGRYARTHSHASTRI)){												
								$move3-> set_promotion_piece(6);
							}		

						$moves[] = $move3;
					}
					//WAR To CASTLE movement
					elseif((strpos($piece->group,"ROYAL")!==FALSE) && ($royalp)&&($ending_square->file>0)&&($ending_square->file<9)&&(($ending_square->rank==0)||($ending_square->rank==9))){
						if ( $board->board[$ending_square->rank][$ending_square->file] ==null) {
							if(($piece->type == ChessPiece::SPY)||($piece->type == ChessPiece::ANGRYKING)||( $piece->type == ChessPiece::ANGRYINVERTEDKING)||($piece->type == ChessPiece::ANGRYARTHSHASTRI)||( $piece->type == ChessPiece::ARTHSHASTRI)){
								if(($ending_square->rank==0)||($ending_square->rank==9)){
									if(/*($foebrokencastle==true)&&*/($piece->square->rank<=9)&&($color_to_move==1))
									{ 
					
										$new_move = new ChessMove(
										$piece->square,
										$ending_square,
										0,					
										$piece->color,
										$piece->type,
										$capture,
										$board,
										$store_board_in_moves,
										FALSE
										);
										$move2 = clone $new_move;
										//check if the king is killed
										if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
											$move2->set_killed_king(TRUE);										
											//doublepromotion of spy logic
										if(($color_to_move==1)&&($ending_square->rank==9)&&($piece->group=="SEMIROYAL")){
											$canpromote=false;	
											$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,12);

											if($canpromote==TRUE){
												$move2 = clone $new_move;
												//check if the king is killed
												if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
													$move2->set_killed_king(TRUE);										
												$move2-> set_promotion_piece(12);
												$moves[] = $move2;
											}
							
											$canpromote=false;	
											$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,11);

											if($canpromote==TRUE){
												$move3 = clone $new_move;
												//check if the king is killed
												if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
													$move3->set_killed_king(TRUE);										
												$move3-> set_promotion_piece(11);
												$moves[] = $move3;
											}

											if((($foebrokencastle==true)&&((($ending_square->rank==9)&&($color_to_move==1))||(($ending_square->rank==0)&&($color_to_move==2)))) &&(($ending_square->file==4)||($ending_square->file==5)))
												{ 
												continue;
												}									
											$move1 = clone $new_move;
											//check if the king is killed
											if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
												$move1->set_killed_king(TRUE);									
											$moves[] = $move1;									
											continue;	
											}
										elseif(($color_to_move==1)&&($ending_square->rank==9)){
											if(($piece->type == ChessPiece::ANGRYARTHSHASTRI)||( $piece->type == ChessPiece::ARTHSHASTRI))
												$move2-> set_promotion_piece(50);
											else
												$move2-> set_promotion_piece(100);
											}
											$moves[] = $move2;
											continue;
									}
									else
									if(	/*($foebrokencastle==true)&&*/($piece->square->rank>=0)&&($color_to_move==2))
										{
										
												$new_move = new ChessMove(
													$piece->square,
													$ending_square,
													0,					
													$piece->color,
													$piece->type,
													$capture,
													$board,
													$store_board_in_moves,
													FALSE
												);

										//doublepromotion of spy logic
										$move2 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);	
										if(($piece->group=="SEMIROYAL")&&($color_to_move==2)&&($ending_square->rank==0)){
											$canpromote=false;	
											$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,12);
			
											if($canpromote==TRUE){
												$move2 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);													
												$move2-> set_promotion_piece(12);
												$moves[] = $move2;
												}
										
											$canpromote=false;	
											$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,11);
			
											if($canpromote==TRUE){
												$move3 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);													
								$move3-> set_promotion_piece(11);
												$moves[] = $move3;
												}
			
											if((($foebrokencastle==true)&&((($ending_square->rank==9)&&($color_to_move==1))||(($ending_square->rank==0)&&($color_to_move==2)))) &&(($ending_square->file==4)||($ending_square->file==5)))
												{ 
												continue;
												}									
											$move1 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move1->set_killed_king(TRUE);												
											$moves[] = $move1;									
											continue;	
											}
											else if(($color_to_move==2)&&($ending_square->rank==0)){
												if(($piece->type == ChessPiece::ANGRYARTHSHASTRI)||( $piece->type == ChessPiece::ARTHSHASTRI))
													$move2-> set_promotion_piece(50);
												else
													$move2-> set_promotion_piece(100);
												}
											
												$moves[] = $move2;
												continue;
									}
									else 
										continue; /** Cannot get inside CASTLE piece */
								}
							}
						}
						else { 	continue;	}
					}
					//WAR To WAR movement
					elseif(($piece->group=="ROYAL") && ($royalp)&&(($piece->square->file>0)&&($piece->square->file<9)&&(($piece->square->rank>=1)&&($piece->square->rank<=8))
					&&(($ending_square->file>0)&&($ending_square->file<9)&&($ending_square->rank>=1)&&($ending_square->rank<=8)))){
						//endblock has no data or blank
						if ( $board->board[$ending_square->rank][$ending_square->file] ==null) {
												$new_move = new ChessMove(
													$piece->square,
													$ending_square,
													0,					
													$piece->color,
													$piece->type,
													$capture,
													$board,
													$store_board_in_moves,
													FALSE
												);

										$move2 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);											

												if(($piece->type == ChessPiece::ANGRYARTHSHASTRI))
													$moves[] = $move2;
												elseif(($piece->type == ChessPiece::ANGRYKING))
												{
													$moves[] = $move2;
													$move2 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);														
													$move2-> set_promotion_piece(4);
													$moves[] = $move2;
												}
												elseif(($piece->type == ChessPiece::ANGRYINVERTEDKING))
												{
													$moves[] = $move2;
													$move2 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);														
													$move2-> set_promotion_piece(3);	
													$moves[] = $move2;
												}												
												continue;

						}
						else { 	continue;	}
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
					elseif(((strpos($piece->group,"ROYAL")!==FALSE) &&($royalp))&&( //Castle to WAR ZONE
						(($ending_square->rank<$piece->square->rank)&&($ending_square->rank==8)&&($piece->square->file>0)&&($piece->square->file<9)&&($ending_square->file>0)&&($ending_square->file<9))||
					(($ending_square->rank>$piece->square->rank)&&($ending_square->rank==1)&&($piece->square->file>0)&&($piece->square->file<9)&&($ending_square->file>0)&&($ending_square->file<9))||
					(($ending_square->rank==$piece->square->rank)&&($ending_square->rank>=8)&&($piece->square->file>0)&&($piece->square->file<9)&&($ending_square->file>0)&&($ending_square->file<9))
					)){
						$booljump=TRUE;
					}
					elseif(((strpos($piece->group,"ROYAL")!==FALSE) &&($royalp))&&( //Castle to Truce
						(($ending_square->rank>$piece->square->rank)&&($ending_square->rank==1)&&($piece->square->file>1)&&($piece->square->file<8)&&($ending_square->file==0)&&($ending_square->file<9))||
						(($ending_square->rank==$piece->square->rank)&&($ending_square->rank>=8)&&($piece->square->file>1)&&($piece->square->file<8)&&($ending_square->file==0)&&($ending_square->file<9))||
						(($ending_square->rank>$piece->square->rank)&&($ending_square->rank==1)&&($piece->square->file>1)&&($piece->square->file<8)&&($ending_square->file==9)&&($ending_square->file>0))||
						(($ending_square->rank==$piece->square->rank)&&($ending_square->rank>=8)&&($piece->square->file>1)&&($piece->square->file<8)&&($ending_square->file==9)&&($ending_square->file>0))
						)){
							$booljump=TRUE;
						}
					elseif(strpos($piece->group,"ROYAL")==FALSE)	{
						if($piece->group=="OFFICER"){
							if(($ending_square->file!=0)&&($ending_square->file!=9)&&(($ending_square->rank==0)||($ending_square->rank==9))){
								//if castle compromised then can jump else not. Compromised castle does need Royal push
								if(((($selfbrokencastle==true)&&($piece->square->rank>=0)&&($color_to_move==1) && ($ending_square->rank==0))||
								(($foebrokencastle==true)&&($piece->square->rank<=9)&&($color_to_move==1) && ($ending_square->rank==9))) || 
								((($selfbrokencastle==true)&&($piece->square->rank<=9)&&($color_to_move==2)&& ($ending_square->rank==9))||
								(($foebrokencastle==true)&&($piece->square->rank>=0)&&($color_to_move==2)&& ($ending_square->rank==0))))
								{ /*
									* CASTLE has become warzone
									*/
									$new_move = new ChessMove(
										$piece->square,
										$ending_square,
										0,					
										$piece->color,
										$piece->type,
										$capture,
										$board,
										$store_board_in_moves,
										FALSE
										);
			
									$move2 = clone $new_move;
									$moves[] = $move2;
									continue;
			
								}
								//1= Self CASTLE.. 0 = Foe CASTLE and can be jumped by Officers without royals or General.
								elseif((($get_CASTLEMover==1)&&($piece->square->rank==0)&&($color_to_move==1))||
								(($get_CASTLEMover==1)&&($piece->square->rank==9)&&($color_to_move==2)))
								{ /*
									* CASTLE has become warzone
									*/
									$new_move = new ChessMove(
										$piece->square,
										$ending_square,
										0,					
										$piece->color,
										$piece->type,
										$capture,
										$board,
										$store_board_in_moves,
										FALSE
										);
			
									$move2 = clone $new_move;
									$moves[] = $move2;
									continue;
								}
								//if the ending square has blank value in castle
								elseif(($piece->group=="OFFICER") &&($board->board[$ending_square->rank][$ending_square->file]==null)&&((($piece->square->rank>0)&&($piece->square->rank<9))&&(($ending_square->file>=0)||($ending_square->file<=9))&&(
									(($ending_square->rank==0)||($ending_square->rank==9))) && (($officer_royalp==true)&&($board->gametype==1)) && ($piece->type==ChessPiece::GENERAL) )){ /* Classical General can penetrate the CASTLE. */
				
										$new_move = new ChessMove(
											$piece->square,
											$ending_square,
											0,					
											$piece->color,
											$piece->type,
											$capture,
											$board,
											$store_board_in_moves,
											FALSE
											);
				
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
								$new_move = new ChessMove(
									$piece->square,
									$ending_square,
									0,					
									$piece->color,
									$piece->type,
									$capture,
									$board,
									$store_board_in_moves,
									FALSE
								);

									$move2 = clone $new_move;
							//check if the king is killed
							if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);										
									//$move2-> set_promotion_piece(25);
									$moves[] = $move2;
									continue;
							}

							if($piece->type!=9) //Piece is Knight can be promoted as Rook
							$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,10);
							else
							$canpromote=false;

							$ksqr=$board->get_king_square($color_to_move);
							if($ksqr==null) continue;	
							//If King is holding scepter then no Capture Allowed
							if(($capture==TRUE)&&($cankill!=0)&&
							(($board->get_king_square($color_to_move)->rank==0)&&($board->get_king_square($color_to_move)->file==4)&&($color_to_move==1)
							||($board->get_king_square($color_to_move)->rank==9)&&($board->get_king_square($color_to_move)->file==5)&&($color_to_move==2)))
							{
								continue;
							}

							//non general can be promoted.
							if($canpromote==TRUE){// then update the parity with new demoted values
							//$piece->type=$piece->type+1;
				
								$new_move = new ChessMove(
									$piece->square,
									$ending_square,
									0,					
									$piece->color,
									$piece->type,
									$capture,
									$board,
									$store_board_in_moves,
									FALSE
								);

									$move2 = clone $new_move;
							//check if the king is killed
							if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);										
									if($officer_royalp==TRUE)
										$move2-> set_promotion_piece(10);

									//check if the king is killed
									if(($capture==TRUE)&&( ($board->get_king_square(abs(3-$color_to_move))->rank==$ending_square->rank) &&($board->get_king_square(3-$color_to_move)->file==$ending_square->file)))
										$move2->set_killed_king(TRUE);

									$moves[] = $move2;
									//return $moves; Dont Return but add more moves									
							}
						}
					
					//classical does not allow the movement of non-officers or non-royals to truce or no mans
					if((($piece->group=="OFFICER") &&($piece->type!=="GENERAL") ||($piece->group=="SOLDIER"))&& (($ending_square->file==0)||($ending_square->file==9))&&(
							$board->gametype==1))
							{
								continue;
							}						
						
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

						$cankill=0;  //Cannot kill from CASTLE to external place
	
						$candemote=$board->checkdemotionparity( $board->export_fen(), $piece,$color_to_move,$board);
	
						if($candemote==TRUE){// then update the parity with new demoted values
						//$piece->type=$piece->type+1;
			
							$new_move = new ChessMove(
								$piece->square,
								$ending_square,
								0,					
								$piece->color,
								$piece->type,
								$capture,
								$board,
								$store_board_in_moves,
								FALSE
							);

								$move2 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);									
								if($officer_royalp==FALSE)
									$move2-> set_demotion_piece($piece->type+$dem);
								$moves[] = $move2;
								continue; //Demotion moves only...Dont Return but add more moves
						}
					}
				elseif(($piece->group=="OFFICER") &&(($ending_square->file==0)||($ending_square->file==9))&&(
					(($ending_square->rank>=0)&&($ending_square->rank<=9))&&($get_CASTLEMover!=1)
					)&&($board->gametype==2)){ // Check of demotion can happen as per Kautilya
							if($officer_royalp==TRUE) {$dem=0;}
							else {$dem=1;}
		
							if((($officer_royalp==TRUE)&&($board->gametype==2))||($board->gametype==1)) {$dem=0;}// Kautilya allows the demotion but Classical had no demotion
							elseif($board->gametype==2) {$dem=1;}
	
							if((($officer_royalp==TRUE)&&($board->gametype==1))  && ($piece->type!=ChessPiece::GENERAL)) 
								{continue;}// Classical does not allow non-Generals to truce

							$candemote=$board->checkdemotionparity( $board->export_fen(), $piece,$color_to_move,$board);
		
							if($candemote==TRUE){// then update the parity with new demoted values
							//$piece->type=$piece->type+1;
				
								$new_move = new ChessMove(
									$piece->square,
									$ending_square,
									0,					
									$piece->color,
									$piece->type,
									$capture,
									$board,
									$store_board_in_moves,
									FALSE
								);

									$move2 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);										
									if($officer_royalp==FALSE)
										$move2-> set_demotion_piece($piece->type+$dem);
									$moves[] = $move2;
									continue; //Demotion moves only...Dont Return but add more moves
							}
					}
				$ksqr=$board->get_king_square($color_to_move);
				if($ksqr==null) continue;
				//If King is holding scepter then no Capture Allowed
				if(($capture==TRUE)&&($cankill==1)&&
				(($board->get_king_square($color_to_move)->rank==0)&&($board->get_king_square($color_to_move)->file==4)&&($color_to_move==1)
				||($board->get_king_square($color_to_move)->rank==9)&&($board->get_king_square($color_to_move)->file==5)&&($color_to_move==2)))
				{
					continue;
				}
				
				if(($cankill==0) &&($capture)){ // Knight logic is required to check the surrounding resource from P to S
					continue;
				}

				//WAR to CASTLE ZONE But not to Sceptres
				if(($piece->group=="ROYAL")&&(( ($piece->type == ChessPiece::ANGRYKING)||( $piece->type == ChessPiece::ANGRYINVERTEDKING))&&
				(((($piece->square->rank>0)&&($piece->square->rank<9))&&(($ending_square->rank==0)||($ending_square->rank==9)))&&(($ending_square->file<4)||($ending_square->file>5))||		
				((($piece->square->rank>0)&&($piece->square->rank<9))&&(($ending_square->rank>0)&&($ending_square->rank<9)))&&(($ending_square->file>=0)&&($ending_square->file<=9))
				)))
				{
					//$moves-> set_promotion_piece(2);
					$new_move = new ChessMove(
						$piece->square,
						$ending_square,
						1,					
						$piece->color,
						$piece->type,
						$capture,
						$board,
						$store_board_in_moves,
						FALSE
					);

					$move2 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);	
					if(( $piece->type != ChessPiece::ANGRYKING)){
						//$move2-> set_demotion_piece($piece->type+$dem);
						$move2-> set_promotion_piece(3);
					}
						$moves[] = $move2;
						$move3 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);	
						if(( $piece->type != ChessPiece::ANGRYINVERTEDKING)){
							$move3-> set_promotion_piece(4);
						}
						$moves[] = $move3;
				}
				//CASTLE too CASTLE or CASTLE to WAR
				elseif(($piece->group=="ROYAL")&&(( $piece->type == ChessPiece::ANGRYKING)&&
				(((($piece->square->rank==0)||($piece->square->rank==9))&&($ending_square->rank!=$piece->square->rank))||
				((($piece->square->rank==0)||($piece->square->rank==9))&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file==0)||($ending_square->file==9)))				
				)))
				{
					//$moves-> set_promotion_piece(2);
					$new_move = new ChessMove(
						$piece->square,
						$ending_square,
						1,					
						$piece->color,
						$piece->type,
						$capture,
						$board,
						$store_board_in_moves,
						FALSE
					);

					$move2 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);	
					if(( $piece->type != ChessPiece::ANGRYKING)){
						//$move2-> set_demotion_piece($piece->type+$dem);
						$move2-> set_promotion_piece(3);
					}
						$moves[] = $move2;
						$move3 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);							
						if(( $piece->type != ChessPiece::ANGRYINVERTEDKING)){												
							$move3-> set_promotion_piece(4);
						}
						$moves[] = $move3;
				}
				//CASTLE to No Mans = TRuce ... KING movement not covered....
				elseif(($piece->group=="ROYAL")&&((( $piece->type == ChessPiece::ANGRYKING)&&
				((($piece->square->rank==0)&&(($ending_square->file==4) ||($ending_square->file==5))&&($color_to_move==1)
				)||(($piece->square->rank==9)&&($ending_square->rank==$piece->square->rank)&&(($ending_square->file==4)||($ending_square->file==5))&&($color_to_move==2)
				))) || /*CASTLE KING becoming full king*/	
				(( $piece->type == ChessPiece::ANGRYKING)&&
				(($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0) && ($piece->square->file<9))&&
				(($ending_square->file==4) ||($ending_square->file==5))&&(($ending_square->rank==0)||($ending_square->rank==9)))					
				)){
					//$moves-> set_promotion_piece(2);
					$new_move = new ChessMove(
						$piece->square,
						$ending_square,
						1,
						$piece->color,
						$piece->type,
						$capture,
						$board,
						$store_board_in_moves,
						FALSE
					);

						$move2 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);							
						//$move2-> set_demotion_piece($piece->type+$dem);
						$move2-> set_promotion_piece(1);
					
						$moves[] = $move2;					
						$move3 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);							
						$move3-> set_promotion_piece(2);
						$moves[] = $move3;

				}
				elseif(($piece->group=="ROYAL")&&($piece->type == ChessPiece::ANGRYKING)&&
				(($piece->square->rank>0)&&($piece->square->rank<9)&&(($piece->square->file==0) || ($piece->square->file==9))))
				{
					$new_move = new ChessMove(
						$piece->square,
						$ending_square,
						1,					
						$piece->color,
						$piece->type,
						$capture,
						$board,
						$store_board_in_moves,
						FALSE
					);

						$moves[] = $move2;					
						$move3 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);							
						if(( $piece->type != ChessPiece::ANGRYINVERTEDKING)){												
							$move3-> set_promotion_piece(4);
						}
						$moves[] = $move3;
				}
				elseif(($piece->group=="ROYAL")&&((( $piece->type == ChessPiece::KING)&&
				((($piece->square->rank==0)&&(($piece->square->file==4) ||($piece->square->file==5))&&($color_to_move==1)
				)||(($piece->square->rank==9)&&(($piece->square->file==4)||($piece->square->file==5))&&($color_to_move==2)
				)))|| (( $piece->type == ChessPiece::ANGRYKING)&&
				(($piece->square->rank>0)&&($piece->square->rank<9)&&($piece->square->file>0) && ($piece->square->file<9)))	
				)){
					//$moves-> set_promotion_piece(2);
					$new_move = new ChessMove(
						$piece->square,
						$ending_square,
						1,					
						$piece->color,
						$piece->type,
						$capture,
						$board,
						$store_board_in_moves,
						FALSE
					);

					if(( $piece->type == ChessPiece::KING)){

						$move2 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);							
						//$move2-> set_demotion_piece($piece->type+$dem);
						$move2-> set_promotion_piece(3);
					}
						$moves[] = $move2;
						$move3 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);							
						if(( $piece->type != ChessPiece::ANGRYINVERTEDKING)){												
							$move3-> set_promotion_piece(4);
						}
						$moves[] = $move3;

				}
				else
				{
                   $new_move1 = new ChessMove(
                        $piece->square,
                        $ending_square,
                        -1,
                        $piece->color,
                        $piece->type,
                        $capture,
                        $board,
                        $store_board_in_moves,
                        false
                    );

					$move2 = clone $new_move1;

						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);	
					$moves[] = 	$move2;				
                }

				if(($piece->group=="SEMIROYAL")&&((($ending_square->rank>=8)&&(($ending_square->file>0)&&($ending_square->file<9))&&($color_to_move==1))||
					(($ending_square->rank<=1)&&(($ending_square->file>0)&&($ending_square->file<9))&&($color_to_move==2))
					))
					{	
						$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,12);
		
						if((($ending_square->rank==1)&&($color_to_move==2))||(($ending_square->rank==8)&&($color_to_move==1))){
							if($canpromote==TRUE){// then update the parity with new ptomoted values
								//$piece->type=$piece->type+1;
								//Force Promotion to add in movelist	
								$new_move1 = new ChessMove(
									$piece->square,
									$ending_square,
									0,					
									$piece->color,
									$piece->type,
									$capture,
									$board,
									$store_board_in_moves,
									FALSE
									);
		
								$move3 = clone $new_move1;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);									
								$move3-> set_promotion_piece(12);
								$moves[] = $move3;
							}
						}

						if((($ending_square->rank==0)&&($color_to_move==2))||(($ending_square->rank==9)&&($color_to_move==1))){
		
							$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,11);
		
							if($canpromote==TRUE){// then update the parity with new ptomoted values
								//$piece->type=$piece->type+1;
								//Force Promotion to add in movelist	
								$new_move1 = new ChessMove(
									$piece->square,
									$ending_square,
									0,					
									$piece->color,
									$piece->type,
									$capture,
									$board,
									$store_board_in_moves,
									FALSE
									);
		
								$canpromote=false;	
								$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,12);

								if($canpromote==TRUE){
									$move2 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move2->set_killed_king(TRUE);										
									$move2-> set_promotion_piece(12);
									$moves[] = $move2;
									}
							
								$canpromote=false;	
								$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,11);

								if($canpromote==TRUE){
									$move3 = clone $new_move;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);										$move3-> set_promotion_piece(11);
									$moves[] = $move3;
									}

								if((($foebrokencastle==true)&&((($ending_square->rank==9)&&($color_to_move==1))||(($ending_square->rank==0)&&($color_to_move==2)))) &&(($ending_square->file==4)||($ending_square->file==5)))
									{ 
									continue;
									}									
								$move1 = clone $new_move;
								$moves[] = $move1;									
								continue;
							}
						}
					}
				//***  Process it at th end only */	

				if(($piece->group=="OFFICER")&&($piece->square->file>0)&&($piece->square->file<9)){ // Check of promotion can happen except TZ
					$skipxy=$piece->square;

					$droyalp=self::has_royal_neighbours( 
					self::KING_DIRECTIONS,
					$skipxy,
					$ending_square,
					$color_to_move,
					$board
					);

						if($droyalp==TRUE)
						{ // Check of demotion can happen
							$dem=-1;

							$canpromote=$board->checkpromotionparity( $board->export_fen(), $piece,$color_to_move,$board,$piece->type-1);

							if($canpromote==TRUE){// then update the parity with new demoted values
								//$piece->type=$piece->type+1;
								//Force Promotion to add in movelist	
								$new_move1 = new ChessMove(
									$piece->square,
									$ending_square,
									0,					
									$piece->color,
									$piece->type,
									$capture,
									$board,
									$store_board_in_moves,
									FALSE
									);

								$move3 = clone $new_move1;
						//check if the king is killed
						if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
								$move3->set_killed_king(TRUE);									
								$move3-> set_promotion_piece($piece->type+$dem);

								//check if the king is killed
								if(($capture==TRUE)&&( ($board->get_king_square(abs($color_to_move-3))->rank==$ending_square->rank) &&($board->get_king_square($color_to_move)->file==$ending_square->file)))
										$move3->set_killed_king(TRUE);								
								
								$moves[] = $move3;
							}
						}
				}
            }
		}
		}
    	}
		return $moves;
	}

	static function mark_checks_and_checkmates(array $moves, $color_to_move): void {
		//**echo '<li> ChessRuleBook.php #8 function mark_checks_and_checkmates called </li>';	
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
		//**echo '<li> ChessRuleBook.php #9 function eliminate_king_in_check_moves called </li>';	

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
		//**echo '<li> ChessRuleBook.php #10 function get_all_pieces_by_color called </li>';	

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
	
	// positive X = east, negative X = west, positive Y = north, negative Y = south
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
		//**echo '<li> ChessRuleBook.php #11 function square_exists_and_not_occupied_by_friendly_piece called </li>';	
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

		if( (($selfbrokencastle==true)&&( $starting_square->rank==9)&&($ending_square->rank<8)&&($color_to_move==2)||
		($foebrokencastle==true)&&($ending_square->rank>1)&&($starting_square->rank==0)&&($color_to_move==2))||  
		(($selfbrokencastle==true)&&( $starting_square->rank==0)&&($ending_square->rank>1)&&($color_to_move==1)||
		($foebrokencastle==true)&&($ending_square->rank<8)&&($starting_square->rank==9)&&($color_to_move==1)))
		{
			return null;
		}	
		if( ((($selfbrokencastle==true)&&( $starting_square->rank==9)&&($ending_square->rank>=8)&&($color_to_move==2)||
		($foebrokencastle==true)&&($ending_square->rank<=1)&&($starting_square->rank==0)&&($color_to_move==2))||  
		(($selfbrokencastle==true)&&( $starting_square->rank==0)&&($ending_square->rank<=1)&&($color_to_move==1)||
		($foebrokencastle==true)&&($ending_square->rank>=8)&&($starting_square->rank==9)&&($color_to_move==1)))  )
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
					elseif ($jumpflag=='2') {
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
					if(  $intermediate_square->rank!=$starting_square->rank ){
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
						if($ending_square->rank!=$intermediate_square->rank){
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
		else //should Fix the issue for General also
		if((($selfbrokencastle==true)&&($ending_square->rank==0)&&($color_to_move==1)||
		($foebrokencastle==true)&&($ending_square->rank==9)&&($color_to_move==1)) ||(($selfbrokencastle==true)&&($ending_square->rank==9)&&($color_to_move==2)||
		($foebrokencastle==true)&&($ending_square->rank==0)&&($color_to_move==2))  
		||   (($ending_square->file>0)&&($ending_square->file<9)&&(($ending_square->rank==9)||($ending_square->rank==0))&&($starting_square->rank>1)&&($starting_square->rank<9)&&($color_to_move==1)&&($board->gametype==1)))

		{ /*
			* Enter into CASTLE as it has become warzone
			*/
			if($type==0) {
                $intermediate_square=$ending_square;
						//$diagonal jump
						if ((($starting_square->rank)-($ending_square->rank)>=2)&&(($starting_square->file)-($ending_square->file)>=2)) {
							$yy=-1;  $xx=-1 ;
						}
						if ((($starting_square->rank)-($ending_square->rank)>=2)&&(($ending_square->file)-($starting_square->file)>=2)) {
							$yy=-1;  $xx=1 ;
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
					elseif ($jumpflag=='2') {
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
					elseif ($jumpflag=='2') {
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
		if(((($ending_square->rank==0)||($ending_square->rank==9))&&($starting_square->rank>=1)&&($starting_square->rank<=8))&&
		(($ending_square->file>0)&&($ending_square->file<9))&&($board->board[$starting_square->rank][$starting_square->file]->group=='OFFICER')){
			return null;// No Officers are allowed to penetrate the CASTLE if not compromised
		}
		else
		if(((($ending_square->rank==0)||($ending_square->rank==9))&&($starting_square->rank>=1)&&($starting_square->rank<=8))&&
		(($ending_square->file>0)&&($ending_square->file<9))&&($board->board[$starting_square->rank][$starting_square->file]->group=='SOLDIER')){
			return null;// No Soldiers are allowed to penetrate the CASTLE  if not compromised
		}
		else
		if(((($starting_square->file==0)||($starting_square->file==9))&&(($starting_square->rank==0)||($starting_square->rank==9))
		&&($board->board[$starting_square->rank][$starting_square->file]->group!='NOBLE'))){
			return null;// No-one can escape NoMans except RajRishi and Emperor
		}	
		
		$xx=0; $yy=0;
		
		if(($type>=1)&&(abs($x_delta)<2) &&(abs($y_delta)<2))
		{
		}
		else
		if ($type>=1){ //Horse
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
            elseif ($jumpflag=='2') {
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
				else
				if ( $board->board[$rank][$file]->color == $color_to_move ) {
					return null;
				}											
				else
				if ( abs($board->board[$rank][$file]->color - $color_to_move) ==1) {
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
			if ( $board->board[$rank][$file]->color == $color_to_move ) {
				//**echo ' Ending square contains a friendly piece ';
				return null;
			}
		}

		return $ending_square;
	}
	
	static function try_to_make_square_using_rank_and_file_num(int $rank, int $file): ?ChessSquare {
		//**echo '<li> ChessRuleBook.php #12 function try_to_make_square_using_rank_and_file_num called </li>';	

		if ( $rank >= 0 && $rank <=9  && $file >= 0 && $file <= 9 ) {
			return new ChessSquare($rank, $file);
		} else {
			return null;
		}
	}
	
	static function invert_color($color) {
		//Echo '<li> ChessRuleBook.php #13 function invert_color called </li>';	

		if ( $color == ChessPiece::WHITE ) {
			return ChessPiece::BLACK;
		} else {
			return ChessPiece::WHITE;
		}
	}
	
	// Used to generate en passant squares.
	static function get_squares_in_these_directions(
		ChessSquare $starting_square,
		array $directions_list,
		int $spaces
	): array {
		//**echo '<li> ChessRuleBook.php #14 function get_squares_in_these_directions called </li>';	
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
		//**echo '<li> ChessRuleBook.php #15 function square_is_attacked called </li>';	

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
		//**echo '<li> ChessRuleBook.php #16 function square_threatened_by_sliding_pieces called </li>';	

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
				if (( $piece->type == ChessPiece::KING )||( $piece->type == ChessPiece::ANGRYKING )) {
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
		//**echo '<li> ChessRuleBook.php #17 function square_threatened_by_jumping_pieces called </li>';	

		$mixingsquare='';
		//1 => array(2,1),
		//2 => array(1,2),
		//4 => array(-1,2),
		//5 => array(-2,1),
		//7 => array(-2,-1),
		//8 => array(-1,-2),
		//10 => array(1,-2),
		//11 => array(2,-1)
	
		//Y/	
		///4 * * * * *  
		///3 * * * * * 
		///2 * * * * *
		///1 * * K * *
		///0 * * * * *
		///X A B C D E 
		foreach ( self::KNIGHT_DIRECTIONS as $oclock ) {
			$current_xy = self::OCLOCK_OFFSETS[$oclock];
			$rank = $square_to_check->rank + $current_xy[0]; //Row 3+
			$file = $square_to_check->file + $current_xy[1];
			////**echo  '<br> Night = X '.$current_xy[0].'  Y = '.$current_xy[1].'  Calculated Rank '.$rank.'  Calculated File '.$file ;

			if ( ! self::square_is_on_board($rank, $file) ) {
				// Square is off the board. On to the next test square.
				continue;  // Check Next Square
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
			
			// If this code is reached, piece must be an enemy. No need to double check.
			
			if (( $piece->type == ChessPiece::KNIGHT ) ||( $piece->type == ChessPiece::GENERAL )) {  //If target piece is enemy and not threatening the opponent under R. Create a function.				
				//**echo '<br/> Final Knight Moved ='.$square_to_check->rank.' '.$square_to_check->file.'  '.$friendly_color;
				//**echo  '<br> Final Night = X '.$current_xy[0].'  Y = '.$current_xy[1].'  Calculated Rank '.$rank.'  Calculated File '.$file ;
				
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
		//**echo '<li> ChessRuleBook.php #18 function square_is_on_board called </li>';	

		if ( $rank >= 0 && $rank <= 9 && $file >= 0 && $file <= 9 ) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	static function get_piece(int $rank, int $file, ChessBoard $board): ?ChessPiece {
		//**echo '<li> ChessRuleBook.php #18 function get_piece called </li>';	

		if ( $board->board[$rank][$file] ) {
			return $board->board[$rank][$file];
		} else {
			return NULL;
		}
	}
}
