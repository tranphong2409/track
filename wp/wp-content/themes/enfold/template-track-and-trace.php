                                <?php 
                                $sLang = pll_current_language();
    $sUrlLink = "/track-and-trace/";
    if($sLang === "vi"){
        $sUrlLink = "/vi/tra-cuu/";
    }
    
                                ?>
<div class="flex_column av_one_third first  avia-builder-el-6  el_after_av_hr  el_before_av_two_third  ">
    <section class="avia_codeblock_section avia_code_block_1" itemscope="itemscope" itemtype="https://schema.org/CreativeWork">
        <div class="avia_codeblock track-searchbox" itemprop="text">
            <div class="track">
                <button onClick="jQuery('#traceForm').submit();">Track & Trace</button>
                <form id="traceForm" action="<?php echo $sUrlLink; ?>" method="get">
                <div class="input-field">
                    <input class="text-box" type="text" name="code" placeholder="<?php echo $data['code']; ?>">
                </div>
                </form>
            </div>
        </div>
    </section>
    <div class="av-catalogue-container  avia-builder-el-8  el_after_av_codeblock  avia-builder-el-last  ">
        <ul class="av-catalogue-list">
            <li>
                <div class="av-catalogue-item">
                    <div class="av-catalogue-item-inner">
                        <div class="av-catalogue-title-container">
                            <div class="av-catalogue-title">Awb.No</div>
                            <div class="av-catalogue-price"></div>
                        </div>
                        <div class="av-catalogue-content">
                            <em><strong><?php echo $data['code']; ?></strong></em>
                            <br>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="av-catalogue-item">
                    <div class="av-catalogue-item-inner">
                        <div class="av-catalogue-title-container">
                            <div class="av-catalogue-title">Destination</div>
                            <div class="av-catalogue-price"></div>
                        </div>
                        <div class="av-catalogue-content">
                            <em><strong><?php echo $data['info'][0]->main_destination; ?></strong></em>
                            <br>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="av-catalogue-item">
                    <div class="av-catalogue-item-inner">
                        <div class="av-catalogue-title-container">
                            <div class="av-catalogue-title">Origin</div>
                            <div class="av-catalogue-price"></div>
                        </div>
                        <div class="av-catalogue-content">
                            <em><strong><?php echo $data['info'][0]->main_origin; ?></strong></em>
                            <br>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="av-catalogue-item">
                    <div class="av-catalogue-item-inner">
                        <div class="av-catalogue-title-container">
                            <div class="av-catalogue-title">Status</div>
                            <div class="av-catalogue-price"></div>
                        </div>
                        <div class="av-catalogue-content">
                            <?php
                            switch($data['info'][0]->main_status){
                                case "process":
                                    $status = "Đang tiến hành";break;
                                case "error":
                                    $status = "Lỗi";break;
                                case "resolve":
                                    $status = "Hoàn thành";break;
                                default:
                                    $status = "";
                            }
                            ?>
                            <em><strong><?php echo $status; ?></strong></em>
                            <br>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="av-catalogue-item">
                    <div class="av-catalogue-item-inner">
                        <div class="av-catalogue-title-container">
                            <div class="av-catalogue-title">Note</div>
                            <div class="av-catalogue-price"></div>
                        </div>
                        <div class="av-catalogue-content">
                            <em><strong><?php echo $data['info'][0]->note; ?></strong></em>
                            <br>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
<div class="flex_column av_two_third   avia-builder-el-9  el_after_av_one_third  avia-builder-el-last  ">
    <section class="avia_codeblock_section avia_code_block_2" itemscope="itemscope" itemtype="https://schema.org/CreativeWork">
        <div class="avia_codeblock " itemprop="text">
            <div class="tracking-info">
                <ul class="avia-icon-list avia-icon-list-left avia_animate_when_almost_visible avia_start_animation">
                  
                    <?php foreach($data['info'] as $vals): ?>
                        <?php $timeExport = explode(' ',$vals->time); ?>
                    <?php
                            switch($vals->status_item){
                                case "process":
                                    $icon = "";
                                    $style = "";
                                    $status = "Đang tiến hành";break;
                                case "error":
                                    $icon = "";
                                    $style = "background-color:#d54e21;";
                                    $status = "Lỗi";break;
                                case "resolve":
                                    $icon = "";
                                    $style  = "background-color:#fab704;";
                                    $status = "Hoàn thành";break;
                                default:
                                    $icon = "";
                                    $style = "";
                                    $status = "";
                            }
                            ?>
                    <li class="avia_start_animation">
                        <div class="timer iconlist_title">
                            <h4 class="iconlist_title"><?php echo $timeExport[0]; ?></h4>
                            <div class="hightlight" hightlight=""><?php echo $timeExport[1]; ?></div>
                        </div>
                        <div style="<?php echo $style; ?>" class="iconlist_icon avia-font-entypo-fontello">
                            <span class="iconlist-char" aria-hidden="true" data-av_icon="<?php echo $icon; ?>" data-av_iconfont="entypo-fontello"></span>
                        </div>
                        <article class="article-icon-entry " itemscope="itemscope" itemtype="https://schema.org/CreativeWork">
                            <div class="iconlist_content_wrap">
                                <header class="entry-content-header">
                                    <h4 class="iconlist_title" itemprop="headline"><?php echo $vals->location_item; ?></h4></header>
                                <div class="iconlist_content " itemprop="text">
                                    <p><?php echo $vals->note_item; ?></p>
                                </div>
                            </div>
                            <footer class="entry-footer"></footer>
                        </article>
                        <div class="iconlist-timeline"></div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>
</div>