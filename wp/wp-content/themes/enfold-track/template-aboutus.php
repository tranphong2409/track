<?php


/**
 * Created by JetBrains PhpStorm.
 * User: PhongTran
 * Date: 7/26/17
 * Time: 5:31 PM
 * To change this template use File | Settings | File Templates.
 */

global $avia_config;

/*
 * get_header is a basic wordpress function, used to retrieve the header.php file in your theme directory.
 */
get_header();


if (get_post_meta(get_the_ID(), 'header', true) != 'no') echo avia_title();
?>

    <div id="slideshow2"
         class="avia-section main_color avia-section-large avia-no-border-styling avia-bg-style-fixed avia-full-stretch  avia-builder-el-0  el_before_av_section  avia-builder-el-first   av-minimum-height av-minimum-height-custom container_wrap fullsize"
         style="background-repeat: no-repeat; background-image: url('/wp-content/uploads/2017/06/transport-banner-1-1500x380.jpg'); background-attachment: fixed; background-position: top center; "
         data-section-bg-repeat="stretch">
        <div class="container" style="height:365px">
            <main role="main" itemprop="mainContentOfPage"
                  class="template-page content  av-content-full alpha units">
                <div class="post-entry post-entry-type-page post-entry-384">
                    <div class="entry-content-wrapper clearfix">
                        <div style="padding-bottom:10px;color:#ffffff;"
                             class="av-special-heading av-special-heading-h2 custom-color-heading blockquote modern-quote modern-centered  avia-builder-el-1  el_before_av_hr  avia-builder-el-first  ">
                            <h2 class="av-special-heading-tag"
                                itemprop="headline"><?php _e("service-page-banner-text"); ?></h2>

                            <div class="special-heading-border">
                                <div class="special-heading-inner-border"
                                     style="border-color:#ffffff"></div>
                            </div>
                        </div>
                        <div style="height:20px"
                             class="hr hr-invisible  avia-builder-el-2  el_after_av_heading  el_before_av_textblock  ">
                            <span class="hr-inner "><span class="hr-inner-style"></span></span></div>
                        <section class="av_textblock_section" itemscope="itemscope"
                                 itemtype="https://schema.org/CreativeWork">
                            <div class="avia_textblock  av_inherit_color" style="color:#ffffff; "
                                 itemprop="text"><p
                                    style="text-align: center;"><?php _e("service-page-banner-desc"); ?></p>
                            </div>
                        </section>

                    </div>
                </div>
            </main>
            <!-- close content main element --></div>
    </div>
    <div id="breadcrumb"
         class="main_color container_wrap fullsize">
        <div class="container">

        </div>
    </div>
    <div id="about-box">
        <div class="container">
            <div style="padding-bottom:10px;font-size:40px;"
                 class="av-special-heading av-special-heading-h2  blockquote modern-quote modern-centered  avia-builder-el-7  el_before_av_one_fourth  avia-builder-el-first   av-inherit-size">
                <h2 class="av-special-heading-tag" itemprop="headline"><?php the_title(); ?></h2>

                <div class="special-heading-border">
                    <div class="special-heading-inner-border"></div>
                </div>
            </div>
            <div style="height:30px"></div>
            <div
                class="flex_column av_one_fourth first  avia-builder-el-8  el_after_av_heading  el_before_av_three_fourth  ">
                <div class="news-menu">
                    <?php wp_nav_menu(array('menu' => __("services-menu-name"), 'echo' => true)); ?>
                </div>
            </div>
            <div
                class="flex_column av_three_fourth   avia-builder-el-10  el_after_av_one_fourth  avia-builder-el-last  ">
                <?php
                /* Run the loop to output the posts.
                * If you want to overload this in a child theme then include a file
                * called loop-page.php and that will be used instead.
                */

                $avia_config['size'] = avia_layout_class('main', false) == 'entry_without_sidebar' ? '' : 'entry_with_sidebar';
                get_template_part('includes/loop', 'service');
                ?>

                <!--end content-->


            </div>
            <?php

            //get the sidebar
            $avia_config['currently_viewing'] = 'page';
//            get_sidebar();

            ?>
        </div>

    </div>
    <div id="partner">
        <div class="container">
            <div style="padding-bottom:10px;" class="av-special-heading av-special-heading-h2  blockquote modern-quote modern-centered  avia-builder-el-77  el_before_av_hr  avia-builder-el-first  "><h2 class="av-special-heading-tag" itemprop="headline"><?php _e("Partner"); ?></h2><div class="special-heading-border"><div class="special-heading-inner-border"></div></div></div>
            <?php echo do_shortcode("[av_partner columns='4' heading='' size='no scaling' border='av-border-deactivate' type='slider' animation='slide' navigation='dots' autoplay='true' interval='5' custom_class='']
[av_partner_logo id='415'][/av_partner_logo]
[av_partner_logo id='407'][/av_partner_logo]
[av_partner_logo id='406'][/av_partner_logo]
[av_partner_logo id='405'][/av_partner_logo]
[av_partner_logo id='404'][/av_partner_logo]
[/av_partner]");?>
        </div>
    </div>
    <div id="faqs"
         class="avia-section main_color avia-section-default avia-no-shadow avia-bg-style-scroll  avia-builder-el-17  el_after_av_section  avia-builder-el-last   container_wrap fullsize">
        <div class="container">
            <div class="template-page content  av-content-full alpha units">
                <div class="post-entry post-entry-type-page post-entry-384">
                    <div class="entry-content-wrapper clearfix">
                        <div style="padding-bottom:10px;font-size:40px;"
                             class="av-special-heading av-special-heading-h2  blockquote modern-quote modern-centered  avia-builder-el-18  el_before_av_hr  avia-builder-el-first   av-inherit-size">
                            <h2 class="av-special-heading-tag" itemprop="headline">FAQs</h2>

                            <div class="special-heading-border">
                                <div class="special-heading-inner-border"></div>
                            </div>
                        </div>
                        <div style="height:50px"
                             class="hr hr-invisible  avia-builder-el-19  el_after_av_heading  el_before_av_one_half  ">
                            <span class="hr-inner "><span class="hr-inner-style"></span></span></div>
                        <div
                            class="flex_column av_one_half first  avia-builder-el-20  el_after_av_hr  el_before_av_one_half  ">
                            <div
                                class="avia-image-container avia_animated_image avia_animate_when_almost_visible right-to-left av-styling-  avia-builder-el-21  avia-builder-el-no-sibling   avia-align-center  avia_start_animation avia_start_delayed_animation"
                                itemscope="itemscope" itemtype="https://schema.org/ImageObject">
                                <div class="avia-image-container-inner"><img class="avia_image "
                                                                             src="/wp-content/uploads/2017/06/FAQs-x2-300x179.jpg"
                                                                             alt="" title="FAQs-x2"
                                                                             itemprop="contentURL"></div>
                            </div>
                        </div>
                        <div
                            class="flex_column av_one_half   avia-builder-el-22  el_after_av_one_half  avia-builder-el-last  ">
                            <section class="av_textblock_section" itemscope="itemscope"
                                     itemtype="https://schema.org/CreativeWork">
                                <div class="avia_textblock " itemprop="text">
                                    <?php _e("faqs-desc"); ?>
                                </div>
                            </section>
                            <div style="height:50px"
                                 class="hr hr-invisible  avia-builder-el-24  el_after_av_textblock  el_before_av_button  ">
                                <span class="hr-inner "><span class="hr-inner-style"></span></span></div>
                            <div
                                class="avia-button-wrap avia-button-left  avia-builder-el-25  el_after_av_hr  avia-builder-el-last  ">
                                <a href="<?php echo get_permalink(get_page_by_title('FAQs')) ?>"
                                   class="avia-button  avia-icon_select-no avia-color-theme-color avia-size-small avia-position-left "><span
                                        class="avia_iconbox_title"><?php _e("Find out more"); ?></span></a></div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- close content main div --> <!-- section close by builder template -->
        </div>
        <!--end builder template-->
    </div>
<div id="feature">
    <div class="container">
        <div style="padding-bottom:10px;" class="av-special-heading av-special-heading-h2  blockquote modern-quote modern-centered  avia-builder-el-77  el_before_av_hr  avia-builder-el-first  "><h2 class="av-special-heading-tag" itemprop="headline"><?php _e("Feature news"); ?></h2><div class="special-heading-border"><div class="special-heading-inner-border"></div></div></div>
        <div>
            <?php echo do_shortcode('[feature_list]'); ?>
           </div>
    </div>
</div>




<?php get_footer(); ?>