<div>
<footer class="section section-primary">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <h1>¯\_(ツ)_/¯</h1>
                        <p><?php
                                echo howManyPosts() . ' posts so far!';
                            ?>
                        </p>
                        <p><?php echo '<i class="fa fa-copyright"></i> 2014-' . date("Y") . ' ' . $copyrightName; ?></p>
                    </div>
                    <div class="col-sm-6">
                        <p class="text-info text-right">
                            <br>
                            <br>
                        </p>
                        <div class="row">
                            <div class="col-md-12 hidden-lg hidden-md hidden-sm text-left">
                                <a href="<?php echo $rootURL;?>"><i class="fa fa-3x fa-fw fa fa-home text-inverse"></i></a>
                                <a href="http://twitter.com/<?php echo $twitterUsername; ?>"><i class="fa fa-3x fa-fw fa-twitter text-inverse"></i></a>
                                <a href="<?php echo $rootURL;?>/rss"><i class="fa fa-3x fa-fw hub text-inverse fa-rss"></i></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 hidden-xs text-right">
                                <a href="<?php echo $rootURL;?>"><i class="fa fa-3x fa-fw fa fa-home text-inverse"></i></a>
                                <a href="http://twitter.com/<?php echo $twitterUsername; ?>"><i class="fa fa-3x fa-fw fa-twitter text-inverse"></i></a>
                                <a href="<?php echo $rootURL;?>/rss"><i class="fa fa-3x fa-fw hub text-inverse fa-rss"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    </body>
    </html>