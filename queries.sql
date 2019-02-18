-- добавляет существующий список проектов
INSERT INTO projects
  SET user_id = 1,
      title = 'Входящие';
INSERT INTO projects
  SET user_id = 2,
      title = 'Учеба';
INSERT INTO projects
  SET user_id = 1,
      title = 'Работа';
INSERT INTO projects
  SET user_id = 2,
      title = 'Домашние дела';
INSERT INTO projects
  SET user_id = 2,
      title = 'Авто';

-- добавляет пару придуманных пользователей

INSERT INTO users
  SET email = 'Вася@Почта.рф',
      name = 'Вася',
      password = '123';
INSERT INTO users
  SET email = 'Петя@Почта.рф',
      name = 'Петя',
      password = '123';

-- добавляет существующий список задач

INSERT INTO tasks
  SET user_id = 1,
      project_id = 3,
      state = 0,
      title = 'Собеседование в IT компании',
      critical_time = STR_TO_DATE('01.12.2019', '%d.%m.%Y');
INSERT INTO tasks
  SET user_id = 1,
      project_id = 3,
      state = 0,
      title = 'Выполнить тестовое задание',
      critical_time = STR_TO_DATE('25.12.2019', '%d.%m.%Y');
INSERT INTO tasks
  SET user_id = 1,
      project_id = 2,
      state = 1,
      title = 'Сделать задание первого раздела',
      critical_time = STR_TO_DATE('21.12.2019', '%d.%m.%Y');
INSERT INTO tasks
  SET user_id = 1,
      project_id = 1,
      state = 0,
      title = 'Встреча с другом',
      critical_time = STR_TO_DATE('22.12.2019', '%d.%m.%Y');
INSERT INTO tasks
  SET user_id = 1,
      project_id = 4,
      state = 0,
      title = 'Купить корм для кота';
INSERT INTO tasks
  SET user_id = 1,
      project_id = 4,
      state = 0,
      title = 'Заказать пиццу';

-- получить список из всех проектов для одного пользователя
SELECT * FROM projects WHERE user_id = 1;
-- получить список из всех задач для одного проекта
SELECT * FROM tasks WHERE project_id = 3;
-- пометить задачу как выполненную
UPDATE tasks SET state = 1 WHERE id = 1;
-- обновить название задачи по её идентификатору
UPDATE tasks SET title = 'new title' WHERE id = 1;
