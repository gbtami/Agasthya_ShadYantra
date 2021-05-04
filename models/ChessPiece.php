<?php

class ChessPiece
{
	public $color;
	public $type;
	public $mortal;	
	public $square;
	public $group;/*royal*/

	
	const VIKRAMADITYA	= 100;
	const SIMPLEKING	= 30;

	const KING = 1;
	const INVERTEDKING = 2;
	const ANGRYKING = 3;
	const ANGRYINVERTEDKING = 4;
	const RAJYAPAALARTHSHASTRI	= 50;
	const ARTHSHASTRI = 5;
	const ANGRYARTHSHASTRI = 6;
	const SPY = 7;
	const GODMAN = 8;
	const GENERAL = 9;
	const ROOK = 10;
	const KNIGHT = 11;
	const BISHOP = 12;
	const PAWN = 13;
	const CAPTUREDSCEPTRE = 25;

	const WHITE = 1;
	const BLACK = 2;
	const ROYAL = 1;
	const OFFICER = 2;
	const NOBLE =3;
	const SEMIROYAL = 5;
	const SOLDIER = 4;

	const VALID_GROUPS = array(
		self::ROYAL,
		self::OFFICER,
		self::NOBLE,
		self::SOLDIER,
		self::SEMIROYAL

	);
	

	const VALID_COLORS = array(
		self::WHITE,
		self::BLACK
	);
	const VALID_TYPES = array(
		self::VIKRAMADITYA,
		self::KING,
		self::SIMPLEKING,

		self::INVERTEDKING,
		self::ANGRYKING,		
		self::ANGRYINVERTEDKING,
		self::RAJYAPAALARTHSHASTRI,
		self::ARTHSHASTRI,
		self::ANGRYARTHSHASTRI,
		self::CAPTUREDSCEPTRE,

		self::SPY,
		self::GODMAN,		
		self::GENERAL,
		self::ROOK,
		self::BISHOP,
		self::KNIGHT,
		self::PAWN

	);
	
	const UNICODE_CHESS_PIECES = array(
		self::WHITE => array(
			self::VIKRAMADITYA	=> 'V',
			self::KING => '&#9812;',
			self::SIMPLEKING =>'R',
			self::INVERTEDKING => '&#9812;',
			self::ANGRYKING => '&#9812;',
			self::ANGRYINVERTEDKING => 'Y',
			self::RAJYAPAALARTHSHASTRI	=> 'Ä',			
			self::ARTHSHASTRI=> '&#9921;',
			self::ANGRYARTHSHASTRI=> '&#9920;',
			self::SPY => '&#9734;',
			self::GODMAN => '&#9872;',				
			self::CAPTUREDSCEPTRE => 'Ö',

			self::GENERAL => '&#9813;',
			self::ROOK => '&#9814;',
			self::BISHOP => '&#9815;',
			self::KNIGHT => '&#9816;',
			self::PAWN => '&#9817;'

		),
		self::BLACK => array(
			self::VIKRAMADITYA	=> 'v',
			self::KING => '&#9818;',
			self::SIMPLEKING =>'r',

			self::INVERTEDKING => '&#9818;',
			self::ANGRYKING => '&#9818;',
			self::ANGRYINVERTEDKING => '&#9818;',
			self::RAJYAPAALARTHSHASTRI	=> 'ä',
			self::ARTHSHASTRI=> '&#9923;',
			self::ANGRYARTHSHASTRI=> '&#9922;',
			self::CAPTUREDSCEPTRE => 'ö',
			
			self::SPY => '&#9733;',
			self::GODMAN => '&#9873;',	
			
			self::GENERAL => '&#9819;',
			self::ROOK => '&#9820;',
			self::BISHOP => '&#9821;',
			self::KNIGHT => '&#9822;',
			self::PAWN => '&#9823;'


		)
	);
	const FEN_CHESS_PIECES = array(
		self::WHITE => array(
			self::VIKRAMADITYA	=> 'V',
			self::KING => 'I',
			self::SIMPLEKING =>'R',

			self::INVERTEDKING => 'J',
			self::ANGRYKING => 'U',
			self::ANGRYINVERTEDKING => 'Y',			
			self::RAJYAPAALARTHSHASTRI	=> 'Ä',
			self::ARTHSHASTRI=> 'Á',
			self::ANGRYARTHSHASTRI=> 'A',
			self::SPY => 'C',
			self::GODMAN => 'N',	
			self::CAPTUREDSCEPTRE => 'Ö',
			
			self::GENERAL => 'S',
			self::ROOK => 'M',
			self::BISHOP => 'G',
			self::KNIGHT => 'H',
			self::PAWN => 'P'
		),
		self::BLACK => array(
			self::VIKRAMADITYA	=> 'v',
			self::KING => 'i',
			self::SIMPLEKING =>'r',

			self::INVERTEDKING => 'j',
			self::ANGRYKING => 'u',
			self::ANGRYINVERTEDKING => 'y',		
			self::RAJYAPAALARTHSHASTRI	=> 'ä',
			self::ARTHSHASTRI=> 'á',
			self::ANGRYARTHSHASTRI=> 'a',		
			self::SPY => 'c',
			self::CAPTUREDSCEPTRE => 'ö',

			self::GODMAN => 'n',			
			self::GENERAL => 's',
			self::ROOK => 'm',
			self::BISHOP => 'g',
			self::KNIGHT => 'h',
			self::PAWN => 'p'
		)
	);
	const PIECE_VALUES = array(
		self::PAWN => 1,
		self::KNIGHT => 3,
		self::BISHOP => 3,
		self::ROOK => 5,
		self::GENERAL => 9,

		self::CAPTUREDSCEPTRE => 0,

		self::VIKRAMADITYA => 0,
		self::KING => 0,
		self::SIMPLEKING =>0,

		self::INVERTEDKING => 0,
		self::ANGRYKING => 0,
		self::ANGRYINVERTEDKING => 0,
		self::RAJYAPAALARTHSHASTRI	=> 0,
		self::ARTHSHASTRI=> 9,
		self::ANGRYARTHSHASTRI=> 9,		
		self::GODMAN => 0,
		self::SPY => 9
	);
	const SIDE_VALUES = array(
		self::WHITE => 1,
		self::BLACK => -1
	);
	
	function __construct($color, string $square_string, $type, $group,$mortal) {
		if ( in_array($color, self::VALID_COLORS) ) {
			$this->color = $color;
		} else {
			throw new Exception('Invalid ChessPiece Color');
		}

		$this->mortal = $mortal;

		//if ( in_array($group, self::VALID_GROUPS) ) {
			$this->group = $group;
		//} else {
			//throw new Exception('Invalid ChessPiece Group');
		//}

		$this->square = new ChessSquare($square_string);
		
		if ( in_array($type, self::VALID_TYPES) ) {
			$this->type = $type;
		} else {
			throw new Exception('Invalid ChessPiece Type');
		}
	}
	
	function __clone() {
		$this->square = clone $this->square;
	}
	
	function get_unicode_symbol(): string
	{
		//Echo '<li> ChessPiece.php #1 function get_unicode_symbol called </li>';	
		return self::UNICODE_CHESS_PIECES[$this->color][$this->type];
	}
	//self::PIECE_LETTERS[$this->piece_type]
	function get_fen_symbol(): string
	{
		//Echo '<li> ChessPiece.php #2 function get_fen_symbol called </li>';	
		
		return self::FEN_CHESS_PIECES[$this->color][$this->type];
	}
	
	function on_rank(int $rank): bool
	{
		//Echo '<li> ChessPiece.php #3 function on_rank called </li>';	
		
		if ( $rank == $this->square->rank )	{
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function get_value(): int {
		//Echo '<li> ChessPiece.php #4 function get_value called </li>';	

		return self::PIECE_VALUES[$this->type] * self::SIDE_VALUES[$this->color];
	}
}
