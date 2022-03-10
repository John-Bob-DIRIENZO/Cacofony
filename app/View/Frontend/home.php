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

<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-3"><a href="/post/create">Créer un article</a></button>

<div>
    <h1 class="flex justify-center font-bold text-3xl my-10">Vous trouverez tout vos articles de culs préférés ici</h1>

    <ul class="container p-6 mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-8">
        <?php /** @var $posts Post[] */
        foreach ($posts as $post) : ?>
            <li class="p-2">
                <a href=" /show/<?= $post->getId(); ?>-article">
                    <div class="relative">
                        <img src="<?= $post->getImage(); ?>" alt="Emoji Support" class="rounded-lg shadow-sm w-full h-52 object-cover">
                    </div>
                    <div class="my-2 pl-2 text-l font-semibold"><?= $post->getTitle(); ?></div>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

</div>