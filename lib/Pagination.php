<?

class Pagination extends DB {
	var $result;
	var $anchors;
	var $total;
	function __construct($qry, $starting, $recpage, $url)
	{
		$db = new DB();
		$anc = "";
		
		$rst = $db->query($qry);
		
		$numrows = $db->numRows($rst);
		$qry		 .=	" LIMIT $starting, $recpage";
		
		$this->result = $db->query($qry);
		$next		=	$starting+$recpage;
		$var		=	((intval($numrows/$recpage))-1)*$recpage;
		$page_showing	=	intval($starting/$recpage)+1;
		$total_page	=	ceil($numrows/$recpage);

		if($numrows % $recpage != 0){
			$last = ((intval($numrows/$recpage)))*$recpage;
		}else{
			$last = ((intval($numrows/$recpage))-1)*$recpage;
		}
		$previous = $starting-$recpage;
		if($previous < 0){
			$anc = "Primero | Anterior | ";
		}else{
			
			$anc .= "<a href='".$url."&search_text=&starting=0'>Primero</a> | ";
			$anc .= "<a href='".$url."&search_text=&starting=".$previous."'>Anterior</a> | ";
		}
		
		################If you dont want the numbers just comment this block###############	
		$norepeat = 4;//no of pages showing in the left and right side of the current page in the anchors 
		$j = 1;
		$anch = '';
		for($i=$page_showing; $i>1; $i--){
			$fpreviousPage = $i-1;
			$page = ceil($fpreviousPage*$recpage)-$recpage;
			
			$anch = "<a href='".$url."&search_text=&starting=".$page."'>".$fpreviousPage."</a> | ".$anch;
			
			if($j == $norepeat) break;
			$j++;
		}
		$anc .= $anch;
		$anc .= $page_showing ."| ";
		$j = 1;
		for($i=$page_showing; $i<$total_page; $i++){
			$fnextPage = $i+1;
			$page = ceil($fnextPage*$recpage)-$recpage;
			//$anc .= "<a href='javascript:pagination($page);'>$fnextPage | </a>";
			$anc .= "<a href='".$url."&search_text=&starting=".$page."'>$fnextPage</a> | ";
			if($j==$norepeat) break;
			$j++;
		}
		
		
		if($next >= $numrows){
			$anc .= "Siguiente | Final ";
		}else{
			
			$anc .= "<a href='".$url."&search_text=&starting=".$next."'>Siguiente</a> | ";
			$anc .= " <a href='".$url."&search_text=&starting=".$last."'> Final</a>";
		}
		$this->anchors = $anc;
		
		$this->total = "<svaluestrong>P&aacute;gina : $page_showing <i> de  </i> $total_page . Total de registros encontrados: $numrows</svaluestrong>";
	}
}
?>