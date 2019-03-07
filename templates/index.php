<?php
$filter_task = isset($_GET['filter_task']) ? esc($_GET['filter_task']) : 'all';
$category = isset($_GET['category']) ? intval($_GET['category']) : 0;
?>

<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="index.php" method="get">
    <input class="search-form__input" type="text" name="search_task" value="" placeholder="Поиск по задачам">

    <input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
    <nav class="tasks-switch">
        <a href="/?filter_task=all&category=<?= $category; ?>"
           class="tasks-switch__item <?php if ($filter_task === 'all'): ?> tasks-switch__item--active <?php endif; ?>">Все
            задачи</a>
        <a href="/?filter_task=today&category=<?= $category; ?>"
           class="tasks-switch__item <?php if ($filter_task === 'today'): ?> tasks-switch__item--active <?php endif; ?>">Повестка
            дня</a>
        <a href="/?filter_task=tomorrow&category=<?= $category; ?>"
           class="tasks-switch__item <?php if ($filter_task === 'tomorrow'): ?> tasks-switch__item--active <?php endif; ?>">Завтра</a>
        <a href="/?filter_task=overdue&category=<?= $category; ?>"
           class="tasks-switch__item <?php if ($filter_task === 'overdue'): ?> tasks-switch__item--active <?php endif; ?>">Просроченные</a>
    </nav>

    <label class="checkbox">
        <input class="checkbox__input visually-hidden show_completed" type="checkbox"
            <?php if ($show_completed): ?> checked <?php endif; ?>>
        <span class="checkbox__text">Показывать выполненные</span>
    </label>
</div>

<table class="tasks">
    <?php if (isset($_GET['search_task']) && empty($tasks)): ?>
        <p>Ничего не найдено по вашему запросу</p>
    <?php else: ?>
        <?php foreach ($tasks as $key => $item): ?>
            <tr class="tasks__item task
                <?php if ($item['state'] === 1): ?> task--completed <?php endif; ?>
                <?php if (is_task_time($item['critical_time']) && $item['state'] === 0): ?> task--important <?php endif; ?>
                ">
                <td class="task__select">
                    <label class="checkbox task__checkbox">
                        <input class="checkbox__input visually-hidden task__checkbox" type="checkbox"
                               value="<?= $item['id'] . '&show_completed=' . intval($show_completed) ?>" <?php if ($item['state'] === 1): ?> checked <?php endif; ?>>
                        <span class="checkbox__text"><?= esc($item['title']); ?></span>
                    </label>
                </td>

                <td class="task__file">
                    <?php if (isset($item['file'])): ?>
                        <a class="download-link" href="<?= $item['file']; ?>"><?= $item['file']; ?></a>
                    <?php endif; ?>
                </td>

                <td class="task__date">
                    <?php if (isset($item['critical_time'])) {
                        echo date('d.m.Y', strtotime($item['critical_time']));
                    }
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>
