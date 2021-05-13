<?php

class ChessBoard {
	const PIECE_LETTERS = array(
		'p' => ChessPiece::PAWN,
		'h' => ChessPiece::KNIGHT,
		'g' => ChessPiece::BISHOP,
		'm' => ChessPiece::ROOK,
		's' => ChessPiece::GENERAL,
		'i' => ChessPiece::KING,
		'r' => ChessPiece::SIMPLEKING ,

		'v' => ChessPiece::VIKRAMADITYA	,
		'j' => ChessPiece::INVERTEDKING,
		'u' => ChessPiece::ANGRYKING,
		'y' => ChessPiece::ANGRYINVERTEDKING,
		'ä' => ChessPiece::RAJYAPAALARTHSHASTRI,
		'á' => ChessPiece::ARTHSHASTRI,
		'a' => ChessPiece::ANGRYARTHSHASTRI,
		'c' => ChessPiece::SPY,
		'n' => ChessPiece::GODMAN
	);
	const FILE_NUMS_AND_LETTERS = array(
		0 => 'x',
		1 => 'a',
		2 => 'b',
		3 => 'c',
		4 => 'd',
		5 => 'e',
		6 => 'f',
		7 => 'g',
		8 => 'h',
		9 => 'y'
	);
	
	//0r2kq2r0/0rneskbnr0/0pppppppp0/080/080/080/080/0PPPPPPPP0/0RNBQKBNR0/0R2KQ2R0 w KQkq - 0 1♪◙

	//const FEN_REGEX_FORMAT = "/^([rnesijuyáä\´çúýåcgpRNESIJUYÁAÇÚÝÄCGP0123456789]{1,10})\/([rnesijuyaä\´çúýåcgpRNESIJUYÁAÇÚÝÄCGP0123456789]{1,10})\/([rnesijuyáä\´çúýåcgpRNESIJUYÁAÇÚÝÄCGP0123456789]{1,10})\/([rnesijuyáä\´çúýåcgpRNESIJUYÁAÇÚÝÄCGP0123456789]{1,10})\/([rnesijuyáä\´çúýåcgpRNESIJUYÁAÇÚÝÄCGP0123456789]{1,10})\/([rnesijuyáä\´çúýåcgpRNESIJUYÁAÇÚÝÄCGP0123456789]{1,10})\/([rnesijuyáä\´çúýåcgpRNESIJUYÁAÇÚÝÄCGP0123456789]{1,10})\/([rnesijuyáä\´çúýåcgpRNESIJUYÁAÇÚÝÄCGP0123456789]{1,10})\/([rnesijuyáä\´çúýåcgpRNESIJUYÁAÇÚÝÄCGP0123456789]{1,10})\/([rnesijuyáä\´çúýåcgpRNESIJUYÁAÇÚÝÄCGP0123456789]{1,10}) ([bw]{1}) ([-OQoq]{1,4}) ([a-hx-y0-9-]{1,2})( (\d{1,2}) (\d{1,4}))?$/";
	
	//const FEN_REGEX_FORMAT = '/^([rnesijuy\u00E1a\u00B0\u00B4\u00E7\u00FA\u00FD\u00E5cgpRNESIJUY\u00C1A\u00C7\u00DA\u00DD\u00C5CGP0123456789]{1,10})\/([rnesijuy\u00E1a\u00B0\u00B4\u00E7\u00FA\u00FD\u00E5cgpRNESIJUY\u00C1A\u00C7\u00DA\u00DD\u00C5CGP0123456789]{1,10})\/([rnesijuy\u00E1a\u00B0\u00B4\u00E7\u00FA\u00FD\u00E5cgpRNESIJUY\u00C1A\u00C7\u00DA\u00DD\u00C5CGP0123456789]{1,10})\/([rnesijuy\u00E1a\u00B0\u00B4\u00E7\u00FA\u00FD\u00E5cgpRNESIJUY\u00C1A\u00C7\u00DA\u00DD\u00C5CGP0123456789]{1,10})\/([rnesijuy\u00E1a\u00B0\u00B4\u00E7\u00FA\u00FD\u00E5cgpRNESIJUY\u00C1A\u00C7\u00DA\u00DD\u00C5CGP0123456789]{1,10})\/([rnesijuy\u00E1a\u00B0\u00B4\u00E7\u00FA\u00FD\u00E5cgpRNESIJUY\u00C1A\u00C7\u00DA\u00DD\u00C5CGP0123456789]{1,10})\/([rnesijuy\u00E1a\u00B0\u00B4\u00E7\u00FA\u00FD\u00E5cgpRNESIJUY\u00C1A\u00C7\u00DA\u00DD\u00C5CGP0123456789]{1,10})\/([rnesijuy\u00E1a\u00B0\u00B4\u00E7\u00FA\u00FD\u00E5cgpRNESIJUY\u00C1A\u00C7\u00DA\u00DD\u00C5CGP0123456789]{1,10})\/([rnesijuy\u00E1a\u00B0\u00B4\u00E7\u00FA\u00FD\u00E5cgpRNESIJUY\u00C1A\u00C7\u00DA\u00DD\u00C5CGP0123456789]{1,10})\/([rnesijuy\u00E1a\u00B0\u00B4\u00E7\u00FA\u00FD\u00E5cgpRNESIJUY\u00C1A\u00C7\u00DA\u00DD\u00C5CGP0123456789]{1,10})([bw]{1})([-OQoq]{1,4})([0-9a-hx-y-]{1,2})((\d{1,2})(\d{1,4}))?$/';
	const FEN_REGEX_FORMAT = '/^([rmneshijuvyaáä´çúýåcgpÖRMNESHIJUVYÇÚÝÄCGP0123456789]{1,10})\/([rmneshijuvyaä´çúýåcgpRMNESHIJUVYÁAÇÚÝÄCGP0123456789]{1,10})\/([rmneshijuvyaä´çúýåcgpRMNESHIJUVYÁAÇÚÝÄCGP0123456789]{1,10})\/([rmneshijuvyaä´çúýåcgpRMNESHIJUVYÁAÇÚÝÄCGP0123456789]{1,10})\/([rmneshijuvyaä´çúýåcgpRMNESHIJUVYÁAÇÚÝÄCGP0123456789]{1,10})\/([rmneshijuvyaä´çúýåcgpRMNESHIJUVYÁAÇÚÝÄCGP0123456789]{1,10})\/([rmneshijuvyaä´çúýåcgpRMNESHIJUVYÁAÇÚÝÄCGP0123456789]{1,10})\/([rmneshijuvyaä´çúýåcgpRMNESHIJUVYÁAÇÚÝÄCGP0123456789]{1,10})\/([rmneshijuvyaä´çúýåcgpRMNESHIJUVYÁAÇÚÝÄCGP0123456789]{1,10})\/([rmneshijuvyöä´çúýåcgpRMNESHIJUVYÁAÇÚÝÄCGP0123456789]{1,10}) ([bw]{1}) ([-OQoq]{1,4}) ([a-hx-y0-9-]{1,2})( (\d{1,2}) (\d{1,4}))?$/u';
	const CLASSIC_FEN_REGEX_FORMAT_LEFT = '/^([cCuUaAvVsSnNyYäÄ1]{1})([rmneshijuvyaáÁäçcgpÖRMNESHIJUVYÇÄCGP12345678]{1,9})*?([cCuUaAvVsSnNyYäÄ1]{1})\/([cCuUaAvVsSnyYNäÄ1]{1})([rmneshuvyáÁaäçcgpRMNESHUVYÇÄCGP12345678]{1,9})*?([cCuUaAvVsSnNyYäÄ1]{1})\/([cCuUaAvVsSnyYNäÄ1]{1})([rmneshuvyaáÁäçcgpRMNESHUVYÇÄCGP12345678]{1,9})*?([cCuUaAvVsSnNyYäÄ1]{1})\/([cCuUaAvVsSnyYNäÄ1]{1})([rmneshuvyaáÁäçcgpRMNESHUVYÇÄCGP12345678]{1,9})*?([cCuUaAvVsSnNyYäÄ1]{1})\/([cCuUaAvVsSnyYNäÄ1]{1})([rmneshuvyaáÁäçcgpRMNESHUVYÇÄCGP12345678]{1,9})*?([cCuUaAvVsSnNyYäÄ1]{1})\/([cCuUaAvVsSnyYNäÄ1]{1})([rmneshuvyaáÁäçcgpRMNESHUVYÇÄCGP12345678]{1,9})*?([cCuUaAvVsSnNyYäÄ1]{1})\/([cCuUaAvVsSnyYNäÄ1]{1})([rmneshuvyaáÁäçcgpRMNESHUVYÇÄCGP12345678]{1,9})*?([cCuUaAvVsSnNyYäÄ1]{1})\/([cCuUaAvVsSnyYNäÄ1]{1})([rmneshuvyaáÁäçcgpRMNESHUVYÇÄCGP12345678]{1,9})*?([cCuUaAvVsSnNyYäÄ1]{1})\/([cCuUaAvVsSnyYNäÄ1]{1})([rmneshuvyaáÁäçcgpRMNESHUVYÇÄCGP12345678]{1,9})*?([cCuUaAvVsSnNyYäÄ1]{1})\/([cCuUaAvVsSnyYNäÄ1]{1})([rmneshijuvyaáÁäçcgpÖRMNESHIJUVYÇÄCGP12345678]{1,9}) ([bw]{1}) ([-OQoq]{1,4}) ([a-hx-y0-9-]{1,2})( (\d{1,2}) (\d{1,4}))?$/u';
	//const CLASSIC_FEN_REGEX_FORMAT = '/^(([cCuUaArRvVsSnNyYäÄ1]{1})([rmneshijuvyaAáÁäçcgpÖRMNESHIJUVYÇÄCGP12345678]{1,8}))*?([cCuUaAvrRVsSnNyYäÄ1]{1})\/(([cCuUaArRvVsSnyYNäÄ1]{1})([rmneshuvyáÁaAäçcgpRMNESHUVYÇÄCGP12345678]{1,8}))*?([cCuUaArRvVsSnNyYäÄ1]{1})\/(([cCuUaArRvVsSnyYNäÄ1]{1})([rmneshuvyaAáÁäçcgpRMNESHUVYÇÄCGP12345678]{1,8}))*?([cCuUaArRvVsSnNyYäÄ1]{1})\/(([cCuUaArRvVsSnyYNäÄ1]{1})([rmneshuvyaAáÁäçcgpRMNESHUVYÇÄCGP12345678]{1,8}))*?([cCuUaArRvVsSnNyYäÄ1]{1})\/(([cCuUaArRvVsSnyYNäÄ1]{1})([rmneshuvyaAáÁäçcgpRMNESHUVYÇÄCGP12345678]{1,8}))*?([cCuUaArRvVsSnNyYäÄ1]{1})\/(([cCuUaArRvVsSnyYNäÄ1]{1})([rmneshuvyaAáÁäçcgpRMNESHUVYÇÄCGP12345678]{1,8}))*?([cCuUaArRvVsSnNyYäÄ1]{1})\/(([cCuUaArRvVsSnyYNäÄ1]{1})([rmneshuvyaAáÁäçcgpRMNESHUVYÇÄCGP12345678]{1,8}))*?([cCuUaArRvVsSnNyYäÄ1]{1})\/(([cCuUaArRvVsSnyYNäÄ1]{1})([rmneshuvyaAáÁäçcgpRMNESHUVYÇÄCGP12345678]{1,8}))*?([cCuUaArRvVsSnNyYäÄ1]{1})\/(([cCuUaArRvVsSnyYNäÄ1]{1})([rmneshuvyaAáÁäçcgpRMNESHUVYÇÄCGP12345678]{1,8}))*?([cCuUaArRvVsSnNyYäÄ1]{1})\/((([cCuUaArRvVsSnyYNäÄ1]{1})([rmneshijuvyaAáÁäçcgpÖRMNESHIJUVYÇÄCGP12345678]{1,8}))*?([cCuUaArRvVsSnNyYäÄ1]{1})) ([bw]{1}) ([-OQoq]{1,4}) ([a-hx-y0-9-]{1,2})( (\d{1,2}) (\d{1,4}))?$/u';
	const CLASSIC_FEN_REGEX_FORMAT = '/^(([ghmGHMcCuUaArRvVsSnNyYäÄ1]{1})([rmneshijuvyaAáÁäçcgpÖRMNESHIJUVYÇÄCGP12345678]{1,8}))*?([ghmGHMcCuUaAvrRVsSnNyYäÄ1]{1})\/(([ghmGHMcCuUaArRvVsSnyYNäÄ1]{1})([rmneshuvyáÁaAäçcgpRMNESHUVYÇÄCGP12345678]{1,8}))*?([ghmGHMcCuUaArRvVsSnNyYäÄ1]{1})\/(([ghmGHMcCuUaArRvVsSnyYNäÄ1]{1})([rmneshuvyaAáÁäçcgpRMNESHUVYÇÄCGP12345678]{1,8}))*?([ghmGHMcCuUaArRvVsSnNyYäÄ1]{1})\/(([ghmGHMcCuUaArRvVsSnyYNäÄ1]{1})([rmneshuvyaAáÁäçcgpRMNESHUVYÇÄCGP12345678]{1,8}))*?([ghmGHMcCuUaArRvVsSnNyYäÄ1]{1})\/(([ghmGHMcCuUaArRvVsSnyYNäÄ1]{1})([rmneshuvyaAáÁäçcgpRMNESHUVYÇÄCGP12345678]{1,8}))*?([ghmGHMcCuUaArRvVsSnNyYäÄ1]{1})\/(([ghmGHMcCuUaArRvVsSnyYNäÄ1]{1})([rmneshuvyaAáÁäçcgpRMNESHUVYÇÄCGP12345678]{1,8}))*?([ghmGHMcCuUaArRvVsSnNyYäÄ1]{1})\/(([ghmGHMcCuUaArRvVsSnyYNäÄ1]{1})([ghmGHMrmneshuvyaAáÁäçcgpRMNESHUVYÇÄCGP12345678]{1,8}))*?([ghmGHMcCuUaArRvVsSnNyYäÄ1]{1})\/(([ghmGHMcCuUaArRvVsSnyYNäÄ1]{1})([rmneshuvyaAáÁäçcgpRMNESHUVYÇÄCGP12345678]{1,8}))*?([ghmGHMcCuUaArRvVsSnNyYäÄ1]{1})\/(([ghmGHMcCuUaArRvVsSnyYNäÄ1]{1})([rmneshuvyaAáÁäçcgpRMNESHUVYÇÄCGP12345678]{1,8}))*?([ghmGHMcCuUaArRvVsSnNyYäÄ1]{1})\/((([ghmGHMcCuUaArRvVsSnyYNäÄ1]{1})([rmneshijuvyaAáÁäçcgpÖRMNESHIJUVYÇÄCGP12345678]{1,8}))*?([ghmGHMcCuUaArRvVsSnNyYäÄ1]{1})) ([bw]{1}) ([-OQoq]{1,4}) ([a-hx-y0-9-]{1,2})( (\d{1,2}) (\d{1,4}))?$/u';

	const CLASSIC_FEN_REGEX_FORMAT_NOMANS = '/^([cCuUaArRvVsSnNyYäÄ1]{1})?$/u';
	const CLASSIC_FEN_REGEX_FORMAT_BCASTLE = '/^([rmneshijuvyaáÁäçcgpÖRMNESHUVYÇÄCGP12345678]{1,8})?$/u';
	const CLASSIC_FEN_REGEX_FORMAT_WAR = '/^([rmneshuvyaäçcgpRMNESHUVYÇAÄCGP12345678]{1,8})?$/u';
	const CLASSIC_FEN_REGEX_FORMAT_WCASTLE = '/^([rmneshuvyaáÁäçcgpÖRMNESHIJUVYÇÄCGP12345678]{1,8})?$/u';
	const CLASSIC_FEN_REGEX_FORMAT_TRUCE = '/^([ghmGHMcCuUaAvrRVsSnyYNäÄ1]{1})?$/u';


	const DEFAULT_FEN = '1c2ái2c1/cmhgsnghmc/cppppppppc/181/181/181/181/CPPPPPPPPC/CMHGNSGHMC/1C2IÁ2C1 w OQoq - 0 1';
	
	public $board = array(); // $board[y][x], or in this case, $board[rank][file]
	public $color_to_move;
	public $castling = array(); // format is array('white_can_castle_kingside' => TRUE, etc.)
	public $en_passant_target_square = NULL;
	public $halfmove_clock;
	public $fullmove_number;
	public $ParityOfficers = array();
	public $Winner = '0';
	public $Winners=0;
	public $DefaultParityOfficers = '1S2M2H2G';
	public $blackcankill = 1;
	public $bkingsquare;
	public $wkingsquare;
	public $bgsquare;
	public $wgquare;	
	public $elevatedbg=false;
	public $elevatedwg=false;		
	public $basquare;
	public $wasquare;
	public $whitecankill = 1;
	public $blackcanfullmove = 0;
	public $whitecanfullmove = 0;
	public $blackscanfullmove = 0;
	public $whitescanfullmove = 0;	
	public $blackcanfullmoveinowncastle = 1;
	public $whitecanfullmoveinowncastle = 1;
	public $blackcanfullmoveinfoecastle = 0;
	public $whitecanfullmoveinfoecastle = 0;
	public $wbrokencastle=false;
	public $bbrokencastle=false;
	public $gametype = 1; //1 means classical Agasthya 2: Means Kautilya
	

	function __construct(string $fen = self::DEFAULT_FEN) {
		$this->import_fen($fen);
	}
	
	function __clone() {
		if ( $this->board ) {
			for ( $rank = 0; $rank <= 9; $rank++ ) {
				for ( $file = 0; $file <= 9; $file++ ) {
					// if there's a piece there
					if ( $this->board[$rank][$file] ) {
						// clone the piece so it's not pointing at an old piece
						$this->board[$rank][$file] = clone $this->board[$rank][$file];
					}
				}
			}
		}
	}

	function setparity(string $fen): void {
		$tchar = 0;
		$cchar ='';
		$chars = $this->DefaultParityOfficers;
		$this->ParityOfficers[0]='';
		$this->ParityOfficers[1]='';

		for($j=0;$j<2;$j++){
			if($j==0){
				$chars=strtolower($chars);
			} //Black = 0
			else if($j==1){$chars=strtoupper($chars);
			} //White = 1
			for ($i=0;$i<strlen($chars);$i=$i+2){
				$tchar = substr_count($fen,substr($chars,$i+1,1));
				$cchar =substr($chars,$i+1,1);
				if($tchar>0){
					$this->ParityOfficers[$j]=$this->ParityOfficers[$j].strval($tchar).$cchar;
				}
				else {
		   			$this->ParityOfficers[$j]=$this->ParityOfficers[$j]."0".$cchar;
				}
			}
    	}	
	}

	function checkcontinuity(string $fen): void {
		$tchar = array();
		$chars = 'vijuyr';
		$tcount = 0;
		//$rv = TRUE;

		for($j=0;$j<2;$j++){
			$tchar[$j] = 0;

			if($j==0){
				$chars=strtolower($chars);
			} //Black = 0
			else if($j==1){
				$chars=strtoupper($chars);
			} //White = 1
			for ($i=0;$i<strlen($chars);$i=$i+1){
				$tcount=substr_count($fen,substr($chars,$i,1));
				$tchar[$j] = $tchar[$j]+$tcount;		 
			}
		}		
	
		if(($tchar[0]==0)&&	($this->Winner!='2')){
			$this->Winner='1';
			//return FALSE;
		 }		 
	
		if(($tchar[1]==0)&&	($this->Winner!='1')){
			$this->Winner='2';
			//return FALSE;
	 	}
	
	 	if(($tchar[0]>0)&& ($tchar[1]>0)){
			$this->Winner='0';
			//return FALSE;
	 	} 
	 	if(($tchar[0]==0)&& ($tchar[1]==0)){ //No Kings on anyside
			$this->Winner='-1';
			//return FALSE;
	 	}
	}
	
	function checkdemotionparity(//no impact if royal throws
		string $fen,
		ChessPiece $piece,
		$color_to_move,
		ChessBoard $board): bool {
		$tchar = 0;
		$chars = $this->DefaultParityOfficers;
		$tcount = 0;
		$pname=strtolower($piece::FEN_CHESS_PIECES[$color_to_move][$piece->type]);
		if(strtolower($piece::FEN_CHESS_PIECES[$color_to_move][$piece->type])=='g'){
			$possibledemotionpiece=7;//Bishop to Spy'
			$chars='6C';
		}
		else{
			$possibledemotionpiece=($piece->type)+1;
		}

		$pname=$piece::FEN_CHESS_PIECES[$color_to_move][$possibledemotionpiece];
		//$type=$piece::BISHOP;

        if ($piece->group=='OFFICER') {
            if ($color_to_move==2) {	//black
                $chars=strtolower($chars);
				$pname=strtolower($pname);
            } //Black = 0
            elseif ($color_to_move==1) { //white
                $chars=strtoupper($chars);
				$pname=strtoupper($pname);
            } //White = 1
			
			$currentpcount=substr_count($fen, $pname);
			if($currentpcount>=0){
				$pcharpos=strpos($chars, $pname);
                if ($pcharpos>=1) {
                    $tcount = (int)(substr($chars, $pcharpos-1, 1));
                    if ($currentpcount<$tcount) {
                        return true;
                    } else { //currentpcount is exhausted
                        return false;
                    }
                    return true;
                }
				return false;
			}
			else
			{
				return false;
			}
        }
		return TRUE;
	}

	function checkpromotionparity(//no impact if royal throws
		string $fen,
		ChessPiece $piece,
		$color_to_move,
		ChessBoard $board,
		$possiblepromotionpiece): bool {
		$tchar = 0;
		$chars = $this->DefaultParityOfficers;
		$tcount = 0;
		$pname=$piece::FEN_CHESS_PIECES[$color_to_move][$possiblepromotionpiece];
		//$type=$piece::BISHOP;

        if (($piece->group=='OFFICER')||($piece->group=='SEMIROYAL')) {
            if ($color_to_move==2) {	//black
                $chars=strtolower($chars);
				$pname=strtolower($pname);
            } //Black = 0
            elseif ($color_to_move==1) { //white
                $chars=strtoupper($chars);
				$pname=strtoupper($pname);
            } //White = 1
			
			$currentpcount=substr_count($fen, $pname);
			if($currentpcount>=0){
				$pcharpos=strpos($chars, $pname);
                if ($pcharpos>=1) {
                    $tcount = (int)(substr($chars, $pcharpos-1, 1));
                    if ($currentpcount<$tcount) {
                        return true;
                    } else { //currentpcount is exhausted
                        return false;
                    }
                    return true;
                }
				return false;
			}
			else
			{
				return false;
			}
        }
		return TRUE;
	}

	function checkparity(string $fen): bool {
		$tchar = 0;
		$chars = $this->DefaultParityOfficers;
		$tcount = 0;
		//$rv = TRUE;

		for($j=0;$j<2;$j++){
			if($j==0){
				$chars=strtolower($chars);
			} //Black = 0
			else if($j==1){
				$chars=strtoupper($chars);
			} //White = 1
			for ($i=0;$i<strlen($chars);$i=$i+2){
				$tchar = substr_count($fen,substr($chars,$i+1,1));
				$tcount = (int)(substr($chars,$i,1));
				if($tchar>$tcount){
					return FALSE;
 				}
			}
    	}

		//parityRoyals
		$tchar = substr_count($fen,'i');
		$tcount = 1;

		if ($tchar > $tcount )
			return FALSE;

		$tchar = substr_count($fen,'I');
		if ($tchar > $tcount )
			return FALSE;

		$tchar = substr_count($fen,'j');
		$tcount = 1;

		if ($tchar > $tcount )
			return FALSE;

		$tchar = substr_count($fen,'J');
		if ($tchar > $tcount )
			return FALSE;

			$tchar = substr_count($fen,'u');
			$tcount = 1;
	
			if ($tchar > $tcount )
				return FALSE;
	
			$tchar = substr_count($fen,'U');
			if ($tchar > $tcount )
				return FALSE;			



				$tchar = substr_count($fen,'y');
				$tcount = 1;
		
				if ($tchar > $tcount )
					return FALSE;
		
				$tchar = substr_count($fen,'Y');
				if ($tchar > $tcount )
					return FALSE;
					
					$tchar = substr_count($fen,'a');
					$tcount = 1;
				
					if ($tchar > $tcount )
						return FALSE;
				
					$tchar = substr_count($fen,'A');
					if ($tchar > $tcount )
						return FALSE;

						$tchar = substr_count($fen,'Ö');
						$tcount = 1;
					
						if ($tchar > $tcount )
							return FALSE;

							$tchar = substr_count($fen,'ö');
							$tcount = 1;
						
							if ($tchar > $tcount )
								return FALSE;

		$tchar = substr_count($fen,'á');
		$tcount = 1;
	
		if ($tchar > $tcount )
			return FALSE;
	
		$tchar = substr_count($fen,'Á');
		if ($tchar > $tcount )
			return FALSE;

		return TRUE;
	}

	function my_mb_substr($string, $offset, $length):string
	{
		$arr = preg_split("//u", $string);
		  $slice = array_slice($arr, $offset + 1, $length);
		  return implode("", $slice);
	}

	function import_fen(string $fen): void {
		//Echo '<li> ChessBoard.php 1# function import_fen called </li>';	

		// TODO: FEN probably needs its own class.
		// Then it can have a method for each section of code below.
		
		$fen = trim($fen);
		$Validparity = 0;
		$valid_fen=null;
		$tempmatch=null;
		// Basic format check. This won't catch everything, but it will catch a lot of stuff.
		// This also parses the info we need into $matches[1] through $matches[14]
		// $matches[12] is skipped.
		// TODO: Make this stricter so that it catches everything.


		/*
		const CLASSIC_FEN_REGEX_FORMAT_NOMANS = '/^(([cCuUaArRvVsSnNyYäÄ1]{1})?$/u';
		const CLASSIC_FEN_REGEX_FORMAT_BCASTLE = '/^([rmneshijuvyaáÁäçcgpÖRMNESHUVYÇÄCGP12345678]{1,8}))?$/u';
		const CLASSIC_FEN_REGEX_FORMAT_WAR = '/^([rmneshuvyaäçcgpRMNESHUVYÇÄCGP12345678]{1,8}))?$/u';
		const CLASSIC_FEN_REGEX_FORMAT_WCASTLE = '/^([rmneshuvyaáÁäçcgpÖRMNESHIJUVYÇÄCGP12345678]{1,8}))?$/u';
		const CLASSIC_FEN_REGEX_FORMAT_WCASTLE = '/^([rmneshuvyaáÁäçcgpÖRMNESHIJUVYÇÄCGP12345678]{1,8}))?$/u';
		const CLASSIC_FEN_REGEX_FORMAT_TRUCE = '/^([cCuUaAvrRVsSnyYNäÄ1]{1})?$/u';
		*/

		$valid_fen = preg_match(self::FEN_REGEX_FORMAT, $fen, $matches);

		if(($this->gametype==1)&&($valid_fen!=null))
		{
			// If the FEN Format is perfect then use this
			$valid_fen = preg_match(self::CLASSIC_FEN_REGEX_FORMAT, $fen , $temp); 

			// If the FEN Format is not perfect then use this
	       /* if ($valid_fen) {
				for($i = 1; $i <= 10; $i++) {
					$fchar=substr($matches[$i], 0,1);
					$midchar=substr($matches[$i], 1, -1);
					$lchar=substr($matches[$i], -1);

					if(($i==1)||($i==10)) 
					{
						$valid_fen = preg_match(self::CLASSIC_FEN_REGEX_FORMAT_NOMANS, $fchar , $temp); 
						if ($valid_fen==null) break;
						if(($i==1)) 
						{
							$valid_fen = preg_match(self::CLASSIC_FEN_REGEX_FORMAT_BCASTLE, $midchar, $temp); 
							if ($valid_fen==null) break;
						}
						if(($i==10)) 
						{
							$valid_fen = preg_match(self::CLASSIC_FEN_REGEX_FORMAT_WCASTLE, $midchar, $temp); 
							if ($valid_fen==null) break;
						}
						$valid_fen = preg_match(self::CLASSIC_FEN_REGEX_FORMAT_NOMANS, $lchar , $temp); 
						if ($valid_fen==null) break;
					}
					
					if(($i>1)&&($i<10))
					{
						$valid_fen = preg_match(self::CLASSIC_FEN_REGEX_FORMAT_TRUCE, $fchar , $temp); 
						if ($valid_fen==null) break;
						$valid_fen = preg_match(self::CLASSIC_FEN_REGEX_FORMAT_WAR, $midchar , $temp); 
						if ($valid_fen==null) break;	
						$valid_fen = preg_match(self::CLASSIC_FEN_REGEX_FORMAT_TRUCE, $lchar , $temp); 
						if ($valid_fen==null) break;					
					}					
				}
        	}
			*/
		}

		if($this->checkparity($fen)==TRUE)
		{
			$this->setparity($fen);			
		}
		else if($this->checkparity($fen)==FALSE)
		{
			$valid_fen=NULL;
			$this->ParityOfficers[0]='';
			$this->ParityOfficers[1]='';			
		}


		$ttt=$this->ParityOfficers;//DefaultParityOfficers;
		$this->checkcontinuity($fen);
		echo ' Fen Value = '.$fen.' <br/> ---------------- ';
		if ( ! $valid_fen ) {
			throw new Exception('Invalid FEN');
		}
		else
		{
			if($this->Winner=='0') 
				echo ' <br/> Valid FEN. Mover (w White / b Black) = '.$matches[11].'  '.$fen.'<br/>';
		}
		// ******* CREATE PIECES AND ASSIGN THEM TO SQUARES *******
		
		// Set all board squares to NULL. That way we don't have to blank them in the loop below. We can just overwrite the NULL with a piece.
		for ( $i = 0; $i <= 9; $i++ ) {
			for ( $j = 0; $j <= 9; $j++ ) {
				$this->board[$i][$j] = NULL;
			}
		}
		
		// Create $rank variables with strings that look like this
			// rnESIbnr // pppppppp // 8 // PPPPPPPP // RNESIBNR // 2p5
		// The numbers are the # of blank squares from left to right
		$rank_string = array();
		for ( $i = 0; $i <= 9; $i++ ) {
			// Match string = 1, but rank = 8. Fix it here to avoid headaches.
			$rank = $this->invert_rank_or_file_number($i);
			$rank_string[$rank] = $matches[$i+1];
			//echo '<br/> i = '.$i.' Rank = '. $rank.' Rank Rank name = '.$matches[$i];
		}
		
		$nn=0;
		$group='OFFICER';
		$Mortal='1';
		// Process $rank variable strings, convert to pieces and add them to $this->board[][]
		foreach ( $rank_string as $rank => $string ) {
			$file = 0;
			//echo '<br/> ---------------------------------------------------------------------<br/>';
			//echo ' Total Strings = '.sizeof($rank_string). ' Size of String = '.strlen($rank_string[$nn]).' * Rank '.$rank_string[$nn];
			//echo '<br/> ---------------------------------------------------------------------<br/>';

			for ( $i = 0; $i <= strlen($rank_string[9-$nn]); $i++ ) {

				
				if (!function_exists('mb_substr'))  
					{
						$char = $this->my_mb_substr($string, $i, 1); 
					}
				else{	$char = mb_substr($string, $i, 1,'UTF-8');	 

					}

				//$char = mb_substr($string, $i, 1,'UTF-8');
				//$char = substr(utf8_decode($string), $i, 1);
				if(preg_match('/[^a-z0-9ÇÚÝÄäÁçúýåá´°á]/i', $char) or strlen($char)==0)
					{
					//echo ' <b><i><u><br/> ***'.$char. " is not valid string </u></i></b>";
					}
				else
				{				
					//echo ' <br/> Temp i = '.$i.' String length = '.strlen($string).' Char is = '.$char;
					// Don't use is_int here. $char is a string. Use is_numeric instead.
					if ( is_numeric($char) ) {					
						$file = $file + $char;
						//echo ' ** Blank Number on file = '.$file;					
					} else {
					$square = $this->number_to_file($file) . $rank;
					if($square=='e0'){
						$square=$square;
					}
					$cc=ctype_upper($char);


					if ($char=='C') {
						$color = ChessPiece::WHITE;
						$Mortal = 1;
						$group='SEMIROYAL';
						$type = self::PIECE_LETTERS[strtolower($char)];
					}
					elseif ($char=='Ç') {
						$color = ChessPiece::WHITE;
						$Mortal = 1;
						$group='SEMIROYAL';	
						$char='ç';
						$type = self::PIECE_LETTERS[$char];
					}
					elseif (($char=='ç')||($char=='c')) {
						$group='SEMIROYAL';
						$Mortal = 1;
						$color = ChessPiece::BLACK;
						$type = self::PIECE_LETTERS[$char];
					}
					else
					if (($char=='A')|| ($char=='R')||($char=='V')||($char=='I')|| ($char=='U')|| ($char=='Y')||($char=='J')) {
						$color = ChessPiece::WHITE;
						$Mortal = 1;
						$group='ROYAL';
						$type = self::PIECE_LETTERS[strtolower($char)];
					} 
					elseif (($char=='Á')|| ($char=='Ú')|| ($char=='Ý')||($char=='Ä')) {
						$color = ChessPiece::WHITE;
						$Mortal = 1;
						$group='ROYAL';
						if($char=='Á')
						{	$char='á';	}
						elseif($char=='Ú')
						{	$char='ú';	}
						elseif($char=='Ý')	
						{	$char='ý';	}					
						elseif($char=='Ä')
						{	$char='ä';	}

						$type = self::PIECE_LETTERS[$char];
					} 
					elseif (($char=='v')||($char=='r')||($char=='i')||($char=='j')||($char=='á')||($char=='a')|| ($char=='ú')||($char=='u')|| ($char=='ý')||($char=='y')||($char=='ä')||($char=='å')||($char=='a')) {
						$group='ROYAL';
						$Mortal = 1;
						$color = ChessPiece::BLACK;
						$type = self::PIECE_LETTERS[$char];
					} 
					elseif(($char=='n')||($char=='N')) 
					{
					   $group='NOBLE';
					   if($char=='n') $color = ChessPiece::BLACK;
					   else  $color = ChessPiece::WHITE;
					   $Mortal = 0;
					   $type = self::PIECE_LETTERS[strtolower($char)];
				   }
				   elseif(($char=='p')||($char=='P')) 
				   {
					  $group='SOLDIER';
					  if($char=='p') $color = ChessPiece::BLACK;
					  else  $color = ChessPiece::WHITE;
					  $Mortal = 1;
					  $type = self::PIECE_LETTERS[strtolower($char)];
				  }				   
				elseif ( ctype_upper($char)) {
						$group='OFFICER';
						$Mortal = 1;
						$color = ChessPiece::WHITE;
						$type = self::PIECE_LETTERS[strtolower($char)];

					} 
					 else
					 {
						$group='OFFICER';
						$Mortal = 1;
						$color = ChessPiece::BLACK;
						$type = self::PIECE_LETTERS[strtolower($char)];
					};
					//echo ' Check lower Char type '.strtolower($char); 			
					//echo ' Type = '.$type.' Color = '.$color;; 
					
					$this->board[$rank][$file] = new ChessPiece($color, $square, $type,$group,$Mortal);					

					if((($rank==9)&&($color==2)&&($file>=4)&&($file<=5)&&(($type==3)||($type==4)))||
					(($rank==0)&&($color==1)&&($file>=4)&&($file<=5)&&(($type==3)||($type==4))))
					 	$this->board[$rank][$file]->type= self::PIECE_LETTERS['i'];

					if((($rank==9)&&($color==2)&&(($file<4)||($file>5))&&($type==1))||
					 (($rank==0)&&($color==1)&&(($file<4)||($file>5))&&($type==1)))
					  $this->board[$rank][$file]->type= self::PIECE_LETTERS['u'];						 

					if((($rank==9)&&($color==2)&&(($file<4)||($file>5))&&($type==2))||
					  (($rank==0)&&($color==1)&&(($file<4)||($file>5))&&($type==2)))
					   $this->board[$rank][$file]->type= self::PIECE_LETTERS['y'];	

					$file++;
					}
				}
			}
		$nn++;				
		}
		//echo '<p>&#9812;</p>';
		
		// ******* SET COLOR TO MOVE *******
		if ( $matches[11] == 'w' ) {
			$this->color_to_move = ChessPiece::WHITE;
		} elseif ( $matches[11] == 'b' ) {
			$this->color_to_move = ChessPiece::BLACK;
		} else {
			throw new Exception('Invalid FEN - Invalid Color To Move');
		}
		
		// Set all castling to false. Only set to true if letter is present in FEN. Prevents bugs.
		$this->castling['white_can_castle_kingside'] = FALSE;
		$this->castling['white_can_castle_generalside'] = FALSE;
		$this->castling['black_can_castle_kingside'] = FALSE;
		$this->castling['black_can_castle_generalside'] = FALSE;
		
		
		// ******* SET EN PASSANT TARGET SQUARE *******
		if ( $matches[13] == '-' ) {
			$this->en_passant_target_square = FALSE;
		} else {
			$this->en_passant_target_square = new ChessSquare($matches[13]);
		}
		// ChessPiece throws its own exceptions, so no need to throw one here.
		
		// Normal (long) FEN
		if ( isset($matches[14]) ) {
			// ******* SET HALFMOVE CLOCK *******
			$this->halfmove_clock = $matches[15];
			
			// ******* SET FULLMOVE NUMBER *******
			$this->fullmove_number = $matches[16];
		// Short fen. Use default values.
		} else {

			$this->halfmove_clock = 0;
			$this->fullmove_number = 1;
		}
		
		//loop or funcytion to check the inverted kings
		$this->checkwinner();

 	}

	 function checkwinner():void{
		 $winners=0;
		 $this->bkingsquare=$this->get_king_square(2);//
		 $this->wkingsquare=$this->get_king_square(1);//

		 $this->basquare=$this->get_arthshastri_square(2);//
		 $this->wasquare=$this->get_arthshastri_square(1);//

		 $bkingsquare=$this->bkingsquare;//
		 $wkingsquare=$this->wkingsquare;//
		 
		 $bking=''; $wking='';

		//We can dynamically update the FENValue
		// $string=self::promoteking(2,$string);//Promote White

		 if ($this->board[9][4]!=null) {
            if (($this->board[9][4]!=null)&&($this->board[9][4]->color==1)&&(($this->board[9][4]->group=='OFFICER')||($this->board[9][4]->group=='SEMIROYAL')||($this->board[9][4]->group=='SOLDIER'))) {
				///self::promoteking(1,$string);//Promote White
				$this->Winner='1';$winners=$winners+1; //Black Wins
            }
        }
		
		if ($this->board[9][5]!=null) {
            if (($this->board[9][5]!=null)&&($this->board[9][5]->color==1)&&(($this->board[9][5]->group=='OFFICER')||($this->board[9][5]->group=='SEMIROYAL')||($this->board[9][5]->group=='SOLDIER'))) {
				//self::promoteking(1,$string);//Promote White
				$this->Winner='1';$winners=$winners+1; //Black Wins
            }
        }    
		
		if ($this->board[0][4]!=null) {
        	if (($this->board[0][4]!=null)&&($this->board[0][4]->color==2)&&(($this->board[0][4]->group=='OFFICER')||($this->board[0][4]->group=='SEMIROYAL')||($this->board[0][4]->group=='SOLDIER'))) {
				//self::promoteking(2,$string);//Promote White
				$this->Winner='2';$winners=$winners+1; //Black Wins
        	}
    	}	
	
		if($this->board[0][5]!=null){
			if(($this->board[0][5]!=null)&&($this->board[0][5]->color==2)&&(($this->board[0][5]->group=='OFFICER')||($this->board[0][5]->group=='SEMIROYAL')||($this->board[0][5]->group=='SOLDIER'))){
				//self::promoteking(2,$string);//Promote White
				$this->Winner='2';$winners=$winners+1; //Black Wins
			}
		}

		 //TRUCE or WAR KINGs are offering draws
		 if(($bkingsquare!=null)&&($bkingsquare->rank!=null))
		 {
		 	if ($this->board[$bkingsquare->rank][$bkingsquare->file]!=null){
		        if((($bkingsquare->rank>0) &&($bkingsquare->rank<9)&&(($bkingsquare->file==0) ||($bkingsquare->file==9))) 
				&&($this->board[$bkingsquare->rank][$bkingsquare->file]->type==self::PIECE_LETTERS[strtolower('U')])){
		 			$bking='TU';
					}
				if((($bkingsquare->rank>0) &&($bkingsquare->rank<9)&&(($bkingsquare->file>0) &&($bkingsquare->file<9))) 
				&&($this->board[$bkingsquare->rank][$bkingsquare->file]->type==self::PIECE_LETTERS[strtolower('Y')])){
					$bking='WY';
					}	 
				}
		}

		//TRUCE or WAR KINGs are offering draws
		if(($wkingsquare!=null)&&($wkingsquare->rank!=null))
		{
			if ($this->board[$wkingsquare->rank][$wkingsquare->file]!=null){
			   if((($wkingsquare->rank>0) &&($wkingsquare->rank<9)&&(($wkingsquare->file==0) ||($wkingsquare->file==9))) 
			   &&($this->board[$wkingsquare->rank][$wkingsquare->file]->type==self::PIECE_LETTERS[strtolower('U')])){
					$wking='TU';
				   }
			   if((($wkingsquare->rank>0) &&($wkingsquare->rank<9)&&(($wkingsquare->file>0) &&($wkingsquare->file<9))) 
			   &&($this->board[$wkingsquare->rank][$wkingsquare->file]->type==self::PIECE_LETTERS[strtolower('Y')])){
				   $wking='WY';
				   }
			   }
	   }

	   //TRUCE vs WAR DRAWs or WINNERs
	   if((($bking=='TU')&&($wking=='TU'))||(($bking=='WY')&&($wking=='WY'))){
		$this->Winner='3';$winners=1; //Draw Game
	   }
	   elseif(($bking=='TU')&&($wking=='WY')){
		$this->Winner='1';$winners=1; //WHITE Wins
	   }
	   elseif(($bking=='WY')&&($wking=='TU')){
		$this->Winner='2';$winners=1; //Black Wins
	   }
	   

        for ($row = 0; $row <= 9; $row++) {
            for ($col = 0; $col <= 9; $col++) {

				if($this->board[$row][$col])
					$pcolor=$this->board[$row][$col]->color;
					
				// Winner with V on any place
				if (($this->board[$row][$col]) &&($this->board[$row][$col]->type==self::PIECE_LETTERS[strtolower('V')])){
						if($this->board[$row][$col]->color==1) {
							$this->Winner='1';$winners=$winners+1;
						}
						if ($this->board[$row][$col]->color==2) {
								$this->Winner='2';$winners=$winners+1;
						}
						//continue;
				}
				//No Mans Invertion means lost
				elseif (($this->board[$row][$col]) && ((($col==0)&&($row==0))||(($col==9)&&($row==0))||(($col==0)&&($row==9))||(($col==9) &&($row==9)))) {
						if (($this->board[$row][$col]->type==self::PIECE_LETTERS[strtolower('Y')])||
						($this->board[$row][$col]->type==self::PIECE_LETTERS[strtolower('J')])){
							if(($this->board[$row][$col]->color==2)) {
								$this->Winner='1';$winners=$winners+1;
								//return FALSE;
							}

							if(($this->board[$row][$col]->color==1)) {
								$this->Winner='2';$winners=$winners+1;
								//return FALSE;
							}							
						}
				}
				//CASTLE INVERSION	
				elseif (($this->board[$row][$col]) && ($col>0) &&($col<9)&&($row==9)) {
                    	if ((($this->board[$row][$col]->type==self::PIECE_LETTERS[strtolower('J')])||
						($this->board[$row][$col]->type==self::PIECE_LETTERS[strtolower('Y')]))&&
						($this->board[$row][$col]->color==2)) {
                        	$this->Winner='1';$winners=$winners+1;
                        	//return FALSE;
                    	}
                }
				//CASTLE INVERSION
				elseif (($this->board[$row][$col]) && ($col>0) &&($col<9)&&($row==0)) {
                    	if ((($this->board[$row][$col]->type==self::PIECE_LETTERS[strtolower('J')]) ||
						($this->board[$row][$col]->type==self::PIECE_LETTERS[strtolower('Y')]))&&
						($this->board[$row][$col]->color==1)) {
                        	$this->Winner='2';$winners=$winners+1;
                        	//return FALSE;
                    	}
                	}
				/* Check the TRUCE Inversion*/	 
				elseif (($this->board[$row][$col]) && ($row>0) &&($row<9)&&(($col==9)||($col==0))) {
                    	if ((($this->board[$row][$col]->type==self::PIECE_LETTERS[strtolower('J')]) ||
						($this->board[$row][$col]->type==self::PIECE_LETTERS[strtolower('Y')]))&&
						($this->board[$row][$col]->color==1)) {
                        	$this->Winner='2';$winners=$winners+1;
                    	}
						if ((($this->board[$row][$col]->type==self::PIECE_LETTERS[strtolower('J')]) ||
						($this->board[$row][$col]->type==self::PIECE_LETTERS[strtolower('Y')]))&&
						($this->board[$row][$col]->color==2)) {
                            $this->Winner='1';$winners=$winners+1;
                    	}
                	}
            	}
        }
		$this->Winners=$winners;
	 }
	
	function promoteking($color,$string):string{

		if($color==1){
			$string = str_replace('U', 'V', $string);
			$string = str_replace('Y', 'V', $string);
			$string = str_replace('I', 'V', $string);
			$string = str_replace('A', 'Ä', $string);
			$string = str_replace('Á', 'Ä', $string);

			$string = str_replace('u', 'r', $string);
			$string = str_replace('j', 'r', $string);
			$string = str_replace('y', 'r', $string);
			$string = str_replace('i', 'r', $string);
			$string = str_replace('a', 'a', $string);
			$string = str_replace('á', 'a', $string);	
		}
		elseif($color==2){
			$string = str_replace('u', 'v', $string);
			$string = str_replace('y', 'v', $string);
			$string = str_replace('i', 'v', $string);
			$string = str_replace('a', 'ä', $string);
			$string = str_replace('á', 'ä', $string);

			$string = str_replace('U', 'R', $string);
			$string = str_replace('J', 'R', $string);
			$string = str_replace('Y', 'R', $string);
			$string = str_replace('I', 'R', $string);
			$string = str_replace('A', 'A', $string);
			$string = str_replace('Á', 'A', $string);	
		}
		return $string;
	} 

	function export_fen(): string {
        //Echo '<li> ChessBoard.php 2# function export_fen called </li>';
        $string = '';
        
        // A chessboard looks like this
        // a8 b8 c8 d8
        // a7 b7 c7 d7
        // etc.
        // But we want to print them starting with row 8 first.
        // So we need to adjust the loops a bit.
    
        for ($rank = 9; $rank >= 0; $rank--) {
            $empty_squares = 0;
            $empty_l =0;
            $empty_r =0;
            $instance =null;
            //echo '<br/><br/>';
            for ($file = 0; $file <= 9; $file++) {
                $piece = $this->board[$rank][$file];
                $instance ='1';

                if ($piece) {
                    $instance=$piece->get_fen_symbol();
                } //else {$instance=null};
                if ((! $piece)||($instance=='') ||(($instance==null))) {
                    //echo ' (Empty) ';
                    if ($file ==0) {
                        $empty_l =1;
                        $string .=$empty_l;
                    } elseif ($file ==9) {
                        if (($empty_squares<=8)&&($empty_squares>=1)) {
                            $string .=$empty_squares;
                        }
                        
                        $empty_r =1;
                        $string .=$empty_r;
                    } else {
                        $empty_squares++;
                    }
                } else { //Square as some piece
                    //echo ' #Piece# = '.$piece->type;
                    //echo ' Blank = '.$empty_squares;
                        if ($empty_squares) { //if empty square is non-zero and reached the file
                            //echo ' *** ';
                            $string .= $empty_squares;
                            $empty_squares = 0;
                        }
                    //if ( $empty_squares ) { //if empty square is non-zero and reached the file
                    ////echo ' ************** ';
                    //$string .= $empty_squares;
                    //$empty_squares = 0;
                    //}

                    $string .= $piece->get_fen_symbol();
                }
            }
            //echo ' <br/> *** Blank L = '.$empty_l.' Blank Mid = '.$empty_squares.' Blank R = '.$empty_r;

            //if ( $empty_squares ) {
            //$string .= $empty_l.$empty_squares==0?'':$empty_squares.$empty_r;
            //}
            
            if ($rank != 0) {
                $string .= "/";
            }
        }

        if ($this->color_to_move == ChessPiece::WHITE) {
            $string .= " w ";
        } elseif ($this->color_to_move == ChessPiece::BLACK) {
            $string .= " b ";
        }
            
        $string .= "-";
            
        $string .= " -";
            
        $string .= " " . $this->halfmove_clock . ' ' . $this->fullmove_number;

        //Change positions of winning empereror and arthshastri if present


        if ($this->board[9][4]!=null) {
            if (($this->board[9][4]!=null)&&($this->board[9][4]->color==1)&&(($this->board[9][4]->group=='OFFICER')||($this->board[9][4]->group=='SEMIROYAL')||($this->board[9][4]->group=='SOLDIER'))) {
				$string = self::promoteking(1,$string);//Promote White
				return $string;
            }
        }
		
		if ($this->board[9][5]!=null) {
            if (($this->board[9][5]!=null)&&($this->board[9][5]->color==1)&&(($this->board[9][5]->group=='OFFICER')||($this->board[9][5]->group=='SEMIROYAL')||($this->board[9][5]->group=='SOLDIER'))) {
				$string = self::promoteking(1,$string);//Promote White
				return $string;			
            }
        }    
		
		if ($this->board[0][4]!=null) {
        	if (($this->board[0][4]!=null)&&($this->board[0][4]->color==2)&&(($this->board[0][4]->group=='OFFICER')||($this->board[0][4]->group=='SEMIROYAL')||($this->board[0][4]->group=='SOLDIER'))) {
				$string = self::promoteking(2,$string);//Promote Black
				return $string;
        	}
    	}	
	
		if($this->board[0][5]!=null){
			if(($this->board[0][5]!=null)&&($this->board[0][5]->color==2)&&(($this->board[0][5]->group=='OFFICER')||($this->board[0][5]->group=='SEMIROYAL')||($this->board[0][5]->group=='SOLDIER'))){
				$string = self::promoteking(2,$string);//Promote Black
				return $string;
			}
		}
	
		if (strpos($string,"Ä")!==FALSE) {		
			$string = self::promoteking(1,$string);//Promote White
			return $string;
		}
		
		if (strpos($string,"ä")!==FALSE) {		
			$string = self::promoteking(2,$string);//Promote Black
			return $string;		
		}

		if ((strpos($string,"V")!==FALSE)) {		
			$string = self::promoteking(1,$string);//Promote White
			return $string;
		}
		else
		if ((strpos($string,"v")!==FALSE)) {		
			$string = self::promoteking(2,$string);//Promote Black
			return $string;		
		}	
		
		return $string;
	}
	
	// Keeping this for debug reasons.
    function get_ascii_board(): string {
		//Echo '<li> ChessBoard.php 3# function get_ascii_board called </li>';	
		if ($this->Winners>=2) {
			$string .= "INVALID FEN. There cannot be two Winners";
			//return $string;
		}

        $string = '';
		if($this->Winner=='-1')
			$string .= "No Kings. Chanakya Game";
		else
        if ($this->Winner=='0') {
            if ($this->color_to_move == ChessPiece::WHITE) {
                $string .= "White To Move";
            } elseif ($this->color_to_move == ChessPiece::BLACK) {
                $string .= "Black To Move";
            }
        }
		else
		if ($this->Winner=='1') {
                $string .= "White Won the Game";
        } 
		else if ($this->Winner=='2') {
                $string .= "Black Won the Game";  
		}
		else if ($this->Winner=='3') {
				$string .= "Both Agreed to Stop the Game. Draw"; 				          
        }
		
        // A chessboard looks like this
            // a8 b8 c8 d8
            // a7 b7 c7 d7
            // etc.
        // But we want to print them starting with row 8 first.
        // So we need to adjust the loops a bit.

        for ( $rank = 9; $rank >= 0; $rank-- ) {
            $string .= "<br>";

            for ( $file = 0; $file <= 9; $file++ ) {
                $square = $this->board[$rank][$file];

                if ( ! $square ) {
                    $string .= "*";
                } else {
                    $string .= $this->board[$rank][$file]->get_unicode_symbol();
                }
            }
        }
		$string .= "<br><br>";

        return $string;
    }
	
	function get_graphical_board(): array {
		//Echo '<li> ChessBoard.php 4# function get_graphical_board called </li>';	

		// We need to throw some variables into an array so our view can build the board.
		// The array shall be in the following format:
			// square_color = black / white
			// id = a1-h8
			// piece = HTML unicode for that piece
		
		// A chessboard looks like this
			// a8 b8 c8 d8
			// a7 b7 c7 d7
			// etc.
		// But we want to print them starting with row 8 first.
		// So we need to adjust the loops a bit.
		
		$graphical_board_array = array();
		for ( $rank = 9; $rank >= 0; $rank-- ) {
			for ( $file = 0; $file <= 9; $file++ ) {
				$piece = $this->board[$rank][$file];

				// NaagLok COLOR
				if ( (($rank==0) && ($file==0)) || (($rank==0) && ($file==9)) || (($rank==9) && ($file==0))||(($rank==9) && ($file==9)) ) {
					$graphical_board_array[$rank][$file]['square_color'] = 'naaglok';
				}
				else if ( (($rank==0) && ($file<9)) || (($rank==9) && ($file<9))) {			
					// CASTLE COLOR
					if ( ($rank + $file) % 2 == 1 ) {
						$graphical_board_array[$rank][$file]['square_color'] = 'blackcastle';
					} else {
						$graphical_board_array[$rank][$file]['square_color'] = 'whitecastle';
					}					
				}			
				else if ( (($file==0) && ($rank<9)) || (($file==9) && ($rank<9))) {
					// Truce COLOR
					if ( ($rank + $file) % 2 == 1 ) {
						$graphical_board_array[$rank][$file]['square_color'] = 'blacktruce';
					} else {
						$graphical_board_array[$rank][$file]['square_color'] = 'whitetruce';
					}					
				}					
				else{					
					// SQUARE COLOR
					if ( ($rank + $file) % 2 == 1 ) {
						$graphical_board_array[$rank][$file]['square_color'] = 'black';
					} else {
						$graphical_board_array[$rank][$file]['square_color'] = 'white';
					}
				}
				// ID
				$graphical_board_array[$rank][$file]['id'] = self::FILE_NUMS_AND_LETTERS[$file] . $rank;
				
				// PIECE
				if ( ! $piece ) {
					$graphical_board_array[$rank][$file]['piece'] = '';
					$graphical_board_array[$rank][$file]['name'] = '';

				} else {
					$graphical_board_array[$rank][$file]['piece'] = $this->board[$rank][$file]->get_unicode_symbol();
					$graphical_board_array[$rank][$file]['name'] = $this->board[$rank][$file]->get_fen_symbol();
				}
			}
		}
		
		return $graphical_board_array;
	}
	
	function get_side_to_move_string(): string {
		//Echo '<li> ChessBoard.php 5# function get_side_to_move_string called </li>';	

		$string = '';
		
		$string = '';
		
		if ($this->Winners>=2) {
			$string .= "INVALID FEN. There cannot be two Winners";
			return $string;
		}
	
		

		if($this->Winner=='-1')
			$string .= "No Kings. Chanakya Game";
		else
        if ($this->Winner=='0') {
            if ($this->color_to_move == ChessPiece::WHITE) {
                $string .= "White To Move";
            } elseif ($this->color_to_move == ChessPiece::BLACK) {
                $string .= "Black To Move";
            }
        }
		else
		if ($this->Winner=='1') {
                $string .= "White Won the Game";
        } 
		else if ($this->Winner=='2') {
                $string .= "Black Won the Game";
		}		
		else if ($this->Winner=='3') {
				$string .= "Both Agreed to Stop the Game. Draw"; 					
        }
		
		return $string;
	}
	
	function get_who_is_winning_string(): string {
		//Echo '<li> ChessBoard.php 6# function get_who_is_winning_string called </li>';	

		$points = 0;
		
		foreach ( $this->board as $value1 ) {
			foreach ( $value1 as $piece ) {
				if ( $piece ) {
					$points += $piece->get_value();
				}
			}
		}
		
		if ( $points > 0 ) {
			return "Material: White Ahead By $points";
		} elseif ( $points < 0 ) {
			$points *= -1;
			return "Material: Black Ahead By $points";
		} else {
			return "Material: Equal";
		}
	}
	
	function invert_rank_or_file_number(int $number): int {
		//Echo '<li> ChessBoard.php 7# function invert_rank_or_file_number called </li>';
		// 1 => 8
		// 2 => 7
		// etc.
		
		return 9 - $number;
	}
	
	function number_to_file(int $number) {
		//Echo '<li> ChessBoard.php 8# function number_to_file called </li>';	
		return self::FILE_NUMS_AND_LETTERS[$number];
	}
	
	// Note: This does not check for and reject illegal moves. It is up to code in the ChessGame class to generate a list of legal moves, then only make_move those moves.
	// In fact, sometimes make_move will be used on illegal moves (king in check moves), then the illegal moves will be deleted from the list of legal moves in a later step.
	function make_move(ChessSquare $old_square, ChessSquare $new_square,bool $sameplace): void {
		//Echo '<li> ChessBoard.php 9# function make_move called </li>';	

		$moving_piece = clone $this->board[$old_square->rank][$old_square->file];
		
		$is_capture = $this->board[$new_square->rank][$new_square->file];
		
		if ( $moving_piece->type == ChessPiece::PAWN || $is_capture ) {
			$this->halfmove_clock = 0;
		} else {
			$this->halfmove_clock++;
		}
		
		$this->board[$new_square->rank][$new_square->file] = $moving_piece;
		
		// Update $moving_piece->square too to avoid errors.
		$moving_piece->square = $new_square;
		
		if($sameplace==FALSE)
		$this->board[$old_square->rank][$old_square->file] = NULL;
		
		if ( $this->color_to_move == ChessPiece::BLACK ) {
			$this->fullmove_number++;
		}
		
		$this->flip_color_to_move();
	}
	
	// Used to move the rook during castling.
	// Can't use make_move because it messes up color_to_move, halfmove, and fullmove.
	function make_additional_move_on_same_turn(ChessSquare $old_square, ChessSquare $new_square): void {
		//Echo '<li> ChessBoard.php 10# function make_additional_move_on_same_turn called </li>';	

		$moving_piece = clone $this->board[$old_square->rank][$old_square->file];
		$this->board[$new_square->rank][$new_square->file] = $moving_piece;
		// Update $moving_piece->square too to avoid errors.
		$moving_piece->square = $new_square;
		$this->board[$old_square->rank][$old_square->file] = NULL;
	}
	
	function flip_color_to_move(): void {
		//Echo '<li> ChessBoard.php 11# function flip_color_to_move called </li>';	

		if ( $this->color_to_move == ChessPiece::WHITE ) {
			$this->color_to_move = ChessPiece::BLACK;
		} elseif ( $this->color_to_move == ChessPiece::BLACK ) {
			$this->color_to_move = ChessPiece::WHITE;
		}
	}
	
	function square_is_occupied(ChessSquare $square): bool {
		//Echo '<li> ChessBoard.php 12# function square_is_occupied called </li>';	
		
		$rank = $square->rank;
		$file = $square->file;
		
		if ( $this->board[$rank][$file] ) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function get_king_square($color): ?ChessSquare {
		//Echo '<li> ChessBoard.php 13# function get_king_square called </li>';	
		foreach ( $this->board as $rank ) {
			////echo '<br/>';
			foreach ( $rank as $piece ) {
				if ( $piece ) {
					////echo ' Actual = '.$piece->type.' Expected = '.ChessPiece::KING;

					if($piece->group=='ROYAL'){
						if ((($piece->type == ChessPiece::SIMPLEKING)||($piece->type == ChessPiece::VIKRAMADITYA)||($piece->type == ChessPiece::KING)||($piece->type == ChessPiece::INVERTEDKING)||($piece->type == ChessPiece::ANGRYKING)||($piece->type == ChessPiece::ANGRYINVERTEDKING)) && ($piece->color == $color )) {
							return $piece->square;
						}
					}
				}
			}
		}
		return NULL;
	}

	function get_general_square($color): ?ChessSquare {
		//Echo '<li> ChessBoard.php 13# function get_king_square called </li>';	
		foreach ( $this->board as $rank ) {
			////echo '<br/>';
			foreach ( $rank as $piece ) {
				if ( $piece ) {
					////echo ' Actual = '.$piece->type.' Expected = '.ChessPiece::KING;

					if (($piece->type == ChessPiece::GENERAL) && ($piece->color == $color )) {
						return $piece->square;
					}
				}
			}
		}
		return NULL;
	}	

	function get_arthshastri_square($color): ?ChessSquare {
		//Echo '<li> ChessBoard.php 13# function get_king_square called </li>';	
		foreach ( $this->board as $rank ) {
			////echo '<br/>';
			foreach ( $rank as $piece ) {
				if ( $piece ) {
					////echo ' Actual = '.$piece->type.' Expected = '.ChessPiece::KING;

					if ((($piece->type == ChessPiece::ARTHSHASTRI)||($piece->type == ChessPiece::ANGRYARTHSHASTRI)||($piece->type == ChessPiece::RAJYAPAALARTHSHASTRI)) && ($piece->color == $color )) {
						return $piece->square;
					}
				}
			}
		}
		return NULL;
	}
	
	function get_generals_on_truce($color): bool {
		//Echo '<li> ChessBoard.php 13# function get_king_square called </li>';	
		$count=0;
		$color=1;

		foreach ( $this->board as $RankData ) {
			if($count==2) break;
			foreach ( $RankData as $piece ) {
				if ( $piece ) {
					//Generals are sitting on TRUCE Borders
                    if (($piece->type == ChessPiece::GENERAL)&&(($piece->square->file==0)||($piece->square->file==9))){
							if(($piece->color==1)){
								$this->whitecanfullmoveinfoecastle = 0; //Can fullmove
								$this->whitecanfullmove = 0; //Can fullmove
								$count=$count+1;
								}
							if(($piece->color==2)){
								$this->blackcanfullmoveinfoecastle = 0; //Can fullmove
								$this->blackcanfullmove = 0; //Can fullmove
								$count=$count+1;
								}
							if($count==2) break;
                    }
				}
			}
		}
		if($count>=1)
			return TRUE;
		return FALSE;
	}
	
	function get_royals_on_Scepters_TruceControl($color): bool {
		//Echo '<li> ChessBoard.php 13# function get_king_square called </li>';	
		$count=0;
		$color=1;

		foreach ( $this->board as $RankData ) {
			////echo '<br/>';			
			if($count==2) break;
			foreach ( $RankData as $piece ) {
				if ( $piece ) {
					//Kings are sitting on Scepters or TRUCE Borders
                    if (((($piece->type == ChessPiece::KING)||($piece->type == ChessPiece::ANGRYKING))&&((($piece->square->file==4)||($piece->square->file==5))&&(($piece->square->rank==0)||($piece->square->rank==9))))||
					(($piece->type == ChessPiece::ANGRYKING)&&((($piece->square->rank==4)||($piece->square->rank==5))&&(($piece->square->file==0)||($piece->square->file==9))))){
                        //if (($piece->color == $color)) {
							if(($piece->color==1)&& ($this->whitecankill == 1)){
								$this->whitecankill = 0; //Cannot kill
								$count=$count+1;
								}
							if(($piece->color==2)&& ($this->blackcankill == 1)){
									$this->blackcankill = 0; //Cannot kill
									$count=$count+1;
								}
							if($count==2) break;
                    }
				}
			}
		}
		if($count>=1)
			return TRUE;
		return FALSE;
	}
	
	function get_royals_on_castle_for_full_move($color): bool {

		$count=0;
		$color=1;

		foreach ( $this->board as $RankData ) {
			foreach ( $RankData as $piece ) {
				if ( $piece ) {
                    if (($piece->square->file>0)&&($piece->square->file<9)&&(($piece->square->rank==0)||($piece->square->rank<9))) {
                        if ((($piece->group == 'ROYAL') || ($piece->group== 'SEMIROYAL'))) {
							/*
							if(($piece->square->rank==0)&&($piece->color==1)&& ($this->whitecanfullmoveinowncastle == 0)){
								$this->whitecanfullmoveinowncastle = 1; //White Can full move
								$count=$count+1;
								}
							if(($piece->square->rank==9)&&($piece->color==2)&& ($this->blackcanfullmoveinowncastle == 0)){
									$this->blackcanfullmoveinowncastle = 1; //Black Can full move
									$count=$count+1;
									}
							*/		

							if(($piece->square->rank==9)&&($piece->color==1)&& ($this->whitecanfullmoveinfoecastle == 0)){
									$this->whitecanfullmoveinfoecastle = 1; //Can fullmove
									$count=$count+1;
								}
							if(($piece->square->rank==0)&&($piece->color==2)&& ($this->blackcanfullmoveinfoecastle == 0)){
									$this->blackcanfullmoveinfoecastle = 1; //Can fullmove
									$count=$count+1;
								}								
							if($count==4) break;
                        }
					elseif ((($piece->group == 'OFFICER') || ($piece->group== 'SOLDIER'))) {
						/*
						if(($piece->square->rank==0)&&($piece->color==1)&& ($this->whitecanfullmoveinowncastle == 0)){
							$this->whitecanfullmoveinowncastle = 1; //White Can full move
							$count=$count+1;
							}
						if(($piece->square->rank==9)&&($piece->color==2)&& ($this->blackcanfullmoveinowncastle == 0)){
								$this->blackcanfullmoveinowncastle = 1; //Black Can full move
								$count=$count+1;
								}
						*/		

						if(($piece->square->rank==9)&&($piece->color==1)&& ($this->whitecanfullmoveinfoecastle == 0)){
								$this->whitecanfullmoveinfoecastle = 1; //Can fullmove
								$count=$count+1;
							}
						if(($piece->square->rank==0)&&($piece->color==2)&& ($this->blackcanfullmoveinfoecastle == 0)){
								$this->blackcanfullmoveinfoecastle = 1; //Can fullmove
								$count=$count+1;
							}								
						if($count==4) break;
					}	
                    }
					
				}
			}
		}
		if($count>=1)
			return TRUE;
		if($count==0)
		return FALSE;
	}

	function get_general_on_castle_for_full_move($color): bool {

		$count=0;
		$color=1;

		foreach ( $this->board as $RankData ) {
			foreach ( $RankData as $piece ) {
				if ( $piece ) {
                    if (($piece->square->file>0)&&($piece->square->file<9)&&(($piece->square->rank==0)||($piece->square->rank<9))) {
                        if ((($piece->group == 'OFFICER') && ($piece->type== ChessPiece::GENERAL))) {
							/*
							if(($piece->square->rank==0)&&($piece->color==1)&& ($this->whitecanfullmoveinowncastle == 0)){
								$this->whitecanfullmoveinowncastle = 1; //White Can full move
								$count=$count+1;
								}
							if(($piece->square->rank==9)&&($piece->color==2)&& ($this->blackcanfullmoveinowncastle == 0)){
									$this->blackcanfullmoveinowncastle = 1; //Black Can full move
									$count=$count+1;
									}
							*/

							if(($piece->square->rank==9)&&($piece->color==1)&& ($this->whitecanfullmoveinfoecastle == 1)){
									$this->whitecanfullmoveinfoecastle = 1; //Can fullmove
									$count=$count+1;
								}
							elseif(($piece->square->rank==9)&&($piece->color==1)&& ($this->whitecanfullmoveinfoecastle == 0)){
									//cannot full move
									$count=$count+1;
								}								
							if(($piece->square->rank==0)&&($piece->color==2)&& ($this->blackcanfullmoveinfoecastle == 1)){
									$this->blackcanfullmoveinfoecastle = 1; //Can fullmove
									$count=$count+1;
								}
							if(($piece->square->rank==0)&&($piece->color==2)&& ($this->blackcanfullmoveinfoecastle == 0)){
									//cannot full move
									$count=$count+1;
								}								
							if($count==4) break;
                        }
                    }
				}
			}
		}
		if($count>=1)
			return TRUE;
		if($count==0)
		return FALSE;
	}

	function get_royals_on_warZone_for_full_move($color): bool {
		//$blackcanfullmove = 1;
		//$whitecanfullmove = 1;
		$count=0;
		$color=1;

		foreach ( $this->board as $RankData ) {
			foreach ( $RankData as $piece ) {
				if ( $piece ) {
                    if (($piece->square->file>0)&&($piece->square->file<9)&&($piece->square->rank>0)&&($piece->square->rank<9)) {
                        if ((($piece->group == 'ROYAL') || ($piece->group== 'SEMIROYAL'))) {
							if(($piece->color==1)&& ($this->whitecanfullmove == 0)){
								$this->whitecanfullmove = 1; //Can move fully
								$this->whitescanfullmove = 1; //S Can move fully
								$count=$count+1;
								}
							if(($piece->color==2)&& ($this->blackcanfullmove == 0)){
									$this->blackcanfullmove = 1; //Can move fully
									$this->blackscanfullmove = 1; //S Can move fully
									$count=$count+1;
								}
							if($count==2) break;
                        }
                    }
					
				}
			}
		}
		if($count>=1)
			return TRUE;
		if($count==0)
		return FALSE;
	}

	function get_general_on_warZone_for_full_move($color): bool {
		//$blackcanfullmove = 1;
		//$whitecanfullmove = 1;
		$count=0;
		$color=1;

		foreach ( $this->board as $RankData ) {
			foreach ( $RankData as $piece ) {
				if ( $piece ) {
                    if (($piece->square->file>0)&&($piece->square->file<9)&&($piece->square->rank>0)&&($piece->square->rank<9)) {
                        if ((($piece->group == 'OFFICER') && ($piece->type== ChessPiece::GENERAL))) {
							if(($piece->color==1) && ( $this->whitecanfullmove == 1)){
								$this->whitecanfullmove = 1; //Can move fully
								$count=$count+1;
								}
							elseif(($piece->color==1)&& ($this->whitecanfullmove == 0)){
									$this->whitecanfullmove = 1; //Can move fully
									$count=$count+1;
									}								
							if(($piece->color==2)&& ($this->blackcanfullmove == 1)){
									$this->blackcanfullmove = 1; //Can move fully
									$count=$count+1;
								}
							elseif(($piece->color==2)&& ($this->blackcanfullmove == 0)){
									$count=$count+1;
									$this->blackcanfullmove = 1; //Can move fully
								}								
							if($count==2) break;
                        }
                    }
				}
			}
		}
		if($count>=1)
			return TRUE;
		if($count==0)
			return FALSE;
	}

	function get_royals_on_warZone($color): ?ChessSquare {
		//Echo '<li> ChessBoard.php 13# function get_king_square called </li>';	
		foreach ( $this->board as $RankData ) {
			////echo '<br/>';
			foreach ( $RankData as $piece ) {
				if ( $piece ) {
                    if (($piece->square->file>0)&&($piece->square->file<9)&&($piece->square->rank>0)&&($piece->square->rank<9)) {
                        ////echo ' Actual = '.$piece->type.' Expected = '.ChessPiece::KING;
                        if ((($piece->type == ChessPiece::KING) || ($piece->type == ChessPiece::INVERTEDKING) ||($piece->type == ChessPiece::ANGRYKING)||
                        ($piece->type == ChessPiece::ANGRYINVERTEDKING)||($piece->type == ChessPiece::SPY)||($piece->type == ChessPiece::ARTHSHASTRI)||($piece->type == ChessPiece::ANGRYARTHSHASTRI)/*||
                        ($piece->type == ChessPiece::SPY)||($piece->type == ChessPiece::SPYWRAAJDAND)||($piece->type == ChessPiece::SPYWARTHDAND)||
                        ($piece->type == ChessPiece::ANGRYKINGWARTHDAND)||($piece->type == ChessPiece::ANGRYARTHSHASTRIWRAAJDAND)||($piece->type == ChessPiece::ANGRYINVERTEDKINGWARTHDAND)*/)
                        && ($piece->color == $color)) {
                            return $piece->square; // Royal is in War Zone.. So, we can return
                        }
                    }
				}
			}
		}
		return NULL;
	}

	function get_compromised_castles() {
		$j=0;
		$castletocheck=1;
		
		for (; $castletocheck <= 2; $castletocheck++) { /**Loop through castle . Any side can enter castle*/
			if ($castletocheck==1) {
				$j=0;
				}
			elseif ($castletocheck==2) {
				$j=9;
				}
			for ($i = 1; $i <= 8; $i++) { /**Loop through castle . Any side can enter castle*/				

				if (!$this->board[$j][$i]) {
					continue;
				}

				if((($this->board[$j][$i]->group=='ROYAL') || ($this->board[$j][$i]->group=='SEMIROYAL') ||
				($this->board[$j][$i]->group=='NOBLE')) &&($this->board[$j][$i]->color!=$castletocheck)){//Compromised
					if($j==0)$this->wbrokencastle=true;
					if($j==9)$this->bbrokencastle=true;
				}

				//Opponent Army
				if(($this->board[$j][$i]->group!='ROYAL')&&($this->board[$j][$i]->group!='SEMIROYAL')&&
				($this->board[$j][$i]->group!='NOBLE')&&($this->board[$j][$i]->color!=$castletocheck)){//Compromised
					if($j==0)$this->wbrokencastle=true;
					if($j==9)$this->bbrokencastle=true;				}
				else
					continue;
			}
		}
	}	

	function remove_piece_from_square(ChessSquare $square): void {
		//Echo '<li> ChessBoard.php 14# function remove_piece_from_square called </li>';	

		$rank = $square->rank;
		$file = $square->file;
	
		$this->board[$rank][$file] = NULL;
	}
	
	function count_pieces_on_rank($type, int $rank, $color): int {
		//Echo '<li> ChessBoard.php 15# function count_pieces_on_rank called </li>';	
		
		$count = 0;
		
		for ( $i = 0; $i <= 9; $i++ ) {
			$piece = $this->board[$rank][$i];
			
			if ( $piece ) {
				if ( $piece->type == $type && $piece->color == $color ) {
					$count++;
				}
			}
		}
		
		return $count;
	}
	
	function count_pieces_on_file($type, int $file, $color): int {
		//Echo '<li> ChessBoard.php 16# function count_pieces_on_file called </li>';	

		$count = 0;
		
		for ( $i = 0; $i <= 9; $i++ ) {
			$piece = $this->board[$i][$file];
			
			if ( $piece ) {
				if ( $piece->type == $type && $piece->color == $color ) {
					$count++;
				}
			}
		}
		return $count;
	}
}