
$(document).ready(function(){
		var color_to_move='',opp_color_to_move='';
		var p1name='',p2name='';
		var kingmove=false;
		var arthshastrimove=false;
		var naaradmove=false;
		var knightmove=false;
		var bishopmove=false;
		var rookmove=false;
		var generalmove=false;
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
		$("textarea#player1ta").val("");
		$("textarea#player2ta").val("");
		$("div#textAreasRules").hide();
					

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
			$("textarea#playerta").val($("textarea#playerta").val()+"* Your ("+color_to_move+ ") Military Officials CANNOT STRIKE the Opponent. Reason: King or ArthShashtri or both interested in Domestic Affairs.\n");
		if($("input#"+color_to_move+"officerscankill").val()=='1')
			$("textarea#playerta").val($("textarea#playerta").val()+"* All Military Officials can kill. Reason: King and ArthShashtri both are not idle involved in domestic affairs\n");
			
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


				naaradmove=false;				
				soldiermove=false;	
				knightmove=false;	
				bishopmove=false;
				rookmove=false;
				generalmove=false;	
				kingmove=false;				
				arthshastrimove=false;
				soldiermove=false;
				spymove=false;
				officermove=false;


			if((p1name.toLowerCase()=='n'))
				naaradmove=true;				
			else if((p1name.toLowerCase()=='p'))
				soldiermove=true;	
			else if((p1name.toLowerCase()=='h'))
				knightmove=true;	
			else if((p1name.toLowerCase()=='g'))
				bishopmove=true;
			else if((p1name.toLowerCase()=='m'))
				rookmove=true;
			else if((p1name.toLowerCase()=='s'))
				generalmove=true;	
			else if((p1name.toLowerCase()=='i')||(p1name.toLowerCase()=='u')||(p1name.toLowerCase()=='y'))
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
			
			if((p1name.toLowerCase()=='g')||(p1name.toLowerCase()=='h')||(p1name.toLowerCase()=='m')||(p1name.toLowerCase()=='s')){
				officermove=true;
				}				
				
	
		if ($('select#recallmove option').length == 0) {
			$('form#recall').hide();
			$("#recallmove").empty();	
		}
				

		if ($('select#Shantimove option').length == 0) {
			$('form#king_Shanti').hide();
			$("#Shantimove").empty();	
		}
		
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
		
		$("#move").empty();	$("#winninggamemove").empty(); $("#endgamemove").empty(); $("#surrendermove").empty();$("#Shantimove").empty();$("#recallmove").empty();

	$("textarea#player1ta").val("");
	$("textarea#player2ta").val("");
	$("div#textAreasRules").hide();
		
			
	if ((($("div.status_box").attr('id')=='1')&& (p1name.match(/^[A-ZÁ]*$/))) || (($("div.status_box").attr('id')=='2')&& (p1name.match(/^[a-zá]*$/)))) {
		$("div#textAreasRules").show();

		$("#moves option").each(function() {
			var val = $(this).val();
			var txt = $(this).html();
			var dataa = $(this).data('coordinate-notation');
			txt=txt.trim();
			if(txt.substr(1,1)=='*') { tname=txt.substr(2,2); dname=txt.substr(4,2)}
			if(txt.substr(1,1)!='*') { tname=txt.substr(1,2); dname=txt.substr(3,2)}

				if((txt.substr(0,1)==p1name)&&(p2name==tname)){

					$("textarea#player1ta").val("");
					$("textarea#player2ta").val("");
					//ArthShastri is in CASTLE or opponent CASTLE. If General is in Truce then it means Army will have to retreat. If King or Arsthshastri is in War then retreat will not happen.
					//if(kingmove==true)
					//debugger
					if((officermove==true)&& (/[a-h09]{2,2}/.test(dname))){
						if ((txt.indexOf("Ö") >= 0)){
							$("#winninggamemove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							$('form#winninggame').show();
							}
						else{
							$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							}						
						}
					//General move from WAR to Truce
					else if((generalmove==true)&& ((/[xy1-8]{2,2}/.test(dname)) &&(/[a-h1-8]{2,2}/.test(p2name)))){
							$("#recallmove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							document.getElementById('lblSandhi').innerHTML="Sandhi";
							$('form#recall').show();
						}
					//King move from WAR to Truce (non-Borders)
					else if((kingmove==true)&& ((/[xy123678]{2,2}/.test(dname)) &&(/[a-h1-8]{2,2}/.test(p2name)))){
						debugger
						if ((txt.indexOf("=Y") >= 0)){
							$("#surrendermove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							$('form#king_surrender').show();
							}
						else {
							$("#recallmove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));	
							document.getElementById('lblSandhi').innerHTML="Viraam Sandhi";
							$('form#recall').show();
							}
						}
					//ArthShashtri moving to Scepter
					else if((arthshastrimove==true)&& (/[a-h45]{2,2}/.test(dname))){
						if ((txt.indexOf("=Ä") >= 0)){
							$("#winninggamemove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							$('form#winninggame').show();
							}
						else if ((txt.indexOf("=Á") >= 0)){
							$("#Shantimove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							document.getElementById('lblShanti').innerHTML="Shanti";
							$('form#king_Shanti').show();
							}							
						else{
							$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							}						
						}
					//ArthShashtri moving to Truce Borders
					else if((arthshastrimove==true)&& (/[xy45]{2,2}/.test(dname))){
						if ((txt.indexOf("=Ä") >= 0)){
							$("#winninggamemove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							$('form#winninggame').show();
							}
						else if ((txt.indexOf("=A") >= 0)||(txt.indexOf("=") >= -1)){
							$("#Shantimove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							document.getElementById('lblShanti').innerHTML="Shanti";
							$('form#king_Shanti').show();								
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
						else if ((txt.indexOf("=U") >= 0)||(txt.indexOf("=I") >= 0)||(txt.indexOf("=") >= -1)){
							$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							}
						else if ((txt.indexOf("=V") >= 0)||(txt.indexOf("#") >= 0)){
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
						else if ((txt.indexOf("=U") >= 0)||(txt.indexOf("=") >= -1)){
							$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							}
						}
					//TRUCE to WAR
					else if((kingmove==true)&& ((/[xy0-8]{2,2}/.test(p2name)) &&(/[a-h1-8]{2,2}/.test(dname)))){
						if ((txt.indexOf("=Y") >= 0)){
							$("#endgamemove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							$('form#king_endgame').show();
							}
						else if ((txt.indexOf("=U") >= 0)||(txt.indexOf("=") >= -1)){
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
						else if ((txt.indexOf("=U") >= 0)||(txt.indexOf("=") >= -1)){
							$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							}
						else if ((txt.indexOf("=V") >= 0)||(txt.indexOf("#") >= 0)){
							$("#winninggamemove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							$('form#winninggame').show();
							}
						}
					//kingmove moving to Truce Borders
					else if((kingmove==true)&& (/[a-h1-8]{2,2}/.test(p2name))&&(/[xy45]{2,2}/.test(dname))){
						if ((txt.indexOf("=V") >= 0)){
							$("#winninggamemove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							$('form#winninggame').show();
							}
						else if ((txt.indexOf("=Y") >= 0)){
							$("#surrendermove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							$('form#king_surrender').show();
							}
						else if ((txt.indexOf("=U") >= 0)||(txt.indexOf("=") >= -1)){
							$("#Shantimove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							document.getElementById('lblShanti').innerHTML="Viraam Shanti Sandhi";
							debugger;
							$('form#king_Shanti').show();
							}
						}						
					//kingmove War to Non-Border Truce	
					else if((kingmove==true)&& ((/[xy1-8]{2,2}/.test(dname)) &&(/[a-h1-8]{2,2}/.test(p2name)))){
						if ((txt.indexOf("=Y") >= 0)){
							$("#surrendermove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							$('form#king_surrender').show();
							}
						else if ((txt.indexOf("=U") >= 0)||(txt.indexOf("=") >= -1)){
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
						else if ((txt.indexOf("=I") >= 0)){
							$("#Shantimove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							$('form#king_Shanti').show();							
							}
						else if ((txt.indexOf("=U") >= 0)||(txt.indexOf("=") >= -1)){
							$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							}
						else if ((txt.indexOf("=V") >= 0)||(txt.indexOf("#")>=0)){
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
						else if ((txt.indexOf("=U") >= 0)||(txt.indexOf("=I") >= 0)||(txt.indexOf("=V")>=0)||(txt.indexOf("#")>=0)||(txt.indexOf("=") >= -1)){
							$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							}
						}
					//CASTLE to WAR
					else if((kingmove==true)&& ((/[a-h1-8]{2,2}/.test(dname))&&(/[a-h09]{2,2}/.test(p2name)))){
						if ((txt.indexOf("=Y") >= 0)){
							$("#endgamemove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							$('form#king_endgame').show();
							}
						else if ((txt.indexOf("=U") >= 0)||(txt.indexOf("=") >= -1)){
							$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							}
						}
					//WAR to CASTLE
					else if((kingmove==true)&& ((/[a-h09]{2,2}/.test(dname)&&(/[a-h1-8]{2,2}/.test(p2name))))){
						if ((txt.indexOf("=Y") >= 0)){
							$("#surrendermove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
									$('form#king_surrender').show();
							}
						else if ((txt.indexOf("=V") >= 0)||(txt.indexOf("#") >= 0)){
							$("#winninggamemove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							$('form#winninggame').show();
							}
						else if ((txt.indexOf("=I") >= 0)){
							$("#Shantimove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							$('form#king_Shanti').show();							
							}							
						else if ((txt.indexOf("=U") >= 0)||(txt.indexOf("=") >= -1)){
							$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							}							
						}
					//WAR to WAR
					else if((kingmove==true)&& ((/[a-h1-8]{2,2}/.test(dname)&&(/[a-h1-8]{2,2}/.test(p2name))))){
						if ((txt.indexOf("=Y") >= 0)){
							$("#endgamemove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							document.getElementById('lblViraam').innerHTML="Viraam";
							$('form#king_endgame').show();
							}
						else if ((txt.indexOf("=V") >= 0)||(txt.indexOf("#") >= 0)){
							$("#winninggamemove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							$('form#winninggame').show();
							}							
						else if ((txt.indexOf("=U") >= 0)||(txt.indexOf("=") >= -1)){
							$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							}
						}
					//CASTLE to No Mans
					else if((kingmove==true)&& ((((/[x]{1}/.test(dname)))&&(((/[09]{2,2}/.test(p2name))&&(/[089]{2,2}/.test(dname)))|| ((/[09]{2,2}/.test(p2name))&&(/[089]{2,2}/.test(dname))))) ||(((/[y]{1}/.test(dname)))&&(((/[09]{2,2}/.test(p2name))&&(/[089]{2,2}/.test(dname)))|| ((/[09]{2,2}/.test(p2name))&&(/[089]{2,2}/.test(dname))))))){
						//debugger					
						if ((txt.indexOf("=Y") >= 0)){
							$("#endgamemove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							document.getElementById('lblViraam').innerHTML="Viraam";							
							$('form#king_endgame').show();
							}
						else if ((txt.indexOf("=U") >= 0)){
							$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							}
						else{
							$("#move").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							}
						}
					//CASTLE to TRUCE
					else if((kingmove==true)&& ((((/[x]{1}/.test(dname)))&&(((/[9]{1}/.test(p2name))&&(/[1-8]{1}/.test(dname)))|| ((/[0]{1}/.test(p2name))&&(/[1-8]{1}/.test(dname)))))||(((/[y]{1}/.test(dname)))&&(((/[9]{1}/.test(p2name))&&(/[1-8]{1}/.test(dname)))|| ((/[0]{1}/.test(p2name))&&(/[1-8]{1}/.test(dname))))))){

						if ((txt.indexOf("=Y") >= 0)){
							$("#surrendermove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							$('form#king_surrender').show();
							}
						else if ((txt.indexOf("=U") >= 0)){
							$("#endgamemove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							$('form#king_endgame').show();
							}
						}
					else if((kingmove==true)&& (/[1-8]{1}/.test(p2name))){						//(p2name.indexOf('1')||(p2name.indexOf('2')>=0)||(p2name.indexOf('3')>=0)||(p2name.indexOf('4')>=0)||(p2name.indexOf('5')>=0)||(p2name.indexOf('6')>=0)||(p2name.indexOf('7')>=0)||(p2name.indexOf('8')>=0))){
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

		$("textarea#player1ta").val("");$("textarea#player2ta").val("");

		if(color_to_move!=''){
			if(kingmove==true){
				$("div#player1 label").html("Rules for King (#I Means Indra or King)");	
				//if($("input#"+color_to_move+"officerscanmovefull").val()=='0')
				$("textarea#player1ta").val($("textarea#player1ta").val()+"*'I' is Royal Controller and Protector of Kingdom. Controls the Kingdom and  Army.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* Generally, 'I' can move 1 step at a time. 'I' can kill. #I01#");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'I' can move or jump 1-2 steps like 'S' in his own CASTLE with max 2 steps. Castle itself is Royal and 'I' is aware of every area. #I02# #I03#");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'I' cannot Jump over opponent.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'I' can move 'To and From' any Zones with the help of Royal or Semi-Royal members only. #I04# ");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* Only 'I' and 'A' both should declare war at their side by leaving the Scepter. Declaration of war helps the Army Officers to Strike the opponent; Otherwise Army cannot strike but only move. #I05");			
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'I' can promote any surrounding Military Officers on the move or even as a simple promotion without moves. #I06# ");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'I' when enters the opponent CASTLE becomes the Emperor or Vikramaditya (IndraJeet). War Ends and opponent loses.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* Army when enters the opponent CASTLE makes the 'I' Emperor or Vikramaditya (IndraJeet). War Ends and opponent loses. Here, 'A' also gets promoted.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'A' when enters the opponent CASTLE makes the 'I' Emperor or Vikramaditya (IndraJeet). War Ends and opponent loses. Here, 'A' also gets promoted.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* Only 'I' or 'S' can suggest 'Army-Recall' by getting into Truce Zone non Boundary Areas.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* Only 'I' can suggest 'Truce and Army-Recall' by getting into Truce Zone's special Boundary Area.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* Only 'I' can suggest 'Sandhi' even in the WAR-Zone.");						
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* Only 'I' can Accept his Defeat in CASTLE. No Sandhi is allowed in CASTLE.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* Only 'I' can Accept his Defeat in TRUCE. No Sandhi is allowed in TRUCE.");						
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* Only 'I' can Accept his Defeat in No Mans Land. No Sandhi is allowed in TRUCE.");						
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* Only 'I' can Accept his Defeat in No Mans Land. No Sandhi is allowed in TRUCE.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* In Order to make Army to move to Full strength in any Specific Zone, the Royal or Semi-Royal should be present in that Zone.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'I' gets permanantly hidden in Naag-Lok or No-Mans land. War still goes on.");
		
				$("div#player2 label").html("Exceptions in Rules for King");	
				//if($("input#"+color_to_move+"officerscanmovefull").val()=='0')
				$("textarea#player2ta").val($("textarea#player2ta").val()+"#I01# If Royal is surrounded with Royal or Semi-Royal in same zone then these Royal or Semi-Royal can move like Knight.");
				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n#I02# 'I' require help 'To move-in or move-out' of his own Compromised CASTLE to Truce.");
				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n#I03# 'I's own Compromised CASTLE becomes Secondary War-Zone.");
				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n#I04# 'I' doesn't need any help 'To move-in or move-out' of Opponent's Compromised CASTLE.");	
				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n#I05# Army can Strike only if 'I' and 'A' both are not idle. (Still has defects to be fixed)");	
				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n#I06# Parity of Ranks are maintained. Only 'G=2', 'H=2', 'M=2', 'S=1'  are allowed..");
			}
	
			if(spymove==true){
				$("div#player1 label").html("Rules for Chaaran (#C Means Chaaran or Spy)");	
				//if($("input#"+color_to_move+"officerscanmovefull").val()=='0')
				$("textarea#player1ta").val($("textarea#player1ta").val()+"* 'C' is Semi-Royal and Semi-Millitary Officer and lead the Spies under King.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'C' can move only 1 step at a time. 'C' CANNOT kill. #C01#");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'C' can move or jump 1-2 steps like 'S' in his own CASTLE with max 2 steps. Castle itself is Royal and 'C' is aware of every area. #C02# #C03#");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'C' cannot Jump over opponent.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'C' can move n number or Times 'To and From' any Zones with the help of Royal or Semi-Royal members only. #C04# ");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'C' can promote any surrounding Military members on the move or even as a simple promotion without moves. #C05# ");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'C' can promote himself as optional in Opponent CASTLE without any help. This is exceptional honor");
				
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* In Order to make Army to move to Full strength in any Specific Zone, the Royal or Semi-Royal should be present in that Zone.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'C' gets permanantly hidden in Naag-Lok or No-Mans land. War still goes on.");
				
				$("div#player2 label").html("Exceptions in Rules for 'C'");	
				//if($("input#"+color_to_move+"officerscanmovefull").val()=='0')
				$("textarea#player2ta").val($("textarea#player2ta").val()+"#C01# If Royal is surrounded with Royal or Semi-Royal in same zone then these Royal or Semi-Royal can move like Knight.");
				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n#C02# 'C' require help 'To move-in or move-out' of his own Compromised CASTLE to Truce or No-Mans.");
				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n#C03# 'C's own Compromised CASTLE becomes Secondary War-Zone.");
				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n#C04# 'C' doesn't need any help 'To move-in or move-out' of Opponent's Compromised CASTLE.");	
				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n#C05# Parity of Ranks are maintained. Only 'G=2', 'H=2', 'M=2', 'S=1'  are allowed.");
			}

			if(arthshastrimove==true){
				$("div#player1 label").html("Rules for ArthShastri (#A Means ArthShastri or Prime Minister)");	
				$("textarea#player1ta").val($("textarea#player1ta").val()+"*'A' is Royal Advisor of King. Manages the Kingdom and Finances.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'A' can move only 1 step at a time. 'A' CANNOT kill. #A01#");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'A' can move or jump 1-2 steps like 'S' in his own CASTLE with max 2 steps. Castle itself is Royal and 'A' is aware of every area. #A02# #A03#");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'A' cannot Jump over opponent.");
				
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'A' can move n number or Times 'To and From' any Zones with the help of Royal or Semi-Royal members only. #A04# ");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'A' can promote any surrounding Military members on the move or even as a simple promotion without moves. #A05# ");
				
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* In Order to make Army to move to Full strength in any Specific Zone, the Royal or Semi-Royal should be present in that Zone.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* Only 'A' or 'I' can only suggest 'Truce' (His own Army as Strikeless) by getting into Truce Zone's Boundary Areas. Rest of the Truce Zone has no impact on Army.");
	
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'A' gets permanantly hidden in Naag-Lok or No-Mans land. War still goes on.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'I' when enters the opponent CASTLE becomes the Emperor or Vikramaditya (IndraJeet). War Ends and opponent loses. Here, 'A' also gets promoted.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*Army or C when enters the opponent CASTLE also makes the 'I' Emperor or Vikramaditya (IndraJeet). War Ends and opponent loses. Here, 'A' also gets promoted.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'A' when enters the opponent CASTLE also makes the 'I' Emperor or Vikramaditya (IndraJeet). War Ends and opponent loses. Here, 'A' also gets promoted.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'A' if is idle then make the Soldiers and Army Strikeless. #A06#");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'A' if dies then make the Soldiers and Army and permanently Strikeless. #A06#");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*Army can Strike only if 'I' and 'A' both are not idle. (Still has defects to be fixed)");	
				
				$("div#player2 label").html("Exceptions in Rules for ArthShastri (ArthShashtri Code has to many bugs");	
				//if($("input#"+color_to_move+"officerscanmovefull").val()=='0')
				$("textarea#player2ta").val($("textarea#player2ta").val()+"#A01# If Royal is surrounded with Royal or Semi-Royal in same zone then these Royal or Semi-Royal can move like 'S' but only with 2 Moves maximum.");
				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n#A02# 'A' require help 'To move-in or move-out' of his own Compromised CASTLE to Truce or No-Mans.");
				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n#A03# 'A's own Compromised-CASTLE becomes Secondary War-Zone.");
				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n#A04# 'A' doesn't need any help 'To move-in or move-out' of Opponent's Compromised CASTLE.");	
				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n#A05# Parity of Ranks are maintained. Only 'G=2', 'H=2', 'M=2', 'S=1'  are allowed.");	
				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n#A06# Kautilya Modified this rule and made Army Units as Autonomous and Self-Sustaining.");
			}
		
			if(naaradmove==true){
				$("div#player1 label").html("Rules for RaajRishi or GodMan (#N Means Naarad)");	
				//if($("input#"+color_to_move+"officerscanmovefull").val()=='0')
				$("textarea#player1ta").val($("textarea#player1ta").val()+"* Not Coded Yet. So Rules are complex for Naarad. For now. Made this piece as immovable");
				
				$("div#player2 label").html("Exceptions in Rules for RaajRishi (RaajRishi Code is too complex. Will take more than month to code");	
				//if($("input#"+color_to_move+"officerscanmovefull").val()=='0')
				$("textarea#player2ta").val($("textarea#player2ta").val()+"* Not Coded Yet. So Rules are complex for Naarad. For now. Made this piece as immovable");
				}		
	
			if(soldiermove==true){
				$("div#player1 label").html("Rules for Padati or Pawns (#P Means Pawns)");	
				//if($("input#"+color_to_move+"officerscanmovefull").val()=='0')
				$("textarea#player1ta").val($("textarea#player1ta").val()+"* 'P' are funded by 'A'. They are under Army Officers.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'P' moves or kills 1 direction forward (straight or Diagonal). #P01#.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'P' can move or kill only when surrounding squares in same Zone have Army Officers.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'P' CANNOT kill opponents, if War is not Declared.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'P' CANNOT kill opponents, if 'A' is Killed.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'P' CANNOT change Zones. #P02#.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'P' are indirectly controlled by Opponent's Naarad. (Not Coded Yet)");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'P' are not controlled by King. (Not Coded Yet)");
				
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'P' are never promoted");
				
				$("div#player2 label").html("Exceptions in Rules for Pawns");	
				//if($("input#"+color_to_move+"officerscanmovefull").val()=='0')
				$("textarea#player2ta").val($("textarea#player2ta").val()+"*#P01# When 'I' or 'S' recalls the Army (Is in Truce&Recall Zone), 'P' cannot march forward but can march backward.");
				$("textarea#player2ta").val($("textarea#player2ta").val()+"*\n#P01# When 'I' signs Truce and Recall Both, then entire Army cannot Kill in any direction.");
				$("textarea#player2ta").val($("textarea#player2ta").val()+"*\n#P02# When the CASTLEs are compromised then everyone including Pawns can enter provided 'I'/'S' have not recalled the army.");
				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n*#P02# 'P' CANNOT Enter Truce or No Mans Land. Can enter compromised CASTLE because it becomes Royal-War Zone.");
				}
	
			if(bishopmove==true){
				$("div#player1 label").html("Rules for Gajaarohi or Hastin (#G Means Bishop)");	
				//if($("input#"+color_to_move+"officerscanmovefull").val()=='0')
				$("textarea#player1ta").val($("textarea#player1ta").val()+"* 'G' are last 1st Rank and Junior to Knight.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'G' are funded by ArthShastri (A). They are under Army 'S'.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'G' moves 1-2 steps in any direction BUT CANNOT jump.");
				
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'G' can move and kill either straight or diagonal.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'G' CANNOT kill opponents, if War is not Declared.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'G' CANNOT kill opponents, if 'A' is Killed.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'G' CAN only change Zones with the help of General/Royal/Semi-Royals.#G01#.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'G' are directly controlled by Opponent's Naarad. (Not Coded Yet)");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'G' are indirectly controlled by King and can be promoted by any Royal or Semi Royal.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'G' when are promoted becomes 'H'(Knights).");
				
				$("div#player2 label").html("Exceptions in Rules for Gajaarohi");	
				//if($("input#"+color_to_move+"officerscanmovefull").val()=='0')
				$("textarea#player2ta").val($("textarea#player2ta").val()+"*#G01# When King or 'S' (Senapati) recalls the Army (Is in Truce&Recall Zone), 'G' cannot march forward but can march backward.");	
				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n*#G01# When King signs Truce and Recall Both, then entire Army cannot Kill in any direction.");
				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n*#G02# When the CASTLEs are compromised then everyone including 'G' can enter or exit provided I/S have  not recalled the army.");
				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n*#G02# Can Enter Truce, BUT can comeout of it with help of I/A/C/G. Cannot come out of No-Mans Land.");
				
				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n*#G02# Kautilya Modified Army Units as Autonomous and Self-Sustaining.");
				}
	
			if(knightmove==true){
				$("div#player1 label").html("Rules for Ashwaarohi or Shoorveer (#H Means Knight)");	
				//if($("input#"+color_to_move+"officerscanmovefull").val()=='0')
				$("textarea#player1ta").val($("textarea#player1ta").val()+"* 'H' are last 2nd Rank and Senior to 'G'.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'H' are like Modern Guirellas funded by 'A'. They are under Army 'S'.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'H' moves 1-2 steps in any direction including jumping.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'H' CANNOT kill anyone if moved only 1 step in any direction. 'H' need resources to kill.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'H' cannot jump over opponent.");
				
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'H' can kill only on 2 steps move. 1 step straight and then 2nd step straight or diagonal. If the 1st step has no team member except Naarad, then 'H' cannot Kill.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'H' CANNOT kill opponents, if War is not Declared.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'H' CANNOT kill opponents, if 'A' is Killed.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'H' CAN only change Zones with the help of General/Royal/Semi-Royals.#H01#.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'H' are directly controlled by Opponent's Naarad. (Not Coded Yet)");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'H' are indirectly controlled by 'I' and can be promoted by any Royal or Semi Royal.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n* 'H' when are promoted becomes 'M' (Rook).");
				
				
				$("div#player2 label").html("Exceptions in Rules for Knight");	
				//if($("input#"+color_to_move+"officerscanmovefull").val()=='0')
				
				$("textarea#player2ta").val($("textarea#player2ta").val()+"*#H01# When 'I'  or 'S' recalls the Army (Is in Truce&Recall Zone), 'H' cannot march forward but can march backward.");
								$("textarea#player2ta").val($("textarea#player2ta").val()+"\n#S04# Must be pushed by I/A/C. Kautilya Modified Army Units as Autonomous and Self-Sustaining.");

				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n*#H01# When 'I' signs Truce and Recall or Both, then entire Army cannot Kill in any direction.");
				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n*#H01# When 'A' signs Truce, then entire Army cannot Kill in any direction.");
				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n*#M01# Can Enter Truce, BUT can comeout of it with help of I/A/C/G. Cannot come out of No-Mans Land.");
				
				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n*#H01# When the CASTLEs are compromised then everyone including 'H' can enter or exit provided King/General have not recalled the army.");
				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n*#Hxx# Kautilya Modified Army Units as Autonomous and Self-Sustaining.");	
				}
	
			if(rookmove==true){
				$("div#player1 label").html("Rules for Mahaarathi (#M Means Rook)");	
				//if($("input#"+color_to_move+"officerscanmovefull").val()=='0')
				$("textarea#player1ta").val($("textarea#player1ta").val()+"*'M' are 3rd Rank and Senior to Knight.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'M' are funded by 'A'. They are under Army 'S'.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'M' moves 1-2 steps in any direction BUT CANNOT jump.");
				
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'M' can move and kill either straight or diagonal.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'M' CANNOT kill opponents, if War is not Declared.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'M' CANNOT kill opponents, if 'A' is Killed.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'M' CAN only change Zones with the help of General/Royal/Semi-Royals.#M01#.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'M' are directly controlled by Opponent's Naarad. (Not Coded Yet)");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'M' are indirectly controlled by 'I' and can be promoted by any Royal or Semi Royal.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'M' when are promoted becomes 'S' (Senapati).");
			
				$("div#player2 label").html("Exceptions in Rules for Mahaarathi");	
				//if($("input#"+color_to_move+"officerscanmovefull").val()=='0')
				$("textarea#player2ta").val($("textarea#player2ta").val()+"*#M01# When 'I' or 'S' recalls the Army (Is in Truce&Recall Zone), 'M' cannot march forward but can march backward.");
				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n*#M01# When King signs Truce and Recall or Both, then entire Army cannot Kill in any direction.");
				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n*#M01# When the CASTLEs are compromised then everyone including 'M' can enter or exit provided I/S have not recalled the army.");
				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n*#M01# Can Enter Truce, BUT can comeout of it with help of I/A/C/G. Cannot come out of No-Mans Land.");
				
				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n*#Mxx# Kautilya Modified Army Units as Autonomous and Self-Sustaining.");
				}
		
			if(generalmove==true){
				$("div#player1 label").html("Rules for Senapati (#S Means General/WaZeer)");	
				//if($("input#"+color_to_move+"officerscanmovefull").val()=='0')
				$("textarea#player1ta").val($("textarea#player1ta").val()+"*'S' are last Rank and Senior to Rook 'M'.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'S' are funded by 'A'. They are the top commander ot Army Officers.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'S' moves 1-4 steps in any direction and can also jump.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'S' cannot jump over opponent.");
				
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'S' can move and kill either straight or diagonal or like 'H'. #S01#");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'S' CANNOT kill opponents, if War is not Declared.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'S' CANNOT kill opponents, if 'A' is Killed.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'S' CAN change Zones with the help of Royal/Semi-Royals. #S03#.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'S' can only suggest 'ReCall' by getting into any areas of Truce Zone. #S04#");
	
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'S' are directly controlled by Opponent's Naarad. (Not Coded Yet)");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'S' are indirectly controlled by 'I'.");
				$("textarea#player1ta").val($("textarea#player1ta").val()+"\n*'S' are never promoted.");
				
				
				$("div#player2 label").html("Exceptions in Rules for Senapati");	
				//if($("input#"+color_to_move+"officerscanmovefull").val()=='0')
				$("textarea#player2ta").val($("textarea#player2ta").val()+"*#S01#. 'S' is not dependent on resources. Hence, even if it is jumping 2 moves like 'H', it does not require resource in 1st step.");
				
				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n*#S02# When 'I' or 'S' recalls the Army (Is in Truce&Recall Zone), 'S' cannot march forward but can march backward.");
				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n*#S03# When 'I' signs Truce and Recall Both, then entire Army cannot Kill in any direction.");
				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n*#S03# When the CASTLEs are compromised then everyone including 'S' can enter or exit provided I has not recalled the army.");
				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n*#S03# When only 'S' has Recalled the Army, then the maximum Area-Under-Control is counted as per the S's holding. It is maximum to the own boundary or the max row distance 'S' has covered.");
	
				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n*#S03# When the 'I' and 'S' both have Recalled the Army, then the maximum Area-Under-Control is counted as per the I's holding. It is maximum to the own boundary or the max row distance 'I' has covered.");
				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n*#S03# Can Enter Truce, BUT can comeout of it with help of I/A/C. Cannot come out of No-Mans Land.");
				$("textarea#player2ta").val($("textarea#player2ta").val()+"\n*#Sxx# Must be pushed by I/A/C. Kautilya Modified Army Units as Autonomous and Self-Sustaining.");

				}
			}
		}
		else {	$('form#winninggame').hide();$('form#King_endgame').hide();$('form#King_surrender').hide(); $('form#make_move').hide();}
	 
		//debugger
		if ($('select#winninggamemove option').length > 0) {
			$('form#winninggame').show();
		}
		else $('form#winninggame').hide();


		if ($('select#endgamemove option').length > 0) {
			$('form#King_endgame').show();
		}	else $('form#King_endgame').hide();

		
		if ($('select#surrendermove option').length > 0) {
			$('form#King_surrender').show();	
		}	else $('form#King_surrender').hide();
		
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
				$('form#King_endgame').show(); $('form#King_surrender').show();	kingmove=true;	}	
				
			if((piece.substr(0,1)==p1name)){ $("#move").empty(); $('form#make_move').show(); }			
			});
			
		if ($('select#endgamemove option').length == 0) { $('form#King_endgame').hide();  }
		if ($('select#surrendermove option').length == 0) { $('form#King_surrender').hide(); }	

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
		$('form#King_endgame').hide(); $('form#King_surrender').hide();	kingmove=false;	$('form#make_move').hide();
		$("#moves option").each(function() {
			var piece=''; piece=$(this).html().trim();
			if(((p1name.toLowerCase()=='i')||(p1name.toLowerCase()=='j')||(p1name.toLowerCase()=='u')||(p1name.toLowerCase()=='y')) &&((piece.substr(0,1)==p1name)) ){
				$('form#King_endgame').show(); $('form#King_surrender').show();	kingmove=true; }	
				
			if((piece.substr(0,1)==p1name)){ $("#move").empty();	$('form#make_move').show();	}
			});
			
		if ($('select#endgamemove option').length == 0) { $('form#King_endgame').hide(); }
		if ($('select#surrendermove option').length == 0) { $('form#King_surrender').hide(); }		
		
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
						$('form#King_surrender').show();
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
						$('form#King_surrender').show();
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
									$('form#King_endgame').show();
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
							$('form#King_endgame').show();
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
							$('form#King_surrender').show();
						}
					else
					if ((txt.indexOf("=U") >= 0)){
						$("#endgamemove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							$('form#King_endgame').show();
						}
					}
				else				
				if((kingmove==true)&& (/[1-8]{2,2}/.test(p2name))){
				//(p2name.indexOf('1')||(p2name.indexOf('2')>=0)||(p2name.indexOf('3')>=0)||(p2name.indexOf('4')>=0)||(p2name.indexOf('5')>=0)||(p2name.indexOf('6')>=0)||(p2name.indexOf('7')>=0)||(p2name.indexOf('8')>=0))){
					if ((txt.indexOf("=Y") >= 0)){
						$("#endgamemove").append($('<option></option>').val(val).html(txt).attr('data-coordinate-notation',dataa));
							$('form#King_endgame').show();
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