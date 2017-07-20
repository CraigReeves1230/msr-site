<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- JQuery -->
    <script
            src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
            crossorigin="anonymous"></script>

    <!-- Bootstrap Javascript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"
            integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"
            integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn"
            crossorigin="anonymous"></script>


    <title>Match Star Rater - Community - @yield('page_title')</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css"
          integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

    <!-- Custom Fonts -->
    <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Anton|Archivo+Black|Crete+Round|News+Cycle|Nunito+Sans" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script>
        window.Laravel = {!! json_encode([
                    'csrfToken' => csrf_token(),
        ]) !!};
    </script>

    <!-- Community page CSS -->
    <link rel="stylesheet" href="/css/community_home.css">

</head>

<body>

    <div class="container-fluid search-main">
        <div class="row">
            <div class="search-bar col-9 offset-9 ">
                <div class="search-area col-sm-5 col-md-3">
                    <div class="input-group search-input-group">
                        <input type="text" class="form-control search-field" placeholder="Search..." name="q">
                        <a href="#" class="input-group-addon search-button btn-primary"><i class="fa fa-search search-icon"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation bar -->
    <nav class="navigation navbar ">
        <div class="row">
            <div class="col-2">
                <a class="nav-link" href={{route('home')}}><i class="fa fa-home"></i> BACK TO MAIN SITE</a>
            </div>
            <div class="col-10">
                <ul class="nav justify-content-end">
                    <li class="nav-item"><a class="nav-link" href="#">HOME</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">FORUM</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">COMMUNITY RATINGS</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">PODCAST</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">FEATURED COLUMNS</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">CRAIG REEVES</a></li>
                </ul>
            </div>
        </div>
    </nav><!-- end navigation -->


    <!-- title -->
    <header>
        <div class="container-fluid">
            <div class="row">
                <div style="background-image: url('@yield('image')')" class="title col-12">
                    <div class="header-text display-1">MSR Community</div>
                </div>
            </div>
        </div>
    </header><!-- end title -->

    <div class="site-body container">
        <div class="row">

            <div class="news-section col-3 offset-1">

                <!-- latest news -->
                <div class="news-card">
                    <h2>LATEST NEWS</h2>
                    <div class="news-box">
                        <img class="img-fluid" src="/img/sd_ladies.jpg">
                        <div class="news-post">
                            <div class="news-title">
                                <h3>Becky Lynch Moves to Smackdown</h3>
                            </div>
                            <hr>
                            <div class="news-article">
                                <p>
                                    Vivamus in nibh eget sapien tincidunt posuere. Pellentesque consectetur sollicitudin sollicitudin.
                                    Aenean euismod odio quis dolor mattis bibendum. Mauris id luctus ante, non sollicitudin sapien.
                                </p>
                                <a class="btn btn-primary" href="#">Full Story</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- latest podcast -->
                    <div class="news-card">
                        <h2>LATEST PODCAST</h2>
                        <div class="news-box">
                            <img class="img-fluid" src="/img/JoeAndBrock.jpg">
                            <div class="news-post">
                                <div class="news-title">
                                    <h3>Dinner with Craig and Taylor</h3>
                                </div>
                                <hr>
                                <div class="news-article">
                                    <p>
                                        We review what was an eventful Great Balls of Fire pay-per-view.
                                    </p>
                                    <a class="btn btn-primary" href="#">Listen Here</a>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

            <!-- recent discussion -->
            <div class="article-section col-4">
                    <h1 class="article-title">RECENT DISCUSSION</h1>
                <div class="post">
                    <span class="post-title">Is Roman Reigns the best in the world?</span>
                    <div class="post-author">by Remus</div>
                    <p class="post-text">Vivamus in nibh eget sapien tincidunt posuere. Pellentesque consectetur sollicitudin sollicitudin.
                        Aenean euismod odio quis dolor mattis bibendum. Mauris id luctus ante, non sollicitudin sapien.
                        Vivamus suscipit auctor elementum...
                    </p>
                    <hr>
                </div>

                <div class="post">
                    <span class="post-title">Turns out the Mae Young Classic was nothing more than a promo
                    for Ronda Rousey and her three friends...</span>
                    <div class="post-author">by Greg</div>
                    <p class="post-text">Vivamus in nibh eget sapien tincidunt posuere. Pellentesque consectetur sollicitudin sollicitudin.
                        Aenean euismod odio quis dolor mattis bibendum. Mauris id luctus ante, non sollicitudin sapien.
                        Vivamus suscipit auctor elementum...
                    </p>
                    <hr>
                </div>

                <div class="post">
                    <span class="post-title">Some people need to keep their mouths shut.</span>
                    <div class="post-author">by Rhodes Scholar</div>
                    <p class="post-text">Vivamus in nibh eget sapien tincidunt posuere. Pellentesque consectetur sollicitudin sollicitudin.
                        Aenean euismod odio quis dolor mattis bibendum. Mauris id luctus ante, non sollicitudin sapien.
                        Vivamus suscipit auctor elementum...
                    </p>
                    <hr>
                </div>
            </div><!-- end recent discussion -->
            

            <div class="aside col-3">

                <!-- top ten wrestlers -->
                <div class="top-wrestlers">
                    <h2>TOP WRESTLERS</h2>
                    <h2>Community Ratings</h2>
                    <table class="rankings-table table table-hover table-sm">
                        <thead>
                          <tr>
                            <th></th>
                            <th align="center">Wrestler</th>
                            <th align="center">Avg. Score</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1.</td>
                            <td>Kenny Omega</td>
                            <td>172</td>
                          </tr>
                          <tr>
                            <td>2.</td>
                            <td>Kazuchika Okada</td>
                            <td>169</td>
                          </tr>
                          <tr>
                            <td>3.</td>
                            <td>A.J. Styles</td>
                            <td>164</td>
                          </tr>
                          <tr>
                              <td>4.</td>
                              <td>Tetsuya Naito</td>
                              <td>156</td>
                          </tr>
                          <tr>
                              <td>5.</td>
                              <td>Ricochet</td>
                              <td>152</td>
                          </tr>
                          <tr>
                              <td>6.</td>
                              <td>Io Shirai</td>
                              <td>152</td>
                          </tr>
                          <tr>
                              <td>7.</td>
                              <td>Shinsuke Nakamura</td>
                              <td>152</td>
                          </tr>
                          <tr>
                              <td>8.</td>
                              <td>Meiko Satomura</td>
                              <td>147</td>
                          </tr>
                          <tr>
                              <td>9.</td>
                              <td>Seth Rollins</td>
                              <td>147</td>
                          </tr>
                          <tr>
                              <td>10.</td>
                              <td>Kairi Hojo</td>
                              <td>147</td>
                          </tr>
                        </tbody>
                      </table>
                    <span class="see-more"><a href="#">See More Rankings</a></span>
                </div>

                <div class="news-card">
                    <h2>FEATURED COLUMN</h2>
                    <div class="news-box">
                        <img class="img-fluid" src="/img/Emma.jpg">
                        <div class="news-post">
                            <div class="news-title">
                                <h3>WWE is Wasting Emma and it's a Total Shame</h3>
                                <h6 class="card-author">by Ryan</h6>
                            </div>
                            <div class="news-article">
                                <p>
                                    Vivamus in nibh eget sapien tincidunt posuere. Pellentesque consectetur sollicitudin sollicitudin.
                                    Aenean euismod odio quis dolor mattis bibendum. Mauris id luctus ante, non sollicitudin sapien.
                                    Vivamus suscipit auctor elementum...
                                </p>
                                <a class="btn btn-primary" href="#">Read Full</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end top ten wrestlers -->

        </div>
    </div>

</body>
















