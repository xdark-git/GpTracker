# ViewPoint

## Technologies

In order to run the application on your computer, you must first install the following dependencies:

- [PHP](https://www.php.net/book.ctype): Version 8.1.x
- [Composer](https://getcomposer.org/download/): Version 2.x
- [Node.js](https://nodejs.org/en/): Version 16.x
- [Symfony CLI](https://symfony.com/download): Version 5.4.x
- [Yarn](https://yarnpkg.com/): Version >=1.22.18

## Installation

The installation follows the steps described below

1. Clone the project
2. Database configuration
3. Install the dependencies
4. Create the Fixtures
5. Start the servers
6. Login

### 1. Clone Project

Open a terminal and run this commands

```bash
  git clone https://github.com/xdark-git/GpTracker.git
  cd GpTracker
```

### 2. Database configuration

1.  To configurate the database connection, we will modified the environment variable called DATABASE_URL (after cloned project).

For this, create and customize your .env.local and add the DATABASE_URL entry:

```symfony
# .env.local
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=8&charset=utf8mb4"
```

### 3. Install dependencies

Install the certificate required by the server for HTTPS

```bash
    symfony server:ca:install
```

Install the dependencies

```bash
    composer install
    yarn install

```

### 4. Fixtures

You need to create the database and the tables

```bash
    php bin/console doctrine:database:drop --force --if-exists
    php bin/console doctrine:database:create --if-not-exists
    php bin/console doctrine:schema:update --force --complete
```

Then create the Fixtures.

```bash
    php bin/console doctrine:fixtures:load --append --group=dev
```

### 5. Run Servers

We can start the two servers

```bash
  symfony serve
  yarn encore dev-server
```

### 6. Login - get access

# DEV STANDARD

## Development

- Create your own branch by copying the JIRA generated code. e.g: git checkout -b GP-00-my-new-branch
- Get in the habit of occasionally merging **dev branch** into your branch, first git checkout your_branch and then git merge development in order to avoid conflicts as much as possible.
- Comment out commits in English

## Merge request

- Download the last changes of development branch by placing inside development with git checkout development and then do git pull
- Complete **the whole**.
- Write in the task **what you need** to do to test the task, specifying whether you need to launch composer or install other libraries.
- Merge **dev branch** into your branch by first git checkout your_branch and then git merge development (git merge dev)
- Resolve any conflicts (via IDE, it's easier)
- Do git commit -m "your message" and then git push
- Make a merge request of **your** branch to **dev branch** via web on the github repository (**Don't approve**)
