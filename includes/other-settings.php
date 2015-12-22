<?php
$cfg->fbAppId = Setting::getValue($dbObj, 'FACEBOOK_APP_ID') ? trim(strip_tags(Setting::getValue($dbObj, 'FACEBOOK_APP_ID'))) : '';
$cfg->fbAdmins = Setting::getValue($dbObj, 'FACEBOOK_ADMINS') ? trim(strip_tags(Setting::getValue($dbObj, 'FACEBOOK_ADMINS'))) : '';
$cfg->fbLink = Setting::getValue($dbObj, 'FACEBOOK_LINK') ? trim(stripcslashes(strip_tags(Setting::getValue($dbObj, 'FACEBOOK_LINK')))) : '';
$cfg->twitterId = Setting::getValue($dbObj, 'TWITTER_ID') ? trim(strip_tags(Setting::getValue($dbObj, 'TWITTER_ID'))) : '';
$cfg->twitterLink = Setting::getValue($dbObj, 'TWITTER_LINK') ? trim(stripcslashes(strip_tags(Setting::getValue($dbObj, 'TWITTER_LINK')))) : '';
$cfg->author = Setting::getValue($dbObj, 'COMPANY_NAME') ? trim(strip_tags(Setting::getValue($dbObj, 'COMPANY_NAME'))) : '';
$cfg->gplusLink = Setting::getValue($dbObj, 'GOOGLEPLUS_LINK') ? trim(stripcslashes(strip_tags(Setting::getValue($dbObj, 'GOOGLEPLUS_LINK')))) : '';
$cfg->linkedinLink = Setting::getValue($dbObj, 'LINKEDIN_LINK') ? trim(stripcslashes(strip_tags(Setting::getValue($dbObj, 'LINKEDIN_LINK')))) : '';
$cfg->youTubeLink = Setting::getValue($dbObj, 'YOUTUBE_LINK') ? trim(stripcslashes(strip_tags(Setting::getValue($dbObj, 'YOUTUBE_LINK')))) : '';
$cfg->pinterestLink = Setting::getValue($dbObj, 'PINTEREST_LINK') ? trim(stripcslashes(strip_tags(Setting::getValue($dbObj, 'PINTEREST_LINK')))) : '';
$cfg->returnUrl = Setting::getValue($dbObj, 'RETURN_URL') ? trim(stripcslashes(strip_tags(Setting::getValue($dbObj, 'RETURN_URL')))) : '';
$cfg->companyEmail = Setting::getValue($dbObj, 'COMPANY_EMAIL') ? trim(stripcslashes(strip_tags(Setting::getValue($dbObj, 'COMPANY_EMAIL')))) : '';