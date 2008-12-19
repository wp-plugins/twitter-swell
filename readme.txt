=== Twitter Swell ===
Contributors: icyleaf
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=N4QVYJCWXPF22&lc=US&item_name=Http%3a%2f%2ficyleaf%2ecom&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHosted
Tags: twitter,widgets,posts,form,posting
Contributors: icyleaf
Requires at least: 2.3.1
Stable tag: trunk
Tested up to: 2.7

== Description == 
You coult post message to your Twitter and show it.

== Installation  ==
1. Upload the full directory into your wp-content/plugins directory.
2. Activate the Plugin in WP-Admin. 
3. Goto Options > Twitter Swell. You must input Twitter username and password.

==  Useage ==
Terminology Agreement
1. LoginForm: Log in to Blog filled out a user name and password form.
2. TwitterForm: Send Twitter message form.
3. TweetForm: Show Twitter messages from.

Add below code to the theme where you would like it your user to twitter from:
<?php if (function_exists('WSTS_ShowTwitter')) : ?>
<?php WSTS_ShowTwitter(); ?>
<?php endif; ?>
The best place to put it would be in your theme's index.php file right above <?php if (have_posts()) : ?>

And WSTS_ShowTwitter() function can be used it with parameter! Parameter Usage:
<?php WSTS_ShowTwitter($LoginForm={true|Fals}) ?>
if using it without parameter, then it did't show LoginForm before log in to your blog.
Also, using <?php WSTS_TweetForm() ?> codes that it will show TweetForm. 

Notice: 
Make sure Don't using this plugins together with the other twitter api apps.

== History ==


== Credits ==
This plugin was inspired from the WS Audio Plauer plugin by:
icyleaf (http://www.icyleaf.cn)