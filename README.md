## Plain PHP starter project for prismic.io

This is a blank plain PHP project that will connect to any prismic.io repository, and trivially list its documents. It uses the prismic.io PHP development kit, and provides a few helpers.

### Getting started

#### Launch the starter project

Fork this repository, then clone your fork, and set up Apache so that the root of your website is the `public_html` directory.

If you haven't, [install Composer](https://getcomposer.org/doc/00-intro.md), and run `composer install`, to retrieve and install the PHP prismic.io kit and its dependencies.

Your plain PHP starter project is now up and running! However, by default, it will list and display documents from our "[Les Bonnes Choses](http://lesbonneschoses.prismic.me)" example repository.

#### Configure the starter project

Change the ```https://lesbonneschoses.prismic.io/api``` API endpoint in the `resources/config.php` file into your repository's endpoint.

To set up the OAuth configuration and interactive signin, go to the _Applications_ panel in your repository's settings, and create a new OAuth application. You simply have to fill in an application name and potentially the callback URL (`localhost` URLs are always authorized, so at development time you can omit to fill in the Callback URL field). After submitting, copy/paste the `clientId` & `clientSecret` tokens into the proper place in your configuration.

You may have to restart your Apache server.

#### Get started with prismic.io

You can find out [how to get started with prismic.io](https://developers.prismic.io/documentation/UjBaQsuvzdIHvE4D/getting-started) on our [prismic.io developer's portal](https://developers.prismic.io/).

#### Understand the PHP development kit

You'll find more information about how to use the development kit included in this starter project, by reading [its README file](https://github.com/prismicio/php-kit).

### Specifics and helpers of the PHP plain starter project

There are several places in this project where you'll be able to find helpful helpers of many kinds. You may want to learn about them in order to know your starter project better, or to take those that you think might be useful to you in order to integrate prismic.io in an existing app.

 * `resources/config.php`:
  * role: gathers key configuration for your project; if you're integrating prismic.io into an existing project, you definitely want this file
  * centralizes all information about the prismic.io repository's API (endpoint, client ID, client secret, ...)
  * defines some key variable used across the project, and requires the `Prismic.php` helper file.
  * defines the `Routes` class, which contains helpers to build some of the project's URLs (depending on your project's architecture, you can choose to do this in another file), including:
    * `index`, `detail` and `search` which are here for the example
    * `signin`, `signout` and `authCallback`, which you'll need if you need to log into your repository through OAuth to preview future content releases
    * `baseUrl`, a helper for all the guys above
  * provides a basic `LinkResolver` class to iterate upon. For a given document, the "link resolver" describes its URL on your front-office. You really should edit this method, so that it supports all the document types your content writers might link to (read the very last paragraph of [our API documentation](https://developers.prismic.io/documentation/UjBe8bGIJ3EKtgBZ/api-documentation) to learn more about what the link resolver is for).
 * `resources/libraries/Prismic.php`
  * role: provides helpers; if you're integrating prismic.io into an existing project, you definitely want this file
  * provides a `Context` class which allows to keep and pass around everything there is to know to use your PHP kit with your prismic.io repository
  * provides a `Prismic` class with helper functions: `config` (to easily access what's in the config file), `context` (to easily build the `Context` object), `apiHome` (to easily build the `Api` object from what in your configuration), `getDocument` (to easily query a document from its ID), `handlePrismicException` (to factorize how to catch API call exceptions), ...
 * `resources/librairies/oauth/` is a directory that contains all the PHP files that need to be executed to get logged in or out of your prismic.io repository; this will be useful to be allowed to preview future content releases; this is includes by 3 similarly-named files in `public_html`.
 * `resources/templates/` is a directory with bits of pages that are useful for the example.
  * `toolbar.php` will interest you particularly, as it contains the selectbox to choose which content release you wish to preview if you're authenticated.
 * `public_html/` contains the page useful for the oAuth authentication, and some pages for the example.
  * `oauthCallback.php`, `signin.php` and `signout.php` are useful for the oAuth authentication; they include the files in `resources/librairies/oauth/`
  * there are 3 preincluded pages: `index.php` (lists all documents), `detail.php` (display one document), `search.php` (display search results).

You'll notice that all preincluded pages are shaped like this, you may want to keep that structure in your project:

```php
<?php
    require_once '../resources/config.php';
    require_once(LIBRARIES_PATH . "/Prismic.php");

    try {
        $ctx = Prismic::context();
        // TODO: Queries to the prismic.io repository
    } catch (Guzzle\Http\Exception\BadResponseException $e) {
        Prismic::handlePrismicException($e);
    }

    // TODO: other controller-level variables
    
    // Beginning of the view
?>
```

### Contribute to the starter project

Contribution is open to all developer levels, read our "[Contribute to the official kits](https://developers.prismic.io/documentation/UszOeAEAANUlwFpp/contribute-to-the-official-kits)" documentation to learn more.

### Licence

This software is licensed under the Apache 2 license, quoted below.

Copyright 2013 Zengularity (http://www.zengularity.com).

Licensed under the Apache License, Version 2.0 (the "License"); you may not use this project except in compliance with the License. You may obtain a copy of the License at http://www.apache.org/licenses/LICENSE-2.0.

Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing permissions and limitations under the License.
