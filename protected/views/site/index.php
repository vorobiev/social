<h1>Сайты</h1>

<ul>
<?php foreach ( $sites as $site ): ?>

<li><a href="/site/<?php print $site -> site_id ; ?>"><?php print $site -> name; ?></a></li>

<?php endforeach; ?>
</ul>



<h1>Теги</h1>

<ul>
<?php foreach ( $tags as $tag ): ?>

<li><a href="/tag/<?php print $tag -> tag_id ; ?>"><?php print $tag -> name; ?></a></li>

<?php endforeach; ?>
</ul>