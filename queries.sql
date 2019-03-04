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
  SET email = 'vasya@milo.tg',
      name = 'Вася',
      password = '$2y$10$xxEJxfsLJj4nZDFkeUMw4OFzx4J8f5QVRleIV9lPl8.cPKNRWij/G';
INSERT INTO users
  SET email = 'myAlexEducation@gmail.com',
      name = 'Петя',
      password = '$2y$10$NRiLw/xDmMoIOT.lXXewqOxeAe7n9MTFhVUVLhdAu/sGo0FLQ90C2';

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
  SET user_id = 2,
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
  SET user_id = 2,
      project_id = 4,
      state = 0,
      title = 'Купить корм для кота',
      critical_time = STR_TO_DATE('04.03.2019 13:39', '%d.%m.%Y %H:%i');
INSERT INTO tasks
  SET user_id = 2,
      project_id = 4,
      state = 0,
      title = 'Заказать пиццу';

-- получить список из всех проектов для одного пользователя
SELECT * FROM projects WHERE user_id = 1;
-- получить список из всех задач для одного проекта
SELECT * FROM tasks WHERE user_id = 1;
-- пометить задачу как выполненную
UPDATE tasks SET state = 1 WHERE id = 1;
-- обновить название задачи по её идентификатору
UPDATE tasks SET title = 'new title' WHERE id = 1;
