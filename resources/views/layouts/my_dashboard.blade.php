<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>

    <title>MSR My Profile - @yield('page_title')</title>

    <!-- Bootstrap Core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/css/sb-admin.css" rel="stylesheet">
    <link href="/css/search.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="/css/plugins/morris.css" rel="stylesheet">
    <link href="/css/private_messages.css" rel="stylesheet">


    <!-- Custom Fonts -->
    <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{route('home')}}">HOME</a>
        </div>
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i

                            @if($user->new_messages == 1)
                                    style="color: #50D4FD;"
                            @endif

                            class="fa fa-envelope"></i> <b class="caret"></b></a>
                <ul class="dropdown-menu message-dropdown">
                    <?php $user->new_messages = 0; ?>
                    <?php $user->save(); ?>
                    @foreach($private_messages as $pm)
                    <li class="message-preview">
                        <a href="{{route('pm_show', ['id' => $pm->id])}}">
                            <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" height="35" src="{{$pm->author()->images[0]->path}}" alt="">
                                    </span>
                                <div class="media-body">
                                    <h5 class="media-heading"><strong>{{$pm->author()->name}}</strong>
                                    </h5>
                                    <p class="small text-muted"><i class="fa fa-clock-o"></i> {{$pm->created_at->diffForHumans()}}</p>
                                    <p>{{str_limit($pm->content, 40)}}</p>
                                </div>
                            </div>
                        </a>
                    </li>
                    @endforeach


                    <li class="message-footer">
                        <a href="{{route('pm_index')}}">Read All New Messages</a>
                    </li>

                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i

                            @if($user->new_alerts == 1)
                                    style="color: #50D4FD;"
                            @endif

                            class="fa fa-bell"></i> <b class="caret"></b></a>
                <ul class="dropdown-menu alert-dropdown">
                    <?php $user->new_alerts = 0; ?>
                    <?php $user->save(); ?>
                    @foreach($alerts as $alert)
                        <li>
                            <a href="{{$alert->link}}">{{str_limit($alert->message, 50)}}
                                <span class="label label-{{$alert->type}}">{{$alert->name}}</span>
                                <br><i style="color: #9d9d9d">{{$alert->created_at->diffForHumans()}}</i></a>

                        </li>
                    @endforeach
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{$user->name}} <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{route('user_profile', ['id' => $user->id])}}"><i class="fa fa-fw fa-user"></i> Profile</a>
                    </li>
                    <li>
                        <a href="{{route('pm_index')}}"><i class="fa fa-envelope"></i> Messages</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav">
                <li class="active">
                    <a href="{{route('user_dashboard')}}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                </li>
                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> My Wrestlers <i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="demo" class="collapse">
                        <li>
                            <a href="{{route('my_wrestlers')}}">Rated Wrestlers</a>
                        </li>
                        <li>
                            <a href="{{route('my_favorites')}}">Favorites</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{route('pm_index')}}"><i class="fa fa-fw fa-envelope"></i> Private Messages</a>
                </li>
                <li>
                    <a href="{{route('dashboard_edit_user')}}"><i class="fa fa-fw fa-edit"></i> Edit Profile</a>
                </li>
                <li>
                    <a href="bootstrap-elements.html"><i class="fa fa-fw fa-desktop"></i> Bootstrap Elements</a>
                </li>
                <li>
                    <a href="bootstrap-grid.html"><i class="fa fa-fw fa-wrench"></i> Bootstrap Grid</a>
                </li>
                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Dropdown <i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="demo" class="collapse">
                        <li>
                            <a href="#">Dropdown Item</a>
                        </li>
                        <li>
                            <a href="#">Dropdown Item</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="blank-page.html"><i class="fa fa-fw fa-file"></i> Blank Page</a>
                </li>
                <li>
                    <a href="index-rtl.html"><i class="fa fa-fw fa-dashboard"></i> RTL Dashboard</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1>@yield('page_title')</h1>
                </div>
            </div>
            <hr>

            @yield('content')

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->




<!-- jQuery -->
<script src="/js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="/js/bootstrap.min.js"></script>

<!-- Morris Charts JavaScript -->
<script src="/js/raphael.min.js"></script>
<script src="/js/morris.min.js"></script>
<script src="/js/morris-data.js"></script>

</body>

</html>
