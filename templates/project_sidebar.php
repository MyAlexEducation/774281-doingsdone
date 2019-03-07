<h2 class="content__side-heading">Проекты</h2>

<nav class="main-navigation">
    <ul class="main-navigation__list">
        <?php $category = isset($_GET['category'])? intval($_GET['category']) : 0 ?>
        <?php foreach ($categories as $key => $item): ?>
            <li class="main-navigation__list-item
                <?php if ($category === $item['id']): ?> main-navigation__list-item--active <?php endif; ?>">
                <a class="main-navigation__list-item-link" href="/?category=<?= intval($item['id']); ?> ">
                    <?= esc($item['title']); ?>
                </a>
                <span class="main-navigation__list-item-count">
                                    <?= $item['cnt'] ?>
                                </span>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>

<a class="button button--transparent button--plus content__side-button"
   href="project.php" target="project.php">Добавить проект</a>
