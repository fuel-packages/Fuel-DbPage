# A Basic Page loader Package for Fuel PHP

Load pages from a database table to make application more dynamic.

#Notes:

You must set your routes to the same page controller:

'_root_' => 'your-page-controller/index', // The default route

'_404_' => 'your-page-comtroller/index',  // The main 404 route


#Features

* Store website page contents in a database for easy management

* Automatically installs

* Load page data with one call

* Add a new page by passing an array

* Add a new page by setting the class variables

* Update a page by setting the class variables and passing the page id

* Update a page by passing the page id and an array

* Delete a page by passing the page id

* Delete a page by passing the page name


#Installation

The first time you call DbPage::load() it checks to see if the it is installed if not this package automatically creates a table for you - Default: pages


# Basic usage example:

// You have two options you can autoload the package in config:

// 'always_load'	=> 'packages'	=> array( array('dbpage'), ),

// or load it in your cms controller like so

Fuel::add_package('DbPage');

// Calling DbPage::load() will automatically create the table if it doesn't exist.

DbPage::load();

// This sets the header response normally 200 unless page not found then it's set to 404

$this->response->status = DbPage::$response_status;

$this->template->title = DbPage::$meta_title;

$this->template->keywords = DbPage::$meta_keywords;

$this->template->description = DbPage::$meta_description;

$data['page_content'] = DbPage::$content;

// You should have something like <?php echo html_entity_decode($page_content)."\n"; ?> in your page/index view

$this->template->content = View::factory('page/index', $data);