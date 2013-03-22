<?php
	/**
	 * ATP Pagination
	 */
	
	function atp_pagination($pages = '', $range = 2){
		$showitems = ($range * 2)+1;  
		
		global $paged, $wp_query;
		if(empty($paged)) $paged = 1;
		if($pages == ''){
			$pages = $wp_query->max_num_pages;
			if(!$pages){
				$pages = 1;
			}
		}   

		if(1 != $pages){
			echo "<div class='pagination'>";
			$out='<span class="pages extend">';
			$out.="Page ".$paged."  of  ".$pages;
			$out.="</span>";
			echo $out;	
			if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
			if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";
			for ($i=1; $i <= $pages; $i++){
				if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
					echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
				}
			}
			if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
			if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
			echo "</div>\n";
		}
	}
?>