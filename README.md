# Festishow_sf

## Presentation
https://docs.google.com/presentation/d/1GdQ6M8gfi7euEGa7tb_yI9XvTNi2E2r6ekB-col8ohI/edit?usp=sharing
## Installation

1. Clone the current repository.

3. Move into the directory and create an `.env.local` file.

   set the DB infos

   // create a mailTrap account and get the key MAILER_DSN
   MAILER_DSN=smtp://xxxx720a7dbc@smtp.mailtrap.io:2525?encryption=tls&auth_mode=login
   MAILER_FROM_ADDRESS=booking@festishow.com

4. Execute the following commands in your working folder to install the project:

```bash
# Install dependencies
composer install

# Create 'festishow_sf' DB
php bin/console d:d:c

# Execute migrations and create tables
php bin/console d:m:m

# Load fixtures data
php bin/console doctrine:fixtures:load

# Install assets dependencies
yarn install

# Compile assets once
yarn dev
```

# Launch the server with the command below and follow the instructions on the homepage `/`;
$ symfony server:start

$ symfony open:local