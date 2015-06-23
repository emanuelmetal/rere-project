<?php
global $options;
global $isdashabord;
global $align;
global $show_remove_fav;
global $is_shortcode;
global $row_number_col;

$col_class  =   'col-md-4';
if($options['content_class']=='col-md-12' && $show_remove_fav!=1){
    $col_class  =   'col-md-3';
    $col_org    =   3;
}

// if template is vertical
if($align=='col-md-12'){
     $col_class  =  'col-md-12';
     $col_org    =  12;
}

$preview        =   array();
$preview[0]     =   '';
$words          =   55;
$link           =   get_permalink();
$title          =   get_the_title();

if (strlen ($title)>90 ){
    $title          =   substr($title,0,90).'...';
}


if(isset($is_shortcode) && $is_shortcode==1 ){
    $col_class='col-md-'.$row_number_col.' shortcode-col';
     //$col_class=' shortcode-col';
}

?>  

<div  class="<?php echo $col_class;?>  listing_wrapper blog2v"> 
    <div class="property_listing" data-link="<?php echo $link; ?>">
        <?php
        if (has_post_thumbnail()):
       
            $pinterest  =   wp_get_attachment_image_src(get_post_thumbnail_id(),'property_full_map');
            $preview    =   wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_listings');
            $compare    =   wp_get_attachment_image_src(get_post_thumbnail_id(), 'slider_thumb');
            $extra= array(
                'data-original'=>$preview[0],
                'class'	=> 'lazyload img-responsive',    
            );
         
            $thumb_prop = get_the_post_thumbnail( $post->ID, 'property_listings',$extra );           
            $featured   = intval  ( get_post_meta( $post->ID, 'prop_featured', true ) );
        
            
            if( $thumb_prop!='' ){
                print '<div class="blog_unit_image">';
                print  $thumb_prop;
                print '<div class="listing-cover"></div>
                <a href="'.$link.'"> <span class="listing-cover-plus">+</span></a>';
                print '</div>'; 
            }
           
        endif;
        ?>

  
           <h4><a href="<?php the_permalink(); ?>"><?php echo $title;?></a> </h4>
        
           <div class="blog_unit_meta">
            <?php print get_the_date('M d, Y');?>
            
           </div>
           
            <div class="listing_details the_grid_view">
                <?php   
               
                if( has_post_thumbnail() ){
                    echo wpestate_strip_words( get_the_excerpt(),18).' ...';
                } else{
                   echo wpestate_strip_words( get_the_excerpt(),40).' ...';
                } ?>
            </div>
       
        
           
             <a class="read_more" href="<?php the_permalink(); ?>"> <?php _e('Continue Reading','wpestate'); ?><i class="fa fa-angle-right"></i> </a>
           
     
        </div>          
    </div>      