<?php
use utils\AbstractClassLoader;
use utils\classLoader;

require_once 'src/mf/utils/AbstractClassLoader.php';
require_once 'src/mf/utils/ClassLoader.php';
$loader = new utils\ClassLoader('src');
$loader->register();

// use twitterapp\model\Follow as Follow;
// use twitterapp\model\Like as Like;
// use twitterapp\model\User as User;
// use twitterapp\model\Tweet as Tweet;

