<?php
define("FACEBOOK_APP_ID", Setting::getValue($dbObj, 'FACEBOOK_APP_ID') ? trim(strip_tags(Setting::getValue($dbObj, 'FACEBOOK_APP_ID'))) : '');
define("FACEBOOK_ADMINS", Setting::getValue($dbObj, 'FACEBOOK_ADMINS') ? trim(strip_tags(Setting::getValue($dbObj, 'FACEBOOK_ADMINS'))) : '');
define("TWITTER_ID", Setting::getValue($dbObj, 'TWITTER_ID') ? trim(strip_tags(Setting::getValue($dbObj, 'TWITTER_ID'))) : '');
define("WEBSITE_AUTHOR", Setting::getValue($dbObj, 'COMPANY_NAME') ? trim(strip_tags(Setting::getValue($dbObj, 'COMPANY_NAME'))) : '');
define("WELCOME_MESSAGE", Setting::getValue($dbObj, 'WELCOME_MESSAGE') ? Setting::getValue($dbObj, 'WELCOME_MESSAGE') : '');
define("FACEBOOK_LINK", Setting::getValue($dbObj, 'FACEBOOK_LINK') ? trim(stripcslashes(strip_tags(Setting::getValue($dbObj, 'FACEBOOK_LINK')))) : '');
define("GOOGLEPLUS_LINK", Setting::getValue($dbObj, 'GOOGLEPLUS_LINK') ? trim(stripcslashes(strip_tags(Setting::getValue($dbObj, 'GOOGLEPLUS_LINK')))) : '');
define("LINKEDIN_LINK", Setting::getValue($dbObj, 'LINKEDIN_LINK') ? trim(stripcslashes(strip_tags(Setting::getValue($dbObj, 'LINKEDIN_LINK')))) : '');
define("TWITTER_LINK", Setting::getValue($dbObj, 'TWITTER_LINK') ? trim(stripcslashes(strip_tags(Setting::getValue($dbObj, 'TWITTER_LINK')))) : '');
define("YOUTUBE_LINK", Setting::getValue($dbObj, 'YOUTUBE_LINK') ? trim(stripcslashes(strip_tags(Setting::getValue($dbObj, 'YOUTUBE_LINK')))) : '');
define("COMPANY_HOTLINE", Setting::getValue($dbObj, 'COMPANY_HOTLINE') ? trim(stripcslashes(strip_tags(Setting::getValue($dbObj, 'COMPANY_HOTLINE')))) : '');
define("COMPANY_EMAIL", Setting::getValue($dbObj, 'COMPANY_EMAIL') ? trim(stripcslashes(strip_tags(Setting::getValue($dbObj, 'COMPANY_EMAIL')))) : '');
define("COMPANY_ADDRESS", Setting::getValue($dbObj, 'COMPANY_ADDRESS') ? Setting::getValue($dbObj, 'COMPANY_ADDRESS') : '');
define("COMPANY_NUMBERS", Setting::getValue($dbObj, 'COMPANY_NUMBERS') ? trim(stripcslashes(strip_tags(Setting::getValue($dbObj, 'COMPANY_NUMBERS')))) : '');
define("COMPANY_ACC_DETAILS", Setting::getValue($dbObj, 'COMPANY_ACC_DETAILS') ? Setting::getValue($dbObj, 'COMPANY_ACC_DETAILS') : '');
define("COMPANY_OTHER_EMAILS", Setting::getValue($dbObj, 'COMPANY_OTHER_EMAILS') ? trim(stripcslashes(strip_tags(Setting::getValue($dbObj, 'COMPANY_OTHER_EMAILS')))) : '');