<div class="gray-bg pt-8">
<div class="container ">
  <div class="search-wrapper contact-overlay">


        <div class="row">
            <div class="col-sm-6 col-md-5 col-xs-12">
               <?php 
$site_adres='';
$site_adres .= $this->config->item('site_settings')->address.',';
$site_adres .= $this->config->item('site_settings')->city.',';
$site_adres .= $this->config->item('site_settings')->state.'-';
$site_adres .= $this->config->item('site_settings')->zip;
?>     
    <h4 class="w-head"><?php echo get_languageword('get_in_touch');?></h4>
    <div class="c-media">
      <div class="media-left">
        <i class="fa fa-fw fa-map-o" aria-hidden="true"></i>
      </div>
      <div class="media-body">
        <p><?php echo $site_adres;?></p>
      </div>
    </div>
    <div class="c-media">
      <div class="media-left">
        <i class="fa fa-fw fa-phone" aria-hidden="true"></i>
      </div>
      <div class="media-body">
        <p><?php echo $this->config->item('site_settings')->land_line;?></p>
        <p><?php echo $this->config->item('site_settings')->phone;?></p>
      </div>
    </div>
    <div class="c-media">
      <div class="media-left">
         <i class="fa fa-fw fa-envelope-o" aria-hidden="true"></i>
      </div>
      <div class="media-body">
        <p><?php echo $this->config->item('site_settings')->portal_email;?></p>
      </div>
    </div>
  <h4 class="w-head mt-5"><?php echo get_languageword('follow_us');?></h4>
       <ul class="ct-social ul">
          
          <?php if(isset($this->config->item('social_networks')->facebook) && $this->config->item('social_networks')->facebook != '') { ?>
          <a href="<?php echo $this->config->item('social_networks')->facebook;?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
          <?php } if(isset($this->config->item('social_networks')->twitter) && $this->config->item('social_networks')->twitter != '') { ?>
         <a href="<?php echo $this->config->item('social_networks')->twitter;?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
          <?php } if(isset($this->config->item('social_networks')->instagram) && $this->config->item('social_networks')->instagram != '') {?>
          <a href="<?php echo $this->config->item('social_networks')->instagram;?>" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
          <?php } if(isset($this->config->item('social_networks')->google_plus) && $this->config->item('social_networks')->google_plus != '') { ?> 
          <a href="<?php echo $this->config->item('social_networks')->google_plus;?>" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
         <?php } if(isset($this->config->item('social_networks')->tumblr) && $this->config->item('social_networks')->tumblr != '') {?>
          <a href="<?php echo $this->config->item('social_networks')->tumblr;?>" target="_blank"><i class="fa fa-tumblr" aria-hidden="true"></i></a>
          <?php } if(isset($this->config->item('social_networks')->pinterest) && $this->config->item('social_networks')->pinterest != '') {?>
          <a href="<?php echo $this->config->item('social_networks')->pinterest;?>" target="_blank"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
          <?php } if(isset($this->config->item('social_networks')->linked_in) && $this->config->item('social_networks')->linked_in != '') {?>
          <a href="<?php echo $this->config->item('social_networks')->linked_in;?>" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
           <?php } ?> 
           
           </ul> 
       </div>
    <!--address details for contactus-->
      <div class="col-sm-12 col-md-1 col-xs-12 hidden-sm"></div>


      <div class="col-sm-6 col-md-6 col-xs-12">

            <?php echo $this->session->flashdata('message'); ?>

      <h4 class="w-head m-mt-3"><?php echo get_languageword('for_enquiries_or_suggestions');?></h4>
      <form method="post" action="<?php echo URL_CONTACT_US;?>" name="contact_form" id="contact_form" class="">
      
        
        <!-- Text input-->
        <div class="form-group">
          
          <?php 
          $element=array('type'=>'text',
                   'name'=>'name',
                   'class'=>'form-control',
                   'placeholder'=>get_languageword('name'));
          echo form_input($element);
          echo form_error('name');          
          ?>
          
          
        </div>
        
        
        <div class="form-group">
          
          <?php 
          $element=array('type'=>'email',
                   'name'=>'email',
                   'class'=>'form-control',
                   'placeholder'=>get_languageword('email'));
          echo form_input($element);
          echo form_error('email'); 
          ?>
        </div>
        
        
        <div class="form-group">
          
          <?php 
          $element=array('type'=>'text',
                   'name'=>'subject',
                   'class'=>'form-control',
                   'placeholder'=>get_languageword('subject'));
          echo form_input($element);
          echo form_error('subject');
          ?>
          
        </div>
        
      
      <!-- Text area -->
      
        <div class="form-group">
          
          <?php 
          $element=array('type'=>'text',
           'name'=>'message',
           'class'=>'form-control',
           'placeholder'=>get_languageword('message'),
           'rows'=>4
           );
           
           
          echo form_textarea($element);
          echo form_error('message'); 
          ?>
          
        </div>
        
      <!-- Button -->
      <div class="form-group">
      
      <button type="submit" name="contactus" class="btn btn-primary"><?php echo get_languageword('send_message');?> </button>
      
      </div>
      
      </form>

      </div>

            </div>






            <div class="row">
              
              <div class="col-sm-6 col-md-12 col-xs-12">

                <?php echo $this->config->item('site_settings')->contact_map_script;?>

                  </div>
            </div>




        </div>
    </div>
    </div>
</div>


    
    






<script type="text/javascript" src="<?php echo JS_VALIDATE_MIN;?>"></script>
<script type="text/javascript">
(function($,W,D)
{
      var JQUERY4U = {};
   
      JQUERY4U.UTIL =
      {
          setupFormValidation: function()
          {
              //Additional Methods
      
      //form validation rules
              $("#contact_form").validate({
          ignore: "",
                  rules: {
           name: {
             required: true
           },
           email: {
             required: true,
             email:true
           },
                     subject: {
            required: true
           },
           message: {
             required: true
           }
           
                  },
         messages: {
           name: {
             required: "<?php echo get_languageword('name_required');?>"
           },
           email: {
             required: "<?php echo get_languageword('email_required');?>"
           },
                     subject: {
            required: "<?php echo get_languageword('subject_required');?>"
           },
           message: {
             required: "<?php echo get_languageword('message_required');?>"
           }
           
        },
                  
                  submitHandler: function(form) {
                      form.submit();
                  }
              });
          }
      }
   
      //when the dom has loaded setup form validation rules
      $(D).ready(function($) {
          JQUERY4U.UTIL.setupFormValidation();
      });
   
   })(jQuery, window, document); 
</script>