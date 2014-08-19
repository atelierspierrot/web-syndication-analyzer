<?php

namespace RSS\Feeds;

final class Reader_Options
    implements \RSS\Feeds_Reader_Editables_Interface
{

    public static function getEditablePreferences()
    {
        return array(
            'extract_length', 'max_items_nb', 'more_items_nb', 'default_cache_time', 'theme'
        );
    }

    public static function getArgumentsList()
    {
        return array(
            'action' => 'index', 
            'feed_url' => null, 
            'limit' => null,
            'offset' => 0,
            'scope' => null,
        );
    }
    
    public static function getDefaultOptions()
    {
        return array(
            // global defaults
            'encoding' => 'utf-8',
            'xss_flag' => ENT_QUOTES,
            'csrf_secure' => true,
            // development mode (auto-refreshing some stuff)
            'force_refresh_language_files' => false,
            // HTTP app roots
            'http_rootdir' => APP_Helper::getServerHttpRoot(),
            'http_rootfile' => APP_Helper::getServerHttpRootFile(),
            // app directories
            'assets_directory' => ASSETS_DIR, // must be relative to HTTP root
            'specifications_directory' => RSS_SRC.'specifications/',
            'views_directory' => APP_SRC.'views/',
            'temporary_directory' => ROOT_DIR.'tmp/',
            'feeds_cache_directory' => 'feeds/', // must be relative to "tmp/"
            'sessions_directory' => 'sessions/', // must be relative to "tmp/"
            'i18n_directory' => 'i18n/', // must be relative to "tmp/"
            'assets_themes_directory' => 'themes/', // must be relative to "ASSETS_DIR"
            'themes_directory' => 'www/themes/', // must be relative to ROOT_DIR
            // app files
            'feeder_config_filename' => 'feeder_config',
            'feeds_list_filename' => 'feeds_list',
            'favorites_filename' => 'favorites',
            'user_session_filename' => 'user_session',
            // language / internationalization
            'available_languages' => array( // "code ISO => 2 letters shortcut" pairs
                'fr_FR' => 'fr',
                'en_US' => 'en'
            ),
            'default_language' => 'en',
            'language_files_mask' => 'i18n.%s.php',
            'language_vars_mask' => 'i18n_%s',
            'language_strings_db_file' => 'build/app_i18n.csv', // !! this db languages file is in "build/" directory !!
            // templates settings
            'jquery_version' => '1.9.0',
            'jquery_ui_version' => '1.10.0',
            // global templates
	        'global_template' => 'template.htm',
	        'simple_content' => 'simple-content.htm',
            'form_template' => 'form-template.htm',
            'header_template' => 'header.htm',
            'footer_template' => 'footer.htm',
            'email_footer_template' => 'email/email-footer.txt',
            // page contents templates
            'error_template' => 'content-error.htm',
            'content_template' => 'content-tabs.htm',
            'overview_template' => 'content-overview.htm',
            'full_feed_template' => 'content-feed-full.htm',
            'items_feed_template' => 'content-feed.htm',
            'entry_channel_template' => 'content-entry-channel.htm',
            'entry_item_template' => 'content-entry-item.htm',
            'breadcrumb_template' => 'tag/tag-breadcrumb.htm',
            // rss tags templates
            'content_tag_template' => 'tag/tag-content.htm',
            'person_tag_template' => 'tag/tag-person.htm',
            'person_tag_widget_template' => 'tag/tag-person-widget.htm',
            'image_tag_template' => 'tag/tag-image.htm',
            'image_tag_widget_template' => 'tag/tag-image-widget.htm',
            'media_tag_template' => 'tag/tag-media.htm',
            'category_tag_template' => 'tag/tag-category.htm',
            'date_tag_template' => 'tag/tag-date.htm',
            'date_tag_widget_template' => 'tag/tag-date-widget.htm',
            // toolbars templates
            'global_toolbar_template' => 'toolbar-global.htm',
            'user_toolbar_template' => 'toolbar-user.htm',
            'item_toolbar_template' => 'toolbar-item.htm',
            'channel_toolbar_template' => 'toolbar-channel.htm',
            // dialog box templates
            'about_template' => 'dialog/dialog-about.htm',
            'navigation_tools_template' => 'dialog/dialog-navigation.htm',
            'preferences_template' => 'dialog/dialog-preferences.htm',
            'editfeed_template' => 'dialog/dialog-edit_feed.htm',
            'removefeed_template' => 'dialog/dialog-remove_feed.htm',
            'sendbyemail_template' => 'dialog/dialog-send_by_email.htm',
            'sendbyemail_email_template' => 'email/email-send_by_email.txt',
            // user management templates
            'signin_form_template' => 'user/dialog-user-signin.htm',
            'login_form_template' => 'user/dialog-user-login.htm',
            'forgot_form_template' => 'user/dialog-user-forgot.htm',
            'changepwd_form_template' => 'user/dialog-user-changepwd.htm',
            'welcome_email_template' => 'email/email-welcome.txt',
            'account_retrieve_email_template' => 'email/email-account_retrieve.txt',
            'removeuser_template' => 'dialog/dialog-remove_user.htm',
            // app management templates
            'sitemap_template' => 'sitemap.htm',
            'install_template' => 'install.htm',
            'admin_template' => 'admin.htm',
            // app themes management
            'theme' => null,
            'default_theme' => 'default',
            'themes' => array( 'default', 'classic', 'dark' ),
            'user_themes' => array(),
            'theme_file' => 'jquery-ui-%s.min.css', // sprintf with jquery_ui_version
            // rendering options
            'extract_length' => 140,
            'max_items_nb' => 15,
            'more_items_nb' => 10,
            'overview_max_items_by_feed_nb' => 5,
            'favorites_max_items_by_feed_nb' => 10,
            // cache manager
            'use_cache' => true,
            'cache_filename_mask' => '%s.xml',
            'default_cache_time' => 3600, // in seconds
            // security
            'salt' => '7fa.V|C]4]T?Bz?sFDtRrtSai=o$[2OvHYAG|4tU5%U>6L-@ZBWASF<TzUR}C[}.',
            // debugging
            'debug' => false,
        );
    }

	public static function getControllerName( $str=null )
	{
	    if (empty($str)) $str = 'Default';
        return ucfirst($str).'_Controller';
	}

	public static function getMethodName( $str=null )
	{
	    if (empty($str)) $str = 'index';
        if (is_numeric($str{0})) $str = '_'.$str;
        return $str.'Action';
	}

}

// Endfile