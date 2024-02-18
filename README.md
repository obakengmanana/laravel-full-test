<p style="background: white; padding: 1rem; text-align: center"><img src="https://www.bravedigital.com/wp-content/themes/bravetheme2017/assets/images/logo.svg" width="400" alt="Brave Logo"></p>

# Welcome

Welcome to the Brave Code test.

In this test your objective will be to extend this installation to include a search function 
in the provided top navigation.

This installation is based of [Laravel 9](https://laravel.com/docs/9.x/) and set up to use a 
SQLLite database. The installation also includes the following tools already set up:

- [Vite](https://laravel.com/docs/9.x/vite) - The new Asset bundler, set up to compile Sass & JavaScript and bundle some assets.
- [Bootstrap 5](https://getbootstrap.com/docs/5.0/getting-started/introduction/) - To allow for some basic scaffolding, you are welcome to replace this if you see fit.
- [Blade](https://laravel.com/docs/9.x/blade) - Used for some base front-end templating, but you are welcome to replace with other tools like Livewire, Vue & React.

## Getting Started

To get up and running the basic Laravel commands can be used along with a provided command 
to populate your database.

The example environment file (`.env-example`) contains the API keys you will need to run the 
script to populate the database, if for some reason this isn't working you can get a fresh
API key from [The Movie Database](https://developers.themoviedb.org/3/getting-started) directly.

---
The following commands should be run to get set up:

Install Laravel & frontend libraries:
```bash
composer install
npm install
```

Set up the database and populate it with data:
```bash
touch database/database.sqlite
php artisan migrate
php artisan brave:get-movies
```

To run the project locally the following commands exists to bundle your assets and set up hot reload,
as well as the serve command to start the local development server for Laravel.

```bash
npm run dev
php artisan serve
```

Once you have completed your task you can use `npm run build` to bundle  all the assets for a portable installation.

## The Challenge

Imagine this is a client site we manage for them. They have asked us to implement a searchbar in the top navigation
that allows users to search all the movies in the database. They are relying on you to develop this within this
codebase, and are open to you deciding on the details of the User Experience. They have only mentioned they need a
autocomplete function included in the experience.

For the purpose of this test we want a full end to end implementation of a search bar in the provided header component,
with  autocomplete functionality and a results page. You are welcome to implement and extend composer or npm packages or
other libraries to achieve this, as long as there are no external tools like Elastic Search or any search services
used.

The design has been provided in the attached PDF. Mobile responsiveness is up to you, and will be discussed in your
technical interview. You are also welcome to replace existing libraries or packages if they are incompatible with something you intend to
utilise.

Below is the list of features which we expect to see from your searchbar:

- An input accessible from any page to allow you to enter your search term.
- Functionality to search within the database within the following fields
  - Title
  - Description
  - Release Year
  - *[Bonus]* Director
  - *[Bonus]* Cast members
- Searching of all fields combined into a single set of results.
- The necessary controller functions and endpoints to expose the search algorithm.
- Autocomplete functionality, providing summarised results as you type.
- Close adherance to the Design.
- *[Bonus]* Mobile responsiveness
- *[Bonus]* Weighting of fields, prioritising the most important fields where text should be matched.
- *[Bonus]* Optimisation of the algorithm for performance and scale.

We expect this test to take less than 4 hours, and expect well documented code to be provided for us to evaluate.


