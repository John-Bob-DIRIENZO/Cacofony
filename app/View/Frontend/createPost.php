<?php

use App\Core\Helper\AuthHelper;
use App\Entity\Post;

?>

<?php if (AuthHelper::isLoggedIn()) : ?>
    <div class="bg-green-600  alert-success" role="alert">
        Bonjour <?= AuthHelper::getLoggedUser()->user; ?>, vous êtes connecté ! <a href="/logout">Logout</a>
    </div>
<?php else : ?>
    <div class="bg-red-600 alert-danger p-5 rounded-lg text-gray-100 font-semibold" role="alert">
        Vous n'êtes pas connecté !
    </div>
    <div class="text-blue-600 font-semibold p-2 underline">
        <a href="/login">Login</a>
    </div>
<?php endif; ?>

<h1 class="text-center text-3xl font-bold text-gray-800 mb-5">Création de l'article</h1>

<!-- <form method="POST" action="/post/post"></form><div class="mt-10 sm:mt-0"> -->
<div class="mt-5 md:mt-0 md:col-span-2">
  <form method="POST" action="/post/post">
      <div class="shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-5 bg-white sm:p-6">
          <div class="grid grid-cols-6 gap-6">

          <!-- TITLE -->
            <div class="col-span-6 sm:col-span-3">
              <label for="title" class="block text-sm font-medium text-gray-700">Titre de l'article</label>
              <input type="text" name="title" id="title" placeholder="Mon titre" class="px-2 h-10 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-600 rounded-md">
            </div>
          <!-- IMAGE -->
            <div class="col-span-6 sm:col-span-3">
              <label for="image" class="block text-sm font-medium text-gray-700">Lien de l'image</label>
              <input type="text" name="image" id="image" placeholder="Mon lien" class="px-2 h-10 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-600 rounded-md">
            </div>
          </div>

        <!-- TEXT CONTENT -->
        <div class="mt-10">
          <label for="content" class="block text-sm font-medium text-gray-700">Contenu de l'article</label>
          <textarea name="content" id="content" class="px-2 py-2 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-600 rounded-md" placeholder="Ecrivez votre article..." rows="20"></textarea>
        </div>

        </div>
      </div>
      <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
          <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Créer</button>
      </div>
    </div>
  </form>
</div>