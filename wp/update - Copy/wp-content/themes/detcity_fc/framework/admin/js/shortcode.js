var shortcode = {
	init:function(){
		jQuery('.primary_select select').val('');
		jQuery('.primary_select select').change(function(){
		jQuery(".secondary_select").hide();
			if(this.value !=''){
				if(jQuery("#secondary_"+this.value).show().children('.tertiary_select').size() == 0){
					jQuery("#secondary_"+this.value).show().find('.on_off :checkbox').iphoneStyle();
				}
			}
		});
		
		jQuery('#sendtoeditor').click(function(){
			shortcode.sendToEditor();
		});
		
		jQuery('.secondaryselect select').val('');
		jQuery('.secondaryselect select').change(function(){
			jQuery(this).closest('.secondary_select').children('.tertiary_select').hide();
			if(this.value !=''){
				jQuery("#atp-"+this.value).show().find('.on_off :checkbox').iphoneStyle();
			}
		});
	},
	generate:function(){
		var type = jQuery('.primary_select select').val();
		switch(type){
/*** COLUMN LAYOUTS ***/
		case 'Columns':
			var types =jQuery('[name="Columns_type"]').val();

			if(types != ''){
			var content =jQuery('[name="Columns_content"]').val();
				return '\n['+types+']\n'+content+'\n[/'+types+']\n';
			}else{
				return '';
			}
			break;	
/*** LAYOUTS ***/
		case 'Layouts':
			var secondary_type =jQuery('#secondary_Layouts select').val();
			switch(secondary_type) {
			case 'one_half_layout':	
				var one_half_layout =jQuery('[name="Layouts_one_half_layout_layout_1"]').val();
				var one_half_layout_last =jQuery('[name="Layouts_one_half_layout_layout_2"]').val();
				return '\n[one_half]\n'+one_half_layout+'\n[/one_half]\n\n[one_half_last]\n'+one_half_layout_last+'\n[/one_half_last]\n';	
				break;
			case 'one_third_layout':
				var one_third_layout1 = jQuery('[name="Layouts_one_third_layout_one_third_1"]').val();
				var one_third_layout2 = jQuery('[name="Layouts_one_third_layout_one_third_2"]').val();
				var one_third_layout3 = jQuery('[name="Layouts_one_third_layout_one_third_3"]').val();
				return '\n[one_third]\n'+one_third_layout1+'\n[/one_third]\n[one_third]\n'+one_third_layout2+'\n[/one_third]\n[one_third_last]\n'+one_third_layout3+'\n[/one_third_last]\n';	
				break;
			case 'one_fourth_layout':
				var one_fourth_layout1 = jQuery('[name="Layouts_one_fourth_layout_one_fourth_1"]').val();
				var one_fourth_layout2 = jQuery('[name="Layouts_one_fourth_layout_one_fourth_2"]').val();
				var one_fourth_layout3 = jQuery('[name="Layouts_one_fourth_layout_one_fourth_3"]').val();
				var one_fourth_layout4 = jQuery('[name="Layouts_one_fourth_layout_one_fourth_4"]').val();
				return '\n[one_fourth]\n'+one_fourth_layout1+'\n[/one_fourth]\n[one_fourth]\n'+one_fourth_layout2+'\n[/one_fourth]\n[one_fourth]\n'+one_fourth_layout3+'\n[/one_fourth]\n[one_fourth_last]\n'+one_fourth_layout4+'\n[/one_fourth_last]\n';	
				break;
			case 'one5thlayout':
				var one5thlayout1 = jQuery('[name="Layouts_one_fifth_layout_onefifth_1"]').val();
				var one5thlayout2 = jQuery('[name="Layouts_one_fifth_layout_onefifth_2"]').val();
				var one5thlayout3 = jQuery('[name="Layouts_one_fifth_layout_onefifth_3"]').val();
				var one5thlayout4 = jQuery('[name="Layouts_one_fifth_layout_onefifth_4"]').val();
				var one5thlayout5 = jQuery('[name="Layouts_one_fifth_layout_onefifth_5"]').val();
				return '\n[one_fifth]\n'+one5thlayout1+'\n[/one_fifth]\n[one_fifth]\n'+one5thlayout2+'\n[/one_fifth]\n[one_fifth]\n'+one5thlayout3+'\n[/one_fifth]\n[one_fifth]\n'+one5thlayout4+'\n[/one_fifth]\n[one_fifth_last]\n'+one5thlayout5+'\n[/one_fifth_last]\n';
				break;
			case 'one6thlayout':
				var one6thlayout1 = jQuery('[name="Layouts_one_sixth_layout_onesixth_1"]').val();
				var one6thlayout2 = jQuery('[name="Layouts_one_sixth_layout_onesixth_2"]').val();
				var one6thlayout3 = jQuery('[name="Layouts_one_sixth_layout_onesixth_3"]').val();
				var one6thlayout4 = jQuery('[name="Layouts_one_sixth_layout_onesixth_4"]').val();
				var one6thlayout5 = jQuery('[name="Layouts_one_sixth_layout_onesixth_5"]').val();
				var one6thlayout6 = jQuery('[name="Layouts_one_sixth_layout_onesixth_6"]').val();
				return '\n[one_sixth]\n'+one6thlayout1+'\n[/one_sixth]\n[one_sixth]\n'+one6thlayout2+'\n[/one_sixth]\n[one_sixth]\n'+3+'\n[/one_sixth]\n[one_sixth]\n'+one6thlayout4+'\n[/one_sixth]\n[one_sixth]\n'+one6thlayout5+'\n[/one_sixth]\n[one_sixth_last]\n'+one6thlayout6+'\n[/one_sixth_last]\n';
				break;
			case 'one_3rd_2rd':
				var one3rd2rd_1 = jQuery('[name="Layouts_one_3rd_2rd_one3rd2rd_1"]').val();
				var one3rd2rd_2 = jQuery('[name="Layouts_one_3rd_2rd_one3rd2rd_2"]').val();
				return '\n[one_third]\n'+one3rd2rd_1+'\n[/one_third]\n[two_third_last]\n'+one3rd2rd_2+'\n[/two_third_last]\n';	
				break;
			case 'two_3rd_1rd':
				var two3rd1rd_1 = jQuery('[name="Layouts_two_3rd_1rd_two3rd1rd_1"]').val();
				var two3rd1rd_2 = jQuery('[name="Layouts_two_3rd_1rd_one3rd2rd_2"]').val();
				return '\n[two_third]\n'+two3rd1rd_1+'\n[/two_third]\n[one_third_last]\n'+two3rd1rd_2+'\n[/one_third_last]\n';	
				break;
			case 'One_4th_Three_4th':
				var One4thThree4th_1 = jQuery('[name="Layouts_One_4th_Three_4th_One4thThree4th_1"]').val();
				var One4thThree4th_2 = jQuery('[name="Layouts_One_4th_Three_4th_One4thThree4th_2"]').val();
				return '\n[one_fourth]\n'+One4thThree4th_1+'\n[/one_fourth]\n[three_fourth_last]\n'+One4thThree4th_2+'\n[/three_fourth_last]\n';
				break;
			case 'Three_4th_One_4th':
				var Three4thOne4th_1 = jQuery('[name="Layouts_Three_4th_One_4th_Three4thOne4th_1"]').val();
				var Three4thOne4th_2 = jQuery('[name="Layouts_Three_4th_One_4th_Three4thOne4th_2"]').val();
				return '\n[three_fourth]\n'+Three4thOne4th_1+'\n[/three_fourth]\n[one_fourth_last]\n'+Three4thOne4th_2+'\n[/one_fourth_last]\n';	
				break;
			case 'One_4th_One_4th_One_half':
				var One_4th_One_4th_One_half_1 = jQuery('[name="Layouts_One_4th_One_4th_One_half_One4thOne4thOnehalf_1"]').val();
				var One_4th_One_4th_One_half_2 = jQuery('[name="Layouts_One_4th_One_4th_One_half_One4thOne4thOnehalf_2"]').val();
				var One_4th_One_4th_One_half_3 = jQuery('[name="Layouts_One_4th_One_4th_One_half_One4thOne4thOnehalf_3"]').val();
				return '\n[one_fourth]\n'+One4thOne4thOnehalf_1+'\n[/one_fourth]\n[one_fourth]\n'+One4thOne4thOnehalf_2+'\n[/one_fourth]\n[one_half_last]\n'+One4thOne4thOnehalf_3+'\n[/one_half_last]\n';
				break;
			case 'One_half_One_4th_One_4th':
				var OnehalfOne4thOne4th_1 = jQuery('[name="Layouts_One_half_One_4th_One_4th_OnehalfOne4thOne4th_1"]').val();
				var OnehalfOne4thOne4th_2 = jQuery('[name="Layouts_One_half_One_4th_One_4th_OnehalfOne4thOne4th_2"]').val();
				var OnehalfOne4thOne4th_3 = jQuery('[name="Layouts_One_half_One_4th_One_4th_OnehalfOne4thOne4th_3"]').val();
				return '\n[one_half]\n'+OnehalfOne4thOne4th_1+'\n[/one_half]\n[one_fourth]\n'+OnehalfOne4thOne4th_2+'\n[/one_fourth]\n[one_fourth_last]\n'+OnehalfOne4thOne4th_3+'\n[/one_fourth_last]\n';
				break;
			case 'One_4th_One_half_One_4th':
				var One4thOnehalfOne4th_1 = jQuery('[name="Layouts_One_4th_One_half_One_4th_One4thOnehalfOne4th_1"]').val();
				var One4thOnehalfOne4th_2 = jQuery('[name="Layouts_One_4th_One_half_One_4th_One4thOnehalfOne4th_2"]').val();
				var One4thOnehalfOne4th_3 = jQuery('[name="Layouts_One_4th_One_half_One_4th_One4thOnehalfOne4th_3"]').val();
				return '\n[one_fourth]\n'+One4thOnehalfOne4th_1+'\n[/one_fourth]\n[one_half]\n'+One4thOnehalfOne4th_2+'\n[/one_half]\n[one_fourth_last]\n'+One4thOnehalfOne4th_3+'\n[/one_fourth_last]\n';
				break;
			case 'One_5th_Four_5th':
				var One5thFour5th_1 = jQuery('[name="Layouts_One_5th_Four_5th_One5thFour5th_1"]').val();
				var One5thFour5th_2 = jQuery('[name="Layouts_One_5th_Four_5th_One5thFour5th_2"]').val();
				return '\n[one_fifth]\n'+One5thFour5th_1+'\n[/one_fifth]\n[four_fifth_last]\n'+One5thFour5th_2+'\n[/four_fifth_last]\n';
				break;
			case 'Four_5th_One_5th':
				var Four5thOne5th_1 = jQuery('[name="Layouts_Four_5th_One_5th_Four5thOne5th_1"]').val();
				var Four5thOne5th_2 = jQuery('[name="Layouts_Four_5th_One_5th_Four5thOne5th_2"]').val();
				return '\n[four_fifth]\n'+Four5thOne5th_1+'\n[/four_fifth]\n[one_fifth_last]\n'+Four5thOne5th_2+'\n[/one_fifth_last]\n';
				break;
			case 'Two_5th_Three_5th':
				var Two5thThree5th_1 = jQuery('[name="Layouts_Two_5th_Three_5th_Two5thThree5th_1"]').val();
				var Two5thThree5th_2 = jQuery('[name="Layouts_Two_5th_Three_5th_Two5thThree5th_2"]').val();
				return '\n[two_fifth]\n'+Two5thThree5th_1+'\n[/two_fifth]\n[three_fifth_last]\n'+Two5thThree5th_2+'\n[/three_fifth_last]\n';
				break;
			case 'Three_5th_Two_5th':
				var Three5thTwo5th_1 = jQuery('[name="Layouts_Three_5th_Two_5th_Three5thTwo5th_1"]').val();
				var Three5thTwo5th_2 = jQuery('[name="Layouts_Three_5th_Two_5th_Three5thTwo5th_2"]').val();
				return '\n[three_fifth]\n'+Three5thTwo5th_1+'\n[/three_fifth]\n[two_fifth_last]\n'+Three5thTwo5th_2+'\n[/two_fifth_last]\n';	
				break;
			}
			break;
/*** TYPOGRAPHY ***/
		case 'Typography':
			var shortcodesub_type =jQuery('#secondary_Typography select').val();
			switch(shortcodesub_type) {
			case 'dropcap1':
				var text = jQuery('[name="Typography_dropcap1_dropcap_text"]').val();
				var color = jQuery('[name="Typography_dropcap1_color"]').val();
				if(color !== '')	{color = ' color="'+color+'"';}
				return '['+shortcodesub_type+color+']'+text+'[/'+shortcodesub_type+']';
				break;
			case 'dropcap2':
				var text = jQuery('[name="Typography_dropcap2_dropcap_text"]').val();
				var bgcolor = jQuery('[name="Typography_dropcap2_bgcolor"]').val();
				if(bgcolor !== '')	{bgcolor = ' bgcolor="'+bgcolor+'"';}
				return '['+shortcodesub_type+bgcolor+']'+text+'[/'+shortcodesub_type+']';
				break;
			case 'dropcap3':
				var text = jQuery('[name="Typography_dropcap3_dropcap_text"]').val();
				var color = jQuery('[name="Typography_dropcap3_color"]').val();
				if(color !== '')	{color = ' color="'+color+'"';}
				return '['+shortcodesub_type+color+']'+text+'[/'+shortcodesub_type+']';
				break;
			case 'blockquote':
				var align = jQuery('[name="Typography_blockquote_align"]').val();
				var cite = jQuery('[name="Typography_blockquote_cite"]').val();
				var content = jQuery('[name="Typography_blockquote_content"]').val();				
				if(content !== '')	{ content = ''+content+'';}
				if(align !== '')	{ align = ' align="'+align+'"';}
				if(cite !== '')		{ cite = ' cite="'+cite+'"';}
				return '[blockquote'+align+cite+']'+content+'[/blockquote]\n';
				break;
			case 'styledlist':
				var style = jQuery('[name="Typography_styledlist_style"]').val();
				var color = jQuery('[name="Typography_styledlist_color"]').val();
				var content = jQuery('[name="Typography_styledlist_content"]').val();
				if(content !== '')	{ content = ''+content+'';}
				if(style !== '')	{ style= ' style="'+style+'"';}
				if(color !== '')	{ color = ' color="'+color+'"';}
				return '\n[list'+style+color+']\n'+ content +'\n[/list]\n';
				break;
			case 'icon':
				var text = jQuery('[name="Typography_icon_text"]').val();
				var style = jQuery('[name="Typography_icon_style"]').val();
				var color = jQuery('[name="Typography_icon_color"]').val();
				if(text !== '')	{ text = ''+text+'';}
				if(style !== '')	{ style= ' style="'+style+'"';}
				if(color !== '')	{ color = ' color="'+color+'"';	}
				return '\n[icon'+style+color+']'+ text +'[/icon]\n';
				break;
			case 'iconlinks':
				var style = jQuery('[name="Typography_iconlinks_style"]').val();
				var color = jQuery('[name="Typography_iconlinks_color"]').val();
				var href = jQuery('[name="Typography_iconlinks_href"]').val();
				var target = jQuery('[name="Typography_iconlinks_target"]').val();
				var text = jQuery('[name="Typography_iconlinks_text"]').val();
				if(text !== '')	{ text = ''+text+'';}
				if(style !== '')	{ style= ' style="'+style+'"'; }
				if(color !== '')	{ color = ' color="'+color+'"'; }
				if(href !== '')		{ href = ' href="'+href+'"'; }
				if(target !== '')	{ target = ' target="'+target+'"';}
				return '\n[icon'+style+color+href+target+']'+ text +'[/icon]\n';
				break;
			case 'highlight':
				var textcolor = jQuery('[name="Typography_highlight_textcolor"]').val();
				var bgcolor = jQuery('[name="Typography_highlight_bgcolor"]').val();
				var text = jQuery('[name="Typography_highlight_text"]').val();
				if(text !== '')	{ text = ''+text+'';}
				if(bgcolor !== '')	{ bgcolor= ' bgcolor="'+bgcolor+'"';}
				if(textcolor !== ''){ textcolor = ' textcolor="'+textcolor+'"';}
				return '\n[highlight'+bgcolor+textcolor+']'+ text +'[/highlight]\n';
				break;
			case 'fancyheading':
				var textcolor = jQuery('[name="Typography_fancyheading_textcolor"]').val();
				var bgcolor = jQuery('[name="Typography_fancyheading_bgcolor"]').val();
				var text = jQuery('[name="Typography_fancyheading_text"]').val();
				if(text !== '')	{ text = ''+text+'';}
				if(bgcolor !== '')	{ bgcolor= ' bgcolor="'+bgcolor+'"';}
				if(textcolor !== ''){ textcolor = ' textcolor="'+textcolor+'"';}
				return '\n[fancyheading'+bgcolor+textcolor+']'+ text +'[/fancyheading]\n';
				break;
			}
			break;
		/*** BUTTON ***/		
		case 'Button':
			var link = jQuery('[name="Button_link"]').val();
			var linktarget =  jQuery('[name="Button_linktarget"]').val();
			var color =  jQuery('[name="Button_color"]').val();
			var align =  jQuery('[name="Button_align"]').val();
			var bgcolor =  jQuery('[name="Button_bgcolor"]').val();
			var hoverbgcolor =  jQuery('[name="Button_hoverbgcolor"]').val();
			var hovertextcolor =  jQuery('[name="Button_hovertextcolor"]').val();
			var textcolor =  jQuery('[name="Button_textcolor"]').val();
			var size =  jQuery('[name="Button_size"]').val();
			var width =  jQuery('[name="Button_width"]').val();
			var style =  jQuery('[name="Button_style"]');
				if(style.is('.atp-button')){
				if(style.is(':checked')){
				style= ' style="true"';	
				}else{
				style= ' style="false"';		
				}
			}
			var text = jQuery('[name="Button_text"]').val();
			if(text !== '')	{ text = ''+text+'';}
			if(link !== '')			{ link= ' link="'+link+'"'; }
			if(linktarget !== '')	{ linktarget= ' linktarget="'+linktarget+'"'; }
			if(color !== '')		{ color= ' color="'+color+'"';}
			if(align !== '')		{ align= ' align="'+align+'"';}
			if(bgcolor !== '')		{ bgcolor= ' bgcolor="'+bgcolor+'"';}
			if(hoverbgcolor !== '')	{ hoverbgcolor= ' hoverbgcolor="'+hoverbgcolor+'"';	}
			if(hovertextcolor !== ''){ hovertextcolor= ' hovertextcolor="'+hovertextcolor+'"';}
			if(textcolor !== '')	{ textcolor= ' textcolor="'+textcolor+'"';}
			if(size !== '')			{ size= ' size="'+size+'"';}
			if(width !== '')		{ width= ' width="'+width+'"';}	
			return '\n[button'+link+linktarget+color+align+bgcolor+hoverbgcolor+hovertextcolor+textcolor+size+width+style+']'+ text +'[/button]\n';
			break;
/*** DIVIDERS ***/			
		case 'Dividers':
			return '\n['+jQuery('[name="Dividers_divide"]').val()+']\n';
			break;
/*** TABLE ***/			
		case 'Table':
			var width =  jQuery('[name="Table_width"]').val();
			var align =  jQuery('[name="Table_align"]').val();
			var text = jQuery('[name="Table_text"]').val();
			if(text !== '')	{ text = ''+text+'';}
			if(width !== '')	{ width= ' width="'+width+'"';}
			if(align !== '')	{ align= ' align="'+align+'"';}
			return '\n[fancytable'+align+width+']'+ text +'[/fancytable]\n';
			break;
/*** TOGGLE ***/			
		case 'Toggle':
			var heading =  jQuery('[name="Toggle_heading"]').val();
			var text = jQuery('[name="Toggle_text"]').val();
			if(text !== '')	{ text = ''+text+'';}
			if(heading !== '')	{ heading= ' heading="'+heading+'"';}
			return '\n[toggle'+heading+']'+ text+'[/toggle]\n';
			break;
/*** FANCY TOGGLE ***/			
		case 'FancyToggle':
			var heading = jQuery('[name="FancyToggle_heading"]').val();
			var text = jQuery('[name="FancyToggle_text"]').val();
			if(text !== '')	{ text = ''+text+'';}
			if(heading !== '')	{ heading= ' heading="'+heading+'"';}
			return '\n[fancytoggle'+heading+']'+ text+'[/fancytoggle]\n';
			break;
/*** BOXES ***/
		case 'Boxes':
			var shortcodesub_type =jQuery('#secondary_Boxes select').val();;
			switch(shortcodesub_type) {
			case 'fancybox':
				var title = jQuery('[name="Boxes_fancybox_title"]').val();
				var heading = jQuery('[name="Boxes_fancybox_heading"]').val();
				var bgcolor = jQuery('[name="Boxes_fancybox_bgcolor"]').val();
				var titlecolor = jQuery('[name="Boxes_fancybox_titlecolor"]').val();
				var ribbon = jQuery('[name="Boxes_fancybox_ribbon"]').val();
				var text = jQuery('[name="Boxes_fancybox_text"]').val();
				if(text !== '')	{ text = ''+text+'';}
				if(title !== '')		{ title= ' title="'+title+'"';}
				if(heading !== '')		{ heading= ' heading="'+heading+'"';}
				if(bgcolor !== '')		{ bgcolor= ' bgcolor="'+bgcolor+'"'; }
				if(titlecolor !== '')	{ titlecolor= ' titlecolor="'+titlecolor+'"';}
				if(ribbon !== '')		{ ribbon= ' ribbon="'+ribbon+'"';}
				return '\n[fancy_box'+title+heading+bgcolor+titlecolor+ribbon+']'+ text +'[/fancy_box]\n';
				break;
			case 'minimalbox':
				var title = jQuery('[name="Boxes_minimalbox_title"]').val();
				var heading = jQuery('[name="Boxes_minimalbox_heading"]').val();
				var headingcolor = jQuery('[name="Boxes_minimalbox_headingcolor"]').val();
				var titlecolor = jQuery('[name="Boxes_minimalbox_titlecolor"]').val();
				var ribbon = jQuery('[name="Boxes_minimalbox_ribbon"]').val();
				var text = jQuery('[name="Boxes_minimalbox_text"]').val();
				if(text !== '')	{ text = ''+text+'';}
				if(title !== '')		{ title= ' title="'+title+'"';}
				if(heading !== '')		{ heading= ' heading="'+heading+'"';}
				if(titlecolor !== '')	{ titlecolor= ' titlecolor="'+titlecolor+'"';}
				if(ribbon !== '')		{ ribbon= ' ribbon="'+ribbon+'"';}
				return '\n[minimal_box'+title+heading+headingcolor+titlecolor+ribbon+']'+ text +'[/minimal_box]\n';
				break;
			case 'framedbox':
				var bgcolor = jQuery('[name="Boxes_framedbox_bgcolor"]').val();
				var bordercolor = jQuery('[name="Boxes_framedbox_bordercolor"]').val();
				var padding = jQuery('[name="Boxes_framedbox_padding"]').val();
				var ribbon = jQuery('[name="Boxes_framedbox_ribbon"]').val();
				var width = jQuery('[name="Boxes_framedbox_width"]').val();
				var height = jQuery('[name="Boxes_framedbox_height"]').val();
				var text = jQuery('[name="Boxes_framedbox_text"]').val();
				if(text !== '')	{ text = ''+text+'';}
				if(bgcolor !== '')		{ bgcolor = ' bgcolor="'+bgcolor+'"'; }
				if(bordercolor !== '')	{ bordercolor = ' bordercolor="'+bordercolor+'"'; }
				if(padding !== '')		{ padding = ' padding="'+padding+'"'; }
				if(ribbon !== '')		{ ribbon = ' ribbon="'+ribbon+'"'; }
				if(width!='')		{ width =' width="'+width+'"'; }
				if(height!='')		{ height =' height="'+height+'"';}
				return '\n[framed_box'+bgcolor+bordercolor+padding+ribbon+width+height+']'+ text +'[/framed_box]\n';
				break;
			case 'teaserbox':
				var bgcolor = jQuery('[name="Boxes_teaserbox_bgcolor"]').val();
				var ribbon = jQuery('[name="Boxes_teaserbox_ribbon"]').val();
				var width = jQuery('[name="Boxes_teaserbox_width"]').val();
				var height = jQuery('[name="Boxes_teaserbox_height"]').val();
				var text = jQuery('[name="Boxes_teaserbox_text"]').val();
				if(text !== '')	{ text = ''+text+'';}
				if(bgcolor !== '')		{ bgcolor = ' bgcolor="'+bgcolor+'"'; }
				if(ribbon !== '')		{ ribbon = ' ribbon="'+ribbon+'"'; }
				if(width!='')		{ width =' width="'+width+'"'; }
				if(height!='')		{ height =' height="'+height+'"';}
				return '\n[teaser_box'+bgcolor+ribbon+width+height+']'+ text +'[/teaser_box]\n';
				break;
			case 'messagebox':
				var msgtype =  jQuery('[name="Boxes_messagebox_msgtype"]').val();
				var text =  jQuery('[name="Boxes_messagebox_text"]').val();
				if(text !== '')	{ text = ''+text+'';}
				if(msgtype == '')		{ msgtype='info'; }
				return '\n['+msgtype+']\n'+ text +'\n[/'+msgtype+']\n';
				break;
			case 'notebox':
				var align = jQuery('[name="Boxes_notebox_align"]').val();
				var width = jQuery('[name="Boxes_notebox_width"]').val();
				var title = jQuery('[name="Boxes_notebox_title"]').val();
				var text = jQuery('[name="Boxes_notebox_text"]').val();
				if(text !== '')	{ text = ''+text+'';}
				if(align !== '')	{align= ' align="'+align+'"';}
				if(width !== '')	{width= ' width="'+width+'"';}
				if(title !== '')	{title= ' title="'+title+'"';}
				return '\n[note'+align+width+title+']'+ text +'[/note]\n';
				break;
			}
			break;
/*** TABS ***/
		case 'Tabs':
			var shortcodesub_tabs=jQuery('#secondary_Tabs select').val();
			for(var i=1;i<=shortcodesub_tabs;i++){	
			var stabstype =jQuery('[name="Tabs_'+shortcodesub_tabs+'_ctabs'+'"]').val();
		
	
			} 
			var outputs = '[minitabs tabtype="'+stabstype+'" ]';
			for(var i=1;i<=shortcodesub_tabs;i++){	
			var stabs1 =jQuery('[name="Tabs_'+shortcodesub_tabs+'_title_'+i+'"]').val();
			var bgcolor =jQuery('[name="Tabs_'+shortcodesub_tabs+'_titlebgcolor_'+i+'"]').val();
			var color =jQuery('[name="Tabs_'+shortcodesub_tabs+'_titlecolor_'+i+'"]').val();
			var stabs2 =jQuery('[name="Tabs_'+shortcodesub_tabs+'_text_'+i+'"]').val();
			var stabstype =jQuery('[name="Tabs_'+shortcodesub_tabs+'_ctabs'+'"]').val();
			outputs +='[tab  title="'+stabs1+'" tabcolor="'+bgcolor+'" textcolor="'+color+'"]\n'+stabs2+'\n[/tab]\n';
			}
			outputs +='[/minitabs]';
			return outputs;
			break;
/*** IMAGE ***/
		case 'image':
			var title = jQuery('[name="image_title"]').val();
			var lightbox = jQuery('[name="image_lightbox"]');
			var width = jQuery('[name="image_width"]').val();
			var imageclass = jQuery('[name="image_class"]').val();
			var height = jQuery('[name="image_height"]').val();
			var align = jQuery('[name="image_align"]').val();
			var alink = jQuery('[name="image_alink"]').val();
			var target = jQuery('[name="image_target"]').val();
			var imagesrc = jQuery('[name="image_imagesrc"]').val();
			if(imagesrc !== '')	{ imagesrc = ''+imagesrc+'';}
			if(width!='')	{ width	=' width="'+width+'"';}else{ width=' width="200"';}
			if(height!='')	{ height =' height="'+height+'"';}else{ height=' height="200"';}
			if(title!='')	{ title =' title="'+title+'"'; }
			if(alink!='')	{ alink	=' link="'+alink+'"';}
			if(target!='')	{ target	=' target="'+target+'"';}
			if(imageclass!='')	{ imageclass =' class="'+imageclass+'"';	}
		if(align!='')	{ align =' align="'+align+'"';	}
			if(lightbox.is('.atp-button')){
				if(lightbox.is(':checked')){
				lightbox= ' lightbox="true"';	
				}else{
				lightbox= ' lightbox="false"';		
				}
			}		
			return '\n[image'+width+height+title+imageclass+lightbox+align+alink+target+']'+ imagesrc +'[/image]\n';		
			break;

		/*** minigallery ***/
		case 'minigallery':
			var width = jQuery('[name="minigallery_width"]').val();
			var height = jQuery('[name="minigallery_height"]').val();
			var imageclass = jQuery('[name="minigallery_class"]').val();
			var minigallery_textareaurl = jQuery('[name="minigallery_textarea_url"]').val();
			if(minigallery_textareaurl !="") {content = ''+minigallery_textareaurl+'';}
			if(width!='')	{ width	=' width="'+width+'"';}else{ width=' width="200"';}
			if(height!='')	{ height =' height="'+height+'"';}else{ height=' height="200"';}
			if(imageclass!='')	{ imageclass =' class="'+imageclass+'"';	}		
			return '\n[minigallery'+imageclass+width+height+']'+ content+'[/minigallery]\n';;	
			break;

		/*** PHOTOFRAME ***/
		case 'photoframe':
			var imagesrc = jQuery('[name="photoframe_imagesrc"]').val();
			var alt = jQuery('[name="photoframe_alt"]').val();
			var width = jQuery('[name="photoframe_width"]').val();
			var height = jQuery('[name="photoframe_height"]').val();
			if(imagesrc!='')	{imagesrc =' src="'+imagesrc+'"';}
			if(width!='')		{width =' width="'+width+'"';}
			if(height!='')		{height =' height="'+height+'"';}
			if(alt!='')			{alt =' alt="'+alt+'"';	}
			if(alink!='')		{link =' link="'+alink+'"';}
			return '\n[photoframe'+imagesrc+width+height+alt+']\n';
			break;
/*** CHART ***/
		case 'chart':
			var data =  jQuery('[name="chart_data"]').val();
			var colors = jQuery('[name="chart_colors"]').val();
			var bgcolor = jQuery('[name="chart_bgcolor"]').val();
			var size =  jQuery('[name="chart_size"]').val();
			var title = jQuery('[name="chart_title"]').val();
			var labels = jQuery('[name="chart_labels"]').val();
			var advanced = jQuery('[name="chart_advanced"]').val();
			var type = jQuery('[name="chart_type"]').val();
			if(data!='')	{ data =' data="'+data+'"'; }
			if(color!='')	{ colors =' colors="'+colors+'"';}
			if(bgcolor!='')	{ bgcolor =' bgcolor="'+bgcolor+'"';}
			if(size!='')	{ size =' size="'+size+'"';}
			if(title!='')	{ title =' title="'+title+'"';}
			if(labels!='')	{ labels =' labels="'+labels+'"';	}
			if(advanced!=''){ advanced =' advanced="'+advanced+'"';}
			if(type!='')	{ type =' type="'+type+'"';}
			return '\n[chart'+data+colors+bgcolor+size+title+labels+advanced+type+']\n';		
			break;
/*** WIDGETS ***/
		case 'widgets':
			var shortcodesub_widgets=jQuery('#secondary_widgets select').val();
			switch(shortcodesub_widgets){
			case 'Contactform':
				var emailid =  jQuery('[name="widgets_Contactform_emailid"]').val();
				var successmessage =  jQuery('[name="widgets_Contactform_successmessage"]').val();
				if(emailid!=''){ emailid =' emailid="'+emailid+'"'; }
				if(successmessage!=''){ successmessage =' successmessage="'+successmessage+'"'; }
				return '\n[contactform'+emailid+successmessage+']\n';	
				break;
			case 'twitter':
				var username =  jQuery('[name="widgets_twitter_username"]').val();
				var limit =  jQuery('[name="widgets_twitter_limit"]').val();
				if(username !='')	{ username=' username="'+username+'"';	}
				if(limit!='')		{ limit =' limit="'+limit+'"'; }
				return '\n[twitter'+username+limit+']\n';
				break;
			case 'flickr':
				var id = jQuery('[name="widgets_flickr_id"]').val();
				var limit = jQuery('[name="widgets_flickr_limit"]').val();
				var type = jQuery('[name="widgets_flickr_type"]').val();
				var display = jQuery('[name="widgets_flickr_display"]').val();
				if(id!='')		{ id =' id="'+id+'"'; }
				if(limit!='')	{ limit =' limit="'+limit+'"';	}
				if(type!='')	{ type =' type="'+type+'"';	}
				if(display!='')	{ display =' display="'+display+'"';	}
					return '\n[flickr'+id+limit+display+type+']\n';
				break;
			case 'popularposts':
				var thumb = jQuery('[name="widgets_popularposts_thumb"]');
				var limit = jQuery('[name="widgets_popularposts_limit"]').val();
				if(thumb.is('.atp-button')){
				if(thumb.is(':checked')){
				thumb= ' thumb="true"';	
				}else{
				thumb= ' thumb="false"';		
				}
				}	
				if(limit!='')		{ limit =' limit="'+limit+'"';	}
				return '\n[popularpost '+thumb+limit+']\n';
				break;
			case 'recentposts':
				var thumb = jQuery('[name="widgets_recentposts_thumb"]');
				var limit = jQuery('[name="widgets_recentposts_limit"]').val();
				var cat_id = jQuery('[name="widgets_recentposts_cat_id[]"]').val();
				if(thumb.is('.atp-button')){
				if(thumb.is(':checked')){
				thumb= ' thumb="true"';	
				}else{
				thumb= ' thumb="false"';		
				}
				}	
				if(limit!='')		{ limit =' limit="'+limit+'"';}
				if(cat_id!='')		{ cat_id =' cat_id="'+cat_id+'"';}
				return '\n[recentpost '+thumb+limit+cat_id+']\n';
				break;
			case 'relatedposts':
				var thumb = jQuery('[name="widgets_relatedposts_thumb"]');
				var limit = jQuery('[name="widgets_relatedposts_limit"]').val();
				if(thumb.is('.atp-button')){
				if(thumb.is(':checked')){
				thumb= ' thumb="true"';	
				}else{
				thumb= ' thumb="false"';		
				}
				}	
				if(limit!='')		{ limit =' limit="'+limit+'"';}
				return '\n[related_posts '+thumb+limit+']\n';
				break;
			case 'contactinfo':
				var name = jQuery('[name="widgets_contactinfo_name"]').val();
				var address = jQuery('[name="widgets_contactinfo_address"]').val();
				var state = jQuery('[name="widgets_contactinfo_state"]').val();
				var city = jQuery('[name="widgets_contactinfo_city"]').val();
				var zip = jQuery('[name="widgets_contactinfo_zip"]').val();
				var email = jQuery('[name="widgets_contactinfo_email"]').val();
				var phone = jQuery('[name="widgets_contactinfo_phone"]').val();
				var mobile = jQuery('[name="widgets_contactinfo_mobile"]').val();
				var link = jQuery('[name="widgets_contactinfo_link"]').val();
				if(name!='')	{ name =' name="'+name+'"';}
				if(address!='')	{ address =' address="'+address+'"';}
				if(city!='')	{ city =' city="'+city+'"';}
				if(zip!='')		{ zip =' zip="'+zip+'"';}
				if(state!='')	{ state =' state="'+state+'"';}
				if(email!='')	{ email =' email="'+email+'"';}
				if(phone!='')	{ phone =' phone="'+phone+'"';}
				if(mobile!='')	{ mobile =' mobile="'+mobile+'"';}
				if(link!='')	{ link =' link="'+link+'"';}
				return '\n[contactinfo '+name+address+state+city+zip+email+phone+mobile+link+']\n';
				break;	
			}
			break;
/*** GOOGLE MAP ***/		
		case 'gmap':
			var width = jQuery('[name="gmap_width"]').val();
			var height = jQuery('[name="gmap_height"]').val();
			var address = jQuery('[name="gmap_address"]').val();
			var latitude = jQuery('[name="gmap_latitude"]').val();
			var longitude = jQuery('[name="gmap_longitude"]').val();
			var zoom = jQuery('[name="gmap_zoom"]').val();
			var marker = jQuery('[name="gmap_marker"]');
			var popup = jQuery('[name="gmap_popupmarker"]');
			var html = jQuery('[name="gmap_html"]').val();
			var controls = jQuery('[name="gmap_controls"]').val();
			var scrollwheel = jQuery('[name="gmap_scrollwheel"]').val();
			var maptype = jQuery('[name="gmap_types"]').val();
			if(width!='')		{ width =' width="'+width+'"'; }
			if(height!='')		{ height =' height="'+height+'"'; }
			if(address!='')		{ address =' address="'+address+'"';	}
			if(latitude!='')	{ latitude =' latitude="'+latitude+'"';}
			if(longitude!='')	{ longitude =' longitude="'+longitude+'"';}
			if(zoom!='')		{ zoom =' zoom="'+zoom+'"';}
			if(marker.is('.atp-button')){
				if(marker.is(':checked')){
				marker= ' marker="true"';	
				}else{
				marker= ' marker="false"';		
				}
			}	
			if(popup.is('.atp-button')){
				if(popup.is(':checked')){
				popup= ' popup="true"';	
				}else{
				popup= ' popup="false"';		
				}
			}	
			if(html!='')		{ html =' html="'+html+'"';}
			if(controls!='')	{ controls =' controls="'+controls+'"';	}
			if(scrollwheel!='')	{ scrollwheel =' scrollwheel="'+scrollwheel+'"';}
			if(maptype!='')		{ maptype =' maptype="'+maptype+'"';}
			return '[gmap'+width+height+marker+popup+html+controls+scrollwheel+maptype+']';		
			break;
/*** VIDEO ***/
		case 'video':
			var shortcodesub_video=jQuery('#secondary_video select').val();
			switch(shortcodesub_video){
			case 'flash':
				var width = jQuery('[name="video_flash_width"]').val();
				var height = jQuery('[name="video_flash_height"]').val();
				var src = jQuery('[name="video_flash_src"]').val();
				var id = jQuery('[name="video_flash_id"]').val();
				var play = jQuery('[name="video_flash_play"]');
				if(width!='')	{ width =' width="'+width+'"';}
				if(height!='')	{ height =' height="'+height+'"';}
				if(src!='')		{ src =' src="'+src+'"'; }
				if(id!='')		{ id =' id="'+id+'"'; }
				if(play.is('.atp-button')){
				if(play.is(':checked')){
				play= ' play="true"';	
				}else{
				play= ' play="false"';		
				}
				}	
				return '\n[flash'+width+height+src+id+play+']\n';	
				break;
			case 'vimeo':
				var width = jQuery('[name="video_vimeo_width"]').val();
				var height = jQuery('[name="video_vimeo_height"]').val();
				var clip_id = jQuery('[name="video_vimeo_clipid"]').val();
				var byline = jQuery('[name="video_vimeo_byline"]');
				var title = jQuery('[name="video_vimeo_title"]');
				var autoplay = jQuery('[name="video_vimeo_autoplay"]');
				var html5 = jQuery('[name="video_vimeo_html5"]');
				var loop = jQuery('[name="video_vimeo_loop"]');
				var portrait = jQuery('[name="video_vimeo_portrait"]');
				if(width!='')		{ width =' width="'+width+'"';}
				if(height!='')		{ height =' height="'+height+'"';	}
				if(src!='')			{ src =' src="'+src+'"';}
				if(clip_id!='')		{ clip_id	 =' clip_id="'+clip_id+'"';	}
				if(byline.is('.atp-button')){
				if(byline.is(':checked')){
				byline= ' byline="1"';	
				}else{
				byline= ' byline="0"';		
				}
				}	
			if(title.is('.atp-button')){
				if(title.is(':checked')){
				title= ' title="1"';	
				}else{
				title= ' title="0"';		
				}
			}	
			if(autoplay.is('.atp-button')){
				if(autoplay.is(':checked')){
				autoplay= ' autoplay="1"';	
				}else{
				autoplay= ' autoplay="0"';		
				}
			}	
			if(loop.is('.atp-button')){
				if(loop.is(':checked')){
				loop= ' loop="1"';	
				}else{
				loop= ' loop="0"';		
				}
			}	
			if(html5.is('.atp-button')){
				if(html5.is(':checked')){
				html5= ' html5="1"';	
				}else{
				html5= ' html5="0"';		
				}
			}	
			if(portrait.is('.atp-button')){
				if(portrait.is(':checked')){
				portrait= ' portrait="1"';	
				}else{
				portrait= ' portrait="0"';		
				}
			}	
				return '\n[vimeo'+width+height+title+clip_id+byline+autoplay+html5+portrait+']\n';	
				break;
			case 'youtube':
			var width = jQuery('[name="video_youtube_width"]').val();
				var height = jQuery('[name="video_youtube_height"]').val();
				var clipid = jQuery('[name="video_youtube_clipid"]').val();
				var autoplay = jQuery('[name="video_youtube_autoplay"]');
				var controls = jQuery('[name="video_youtube_controls"]');
				var loop = jQuery('[name="video_youtube_loop"]');
				var disablekb = jQuery('[name="video_youtube_disablekb"]');
				var hd = jQuery('[name="video_youtube_hd"]');
				var showinfo = jQuery('[name="video_youtube_showinfo"]');
				var showsearch = jQuery('[name="video_youtube_showsearch"]');
				if(width!='')			{ width =' width="'+width+'"'; }
				if(height!='')			{ height =' height="'+height+'"';	}
				if(clipid!='')			{ clip_id =' clipid="'+clipid+'"';}
				if(autoplay.is('.atp-button')){
				if(autoplay.is(':checked')){
				autoplay= ' autoplay="1"';	
				}else{
				autoplay= ' autoplay="0"';		
				}
			}
		if(controls.is('.atp-button')){
				if(controls.is(':checked')){
				controls= ' controls="1"';	
				}else{
				controls= ' controls="0"';		
				}
			}
			
			if(loop.is('.atp-button')){
				if(loop.is(':checked')){
				loop= ' loop="1"';	
				}else{
				loop= ' loop="0"';		
				}
			}
			if(disablekb.is('.atp-button')){
				if(disablekb.is(':checked')){
				disablekb= ' disablekb="1"';	
				}else{
				disablekb= ' disablekb="0"';		
				}
			}
			if(hd.is('.atp-button')){
				if(hd.is(':checked')){
				hd= ' hd="1"';	
				}else{
				hd= ' hd="0"';		
				}
			}
			if(showinfo.is('.atp-button')){
				if(showinfo.is(':checked')){
				showinfo= ' showinfo="1"';	
				}else{
				showinfo= ' showinfo="0"';		
				}
			}
			if(showsearch.is('.atp-button')){
				if(showsearch.is(':checked')){
				showsearch= ' showsearch="1"';	
				}else{
				showsearch= ' showsearch="0"';		
				}
			}	
				return '\n[youtube'+width+height+clip_id+autoplay+controls+loop+disablekb+hd+showinfo+showsearch+']\n';	
				break;
			case 'wordpresstv':
				var width = jQuery('[name="video_wordpresstv_width"]').val();
				var height = jQuery('[name="video_wordpresstv_height"]').val();
				var clipid = jQuery('[name="video_wordpresstv_id"]').val();
				
				if(width!='')			{ width =' width="'+width+'"'; }
				if(height!='')			{ height =' height="'+height+'"';	}
				if(clipid!='')			{ id =' id="'+clipid+'"';}
				
				return '\n[wordpresstv'+width+height+id+']\n';	
				break;
		case 'bliptv':
				var width = jQuery('[name="video_bliptv_width"]').val();
				var height = jQuery('[name="video_bliptv_height"]').val();
				var clipid = jQuery('[name="video_bliptv_id"]').val();
				
				if(width!='')			{ width =' width="'+width+'"'; }
				if(height!='')			{ height =' height="'+height+'"';	}
				if(clipid!='')			{ id =' id="'+clipid+'"';}
					
				return '\n[bliptv'+width+height+id+']\n';	
				break;
		case 'googlevideo':
				var width = jQuery('[name="video_googlevideo_width"]').val();
				var height = jQuery('[name="video_googlevideo_height"]').val();
				var clipid = jQuery('[name="video_googlevideo_id"]').val();
				
				if(width!='')			{ width =' width="'+width+'"'; }
				if(height!='')			{ height =' height="'+height+'"';	}
				if(clipid!='')			{ id =' id="'+clipid+'"';}
					
				return '\n[googlevideo'+width+height+id+']\n';	
				break;
			}	
			break;
/*** LIGHTBOX ***/
 		case 'lightbox':
		 	var content = jQuery('[name="lightbox_content"]').val();
            var height = jQuery('[name="lightbox_height"]').val();
            var width = jQuery('[name="lightbox_width"]').val();
            var href = jQuery('[name="lightbox_href"]').val();
            var title = jQuery('[name="lightbox_title"]').val();
            var rel = jQuery('[name="lightbox_rel"]').val();
            var iframe = jQuery('[name="lightbox_iframe"]');
            var autoresize = jQuery('[name="lightbox_autoresize"]');
            var inline = jQuery('[name="lightbox_inline"]').val();
            var inlineid = jQuery('[name="lightbox_inlineid"]').val();
            var html = jQuery('[name="lightbox_html"]').val();
			if(content!='')		{ content = ''+content+''; }
			if(width!='')		{ width =' width="'+width+'"'; }
			if(title!='')		{ title	 =' title="'+title+'"';}
			if(height!='')		{ height =' height="'+height+'"'; }
			if(href!='')		{ href =' href="'+href+'"'; }
			if(rel !='')		{ rel =' rel="'+rel+'"'; }			
			if(autoresize.is('.atp-button')){
				if(autoresize.is(':checked')){
				autoresize= ' autoresize="true"';	
				}else{
				autoresize= ' autoresize="false"';		
				}
			}	
			if(iframe.is('.atp-button')){
				if(iframe.is(':checked')){
				iframe= ' iframe="true"';	
				}else{
				iframe= ' iframe="false"';		
				}
			}		
			return '\n[lightbox'+width+height+rel+title+href+autoresize+iframe+']'+ content+'[/lightbox]\n';			
			break;
/*** GALLERIA ***/			
		case 'galleria':
			var shortcodesub_galleria=jQuery('#secondary_galleria select').val();
			
			switch(shortcodesub_galleria){
			case'attachment':
			var galleria_width = jQuery('[name="galleria_attachment_width"]').val();
			var galleria_height = jQuery('[name="galleria_attachment_height"]').val();
			var galleria_transition = jQuery('[name="galleria_attachment_transition"]').val();
			var galleria_autoplay = jQuery('[name="galleria_attachment_autoplay"]').val();
			if(galleria_width !="") { width = ' width="'+galleria_width+'"';}else{width = ' width="500"';}
			if(galleria_height !="") { height = ' height="'+galleria_height+'"';}else{height = ' height="500"';}
			if(galleria_transition !="") { transition = ' transition="'+galleria_transition+'"';}else{transition = ' transition="500"';}
			if(galleria_autoplay !="") { autoplay = ' autoplay="'+galleria_autoplay+'"';}else{autoplay = ' autoplay="500"';}
			return '\n[galleria'+width+height+transition+autoplay+']\n';
			break;
			case'galleriaurl':
			var galleria_width = jQuery('[name="galleria_galleriaurl_width"]').val();
			var galleria_height = jQuery('[name="galleria_galleriaurl_height"]').val();
			var galleria_transition = jQuery('[name="galleria_galleriaurl_transition"]').val();
			var galleria_textareaurl = jQuery('[name="galleria_galleriaurl_textarea_url"]').val();
			var galleria_autoplay = jQuery('[name="galleria_galleriaurl_autoplay"]').val();
			if(galleria_width !="") { width = ' width="'+galleria_width+'"';}else{width = ' width="500"';}
			if(galleria_textareaurl !="") {content = ''+galleria_textareaurl+'';}
			if(galleria_height !="") { height = ' height="'+galleria_height+'"';}else{height = ' height="500"';}
			if(galleria_transition !="") { transition = ' transition="'+galleria_transition+'"';}else{transition = ' transition="500"';}
			if(galleria_autoplay !="") { autoplay = ' autoplay="'+galleria_autoplay+'"';}else{autoplay = ' autoplay="500"';}
			return '\n[galleriaurl'+width+height+transition+autoplay+']'+ content+'[/galleriaurl]\n';;
			break;
			}				
			break;

/** NIVO ***/
		case 'nivoslider':
			var shortcodesub_slider=jQuery('#secondary_nivoslider select').val();
			
			switch(shortcodesub_slider){
			case 'post':
					var nivo_effect = jQuery('[name="nivoslider_post_nivoeffect"]').val();
					var nivo_cat = jQuery('[name="nivoslider_post_nivocats[]"]').val();
					
					var nivo_speed = jQuery('[name="nivoslider_post_nivoanimspeed"]').val();
					var nivo_pausetime = jQuery('[name="nivoslider_post_nivopausetime"]').val();
					var nivo_limits = jQuery('[name="nivoslider_post_nivoslidelimit"]').val();
					var nivo_width = jQuery('[name="nivoslider_post_width"]').val();
					var nivo_height = jQuery('[name="nivoslider_post_height"]').val();
					var navigation =  jQuery('[name="nivoslider_post_navigation"]');
				if(navigation.is('.atp-button')){
				if(navigation.is(':checked')){
				navigation= ' navigation="true"';	
				}else{
				navigation= ' navigation="false"';		
				}
			}
					if(nivo_effect!="")			{ effect = ' effect="'+nivo_effect+'"';}else{effect	 = '';}
					if(nivo_cat!="")			{ cat = ' cat="'+nivo_cat+'"';}else{cat	 = '';}
					if(nivo_speed!="")			{ speed = ' speed="'+nivo_speed+'"';}else{speed	 = '';}
					if(nivo_pausetime!="")			{ pausetime = ' pausetime="'+nivo_pausetime+'"';}else{pausetime	 = '';}
					if(nivo_limits!="")			{ limits = ' limits="'+nivo_limits+'"';}else{limits	 = '';}
					if(nivo_width!="")			{ width = ' width="'+nivo_width+'"';}else{width	 = '';}
					if(nivo_height!="")			{ height = ' height="'+nivo_height+'"';}else{height	 = '';}

				return '\n[slider'+effect+cat+speed+pausetime+limits+width+height+navigation+']\n';	
				break;
			case 'slider':
					var nivo_effect = jQuery('[name="nivoslider_slider_nivoeffect"]').val();					
					var nivo_speed = jQuery('[name="nivoslider_slider_nivoanimspeed"]').val();
					var nivo_pausetime = jQuery('[name="nivoslider_slider_nivopausetime"]').val();
					var nivo_limits = jQuery('[name="nivoslider_slider_nivoslidelimit"]').val();
					var nivo_width = jQuery('[name="nivoslider_slider_width"]').val();
					var nivo_height = jQuery('[name="nivoslider_slider_height"]').val();
						var navigation =  jQuery('[name="nivoslider_slider_navigation"]');
				if(navigation.is('.atp-button')){
				if(navigation.is(':checked')){
				navigation= ' navigation="true"';	
				}else{
				navigation= ' navigation="false"';		
				}
			}
					if(nivo_effect!="")			{ effect = ' effect="'+nivo_effect+'"';}else{effect	 = '';}
					if(nivo_cat!="")			{ cat = ' cat="'+nivo_cat+'"';}else{cat	 = '';}
					if(nivo_speed!="")			{ speed = ' speed="'+nivo_speed+'"';}else{speed	 = '';}
					if(nivo_pausetime!="")			{ pausetime = ' pausetime="'+nivo_pausetime+'"';}else{pausetime	 = '';}
					if(nivo_limits!="")			{ limits = ' limits="'+nivo_limits+'"';}else{limits	 = '';}
						if(nivo_width!="")			{ width = ' width="'+nivo_width+'"';}else{width	 = '';}
						if(nivo_height!="")			{ height = ' height="'+nivo_height+'"';}else{height	 = '';}
				return '\n[slider'+effect+speed+pausetime+limits+width+height+navigation+']\n';		
				break;
					case 'postattachment':
					var nivo_effect = jQuery('[name="nivoslider_postattachment_nivoeffect"]').val();					
					var nivo_speed = jQuery('[name="nivoslider_postattachment_nivoanimspeed"]').val();
					var nivo_pausetime = jQuery('[name="nivoslider_postattachment_nivopausetime"]').val();
					var nivo_limits = jQuery('[name="nivoslider_postattachment_nivoslidelimit"]').val();
					var nivo_width = jQuery('[name="nivoslider_postattachment_width"]').val();
					var nivo_height = jQuery('[name="nivoslider_postattachment_height"]').val();
						var navigation =  jQuery('[name="nivoslider_postattachment_navigation"]');
				if(navigation.is('.atp-button')){
				if(navigation.is(':checked')){
				navigation= ' navigation="true"';	
				}else{
				navigation= ' navigation="false"';		
				}
			}
					if(nivo_effect!="")			{ effect = ' effect="'+nivo_effect+'"';}else{effect	 = '';}
					if(nivo_cat!="")			{ cat = ' cat="'+nivo_cat+'"';}else{cat	 = '';}
					if(nivo_speed!="")			{ speed = ' speed="'+nivo_speed+'"';}else{speed	 = '';}
					if(nivo_pausetime!="")			{ pausetime = ' pausetime="'+nivo_pausetime+'"';}else{pausetime	 = '';}
					if(nivo_limits!="")			{ limits = ' limits="'+nivo_limits+'"';}else{limits	 = '';}
					if(nivo_width!="")			{ width = ' width="'+nivo_width+'"';}else{width	 = '';}
					if(nivo_height!="")			{ height = ' height="'+nivo_height+'"';}else{height	 = '';}
				return '\n[postslider'+effect+speed+pausetime+limits+width+height+navigation+']\n';		
				break;
				}
	
			break;	
/*** BLOG ***/
	case 'blog':
			var blog_cat = jQuery('[name="blog_cat[]"]').val();
			var blogimage = jQuery('[name="blog_image"]');
			var blogmeta = jQuery('[name="blog_meta"]');
			var blog_max = jQuery('[name="blog_limit"]').val();
			var blog_limitcontent = jQuery('[name="blog_limitcontent"]').val();

			var blogpagination = jQuery('[name="blog_pagination"]');
			var blog_imgheight = jQuery('[name="blog_imgheight"]').val();
			var blogstyle =  jQuery('[name="blog_blogstyle"]').val();
			if(blogstyle !== '')		{ blogstyle= ' blogstyle="'+blogstyle+'"';}
			if(blog_imgheight !="")	{ imgheight = ' imgheight="'+blog_imgheight+'"';}else{imgheight = ' imgheight="250"';}	
			if(blogimage.is('.atp-button')){
				if(blogimage.is(':checked')){
				image= ' image="true"';	
				}else{
				image= ' image="false"';		
				}
			}		
			if(blogpagination.is('.atp-button')){
				if(blogpagination.is(':checked')){
				pagination= ' pagination="true"';	
				}else{
				pagination= ' pagination="false"';		
				}
			}		
			if(blogmeta.is('.atp-button')){
				if(blogmeta.is(':checked')){
				meta= ' postmeta="true"';	
				}else{
				meta= ' meta="false"';		
				}
			}		
			if(blog_cat!="")			{ cat = ' cat="'+blog_cat+'"';	}else{	cat = '';}
			if(blog_max!="")			{ max = ' limit="'+blog_max+'"';}else{max	 = '';}
			if(blog_limitcontent!="")			{ charlimits = ' charlimits="'+blog_limitcontent+'"';}else{charlimits = '';}	
			return '[blog'+cat+meta+max+pagination+imgheight+image+blogstyle+charlimits+']';
			break;	
/*** PORTFOLIO ***/
		case 'portfolio':
			var columns = jQuery('[name="portfolio_column"]').val();
			var portfolio_cat = jQuery('[name="portfolio_cat[]"]').val();
			var portfoliotitle = jQuery('[name="portfolio_title"]');
			var portfoliodesc = jQuery('[name="portfolio_desc"]');
			var portfolio_sidebar = jQuery('[name="portfolio_sidebar"]');
			var portfolio_limit = jQuery('[name="portfolio_limit"]').val();
			var portfolio_readmoretxt = jQuery('[name="portfolio_readmore"]').val();
			var portfoliomorebutton = jQuery('[name="portfolio_morebutton"]');
			var portfolio_limitcontent = jQuery('[name="portfolio_limitcontent"]').val();
			var portfoliopagination = jQuery('[name="portfolio_pagination"]');
			var portfolio_imgheight = jQuery('[name="portfolio_imgheight"]').val();
			if(columns !="")					{ columns = ' columns="'+columns+'"';}else{columns = ' columns="4"';}
			if(portfolio_imgheight !="")	{ imgheight = ' imgheight="'+portfolio_imgheight+'"';}else{imgheight = ' imgheight="250"';}
				if(portfoliotitle.is('.atp-button')){
				if(portfoliotitle.is(':checked')){
				title= ' title="true"';	
				}else{
				title= ' title="false"';		
				}
			}
			if(portfoliodesc.is('.atp-button')){
				if(portfoliodesc.is(':checked')){
				desc= ' desc="true"';	
				}else{
				desc= ' desc="false"';		
				}
			}	
			if(portfolio_cat!="")			{ cat = ' cat="'+portfolio_cat+'"';	}else{	cat = '';}
			if(portfolio_limit!="")			{ limit = ' limit="'+portfolio_limit+'"';}else{limit	 = '';}
			if(portfolio_readmoretxt!="")		{ readmoretext = ' readmoretext="'+portfolio_readmoretxt+'"'; }else{ readmoretext = '';}
			if(portfoliomorebutton.is('.atp-button')){
				if(portfoliomorebutton.is(':checked')){
				readmore= ' readmore="true"';	
				}else{
				readmore= ' readmore="false"';		
				}
			}
			if(portfolio_sidebar.is('.atp-button')){
						if(portfolio_sidebar.is(':checked')){
						sidebar= ' sidebar="true"';	
						}else{
						sidebar= ' sidebar="false"';		
						}
					}	
			if(portfoliopagination.is('.atp-button')){
				if(portfoliopagination.is(':checked')){
				pagination= ' pagination="true"';	
				}else{
				pagination= ' pagination="false"';		
				}
			}	
			if(portfolio_limitcontent!="")	{ charlimits = ' charlimits="'+portfolio_limitcontent+'"';}else{charlimits = ' charlimits="150"';}	
			return '[portfolio'+columns+cat+title+desc+limit+readmoretext+readmore+charlimits+pagination+imgheight+sidebar+']';
			break;
		/*** Todayspecial ***/
		case 'todayspecial':
			var todayspecial_tags = jQuery('[name="todayspecial_tags[]"]').val();
			var todayspecialtitle = jQuery('[name="todayspecial_title"]');
			var todayspecialdesc = jQuery('[name="todayspecial_desc"]');
			var todayspecial_limit = jQuery('[name="todayspecial_limit"]').val();
			var todayspecial_readmoretxt = jQuery('[name="todayspecial_readmore"]').val();
			var todayspecialmorebutton = jQuery('[name="todayspecial_morebutton"]');
			var todayspecial_limitcontent = jQuery('[name="todayspecial_limitcontent"]').val();
			var todayspecialpagination = jQuery('[name="todayspecial_pagination"]');
			var todayspecial_imgheight = jQuery('[name="todayspecial_imgheight"]').val();
			if(columns !="")					{ columns = ' columns="'+columns+'"';}else{columns = ' columns="4"';}
			if(todayspecial_imgheight !="")	{ imgheight = ' imgheight="'+todayspecial_imgheight+'"';}else{imgheight = ' imgheight="250"';}
				if(todayspecialtitle.is('.atp-button')){
				if(todayspecialtitle.is(':checked')){
				title= ' title="true"';	
				}else{
				title= ' title="false"';		
				}
			}
			if(todayspecialdesc.is('.atp-button')){
				if(todayspecialdesc.is(':checked')){
				desc= ' desc="true"';	
				}else{
				desc= ' desc="false"';		
				}
			}	
			if(todayspecial_tags!="")			{ tags = ' tags="'+todayspecial_tags+'"';	}else{	tags = '';}
			if(todayspecial_limit!="")			{ limit = ' limit="'+todayspecial_limit+'"';}else{limit	 = '';}
			if(todayspecial_readmoretxt!="")		{ readmoretext = ' readmoretext="'+todayspecial_readmoretxt+'"'; }else{ readmoretext = '';}
			if(todayspecialmorebutton.is('.atp-button')){
				if(todayspecialmorebutton.is(':checked')){
				readmore= ' readmore="true"';	
				}else{
				readmore= ' readmore="false"';		
				}
			}
		if(todayspecialpagination.is('.atp-button')){
				if(todayspecialpagination.is(':checked')){
				pagination= ' pagination="true"';	
				}else{
				pagination= ' pagination="false"';		
				}
			}	
			if(todayspecial_limitcontent!="")	{ charlimits = ' charlimits="'+todayspecial_limitcontent+'"';}else{charlimits = ' charlimits="150"';}	
			return '[todayspecial'+tags+title+desc+limit+readmoretext+readmore+charlimits+pagination+imgheight+']';
			break;
		
		}
	},
	sendToEditor :function(){
		send_to_editor(shortcode.generate());
	}
}
jQuery(document).ready( function() {
	shortcode.init();
});