<h1>Теги</h1>

<ul>
<?php foreach ( $tags as $tag ): ?>
<li><a href="/tag/<?php print $tag -> tag_id; ?>"><?php print $tag -> name; ?></a> (<?php print count ( $tag -> sites ); ?>)</li>
<?php endforeach; ?>
</ul>