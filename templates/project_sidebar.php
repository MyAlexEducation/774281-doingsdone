<h2 class="content__side-heading">Проекты</h2>

<nav class="main-navigation">
    <ul class="main-navigation__list">
        <?php foreach ($categories as $key => $item): ?>
            <li class="main-navigation__list-item">
                <a class="main-navigation__list-item-link" href="/?filter=<?= array_search($item, $categories); ?> ">
                    <?= esc($item); ?>
                </a>
                <span class="main-navigation__list-item-count">
                                    <?php echo(countCategory($tasks, $item)) ?>
                                </span>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>

<a class="button button--transparent button--plus content__side-button"
   href="pages/form-project.html" target="project_add">Добавить проект</a>
