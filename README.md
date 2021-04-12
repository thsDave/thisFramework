# thisFramework 🗂️

"thisFramework" is a personal project for those who are starting in the world of software development and want to refine their knowledge of object-oriented programming, library use, etc.

If you know about good development practices and you find one or many bugs, errors or bad practices that need to be modified or eliminated, I would greatly appreciate your help to improve this project.

> If you want to use this framework for your personal projects, feel free to do so and adhere to the terms established in the [LICENSE](LICENSE) file.

# How to use it 🛠️

* Clone the repo at the root of your projects.
```
git clone https://github.com/thsDave/thisFw thisframework
```
* Edit the `config.php` file in `app/config/` and set your database parameters, project URL, etc.
* Edit the .htaccess file and set the modified URL in config.php.
* Execute the .sql files found in `app/config/data/`.
```
Default user with "Sudo" permission 👉 user: sudo@this.com | password: sudosu
```
> Note: You can change the credentials in `inserts.sql`

## Models, Views and Controllers 📚

The models, views and controllers within the project are based on the specific user level name that is registered in the database, therefore these files and folders need to be edited or added as follows:

> As an example, we will create the user level "Customer"


### In Models 🗃️

Create the following php file in the `app/models/` folder with the exact name of the user level. Then set the class with the same file name by requesting the main model class and extending it within the current class.

```php
<?php

require_once 'Model.php';

class Customer extends Model
{
	//Methods and vars
}
```

### In Controllers ⚙️

Create the following php file in the `app/controllers/` folder with the exact name of the user level adding the word "Controller". Then configure the class with the same file name by requesting the user-level class created earlier and extending it within the current class. Then instantiate the controller and model classes within the file and copy and paste the following code.

```php
<?php

require_once APP.'/models/Customer.php';

class CustomerController extends Customer {
  //Methods and vars
}

$customer_m = new Customer;

$customer_c = new CustomerController;

if (isset($_GET['event']))
{
	$method_name = $_GET['event'];
	$val = (isset($_GET['val'])) ? $_GET['val']:null;

	if (method_exists($employee_c, $method_name))
	{
		if (is_null($val))
			$customer_c->$method_name();
		else
			$customer_c->$method_name($val);
	}
	if (method_exists($objHome, $method_name))
	{
		if (is_null($val))
			$objHome->$method_name();
		else
			$objHome->$method_name($val);
	}
	else
	{
		load_view('404');
	}
}
```

### In Views 👁️

Create the folder with the exact name of the user level in `app/views/` then create a file with the name `starter.php` inside it. Then, inside the starter.php file paste the following code.

```php
<?php require_once APP."/views/master/header.php"; ?>

<!-- overlayScrollbars -->
<link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

<?php require_once APP."/views/master/{$_SESSION['log']['level']}-nav.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Welcome <?= $_SESSION['log']['name'] ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Página inicial</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- Main content -->

  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<?php require_once APP."/views/master/footer_js.php"; ?>

<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="plugins/raphael/raphael.min.js"></script>
<script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>

<?php require_once APP."/views/master/footer_end.php"; ?>
```

For general views use this code.

```php
<?php require_once APP."/views/master/header.php"; ?>

<?php require_once APP."/views/master/{$_SESSION['log']['level']}-nav.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Title</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= URL ?>?request=home">Home</a></li>
              <li class="breadcrumb-item active">View</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <p>Your content here.</p>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<?php require_once APP."/views/master/footer_js.php"; ?>

<?php require_once APP."/views/master/footer_end.php"; ?>

```

### Views structure 👁️ 📂

    .
    ├── ...
    ├── views                         # Content of views
    │   ├── Customer                  # User level
    │   │   ├── starter.php           # Home view
    │   │   ├── otherview.php         # Other view
    │   │   └── ...                   # etc.
    │   │
    │   ├── master                    # Master pages
    │   │   ├── Customer-nav.php      # User level navigator
    │   │   ├── Sudo-nav.php          # User level navigator
    │   │   ├── header.php            # Header view
    │   │   ├── footer_js.php         # Footer view
    │   │   ├── footer_end.php        # End of footer view
    │   │   ├── profile.php           # Profile view
    │   │   ├── support.php           # Support view
    │   │   └── info.php              # Info view
    │   │
    │   └── starter                   # System startup views
    │       ├── forgot-password.php   # Password reset request
    │       ├── login.php             # Login view
    │       ├── register.php          # Register view
    │       └── reset.php             # Password reset view
    └── ...


## Firebase settings 🔥

Enable social network access in the config.php file in `app/config/`
```php
const LC_LOGIN = true; //Local login
const FB_LOGIN = true; //Facebook login
const GL_LOGIN = true; //Google login
const MS_LOGIN = false; //Microsoft login
const TW_LOGIN = false; //Twitter login
const GH_LOGIN = false; //Github login
```
Edit the `socialconfig.js` file in `dist/js/` and set the parameters of your Firebase project and set the project URL.
```js
export const data = {
  apiKey: "RIzWSyfLPowOV1Oq2U4PSETBT_TigdYeehUJzxM",
  authDomain: "login-rt6548.firebaseapp.com",
  projectId: "login-rt6548",
  storageBucket: "login-rt6548.appspot.com",
  messagingSenderId: "548264215874",
  appId: "1:548264215874:web:shwo8621aii92145dce6df8",
  measurementId: "G-1FBSsdVC7QWEK"
};

export const url = 'http://localhost/thisframework/';
```

## Automatic task settings ⏲️

* Edit the `config.php` file in `app/cronos/config/` and set your database parameters, project URL, etc.
* Create the necessary methods for the actions you want to perform in "TasksController.php".
```php
public function sayhi($hi) { echo $hi; }
```
* Add your task in `app/cronos/cron/tasks.php` with the following code.
```php
<?php
require_once 'main.php';
$task->sayhi('Hi! im use thisframework');
```
> If you add another controllers, you must add those calls in `main.php`.
* Now create your scheduled tasks by calling the task files hosted in `app/cronos/cron`.


## License 📑

thisFramework is open source software under the GPL v3.0 license. Please see full terms in the [LICENSE](LICENSE) file.