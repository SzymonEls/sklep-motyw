<?php
/**
 * Title: Posts grid
 * Slug: witryna/hidden-posts-grid
 * Inserter: no
 *
 * @package Witryna
 */

?>
<!-- wp:query {"queryId":1,"query":{"perPage":9,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true},"align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-query alignwide"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"grid","columnCount":3,"minimumColumnWidth":"18rem"}} -->
<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3","className":"is-style-zoom"} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20","margin":{"top":"var:preset|spacing|30"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="margin-top:var(--wp--preset--spacing--30)"><!-- wp:group {"style":{"spacing":{"blockGap":"0.75rem"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group"><!-- wp:post-terms {"term":"category","className":"is-style-pills","fontSize":"x-small"} /-->

<!-- wp:post-date {"fontSize":"x-small"} /--></div>
<!-- /wp:group -->

<!-- wp:post-title {"level":2,"isLink":true,"fontSize":"x-large"} /-->

<!-- wp:post-excerpt {"excerptLength":24,"textColor":"muted","fontSize":"small"} /--></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-pagination {"paginationArrow":"arrow","layout":{"type":"flex","justifyContent":"space-between"}} -->
<!-- wp:query-pagination-previous /-->

<!-- wp:query-pagination-numbers /-->

<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination -->

<!-- wp:query-no-results -->
<!-- wp:pattern {"slug":"witryna/hidden-no-results"} /-->
<!-- /wp:query-no-results --></div>
<!-- /wp:query -->
