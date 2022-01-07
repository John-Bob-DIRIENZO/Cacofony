<?php /** @var $post \App\Entity\Post */ ?>

<h1><?= $post->getTitle(); ?></h1>
<p><small>Publié le : <?= $post->getCreatedAt()->format('Y/m/d à H:m'); ?></small></p>
<p><?= nl2br($post->getContent()); ?></p>
