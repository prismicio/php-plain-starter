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

### Contribute to the starter project

Contribution is open to all developer levels, read our "[Contribute to the official kits](https://developers.prismic.io/documentation/UszOeAEAANUlwFpp/contribute-to-the-official-kits)" documentation to learn more.

### Licence

This software is licensed under the Apache 2 license, quoted below.

Copyright 2013 Zengularity (http://www.zengularity.com).

Licensed under the Apache License, Version 2.0 (the "License"); you may not use this project except in compliance with the License. You may obtain a copy of the License at http://www.apache.org/licenses/LICENSE-2.0.

Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing permissions and limitations under the License.
