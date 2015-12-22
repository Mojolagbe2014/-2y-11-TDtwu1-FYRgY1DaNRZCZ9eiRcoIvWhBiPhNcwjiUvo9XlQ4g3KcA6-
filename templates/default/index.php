<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contest Template</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="<?php echo $cfg->templateUrl; ?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $cfg->templateUrl; ?>css/tabserving_v2.css" media="screen" rel="stylesheet" type="text/css">
    <link href="<?php echo $cfg->templateUrl; ?>css/responsive.css" media="(max-width: 767px)" rel="stylesheet" type="text/css">
    <link href="<?php echo $cfg->templateUrl; ?>css/tabdesign_v2.css" media="screen" rel="stylesheet" type="text/css">
    <style id="ss_generated_css" type="text/css"> body.desktop #wrapper { width: 960px;  } </style>
    <link href="<?php echo $cfg->templateUrl; ?>css/base.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $cfg->templateUrl; ?>css/theme_default2.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $cfg->templateUrl; ?>font_awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $cfg->templateUrl; ?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $cfg->templateUrl; ?>css/facebox.css" rel="stylesheet" type="text/css"/>
    <style id="ss_custom_css" type="text/css">
        .column_border {
            padding: 2%;
        }
        body.desktop .column_border #column2 {
            margin-top: 5%;
            border-left: 1px solid;
            border-color: rgba(0, 0, 0, .25);
        }
    </style>
    <style id="customStyles"><?php echo $contestObj->css; ?></style>
</head>

<body class="web desktop">
    <div id="fb-root" class=" fb_reset">
        <div style="position: absolute; top: -10000px; height: 0px; width: 0px;">
            <div></div>
        </div>
        <div style="position: absolute; top: -10000px; height: 0px; width: 0px;">
            <div></div>
        </div>
    </div>
    <div id="wrapper">
        <div class="ss_box ss_image ss_odd" data-widget="image" id="image">
            <div class="ss_box_header ss_image_header" id="header_image">
                <h3>Header Image</h3>
            </div>
            <div class="ss_box_content ss_image_content ss_align_center" id="content_image">
                <div class="ss_image_container">
                    <img alt="" id="headerImage" class="no_hotspots" src="<?php echo $contestObj->header ? $contestObj->header : $cfg->templateUrl."images/original_ec503296c84547636b2afbf081a3041c.png"; ?>" title="">
                </div>
            </div>
            <div class="ss_box_footer ss_image_footer" id="footer_image"></div>
        </div>
        <div class="ss_container container_bg" data-widget="container" id="container">
            <div class="ss_container ss_layout ss_layout_2col column_border" data-widget="two_column" id="two_column">
                <div class="ss_container ss_layout_column" data-widget="column" id="column" style="width: 50%;">
                    <div class="ss_box ss_image ss_even" data-widget="image2" id="image2">
                        <div class="ss_box_header ss_image_header" id="header_image2">
                            <h3>sweeps image</h3>
                        </div>
                        <div class="ss_box_content ss_image_content ss_align_center" id="content_image2">
                            <div class="ss_image_container">
                                <img alt="" class="no_hotspots" id="logoImage" src="<?php echo $contestObj->logo ? $contestObj->logo : $cfg->templateUrl."images/original_original_d5be9bbb216fc983cb69d22a0c5d6dee.png"; ?>" title="">
                            </div>
                        </div>
                    </div>
                    <div class="ss_box ss_rich_text ss_odd" data-widget="rich_text" id="rich_text">
                        <div class="ss_box_header ss_rich_text_header" id="header_rich_text">
                            <h3>Intro Text</h3>
                        </div>
                        <div class="ss_box_content ss_rich_text_content" id="content_rich_text">
                            <h1 style="text-align: center;" id="prevIntro"><?php echo $contestObj->intro ? $contestObj->intro : "We're giving away an awesome prize!"; ?></h1>
                            <p style="text-align: center;" id="prevDescription"><?php echo $contestObj->description ? $contestObj->description : "That's right, and all you have to do is enter! Fill out the form and be sure to share with friends. The more the merrier!"; ?></p>
                            <h3 style="text-align: center;">Good luck!</h3>
                        </div>
                        <div class="ss_box_footer ss_rich_text_footer" id="footer_rich_text"></div>
                    </div>
                    <div class="ss_box_footer ss_image_footer" id="footer_image2">
                        <strong> <i class="fa fa-calendar"></i> Start Date:</strong> <span id="prevStartDate"><?php echo $contestObj->startDate ? str_replace("-", "@", $contestObj->startDate) : "No date available"; ?></span><br/><br/>
                        <strong> <i class="fa fa-calendar"></i> End Date:</strong> <span id="prevEndDate"><?php echo $contestObj->endDate ? str_replace("-", "@", $contestObj->endDate) : "No date available"; ?></span><br/><br/>
                        <strong> <i class="fa fa-trophy"></i> Winner(s) Announce on:</strong> <span id="prevAnnounceDate"><?php echo $contestObj->announcementDate ? str_replace("-", "@", $contestObj->announcementDate) : "No date available"; ?></span><br/><br/>
                        <strong> <i class="fa fa-trophy"></i> No of Winner(s):</strong> <span id="prevNoOfWinners"><?php echo $contestObj->winners ? $contestObj->winners : "Not specified"; ?></span>
                    </div>
                </div>
                <div class="ss_container ss_layout_column" data-widget="column2" id="column2" style="width: 50%;">
                    <div class="ss_box ss_form ss_even" data-widget="form" id="form">
                        <div class="ss_box_header ss_form_header" id="header_form">
                            <h3>Form</h3>
                        </div>
                        <div class="ss_box_content ss_form_content" id="content_form">
                            <div class="ss_form_header_msg" id="header_msg_form"></div>
                            <form action="" class="ss_form_form ss_bindable_form" id="form_form" method="post">
                                <div class="field_block email_field_block" id="form_name_block">
                                    <div class="field_block email_field_block" id="form_email_block">
                                        <label for="entrantEmail"><span class="main_field_label">Your Email:</span><span class="required">*</span>
                                        </label>
                                        <input id="entrantEmail" name="entrantEmail" type="text" class="error" required="required">
                                    </div>
                                    <label for="name"><span class="main_field_label">Your Friend's Name:</span><span class="required">*</span>
                                    </label>
                                    <input id="name" name="name" type="text" class="error" required="required">
                                </div>
                                <div class="field_block email_field_block" id="form_email_block">
                                    <label for="email"><span class="main_field_label">Your Friend's Email</span><span class="required">*</span>
                                    </label>
                                    <input id="email" name="email" type="text" class="error" required="required">
                                </div>
                                <div class="field_block custom_field_1_field_block format_rich_text_field_type_block" id="form_custom_field_1_block">
                                    <p style="text-align: center;">&nbsp;</p>
                                    <hr>
                                    <h1 style="text-align: center;">Earn extra entry points!</h1>
                                    <p style="text-align: center;">Each question you answer below gets you <span id="prevBonusPoint"><?php echo $contestObj->bonusPoint ? $contestObj->bonusPoint : ""; ?></span> extra point(s)!</p>
                                    <p style="text-align: center;">&nbsp;</p>
                                </div>
                                <div class="field_block custom_field_2_field_block select_field_type_block" id="form_custom_field_2_block">
                                    <label for="form_custom_field_2"><span class="main_field_label">Question: (Optional)</span> </label>
                                    <p><em id="prevBonusQuestion"><?php echo $contestObj->question ? $contestObj->question : "The sweepstakes extra point question goes here?"; ?></em></p>
                                </div>
                                <div class="field_block custom_field_3_field_block text_field_type_block" id="form_custom_field_3_block">
                                    <label for="answer"><span class="main_field_label">Answer: </span> <span id="prevBonusAnswer"></span></label>
                                    <input class="large valid" id="answer" name="answer" type="text">
                                </div>
                                <div class="field_block submit_field_block" id="form_submit_block"><button type="submit" class="form_submit ss_btn">Submit </button>
                                </div>
                                <div class="ss_form_message ajax_message" id="message_form"></div>
                            </form>
                            <div class="ss_form_footer_msg" id="footer_msg_form"></div>
                        </div>
                        <div class="ss_box_footer ss_form_footer" id="footer_form"></div>
                    </div>
                </div>
            </div>
            <div class="ss_container" data-widget="container2" id="container2" style="display:none;">
                <div class="ss_box ss_image ss_odd" data-widget="image3" id="image3">
                    <div class="ss_box_header ss_image_header" id="header_image3">
                        <h3>Image</h3>
                    </div>
                    <div class="ss_box_content ss_image_content ss_align_center" id="content_image3">
                        <div class="ss_image_container">
                            <img alt="" class="no_hotspots" src="<?php echo $cfg->templateUrl; ?>images/original_beach.png" title="">
                        </div>
                    </div>
                    <div class="ss_box_footer ss_image_footer" id="footer_image3"></div>
                </div>
                <div class="ss_box ss_rich_text ss_even" data-widget="rich_text2" id="rich_text2">
                    <div class="ss_box_header ss_rich_text_header" id="header_rich_text2">
                        <h3>Thanks Text</h3>
                    </div>
                    <div class="ss_box_content ss_rich_text_content" id="content_rich_text2">
                        <h1 style="text-align: center;">Thanks for entering!</h1>
                        <p style="text-align: center;">We'll announce the winners on [date]!</p>
                    </div>
                    <div class="ss_box_footer ss_rich_text_footer" id="footer_rich_text2"></div>
                </div>
            </div>
            <div class="ss_box ss_links ss_odd" data-widget="links" id="links">
                <div class="ss_box_header ss_links_header" id="header_links">
                    <h3>Links</h3>
                </div>
                <div class="ss_box_content ss_links_content ss_align_center" id="content_links">
                    <ol>
                        <li class="item0 first" id="item_0_links"><a  href="javascript:;" id="officialRules" >Official Rules</a> </li>
                        <li class="item1 last selected" id="item_1_links"><a href="javascript:;" id="thePrize">The Prize </a> </li>
                        <li class="item1 last selected" id="item_1_links"><a href="javascript:;" id="theWinners">The Winners </a> </li>
                    </ol>
                </div>
                <div class="ss_box_footer ss_links_footer" id="footer_links"></div>
            </div>
        </div>
        <div class="ss_box ss_share ss_even transparent_bg" data-widget="share" id="share">
            <div class="ss_box_header ss_share_header" id="header_share">
                <h3>Share</h3>
            </div>
            <div class="ss_box_content ss_share_content ss_align_center" id="content_share">
                <ul>
                    <li>
                        <a class="ss_share_on ss_share_on_manual" data-platform="manual" href="<?php echo $cfg->returnUrl ? $cfg->returnUrl : 'javascript:;'; ?>" style="">
                            <i class="fa fa-share-square fa-2x"></i>
                        </a>
                    </li>
                    <li>
                        <a class="ss_share_on ss_share_on_facebook" data-platform="facebook" href="<?php echo $cfg->fbLink ? $cfg->fbLink : 'javascript:;'; ?>" style="">
                            <i class="fa fa-facebook-square fa-2x"></i>
                        </a>
                    </li>
                    <li>
                        <a class="ss_share_on ss_share_on_twitter" data-platform="twitter" href="<?php echo $cfg->twitterLink ? $cfg->twitterLink : 'javascript:;'; ?>" style="">
                            <i class="fa fa-twitter-square fa-2x"></i>
                        </a>
                    </li>
                    <li>
                        <a class="ss_share_on ss_share_on_pinterest" data-platform="pinterest" href="<?php echo $cfg->pinterestLink ? $cfg->pinterestLink : 'javascript:;'; ?>" style="">
                            <i class="fa fa-pinterest-square fa-2x"></i>
                        </a>
                    </li>
                    <li>
                        <a class="ss_share_on ss_share_on_google" data-platform="google" href="<?php echo $cfg->gplusLink ? $cfg->gplusLink : 'javascript:;'; ?>" style="">
                            <i class="fa fa-google-plus-square fa-2x"></i>
                        </a>
                    </li>
                    <li>
                        <a class="ss_share_on ss_share_on_linkedin" data-platform="linkedin" href="<?php echo $cfg->linkedinLink ? $cfg->linkedinLink : 'javascript:;'; ?>" style="">
                            <i class="fa fa-linkedin-square fa-2x"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="ss_box_footer ss_share_footer" id="footer_share"></div>
        </div>
    </div>
    <div id="officialRulesOverlay" class="facebox et_pb_module et_pb_contact_form_container clearfix  et_pb_contact_form_0">
        <div><h2 class="et_pb_contact_main_title">Official Rules <button class="close" style="float:right;margin-top:-7px">X</button></h2> </div>
        <div class="et_pb_contact"><?php echo $contestObj->rules ? $contestObj->rules : "Office entry rules goes here!"; ?></div>        
    </div>
    <div id="thePrizeOverlay" class="facebox et_pb_module et_pb_contact_form_container clearfix  et_pb_contact_form_0">
        <div><h2 class="et_pb_contact_main_title">The Prize <button class="close" style="float:right;margin-top:-7px">X</button></h2> </div>
        <div class="et_pb_contact"><?php echo $contestObj->prize ? $contestObj->prize : "Prize info goes here!"; ?></div>     
    </div>
    <div id="theWinnersOverlay" class="facebox et_pb_module et_pb_contact_form_container clearfix  et_pb_contact_form_0">
        <div><h2 class="et_pb_contact_main_title">The Winners <button class="close" style="float:right;margin-top:-7px">X</button></h2> </div>
        <div class="et_pb_contact"><?php echo $contestObj->getWinners() ? $contestObj->getWinners() : "The List of winners goes here "; ?></div>
    </div>
    <script src="<?php if(strpos($_SERVER['REQUEST_URI'],'/contest')){ echo $cfg->templateUrl;} ?>js/jquery.tools.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        jQuery(document).ready(function(e) {
            jQuery("#officialRules, #thePrize, #theWinners").click(function(e) {
                e.preventDefault();
                $("#"+$(this).attr('id')+'Overlay').overlay().load();
            });
            // select the overlay element - and "make it an overlay"
            $(".facebox").overlay({top: 150,mask: {color: '#fff',loadSpeed: 200,opacity: 0.5},closeOnClick: true,load: false });
        });	
    </script>
</body>
</html>
