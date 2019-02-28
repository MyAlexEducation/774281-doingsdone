<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="index.php" method="post">
    <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

    <input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
    <nav class="tasks-switch">
        <a href="/?filter_task=all" class="tasks-switch__item <?php if ($_SESSION['filters']['filter_task'] === 'all'): ?> tasks-switch__item--active <?php endif; ?>">Все задачи</a>
        <a href="/?filter_task=today" class="tasks-switch__item <?php if ($_SESSION['filters']['filter_task'] === 'today'): ?> tasks-switch__item--active <?php endif; ?>">Повестка дня</a>
        <a href="/?filter_task=tomorrow" class="tasks-switch__item <?php if ($_SESSION['filters']['filter_task'] === 'tomorrow'): ?> tasks-switch__item--active <?php endif; ?>">Завтра</a>
        <a href="/?filter_task=overdue" class="tasks-switch__item <?php if ($_SESSION['filters']['filter_task'] === 'overdue'): ?> tasks-switch__item--active <?php endif; ?>">Просроченные</a>
    </nav>

    <label class="checkbox">
        <!--добавить сюда аттрибут "checked", если переменная $show_complete_tasks равна единице-->
        <input class="checkbox__input visually-hidden show_completed" type="checkbox"
            <?php if ($_SESSION['filters']['show_completed']): ?> checked <?php endif; ?>>
        <span class="checkbox__text">Показывать выполненные</span>
    </label>
</div>

<table class="tasks">
    <?php foreach ($tasks as $key => $item): ?>
        <?php if ((!$item["isDone"] || $_SESSION['filters']['show_completed'])
                   && ($_SESSION['filters']['filter_categories'] === 0 || $_SESSION['filters']['filter_categories'] === array_search($item['category'], $categories))
                   && (is_date_interval($intervals[$_SESSION['filters']['filter_task']], $item["data"]))): ?>
            <tr class="tasks__item task
                <?php if ($item["isDone"]): ?> task--completed <?php endif; ?>
                <?php if (is_task_time($item["data"])): ?> task--important <?php endif; ?>
                ">
                <td class="task__select">
                    <label class="checkbox task__checkbox">
                        <input class="checkbox__input visually-hidden task__checkbox" type="checkbox"
                               value="<?= $item['id'] ?>" <?php if ($item["isDone"]): ?> checked <?php endif; ?>>
                        <span class="checkbox__text"><?= esc($item["name"]); ?></span>
                    </label>
                </td>

                <td class="task__file">
                    <?php if ($item['file'] != NULL): ?>
                        <a class="download-link" href="<?= $item['file']; ?>"><?= $item['file']; ?></a>
                    <?php endif; ?>
                </td>

                <td class="task__date"><?= esc($item["data"]); ?></td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
</table>
