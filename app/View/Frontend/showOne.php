<?php

/** @var $post \App\Entity\Post */ ?>

<h1 class="text-gray-600"><?= $post->getTitle(); ?></h1>
<p><small>Publié le : <?= $post->getCreatedAt()->format('Y/m/d à H:m'); ?></small></p>
<p class="mb-10"><?= nl2br($post->getContent()); ?></p>

<form method="POST" action="">
  <div>
    <label for="commentary" class="block text-sm font-medium text-gray-700"> Your commentary </label>
    <div class="mt-2">
      <textarea id="commentary" name="commentary" rows="3" class="shadow-sm focus:ring-indigo-300 focus:border-indigo-300 p-2 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="Your commentary"></textarea>
    </div>
  </div>
  <button class="w-full" type="submit">Post Comment</button>
</form>