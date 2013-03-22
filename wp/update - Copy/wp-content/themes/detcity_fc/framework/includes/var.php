<?php  
/* This code retrieves all our admin options. */
global $options,$themename;
foreach ($options as $value) {
    if (isset($value['id']) && get_option( $value['id'] ) === FALSE && isset($value['std'])) {
            $$value['id'] = $value['std'];
        }
    elseif (isset($value['id'])) { $$value['id'] = get_option( $value['id'] ); }
}    
$readmoretxt = $atp_readmore_text ? $atp_readmore_text:'Read More';
$postedin=$atp_postedin ? $atp_postedin:'Posted In';
$bytxt=$atp_bytxt ? $atp_bytxt:'By';
$visitsitetxt=$atp_visittxt ? $atp_visittxt:'Visit Site';
$datetext=$atp_datetext ? $atp_datetext:'Date';
$authortxt=$atp_authortxt ? $atp_authortxt:'Autor';
$categorytxt=$atp_categorytxt ? $atp_categorytxt:'Category';
$header_teaser_text=get_option("atp_teaser");
$text_separator=get_option('atp_text_separator')? get_option('atp_text_separator') :'&#47;';
$radio = get_post_meta($post->ID, "radio_options", true);
$relatedposts=get_option('atp_relatedposts');
$comments=get_option('comments');
$atp_singlenavigation = get_option('atp_singlenavigation');
$aboutauthor=get_option('atp_aboutauthor');
$atp_timthumb=get_option('atp_timthumb');
$atp_layoutoptions = get_option('atp_layoutoption');
$atp_style = get_option('atp_default_colors');
$atp_searchformtxt=get_option('atp_searchformtxt') ? get_option('atp_searchformtxt'): 'Search';
$atp_error404txt=get_option('atp_error404txt') ? get_option('atp_error404txt') :'Sorry the page you are looking cannot be found on this server. Please browse the below sitemap';
$sidebaroption=get_post_meta($post->ID, "sidebar_options", TRUE);
$favicon = get_option('atp_custom_favicon');
?>