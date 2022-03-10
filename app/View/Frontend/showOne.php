<?php

/** @var $post \App\Entity\Post */ ?>
<h1 class=" text-center text-3xl font-bold text-gray-800 mb-10"><?= $post->getTitle(); ?></h1>
<p><small>Publié le : <?= $post->getCreatedAt()->format('Y/m/d à H:m'); ?></small></p>
<div class="flex space-x-10 mb-10">
  <div class="col-span-2">
    <p class="text-justify"><?= nl2br($post->getContent()); ?></p>
  </div>
  <div class="mt-14 col-span-2">
    <img class="w-full rounded" src="<?= $post->getImage(); ?>" alt="Emoji Support" class="rounded-lg shadow-sm w-full h-52 object-cover">
  </div>
</div>

<form method="POST" action="/post/<?= $post->getId() ?>/comment">
  <div>
    <label for="content" class="block text-sm font-medium text-gray-700"> Laissez-nous un commentaire : </label>
    <div class="mt-2">
      <textarea id="content" name="content" rows="3" class="shadow-sm focus:ring-indigo-300 focus:border-indigo-300 p-2 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="Comentaire..."></textarea>
    </div>
  </div>
  <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-3" type="submit">Envoyer votre commentaire</button>
</form>

<div class="flex flex-col mt-10">
  <h3 class="m-auto mb-5 text-3xl font-bold">Commentaries</h3>
  <div class="container">
    <?php foreach ($commentaries as $commentary) : ?>
      <div class="my-5 px-5 space-y-1">
        <p class="text-sm text-gray-400"><?= $commentary["createdAt"] ?></p>
        <p class="text-lg font-semibold text-indigo-600"><?= $commentary["lastname"]; ?></p>
        <p class="text-xl"><?= $commentary["content"] ?></p>
      </div>
      <div class=" w-full h-0.5 border border-gray-200">
      </div>
    <?php endforeach; ?>
  </div>
</div>