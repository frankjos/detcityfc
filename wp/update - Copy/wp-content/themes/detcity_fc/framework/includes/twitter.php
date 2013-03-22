<?php
define("SECOND", 1);
define("MINUTE", 60 * SECOND);
define("HOUR", 60 * MINUTE);
define("DAY", 24 * HOUR);
define("MONTH", 30 * DAY);
function relativeTime($time) {
	$delta = strtotime('+2 hours') - $time;
	if ($delta < 2 * MINUTE) {
		return "1 min ago";
	}
	if ($delta < 45 * MINUTE) {
		return floor($delta / MINUTE) . " min ago";
	}
	if ($delta < 90 * MINUTE) {
		return "1 hour ago";
	}
	if ($delta < 24 * HOUR) {
		return floor($delta / HOUR) . " hours ago";
	}
	if ($delta < 48 * HOUR) {
		return "yesterday";
	}
	if ($delta < 30 * DAY) {
		return floor($delta / DAY) . " days ago";
	}
	if ($delta < 12 * MONTH) {
		$months = floor($delta / DAY / 30);
		return $months <= 1 ? "1 month ago" : $months . " months ago";
	} else {
		$years = floor($delta / DAY / 365);
		return $years <= 1 ? "1 year ago" : $years . " years ago";
	}
}

function parse_cache_feed($username,$limit) {

	global $twitter_options;
	include_once(ABSPATH . WPINC . '/class-simplepie.php');
	$messages = fetch_feed('http://twitter.com/statuses/user_timeline/'.$username.'.rss');
	$out='';
	if ($username == '') {
		$out='<p class="tweet">';
		$out.="Please enter your twitter Id in place of username";
		$out.="</p>";
	}else{
		$feed_count = $messages->get_item_quantity();
			if ( empty($feed_count) ) {
			$out='<p class="tweet">';
			$out.="No public Twitter messages";
			$out.="</p>";
		}else{
			$i = 0;
			foreach ( $messages->get_items() as $message ) {
			$out .='<p class="tweet">';
			$msg = " ".substr(strstr($message->get_description(),': '), 2, strlen($message->get_description()))." ";
			
			if(isset($encode_utf8)) $msg = utf8_encode($msg);
			$link = $message->get_link();
			$time = $message->get_date();
			$msg = hyperlinks($msg);
			$msg = twitter_users($msg);
			$out .= $msg;
			$out .= '<span><small>(' . relativeTime(strtotime($time)) . '&nbsp;)</small></span>';
					
			//$out .= '<a class="target_blank" href="' .$link. '" title="' .relativeTime(strtotime($time)). '">' .$msg. '</a>';
			$i++;
			if ( $i >= $limit ) break;	
			$out.='</p>';	
			}
		}
	}
	return $out;
}

function footersidebar_twitter($username,$limit,$encode_utf8 = false) {
	global $twitter_options;
	include_once(ABSPATH . WPINC . '/class-simplepie.php');
	$messages = fetch_feed('http://twitter.com/statuses/user_timeline/'.$username.'.rss');
	$out = '';
	if ($username == '') {
		$out .='<p class="tweet">';
		$out .="Please enter your twitter Id in place of username";
		$out .="</p>";
	}else{
			$feed_count = $messages->get_item_quantity();
			if ( empty($feed_count) ) {
			$out .='<p class="tweet">';
			$out .="No public Twitter messages";
			$out .="</p>";
		}else{
			$i = 0;
			foreach ( $messages->get_items() as $message ) {
			$out .='<p class="tweet">';
			$msg = " ".substr(strstr($message->get_description(),': '), 2, strlen($message->get_description()))." ";
			
			if($encode_utf8) $msg = utf8_encode($msg);
			$link = $message->get_link();
			$time = $message->get_date();
			$msg = hyperlinks($msg);
			$msg = twitter_users($msg);
			$out .= $msg;
			$out .= '<span><small>(' . relativeTime(strtotime($time)) . '&nbsp;)</small></span>';
					
			//$out .= '<a class="target_blank" href="' .$link. '" title="' .relativeTime(strtotime($time)). '">' .$msg. '</a>';
			$i++;
			if ( $i >= $limit ) break;	
			$out .='</p>';			
			}
		}
	}
	return $out;
}

function parse_cache_pagetwitter_widget($username,$limit) {
	global $twitter_options;
	include_once(ABSPATH . WPINC . '/class-simplepie.php');

	$messages = fetch_feed('http://twitter.com/statuses/user_timeline/'.$username.'.rss');
	$out='';
	$out .='<div class="syswidget sc">';
	if ($username == '') {
		$out .='<p>';
		$out .="Please enter your twitter Id in place of username";
		$out .="</p>";
	}else{
		$feed_count = $messages->get_item_quantity();
			if ( empty($feed_count) ) {
			$out .='<p>';
			$out .="No public Twitter messages";
			$out .="</p>";
		}else{
			$i = 0;
			foreach ( $messages->get_items() as $message ) {
				$out .='<p class="tweet">';
				$msg = " ".substr(strstr($message->get_description(),': '), 2, strlen($message->get_description()))." ";
			
				if(isset($encode_utf8)) $msg = utf8_encode($msg);
				$link = $message->get_link();
				$time = $message->get_date();
				$msg= hyperlinks($msg);
				$msg = twitter_users($msg);
				$out .= $msg;
				$out .='<span class="note"><small>(' . relativeTime(strtotime($time)) . '&nbsp;)</small></span>';
				//$out .= '<a class="target_blank" href="' .$link. '" title="' .relativeTime(strtotime($time)). '">' .$msg. '</a>';
				$i++;
				if ( $i >= $limit ) break;	
				$out .='</p>';	
			}
		}
	}
	$out.='</div>';
	return $out;
}

function hyperlinks($text) {
    // Props to Allen Shaw & webmancers.com
    // match protocol://address/path/file.extension?some=variable&another=asf%
    //$text = preg_replace("/\b([a-zA-Z]+:\/\/[a-z][a-z0-9\_\.\-]*[a-z]{2,6}[a-zA-Z0-9\/\*\-\?\&\%]*)\b/i","<a href=\"$1\" class=\"twitter-link\">$1</a>", $text);
    $text = preg_replace('/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"$1\" class=\"twitter-link\">$1</a>", $text);
    // match www.something.domain/path/file.extension?some=variable&another=asf%
    //$text = preg_replace("/\b(www\.[a-z][a-z0-9\_\.\-]*[a-z]{2,6}[a-zA-Z0-9\/\*\-\?\&\%]*)\b/i","<a href=\"http://$1\" class=\"twitter-link\">$1</a>", $text);
    $text = preg_replace('/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"http://$1\" class=\"twitter-link\">$1</a>", $text);    
    
    // match name@address
    $text = preg_replace("/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i","<a href=\"mailto://$1\" class=\"twitter-link\">$1</a>", $text);
        //mach #trendingtopics. Props to Michael Voigt
    $text = preg_replace('/([\.|\,|\:|\¡|\¿|\>|\{|\(]?)#{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/#search?q=$2\" class=\"twitter-link\">#$2</a>$3 ", $text);
    return $text;
}
function twitter_users($text) {
       $text = preg_replace('/([\.|\,|\:|\¡|\¿|\>|\{|\(]?)@{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/$2\" class=\"twitter-user\">@$2</a>$3 ", $text);
       return $text;
}     
?>