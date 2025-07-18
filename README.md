# Mlab Ms template

This repository contains the code of microservice budgetcontrol template.

## Prerequisites

- Docker: [Install Docker](https://docs.docker.com/get-docker/)
- Task: [Install Task](https://taskfile.dev/#/installation)

## Getting Started

1. Clone this repository:

    ```bash
    git clone https://github.com/your-repository
    ```

2. Build and run the Docker containers:

    ```bash
    task build:dev
    ```

5. Open your browser and visit [http://localhost:8084](http://localhost:8084) to access the Mlab application.

## Task Commands

- `task build:dev`: Install and build dev application.
- `task build`: Install and build base application.

### Test with FTP

You can use an fake ftp docker server
- docker run --rm -d --name ftpd_server -p 21:21 -p 30000-30009:30000-30009 -e FTP_USER_NAME=user -e FTP_USER_PASS=12345 -e FTP_USER_HOME=/home/user stilliard/pure-ftpd
- docker network connect [network_name] ftpd_server

## Build dev enviroment
- docker-compose -f docker-compose.yml -f -f docker-compose.db.yml up -d
- docker container cp bin/apache/default.conf budgetcontrol-ms-authentication:/etc/apache2/sites-available/budgetcontrol.cloud.conf
- docker container exec budgetcontrol-ms-authentication service apache2 restart

### Test with mailhog service

You can use an fake mailhog server
- docker run --rm -d --name mailhog -p 8025:8025 -p 1025:1025 mailhog/mailhog
- docker network connect [network_name] mailhog

## Run PHP Tests
- docker exec budgetcontrol-ms-authentication bash -c "vendor/bin/phinx rollback -t 0 && vendor/bin/phinx migrate && vendor/bin/phinx seed:run" 
- docker exec budgetcontrol-ms-authentication vendor/bin/phpunit test

## Contributing

Contributions are welcome! Please read our [Contribution Guidelines](CONTRIBUTING.md) for more information.

## License

This project is licensed under the [MIT License](LICENSE).

## Debug
```bash
{
    // Usare IntelliSense per informazioni sui possibili attributi.
    // Al passaggio del mouse vengono visualizzate le descrizioni degli attributi esistenti.
    // Per altre informazioni, visitare: https://go.microsoft.com/fwlink/?linkid=830387
    "version": "0.2.0",
    "configurations": [
        {
            "name": "Listen for Remote Xdebug",
            "type": "php",
            "request": "launch",
            "port": 9003,
            "pathMappings": {
                "/var/www/workdir": "${workspaceRoot}",
            },
            "log": true, 
        },
    ]
}
```