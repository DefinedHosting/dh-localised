<?php
/*
 * Template: Landing_pages_list
 * For displaying the all the landing page areas with sub page links
 */
if($collapse){ ?>
  <a href="#" id="show-dm-landingpages-menu"><?php echo $text ?></a>
<?php }elseif(!$collapse || $collapse == false && $text !== ''){ ?>
  <h3 id="landing_page_list_title"><?php echo $text ?></h3>
<?php } ?>

<?php if($search){ ?>
    <div id="lp_searchbar_holder" <?php if($collapse){echo 'style="display:none"';} ?>>
      <input id="lp_searchbar" type="text" placeholder="search" />
    </div>
<?php } ?>

<div id="dm-landingpages-menu" <?php if($collapse){echo 'style="display:none"';} ?>>
<?php
  foreach($all_tl_pages as $holder){ ?>
     <div class="area-list" data-area="<?php echo strtolower($holder->post_title); ?>">
       <h3><?php echo $holder->post_title; ?></h3>
       <ul>
        <?php
          $children = get_page_children( $holder->ID, $landingpages );
          if($children){
             foreach($children as $child){
                 $title = $child->post_title;
                 if(strpos($title,'[') !== false){
                     $sc = substr($title,strpos($title,'['),strpos($title,']')+2);
                     $title = str_replace('['.$city.']',$holder->post_title,$title);
                 }
                 ?>
                 <li><a href="<?php echo get_post_permalink($child->ID); ?>"><?php echo $title; ?></a></li>
             <?php
             }
         }
        ?>
      </ul>
    </div>
  <?php
  }
?>
</div>




<?php
if($collapse){ ?>
   <script>
     jQuery(document).ready(function($){
       $("#show-dm-landingpages-menu").on("click",function(){
         var menu = $("#dm-landingpages-menu");
         var search_box = $("#lp_searchbar_holder");
         if(menu.css("display") == "flex"){
           menu.css("display","none");
           search_box.css("display","none");
         }else{
           menu.css({"display":"flex"});
           search_box.css("display","block");
         }
         return false;
       });
     })
   </script>
 <?php
}
if($search){ ?>
  <script>
    jQuery(document).ready(function($){
      if($('#lp_searchbar_holder').length != 0){
        var dhlp_timer;
        $('#lp_searchbar').on('input',function(){
          clearTimeout(dhlp_timer);
          dhlp_timer = setTimeout(function () {
            var search_val = $.trim($('#lp_searchbar').val().toLowerCase());
            var areas = $('#dm-landingpages-menu').find('div[data-area]');
            $.each(areas,function(){
              if($(this).data('area').indexOf(search_val) == -1){
                if($(this).css('display') !== 'none'){
                  $(this).hide();
                  console.log('hide');
                }
              }else{
                if($(this).css('display') == 'none'){
                  $(this).show();
                  console.log('show');
                }
              }
            });
          },800);
        });
      }
    })
  </script>
<?php
}
