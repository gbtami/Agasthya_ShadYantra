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
		12 => array(0,2)				
		
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
	);
	const ROOK_DIRECTIONS = array(
		self::NORTH,
		self::SOUTH,
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
	const KNIGHT_DIRECTIONS = array(1, 2, 3,4, 5, 6,7, 8, 9,10, 11,12);
	const BLACK_PAWN_CAPTURE_DIRECTIONS = array(self::SOUTHEAST, self::SOUTHWEST);
	const BLACK_PAWN_MOVEMENT_DIRECTIONS = array(self::SOUTH);
	const WHITE_PAWN_CAPTURE_DIRECTIONS = array(self::NORTHEAST, self::NORTHWEST);
	const WHITE_PAWN_MOVEMENT_DIRECTIONS = array(self::NORTH);
	
	const PROMOTION_PIECES = array(
		ChessPiece::GENERAL,
		ChessPiece::ROOK,
		ChessPiece::BISHOP,
		ChessPiece::KNIGHT
	);
	
	const MAX_SLIDING_DISTANCE = 7;
	
	static function get_legal_moves_list(
		$color_to_move, // Color changes when we call recursively. Can't rely on $board for color.
		ChessBoard $board, // ChessBoard, not ChessBoard->board. We need the entire board in a couple of methods.
		bool $need_perfect_move_list = TRUE,
		bool $store_board_in_moves = TRUE,
		bool $need_perfect_notation = TRUE
	): array {
		$pieces_to_check = self::get_all_pieces_by_color($color_to_move, $board);
		
		$moves = array();
		
		// TODO: Iterate through all squares on chessboard, not all pieces. Then I won't need to
		// store each piece's ChessSquare, and I can get rid of that class completely.
		foreach ( $pieces_to_check as $piece ) {
			if ( $piece->type == ChessPiece::PAWN ) {
				if ( $piece->color == ChessPiece::WHITE ) {
						$moves = self::add_slide_moves_to_moves_list(self::WHITE_PAWN_MOVEMENT_DIRECTIONS, 1, $moves, $piece, $color_to_move, $board, $store_board_in_moves);
				
					$moves = self::add_capture_moves_to_moves_list(self::WHITE_PAWN_CAPTURE_DIRECTIONS, $moves, $piece, $color_to_move, $board, $store_board_in_moves);
				} elseif ( $piece->color == ChessPiece::BLACK ) {
						$moves = self::add_slide_moves_to_moves_list(self::BLACK_PAWN_MOVEMENT_DIRECTIONS, 1, $moves, $piece, $color_to_move, $board, $store_board_in_moves);
			
					$moves = self::add_capture_moves_to_moves_list(self::BLACK_PAWN_CAPTURE_DIRECTIONS, $moves, $piece, $color_to_move, $board, $store_board_in_moves);
				}
			} elseif ( $piece->type == ChessPiece::KNIGHT ) {
				$moves = self::add_jump_and_jumpcapture_moves_to_moves_list(self::KNIGHT_DIRECTIONS, $moves, $piece, $color_to_move, $board, $store_board_in_moves);
			} elseif ( $piece->type == ChessPiece::BISHOP ) {
				$moves = self::add_slide_and_slidecapture_moves_to_moves_list(self::BISHOP_DIRECTIONS, self::MAX_SLIDING_DISTANCE, $moves, $piece, $color_to_move, $board, $store_board_in_moves);
			} elseif ( $piece->type == ChessPiece::ROOK ) {
				$moves = self::add_slide_and_slidecapture_moves_to_moves_list(self::ROOK_DIRECTIONS, self::MAX_SLIDING_DISTANCE, $moves, $piece, $color_to_move, $board, $store_board_in_moves);
			} elseif ( $piece->type == ChessPiece::GENERAL ) {
				$moves = self::add_slide_and_slidecapture_moves_to_moves_list(self::GENERAL_DIRECTIONS, self::MAX_SLIDING_DISTANCE, $moves, $piece, $color_to_move, $board, $store_board_in_moves);
				$moves = self::add_jump_and_jumpcapture_moves_to_moves_list(self::KNIGHT_DIRECTIONS, $moves, $piece, $color_to_move, $board, $store_board_in_moves);				
			} elseif ( $piece->type == ChessPiece::KING ) {
				$moves = self::add_slide_and_slidecapture_moves_to_moves_list(self::KING_DIRECTIONS, 1, $moves, $piece, $color_to_move, $board, $store_board_in_moves);
				$moves = self::add_jump_and_jumpcapture_moves_to_moves_list(self::KNIGHT_DIRECTIONS, $moves, $piece, $color_to_move, $board, $store_board_in_moves);
				// Set $king here so castling function can use it later.
				$king = $piece;
			}
		}
		
		if ( $need_perfect_move_list ) {
			//$moves = self::eliminate_king_in_check_moves($king, $moves, $color_to_move);
			
			//$moves = self::add_castling_moves_to_moves_list($moves, $king, $board);
		}
		
		if ( $need_perfect_notation ) {
			self::clarify_ambiguous_pieces($moves, $color_to_move, $board);
			
			self::mark_checks_and_checkmates($moves, $color_to_move);
			
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
			foreach ( $moves as $move ) {
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
		}
	}
	
	static function add_slide_and_slidecapture_moves_to_moves_list(
		array $directions_list,
		int $spaces,
		array $moves,
		ChessPiece $piece,
		$color_to_move,
		ChessBoard $board,
		bool $store_board_in_moves
	): array {

		foreach ( $directions_list as $direction ) {
			for ( $i = 1; $i <= $spaces; $i++ ) {
				$current_xy = self::DIRECTION_OFFSETS[$direction];
				$current_xy[0] *= $i;
				$current_xy[1] *= $i;
				
				$ending_square = self::square_exists_and_not_occupied_by_friendly_piece(
					$piece->square,
					$current_xy[0],
					$current_xy[1],
					$color_to_move,
					$board
				);
				
				if ( ! $ending_square ) {
					// square does not exist, or square occupied by friendly piece
					// stop sliding
					break;
				}
				
				if((($ending_square->rank==0)/*&&($current_xy[0]>=2)&&($current_xy[0]<=7)*/) ||(($ending_square->rank==9)/*&&($current_xy[0]>=2)&&($current_xy[0]<=7)*/)) {					break;
				}
					


				$capture = FALSE;
				
				if ( $board->board[$ending_square->rank][$ending_square->file] ) {
					if ( $board->board[$ending_square->rank][$ending_square->file]->color != $color_to_move ) {
						$capture = TRUE;
					}
				}
				
				$moves[] = new ChessMove(
					$piece->square,
					$ending_square,
					$piece->color,
					$piece->type,
					$capture,
					$board,
					$store_board_in_moves
				);
				
				if ( $capture ) {
					// stop sliding
					break;
				}

				// empty square
				// continue sliding
				// continue;
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
		bool $store_board_in_moves
	): array {
		foreach ( $directions_list as $direction ) {
			$current_xy = self::DIRECTION_OFFSETS[$direction];
			
			$ending_square = self::square_exists_and_not_occupied_by_friendly_piece(
				$piece->square,
				$current_xy[0],
				$current_xy[1],
				$color_to_move,
				$board
			);
			
			if ( $ending_square ) {
				$capture = FALSE;
				
				if ( $board->board[$ending_square->rank][$ending_square->file] ) {
					if ( $board->board[$ending_square->rank][$ending_square->file]->color != $color_to_move ) {
						$capture = TRUE;
					}
				}
				
				if ( $capture ) {
					$move = new ChessMove(
						$piece->square,
						$ending_square,
						$piece->color,
						$piece->type,
						$capture,
						$board,
						$store_board_in_moves
					);
					
					// pawn promotion
					$white_pawn_capturing_on_rank_8 = $piece->type == ChessPiece::PAWN && $ending_square->rank == 8 && $piece->color == ChessPiece::WHITE;
					$black_pawn_capturing_on_rank_1 = $piece->type == ChessPiece::PAWN && $ending_square->rank == 1 && $piece->color == ChessPiece::BLACK;
					if ( $white_pawn_capturing_on_rank_8 || $black_pawn_capturing_on_rank_1 ) {
						foreach ( self::PROMOTION_PIECES as $type ) {
							$move2 = clone $move;
							$move2->set_promotion_piece($type);
							$moves[] = $move2;
						}
					} else {
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
		bool $store_board_in_moves
	): array {
		foreach ( $directions_list as $direction ) {
			for ( $i = 1; $i <= $spaces; $i++ ) {
				$current_xy = self::DIRECTION_OFFSETS[$direction];
				$current_xy[0] *= $i;
				$current_xy[1] *= $i;
				
				$ending_square = self::square_exists_and_not_occupied_by_friendly_piece(
					$piece->square,
					$current_xy[0],
					$current_xy[1],
					$color_to_move,
					$board
				);
				
				if ( ! $ending_square ) {
					// square does not exist, or square occupied by friendly piece
					// stop sliding
					break;
				}
				

				$capture = FALSE;
				
				if ( $board->board[$ending_square->rank][$ending_square->file] ) {
					if ( $board->board[$ending_square->rank][$ending_square->file]->color != $color_to_move ) {
						$capture = TRUE;
					}
				}
				
				if ( $capture ) {
					// enemy piece in square
					// stop sliding
					break;
				}
				
				$new_move = new ChessMove(
					$piece->square,
					$ending_square,
					$piece->color,
					$piece->type,
					$capture,
					$board,
					$store_board_in_moves
				);
				
		
				// pawn promotion
				$white_pawn_moving_to_rank_8 = $piece->type == ChessPiece::PAWN && $ending_square->rank == 8 && $piece->color == ChessPiece::WHITE;
				$black_pawn_moving_to_rank_1 = $piece->type == ChessPiece::PAWN && $ending_square->rank == 1 && $piece->color == ChessPiece::BLACK;
				if ( $white_pawn_moving_to_rank_8 || $black_pawn_moving_to_rank_1 ) {
					foreach ( self::PROMOTION_PIECES as $type ) {
						$move2 = clone $new_move;
						$move2->set_promotion_piece($type);
						$moves[] = $move2;
					}
				} else {
					$moves[] = $new_move;
				}
					
				// empty square
				// continue sliding
				// continue;
			}
		}
		
		return $moves;
	}
	

	static function add_jump_and_jumpcapture_moves_to_moves_list(
		array $oclock_list,
		array $moves,
		ChessPiece $piece,
		$color_to_move,
		ChessBoard $board,
		bool $store_board_in_moves
	): array {
		foreach ( $oclock_list as $oclock ) {
			$ending_square = self::square_exists_and_not_occupied_by_friendly_piece(
				$piece->square,
				self::OCLOCK_OFFSETS[$oclock][0],
				self::OCLOCK_OFFSETS[$oclock][1],
				$color_to_move,
				$board
			);
			
			if ( $ending_square ) {
				$capture = FALSE;
				
				if ( $board->board[$ending_square->rank][$ending_square->file] ) {
					// enemy piece
					if ( $board->board[$ending_square->rank][$ending_square->file]->color != $color_to_move ) {
						$capture = TRUE;
					}
				}
				
				$moves[] = new ChessMove(
					$piece->square,
					$ending_square,
					$piece->color,
					$piece->type,
					$capture,
					$board,
					$store_board_in_moves
				);
			}
		}
		
		return $moves;
	}
	

	static function mark_checks_and_checkmates(array $moves, $color_to_move): void {
		$enemy_color = self::invert_color($color_to_move);
		
		foreach ( $moves as $move ) {
			$enemy_king_square = $move->board->get_king_square($enemy_color);
			
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
			
			if ( ! self::square_is_attacked($enemy_color, $move->board, $friendly_king_square) ) {
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
	
	// positive X = east, negative X = west, positive Y = north, negative Y = south
	static function square_exists_and_not_occupied_by_friendly_piece(
		ChessSquare $starting_square,
		int $x_delta,
		int $y_delta,
		$color_to_move,
		ChessBoard $board
	): ?ChessSquare {
		$rank = $starting_square->rank + $x_delta;
		$file = $starting_square->file + $y_delta;
		
		$ending_square = self::try_to_make_square_using_rank_and_file_num($rank, $file);
		
		// Ending square is off the board
		if ( ! $ending_square ) {
			return null;
		}
		
		// Ending square contains a friendly piece
		if ( $board->board[$rank][$file] ) {
			if ( $board->board[$rank][$file]->color == $color_to_move ) {
				return null;
			}
		}
		
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
	
	// Used to generate en passant squares.
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
				if ( $piece->type == ChessPiece::KING ) {
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
							if ( $direction == self::NORTHEAST || $direction == self::NORTHWEST ) {
								return TRUE;
							}
						} elseif ( $piece->color == ChessPiece::WHITE ) {
							if ( $direction == self::SOUTHEAST || $direction == self::SOUTHWEST ) {
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
	
	static function square_threatened_by_jumping_pieces(
		ChessBoard $board,
		ChessSquare $square_to_check,
		$friendly_color
	): bool {
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
			//echo  '<br> Night = X '.$current_xy[0].'  Y = '.$current_xy[1].'  Calculated Rank '.$rank.'  Calculated File '.$file ;

			if ( ! self::square_is_on_board($rank, $file) ) {
				// Square is off the board. On to the next test square.
				continue;  // Check Next Square
			}
			
			$piece = self::get_piece($rank, $file, $board);
			//echo ' $piece->type = '.$piece->type;
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
			
			if ( $piece->type == ChessPiece::KNIGHT ) {  //If target piece is enemy and not threatening the opponent under R. Create a function.				
				echo '<br/> Final Knight Moved ='.$square_to_check->rank.' '.$square_to_check->file.'  '.$friendly_color;
				echo  '<br> Final Night = X '.$current_xy[0].'  Y = '.$current_xy[1].'  Calculated Rank '.$rank.'  Calculated File '.$file ;
				
				return TRUE;
			}	
			
			// If this code has been reached, then there is an enemy piece on this square
			// but it is not threatening the test square. On to the next square.
			// continue;
			echo ' Rank '.$square_to_check->rank.' File '.$square_to_check->file.'  Color '.$friendly_color.' Final Bad ='.$square_to_check->rank.' '.$square_to_check->file.'  '.$friendly_color.'<br/> *** Next Square to be checked <br/>';				
		}
		echo '<br/>  Rank '.$square_to_check->rank.' File '.$square_to_check->file.'  Color '.$friendly_color.' Final Bad ='.$square_to_check->rank.' '.$square_to_check->file.'  '.$friendly_color;		
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
