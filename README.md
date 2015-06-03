# Saft.example

Collection of some example scripts using Saft.library. These will help you to better understand how Saft and
its parts work.

## Getting Started

You can directly execute an example without the need to configure it or something.

### Install dependencies

Before you can start, you have to install all dependencies to run the examples. So please execute the following
command in your terminal while you are in the root folder of Saft.examples:

```
composer update
```

#### Troubleshooting

If your machine lacks some PHP extension needed to be loaded, composer will throw errors such as:

```
- Installation request for saft/saft dev-master -> satisfiable by saft/saft[dev-master].
- saft/saft dev-master requires ext-redland * -> the requested PHP extension redland is missing from your system.
```

If you dont need the according examples, you can avoid that by using the `--ignore-platform-reqs` option
in your composer command:

```
composer update --ignore-platform-reqs
```

### Using the terminal

Executing the example using your terminal is the usual way. Its really easy, you just have to use the example
filepath in the `php` command.

```
php DependencyInjection/Dice/InstanceAClass.php
```

You should see some output on your terminal.

### Using a webserver

If you want to execute the examples in your browser, you have to copy the example into a folder which can be
accessed using a webserver, such as Apache or nginx. Afterwards, directly call the file in the browser.
