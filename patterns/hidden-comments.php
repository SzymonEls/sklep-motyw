<?php
/**
 * Title: Comments
 * Slug: witryna/hidden-comments
 * Inserter: no
 *
 * @package Witryna
 */

?>
<!-- wp:comments {"className":"witryna-comments"} -->
<div class="wp-block-comments witryna-comments"><!-- wp:comments-title {"level":2,"fontSize":"x-large"} /-->

<!-- wp:comment-template -->
<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"},"blockGap":"var:preset|spacing|20"}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30)"><!-- wp:group {"style":{"spacing":{"blockGap":"0.75rem"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:avatar {"size":40} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"0"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:comment-author-name {"fontSize":"small"} /-->

<!-- wp:comment-date {"fontSize":"x-small"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:comment-content /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"fontSize":"x-small","layout":{"type":"flex"}} -->
<div class="wp-block-group has-x-small-font-size"><!-- wp:comment-reply-link /-->

<!-- wp:comment-edit-link /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:comment-template -->

<!-- wp:comments-pagination {"layout":{"type":"flex","justifyContent":"space-between"}} -->
<!-- wp:comments-pagination-previous /-->

<!-- wp:comments-pagination-numbers /-->

<!-- wp:comments-pagination-next /-->
<!-- /wp:comments-pagination -->

<!-- wp:post-comments-form /--></div>
<!-- /wp:comments -->
