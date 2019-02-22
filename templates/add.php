<h2 class="content__main-heading">Добавление задачи</h2>

<form class="form" action="add.php" method="post" enctype="multipart/form-data">
    <div class="form__row">
        <?php
        $classname = isset($errors['name']) ? "form__input--error" : "";
        $value = isset($task['name']) ? $task['name'] : "";
        ?>
        <?php if (isset($errors['name'])): ?>
            <p class="form__message"><?= $errors['name']; ?></p>
        <?php endif; ?>
        <label class="form__label" for="name">Название <sup>*</sup></label>

        <input class="form__input <?= $classname; ?>" type="text" name="name" id="name" value="<?= $value; ?>" placeholder="Введите название">
    </div>

    <div class="form__row">
        <?php
        $classname = isset($errors['project']) ? "form__input--error" : "";
        $value = isset($task['project']) ? $task['project'] : "";
        ?>
        <?php if (isset($errors['project'])): ?>
            <p class="form__message"><?= $errors['project']; ?></p>
        <?php endif; ?>
        <label class="form__label" for="project">Проект</label>

        <select class="form__input form__input--select <?= $classname; ?>" name="project" id="project">
            <?php foreach ($categories as $key => $item): ?>
                <option value="<?= $item; ?>"
                        <?php if ($value === $item): ?>
                        selected
                        <?php endif; ?>
                >
                    <?php echo $item; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form__row">
        <?php
        $classname = isset($errors['date']) ? "form__input--error" : "";
        $value = ($task['date'] !== '' && isset($task['date'])) ? date('Y-m-d', strtotime($task['date'])) : "";
        ?>
        <?php if (isset($errors['date'])): ?>
            <p class="form__message"><?= $errors['date']; ?></p>
        <?php endif; ?>
        <label class="form__label" for="date">Дата выполнения</label>

        <input class="form__input form__input--date <?= $classname; ?>" type="date" name="date" id="date" value="<?= $value; ?>"
               placeholder="Введите дату в формате ДД.ММ.ГГГГ">
    </div>

    <div class="form__row">
        <label class="form__label" for="preview">Файл</label>

        <div class="form__input-file">
            <input class="visually-hidden" type="file" name="preview" id="preview" value="">

            <label class="button button--transparent" for="preview">
                <span>Выберите файл</span>
            </label>
        </div>
    </div>

    <div class="form__row form__row--controls">
        <input class="button" type="submit" name="" value="Добавить">
    </div>
</form>
