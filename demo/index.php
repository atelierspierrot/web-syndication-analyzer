<?php
/**
 * Show errors at least initially
 *
 * `E_ALL` => for hard dev
 * `E_ALL & ~E_STRICT` => for hard dev in PHP5.4 avoiding strict warnings
 * `E_ALL & ~E_NOTICE & ~E_STRICT` => classic setting
 */
@ini_set('display_errors','1'); @error_reporting(E_ALL);
//@ini_set('display_errors','1'); @error_reporting(E_ALL & ~E_STRICT);
//@ini_set('display_errors','1'); @error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);

/**
 * Set a default timezone to avoid PHP5 warnings
 */
$dtmz = @date_default_timezone_get();
date_default_timezone_set($dtmz?:'Europe/Paris');

// arguments settings
$doc = isset($_GET['doc']) ? $_GET['doc'] : null;
$md = isset($_GET['md']) ? $_GET['md'] : 'none';
$arg_ln = isset($_GET['ln']) ? $_GET['ln'] : 'en';
$page = isset($_GET['page']) ? $_GET['page'] : null;
if (!empty($page)) {
    if (file_exists($page.'.php')) $page = $page . '.php';
    elseif (file_exists($page.'.html')) $page = $page . '.html';
    else unset($page);
}

// contents settings
$js_code = false;
$parse_options = array();
$templater_options = array();
$info = $error = $content = '';

// -----------------------------------
// NAMESPACE
// -----------------------------------

// get the Composer autoloader
if (file_exists($a = __DIR__.'/../../../autoload.php')) {
    require_once $a;
} elseif (file_exists($b = __DIR__.'/../vendor/autoload.php')) {
    require_once $b;

// else try to register `RSS` namespace
} elseif (file_exists($c = __DIR__.'/../src/SplClassLoader.php')) {
    require_once $c;
    $classLoader = new SplClassLoader('RSS', __DIR__.'/../src');
    $classLoader->register();
    $classLoader = new SplClassLoader('CachedRSS', __DIR__.'/../src');
    $classLoader->register();

// else error, classes can't be found
} else {
    die('You need to run Composer on your project to use this interface!');
}

// -----------------------------------
// Page Content
// -----------------------------------
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test & documentation of PHP "RSS analyzer" package</title>
<!-- Bootstrap -->
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
    <link rel="stylesheet" href="assets/styles.css" />
</head>
<body>
    <!--[if lt IE 7]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">RSS analyzer</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul id="navigation_menu" class="nav navbar-nav" role="navigation">
                    <li><a href="index.php">Usage</a></li>
                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Documentation <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right" role="navigation">
                    <li><a href="#bottom" title="Go to the bottom of the page">&darr;</a></li>
                    <li><a href="#top" title="Back to the top of the page">&uarr;</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>

    <div class="container">

        <a id="top"></a>

        <header role="banner">
            <h1>The PHP "<em>RSS analyzer</em>" package <br><small>A complete PHP 5.3 package of Markdown syntax parser (extended version)</small></h1>
            <div class="hat">
                <p>These pages show and demonstrate the use and functionality of the <a href="http://github.com/atelierspierrot/rss-analyzer">atelierspierrot/rss-analyzer</a> PHP package you just downloaded.</p>
            </div>
        </header>

        <div id="content" role="main">

            <article>



            </article>

        </div>
    </div>

    <footer id="footer">
        <div class="container">
            <div class="text-muted pull-left">
                This page is <a href="" title="Check now online" id="html_validation">HTML5</a> & <a href="" title="Check now online" id="css_validation">CSS3</a> valid.
            </div>
            <div class="text-muted pull-right">
                <a href="http://github.com/atelierspierrot/rss-analyzer">atelierspierrot/rss-analyzer</a> package by <a href="https://github.com/piwi">@piwi</a> under <a href="http://spdx.org/licenses/BSD-3-Clause">BSD 3 Clause</a> license.
                <p class="text-muted small" id="user_agent"></p>
            </div>
        </div>
    </footer>

    <div id="message_box" class="msg_box"></div>
    <a id="bottom"></a>

<!-- jQuery lib -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<!-- Bootstrap -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

<!-- jQuery.tablesorter plugin
<script src="assets/js/jquery.tablesorter.min.js"></script>
-->

<!-- jQuery.highlight plugin -->
<script src="assets/js/highlight.js"></script>

<!-- scripts for demo -->
<script src="assets/scripts.js"></script>

<script>
$(function() {
    getToHash();
    addCSSValidatorLink('assets/styles.css');
    addHTMLValidatorLink();
    $("#user_agent").html( navigator.userAgent );
    $('pre').each(function(i,o) {
        var dl = $(this).attr('data-language');
        if (dl) {
            $(this).addClass('code')
                .highlight({indent:'tabs', code_lang: 'data-language'});
        }
    });
    initHandler('classinfo', true);
    initHandler('plaintext', true);
});
</script>
<?php if ($js_code) : ?>
<script id="js_code">
$(function() {

// list manifest content
    initHandler( 'manifest' );
    var manifest_url = '../composer.json';
    var manifest_ul = $('#manifest').find('ul');
    getPluginManifest(manifest_url, function(data){
        manifest_ul.append( getNewInfoItem( data.name, 'title' ) );
        if (data.version) {
            manifest_ul.append( getNewInfoItem( data.version, 'version' ) );
        } else if (data.extra["branch-alias"] && data.extra["branch-alias"]["dev-master"]) {
            manifest_ul.append( getNewInfoItem( data.extra["branch-alias"]["dev-master"], 'version' ) );
        }
        manifest_ul.append( getNewInfoItem( data.description, 'description' ) );
        manifest_ul.append( getNewInfoItem( data.license, 'license' ) );
        manifest_ul.append( getNewInfoItem( data.homepage, 'homepage', data.homepage ) );
    });

// list GitHub infos
    initHandler( 'github' );
    var github = 'https://api.github.com/repos/atelierspierrot/rss-analyzer/';
    // commits list
    var github_commits = $('#github').find('#commits_list');
    getGitHubCommits(github, function(data){
        if (data!==undefined && data!==null) {
            $.each(data, function(i,o) {
                if (o!==null && typeof o==='object' && o.commit.message!==undefined && o.commit.message.length)
                    github_commits.append( getNewInfoItem( o.commit.message, (o.commit.committer.date || ''), (o.commit.url || '') ) );
            });
        } else {
            github_commits.append( getNewInfoItem( 'No commit for now.', '' ) );
        }
    });
    // bugs list
    var github_bugs = $('#github').find('#bugs_list');
    getGitHubBugs(github, function(data){
        if (data!==undefined && data!==null) {
            $.each(data, function(i,o) {
                if (o!==null && typeof o==='object' && o.title!==undefined && o.title.length)
                    github_bugs.append( getNewInfoItem( o.title, (o.created_at || ''), (o.html_url || '') ) );
            });
        } else {
            github_bugs.append( getNewInfoItem( 'No opened bug for now.', '' ) );
        }
    });

});
</script>
<?php endif; ?>
</body>
</html>
