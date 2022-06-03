## Relipa portal API

### Prerequisites
- [Install Docker](https://docs.docker.com/install/linux/docker-ce/ubuntu/) & [Post-installation steps for Linux](https://docs.docker.com/install/linux/linux-postinstall/)
- [Install Docker compose](https://docs.docker.com/compose/install/)
- Build docker on: Ubuntu / Linux or MacOS

### Environment

|Software  |  Version |
|---|---|
| nginx  | 1.22.0  |
| php  | 8.1.6  |
| mysql  | 5.7  |
| redis  | 7.0.0  |
| laravel  | 8.83.12  |
| composer  | 2.3.5  |
| node  | 16.15  |

### Development
```zsh
$ chmod a+x ./app.sh
$ ./app.sh start
```
Bringing up the Docker Compose network with `web` instead of just using up,
ensures that only our web's containers are brought up at the start,
instead of all of the command containers as well. The following are built for our web server,
with their exposed ports detailed:

|Service  |  Port |
|---|---|
| nginx  | 80, 443  |
| mysql  | 3306  |
| php  | 9000  |
| redis  | 6379  |
| mailhog  | 8025  |


- Attach to a running container
```zsh
$  ./app.sh exec {service_name}
```
- Running COMPOSER command from host machine
```zsh
$ ./app.sh composer -v
```

- Running ARTISAN command from host machine
```zsh
$ ./app.sh artisan config:cache
```

- Running NPM command from host machine
```zsh
$ ./app.sh npm -v
```

### Linter
#### 1. Install Husky & Lint-staged
- Install node dependencies
```zsh
$ ./app.sh npm install
```

- Init husky hook pre-commit
```zsh
$ ./app.sh npm run postinstall
```
#### 2. Linter PHP coding standards
Prerequisites: Install PHP >= 7.0 on host machine
- Linter by PHP Coding Standard rules
```zsh
$ ./app.sh php_lint
```

- Fixed follow by PHP Coding Standard rules
```zsh
$ ./app.sh php_fix
```
