<?php

namespace DbPage;

// ------------------------------------------------------------------------

/**
 * CmsPage
 *
 * @package		Fuel
 * @subpackage	DbPage
 * @author		Phil Foulston
 */

class DbPage {

	/**
	 * @var	cms table name
	 */
	public static $table = null;

    /**
	 * @var	page id
	 */
    public static $id = null;

    /**
	 * @var	responce status
	 */
    public static $response_status = 200;

   	/**
	 * @var	page name
	 */
    public static $page = null;

    /**
	 * @var	page parameters
	 */
    public static $parameters = null;

	/**
	 * @var	page title
	 */
    public static $meta_title;

    /**
	 * @var	page keywords
	 */
    public static $meta_keywords;

    /**
	 * @var	page description
	 */
    public static $meta_description;

    /**
	 * @var	page content
	 */
    public static $content;

    /**
	 * @var	page status
	 */
    public static $status;

	public static function _init()
	{
	   	\Config::load('dbpage', true);
		static::$table  = \Config::get('dbpage.db.table', 'pages');
		$installed      = \Config::get('dbpage.db.installed', false);

		if ( ! $installed)
		{
			if ( ! static::_install_db())
			{
				throw new \Exception('Could not create db pages table.');
			}

			\Config::set('dbpage.db', array('table' => static::$table, 'installed' => true));
			\Config::save('dbpage', \Config::get('dbpage'));
		}
	}

    public static function load()
    {
        $segments = explode ('/', \Uri::detect (), 2);
        $page = (!empty ($segments [0])) ? $segments [0] : 'home';
        $parameters = (!empty ($segments [1])) ? $segments [1] : null;

        $result = \DB::select ('*')
                ->from ('pages')
                ->where ('page', $page)
                ->where ('status', true)
                ->limit (1)
                ->execute ()
                ->current ();

        if (!$result)
        {
            static::$response_status = 404;
            $result = \DB::select ('*')
                ->from ('pages')
                ->where ('page', '404')
                ->limit (1)
                ->execute ()
                ->current ();
        }

        static::$page =                 $page;
        static::$parameters =           $parameters;
        static::$meta_title =           $result['meta_title'];
        static::$meta_keywords =        $result['meta_keywords'];
        static::$meta_description =     $result['meta_description'];
        static::$content =              $result['content'];
        static::$status =               $result['status'];
    }


	private static function _install_db()
	{
		$rows = \DBUtil::create_table(static::$table, array(
			'id'                => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'page'              => array('constraint' => 255, 'type' => 'varchar', 'null' => false),
            'meta_title'        => array('constraint' => 255, 'type' => 'varchar', 'null' => false),
            'meta_keywords'     => array('constraint' => 255, 'type' => 'varchar', 'null' => false),
            'meta_description'  => array('type' => 'text', 'null' => false),
            'content'           => array('type' => 'text', 'null' => false),
            'status'            => array('constraint' => 1, 'type' => 'int', 'default' => 0, 'null' => false),
		), array('id'));

        if($rows > 0)
        {
          $page = array(
                'page' => '404',
                'meta_title' => 'Page can not be found',
                'meta_keywords' => 'Page can not be found',
                'meta_description' => 'Page can not be found',
                'content' => '<h1>Page can not be found!</h1>',
                'status' => 1,
            );
          \DB::insert(static::$table)
                ->set($page)
                ->execute();

          $page = array(
                'page' => 'home',
                'meta_title' => 'Home Page',
                'meta_keywords' => 'Home Page',
                'meta_description' => 'Home Page',
                'content' => '<h1>Insert your content...</h1>',
                'status' => 1,
            );
          \DB::insert(static::$table)
                ->set($page)
                ->execute();

          return true;
        }

		return false;
	}
}