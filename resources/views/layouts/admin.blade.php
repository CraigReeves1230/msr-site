<?php //include "../functions.php"; ?>

        <!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="https://cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>

    <title>MSR Admin</title>

    <!-- Bootstrap Core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/css/simple-sidebar.css" rel="stylesheet">

    <style>
        #imaginary_container{
            margin-top:20%; /* Don't copy this */
        }
        .stylish-input-group .input-group-addon{
            background: white !important;
        }
        .stylish-input-group .form-control{
            border-right:0;
            box-shadow:0 0 0;
            border-color:#ccc;
        }
        .stylish-input-group button{
            border:0;
            background:transparent;
        }
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div id="wrapper">

    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand">
                <a href="<?php echo route('home'); ?>">
                    MSR Home
                </a>
            </li>
            <li>
                <a href="<?php echo route('create_post'); ?>">New Post</a>
            </li>
            <li>
                <a href="<?php echo route('all_posts'); ?>">All Posts</a>
            </li>
            <li>
                <a href="<?php echo route('create_wrestler'); ?>">New Wrestler</a>
            </li>
            <li>
                <a href="{{route("all_wrestlers")}}">All Wrestlers</a>
            </li>
            <li>
                <a href="{{route("users.create")}}">New User</a>
            </li>
            <li>
                <a href="{{route("users.index")}}">All Users</a>
            </li>
            <li>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">Log Out</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">


                    @yield('content')


                </div>
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- Menu Toggle Script -->
<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>

</body>

</html>