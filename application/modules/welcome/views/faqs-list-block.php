  
  <div class="cs-card-content card-items-list">
  <?php if (isset($faqs) && !empty($faqs)) : ?>
                    <div class="panel-group" id="accordion">
					
					
					<?php 
					$n=0;
					foreach ($faqs as $faq) {
					$n++;
					$clps='';
					if ($n==1) {
						$clps='in';
					}
					
						?>
					
                    <div class="panel panel-default faq-panel">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $n;?>" class="faq-ques">
                            <?php echo isset($faq->question) ? $faq->question : '';?>
                          </a>
                        </h4>
                      </div>
                      <div id="collapse<?php echo $n;?>" class="panel-collapse collapse <?php echo $clps;?>">
                        <div class="panel-body">
                            
							<?php echo isset($faq->answer) ? $faq->answer : '';?>
							
                        </div>
                      </div>
                    </div>
					
					<?php } ?>
                  
				
				
					
					
				</div>
				
				<?php else :

				echo '<h4>'.get_languageword('no_faqs_available').' </h4>';
				
				endif;?>
				
               </div>
			   