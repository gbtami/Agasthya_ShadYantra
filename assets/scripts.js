
$(document).ready(function(){
		var p1name='',p2name='';
		var kingmove=false;
		var arthshastrimove=false;
		var officermove=false;
		var soldiermove=false;
		var spymove=false;
		
		var olelemnt;
		var oname;
		var optionn;
		var lastsquare;
		var lastcolor;
		var history='';
        var item = {};
		var oldsquare = null;
		var newsquare = null;
		var coordinate_notation = '';
		var option_tag_in_select_tag = null;

		var myAudio = document.createElement('audio');
		myAudio.controls = true;
		myAudio.src = 'assets/move.mp3';
		//var failedAudio = document.createElement('audio');
		//failedAudio.controls = true;
		//failedAudio.src = 'Your File';

		$("#moves option").each(function() {

		//var failedAudio = document.createElement('audio');
		//failedAudio.controls = true;
		//failedAudio.src = 'Your File';
		$('form#winninggame').hide();	$('form#king_endgame').hide(); $('form#king_surrender').hide();
			
		if ($('select#moves option').length == 0) {
			$('form#all_moves').hide(); $('form#winninggame').hide(); $('form#history_move').hide();	$('form#make_move').hide();
		}
		//debugger
		$("textarea#playerta").val("");
		$("textarea#opponentta").val("");
		
	var color_to_move='',opp_color_to_move='';

	if(($("div.status_box").attr('id')=='1')){
	color_to_move='white';opp_color_to_move='black';
	}
	else if(($("div.status_box").attr('id')=='2')){
	color_to_move='black';opp_color_to_move='white';
	}
	 
	if(color_to_move!=''){
		if($("input#"+color_to_move+"officerscanmovefull").val()=='0')
			$("textarea#playerta").val($("textarea#playerta").val()+"* Your ("+color_to_move+ ") Military Officials can move only 1 step in WARZONE. Reason: There is NO Coordinator.\n");
		if($("input#"+color_to_move+"officerscanmovefull").val()=='1')
			$("textarea#playerta").val($("textarea#playerta").val()+"* All Military Officials can move full steps in WARZone.\n");
		if($("input#"+color_to_move+"officerscankill").val()=='0')
			$("textarea#playerta").val($("textarea#playerta").val()+"* Your ("+color_to_move+ ") Military Officials CANNOT STRIKE the Opponent. Reason: King is interested in Domestic Affairs.\n");
		if($("input#"+color_to_move+"officerscankill").val()=='1')
			$("textarea#playerta").val($("textarea#playerta").val()+"* All Military Officials can kill. Reason: King has declared the war or King is not involved in domestic affairs\n");
			
		//$("textarea#opponentta").val($("textarea#opponentta").val()+"\:: Your Opponent Details:: \n");	
		if($("input#"+opp_color_to_move+"officerscanmovefull").val()=='0')
			$("textarea#opponentta").val($("textarea#opponentta").val()+"** "+opp_color_to_move+" Millitary Officials can move only 1 step in WARZONE. \n");
		if($("input#"+opp_color_to_move+"officerscanmovefull").val()=='1')
			$("textarea#opponentta").val($("textarea#opponentta").val()+"** "+opp_color_to_move+" Millitary Officials can move full steps in WARZONE. So be Cautious.\n");
		if($("input#"+opp_color_to_move+"officerscankill").val()=='0')
			$("textarea#opponentta").val($("textarea#opponentta").val()+"** "+opp_color_to_move+" Military Officials cannot kill anyone in war. Their King has not declared the war or is involved in domestic affairs.\n");
		if($("input#"+opp_color_to_move+"officerscankill").val()=='1')
			$("textarea#opponentta").val($("textarea#opponentta").val()+"** "+opp_color_to_move+" Military Officials Military Officials has rights to STRIKE. So be Cautious\n");
	}
	

	function getinitServerData(){
		jsonObj = [];

        // Add JSON to localStorage under serverData
        localStorage.setItem("serverData", JSON.stringify(jsonObj));
		history = '';		
		$("#history").val(function() {
				return history;
		});
			history='';
			coordinate_notation='';				
		}

	function retrieveAndSetinitData(){
		var temp = JSON.parse(localStorage.getItem("serverData"));
	
		history = '';
		
		$.each(temp, function(key,value) {
			history = history+ ' '+value.data;
			});
		
		$("#history").val(function() {
				return history;
		});
			history='';
			coordinate_notation='';						
	}
	

		function getServerData(){
		jsonObj = [];

        var val = option_tag_in_select_tag.val();
        var html = option_tag_in_select_tag.html();
		var data = option_tag_in_select_tag.attr('data-coordinate-notation');

        item = {}
        item ["val"] = val;
        item ["html"] = html;
        item ["data"] = data;

        jsonObj.push(item);
		console.log(jsonObj);
	
        // Add JSON to localStorage under serverData
        localStorage.setItem("serverData", JSON.stringify(jsonObj));
		history = '';
		$.each(temp, function(key,value) {
			history = history+ ' '+value.data;
			});
		
		$("#history").val(function() {
				return history;
		});
			history='';
			coordinate_notation='';				
		}

	function retrieveAndSetData(){
		var temp = JSON.parse(localStorage.getItem("serverData"));
		// Do stuff with JSON data
	
        var val = option_tag_in_select_tag.val();
        var html = option_tag_in_select_tag.html();
		var data = option_tag_in_select_tag.attr('data-coordinate-notation');

        item = {}
        item ["val"] = val;
        item ["html"] = html;
        item ["data"] = data;
	
		temp.push(item);
		localStorage.setItem("serverData", JSON.stringify(temp));

		history = '';
		
		$.each(temp, function(key,value) {
			history = history+ ' '+value.data;
			});
		
		$("#history").val(function() {
				return history;
		});
			history='';
			coordinate_notation='';						
	}


				if (typeof (Storage) != "undefined"){
					if (!localStorage.getItem("serverData")){
						// Ajax JSON to get server information
						getinitServerData();
						}
					else
						{
						retrieveAndSetinitData();
						}
					}
				else
					{
					alert("localStorage unavailable!");
					}
			
	$('select#move').dblclick(function(){
		$('#make_move').submit();
		myAudio.play();
	});

	$('select#surrendermove').dblclick(function(){
		$('#king_surrender').submit();
		myAudio.play();
	});
	
	$('select#endgamemove').dblclick(function(){
		$('#king_endgame').submit();
		myAudio.play();
	});
	
	
	function simple(event){
		var i =0;var oop;	var tempi=0;
		p1name = $(this).attr('name');
		
		if(lastsquare!=null){
			lastsquare.css('background-color',lastcolor);
			lastsquare	=null; 	lastcolor =null;
		}	

		if(lastsquare==null){
			lastcolor=$(this).closest('td').css('background-color');
			$(this).closest('td').css('background-color', 'blue');
			lastsquare=$(this).closest('td');
		}

		$("#move").empty();
		$("#moves option").each(function() {
			//debugger
			var val = $(this).val();
				var txt = $(this).html();
			var dataa = $(this).data('coordinate-notation');
			txt=txt.trim();
			if(txt.substr(0,1)==p1name){
				$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
				tempi=tempi+1;
				}
			i=i+1;
			});
		$("#move_count").html(tempi);			
		}
	$('.draggable_piece').on("click", function(event) {
		
		var i =0;var oop;var tempi=0;var tname='';var dname='';
		p1name = $(this).attr('name');
		if(lastsquare!=null){
			lastsquare.css('background-color',lastcolor);
			lastsquare	=null; 	lastcolor =null;
		}

			$('form#winninggame').hide();$('form#king_endgame').hide(); $('form#king_surrender').hide();	kingmove=false;
			$('form#make_move').hide();
			$("#winninggamemove").empty();	$("#move").empty();

			if((p1name.toLowerCase()=='i')||(p1name.toLowerCase()=='u')||(p1name.toLowerCase()=='y'))
				kingmove=true;				
			else if((p1name.toLowerCase()=='a')||(p1name=='á')||(p1name=='Á')){
				arthshastrimove=true;
				}
			else if(p1name.toLowerCase()=='p'){
				soldiermove=true;
				}
			else if(p1name.toLowerCase()=='c'){
				spymove=true;
				}
			else if((p1name.toLowerCase()=='g')||(p1name.toLowerCase()=='h')||(p1name.toLowerCase()=='m')||(p1name.toLowerCase()=='s')){
				officermove=true;
				}				
				
		/*
		$("#moves option").each(function() {
			var piece='';			
			piece=$(this).html().trim();
			if((piece.substr(0,1)====p1name)&&(((p1name.toLowerCase()=='i')||(p1name.toLowerCase()=='j')||(p1name.toLowerCase()=='u')||(p1name.toLowerCase()=='y')) &&((piece.substr(0,1)==p1name)) )){
				$('form#king_endgame').show(); $('form#king_surrender').show();	kingmove=true;
				}	
			else if((piece.substr(0,1)====p1name)&&(((p1name.toLowerCase()=='a')||(p1name=='á')||(p1name=='Á')))){
				arthshastrimove=true;
				//$('form#winninggame').show();
				}
			if((piece.substr(0,1)==p1name)){
				$('form#make_move').show();
				}
			});
		*/
			
		if ($('select#winninggamemove option').length == 0) {
			$('form#winninggame').hide();
			$("#winninggamemove").empty();	
		}
		
		if ($('select#endgamemove option').length == 0) {
			$('form#king_endgame').hide();
		}
		
		if ($('select#surrendermove option').length == 0) {
			$('form#king_surrender').hide();
		}					
		
		
		if(lastsquare==null){
			lastcolor=$(this).closest('td').css('background-color');
			$(this).closest('td').css('background-color', 'blue');
			lastsquare=$(this).closest('td');
		}

		lastsquare=$(this).closest('td');
		p2name=$(this).closest('td').attr('id').substr(0,2);
		//alert (p2name);
		
		$("#move").empty();	$("#winninggamemove").empty(); $("#endgamemove").empty(); $("#surrendermove").empty();

		$("#moves option").each(function() {
			var val = $(this).val();
			var txt = $(this).html();
			var dataa = $(this).data('coordinate-notation');
			txt=txt.trim();
			if(txt.substr(1,1)=='*') { tname=txt.substr(2,2); dname=txt.substr(4,2)}
			if(txt.substr(1,1)!='*') { tname=txt.substr(1,2); dname=txt.substr(3,2)}
			
			if((txt.substr(0,1)==p1name)&&(p2name==tname)){

				//ArthShastri is in CASTLE or opponent CASTLE. If General is in Truce then it means Army will have to retreat. If King or Arsthshastri is in War then retreat will not happen.
				if(kingmove==true)
				debugger

				if((arthshastrimove==true)&& (/[a-h09]{2,2}/.test(dname))){
					if ((txt.indexOf("=Ä") >= 0)){
						$("#winninggamemove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						$('form#winninggame').show();
						}
					else{
						$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						}						
					}
				//Officers	winning the scepters
				else if(((spymove==true)||(officermove==true)||(soldiermove==true))&& (/[a-h09]{2,2}/.test(dname))){
					if ((txt.indexOf("Ö")>=0)||(txt.indexOf("#") >= 0)){
						$("#winninggamemove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						$('form#winninggame').show();
						}
					else{
						$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						}
					}
				//TRUCE to No Mans
				else if((kingmove==true)&& ((((/[x0]{2,2}/.test(p2name))||(/[y0]{2,2}/.test(p2name)))&&(/[xy09]{2,2}/.test(dname)))|| (((/[x9]{2,2}/.test(p2name))||(/[y9]{2,2}/.test(p2name)))&&(/[xy09]{2,2}/.test(dname))))){
					//No Inversion in TRUCE
					if ((txt.indexOf("=Y") >= 0)||(txt.indexOf("=J") >= 0)){
						$("#surrendermove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						$('form#king_surrender').show();
						}
					else
					if ((txt.indexOf("=U") >= 0)||(txt.indexOf("=I") >= 0)||(txt.indexOf("=") >= -1)){
						$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						}
					else	
					if ((txt.indexOf("=V") >= 0)||(txt.indexOf("#") >= 0)){
						$("#winninggamemove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						$('form#winninggame').show();
						}
					}
				//Truce to Truce	
				else if((kingmove==true)&& ((/[xy0-8]{2,2}/.test(p2name)) &&(/[xy0-8]{2,2}/.test(dname)))){
					if ((txt.indexOf("=Y") >= 0)){
						$("#surrendermove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						$('form#king_surrender').show();
						}
					else
					if ((txt.indexOf("=U") >= 0)||(txt.indexOf("=") >= -1)){
						$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						}
					}
				//TRUCE to WAR
				else if((kingmove==true)&& ((/[xy0-8]{2,2}/.test(p2name)) &&(/[a-h1-8]{2,2}/.test(dname)))){
					if ((txt.indexOf("=Y") >= 0)){
						$("#endgamemove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						$('form#king_endgame').show();
						}
					else
					if ((txt.indexOf("=U") >= 0)||(txt.indexOf("=") >= -1)){
						$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						}
					}
				//TRUCE to CASTLE	
				else if((kingmove==true)&& ((((/[x0]{2,2}/.test(p2name))||(/[y0]{2,2}/.test(p2name)))&&(/[ah0]{2,2}/.test(dname)))|| (((/[x9]{2,2}/.test(p2name))||(/[y9]{2,2}/.test(p2name)))&&(/[ah0]{2,2}/.test(dname))))){
					//No Inversion in TRUCE
					if ((txt.indexOf("=Y") >= 0)){
						$("#surrendermove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						$('form#king_surrender').show();
						}
					else
					if ((txt.indexOf("=U") >= 0)||(txt.indexOf("=") >= -1)){
						$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						}
					else	
					if ((txt.indexOf("=V") >= 0)||(txt.indexOf("#") >= 0)){
						$("#winninggamemove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						$('form#winninggame').show();
						}
					}
				//War to Truce	
				else if((kingmove==true)&& ((/[xy09]{2,2}/.test(dname)) &&(/[a-h1-8]{2,2}/.test(p2name)))){
					if ((txt.indexOf("=Y") >= 0)){
						$("#surrendermove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						$('form#king_surrender').show();
						}
					else
					if ((txt.indexOf("=U") >= 0)||(txt.indexOf("=") >= -1)){
						$("#endgamemove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						$('form#king_endgame').show();
						}
					}
				// Within CASTLE Scepter
				else if((kingmove==true)&& (((/[a-h9]{2,2}/.test(p2name))&&(/[d-e9]{2,2}/.test(dname)))|| ((/[a-h0]{2,2}/.test(p2name)&&(/[d-e0]{2,2}/.test(dname)))))){
					//No Draw in CASTLE
					if ((txt.indexOf("=Y") >= 0)||(txt.indexOf("=J") >= 0)){
						$("#surrendermove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						$('form#king_surrender').show();
						}
					else
					if ((txt.indexOf("=U") >= 0)||(txt.indexOf("=I") >= 0)||(txt.indexOf("=") >= -1)){
						$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						}
					else	
					if ((txt.indexOf("=V") >= 0)||(txt.indexOf("#")>=0)){
						$("#winninggamemove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						$('form#winninggame').show();
						}
					}
				//Within CASTLE
				else if((kingmove==true)&& (((/[a-h9]{2,2}/.test(p2name))&&(/[a-h9]{2,2}/.test(dname)))|| ((/[a-h0]{2,2}/.test(p2name))&&(/[a-h0]{2,2}/.test(dname))))){
					if ((txt.indexOf("=Y") >= 0)||(txt.indexOf("=J") >= 0)){
						$("#surrendermove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						$('form#king_surrender').show();
						}
					else
					if ((txt.indexOf("=U") >= 0)||(txt.indexOf("=I") >= 0)||(txt.indexOf("=V")>=0)||(txt.indexOf("#")>=0)||(txt.indexOf("=") >= -1)){
						$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						}
					}
				//CASTLE to WAR
				else if((kingmove==true)&& ((/[a-h1-8]{2,2}/.test(dname))&&(/[a-h09]{2,2}/.test(p2name)))){
					if ((txt.indexOf("=Y") >= 0)){
						$("#endgamemove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
									$('form#king_endgame').show();
						}
					else
					if ((txt.indexOf("=U") >= 0)||(txt.indexOf("=") >= -1)){
						$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						}
					}
				//WAR to CASTLE
				else if((kingmove==true)&& ((/[a-h09]{2,2}/.test(dname)&&(/[a-h1-8]{2,2}/.test(p2name))))){
					if ((txt.indexOf("=Y") >= 0)){
						$("#surrendermove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
									$('form#king_surrender').show();
						}
					else
					if ((txt.indexOf("=U") >= 0)||(txt.indexOf("=") >= -1)){
						$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						}
					}
				//WAR to WAR
				else if((kingmove==true)&& ((/[a-h1-8]{2,2}/.test(dname)&&(/[a-h1-8]{2,2}/.test(p2name))))){
					if ((txt.indexOf("=Y") >= 0)){
						$("#endgamemove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
									$('form#king_endgame').show();
						}
					else
					if ((txt.indexOf("=U") >= 0)||(txt.indexOf("=") >= -1)){
						$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						}
					}
				//CASTLE to No Mans
				else if((kingmove==true)&& ((((/[x]{2,2}/.test(dname)))&&(((/[09]{2,2}/.test(p2name))&&(/[089]{2,2}/.test(dname)))|| ((/[09]{2,2}/.test(p2name))&&(/[089]{2,2}/.test(dname))))) ||(((/[y]{2,2}/.test(dname)))&&(((/[09]{2,2}/.test(p2name))&&(/[089]{2,2}/.test(dname)))|| ((/[09]{2,2}/.test(p2name))&&(/[089]{2,2}/.test(dname))))))){
					//debugger					
					if ((txt.indexOf("=Y") >= 0)){
						$("#endgamemove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							$('form#king_endgame').show();

						}
					else
					if ((txt.indexOf("=U") >= 0)){
						$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						}
					else{
						$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						}						
					}
				//CASTLE to TRUCE
				else if((kingmove==true)&& ((((/[x]{2,2}/.test(dname)))&&(((/[9]{2,2}/.test(p2name))&&(/[1-8]{2,2}/.test(dname)))|| ((/[0]{2,2}/.test(p2name))&&(/[1-8]{2,2}/.test(dname)))))||(((/[y]{2,2}/.test(dname)))&&(((/[9]{2,2}/.test(p2name))&&(/[1-8]{2,2}/.test(dname)))|| ((/[0]{2,2}/.test(p2name))&&(/[1-8]{2,2}/.test(dname))))))){

					if ((txt.indexOf("=Y") >= 0)){
						$("#surrendermove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							$('form#king_surrender').show();
						}
					else
					if ((txt.indexOf("=U") >= 0)){
						$("#endgamemove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							$('form#king_endgame').show();

						}
					}
				else if((kingmove==true)&& (/[1-8]{2,2}/.test(p2name))){
				//(p2name.indexOf('1')||(p2name.indexOf('2')>=0)||(p2name.indexOf('3')>=0)||(p2name.indexOf('4')>=0)||(p2name.indexOf('5')>=0)||(p2name.indexOf('6')>=0)||(p2name.indexOf('7')>=0)||(p2name.indexOf('8')>=0))){
					if ((txt.indexOf("=Y") >= 0)){
						$("#endgamemove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							$('form#king_endgame').show();
						}
					else{
						$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						}
					}
				else if((/[a-h0-9]{2,2}/.test(dname))){
					if ((txt.indexOf("#") >= 0)){
						$("#winninggamemove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						$('form#winninggame').show();
						}
					else{
						$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						}						
					}					
				else{
					$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
					tempi=tempi+1;
					}					
			}
		i=i+1;
		
	});





$("textarea#player1ta").val("");
$("textarea#player2ta").val("");

	if(color_to_move!=''){
		if(kingmove==true){
			$("div#player1 label").html("Rules for King (#I Means Indra or King)");	
			//if($("input#"+color_to_move+"officerscanmovefull").val()=='0')
			$("textarea#player1ta").val($("textarea#player1ta").val()+"* 'I' can move only 1 step at a time. 'I' can kill. #I01#");
			$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'I' can move 1 or 2 steps like Knights in his own CASTLE. Castle itself is Royal and 'I' is aware of every area. #I02# #I03#");
			$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'I' can move n number or Times 'To and From' any Zones with the help of Royal or Semi-Royal members only. #I04# ");
			$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* Only 'I' can declare war at his side by leaving the Scepter. Declaration of war helps the Army Officers to Strike the opponent; Otherwise Army cannot strike but only move. #I05");			
			$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'I' can promote any surrounding Military members on the move or even as a simple promotion without moves. #I06# ");
			$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'I' when enters the opponent CASTLE becomes the Emperor or Vikramaditya (IndraJeet). War Ends and opponent loses.");
			$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* Army when enters the opponent CASTLE makes the 'I' Emperor or Vikramaditya (IndraJeet). War Ends and opponent loses. Here, 'A' also gets promoted.");
			$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'A' when enters the opponent CASTLE makes the 'I' Emperor or Vikramaditya (IndraJeet). War Ends and opponent loses. Here, 'A' also gets promoted.");
			$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* Only 'I' can suggest 'Army-Recall' by getting into Truce Zone.");
			$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* Only 'I' can suggest 'Truce and Army-Recall' by getting into Truce Zone's special Boundary Area.");
			$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* Only 'I' can suggest 'Sandhi' even in the WAR-Zone.");						
			$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* Only 'I' can Accept his Defeat in CASTLE. No Sandhi is allowed in CASTLE.");
			$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* Only 'I' can Accept his Defeat in TRUCE. No Sandhi is allowed in TRUCE.");						
			$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* Only 'I' can Accept his Defeat in No Mans Land. No Sandhi is allowed in TRUCE.");						
			$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* Only 'I' can Accept his Defeat in No Mans Land. No Sandhi is allowed in TRUCE.");
			$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* In Order to make Army to move to Full strength in any Specific Zone any of the Royal or Semi-Royal should be present in that Zone.");
			$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'I' gets permanantly hidden in Naag-Lok or No-Mans land. War still goes on.");
	
			$("div#player2 label").html("Exceptions in Rules for King");	
			//if($("input#"+color_to_move+"officerscanmovefull").val()=='0')
			$("textarea#player2ta").val($("textarea#player2ta").val()+"#I01# If Royal is surrounded with Royal or Semi-Royal in same zone then these Royal or Semi-Royal can move like Knight.");
			$("textarea#player2ta").val($("textarea#player2ta").val()+"\n#I02# King require help 'To move-in or move-out' of his own Compromised CASTLE.");
			$("textarea#player2ta").val($("textarea#player2ta").val()+"\n#I03# Kings own Compromised CASTLE becomes Secondary War-Zone.");
			$("textarea#player2ta").val($("textarea#player2ta").val()+"\n#I04# King doesn't need any help 'To move-in or move-out' of Opponent's Compromised CASTLE.");	
			$("textarea#player2ta").val($("textarea#player2ta").val()+"\n#I05# Army can Strike only of 'I' and 'A' both are not idle. (Still has defects to be fixed)");	
			$("textarea#player2ta").val($("textarea#player2ta").val()+"\n#I06# Parity of Ranks are maintained. Only 1 General, 2 Knights, 2 Gajarohi, 2 MahaRathis allowed.");	
			
	}
	
		if(spymove==true){
			$("div#player1 label").html("Rules for Chaaran (#C Means Chaaran or Spy)");	
			//if($("input#"+color_to_move+"officerscanmovefull").val()=='0')
			$("textarea#player1ta").val($("textarea#player1ta").val()+"* 'C' can move only 1 step at a time.  'S' CANNOT kill. #S01#");
			$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'C' can move 1 or 2 steps like Knights in his own CASTLE. Castle itself is Royal and 'C' is aware of every area. #S02# #S03#");
			$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'C' can move n number or Times 'To and From' any Zones with the help of Royal or Semi-Royal members only. #S04# ");
			$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'C' can promote any surrounding Military members on the move or even as a simple promotion without moves. #S05# ");
			$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'C' can promote himself as optional in Opponent CASTLE without any help. This is exceptional honor");
			
			$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* In Order to make Army to move to Full strength in any Specific Zone any of the Royal or Semi-Royal should be present in that Zone.");
			$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'C' gets permanantly hidden in Naag-Lok or No-Mans land. War still goes on.");
			
			$("div#player2 label").html("Exceptions in Rules for 'C'");	
			//if($("input#"+color_to_move+"officerscanmovefull").val()=='0')
			$("textarea#player2ta").val($("textarea#player2ta").val()+"#S01# If Royal is surrounded with Royal or Semi-Royal in same zone then these Royal or Semi-Royal can move like Knight.");
			$("textarea#player2ta").val($("textarea#player2ta").val()+"\n#S02# 'C' require help 'To move-in or move-out' of his own Compromised CASTLE.");
			$("textarea#player2ta").val($("textarea#player2ta").val()+"\n#S03# 'C's own Compromised CASTLE becomes Secondary War-Zone.");
			$("textarea#player2ta").val($("textarea#player2ta").val()+"\n#S04# 'C' doesn't need any help 'To move-in or move-out' of Opponent's Compromised CASTLE.");	
			$("textarea#player2ta").val($("textarea#player2ta").val()+"\n#S05# Parity of Ranks are maintained. Only 1 General, 2 Knights, 2 Gajarohi, 2 MahaRathis allowed.");	
			
	}

		if(arthshastrimove==true){
			$("div#player1 label").html("Rules for ArthShastri (#A Means ArthShastri or Prime Minister)");	
			//if($("input#"+color_to_move+"officerscanmovefull").val()=='0')
			$("textarea#player1ta").val($("textarea#player1ta").val()+"*'A' can move only 1 step at a time. 'A' CANNOT kill. #A01#");
			$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'A' can move 1 or 2 steps like Knights in his own CASTLE. Castle itself is Royal and 'A' is aware of every area. #A02# #A03#");
			$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'A' can move n number or Times 'To and From' any Zones with the help of Royal or Semi-Royal members only. #A04# ");
			$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'A' can promote any surrounding Military members on the move or even as a simple promotion without moves. #A05# ");
			
			$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*In Order to make Army to move to Full strength in any Specific Zone any of the Royal or Semi-Royal should be present in that Zone.");
			$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'A' gets permanantly hidden in Naag-Lok or No-Mans land. War still goes on.");
			$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*King when enters the opponent CASTLE becomes the Emperor or Vikramaditya (IndraJeet). War Ends and opponent loses. Here, 'A' also gets promoted.");
			$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*Army when enters the opponent CASTLE also makes the King Emperor or Vikramaditya (IndraJeet). War Ends and opponent loses. Here, 'A' also gets promoted.");
			$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'A' when enters the opponent CASTLE also makes the King Emperor or Vikramaditya (IndraJeet). War Ends and opponent loses. Here, 'A' also gets promoted.");
			$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'A' if is idle then make the Soldiers and Army Strikeless. #A06#");
			$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'A' if dies then make the Soldiers and Army and permanently Strikeless. #A06#");
			$("textarea#player1ta").val($("textarea#player1ta").val()+"\nArmy can Strike only of 'I' and 'A' both are not idle. (Still has defects to be fixed)");	
			
			$("div#player2 label").html("Exceptions in Rules for ArthShastri (ArthShashtri Code has to many bugs");	
			//if($("input#"+color_to_move+"officerscanmovefull").val()=='0')
			$("textarea#player2ta").val($("textarea#player2ta").val()+"#A01# If Royal is surrounded with Royal or Semi-Royal in same zone then these Royal or Semi-Royal can move like Knight.");
			$("textarea#player2ta").val($("textarea#player2ta").val()+"\n#A02# 'A' require help 'To move-in or move-out' of his own Compromised CASTLE.");
			$("textarea#player2ta").val($("textarea#player2ta").val()+"\n#A03# 'A' own Compromised CASTLE becomes Secondary War-Zone.");
			$("textarea#player2ta").val($("textarea#player2ta").val()+"\n#A04# 'A' doesn't need any help 'To move-in or move-out' of Opponent's Compromised CASTLE.");	
			$("textarea#player2ta").val($("textarea#player2ta").val()+"\n#A05# Parity of Ranks are maintained. Only 1 General, 2 Knights, 2 Gajarohi, 2 MahaRathis allowed.");	
			$("textarea#player2ta").val($("textarea#player2ta").val()+"\n#A06# Kautilya Modified this rule and made Army Units as Autonomous and Self-Sustaining.");
			
	}		
	
	}
	









	
	//debugger
		if ($('select#winninggamemove option').length > 0) {
			$('form#winninggame').show();
		}
		else $('form#winninggame').hide();


		if ($('select#endgamemove option').length > 0) {
			$('form#Iing_endgame').show();
		}	else $('form#Iing_endgame').hide();

		
		if ($('select#surrendermove option').length > 0) {
			$('form#Iing_surrender').show();	
		}	else $('form#Iing_surrender').hide();
		
		if ($('select#move option').length > 0) {
			$('form#make_move').show();	
		}	else $('form#make_move').hide();
		
		$("#move_count").html(tempi);
	});
	
	$('.draggable_piece').on("dragstart", function (event) {
		var i =0;var oop; var tempi=0;
		p1name = $(this).attr('name');
		
		if(lastsquare!=null){
			lastsquare.css('background-color',lastcolor); lastsquare=null; lastcolor =null;
			}

		if(lastsquare==null){
			lastcolor=$(this).closest('td').css('background-color');
			$(this).closest('td').css('background-color', 'blue');
			lastsquare=$(this).closest('td');
		}

/*
	$("#move").empty();	$("#endgamemove").empty(); $("#surrendermove").empty();

		$("#moves option").each(function() {
			var piece=''; piece=$(this).html().trim();
			if(((p1name.toLowerCase()=='i')||(p1name.toLowerCase()=='j')||(p1name.toLowerCase()=='u')||(p1name.toLowerCase()=='y')) &&((piece.substr(0,1)==p1name)) ){
				$('form#Iing_endgame').show(); $('form#Iing_surrender').show();	kingmove=true;	}	
				
			if((piece.substr(0,1)==p1name)){ $("#move").empty(); $('form#make_move').show(); }			
			});
			
		if ($('select#endgamemove option').length == 0) { $('form#Iing_endgame').hide();  }
		if ($('select#surrendermove option').length == 0) { $('form#Iing_surrender').hide(); }	

		$("#move").empty();
		$("#moves option").each(function() {
			var val = $(this).val(); var txt = $(this).html(); var dataa = $(this).data('coordinate-notation');
			txt=txt.trim();
			if(txt.substr(0,1)==p1name){
				$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
				tempi=tempi+1;
			}
		i=i+1;
		});
		$("#move_count").html(tempi);		
		var dt = event.originalEvent.dataTransfer; dt.setData('Text', $(this).closest('td').attr('id'));
		p1name = $(this).attr('name');

		$("#move").empty();
		$("#moves option").each(function() {
			var val = $(this).val(); var txt = $(this).html(); 	var dataa = $(this).data('coordinate-notation');
			txt=txt.trim();
			if(txt.substr(0,1)==p1name){
				$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
				tempi=tempi+1;
			}
		i=i+1;
		});

		$("#move_count").html(tempi);
	*/	
		$('form#Iing_endgame').hide(); $('form#Iing_surrender').hide();	kingmove=false;	$('form#make_move').hide();
		$("#moves option").each(function() {
			var piece=''; piece=$(this).html().trim();
			if(((p1name.toLowerCase()=='i')||(p1name.toLowerCase()=='j')||(p1name.toLowerCase()=='u')||(p1name.toLowerCase()=='y')) &&((piece.substr(0,1)==p1name)) ){
				$('form#Iing_endgame').show(); $('form#Iing_surrender').show();	kingmove=true; }	
				
			if((piece.substr(0,1)==p1name)){ $("#move").empty();	$('form#make_move').show();	}
			});
			
		if ($('select#endgamemove option').length == 0) { $('form#Iing_endgame').hide(); }
		if ($('select#surrendermove option').length == 0) { $('form#Iing_surrender').hide(); }		
		
		var dt = event.originalEvent.dataTransfer; dt.setData('Text', $(this).closest('td').attr('id'));
		p1name = $(this).attr('name');
		p2name=$(this).closest('td').attr('id').substr(0,2);
		//alert (p2name);
		
		$("#move").empty();	$("#endgamemove").empty(); $("#surrendermove").empty();

		$("#moves option").each(function() {
			var val = $(this).val(); var txt = $(this).html(); var dataa = $(this).data('coordinate-notation');
			txt=txt.trim();
			if(txt.substr(1,1)=='*') { tname=txt.substr(2,2); dname=txt.substr(4,2)}
			if(txt.substr(1,1)!='*') { tname=txt.substr(1,2); dname=txt.substr(3,2)}
			
			//alert('txt ='+txt+' txt.substr(1,1) = '+txt.substr(1,1)+ ' txt.substr(2,2)= '+txt.substr(2,2)+ ' txt.substr(0,1)='+txt.substr(0,1)+ ' p1name= '+p1name+ ' p2name= '+ p2name+ ' tname='+tname);
			if (kingmove==true)
				//debugger
			if((txt.substr(0,1)==p1name)&&(p2name==tname)){
				//Within Same CASTLE
				if((kingmove==true)&& (((/[a-h9]{2,2}/.test(p2name))&&(/[d-e9]{2,2}/.test(dname)))|| ((/[a-h0]{2,2}/.test(p2name)&&(/[d-e0]{2,2}/.test(dname)))))){
					//No Draw in CASTLE
					if ((txt.indexOf("=Y") >= 0)||(txt.indexOf("=J") >= 0)){
						$("#surrendermove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						$('form#Iing_surrender').show();
						}
					else
					if ((txt.indexOf("=U") >= 0)||(txt.indexOf("=I") >= 0)||(txt.indexOf("=") >= -1)){
						$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						}
					else	
					if ((txt.indexOf("=V") >= 0)||(txt.indexOf("#")>=0)){
						$("#wininggamemove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						$('form#winninggame').show();
						}
					}
				else	
				if((kingmove==true)&& (((/[9]{2,2}/.test(p2name))&&(/[9]{2,2}/.test(dname)))|| ((/[0]{2,2}/.test(p2name))&&(/[0]{2,2}/.test(dname))))){
					//No Draw in CASTLE
						if ((txt.indexOf("=Y") >= 0)||(txt.indexOf("=J") >= 0)){
						$("#surrendermove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						$('form#Iing_surrender').show();
						}
					else
					if ((txt.indexOf("=U") >= 0)||(txt.indexOf("=I") >= 0)||(txt.indexOf("=") >= -1)){
						$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						}							
					}
				else	
				if((kingmove==true)&& ((/[a-h]{2,2}/.test(dname)))&&(((/[9]{2,2}/.test(p2name))&&(/[1-8]{2,2}/.test(dname)))|| ((/[0]{2,2}/.test(p2name))&&(/[1-8]{2,2}/.test(dname))))){
					//CASTLE to WAR
						if ((txt.indexOf("=Y") >= 0)){
						$("#endgamemove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
									$('form#Iing_endgame').show();
						}
					else
					if ((txt.indexOf("=U") >= 0)){
						$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						}
					else{
						$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						}
					}
				else				
				if((kingmove==true)&& ((((/[x]{2,2}/.test(dname)))&&(((/[09]{2,2}/.test(p2name))&&(/[089]{2,2}/.test(dname)))|| ((/[09]{2,2}/.test(p2name))&&(/[089]{2,2}/.test(dname))))) ||(((/[y]{2,2}/.test(dname)))&&(((/[09]{2,2}/.test(p2name))&&(/[089]{2,2}/.test(dname)))|| ((/[09]{2,2}/.test(p2name))&&(/[089]{2,2}/.test(dname))))))){
					//CASTLE to No Mans				
					//debugger					
					if ((txt.indexOf("=Y") >= 0)){
						$("#endgamemove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							$('form#Iing_endgame').show();
						}
					else
					if ((txt.indexOf("=U") >= 0)){
						$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						}
					else{
						$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						}						
					}
				else
				if((kingmove==true)&& ((((/[x]{2,2}/.test(dname)))&&(((/[9]{2,2}/.test(p2name))&&(/[1-8]{2,2}/.test(dname)))|| ((/[0]{2,2}/.test(p2name))&&(/[1-8]{2,2}/.test(dname)))))||(((/[y]{2,2}/.test(dname)))&&(((/[9]{2,2}/.test(p2name))&&(/[1-8]{2,2}/.test(dname)))|| ((/[0]{2,2}/.test(p2name))&&(/[1-8]{2,2}/.test(dname))))))){
					//CASTLE to TRUCE
						if ((txt.indexOf("=Y") >= 0)){
						$("#surrendermove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							$('form#Iing_surrender').show();
						}
					else
					if ((txt.indexOf("=U") >= 0)){
						$("#endgamemove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							$('form#Iing_endgame').show();
						}
					}
				else				
				if((kingmove==true)&& (/[1-8]{2,2}/.test(p2name))){
				//(p2name.indexOf('1')||(p2name.indexOf('2')>=0)||(p2name.indexOf('3')>=0)||(p2name.indexOf('4')>=0)||(p2name.indexOf('5')>=0)||(p2name.indexOf('6')>=0)||(p2name.indexOf('7')>=0)||(p2name.indexOf('8')>=0))){
					if ((txt.indexOf("=Y") >= 0)){
						$("#endgamemove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							$('form#Iing_endgame').show();
						}
					else{
						$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
						}
					}					
				else{
					$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
					tempi=tempi+1;
					}					
				}
			i=i+1;
		
		});
		$("#move_count").html(tempi);	
	
	});

	$('table td').on("dragenter dragover drop", function (event,ui ) {	
		event.preventDefault();
		var optioncount=0; var tempvalue=null;;
		if (event.type === 'drop') {
			
			oldsquare = event.originalEvent.dataTransfer.getData('Text', $(this).attr('id'));
		    newsquare = $(this).attr('id');
			optioncount=0;
			coordinate_notation = p1name+oldsquare + newsquare;
			console.log(coordinate_notation);			
			tempvalue=$("form[name='all_moves'] select[name='move'] option[data-coordinate-notation^='" + coordinate_notation + "']");
			
			//optioncount=optioncount+tempvalue.length;
			option_tag_in_select_tag = tempvalue;
			optioncount=optioncount+tempvalue.length;		
			coordinate_notation = p1name+'*'+oldsquare + newsquare;
			console.log(coordinate_notation);
			tempvalue=$("form[name='all_moves'] select[name='move'] option[data-coordinate-notation^='" + coordinate_notation + "']");
			
			if(option_tag_in_select_tag.length == 0){
				option_tag_in_select_tag = tempvalue;
				//'.' means the end of game
			}
		
			optioncount=optioncount+tempvalue.length;
			coordinate_notation = p1name+oldsquare + newsquare+'=';
			console.log(coordinate_notation);
			tempvalue=$("form[name='all_moves'] select[name='move'] option[data-coordinate-notation^='" + coordinate_notation + "']");

			if(option_tag_in_select_tag.length == 0){ //check the demotion piece
				option_tag_in_select_tag = tempvalue;
				//'.' means the end of game
			}
			
			optioncount=optioncount+tempvalue.length;
			coordinate_notation = p1name+oldsquare + newsquare+'+';
			console.log(coordinate_notation);
			tempvalue=$("form[name='all_moves'] select[name='move'] option[data-coordinate-notation^='" + coordinate_notation + "']");
			
			if(option_tag_in_select_tag.length == 0){
				option_tag_in_select_tag = tempvalue;
				//'.' means the end of game
			}

			optioncount=optioncount+tempvalue.length;
			coordinate_notation = p1name+'*'+oldsquare + newsquare+'+';
			console.log(coordinate_notation);
			tempvalue=$("form[name='all_moves'] select[name='move'] option[data-coordinate-notation^='" + coordinate_notation + "']");

			if(option_tag_in_select_tag.length == 0){
				option_tag_in_select_tag = tempvalue;
				//'.' means the end of game
			}

			optioncount=optioncount+tempvalue.length;
			//coordinate_notation = p1name+'*'+oldsquare + newsquare+'+';
			//console.log(coordinate_notation);
			//tempvalue=$("form[name='all_moves'] select[name='move'] option[data-coordinate-notation='" + coordinate_notation + "']");
			//debugger			
			if ( option_tag_in_select_tag.length != 0 ) {				

				option_tag_in_select_tag.attr('selected','selected');
				$(this).find('span').attr('name',p1name);

								
				if (typeof (Storage) != "undefined"){
					if (!localStorage.getItem("serverData")){
						// Ajax JSON to get server information
						getServerData();
						}
					else
						{
						retrieveAndSetData();
						}
					}
				else
					{
					alert("localStorage unavailable!");
					}
				//$('#make_move').submit();
				if(optioncount==1){
					//debugger
					$('#all_moves').submit();
					myAudio.play();
					}
				};
		}	
    });
	
        $('#submitmove').attr('disabled','disabled'); 
		$('#submitmove').attr('hidden','hidden');
        $('#submitendgamemove').attr('disabled','disabled');        
        $('#submitendgamemove').attr('hidden','hidden'); 
        $('#submitwinninggamemove').attr('disabled','disabled');        
        $('#submitwinninggamemove').attr('hidden','hidden'); 	
        $('#submitsurrendermove').attr('disabled','disabled');        
        $('#submitsurrendermove').attr('hidden','hidden'); 
		

		$('select#move').css("background-color", "");
		$('select#endgamemove').css("background-color", "");
		$('select#surrendermove').css("background-color", "");
		$('select#winninggamemove').css("background-color", "");		
		
$('select#move').change(function(){
  debugger
  var $empty=$('select#move').filter(function() { return this.value == ""; });
    if ( $('select#move').filter(function() { return this.value == ""; }).length == $('select#move').length ){
             $('#make_move #submitmove').attr('disabled','disabled');     
			$('select#move').css("background-color", "");
			 
    } else
    {
        $('#submitmove').removeAttr('disabled');
		$('#submitmove').removeAttr('hidden');
		
		$('select#move').css("background-color", "yellow");
		$('select#endgamemove').css("background-color", "");
		$('select#surrendermove').css("background-color", "");
		$('select#winninggamemove').css("background-color", "");


        $('#submitendgamemove').attr('disabled','disabled');        
        $('#submitendgamemove').attr('hidden','hidden');
        $('#submitsurrendermove').attr('disabled','disabled');        
        $('#submitsurrendermove').attr('hidden','hidden'); 
        $('#submitwinninggamemove').attr('disabled','disabled');        
        $('#submitwinninggamemove').attr('hidden','hidden'); 		
    }
});

$('select#winninggamemove').change(function(){
  var $empty=$('select#winninggamemove').filter(function() { return this.value == ""; });
    if ( $('select#winninggamemove').filter(function() { return this.value == ""; }).length == $('select#winninggamemove').length ){
             $('#submitendgamemove').attr('disabled','disabled');        
    } else
    {
             $('#submitwinninggamemove').removeAttr('disabled');        
             $('#submitwinninggamemove').removeAttr('hidden');
			 
        $('#submitmove').attr('disabled','disabled'); 
		$('#submitmove').attr('hidden','hidden');
        $('#submitsurrendermove').attr('disabled','disabled');        
        $('#submitsurrendermove').attr('hidden','hidden'); 
        $('#submitendgamemove').attr('disabled','disabled');        
        $('#submitendgamemove').attr('hidden','hidden'); 				 
		
		$('select#move').css("background-color", "");
		$('select#endgamemove').css("background-color", "");
		$('select#surrendermove').css("background-color", "");
		$('select#winninggamemove').css("background-color", "yellow");

		
    }
});

$('select#endgamemove').change(function(){
  var $empty=$('select#endgamemove').filter(function() { return this.value == ""; });
    if ( $('select#endgamemove').filter(function() { return this.value == ""; }).length == $('select#endgamemove').length ){
             $('#submitendgamemove').attr('disabled','disabled');        
			$('select#endgamemove').css("background-color", "");

    } else
    {
             $('#submitendgamemove').removeAttr('disabled');        
             $('#submitendgamemove').removeAttr('hidden');
			 
        $('#submitmove').attr('disabled','disabled'); 
		$('#submitmove').attr('hidden','hidden');
        $('#submitsurrendermove').attr('disabled','disabled');        
        $('#submitsurrendermove').attr('hidden','hidden'); 
        $('#submitwinninggamemove').attr('disabled','disabled');        
        $('#submitwinninggamemove').attr('hidden','hidden'); 

		$('select#move').css("background-color", "");
		$('select#endgamemove').css("background-color", "yellow");
		$('select#surrendermove').css("background-color", "");
		$('select#winninggamemove').css("background-color", "");

		
    }
});

$('select#surrendermove').change(function(){
  var $empty=$('select#surrendermove').filter(function() { return this.value == ""; });
    if ( $('select#surrendermove').filter(function() { return this.value == ""; }).length == $('select#surrendermove').length ){
             $('#submitsurrendermove').attr('disabled','disabled');        
	 		$('select#surrendermove').css("background-color", "");

    } else
    {
             $('#submitsurrendermove').removeAttr('disabled');        
             $('#submitsurrendermove').removeAttr('hidden');
			 
        $('#submitmove').attr('disabled','disabled'); 
		$('#submitmove').attr('hidden','hidden');
        $('#submitendgamemove').attr('disabled','disabled');        
        $('#submitendgamemove').attr('hidden','hidden'); 
        $('#submitwinninggamemove').attr('disabled','disabled');        
        $('#submitwinninggamemove').attr('hidden','hidden'); 		

		$('select#move').css("background-color", "");
		$('select#endgamemove').css("background-color", "");
		$('select#surrendermove').css("background-color", "yellow");
		$('select#winninggamemove').css("background-color", "");
		
    }
});


$('select#winninggamemove').change(function(){
  var $empty=$('select#winninggamemove').filter(function() { return this.value == ""; });
    if ( $('select#winninggamemove').filter(function() { return this.value == ""; }).length == $('select#winninggamemove').length ){
             $('#submitwinninggamemove').attr('disabled','disabled');        
    } else
    {
             $('#submitwinninggamemove').removeAttr('disabled');        
             $('#submitwinninggamemove').removeAttr('hidden');
			 
        $('#submitmove').attr('disabled','disabled'); 
		$('#submitmove').attr('hidden','hidden');
        $('#submitendgamemove').attr('disabled','disabled');        
        $('#submitendgamemove').attr('hidden','hidden'); 
        $('#submitwinninggamemove').attr('disabled','disabled');        
        $('#submitwinninggamemove').attr('hidden','hidden'); 				 
    }
});

		
	$('#perft').click(function(){
		window.location.href = 'perft.php?fen='  + $('#fen').val();
	});
});
});