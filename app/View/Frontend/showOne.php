<?php

/** @var $post \App\Entity\Post */ ?>

<h1 class="text-gray-600"><?= $post->getTitle(); ?></h1>
<p><small>Publié le : <?= $post->getCreatedAt()->format('Y/m/d à H:m'); ?></small></p>
<p class="mb-10"><?= nl2br($post->getContent()); ?></p>

<form method="POST" action="/post/<?= $post->getId() ?>/comment" class="mb-5">
  <div>
    <label for="content" class="block text-sm font-medium text-gray-700"> Your content </label>
    <div class="mt-2">
      <textarea id="content" name="content" rows="3" class="shadow-sm focus:ring-indigo-300 focus:border-indigo-300 p-2 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="Your commentary"></textarea>
    </div>
  </div>
  <button class="w-full" type="submit">Post Comment</button>
</form>

<?php foreach ($commentaries as $commentary) : ?>
  <p class="mb-10"><?= $commentary["lastname"]; ?></p>
  <div> <?= $commentary["content"] ?> </div>
<?php endforeach; ?>