<?php

class ChessMove {
	const PIECE_LETTERS = array(
		ChessPiece::PAWN => 'p',
		ChessPiece::KNIGHT => 'h',
		ChessPiece::BISHOP => 'g',
		ChessPiece::ROOK => 'm',
		ChessPiece::GENERAL => 's',
		ChessPiece::KING => 'i',
		ChessPiece::SIMPLEKING => 'r',

		ChessPiece::INVERTEDKING => 'j',
		ChessPiece::ANGRYKING => 'u', //without rajdand
		ChessPiece::ANGRYINVERTEDKING => 'y', //without rajdand
		ChessPiece::ARTHSHASTRI => 'á' ,
		ChessPiece::ANGRYARTHSHASTRI => 'a' ,
		ChessPiece::CAPTUREDSCEPTRE =>'ö',
		ChessPiece::RAJYAPAALARTHSHASTRI => 'ä',

		ChessPiece::SPY => 'c' ,
		ChessPiece::GODMAN => 'n',
		//self::RAAJDAND=>'°',
		//self::ARTHDAND=>'´',

	);
	
	public $starting_square;
	public $ending_square;
	public $ending_square_piecetype;
	public $capturedking=FALSE;
	public $color;
	public $piece_type;
	public $capture;
	public $check = FALSE;
	public $checkmate = FALSE;
	public $promotion_piece_type = NULL; // Use the setter to change this. Keeping public so it can be read publicly.
	public $demotion_piece_type = NULL; // Use the setter to change this. Keeping public so it can be read publicly.	
	public $en_passant = FALSE;
	public $disambiguation = '';
	public $castling = FALSE;
	
	public $board;
	
	function __construct(		
		ChessSquare $starting_square,
		ChessSquare $ending_square,
		//$ending_square_type,
		int $ranking, /* 0 Nothing, 1 = Promotion -1 = Demotion*/		
		$color,
		$piece_type,
		bool $capture,
		ChessBoard $old_board,
		bool $store_board = TRUE,
		bool $sameplace
	) {
		$this->starting_square = $starting_square;
		$this->ending_square = $ending_square;
		$this->color = $color;
		$this->piece_type = $piece_type;
		$this->capture = $capture;
		
		// Adding $store_board sped up the code by 300ms
		if ( $store_board ) {
			$this->board = clone $old_board;
			
			// Perft uses an empty move to store a board. If not empty move, modify the board.
			if ( $this->starting_square ) {
				$this->board->make_move($starting_square, $ending_square, $sameplace);
			}
		}
	}
	
	// Do a deep clone. Needed for pawn promotion.
	function __clone() {
		$this->starting_square = clone $this->starting_square;
		$this->ending_square = clone $this->ending_square;
		if ( $this->board ) {
			$this->board = clone $this->board;
		}
	}

	

function set_killed_king($killedKing):void{
	//Echo '<li> ChessMove.php #1 function set_promotion_piece called </li>';	
		$this->capturedking = $killedKing;   

}

	function set_demotion_piece($piece_type): void {
		//Echo '<li> ChessMove.php #1 function set_promotion_piece called </li>';	
		
		// update the piece
		$rank = $this->ending_square->rank;
		$file = $this->ending_square->file;
		if ( $this->board ) {
			$this->board->board[$rank][$file]->type = $piece_type;
		}
		
		// update the notation
		$this->demotion_piece_type = $piece_type;
	}

	function set_promotion_piece($piece_type): void {
		//Echo '<li> ChessMove.php #1 function set_promotion_piece called </li>';	
		
		// update the piece
		$rank = $this->ending_square->rank;
		$file = $this->ending_square->file;
		if ( $this->board ) {
			$this->board->board[$rank][$file]->type = $piece_type;
		}
		
		// update the notation
		$this->promotion_piece_type = $piece_type;
	}

	function get_notation(): string {
		//Echo '<li> ChessMove.php #2 function get_notation called </li>';	
		$pcolor = NULL;
		$string = '';
		$char = self::PIECE_LETTERS[$this->piece_type];
		$kingsquare = NULL;
		if(((preg_match('/[çúýåá]/', $char)) &&($this->color == ChessPiece::BLACK))){
			$pcolor = $char	;
		}
		elseif ($this->color == ChessPiece::WHITE)
		{
			if (($char=='a')|| ($char=='i')||($char=='c')|| ($char=='u')|| ($char=='y')||($char=='j')) {
				$pcolor = strtoupper($char);
			} 
			//elseif (($char=='á')|| ($char=='ç')|| ($char=='ú')|| ($char=='ý')||($char=='å')) {
			elseif((preg_match('/[çúýåá]/', $char))){
				if($char=='á')
				{	$pcolor='Á';	}
				elseif($char=='ç')
				{	$pcolor='Ç';	}					
				elseif($char=='ú')
				{	$pcolor='Ú';	}
				elseif($char=='ý')	
				{	$pcolor='Ý';	}
				elseif($char=='å')
				{	$pcolor='Å';	}
			}
			else
				$pcolor =	strtoupper(self::PIECE_LETTERS[$this->piece_type]);
		}
		elseif($this->color == ChessPiece::BLACK){
			$pcolor = strtolower($char)	;
		}

		/*
		if ($this->color == ChessPiece::WHITE) {
		//check for special characters 
            $pcolor =	strtoupper(self::PIECE_LETTERS[$this->piece_type]);
        }
		else{
		$pcolor =	strtolower(self::PIECE_LETTERS[$this->piece_type]);
		}; 
		*/

		if (
			$this->starting_square->get_alphanumeric() == 'e8' &&
			$this->ending_square->get_alphanumeric() == 'g8' &&
			$this->piece_type == ChessPiece::KING &&
			$this->color == ChessPiece::BLACK
		) {
			$string .= 'O-O';
		} elseif (
			$this->starting_square->get_alphanumeric() == 'e1' &&
			$this->ending_square->get_alphanumeric() == 'g1' &&
			$this->piece_type == ChessPiece::KING &&
			$this->color == ChessPiece::WHITE
		) {
			$string .= 'O-O';
		} elseif (
			$this->starting_square->get_alphanumeric() == 'e8' &&
			$this->ending_square->get_alphanumeric() == 'c8' &&
			$this->piece_type == ChessPiece::KING &&
			$this->color == ChessPiece::BLACK
		) {
			$string .= 'O-O-O';
		} elseif (
			$this->starting_square->get_alphanumeric() == 'e1' &&
			$this->ending_square->get_alphanumeric() == 'c1' &&
			$this->piece_type == ChessPiece::KING &&
			$this->color == ChessPiece::WHITE
		) {
			$string .= 'O-O-O';
		} else {
			// type of piece
			if ( $this->piece_type == ChessPiece::PAWN){// && $this->capture ) {
				$string .= $pcolor;
				//$string .= substr($this->starting_square->get_alphanumeric(), 0, 1);
			} elseif ( $this->piece_type != ChessPiece::PAWN ) {
				$string .= $pcolor;
			}
			
			//$string .= $this->disambiguation;  // Disabled because extra Square name was added
			
			// capture?
			if ( $this->capture ) {
				$string .= '*';
			}
			
			// destination square
			$string .= $this->starting_square->get_alphanumeric();
			$string .= $this->ending_square->get_alphanumeric();
			
			
			// pawn promotion

			//self::CAPTUREDSCEPTRE => 'Ö',

			if($this->color==1)
			$kingsquare=$this->board->bkingsquare;//opponent square
			if($this->color==2)
			$kingsquare=$this->board->wkingsquare;//
			
			
			if($kingsquare!=null){
				if ($this->board->board[$kingsquare->rank][$kingsquare->file]!=null) {
					if (($this->ending_square->rank == $kingsquare->rank )&&($this->ending_square->file == $kingsquare->file )) {
						$string .= '#';
					}
				}
			}

			if ( $this->promotion_piece_type == ChessPiece::GENERAL ) {
				$string .= '=S';
			} elseif ( $this->promotion_piece_type == ChessPiece::ROOK ) {
				$string .= '=M';
			} elseif ( $this->promotion_piece_type == ChessPiece::BISHOP ) {
				$string .= '=G';
			} elseif ( $this->promotion_piece_type == ChessPiece::KNIGHT ) {
				$string .= '=H';
			}

			//later will change the royal_piece_type
			if ( $this->promotion_piece_type == ChessPiece::KING ) {
				$string .= '=I';
			} elseif ( $this->promotion_piece_type == ChessPiece::INVERTEDKING ) {
				$string .= '=J';
			} elseif ( $this->promotion_piece_type == ChessPiece::ANGRYKING ) {
				$string .= '=U';
			} elseif ( $this->promotion_piece_type == ChessPiece::ANGRYINVERTEDKING ) {

				if($kingsquare!=null){
					if ($this->board->board[$kingsquare->rank][$kingsquare->file]!=null) {
						if (($this->ending_square->rank == $kingsquare->rank )&&($this->ending_square->file == $kingsquare->file )) {
							}
					else		
						$string .= '=Y';	
					}
				}

		 	} elseif ( $this->promotion_piece_type == ChessPiece::VIKRAMADITYA) {
				$string .= '=V';
			} elseif ( $this->promotion_piece_type == ChessPiece::RAJYAPAALARTHSHASTRI) {
				$string .= '=Ä';
			}elseif ( $this->promotion_piece_type == ChessPiece::ARTHSHASTRI) {
				$string .= '=Á';
			}elseif ( $this->promotion_piece_type == ChessPiece::ANGRYARTHSHASTRI) {
				$string .= '=A';
			}
	



			if ( $this->demotion_piece_type == ChessPiece::KING ) {
				$string .= '=I';
			} elseif ( $this->demotion_piece_type == ChessPiece::INVERTEDKING ) {
				$string .= '=J';
			} elseif ( $this->demotion_piece_type == ChessPiece::ANGRYKING ) {
				$string .= '=U';
			} elseif ( $this->demotion_piece_type == ChessPiece::ANGRYINVERTEDKING ) {
				$string .= '=Y';
			}elseif ( $this->demotion_piece_type == ChessPiece::ANGRYARTHSHASTRI) {
				$string .= '=A';
			}elseif ( $this->demotion_piece_type == ChessPiece::ARTHSHASTRI) {
				$string .= '=Á';
			}
			elseif ( $this->demotion_piece_type == ChessPiece::CAPTUREDSCEPTRE) {
				$string .= '=Ö';
			}

			if (( $this->demotion_piece_type!= $this->piece_type) &&( $this->promotion_piece_type!= $this->piece_type)&& (( $this->piece_type == ChessPiece::ROOK)||( $this->piece_type == ChessPiece::BISHOP)||( $this->piece_type == ChessPiece::KNIGHT)||( $this->piece_type == ChessPiece::GENERAL) ||( $this->piece_type == ChessPiece::PAWN))&&((( $this->color=='1')&&(($this->ending_square->get_alphanumeric()=='d9')||($this->ending_square->get_alphanumeric()=='e9')))||
			(( $this->color=='2')&&(($this->ending_square->get_alphanumeric()=='d0')||($this->ending_square->get_alphanumeric()=='e0'))))){
				$string .= 'Ö';
			}
			elseif (( $this->demotion_piece_type!= $this->piece_type) &&( $this->promotion_piece_type!= $this->piece_type)&& (( $this->piece_type == ChessPiece::ROOK)||( $this->piece_type == ChessPiece::BISHOP)||( $this->piece_type == ChessPiece::KNIGHT)||( $this->piece_type == ChessPiece::GENERAL) ||( $this->piece_type == ChessPiece::PAWN))&&((( $this->color=='1')&&(($this->ending_square->get_alphanumeric()=='d9')||($this->ending_square->get_alphanumeric()=='e9')))||
			(( $this->color=='2')&&(($this->ending_square->get_alphanumeric()=='d0')||($this->ending_square->get_alphanumeric()=='e0'))))){
				$string .= 'Ö';
			}
			elseif ((($this->promotion_piece_type == ChessPiece::BISHOP)||( $this->promotion_piece_type == ChessPiece::KNIGHT))&&($this->piece_type==ChessPiece::SPY)&&(($this->ending_square->get_alphanumeric()=='d9')||($this->ending_square->get_alphanumeric()=='e9')||($this->ending_square->get_alphanumeric()=='d0')||($this->ending_square->get_alphanumeric()=='e0'))) {
				$string .= 'Ö';
			}
			elseif ((($this->promotion_piece_type == ChessPiece::BISHOP)||( $this->promotion_piece_type == ChessPiece::KNIGHT)||($this->promotion_piece_type == ChessPiece::GENERAL)||( $this->promotion_piece_type == ChessPiece::ROOK))&&(($this->ending_square->get_alphanumeric()=='d9')||($this->ending_square->get_alphanumeric()=='e9')||($this->ending_square->get_alphanumeric()=='d0')||($this->ending_square->get_alphanumeric()=='e0'))) {
				$string .= 'Ö';
			}
			//if(( $this->piece_type == ChessPiece::KNIGHT)&&($this->ending_square->rank==5)&&($this->ending_square->file==4)){
                //except Inveted King ever king type can be kicked
                if ($this->capturedking == true){
                    $string .= '#';
                }
           // }
						
			//if ( $this->demotion_piece_type == ChessPiece::GENERAL ) {
				//$string .= '=S';
			//} else
			if ( $this->demotion_piece_type == ChessPiece::ROOK ) {
				$string .= '=M';
			} elseif ( $this->demotion_piece_type == ChessPiece::BISHOP ) {
				$string .= '=G';
			} elseif ( $this->demotion_piece_type == ChessPiece::KNIGHT ) {
				$string .= '=H';
			} elseif ( $this->demotion_piece_type == ChessPiece::SPY ) {
			$string .= '=C';			
			}

		}
		
		// check or checkmate
		if ( $this->checkmate ) {
			$string .= '#';
		} elseif ( $this->check ) {
			$string .= '+';
		}
		
		return $string;
	}
	
	function get_coordinate_notation(): string {
		// Automatically pick GENERAL when drag and dropping.
		if (
			$this->demotion_piece_type == ChessPiece::ROOK ||
			$this->demotion_piece_type == ChessPiece::BISHOP ||
			$this->demotion_piece_type == ChessPiece::KNIGHT
		) {
			return "";
		}
		if (
			$this->promotion_piece_type == ChessPiece::ROOK ||
			$this->promotion_piece_type == ChessPiece::BISHOP ||
			$this->promotion_piece_type == ChessPiece::KNIGHT
		) {
			return "";
		} else {		
			return $this->starting_square->get_alphanumeric() . $this->ending_square->get_alphanumeric();
		}
	}
	
	function get_piece_letter(): string {
		$pcolor='';
		if ($this->color == ChessPiece::WHITE) {
            $pcolor =	strtoupper(self::PIECE_LETTERS[$this->piece_type]);
        }
		else{
		$pcolor =	strtolower(self::PIECE_LETTERS[$this->piece_type]);
		};
		//Echo '<li> ChessMove.php #4 function get_piece_letter called </li>';	
		return $pcolor;

	}
}
