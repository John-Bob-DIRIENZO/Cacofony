<?php

/** @var $post \App\Entity\Post */ ?>

<h1 class="text-center text-3xl font-bold text-gray-800"><?= $post->getTitle(); ?></h1>
<p><small>Publié le : <?= $post->getCreatedAt()->format('Y/m/d à H:m'); ?></small></p>
<p class="mb-10"><?= nl2br($post->getContent()); ?></p>

<form method="POST" action="/post/<?= $post->getId() ?>/comment">
  <div>
    <label for="content" class="block text-sm font-medium text-gray-700"> Your commentary </label>
    <div class="mt-2">
      <textarea id="content" name="content" rows="3" class="shadow-sm focus:ring-indigo-300 focus:border-indigo-300 p-2 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="Write your commentary..."></textarea>
    </div>
  </div>
  <button class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-3" type="submit">Post Comment</button>
</form>

<div class="flex flex-col mt-10">
  <h3 class="m-auto mb-5 text-3xl font-bold">Commentaries</h3>
  <div class="container">
    <?php foreach ($commentaries as $commentary) : ?>
      <div class="my-5 px-5">
        <p class="text-lg font-semibold"><?= $commentary["lastname"]; ?></p>
        <p><?= $commentary["content"] ?></p>
      </div>
      <div class="w-full h-0.5 border border-gray-200"></div>
    <?php endforeach; ?>
  </div>
</div>