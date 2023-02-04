
<div class="privacy-section cs-gray-bg">
        <div class="container">
            <div class="row">
                <div class="col l12">
                    <nav class="cs-pages-breadcrumb">
                        <div class="nav-wrapper">
                             <a href="<?php echo SITEURL;?>" class="breadcrumb"><?php echo get_languageword('home');?></a>
                            <a href="#" class="breadcrumb"><?php if (isset($pagetitle)) echo $pagetitle; ?></a>
                        </div>
                    </nav>
                </div>
                <div class="col l12">
                    <div class="cs-question">
                       <?php if (isset($record->description)) echo $record->description;?>
                    </div>
                </div>
            </div>
        </div>
    </div>