# Symfony Docker

A Docker-based installer and runtime for the Symfony web framework, featuring **FrankenPHP** and **Caddy** for high performance.

![CI Status](https://github.com/koropEli/symfonyFramework/workflows/CI/badge.svg)

---

## 🛠 Getting Started

### Prerequisites

Ensure you have the following installed:

- **Docker**: [Download and Install](https://www.docker.com/)
- **Docker Compose**: Verify installation by running:
  ```bash
  docker-compose --version
  ```

---

## 📥 Installation

### Clone the Repository

```bash
git clone https://github.com/koropEli/symfonyFramework.git
cd symfonyFramework
```

### Build Docker Images

```bash
docker compose build --no-cache
```

### Start the Application

```bash
docker compose up --pull always -d --wait
```

### Access the Application

Open **[https://localhost](https://localhost)** in your browser and accept the auto-generated TLS certificate.

---

## ⚙️ Configuration

### Environment Variables

Review and adjust settings in the `.env` file as needed.

### Database Migrations

If your application uses a database, apply migrations after starting the containers:

```bash
docker-compose exec php bin/console doctrine:migrations:migrate
```

### Composer Dependencies

Install or update PHP dependencies:

```bash
docker-compose exec php composer install
```

### Frontend Assets

If using Webpack Encore or similar tools:

```bash
docker-compose exec php npm install
docker-compose exec php npm run dev
```

---

## 🛑 Stopping the Application

To stop the running containers:

```bash
docker compose stop
```

To remove containers and networks:

```bash
docker compose down --remove-orphans
```

---

## 🧪 Running Tests

### Behat

**Behat** is configured for behavior-driven development testing.

- **Configuration File**: `behat.yml`
- **Test Directory**: `features/`

To run Behat tests:

```bash
docker-compose exec php vendor/bin/behat
```

For more information on setting up Behat with Symfony, refer to this guide: [SymfonyCasts](https://symfonycasts.com/).

---

### PHPUnit

**PHPUnit** is set up for unit testing.

- **Configuration File**: `phpunit.xml.dist`
- **Test Directory**: `tests/`

To run PHPUnit tests:

```bash
docker-compose exec php vendor/bin/phpunit
```

---

### Postman Collection

A **Postman** collection is available for API testing.

- **Collection File**: `Symfony.postman_collection.json`

#### To Use the Collection:

1. **Import the Collection**:
   - Open Postman.
   - Click on "Import" and select the `Symfony.postman_collection.json` file located in the root directory of this repository.

2. **Configure Environment**:
   - Ensure that the environment variables in Postman match those in your `.env` file, especially the base URL.

3. **Run Requests**:
   - Select the desired request from the collection.
   - Click "Send" to execute.

For guidance on integrating Postman with Symfony, refer to: [Postman Quickstart](https://quickstarts.postman.com/).

---

## 🚀 Features

- ✅ **Production, development, and CI ready**
- ✅ **Minimal setup** – Just one service by default
- ✅ **High performance** – FrankenPHP worker mode enabled in production
- ✅ **Easy extra service installation** via Symfony Flex
- ✅ **Automatic HTTPS** in both development and production
- ✅ **Modern web standards**: HTTP/3, Early Hints, real-time messaging (built-in Mercure hub)
- ✅ **Built-in debugging** with XDebug integration
- ✅ **Readable and customizable configuration**

---

## 📖 Documentation

For more details, refer to the following:

- [Available options](docs/options.md)
- [Using Symfony Docker with an existing project](docs/existing-project.md)
- [Adding extra services](docs/extra-services.md)
- [Deploying in production](docs/deployment.md)
- [Debugging with Xdebug](docs/debugging.md)
- [Working with TLS certificates](docs/tls.md)
- [Using MySQL instead of PostgreSQL](docs/mysql.md)
- [Switching to Alpine Linux](docs/alpine.md)
- [Using a Makefile](docs/makefile.md)
- [Updating the template](docs/update.md)
- [Troubleshooting](docs/troubleshooting.md)

---

##  License

This project is licensed under the **MIT License**.

---

##  Credits

Created by **Kévin Dunglas**, co-maintained by **Maxime Helias**, and sponsored by [Les-Tilleuls.coop](https://les-tilleuls.coop).

---

**Enjoy!** 