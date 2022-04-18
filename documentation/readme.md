
![Logo](./public/img/logo.png)


# Project

Project descriptions.


## Tech Stack

**Client:** Laravel Blade, Vue js, Bootstrap

**Server:** Php, Laravel


## Setup Project

Clone the project

```bash
  git clone GITURL
```

Installation Steps

```bash
  cd folder                               // Go to the project directory
  composer install                            // install php dependencies
  cp .env.example .env                        // copy .env.example to .env
  php artisan key:generate                    // generate key for project
  set database credentials in .env
  php artisan migrate                         // run migration files
  php artisan db:seed                         // run database seeders
  php artisan storage:link                    // create storage link
  install wkhtmltopdf on server or system     // for export pdf of cv builder on front side
```

Setup Project Module of Admin side
```bash
  php artisan module:seed Project             // run database seeders
  cd Modules/Project                          // go to the Modules/Project directory
  npm install                                 // install npm dependencies
  npm run dev                                 // generate build
```

Start the server

```bash
  // run this command from root path of the project
  php artisan serve
```


## Environment Variables

To run this project, you will need to add the following environment variables to your .env file

```bash
'WKHTML_PDF_BINARY'                           // for the cv builder pdf

'FILE_SIZE_LIMIT'                             // file size limit for validation

'MIX_FILE_SIZE_LIMIT'                         // file size limit for validation in vue components

'INVOICE_PROJECT_VALIDATION_START_DATE'       // start invoice validation for project field


## Extra Environment Variables
-------------------------------

'DEBUGBAR_ENABLED'                            // enable/disable debugbar

'DEBUGBAR_THEME'                              // set debugbar theme

```
