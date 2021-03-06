<?php

/*
 * // URL for tests
    'Cyber Citi (test atom)'        => 'http://feeds.cyberciti.biz/Nixcraft-LinuxFreebsdSolarisTipsTricks',
    'Digital Trends (test rss 2.0)' => 'http://www.digitaltrends.com/feed/'
*/

// options for the syndication feeds
$options = array(
    'use_cache' => false,
    'cache_directory' => __DIR__.'/tmp/', // this MUST exist and be writable
    'classes'=>array(
        // content-feed-channel.htm
        'channel_wrapper'=>'lead clearfix',
        'channel_title'=>'',
        'channel_content'=>'',
        'channel_subtitle'=>'',
        'channel_description'=>'',
        'channel_image'=>'',
        // content-feed-item.htm
        'item_wrapper'=>'',
        'item_title'=>'page-header',
        'item_content'=>'',
        'item_subtitle'=>'',
        'item_description'=>'',
        'item_categories_list'=>'',
        'item_media'=>'',
        // tags
        'tag_category'=>'label label-default',
        'tag_content'=>'',
        'tag_date'=>'',
        'tag_image'=>'pull-right',
        'tag_media'=>'',
        'tag_person'=>'',
    ),

);

/**
 * Show errors at least initially
 *
 * `E_ALL` => for hard dev
 * `E_ALL & ~E_STRICT` => for hard dev in PHP5.4 avoiding strict warnings
 * `E_ALL & ~E_NOTICE & ~E_STRICT` => classic setting
 */
@ini_set('display_errors', '1'); @error_reporting(E_ALL);
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
    if (file_exists($page.'.php')) {
        $page = $page . '.php';
    } elseif (file_exists($page.'.html')) {
        $page = $page . '.html';
    } else {
        unset($page);
    }
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

// else try to register `WebSyndication` namespace
} elseif (file_exists($c = __DIR__.'/../src/SplClassLoader.php')) {
    require_once $c;
    $classLoader = new SplClassLoader('WebSyndication', __DIR__.'/../src');
    $classLoader->register();

// else error, classes can't be found
} else {
    die('You need to run Composer on your project to use this interface!');
}

$feed_urls = (!empty($_POST) && isset($_POST['feed_url'])) ? $_POST['feed_url'] : '';
$feed_urls = explode(',', $feed_urls);
$feed_urls = array_filter($feed_urls);
$page_max = (!empty($_POST) && isset($_POST['page_max'])) ? $_POST['page_max'] : 10;
$current_page = (!empty($_POST) && isset($_POST['current_page'])) ? $_POST['current_page'] : 1;
$category = (!empty($_POST) && isset($_POST['category'])) ? $_POST['category'] : '';

// -----------------------------------
// Page Content
// -----------------------------------
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test & documentation of PHP "WebSyndication analyzer" package</title>
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
                <a class="navbar-brand" href="#">WebSyndication analyzer</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul id="navigation_menu" class="nav navbar-nav" role="navigation">
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
            <h1>The PHP "<em>WebSyndication analyzer</em>" package <br><small>A PHP 5.3 package to manipulate syndication feeds</small></h1>
            <div class="hat">
                <p>These pages show and demonstrate the use and functionality of the <a href="http://github.com/atelierspierrot/web-syndication-analyzer">atelierspierrot/web-syndication-analyzer</a> PHP package you just downloaded.</p>
            </div>
        </header>

        <div id="content" role="main">

            <div class="jumbotron">
                <form role="form" action="index.php" method="post" id="feed-tester">
                    <input type="hidden" id="page_max" name="page_max" value="<?php echo $page_max; ?>">
                    <input type="hidden" id="current_page" name="current_page" value="<?php echo $current_page; ?>">
                    <input type="hidden" id="category" name="category" value="<?php echo $category; ?>">

                    <div class="form-group">
                        <label for="feed_url">URL feed(s) to test</label>
                        <input type="url" class="form-control" id="feed_url" name="feed_url" placeholder="Enter feed URL" value="<?php echo join(',', $feed_urls); ?>">
                    </div>

                    <span class="help-block">You can define multiple feeds URLs separated by coma.</span>
                    <span class="help-block">Shortcuts:
                        <ul>
                            <li><a href="#" onclick="updateForm('feed_url', 'http://feeds.cyberciti.biz/Nixcraft-LinuxFreebsdSolarisTipsTricks');">http://feeds.cyberciti.biz/Nixcraft-LinuxFreebsdSolarisTipsTricks</a></li>
                            <li><a href="#" onclick="updateForm('feed_url', 'http://www.digitaltrends.com/feed/');">http://www.digitaltrends.com/feed/</a></li>
                        </ul>
                    </span>

                    <button type="submit" class="btn btn-primary">Submit</button>

                </form>
            </div>
            <article>

<?php

\WebSyndication\Helper::setOptions($options);
$feeds = null;

if (!empty($feed_urls)) {
    $feeds = new \WebSyndication\FeedsCollection($feed_urls);
    $feeds->read();

//var_export($feeds);

    $categories = $feeds->getItemsCategories();

    if (empty($category)) {
        $items          = $feeds->getItems();
    } else {
        $items          = $feeds->getItemsCollectionByCategorie($category);
    }

    $pagination = new \Library\Tool\Pagination($items, $page_max, $page_max*($current_page-1));

    echo '<div class="page-header"><h1>';
    foreach ($feeds->getFeedsRegistry() as $i=>$feed) {
        echo $feed->getFeedUrl().' ('.$feed->getProtocol().' '.$feed->getVersion().') ';
    }
    echo '<br /><small>'.$pagination->getItemsNumber().' items - page '.$current_page.' / '.$pagination->getPagesNumber();
    if (!empty($categories)) {
        echo ' - Categories: <select class="form-control" onchange="updateForm(\'category\', $(\'option:selected\').val());" style="width:180px;display:inline;">';
        echo '<option>Choose ...</option>';
        foreach ($categories as $category_name) {
            echo '<option value="'.$category_name.'"'
                .($category_name==$category ? ' selected' : '')
                .'>'.$category_name.'</option>';
        }
        echo '</select>';
    }
    echo '</small></h1></div>';

    if ($pagination->exists()) {
        echo '<ul class="pagination">';
        foreach ($pagination as $i=>$page) {
            echo '<li';
            if ($page->isCurrent()) {
                echo ' class="active"';
            }
            echo '><a href="#" onclick="updateForm(\'current_page\', '.$page->getPageNumber().');">'.$page->getPageNumber().'</a></li>';
        }
        echo '</ul>';
    }

    $collection = new \WebSyndication\ItemsCollection($pagination->getPaginatedCollection());
    $renderer = new \WebSyndication\Renderer($collection);
    $renderer
        ->setOffset($page_max*($current_page-1))
        ->setLimit($page_max);
    echo '<hr />'.$renderer;

    /*
    foreach ($pagination->getPaginatedCollection() as $item) {
        //    var_export($item);
        $renderer = new \WebSyndication\Renderer($item);
        $renderer
            ->setOffset($page_max*($current_page-1))
            ->setLimit($page_max);
        echo "<hr />".$renderer;
    }
    */
}
?>
            </article>
            <hr />

<?php
if (!empty($feeds)) {
    foreach ($feeds->getFeedsRegistry() as $i=>$feed) {
        echo '<strong>Original raw feed for '.$feed->getFeedUrl().'</strong>'
            .'<pre class="pre-scrollable">'.htmlentities($feed->getXml()->asXml()).'</pre>';
    }
}
?>

        </div>
    </div>

    <footer id="footer">
        <div class="container">
            <div class="text-muted pull-left">
                This page is <a href="" title="Check now online" id="html_validation">HTML5</a> & <a href="" title="Check now online" id="css_validation">CSS3</a> valid.
            </div>
            <div class="text-muted pull-right">
                <a href="http://github.com/atelierspierrot/web-syndication-analyzer">atelierspierrot/web-syndication-analyzer</a> package by <a href="https://github.com/piwi">@piwi</a> under <a href="http://www.apache.org/licenses/LICENSE-2.0">Apache 2.0</a> license.
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

<!-- scripts for demo -->
<script src="assets/scripts.js"></script>

<script>

function updateForm(fname, fval)
{
    jQuery('#'+fname).val(fval);
    jQuery('#feed-tester').submit();
    return false;
}

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
    var github = 'https://api.github.com/repos/atelierspierrot/web-syndication-analyzer/';
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
