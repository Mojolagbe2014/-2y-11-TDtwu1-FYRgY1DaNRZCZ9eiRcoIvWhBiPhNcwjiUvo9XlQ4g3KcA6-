<?php 
session_start();
include('config/config.php');
define("CURRENT_PAGE", "home");

$dbObj = new Database($cfg);//Instantiate database
$thisPage = new WebPage($dbObj, 'webpage'); //Create new instance of webPage class

include('includes/other-settings.php');
require('includes/page-properties.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="operator/assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="css/tabserving_v2.css" media="screen" rel="stylesheet" type="text/css">
    <link href="css/responsive.css" media="(max-width: 767px)" rel="stylesheet" type="text/css">
    <link href="css/tabdesign_v2.css" media="screen" rel="stylesheet" type="text/css">
    <style id="ss_generated_css" type="text/css">
        body.desktop #wrapper {
            max-width: 960px;
        }
    </style>
    <link href="css/base.css" rel="stylesheet" type="text/css" />
    <link href="css/theme_default2.css" rel="stylesheet" type="text/css" />
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
                    <img alt="" class="no_hotspots" src="<?php echo SITE_URL; ?>images/original_ec503296c84547636b2afbf081a3041c.png" title="">
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
                                <img alt="" class="no_hotspots" src="<?php echo SITE_URL; ?>images/original_original_d5be9bbb216fc983cb69d22a0c5d6dee.png" title="">
                            </div>
                        </div>
                        <div class="ss_box_footer ss_image_footer" id="footer_image2"></div>
                    </div>
                    <div class="ss_box ss_rich_text ss_odd" data-widget="rich_text" id="rich_text">
                        <div class="ss_box_header ss_rich_text_header" id="header_rich_text">
                            <h3>Intro Text</h3>
                        </div>
                        <div class="ss_box_content ss_rich_text_content" id="content_rich_text">
                            <h1 style="text-align: center;">We're giving away an awesome prize!</h1>
                            <p style="text-align: center;">That's right, and all you have to do is enter! Fill out the form and be sure to share with friends. The more the merrier!</p>
                            <h3 style="text-align: center;">Good luck!</h3>
                        </div>
                        <div class="ss_box_footer ss_rich_text_footer" id="footer_rich_text"></div>
                    </div>
                </div>
                <div class="ss_container ss_layout_column" data-widget="column2" id="column2" style="width: 50%;">
                    <div class="ss_box ss_form ss_even" data-widget="form" id="form">
                        <div class="ss_box_header ss_form_header" id="header_form">
                            <h3>Form</h3>
                        </div>
                        <div class="ss_box_content ss_form_content" id="content_form">
                            <div class="ss_form_header_msg" id="header_msg_form"></div>
                            <form action="" class="ss_form_form ss_bindable_form" id="form_form" method="post" novalidate="novalidate">
                                <div style="margin:0;padding:0;display:inline">
                                    <input name="authenticity_token" type="hidden" value="4Iq4FXfIfYLcggYUCGdl+TyN/6Eslj3/Gylnqno6GpU=">
                                </div>
                                <input id="simulated" name="simulated" type="hidden" value="1">
                                <input class="ss_token" id="ss_token" name="ss_token" type="hidden" value="">
                                <input class="ss_timestamp" id="ss_timestamp" name="ss_timestamp" type="hidden" value="">
                                <input class="ss_url_path" id="ss_url_path" name="ss_url_path" type="hidden" value="">
                                <input class="ss_user_agent" id="ss_user_agent" name="ss_user_agent" type="hidden" value="Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.80 Safari/537.36">
                                <input class="fb_api_version" id="fb_api_version" name="fb_api_version" type="hidden" value="2">
                                <input class="ss_avi" id="ss_avi" name="ss_avi" type="hidden">
                                <input id="referring_entry_id" name="referring_entry_id" type="hidden" value="0">
                                <div class="horizontal_container name_field_block" id="form_name_block">
                                    <label for="form_name"><span class="main_field_label">Name</span><span class="required">*</span>
                                    </label>
                                    <div class="field_block first_child first_name_field_block" id="form_first_name_block">
                                        <input id="form_first_name" name="form[first_name]" placeholder="" type="text" class="error">
                                    </div>
                                    <div class="field_block last_name_field_block" id="form_last_name_block">
                                        <input id="form_last_name" name="form[last_name]" placeholder="" type="text" class="error">
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <div class="field_block email_field_block" id="form_email_block">
                                    <label for="form_email"><span class="main_field_label">Email</span><span class="required">*</span>
                                    </label>
                                    <input id="form_email" name="form[email]" placeholder="" type="text" class="error">
                                </div>
                                <div class="field_block custom_field_1_field_block format_rich_text_field_type_block" id="form_custom_field_1_block">
                                    <p style="text-align: center;">&nbsp;</p>
                                    <hr>
                                    <h1 style="text-align: center;">Earn extra entry points!</h1>
                                    <p style="text-align: center;">Each question you answer below gets you two extra points!</p>
                                    <p style="text-align: center;">&nbsp;</p>
                                </div>
                                <div class="field_block custom_field_2_field_block select_field_type_block" id="form_custom_field_2_block">
                                    <label for="form_custom_field_2"><span class="main_field_label">Enter a question here</span>
                                    </label>
                                    <select id="form_custom_field_2" name="form[custom_field_2]" size="0" class="valid">
                                        <option value="Choice 1">Google</option>
                                        <option value="Choice 2">Yahoo</option>
                                        <option value="Choice 3">Others</option>
                                    </select>
                                </div>
                                <div class="field_block custom_field_3_field_block text_field_type_block" id="form_custom_field_3_block">
                                    <label for="form_custom_field_3"><span class="main_field_label">Question</span>
                                    </label>
                                    <input class="large valid" id="form_custom_field_3" name="form[custom_field_3]" placeholder="" type="text">
                                </div>
                                <div class="field_block submit_field_block" id="form_submit_block"><a class="form_submit ss_btn" href="#" onclick="return SST.form_submit(widget_36129236);">
Submit
</a>
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
                            <img alt="" class="no_hotspots" src="<?php echo SITE_URL; ?>images/original_beach.png" title="">
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
                    <a class="ss_btn ss_links_menu" href="#" onclick="">
                        <span></span>
                        <span></span>
                        <span></span>
                    </a>
                    <ol>
                        <li class="item0 first" id="item_0_links"><a data-action="rich_text3.popup" href="#" id="link_0_links" onclick="">Official Rules</a>
                        </li>
                        <li class="item1 last selected" id="item_1_links"><a href="#" id="link_1_links">The Prize
</a>
                        </li>
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
                        <a class="ss_share_on ss_share_on_manual" data-platform="manual" href="#" style="">
                            <i class="fa fa-share-square fa-2x"></i>
                        </a>
                    </li>
                    <li>
                        <a class="ss_share_on ss_share_on_facebook" data-platform="facebook" href="#" style="">
                            <i class="fa fa-facebook-square fa-2x"></i>
                        </a>
                    </li>
                    <li>
                        <a class="ss_share_on ss_share_on_twitter" data-platform="twitter" href="#" style="">
                            <i class="fa fa-twitter-square fa-2x"></i>
                        </a>
                    </li>
                    <li>
                        <a class="ss_share_on ss_share_on_pinterest" data-platform="pinterest" href="#" style="">
                            <i class="fa fa-pinterest-square fa-2x"></i>
                        </a>
                    </li>
                    <li>
                        <a class="ss_share_on ss_share_on_google" data-platform="google" href="#" style="">
                            <i class="fa fa-google-plus-square fa-2x"></i>
                        </a>
                    </li>
                    <li>
                        <a class="ss_share_on ss_share_on_linkedin" data-platform="linkedin" href="#" style="">
                            <i class="fa fa-linkedin-square fa-2x"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="ss_box_footer ss_share_footer" id="footer_share"></div>
        </div>
    </div>
    <ul id="ss_cimico" style="display:none;"></ul>
</body>
</html>