(function($){
$(document).ready(function() {

    var $page_template = $('#page_template'),
        $side = $('#page_metabox'),
        $rep = $('#rep-meta-box'),
        $image = $('#postimagediv');

    $page_template.change(function() {
        if ($(this).val() == 'template-two-column.php') {
            $side.show();
            $rep.hide();
            $image.hide(); 
        }else if($(this).val() == 'template_rep.php'){
        	$side.hide();
            $rep.show();
            $image.show(); 
        }else {
        	$side.hide();
        	$rep.hide();
        	$image.hide();          
        }
    }).change();

});
})(jQuery);