<?php $this->load->view('common/admin/header'); ?>


<div class="cs-wrapper">
	<?php $this->load->view('common/admin/navigation'); ?>
	<?php  $this->load->view($content); ?>
	<?php $this->load->view('common/admin/footer'); ?>
</div>
 
<script type="text/javascript">
	$(document).ready(function() {
    var docHeight = $(window).height();
    var footerHeight = $('.footer').height();
    var footerTop = $('.footer').position().top + footerHeight;

    if (footerTop < docHeight) {
        $('.footer').css('margin-top', 10+ (docHeight - footerTop) + 'px');
    }
});
</script>