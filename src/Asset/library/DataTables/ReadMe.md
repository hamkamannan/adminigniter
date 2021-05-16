### Manual Installation

Should you choose not to use Composer to install, you can download this repo, extract and rename this folder to **codeigniter4-datatables**. 
Then enable it by editing **app/Config/Autoload.php** and adding the **DataTables**
namespace to the **$psr4** array. For example, if you copied it into **app/Libraries**:
```php
    $psr4 = [
        'Config'      => APPPATH . 'Config',
        APP_NAMESPACE => APPPATH,
        'App'         => APPPATH,
        'DataTables'   => APPPATH .'Libraries/DataTables',
    ];
```


## Example:
This is an example code for using this library:
* PHP:
```php
<?php namespace App\Controllers;

use DataTables\DataTables;

class Home extends BaseController
{
	public function json()
	{
		return DataTables::use('users')
			->where(['role' => 'admin'])
			->hideColumns(['password'])
			->rawColumns(['bio'])
			->make(true);
	}
}
```

* Javascript
```javascript
$('#table').DataTable({
  processing: true,
  serverSide: true,
  ajax:{
    url: 'http://localhost:8080/json'
  },
  columns: [
	  {data: 'username', name: 'username'},
	  {data: 'email', name: 'email'},
	  {data: 'fullname', name: 'fullname'}
	  {data: 'bio', name: 'bio'}
  ]
});
```


## Documentation:

Now you can use this without instantiate class
```php
DataTables::use('table');
```

We did not use the POST method due to a problem with the CSRF
```php
$routes->get('datatables/json', 'Controller::method', ['as' => 'dt-json']);
```

* **Select Table**\
	Select the table that you want to use
```php
DataTables::use('table')
```

* **Set Output**\
	The default parameter is true, which is automatically return the JSON data. You can return the data's dump by passing the **false** param
```php
DataTables::use('table')
	->make(false);
```

* **Select Fields**\
	Select the sepicifics column in the table
```php
->select('username, password')
```

* **Where Clause**
```php
->where(['role' => 'user', 'active' => 1])
```

* **Join Clause**
```php
// <table>, <condition>, <type>
->join('address', 'users.id = address.uid', 'INNER JOIN')
```

* **Add Column**\
	Add custom column which is not in the table
```php
// <name>, <callback>
->addColumn('action', function($data) {
	return '<a href="/edit/'.$data->id.'">edit</a>';
})
```

* **Edit Column**\
```php
// <name>, <callback>
->editColumn('created_at', function($data) {
	return format($data);
})
```

* **Raw Columns**\
	By default, all of the data is escaped to prevent XSS. But if you want to unescape them, you can use this method
```php
->rawColumns(['bio'])
```

* **Hide Columns**\
	Hide columns from JSON output
```php
->hideColumns(['password'])
```

### Notes:

* For now, we don't use the POST method due to a problem with the CSRF

<br />

## Author's Profile:
