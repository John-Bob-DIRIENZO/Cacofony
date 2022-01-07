<h1>Je suis la page d'accueil</h1>

<ul>
    <?php /** @var $posts \App\Entity\Post[] */
    foreach ($posts as $post) : ?>
        <li><?= $post->getTitle(); ?></li>
    <?php endforeach; ?>
</ul>


