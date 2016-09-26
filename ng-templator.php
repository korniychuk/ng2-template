#!/usr/bin/php
<?php

require_once 'vendor/autoload.php';

$cmd = new Commando\Command();

// Define first option
$cmd->option()
    ->require()
    ->describedAs('Command name')
    ->must(function($title) {
        $titles = array('component', 'module');
        return in_array($title, $titles);
    });

// Define second option
$cmd->option()
    ->require()
    ->describedAs('Entity name');

// Configure additional parameters
$cmd->option('s')
    ->aka('style')
    ->describedAs('What preprocessor need to be used for styles file? (need for component')
    ->must(function($title) {
        $preprocessors = array('less', 'scss');
        return in_array($title, $preprocessors);
    })
    ->default('less');
/*

// Define a flag "-t" a.k.a. "--title"
$cmd->option('t')
    ->aka('title')
    ->describedAs('When set, use this title to address the person')
    ->must(function($title) {
              $titles = array('Mister', 'Mr', 'Misses', 'Mrs', 'Miss', 'Ms');
              return in_array($title, $titles);
          })
    ->map(function($title) {
              $titles = array('Mister' => 'Mr', 'Misses' => 'Mrs', 'Miss' => 'Ms');
              if (array_key_exists($title, $titles))
                  $title = $titles[$title];
              return "$title. ";
          });

// Define a boolean flag "-c" aka "--capitalize"
$cmd->option('c')
    ->aka('capitalize')
    ->aka('cap')
    ->describedAs('Always capitalize the words in a name')
    ->boolean();
*/

//$name = $cmd['capitalize'] ? ucwords($cmd[0]) : $cmd[0] . ' '. $cmd[1];
//
//echo "Hello {$cmd['title']}$name!", PHP_EOL;

$rootDir = getcwd();

$name = $cmd[1];

$nameCamel = preg_replace_callback('/^.|-./', function($matches) {
    return str_replace('-', '', strtoupper($matches[0]));
}, $name);
$nameCamelLower = lcfirst($nameCamel);

/**
 * @param string $name    file name
 * @param string $content file content
 */
function makeFile($name, $content) {
    file_put_contents($GLOBALS['rootDir'].'/'.$name, $content);
    echo "File created: $name\n";
}
/**
 * @param string $name directory name
 */
function makeDir($name) {
    if (!file_exists($GLOBALS['rootDir'].'/'.$name)) {
        echo "Directory created: $name\n";
        mkdir($GLOBALS['rootDir'].'/'.$name);
    } else {
        echo "Directory already exists: $name\n";
    }
}

$commandName = $cmd[0];


echo "Creation $commandName '$name'\n\n";

require(__DIR__."/commands/$commandName.php");

echo "\nDone!\n\n";