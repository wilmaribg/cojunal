<?php 

function pagination($item_count, $limit, $cur_page, $link)
{
  $page_count = ceil($item_count/$limit);
  $current_range = array(($cur_page-2 < 1 ? 1 : $cur_page-2), ($cur_page+2 > $page_count ? $page_count : $cur_page+2));

  $first_page = $cur_page > 3 
    ? '<a href="'.sprintf($link, '1').'">1</a>'.($cur_page < 5 ? ', ' : ' ... ')
    : null;

  $last_page = $cur_page < $page_count-2 
    ? ($cur_page > $page_count-4 ? ', ' : ' ... ').'<a href="'.sprintf($link, $page_count).'">'.$page_count.'</a>' 
    : null;

  $previous_page = $cur_page > 1 
    ? '<a href="'.sprintf($link, ($cur_page-1)).'">Anterior</a> | ' 
    : null;

  $next_page = $cur_page < $page_count 
    ? ' | <a href="'.sprintf($link, ($cur_page+1)).'">Siguiente</a>' 
    : null;

  for ($x=$current_range[0];$x <= $current_range[1]; ++$x) {
    $pages[] = '<a href="'.sprintf($link, $x).'">'.($x == $cur_page ? '<strong>'.$x.'</strong>' : $x).'</a>';
  }

  if ($page_count > 1) {
    return '<p class="pagination"><strong>Paginas:</strong> '.$previous_page
            .$first_page.implode(', ', $pages)
            .$last_page.$next_page.'</p>';
  }
}

?>