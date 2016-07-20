
<?php


	$paginationComputer = ffContainer::getInstance()->getThemeFrameworkFactory()->getPaginationWPLoop();

	$pagination = $paginationComputer->computePagination();
	if( !empty( $pagination ) && $query->get('pagination show') ) {
        $beforePagination = '';
        $afterPagination = '';
        $paginationContent = '';
		echo '<div class="row">';
        echo '<div class="col-sm-12">';
        echo '<ul class="pagination">';

		foreach( $pagination as $oneItem ) {
			switch( $oneItem->type ) {
				case ffPaginationComputer::TYPE_PREV:
					$beforePagination .= '<li><a href="'.get_pagenum_link( $oneItem->page).'">&lsaquo;</a></li>';
					break;


				case ffPaginationComputer::TYPE_DOTS_START:
					$paginationContent .= '<li class="no-active"><a class="no-active">...</a></li>';
					break;

				case ffPaginationComputer::TYPE_LAST_NUMBER_BUTTON:
                    $afterPagination .= '<li><a href="'.get_pagenum_link( $oneItem->page).'">'.ff_wp_kses( $oneItem->page ).'</a></li>';
                    break;
				case ffPaginationComputer::TYPE_FIRST_NUMBER_BUTTON:
                    $beforePagination .= '<li><a href="'.get_pagenum_link( $oneItem->page).'">'.ff_wp_kses( $oneItem->page ).'</a></li>';
                    break;
				case ffPaginationComputer::TYPE_STD_BUTTON;
				$class = '';
				$href = 'href="'.get_pagenum_link( $oneItem->page).'"';
                //<li class="active"><a href="#">1</a></li>
                $class = '';
                if( $oneItem->selected == true ) {
                    $class = 'active';
                }
                $paginationContent .= '<li class="'.esc_attr( $class ).'">';
                    $paginationContent .= '<a '.  $href.'>';
                        $paginationContent .= $oneItem->page;
                    $paginationContent .= '</a>';
                $paginationContent .= '</li>';


				break;

				case ffPaginationComputer::TYPE_DOTS_END:
					$paginationContent .= '<li  class="no-active"><a class="no-active">...</a></li>';
					break;

				case ffPaginationComputer::TYPE_NEXT:
					$afterPagination .= '<li><a href="'.get_pagenum_link( $oneItem->page).'">&rsaquo;</a></li>';
					break;
			}
		}
        echo  $beforePagination;
        echo  $paginationContent;
        echo  $afterPagination;

		echo '</ul>';
        echo '</div>';
        echo '</div>';
	}
