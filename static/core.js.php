<?php header('Content-Type: application/javascript'); ?>'use strict';

var bbParams = {
		"toolbarButtonSize": "large",
		"toolbarAdaptive": false,
		"buttons": "bold,strikethrough,underline,italic,link,ul,table,source",
	    "useAceEditor": false,
	    "showPlaceholder": false,
    	"extraButtons": ["previewContent"]
	};

var unbindBeforeUnloadStatus = false;

function unbindBeforeUnload(status,text){

	unbindBeforeUnloadStatus = status;
	
	if(status) {

		window.onbeforeunload = function() {
			if(!unbindBeforeUnloadStatus) return null;
	    	return (typeof(text)!='undefined'?text:'You have changed Account Status but did not save. Are you sure you want to leave?');
		};

		$("a[href!='']").addClass('ubgo');

	} else {

		window.onbeforeunload = null;
		$("a[href!='']").removeClass('ubgo');

	}
}

function deleteUser(el, id){
	var x = window.confirm("Are you sure you want to delete this user?");
	if(x){
		btnLoader(el);
		$.get("/ajax.php?action=delete-user&id="+id, function(data){
			if(data.status=='ok'){
				$("#content-form").html('<div class="success">This account was successfully deleted</div>');
				$("#user-attendance").remove();
			} else {
				$(el).html('Delete');
				alert(data.error);
			}
		}, 'json');
	}
}

function addUsersSpreadsheet(){
	$("#spreadsheet-users-file").trigger("click");
}

(function (factory) {
	if (typeof define === 'function' && define.amd) {
		// AMD
		define(['jquery'], factory);
	} else if (typeof exports === 'object') {
		// CommonJS
		factory(require('jquery'));
	} else {
		// Browser globals
		factory(jQuery);
	}
}(function ($) {

	var pluses = /\+/g;

	function encode(s) {
		return config.raw ? s : encodeURIComponent(s);
	}

	function decode(s) {
		return config.raw ? s : decodeURIComponent(s);
	}

	function stringifyCookieValue(value) {
		return encode(config.json ? JSON.stringify(value) : String(value));
	}

	function parseCookieValue(s) {
		if (s.indexOf('"') === 0) {
			// This is a quoted cookie as according to RFC2068, unescape...
			s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
		}

		try {
			// Replace server-side written pluses with spaces.
			// If we can't decode the cookie, ignore it, it's unusable.
			// If we can't parse the cookie, ignore it, it's unusable.
			s = decodeURIComponent(s.replace(pluses, ' '));
			return config.json ? JSON.parse(s) : s;
		} catch(e) {}
	}

	function read(s, converter) {
		var value = config.raw ? s : parseCookieValue(s);
		return $.isFunction(converter) ? converter(value) : value;
	}

	var config = $.cookie = function (key, value, options) {

		// Write

		if (value !== undefined && !$.isFunction(value)) {
			options = $.extend({}, config.defaults, options);

			if (typeof options.expires === 'number') {
				var days = options.expires, t = options.expires = new Date();
				t.setTime(+t + days * 864e+5);
			}

			return (document.cookie = [
				encode(key), '=', stringifyCookieValue(value),
				options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
				options.path    ? '; path=' + options.path : '',
				options.domain  ? '; domain=' + options.domain : '',
				options.secure  ? '; secure' : ''
			].join(''));
		}

		// Read

		var result = key ? undefined : {};

		// To prevent the for loop in the first place assign an empty array
		// in case there are no cookies at all. Also prevents odd result when
		// calling $.cookie().
		var cookies = document.cookie ? document.cookie.split('; ') : [];

		for (var i = 0, l = cookies.length; i < l; i++) {
			var parts = cookies[i].split('=');
			var name = decode(parts.shift());
			var cookie = parts.join('=');

			if (key && key === name) {
				// If second argument (value) is a function it's a converter...
				result = read(cookie, value);
				break;
			}

			// Prevent storing a cookie that we couldn't decode.
			if (!key && (cookie = read(cookie)) !== undefined) {
				result[name] = cookie;
			}
		}

		return result;
	};

	config.defaults = {};

	$.removeCookie = function (key, options) {
		if ($.cookie(key) === undefined) {
			return false;
		}

		// Must not alter options, thus extending a fresh object...
		$.cookie(key, '', $.extend({}, options, { expires: -1 }));
		return !$.cookie(key);
	};

}));

function bundleLocStorage(){
	var data = {};
	var len = len = localStorage.length;
	for(var i=0;i<len;++i){
		var k = localStorage.key(i);
	  	data[k] = localStorage.getItem(k);
	}
	return JSON.stringify(data);
}

function logout(step_back){
	$.get("/ajax.php?action=logout"+(typeof(step_back)!='undefined'?'&step_back=1':'')+'&local_storage='+bundleLocStorage(), function(data){
		if(data=='ok'){
			window.location.reload();
		}
	});
}


$.fn.textWidth = function(text, font) {
    if (!$.fn.textWidth.fakeEl) $.fn.textWidth.fakeEl = $('<span>').hide().appendTo(document.body);
    $.fn.textWidth.fakeEl.html(text || this.val() || this.html()).css('font', font || this.css('font'));
    return $.fn.textWidth.fakeEl.width();
};
$.fn.pressEnter = function(fn) {  
    return this.each(function() {  
        $(this).bind('enterPress', fn);
        $(this).keyup(function(e){
            if(e.keyCode == 13){
            	$(this).trigger("enterPress");
            }
        })
    });  
}; 

function printTableWithParams(page,sort,callback){
	if(typeof(page)!='undefined' && parseInt(page)>0){
		content_page = page;
	}
	if(typeof(page)!='undefined' && typeof(sort)!='undefined' && sort!=''){
		content_sort = sort;
	}	
	printTableContent(callback);
}

function setTableContentData(data){
	if((data.hasOwnProperty('view_role') || data.view_role) && typeof(content_view_role)!='undefined') content_view_role = data.view_role;
	content_section = data.section;
	content_page = data.page;
	content_sort = data.sort;
	content_search_text = data.search_text;
	if((data.hasOwnProperty('search_fields') || data.search_fields) && typeof(content_search_fields)!='undefined') content_search_fields = data.search_fields;
}

function printTableContent(callback){
 	var h1 = $("#table-content thead").height();
 	var h2 = $("#table-content tbody").height();
 	$('#table-content').append('<div class="loader" style="top: '+h1+'px;height: '+h2+'px;"><img src="/static/images/loader.gif" /></div>');
 	$.get('/ajax.php?action=get-table-content'
 		+((typeof(content_view_role)!='undefined'&&content_view_role)?'&view_role='+content_view_role:'')
 		+'&section='+content_section
 		+'&page='+content_page
 		+(content_sort?'&sort='+content_sort:'')
 		+((typeof(content_search_fields)!='undefined' && content_search_fields)?'&search_fields='+JSON.stringify(content_search_fields):'')
 		+(content_search_text!=''?'&search_text='+encodeURIComponent(content_search_text):''), function(data){

		if(data.status == 'ok'){
			$("#table-content .table-no-results").remove();
			$("#table-body").html(data.result);
		} else {
			if(!$("#table-content .table-no-results").length){
				$("#table-body").html('');
				$("#table-content").append(data.no_result);
 			}
		}
		$('#table-content .loader').remove();

		hideClearParamsButton(data);

		$("#table-after-params").html(data.after_params);
		var $scs = $("#cert-selection-list option[value='all']");
		if($scs.length){
			if(data.hasOwnProperty('certs_num') && data.certs_num>0) {
				$scs.removeAttr('disabled');
			} else {
				$scs.attr('disabled', 'disabled');
			}
			$scs.attr('data-num', data.certs_num);
		}
		$("#table-content thead .checkbox-column .row-checkbox").removeClass('checked');
		$('#cert-selection-list option[value="selected"]').text('Selected Certificates (0)');
		$("#cert-selection-list").removeClass('large');
		setTableContentData(data);

		//history.replaceState({
/*		history.pushState({
			nav: 'table-content',
			page: data.page, 
			sort: data.sort, 
			search_text: data.search_text, 
			search_fields: data.search_fields
		}, data.title, data.link);*/

		if(typeof(callback)!='undefined'){
			callback(data);
		} else {
			addPushState(data);
		}

	}, 'json');
}

function getAllSearchTableVars(){
	return ((typeof(content_view_role)!='undefined'&&content_view_role)?'&view_role='+content_view_role:'')
 		+'&section='+content_section
 		+'&page='+content_page
 		+(content_sort?'&sort='+content_sort:'')
 		+((typeof(content_search_fields)!='undefined' && content_search_fields)?'&search_fields='+JSON.stringify(content_search_fields):'')
 		+(content_search_text!=''?'&search_text='+encodeURIComponent(content_search_text):'');
}

function loginByAltId(el,id){
  	var $btn = $(el);
 	btnLoader(el);	
 	$.get('/ajax.php?action=login-as&id='+id, function(data){
 		if(data=='ok'){
 			$btn.text('Done!');
 			window.location.href = '/';
 		} else {
 			$btn.text('ERROR! NOT LOGGED!');
 		}
 		setTimeout(function(){
 			$btn.text('Login as this user');
 		}, 1500);
 	});
}
 
function changePassword(){
	var pass = $('#reg-password').val();
	if(pass==$('#reg-password2').val()){
		if(pass.length<6){
			contentResMessage(false, 'Password must be at least 6 characters', 4500);
		} else {
			$('#restore-form').submit();
		}
	} else {
		contentResMessage(false, 'Please, ensure that the two passwords are equal', 4500);
	}
}

function showSimpleModal(modal_tpl,close_btn){
	$("body").addClass('fix');
	$("#overlay").fadeIn(200);
	$("#edit-modal").remove();
	var tpl = '<div id="edit-modal">'+(close_btn?'<div class="close-modal"></div>':'') + modal_tpl + '</div>';
	$("body").append(tpl);
	$("#edit-modal").fadeIn(200);
}
function postUser(el,is_add,is_pin){
 	var $btn = $(el);
 	var err = false,
 		email_err = false,
 		add_mode = ((typeof(is_add)!='undefined' && is_add==true) ? true : false),
 		pin_mode = ((typeof(is_pin)!='undefined' && is_pin==true) ? true : false);
 	var _email = '';
 	var ut = $("#content-form input[name='user_type']").length ? $("#content-form input[name='user_type']").val() : '';

 	$("#content-form input").each(function(i,e){
 		if( $(e).val()=='' && !$(e).attr('name')=='email' ){
 			err = true;
 		} 		
 		//if suspended state selected then reason is required
 		if( $(e).val()=='false' && $(e).attr('name')=='is_active' && $("#content-form input[name='reason_suspension']").val()=='' ){
 			err = true;
 		}
 		
 		if($(e).attr('name')=='email'){
 			_email = $(e).val();
 			if($(e).val().split('@').length!=2){
 				email_err = true;
 			}
 		}
 	});
 	if(err){
 		contentResMessage(false, 'All fields marked with asterisk should be filled!');
 		return false;
 	}

 	if(email_err && !pin_mode && ut != 'user'){
 		contentResMessage(false, 'E-mail is not correct');
 		return false;
 	}
 	var form = $("#content-form").serialize();

 	btnLoader(el);
 	$.get("/ajax.php?action=post-user&"+form+(add_mode?'&is_add=1':'')+(pin_mode?'&is_pin=1':''), function(data){
 		if(data.status == 'ok'){
 			if(add_mode){

 					$(".content-top-nav").remove();
 					$("#content-form").html('<div class="data-row" style="font-size: 15px;">Login details sent to: '+_email+'</div><div class="btn-wrap"><a href="/" class="btnsave green">Back</a></div>');
 				
 				$("#content-msg").html('');
 			} else {
 				contentResMessage(true, 'Account information was successfully saved', 2500);


 				var $sdr = $("#content-form .suspension-depend-reason");
 				if($sdr.length){
 					var sdr_val = $sdr.hasClass('active') ? 0 : 1;
 					if($sdr.attr('data-val') != sdr_val){
 						$sdr.attr('data-val', sdr_val);
 						unbindBeforeUnload(false);
 						$("#suspension-reason").hide(150);
 						$("#add-note-button-wrap").show(150);
 					}
 				}
 			}
 		} else {
 			contentResMessage(false, data.error);
 		}
 		$btn.text('Save');
 	}, 'json');
 }
function contentResMessage(a,b,timer){
	
	$('#content-msg').html('<div class="'+(a?'success':'error')+'">'+b+'</div>');
	
	if(typeof(timer)!='undefined'){
		setTimeout(function(){
			$("#content-msg div").animate({opacity: 0}, {duration: 500, complete: function(){
				$("#content-msg").html('');
			}});
		}, timer);
	}
}

function btnLoader(el){
	$(el).html('<div class="btn-loader"><img src="/static/images/btn_loader.gif" /></div>');
}
function clearTableSorts(){
 	$("#table-content").find('.sortable').removeClass('sorted-asc').removeClass('sorted-desc');
}
function clearTableInputs(){
	$("#table-content .th-search").find('input').val('');
}
function hideClearParamsButton(data){
	if(data.sort || data.search_text!= '' || !jQuery.isEmptyObject(data.search_fields)) {
		$('#clear-params').fadeIn(150);
	} else {
		$('#clear-params').fadeOut(150);
	}
}
function addPushState(data){
				history.pushState({
					nav: 'table-content',
					section: data.section, 
					view_role: data.view_role, 
					page: data.page, 
					sort: data.sort, 
					search_text: data.search_text, 
					search_fields: data.search_fields
				}, data.title, data.link);
}




$(document).ready(function(){

	var $um = $("#user-menu"),
		$overlay = $("#overlay"),
		$uml = $("#user-menu-list"),
		$menu = $("#menu"),
		$header_menu = $("#header-menu");

	var hideUML = function(){
		$uml.animate({opacity: 0, top: '130%'}, {duration: 250, complete: function(){
			$uml.hide();
		}});
		$uml.removeClass('active');
	};

	var hideBox = function($el, perc){
		$el.animate({opacity: 0, left: '-225px'}, {duration: 250, complete: function(){
			$el.hide();
		}});
		$el.removeClass('active');
	};

	$("#sidebar-tg").on('click', function(){
		if($.cookie('sidebar-tg') == 'on'){
			$.cookie('sidebar-tg', 'off', { path: '/' });
			$('body').removeClass('sb-mini');
		} else {
			$.cookie('sidebar-tg', 'on', { path: '/' });
			$('body').addClass('sb-mini');
		}
	});

	$("#spreadsheet-users-file").on('change', function(){
 		var fv = document.getElementById('spreadsheet-users-file');
	    var file = fv!==null?(fv.files.length>0?fv.files[0]:''):'';
	    if(file){
			$("#extra-top-message-box").animate({opacity: 0}, {duration: 250, complete: function(){
				$("#extra-top-message-box").remove();
			}});
	    	var $btn_dr = $("#add-users-spreadsheet-button-data-res");
	    	var form = new FormData();
	        form.append('file', file);
	        btnLoader($btn_dr[0]);
	        $.ajax({
	            url: "/ajax.php?action=add-users-from-spreadsheet&role="+$(this).attr("data-role"),
	            type: 'POST',
	            cache: false,
	            contentType: false,
	            processData: false,
	            data: form,
	            complete: function(r){
	            	var json = $.parseJSON(r.responseText);

		 			$btn_dr.html($btn_dr.attr('data-name'));
					fv.value = '';

		 			var result = '';

		 			if(json.status == 'ok'){
		 				result = '<div class="success">Your filed was successfully imported.</div>';
		 			} else {
		 				result = '<div class="error">'+json.error+'</div>';
		 			}

		 			if($("#extra-top-message-box").length){
		 				$("#extra-top-message-box").html(result);
		 			} else {
		 				$(".content-top-nav").after('<div id="extra-top-message-box">'+result+'</div>');
		 			}
/*		 			setTimeout(function(){
		 				$("#extra-top-message-box").animate({opacity: 0}, {duration: 250, complete: function(){
							$("#extra-top-message-box").remove();
						}});
		 			}, 5000);*/

	            }
	        });
	    }
	});

	window.addEventListener('popstate', function(e){
		if(window.history){

			if(typeof(e.state) != null && typeof(e.state)=='object' && e.state.hasOwnProperty('nav')){

		  		setTableContentData(e.state);

				printTableWithParams(e.state.page,e.state.sort,function(data){
					clearTableSorts();
					if(data.sort){
						var s = data.sort.split('-');
						var $th = $('#table-content th[data-id="'+s[0]+'"]');
						$th.attr('data-order', s[1]);
						$th.addClass('sorted-'+s[1]);
					}
					
					$('#table-search').val(data.search_text);
					
					if(jQuery.isEmptyObject(data.search_fields)){
						clearTableInputs();
					} else {
						clearTableInputs();
						for(var i in data.search_fields){
							$('#table-content .th-search[data-id="'+i+'"]').find('input').val(data.search_fields[i]);
						}
					}
					
					hideClearParamsButton(data);

				});

	  		}
		}
	});

	var $dailyDateInput = $('#daily-report-date');
	var $tableLastModifiedInput = $('#table-last-modified');
	var $tableCompletionDateInput = $('#table-completion-date');
	var dateDefaultFormat = function(date){
			var day = date.getDate();
	        day = day<10?'0'+day:day;
	        var month = date.getMonth() + 1;
	        month = month<10?'0'+month:month;
	        var year = date.getFullYear();
	        return `${day}/${month}/${year}`;
	}
	var dateDefaultParse = function(dateString){
		var parts = dateString.split('/');
	    var day = parseInt(parts[0], 10);
	    var month = parseInt(parts[1], 10) - 1;
	    var year = parseInt(parts[2], 10);
	    return new Date(year, month, day);
	}

	if($tableCompletionDateInput.length){

    	var lastModifiedPicker = new Pikaday({
        field: $tableCompletionDateInput[0],
        defaultDate: dateDefaultParse($tableCompletionDateInput.val()),
        setDefaultDate: true,
        format: 'D/M/YYYY',
        firstDay: 1,
	    toString(date, format){
	        //  return 'D/M/YYYY' for simplicity
	        return dateDefaultFormat(date);
	    },
	    parse(dateString, format){
	        // dateString is the result of `toString` method
	        return dateDefaultParse(dateString);
	    },
	    onSelect: function(date){
			content_search_fields['completion_date'] = dateDefaultFormat(date);
			printTableContent();
    	}
    	});

		$tableCompletionDateInput.on('change keyup', function(){
			if($(this).val() == ''){
				delete content_search_fields['completion_date'];
				printTableContent();
			}
		});

	}
	if($tableLastModifiedInput.length){

    	var lastModifiedPicker = new Pikaday({
        field: $tableLastModifiedInput[0],
        defaultDate: dateDefaultParse($tableLastModifiedInput.val()),
        setDefaultDate: true,
        format: 'D/M/YYYY',
        firstDay: 1,
	    toString(date, format){
	        //  return 'D/M/YYYY' for simplicity
	        return dateDefaultFormat(date);
	    },
	    parse(dateString, format){
	        // dateString is the result of `toString` method
	        return dateDefaultParse(dateString);
	    },
	    onSelect: function(date){
			content_search_fields['last_modified'] = dateDefaultFormat(date);
			printTableContent();
    	}
    	});
    	if($tableLastModifiedInput.val()!=''){
    		//console.log($tableLastModifiedInput.val(), dateDefaultParse($tableLastModifiedInput.val()));
    		//lastModifiedPicker.setDate($tableLastModifiedInput.val());
    	}
		$tableLastModifiedInput.on('change keyup', function(){
			if($(this).val() == ''){
				delete content_search_fields['last_modified'];
				printTableContent();
			}
		});

	}

	//report
	if($dailyDateInput.length){

    	var lastModifiedPicker = new Pikaday({
        field: $dailyDateInput[0],
        defaultDate: dateDefaultParse($dailyDateInput.val()),
        setDefaultDate: true,
        format: 'D/M/YYYY',
        firstDay: 1,
	    toString(date, format){
	        //  return 'D/M/YYYY' for simplicity
	        return dateDefaultFormat(date);
	    },
	    parse(dateString, format){
	        // dateString is the result of `toString` method
	        return dateDefaultParse(dateString);
	    },
	    onSelect: function(date){
			window.location.href="/reports/daily/?date="+dateDefaultFormat(date);
    	}
    	});

	}




	$("body").on('click', '.date-custom-picker .pw-value', function(){
		$(this).next().slideToggle(150);
	});		
	$("body").on('click', '.date-custom-picker .pw', function(){
		
		window.location.href="/reports/"+$(this).parent().parent().attr("data-id")+"/?wp="+$(this).attr("data-wp");
	});	

	$("body").on('click', '.ubgo', function(){
		return false;
	});	


	$("body").on("click input change", ".bi", function(e){
		var $inp = $(this).find("input");

		//Increment input integer
		if($(e.target).hasClass('ii-increase')){
			//transform from negative
			if($(e.target).hasClass('ii-negative')){
				var cv = $inp.val() ? $inp.val() : 0;
				var cv = parseInt(cv);
				$inp.val(cv+1);
			} else {
				var cv = parseInt($inp.val())>0?parseInt($inp.val()):0;
				$inp.val(cv+1);
			}
			$inp.trigger('change');
			$(this).addClass("active");
			return;
		}

		//Decrease
		if($(e.target).hasClass('ii-decrease')){
			//can be negative
			if($(e.target).hasClass('ii-negative')){
				var cv = $inp.val() ? $inp.val() : 0;
				cv = parseInt(cv);
				$inp.val(cv-1);
			} else {
				var cv = parseInt($inp.val())>0?parseInt($inp.val()):0;
				$inp.val((cv-1)<0?0:(cv-1));
			}
			$inp.trigger('change');
			$(this).addClass("active");
			return;
		}

		if($(this).hasClass("active")) return;

		$inp.focus();
		$(this).addClass("active");
	});
	$("body").on("blur", ".bi input", function(){
		if($(this).val()==""){
			$(this).parent().parent().removeClass("active");
		}
	});


	$("body").on('click', '.bi-fulldd-wrap input', function(){
		$(this).parent().find('ul').show().animate({opacity: 1, top: '100%'}, 250);
	});
	$("body").on('click', '.bi-fulldd li', function(){
		var $p = $(this).parent();
		var $pp = $p.parent();
		var a = $(this).attr('data-id');
		if(!$pp.hasClass("simple-change")){
			$pp.find('input').val(a+' year'+(a>1?'s':''));
		} else {
			$pp.find('input').val($(this).text());
			if($pp.hasClass('depend-smtp-security')){
				if(a == "tls"){
					$("#smtp-autotls-row").hide(150);
				} else {
					$("#smtp-autotls-row").show(150);
				}
				if(a == "tls"){
					$("#smtp-port").val("587");
				} else if(a == "ssl"){
					$("#smtp-port").val("465");
				} else {
					$("#smtp-port").val("25");
				}
				$("#smtp-port-row").find(".bi").addClass("active");
			}
			if($pp.hasClass('depend-smtp-auth')){
				if(a == "true"){
					$("#smtp-username-row").show(150);
					$("#smtp-password-row").show(150);
				} else {
					$("#smtp-username-row").hide(150);
					$("#smtp-password-row").hide(150);
				}
			}
		}
		
		$('.bi-fulldd').animate({opacity: 0, top: '130%'}, {duration: 250, complete: function(){
			$('.bi-fulldd').hide();
		}});
	});
	$("body").on('click', '.th-select input', function(){
		var $ul = $(this).parent().find('ul');

		$ul.show().animate({opacity: 1, top: '100%'}, 250);
		var $g = $('.th-select-ul').not($ul);
		$g.animate({opacity: 0, top: '130%'}, {duration: 250, complete: function(){
			$g.hide();
		}});

	});
	$("body").on('click', '.th-select-ul li', function(){
		var $p = $(this).parent();
		var $pp = $p.parent();
		var a = $(this).attr('data-id');
		$pp.find('input').val($(this).text());
		$('.th-select-ul').animate({opacity: 0, top: '130%'}, {duration: 250, complete: function(){
			$('.th-select-ul').hide();
		}});
		var field = $pp.attr('data-id');
		content_search_fields[field] = encodeURIComponent(a);
		printTableContent();
	});

	$("body").on("change keyup", "#user-note", function(){
		var $p = $(this).parent().parent().next();
		if($(this).val() != ''){
			if($p.css('display')=='none'){
				$p.show(150);
			}
		} else {
			$p.hide(150);
		}
	});	

	$("body").on('click', '.tg-header', function(){
		$(this).parent().next().find(".newton").toggle(150);
		$(this).toggleClass("open");
	});


	$("body").on("click", ".bi-switcher", function(){
		var nv = false;
		var off_name = $(this).attr('data-off');
		var on_name = $(this).attr('data-on');
		if(!on_name) on_name = 'ON';
		if(!off_name) off_name = 'OFF';
		var nv_name = 0;
		if($(this).hasClass("active")){
			$(this).find(".sw-val").text(off_name);
			$(this).removeClass("active");
			$(this).find("input").val("false");
			nv_name = 1;
		} else {
			$(this).find(".sw-val").text(on_name);
			$(this).addClass("active");
			$(this).find("input").val("true");
			nv = true;
		}
		if($(this).hasClass("suspension-depend-reason")){
			var $ww = $(this).next();
			if(nv){
				$ww.find(".input-label").text('Reason for Activation');
			} else {
				$ww.find(".input-label").text('Reason for Suspended');
			}

			if($(this).attr('data-val') != nv_name){
				$("#add-note-button-wrap").hide(150);
				$ww.show(150);
				unbindBeforeUnload(true);
			} else {
				$("#add-note-button-wrap").show(150);
				$ww.hide(150);
				unbindBeforeUnload(false);
			}
		}

	});



	//Table pagination
	$('body').on('click', '.pagi a', function(){
		var pid = $(this).attr('data-id');
		if(pid!=''){
			//only pid
			printTableWithParams(pid,'',function(data){
				addPushState(data);
			});
		}
		return false;
	});

	//Table TH Onpress
	$('th.sortable').on('click', function(e){
		if($(e.target).prop("tagName").toLowerCase() != 'input'){

			var $th = $(this),
				new_sort = $(this).attr('data-id'),
				cur_order = $(this).attr('data-order');

			if(cur_order!=''){
				new_sort += '-'+(cur_order=='desc'?'asc':'desc');
			}

			printTableWithParams(0,new_sort,function(data){
				var s = data.sort.split('-')[1];
				clearTableSorts();
				$th.attr('data-order', s);
				$th.addClass('sorted-'+s);

				addPushState(data);

			});

		}
	});



	$("body").on('click', '#clear-params', function(){
		content_sort = '';
		content_search_text = '';
		if(typeof(content_search_fields)!='undefined') content_search_fields = {};
		printTableContent();
		clearTableSorts();
		clearTableInputs();
		$('#table-search').val('');
		$(this).hide();
	});

	$('#table-search').pressEnter(function(){
		content_search_text = encodeURIComponent($(this).val());
		printTableContent();
	});

	$('.th-search input').pressEnter(function(){
		var field = $(this).parent().attr('data-id');
		content_search_fields[field] = encodeURIComponent($(this).val());
		printTableContent();
	});

	$("#user-menu").on('click', '.inline-name', function(){
		if($uml.hasClass('active')){

			hideUML();

		} else {
		
			$uml.show().animate({opacity: 1, top: '100%'}, 250);
			$uml.addClass('active');
			
		}
	});	
	$menu.on('click', function(){
		if(!$header_menu.hasClass('active')){
			$header_menu.show().animate({opacity: 1, left: 0}, 250);
			$header_menu.addClass('active');
		} else {
			hideBox($header_menu, 130);
		}
	});

	$("#table-size").on('change', function(){
		$.get('/ajax.php?action=set-table-size&size='+$(this).val(), function(data){
			if(data == 'ok'){
				window.location.reload();
			}
		});
	});

	$("body").on('click', function(e){

	    if(!$um.is(e.target) && $um.has(e.target).length === 0) {
			hideUML();
	    }
	    if(!$menu.is(e.target) && !$header_menu.is(e.target) && $header_menu.has(e.target).length === 0) {
			hideBox($header_menu, 130);
	    }	    



	    if(!$('.bi-fulldd-wrap input').is(e.target) && !$('.bi-fulldd').is(e.target) && $('.bi-fulldd').has(e.target).length === 0) {
			$('.bi-fulldd').animate({opacity: 0, top: '130%'}, {duration: 250, complete: function(){
				$('.bi-fulldd').hide();
			}});
	    }

	    if(!$('.th-select input').is(e.target) && !$('.th-select-ul').is(e.target) && $('.th-select-ul').has(e.target).length === 0) {
			$('.th-select-ul').animate({opacity: 0, top: '130%'}, {duration: 250, complete: function(){
				$('.th-select-ul').hide();
			}});
	    }	    

	    if(!$('.date-custom-picker .pw-value').is(e.target) && !$('.date-custom-picker .list').is(e.target) && $('.date-custom-picker .list').has(e.target).length === 0) {
			$('.date-custom-picker .list').slideUp(150);
	    }	    

	});

});


/**
pikaday
*/
!function(e,t){"use strict";var n;if("object"==typeof exports){try{n=require("moment")}catch(e){}module.exports=t(n)}else"function"==typeof define&&define.amd?define(function(e){try{n=e("moment")}catch(e){}return t(n)}):e.Pikaday=t(e.moment)}(this,function(n){"use strict";var s="function"==typeof n,o=!!window.addEventListener,c=window.document,h=window.setTimeout,r=function(e,t,n,a){o?e.addEventListener(t,n,!!a):e.attachEvent("on"+t,n)},t=function(e,t,n,a){o?e.removeEventListener(t,n,!!a):e.detachEvent("on"+t,n)},l=function(e,t){return-1!==(" "+e.className+" ").indexOf(" "+t+" ")},f=function(e,t){l(e,t)||(e.className=""===e.className?t:e.className+" "+t)},g=function(e,t){var n;e.className=(n=(" "+e.className+" ").replace(" "+t+" "," ")).trim?n.trim():n.replace(/^\s+|\s+$/g,"")},y=function(e){return/Array/.test(Object.prototype.toString.call(e))},F=function(e){return/Date/.test(Object.prototype.toString.call(e))&&!isNaN(e.getTime())},L=function(e,t){return[31,(n=e,n%4==0&&n%100!=0||n%400==0?29:28),31,30,31,30,31,31,30,31,30,31][t];var n},P=function(e){F(e)&&e.setHours(0,0,0,0)},B=function(e,t){return e.getTime()===t.getTime()},d=function(e,t,n){var a,i;for(a in t)(i=void 0!==e[a])&&"object"==typeof t[a]&&null!==t[a]&&void 0===t[a].nodeName?F(t[a])?n&&(e[a]=new Date(t[a].getTime())):y(t[a])?n&&(e[a]=t[a].slice(0)):e[a]=d({},t[a],n):!n&&i||(e[a]=t[a]);return e},i=function(e,t,n){var a;c.createEvent?((a=c.createEvent("HTMLEvents")).initEvent(t,!0,!1),a=d(a,n),e.dispatchEvent(a)):c.createEventObject&&(a=c.createEventObject(),a=d(a,n),e.fireEvent("on"+t,a))},a=function(e){return e.month<0&&(e.year-=Math.ceil(Math.abs(e.month)/12),e.month+=12),11<e.month&&(e.year+=Math.floor(Math.abs(e.month)/12),e.month-=12),e},u={field:null,bound:void 0,ariaLabel:"Use the arrow keys to pick a date",position:"bottom left",reposition:!0,format:"YYYY-MM-DD",toString:null,parse:null,defaultDate:null,setDefaultDate:!1,firstDay:0,formatStrict:!1,minDate:null,maxDate:null,yearRange:10,showWeekNumber:!1,pickWholeWeek:!1,minYear:0,maxYear:9999,minMonth:void 0,maxMonth:void 0,startRange:null,endRange:null,isRTL:!1,yearSuffix:"",showMonthAfterYear:!1,showDaysInNextAndPreviousMonths:!1,enableSelectionDaysInNextAndPreviousMonths:!1,numberOfMonths:1,mainCalendar:"left",container:void 0,blurFieldOnSelect:!0,i18n:{previousMonth:"Previous Month",nextMonth:"Next Month",months:["January","February","March","April","May","June","July","August","September","October","November","December"],weekdays:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],weekdaysShort:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"]},theme:null,events:[],onSelect:null,onOpen:null,onClose:null,onDraw:null,keyboardInput:!0},m=function(e,t,n){for(t+=e.firstDay;7<=t;)t-=7;return n?e.i18n.weekdaysShort[t]:e.i18n.weekdays[t]},H=function(e){var t=[],n="false";if(e.isEmpty){if(!e.showDaysInNextAndPreviousMonths)return'<td class="is-empty"></td>';t.push("is-outside-current-month"),e.enableSelectionDaysInNextAndPreviousMonths||t.push("is-selection-disabled")}return e.isDisabled&&t.push("is-disabled"),e.isToday&&t.push("is-today"),e.isSelected&&(t.push("is-selected"),n="true"),e.hasEvent&&t.push("has-event"),e.isInRange&&t.push("is-inrange"),e.isStartRange&&t.push("is-startrange"),e.isEndRange&&t.push("is-endrange"),'<td data-day="'+e.day+'" class="'+t.join(" ")+'" aria-selected="'+n+'"><button class="pika-button pika-day" type="button" data-pika-year="'+e.year+'" data-pika-month="'+e.month+'" data-pika-day="'+e.day+'">'+e.day+"</button></td>"},p=function(e,t,n,a,i,s){var o,r,l,h,d,u=e._o,c=n===u.minYear,f=n===u.maxYear,g='<div id="'+s+'" class="pika-title" role="heading" aria-live="assertive">',m=!0,p=!0;for(l=[],o=0;o<12;o++)l.push('<option value="'+(n===i?o-t:12+o-t)+'"'+(o===a?' selected="selected"':"")+(c&&o<u.minMonth||f&&o>u.maxMonth?'disabled="disabled"':"")+">"+u.i18n.months[o]+"</option>");for(h='<div class="pika-label">'+u.i18n.months[a]+'<select class="pika-select pika-select-month" tabindex="-1">'+l.join("")+"</select></div>",y(u.yearRange)?(o=u.yearRange[0],r=u.yearRange[1]+1):(o=n-u.yearRange,r=1+n+u.yearRange),l=[];o<r&&o<=u.maxYear;o++)o>=u.minYear&&l.push('<option value="'+o+'"'+(o===n?' selected="selected"':"")+">"+o+"</option>");return d='<div class="pika-label">'+n+u.yearSuffix+'<select class="pika-select pika-select-year" tabindex="-1">'+l.join("")+"</select></div>",u.showMonthAfterYear?g+=d+h:g+=h+d,c&&(0===a||u.minMonth>=a)&&(m=!1),f&&(11===a||u.maxMonth<=a)&&(p=!1),0===t&&(g+='<button class="pika-prev'+(m?"":" is-disabled")+'" type="button">'+u.i18n.previousMonth+"</button>"),t===e._o.numberOfMonths-1&&(g+='<button class="pika-next'+(p?"":" is-disabled")+'" type="button">'+u.i18n.nextMonth+"</button>"),g+"</div>"},V=function(e,t,n){return'<table cellpadding="0" cellspacing="0" class="pika-table" role="grid" aria-labelledby="'+n+'">'+function(e){var t,n=[];for(e.showWeekNumber&&n.push("<th></th>"),t=0;t<7;t++)n.push('<th scope="col"><abbr title="'+m(e,t)+'">'+m(e,t,!0)+"</abbr></th>");return"<thead><tr>"+(e.isRTL?n.reverse():n).join("")+"</tr></thead>"}(e)+("<tbody>"+t.join("")+"</tbody>")+"</table>"},e=function(e){var a=this,i=a.config(e);a._onMouseDown=function(e){if(a._v){var t=(e=e||window.event).target||e.srcElement;if(t)if(l(t,"is-disabled")||(!l(t,"pika-button")||l(t,"is-empty")||l(t.parentNode,"is-disabled")?l(t,"pika-prev")?a.prevMonth():l(t,"pika-next")&&a.nextMonth():(a.setDate(new Date(t.getAttribute("data-pika-year"),t.getAttribute("data-pika-month"),t.getAttribute("data-pika-day"))),i.bound&&h(function(){a.hide(),i.blurFieldOnSelect&&i.field&&i.field.blur()},100))),l(t,"pika-select"))a._c=!0;else{if(!e.preventDefault)return e.returnValue=!1;e.preventDefault()}}},a._onChange=function(e){var t=(e=e||window.event).target||e.srcElement;t&&(l(t,"pika-select-month")?a.gotoMonth(t.value):l(t,"pika-select-year")&&a.gotoYear(t.value))},a._onKeyChange=function(e){if(e=e||window.event,a.isVisible())switch(e.keyCode){case 13:case 27:i.field&&i.field.blur();break;case 37:e.preventDefault(),a.adjustDate("subtract",1);break;case 38:a.adjustDate("subtract",7);break;case 39:a.adjustDate("add",1);break;case 40:a.adjustDate("add",7)}},a._onInputChange=function(e){var t;e.firedBy!==a&&(t=i.parse?i.parse(i.field.value,i.format):s?(t=n(i.field.value,i.format,i.formatStrict))&&t.isValid()?t.toDate():null:new Date(Date.parse(i.field.value)),F(t)&&a.setDate(t),a._v||a.show())},a._onInputFocus=function(){a.show()},a._onInputClick=function(){a.show()},a._onInputBlur=function(){var e=c.activeElement;do{if(l(e,"pika-single"))return}while(e=e.parentNode);a._c||(a._b=h(function(){a.hide()},50)),a._c=!1},a._onClick=function(e){var t=(e=e||window.event).target||e.srcElement,n=t;if(t){!o&&l(t,"pika-select")&&(t.onchange||(t.setAttribute("onchange","return;"),r(t,"change",a._onChange)));do{if(l(n,"pika-single")||n===i.trigger)return}while(n=n.parentNode);a._v&&t!==i.trigger&&n!==i.trigger&&a.hide()}},a.el=c.createElement("div"),a.el.className="pika-single"+(i.isRTL?" is-rtl":"")+(i.theme?" "+i.theme:""),r(a.el,"mousedown",a._onMouseDown,!0),r(a.el,"touchend",a._onMouseDown,!0),r(a.el,"change",a._onChange),i.keyboardInput&&r(c,"keydown",a._onKeyChange),i.field&&(i.container?i.container.appendChild(a.el):i.bound?c.body.appendChild(a.el):i.field.parentNode.insertBefore(a.el,i.field.nextSibling),r(i.field,"change",a._onInputChange),i.defaultDate||(s&&i.field.value?i.defaultDate=n(i.field.value,i.format).toDate():i.defaultDate=new Date(Date.parse(i.field.value)),i.setDefaultDate=!0));var t=i.defaultDate;F(t)?i.setDefaultDate?a.setDate(t,!0):a.gotoDate(t):a.gotoDate(new Date),i.bound?(this.hide(),a.el.className+=" is-bound",r(i.trigger,"click",a._onInputClick),r(i.trigger,"focus",a._onInputFocus),r(i.trigger,"blur",a._onInputBlur)):this.show()};return e.prototype={config:function(e){this._o||(this._o=d({},u,!0));var t=d(this._o,e,!0);t.isRTL=!!t.isRTL,t.field=t.field&&t.field.nodeName?t.field:null,t.theme="string"==typeof t.theme&&t.theme?t.theme:null,t.bound=!!(void 0!==t.bound?t.field&&t.bound:t.field),t.trigger=t.trigger&&t.trigger.nodeName?t.trigger:t.field,t.disableWeekends=!!t.disableWeekends,t.disableDayFn="function"==typeof t.disableDayFn?t.disableDayFn:null;var n=parseInt(t.numberOfMonths,10)||1;if(t.numberOfMonths=4<n?4:n,F(t.minDate)||(t.minDate=!1),F(t.maxDate)||(t.maxDate=!1),t.minDate&&t.maxDate&&t.maxDate<t.minDate&&(t.maxDate=t.minDate=!1),t.minDate&&this.setMinDate(t.minDate),t.maxDate&&this.setMaxDate(t.maxDate),y(t.yearRange)){var a=(new Date).getFullYear()-10;t.yearRange[0]=parseInt(t.yearRange[0],10)||a,t.yearRange[1]=parseInt(t.yearRange[1],10)||a}else t.yearRange=Math.abs(parseInt(t.yearRange,10))||u.yearRange,100<t.yearRange&&(t.yearRange=100);return t},toString:function(e){return e=e||this._o.format,F(this._d)?this._o.toString?this._o.toString(this._d,e):s?n(this._d).format(e):this._d.toDateString():""},getMoment:function(){return s?n(this._d):null},setMoment:function(e,t){s&&n.isMoment(e)&&this.setDate(e.toDate(),t)},getDate:function(){return F(this._d)?new Date(this._d.getTime()):null},setDate:function(e,t){if(!e)return this._d=null,this._o.field&&(this._o.field.value="",i(this._o.field,"change",{firedBy:this})),this.draw();if("string"==typeof e&&(e=new Date(Date.parse(e))),F(e)){var n=this._o.minDate,a=this._o.maxDate;F(n)&&e<n?e=n:F(a)&&a<e&&(e=a),this._d=new Date(e.getTime()),P(this._d),this.gotoDate(this._d),this._o.field&&(this._o.field.value=this.toString(),i(this._o.field,"change",{firedBy:this})),t||"function"!=typeof this._o.onSelect||this._o.onSelect.call(this,this.getDate())}},gotoDate:function(e){var t=!0;if(F(e)){if(this.calendars){var n=new Date(this.calendars[0].year,this.calendars[0].month,1),a=new Date(this.calendars[this.calendars.length-1].year,this.calendars[this.calendars.length-1].month,1),i=e.getTime();a.setMonth(a.getMonth()+1),a.setDate(a.getDate()-1),t=i<n.getTime()||a.getTime()<i}t&&(this.calendars=[{month:e.getMonth(),year:e.getFullYear()}],"right"===this._o.mainCalendar&&(this.calendars[0].month+=1-this._o.numberOfMonths)),this.adjustCalendars()}},adjustDate:function(e,t){var n,a=this.getDate()||new Date,i=24*parseInt(t)*60*60*1e3;"add"===e?n=new Date(a.valueOf()+i):"subtract"===e&&(n=new Date(a.valueOf()-i)),this.setDate(n)},adjustCalendars:function(){this.calendars[0]=a(this.calendars[0]);for(var e=1;e<this._o.numberOfMonths;e++)this.calendars[e]=a({month:this.calendars[0].month+e,year:this.calendars[0].year});this.draw()},gotoToday:function(){this.gotoDate(new Date)},gotoMonth:function(e){isNaN(e)||(this.calendars[0].month=parseInt(e,10),this.adjustCalendars())},nextMonth:function(){this.calendars[0].month++,this.adjustCalendars()},prevMonth:function(){this.calendars[0].month--,this.adjustCalendars()},gotoYear:function(e){isNaN(e)||(this.calendars[0].year=parseInt(e,10),this.adjustCalendars())},setMinDate:function(e){e instanceof Date?(P(e),this._o.minDate=e,this._o.minYear=e.getFullYear(),this._o.minMonth=e.getMonth()):(this._o.minDate=u.minDate,this._o.minYear=u.minYear,this._o.minMonth=u.minMonth,this._o.startRange=u.startRange),this.draw()},setMaxDate:function(e){e instanceof Date?(P(e),this._o.maxDate=e,this._o.maxYear=e.getFullYear(),this._o.maxMonth=e.getMonth()):(this._o.maxDate=u.maxDate,this._o.maxYear=u.maxYear,this._o.maxMonth=u.maxMonth,this._o.endRange=u.endRange),this.draw()},setStartRange:function(e){this._o.startRange=e},setEndRange:function(e){this._o.endRange=e},draw:function(e){if(this._v||e){var t,n=this._o,a=n.minYear,i=n.maxYear,s=n.minMonth,o=n.maxMonth,r="";this._y<=a&&(this._y=a,!isNaN(s)&&this._m<s&&(this._m=s)),this._y>=i&&(this._y=i,!isNaN(o)&&this._m>o&&(this._m=o)),t="pika-title-"+Math.random().toString(36).replace(/[^a-z]+/g,"").substr(0,2);for(var l=0;l<n.numberOfMonths;l++)r+='<div class="pika-lendar">'+p(this,l,this.calendars[l].year,this.calendars[l].month,this.calendars[0].year,t)+this.render(this.calendars[l].year,this.calendars[l].month,t)+"</div>";this.el.innerHTML=r,n.bound&&"hidden"!==n.field.type&&h(function(){n.trigger.focus()},1),"function"==typeof this._o.onDraw&&this._o.onDraw(this),n.bound&&n.field.setAttribute("aria-label",n.ariaLabel)}},adjustPosition:function(){var e,t,n,a,i,s,o,r,l,h,d,u;if(!this._o.container){if(this.el.style.position="absolute",t=e=this._o.trigger,n=this.el.offsetWidth,a=this.el.offsetHeight,i=window.innerWidth||c.documentElement.clientWidth,s=window.innerHeight||c.documentElement.clientHeight,o=window.pageYOffset||c.body.scrollTop||c.documentElement.scrollTop,u=d=!0,"function"==typeof e.getBoundingClientRect)r=(h=e.getBoundingClientRect()).left+window.pageXOffset,l=h.bottom+window.pageYOffset;else for(r=t.offsetLeft,l=t.offsetTop+t.offsetHeight;t=t.offsetParent;)r+=t.offsetLeft,l+=t.offsetTop;(this._o.reposition&&i<r+n||-1<this._o.position.indexOf("right")&&0<r-n+e.offsetWidth)&&(r=r-n+e.offsetWidth,d=!1),(this._o.reposition&&s+o<l+a||-1<this._o.position.indexOf("top")&&0<l-a-e.offsetHeight)&&(l=l-a-e.offsetHeight,u=!1),this.el.style.left=r+"px",this.el.style.top=l+"px",f(this.el,d?"left-aligned":"right-aligned"),f(this.el,u?"bottom-aligned":"top-aligned"),g(this.el,d?"right-aligned":"left-aligned"),g(this.el,u?"top-aligned":"bottom-aligned")}},render:function(e,t,n){var a=this._o,i=new Date,s=L(e,t),o=new Date(e,t,1).getDay(),r=[],l=[];P(i),0<a.firstDay&&(o-=a.firstDay)<0&&(o+=7);for(var h=0===t?11:t-1,d=11===t?0:t+1,u=0===t?e-1:e,c=11===t?e+1:e,f=L(u,h),g=s+o,m=g;7<m;)m-=7;g+=7-m;for(var p,y,D,v,b,_,w,M=!1,k=0,x=0;k<g;k++){var R=new Date(e,t,k-o+1),N=!!F(this._d)&&B(R,this._d),S=B(R,i),C=-1!==a.events.indexOf(R.toDateString()),I=k<o||s+o<=k,T=k-o+1,E=t,Y=e,O=a.startRange&&B(a.startRange,R),j=a.endRange&&B(a.endRange,R),W=a.startRange&&a.endRange&&a.startRange<R&&R<a.endRange;I&&(k<o?(T=f+T,E=h,Y=u):(T-=s,E=d,Y=c));var A={day:T,month:E,year:Y,hasEvent:C,isSelected:N,isToday:S,isDisabled:a.minDate&&R<a.minDate||a.maxDate&&R>a.maxDate||a.disableWeekends&&(void 0,0===(w=R.getDay())||6===w)||a.disableDayFn&&a.disableDayFn(R),isEmpty:I,isStartRange:O,isEndRange:j,isInRange:W,showDaysInNextAndPreviousMonths:a.showDaysInNextAndPreviousMonths,enableSelectionDaysInNextAndPreviousMonths:a.enableSelectionDaysInNextAndPreviousMonths};a.pickWholeWeek&&N&&(M=!0),l.push(H(A)),7==++x&&(a.showWeekNumber&&l.unshift((D=k-o,v=t,b=e,_=void 0,_=new Date(b,0,1),'<td class="pika-week">'+Math.ceil(((new Date(b,v,D)-_)/864e5+_.getDay()+1)/7)+"</td>")),r.push((p=l,y=a.isRTL,'<tr class="pika-row'+(a.pickWholeWeek?" pick-whole-week":"")+(M?" is-selected":"")+'">'+(y?p.reverse():p).join("")+"</tr>")),x=0,M=!(l=[]))}return V(a,r,n)},isVisible:function(){return this._v},show:function(){this.isVisible()||(this._v=!0,this.draw(),g(this.el,"is-hidden"),this._o.bound&&(r(c,"click",this._onClick),this.adjustPosition()),"function"==typeof this._o.onOpen&&this._o.onOpen.call(this))},hide:function(){var e=this._v;!1!==e&&(this._o.bound&&t(c,"click",this._onClick),this.el.style.position="static",this.el.style.left="auto",this.el.style.top="auto",f(this.el,"is-hidden"),this._v=!1,void 0!==e&&"function"==typeof this._o.onClose&&this._o.onClose.call(this))},destroy:function(){var e=this._o;this.hide(),t(this.el,"mousedown",this._onMouseDown,!0),t(this.el,"touchend",this._onMouseDown,!0),t(this.el,"change",this._onChange),e.keyboardInput&&t(c,"keydown",this._onKeyChange),e.field&&(t(e.field,"change",this._onInputChange),e.bound&&(t(e.trigger,"click",this._onInputClick),t(e.trigger,"focus",this._onInputFocus),t(e.trigger,"blur",this._onInputBlur))),this.el.parentNode&&this.el.parentNode.removeChild(this.el)}},e});
