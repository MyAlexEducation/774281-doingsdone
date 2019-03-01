<h2 class="content__side-heading">Проекты</h2>

<nav class="main-navigation">
    <ul class="main-navigation__list">
        <?php foreach ($categories as $key => $item): ?>
            <li class="main-navigation__list-item
                <?php if (intval($_SESSION['filters']['filter_categories']) === array_search($item, $categories)): ?> main-navigation__list-item--active <?php endif; ?>">
                <a class="main-navigation__list-item-link" href="/?filter=<?= array_search($item, $categories); ?> ">
                    <?= esc($item); ?>
                </a>
                <span class="main-navigation__list-item-count">
                                    <?php echo(count_category($tasks, $item)) ?>
                                </span>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>

<a class="button button--transparent button--plus content__side-button"
   href="project.php" target="project.php">Добавить проект</a>
