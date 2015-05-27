<?php echo $header; ?>
<div class="row" style="margin-top: 40px;">
     <div class="col-md-3" style="padding: 4px;">
          <div class="col-md-12 box-shadow" style="padding: 4px;">
               <div class="row">
                    <?php echo $column_left; ?>
               </div>
               <div class="row">
                    <?php echo $column_right; ?>
               </div>

          </div>
     </div>
     <div class="col-md-9">
          <div class="col-md-12 box-shadow" style="padding: 4px;">
               <?php if ($success) { ?>
               <div class="success"><?php echo $success; ?></div>
               <?php } ?>

               <div id="s-page-content" class="s-row">

                    <div id="content" class="s-pc-c-center">
                         <?php if(!$isCustomerPayed) { ?>
                         <div class="error" style="font-size: large;"><?php echo $text_user_not_payed; ?></div>
                         <div class="error" style="font-size: large;"><a href="<?php echo $buy_plan_link; ?>" class="error" style="font-size: large;"><?php echo $text_link; ?></a> </div>
                         <?php } ?>
                         <?php echo $content_top; ?>
                         <div class="breadcrumb s-pc-c-c-bread">
                              <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                              <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
                              <?php } ?>
                         </div><br />
                         <h2><?php echo $heading_title; ?></h2>
                         <div class="content">
                              <div class="a-rows">
                                   <a href="<?php echo $edit ?>" >
                                        <div class="a-box">
                                             <i class="flaticon-authorship"></i><br />
                                             <?php echo $text_edit   ?>
                                        </div>
                                   </a>
                                   <a href="<?php echo $password  ?>" >
                                        <div class="a-box">
                                             <i class="flaticon-ssl"></i><br />
                                             <?php echo $text_password   ?>
                                        </div>
                                   </a>
                                   <a href="<?php echo $wishlist   ?>" >
                                        <div class="a-box">
                                             <i class="flaticon-retina"></i><br />
                                             <?php echo $text_wishlist   ?>
                                        </div>
                                   </a>
                                   <a href="<?php echo $address   ?>" >
                                        <div class="a-box">
                                             <i class="flaticon-scripting"></i><br />
                                             <?php echo $text_address   ?>
                                        </div>
                                   </a>
                                   <a href="<?php echo $newsletter   ?>" >
                                        <div class="a-box">
                                             <i class="flaticon-email6"></i><br />
                                             <?php echo $text_newsletter   ?>
                                        </div>
                                   </a>
                                   <a href="<?php echo $ad   ?>" >
                                        <div class="a-box">
                                             <i class="flaticon-space1"></i><br />
                                             <?php echo $text_ad   ?>
                                        </div>
                                   </a>
                              </div>
                              <?php if ($Customer_Group_Id ==2) {
                          if(!$isCustomerPayed) { ?>
                              <div class="a-rows">
                                   <h2><?php echo $text_profile   ?></h2>
                              </div>
                              <div class="a-rows">
                                   <a href="#" >
                                        <div class="a-box">
                                             <i class="flaticon-career"></i><br />
                                             <?php echo $text_menu_profiles   ?>
                                        </div>
                                   </a>
                                   <a href="#" >
                                        <div class="a-box">
                                             <i class="flaticon-services"></i><br />
                                             <?php echo $text_menu_sub_profiles   ?>
                                        </div>
                                   </a>
                                   <a href="#" >
                                        <div class="a-box">
                                             <i class="flaticon-recovery"></i><br />
                                             <?php echo $text_menu_add_products   ?>
                                        </div>
                                   </a>
                                   <a href="#" >
                                        <div class="a-box">
                                             <i class="flaticon-seo12"></i><br />
                                             <?php echo $text_menu_set_prices   ?>
                                        </div>
                                   </a>
                                   <a href="#" >
                                        <div class="a-box">
                                             <i class="flaticon-like3"></i><br />
                                             <?php echo $text_menu_set_discounts   ?>
                                        </div>
                                   </a>
                                   <!--
                                   <div class="a-box">
                                        <i class="flaticon-seo1"></i><br />
                                        <?php echo $text_menu_pofiles_stat   ?>
                                   </div>
                                   <div class="a-box">
                                        <i class="flaticon-affiliate"></i><br />
                                        <?php echo $text_menu_bank   ?>
                                   </div>
                                   -->
                                   <a href="#" >
                                        <div class="a-box">
                                             <i class="flaticon-active"></i><br />
                                             <?php echo $text_menu_namads   ?>
                                        </div>
                                   </a>
                              </div>
                              <?php }else{ ?>
                              <div class="a-rows">
                                   <h2><?php echo $text_profile   ?></h2>
                              </div>
                              <div class="a-rows">
                                   <a href="<?php echo $profile   ?>" >
                                        <div class="a-box">
                                             <i class="flaticon-career"></i><br />
                                             <?php echo $text_menu_profiles   ?>
                                        </div>
                                   </a>
                                   <a href="<?php echo $subprofile   ?>" >
                                        <div class="a-box">
                                             <i class="flaticon-services"></i><br />
                                             <?php echo $text_menu_sub_profiles   ?>
                                        </div>
                                   </a>
                                   <a href="<?php echo $allsubprofiles   ?>" >
                                        <div class="a-box">
                                             <i class="flaticon-recovery"></i><br />
                                             <?php echo $text_menu_add_products   ?>
                                        </div>
                                   </a>
                                   <a href="<?php echo $price   ?>" >
                                        <div class="a-box">
                                             <i class="flaticon-seo12"></i><br />
                                             <?php echo $text_menu_set_prices   ?>
                                        </div>
                                   </a>
                                   <a href="<?php echo $rebate   ?>" >
                                        <div class="a-box">
                                             <i class="flaticon-like3"></i><br />
                                             <?php echo $text_menu_set_discounts   ?>
                                        </div>
                                   </a>
                                   <!--
                                   <div class="a-box">
                                        <i class="flaticon-seo1"></i><br />
                                        <?php echo $text_menu_pofiles_stat   ?>
                                   </div>
                                   <div class="a-box">
                                        <i class="flaticon-affiliate"></i><br />
                                        <?php echo $text_menu_bank   ?>
                                   </div>
                                   -->
                                   <a href="<?php echo $etrust   ?>" >
                                        <div class="a-box">
                                             <i class="flaticon-active"></i><br />
                                             <?php echo $text_menu_namads   ?>
                                        </div>
                                   </a>
                              </div>
                              <?php } ?>
                              <?php } ?>
                         </div>
                         <?php echo $content_bottom; ?>
                    </div>
               </div>
          </div>

     </div>
</div>

<?php echo $footer; ?> 