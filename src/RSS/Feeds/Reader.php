<?php


final class \RSS\Feeds_Reader
    extends BaseSingleton
    implements MVC_Interface, Optionable_Interface, TemplateEngine_Interface
{

    protected static $_isInstalled = false;
    protected static $_isInited = false;
    protected static $_models = array();

    protected static $default_options;
    protected static $editable_preferences;
    protected static $arguments_list;

    protected $options = array();
    protected $arguments = array();

    public $messages = array( 'info'=>array(), 'error'=>array() );
    public $global_response_args = array();
    public $content;
    public $breadcrumb = array();
    public $user;
	public $output='';
    public $rss_reader;

// --------------------
// Singleton Instance
// --------------------

    public static function getInstance( array $user_options=array() )
    {
        if (!isset(self::$_instances['app']))
        {
            $_cls = __CLASS__;
            self::$_instances['app'] = new $_cls( $user_options );
            self::$_instances['app']->setOptions($user_options);
            self::$_instances['app']->init();
        }
        return self::$_instances['app'];
    }
    
// --------------------
// Construct / Destruct / Clone
// --------------------

    protected function __construct( array $user_options=array() )
    {
        // all values from the \RSS\Feeds\Reader_Options static object
        self::$editable_preferences = \RSS\Feeds\Reader_Options::getEditablePreferences();
        self::$arguments_list = \RSS\Feeds\Reader_Options::getArgumentsList();
        self::$default_options = \RSS\Feeds\Reader_Options::getDefaultOptions();

        // options are first defaults
        $this->options = self::$default_options;

        // the models as singletons
        $this->registerModelClass('user', 'User_Model');
        $this->registerModelClass('session', 'UserSession_Model');
        $this->registerModelClass('feeder_config', 'FeederConfigCollection_Model');
        $this->registerModelClass('feeds_collection', 'FeedsCollection_Model');
        $this->registerModelClass('favorites', 'Favorites_Model');
    }

    public function __destruct()
    {
        if (!headers_sent()) $this->render();
    }

    private function init()
    {
        // theme file
        $this->setOption('theme_file', sprintf($this->getOption('theme_file'), $this->getOption('jquery_ui_version')));

        // user session
        $user_session = $this->getModelInstance('session');
        $in_admin = $user_session->read('in_admin');

        // temporary directory
        $_tmp = $this->getOption('temporary_directory');
        APP_Helper::makeDir($_tmp);

        // language
        $ln_inst = i18n::getInstance();
        $user_session = $this->getModelInstance('session');
        $user_lang = $user_session->read('locale');
        if (!empty($user_lang) && $ln_inst->isAvailableLanguage($user_lang))
        {
            $ln_inst->setLanguage($user_lang);
        }
        else
        {
            $browser_lang = (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && !empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) ?
                substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : null;
            if ($ln_inst->isAvailableLanguage($browser_lang))
            {
                $ln_inst->setLanguage($browser_lang);
            }
        }
        $test = i18n::translate('test');
        
        // the current user
        $user_model = $this->getModelInstance('user');
        $this->user = $user_model->authoring(true);
        if ($this->user->isLogged())
        {
            $this->getModelInstance('feeder_config')
                ->setUserToken( $this->user->getUserToken() )
                ->forceReload();
            $this->getModelInstance('feeds_collection')
                ->setUserToken( $this->user->getUserToken() )
                ->forceReload();
            $this->getModelInstance('favorites')
                ->setUserToken( $this->user->getUserToken() )
                ->forceReload();
        }

        // options in session ?
        $this->setUserPreferences($user_session->getEntity());

        // user preferences ?
        $feeder_config = $this->getModelInstance('feeder_config');
        if (!$feeder_config->isEmpty())
        {
            $this->setUserPreferences($feeder_config->getEntity());
        }

        // the feeds list
        if (null===$this->getOption('feeds_collection'))
        {
            $feeds_collection = $this->getModelInstance('feeds_collection');
            $this->setOption('feeds_collection', $feeds_collection->getEntityAsArray());
        }
        $feeds = $this->getOption('feeds_collection');
        if (!is_null($feeds) && !empty($feeds))
        {
            $this->rss_reader = new \RSS\Reader( $this->getOption('feeds_collection') );
        }

        // isInstalled ?
        $session = $this->getModelInstance('session');
        if (is_null($this->rss_reader))
        {
            $session->update('install', true);
        }
        $sess_installation = $session->read('install');
        self::$_isInstalled = !(is_null($this->rss_reader) || (!empty($sess_installation) && true===$sess_installation));

        // init the breadcrumb
        $this->setBreadcrumb( array('application_home'=>buildUrl()) );

        return $this;
    }
        
// --------------------
// Models Management
// --------------------

    public static function registerModelClass( $name, $classname )
    {
        if (!isset(self::$_models[$name]))
        {
            self::$_models[$name] = array('class' => $classname);
        }
    }

    public static function getModelInstance( $name )
    {
        if (isset(self::$_models[$name]))
        {
            if (empty(self::$_models[$name]['instance']))
            {
                $_cls = self::$_models[$name]['class'];
                self::$_models[$name]['instance'] = new $_cls(self::getOptions());
            }
            return self::$_models[$name]['instance'];
        }
        return null;
    }

// --------------------
// User Options
// --------------------

    public static function setOptions( array $options )
    {
        $_this = self::getInstance();
        $_this->options = array_merge($_this->options, $options);
        return $_this;
    }

    public static function setOption( $name, $value )
    {
        $_this = self::getInstance();
        $_this->options[$name] = $value;
        return $_this;
    }

    public static function getOptions()
    {
        $_this = self::getInstance();
        return $_this->options;
    }

    public static function getOption( $name, $default=null )
    {
        $_this = self::getInstance();
        return (array_key_exists($name, $_this->options)) ? $_this->options[$name] : $default;
    }

    public static function getDefaultOptions()
    {
        return self::$default_options;
    }

// --------------------
// Getters / Setters / Checkers
// --------------------

    public function addMessage( $msg, $type='info' )
    {
        $this->messages[$type][] = $msg;
    }

    public function getMessages( $type=null )
    {
        return ($type!==null ? $this->messages[$type] : $this->messages);
    }

    public function setContent( $content )
    {
        $this->content .= $content;
        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setArgument( $name, $value )
    {
        $this->arguments[$name] = $value;
        return $this;
    }

    public function getArgument( $name )
    {
        return array_key_exists($name, $this->arguments) ? $this->arguments[$name] : null;
    }

    public function getArguments()
    {
        return $this->arguments;
    }

    public static function setIsInstalled( $bool )
    {
        self::$_isInstalled = (bool) $bool;
    }

    public static function isInstalled()
    {
        return self::$_isInstalled;
    }

    public static function isFavoriteFeed( $feed_url )
    {
        $_this = self::getInstance();
        $favorites = new Favorites_Model($_this->getOptions());
        return $favorites->entityExists( $feed_url, 'feed' );
    }

    public static function isFavoriteItem( $item )
    {
        $_this = self::getInstance();
        return false;
    }

// --------------------
// User Preferences Management
// --------------------

    public function setUserPreferences( array $user_prefs=array() )
    {
        if (!empty($user_prefs))
        {
            foreach($user_prefs as $name=>$value)
            {
                if (array_key_exists($name, $this->options))
                {
                    $this->setOption($name, $value);
                }
            }
        }
    }

    public function getUserPreference( $pref_name )
    {
        $prefs = $this->getUserPreferences();
        return isset($prefs[$pref_name]) ? $prefs[$pref_name] : null;
    }

    public function getDefaultPreference( $pref_name )
    {
        if (isset(self::$default_options[$pref_name]))
        {
            return self::$default_options[$pref_name];
        }
        $pref_name_default = 'default_'.$pref_name;
        if (isset(self::$default_options[$pref_name_default]))
        {
            return self::$default_options[$pref_name_default];
        }
        return null;
    }

    public function getUserPreferences( $defaults=false )
    {
        $prefs = array();
        $feeder_config = $this->getModelInstance('feeder_config');
        foreach(self::$editable_preferences as $_pref_name)
        {
            $basic_default = $this->getDefaultPreference($_pref_name);
            if (true===$defaults)
            {
                $prefs[$_pref_name] = $basic_default;
            }
            else
            {
                $user_defined = $feeder_config->read($_pref_name);
                $default_defined = $this->getOption($_pref_name);
                $prefs[$_pref_name] = (!is_null($user_defined) && false!==$user_defined) ? $user_defined : (
                    !is_null($default_defined) ? $default_defined : $basic_default
                );
            }
        }
        return $prefs;
    }

// --------------------
// Template Engine Interface
// --------------------

    public function getPageTitle()
    {
	    $last_crumb = end( array_keys( $this->breadcrumb ) );
	    if ($last_crumb!=='application_home')
	    {
    	    $page_title = _T($last_crumb).' - '.RSS_READER_NAME;
	    }
	    else
	    {
    	    $page_title = RSS_READER_NAME;
	    }
        return $page_title;
    }

    public function setBreadcrumb( array $entries )
    {
        $this->breadcrumb = $entries;
        return $this;
    }

    public function addBreadcrumb( array $entries )
    {
        foreach($entries as $_name=>$_url) {
            $this->breadcrumb[$_name] = $_url;
        }
        return $this;
    }

    public function getBreadcrumb()
    {
        return $this->breadcrumb;
    }

    public function themeExists( $theme )
    {
        $theme_file = 
            rtrim(ROOT_DIR, '/').'/'
            .rtrim($this->getOption('themes_directory'), '/').'/'
            .rtrim($theme, '/').'/'
            .$this->getOption('theme_file');
        return @file_exists($theme_file);
    }

    public function getProposedThemes( $including_user=false )
    {
        $themes = $this->getOption('themes', array());
        if (true===$including_user)
        {
            $themes = array_merge($themes, $this->getOption('user_themes', array()));
        }
        return $themes;
    }

    public function getTheme()
    {
        $theme = $this->getOption('theme');
        if (!$this->themeExists($theme))
            $theme = $this->getOption('default_theme');
        if (!$this->themeExists($theme))
            $theme = self::$default_options['default_theme'];
        if (!$this->themeExists($theme))
        {
            throw new Exception(
                sprintf('The default application CSS theme can not be found! Rendering will be altered! (got "%s")', $theme)
            );
        }
        return $theme;
    }

// --------------------
// Output Rendering
// --------------------

	public function render( $json_allowed=true )
	{
	    if (APP_Helper::isAjaxRequest())
	    {
	        if ($json_allowed)
	        {
                if (!headers_sent())
                {
                    header('Content-type: application/json');
                }
                $response = array(
                    'error' => $this->getMessages('error'),
                    'info' => $this->getMessages('info'),
                    'content' => RSS_Helper::getSecuredString( $this->getContent() )
                );
                if (!empty($this->global_response_args))
                {
                    $response = array_merge($this->global_response_args, $response);
                }
                $json = json_encode($response);
                if (!$json && function_exists('json_last_error'))
                {
                    $response['error'][] = json_last_error();
                    $response['content'] = '';
                    echo json_encode($response);
                }
                else
                {
                    echo $json;
                }
            }
            else
            {
                $error = $this->getMessages('error');
                $info = $this->getMessages('info');
                if (!empty($error)) $response = $error;
                else $response = $this->getContent();
                if (empty($response)) $response = $info;
    	        if (!headers_sent())
	            {
                    header('Content-type: text/html');
                }
                echo $response;
            }
	    }
	    else
	    {
	        if (!headers_sent())
	        {
                header('Content-type: text/html');
            }
            $theme = $this->getTheme();
    	    $contents = array(
	            'error' => $this->getMessages('error'),
	            'info' => $this->getMessages('info'),
	            'header'=> $this->renderView($this->getOption('header_template'), array()),
	            'footer'=> $this->renderView($this->getOption('footer_template'), array()),
	            'content'=> $this->getContent(),
	            'charset' => $this->getOption('encoding', 'utf-8'),
	            'theme' => rtrim($this->getOption('assets_themes_directory'), '/').'/'.$theme,
	            'page_title' => $this->getPageTitle()
    	    );
	        if (!empty($this->global_response_args))
	        {
	            $contents = array_merge($this->global_response_args, $contents);
	            if (!isset($contents['redirect']) && isset($contents['refresh']) && !empty($contents['refresh']))
	            {
                    $contents['redirect'] = buildUrl();
                    $contents['refresh'] = null;
	            }
                if (
                    (isset($this->global_response_args['dialogbox_open']) && true===$this->global_response_args['dialogbox_open']) ||
                    ($this->getContent()=='')
                ){
                    $contents['content'] = $this->renderView($this->getOption('simple_content'), array(
                        'title' => isset($this->global_response_args['dialogbox_title']) ? $this->global_response_args['dialogbox_title'] : null,
                        'content' => $this->getContent()
                    ));
                }
	        }
	        $this->renderView($this->getOption('global_template'), $contents, true);
	    }
	    exit(0);
	}
	
	public function renderView( $view=null, $params=null, $display=false )
	{
	    $view_file = rtrim($this->getOption('views_directory'), '/').'/'.$view;
		if ($view_file) 
		{
		    if (empty($params)) $params = array();
			$params['app'] =& $this;
			$params['rss_reader'] =& $this->rss_reader;
			$params['user'] =& $this->user;
	      	extract($params, EXTR_OVERWRITE);
			ob_start();
			include $view_file;
	    	$this->output = ob_get_contents();
  	  		ob_end_clean();
		} else {
      		throw new Exception(
      			sprintf('View "%s" can\'t be found! (searched in "%s")', $view, $view_file)
      		);
		}
		if ($display===true) echo $this->output;
		else return $this->output;
	}

// --------------------
// Actions Router
// --------------------

    public function redirect($action, array $args=array())
    {
        $this->distribute( $action, $args );
    }
    
	public function router()
	{
	    foreach(self::$arguments_list as $_name=>$_default)
	    {
	        $this->setArgument($_name, APP_Helper::getRequestArgument($_name, $_default));
	    }
        $action_arg = $this->getArgument('action');
        $this->distribute( $action_arg, $this->getArguments() );
	}

	protected function distribute( $route, array $args=array() )
	{
        $routing_parts = explode(':', $route);
        if (count($routing_parts)==1)
        {
            $_action = $routing_parts[0];
            $_ctrl = null;
        }
        else
        {
            $_ctrl = $routing_parts[0];
            $_action = $routing_parts[1];
        }

        $_ctrl_test = \RSS\Feeds\Reader_Options::getControllerName( $_ctrl );
        $_action_test = \RSS\Feeds\Reader_Options::getMethodName( $_action );
        if (!is_null($_ctrl_test) && class_exists($_ctrl_test))
        {
            $_ctrl_obj = new $_ctrl_test( $this );
            if (!is_null($_action_test) && method_exists($_ctrl_obj, $_action_test))
            {
                call_user_func(array($_ctrl_obj, $_action_test), $args);
            }
            else
            {
                $_ctrl_retest = \RSS\Feeds\Reader_Options::getControllerName( $_action );
                $_action_retest = \RSS\Feeds\Reader_Options::getMethodName();
                if (class_exists($_ctrl_retest) && !is_null($_action_retest) && method_exists($_ctrl_retest, $_action_retest))
                {
                    $_ctrl_reobj = new $_ctrl_retest( $this );
                    call_user_func(array($_ctrl_reobj, $_action_retest), $args);
                }
                else
                {
                    throw new RuntimeException(
                        sprintf('Requested action "%s" not found in "%s" class!', $_action, $_ctrl)
                    );
                }
            }
        }
        else
        {
            throw new RuntimeException(
                sprintf('Requested controller "%s" not found!', $_ctrl)
            );
        }

	}

}

// Endfile