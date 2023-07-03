<?php
$this->layout("layout");
/** @var \Alura\Mvc\Entity\Video[] $videoList */
?>

<ul class="videos__container">
    <?php foreach ($videoList as $video): ?>
        <li class="videos__item">
            <?php if($video->getFilePath() !== null): ?>
            <a href="/img/uploads/<?= $video->url; ?>">
                <img src="<?= $video->getFilePath();?>" alt="" style="width: 100%"/>
            </a>
            <?php else: ?>
            <iframe width="100%" height="72%" src="<?= htmlentities($video->url); ?>"
                    title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
            <?php endif; ?>
            <div class="descricao-video">
                <h3><?= htmlentities($video->title); ?></h3>
                <div class="acoes-video">
                    <a href="/editar-video?id=<?= $video->id; ?>">Editar</a>
                    <a href="/remover-video?id=<?= $video->id; ?>">Excluir</a>
                </div>
            </div>
        </li>
    <?php endforeach; ?>
</ul>