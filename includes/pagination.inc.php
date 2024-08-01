<?php 

function paginate($item_per_page, $current_page, $total_records, $total_pages, $page_url) {
?>

<nav class="navigation pagination text-center">
<?php
    $pagination = '';
    if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages){ //verify total pages and current page number
        $pagination .= '<div class="nav-links">';
        
        $right_links    = $current_page + 3; 
        $previous       = $current_page - 3; //previous link 
        $next           = $current_page + 1; //next link
        $first_link     = true; //boolean var to decide our first link
        
        if($current_page > 1){
			$previous_link = $current_page-1;;
            
            $pagination .= '<a class="page-numbers" href="'.$page_url.'?page=1" title="First"> <<</a>'; //first link
			
            
            $pagination .= '<a class="page-numbers" href="'.$page_url.'?page='.$previous_link.'"  title="Previous"> < </a>'; //previous link
                for($i = ($current_page-2); $i < $current_page; $i++){ //Create left-hand side links
                    if($i > 0){
                 
                        $pagination .= '<a class="page-numbers" href="'.$page_url.'?page='.$i.'">'.$i.'</a>';
                    }
                }   
            $first_link = false; //set first link to false
        }
        
        if($first_link){ //if current active page is first link
            $pagination .= '<span class="page-numbers current">'.$current_page.'</span>';
        }elseif($current_page == $total_pages){ //if it's the last active link
			$pagination .= '<span class="page-numbers current">'.$current_page.'</span>';
        }else{ //regular current link
            $pagination .= '<span class="page-numbers current">'.$current_page.'</span>';
        }
                
        for($i = $current_page+1; $i < $right_links ; $i++){ //create right-hand side links
            if($i<=$total_pages){
				
                $pagination .= '<a class="page-numbers" href="'.$page_url.'?page='.$i.'">'.$i.'</a>';
				
            }
        }
        if($current_page < $total_pages){ 
				$next_link = $current_page+1;
                
				
				$pagination .= '<a class="page-numbers" href="'.$page_url.'?page='.$next_link.'"> > </a>'; //Next Link
				$pagination .= '<a class="page-numbers" href="'.$page_url.'?page='.$total_pages.'" title="Last"> >> </a>'; //Lastlink
			
            
            	
        }
        
        $pagination .= '</div>'; 
    }
?>
   </nav>
   
<?php
    return $pagination; //return pagination links
}

?>