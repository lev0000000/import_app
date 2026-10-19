## Быстрый запуск

### Требования

- Docker и Docker Compose
- [Task (go-task)](https://taskfile.dev/docs/installation)
- Node.js и npm для Angular

### 1. Backend

Клонируйте репозиторий и перейдите в директорию проекта:

```bash
git clone <REPOSITORY_URL>
cd import_app
```

Создайте `.env` из `.env.example` и при необходимости настройте подключение к MySQL и RabbitMQ.

Установите PHP-зависимости, если они ещё не установлены:

```bash
docker compose run --rm --no-deps php composer install
```

Запустите развёртывание:

```bash
task install
```

Команда создаст директории для загрузок, соберёт и запустит Docker-контейнеры, настроит права на запись в `uploads` и выполнит миграции базы данных.

### 2. Frontend

Откройте второй терминал:

```bash
cd client
npm ci
npm start -- --host 0.0.0.0
```

### 3. Адреса

| Сервис | Адрес |
|---|---|
| Angular | http://localhost:4200 |
| Backend API | http://localhost:8080/api/products |
| Swagger UI | http://localhost:8081 |
| RabbitMQ Management | http://localhost:15671 |

### 4. Управление

| Команда | Описание |
|---|---|
| `task install` | Первоначальное развёртывание backend |
| `task up` | Запуск Docker-сервисов |
| `task down` | Остановка Docker-сервисов |
| `task restart` | Перезапуск контейнеров |
| `task migrate` | Миграции базы данных |
| `task test` | Unit-тесты PHPUnit |
| `task logs` | Логи сервисов |
| `task status` | Состояние контейнеров |

### Важно

- PHP и RabbitMQ consumer должны иметь права на запись в `server/uploads`.
- Для обработки XLSX должен работать контейнер `queue-consumer`.
- Для доступа с другого ПК замените `localhost` в адресах API на IP или домен сервера и настройте CORS.
- На Linux для настройки прав через Taskfile необходимы `sudo` и пакет `acl`.
