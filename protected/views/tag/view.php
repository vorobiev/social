<h1><?php print $tag -> name; ?></h1>

<?php if ( count ( $sites ) == 0 ): ?>
Тег не содержит ни один сайт.
<?php else: ?>
Содержит сайтов: <?php print count ( $sites ); ?>.
<?php endif; ?>
<br />
<ul>
<?php foreach ( $sites as $site ): ?>
<li><a href="/site/<?php print $site -> site_id; ?>"><?php print $site -> name ; ?></a></li>
<?php endforeach; ?>
</ul>