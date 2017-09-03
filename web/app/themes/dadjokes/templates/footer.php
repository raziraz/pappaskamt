<footer class="content-info">
  <div class="container">
    <?php dynamic_sidebar('sidebar-footer'); ?>
  </div>
</footer>

<footer class="footer container-fluid index-footer">
  <div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6">
      <p>
        CCS Healthcare AB<br>
        Box 100 54<br>
        781 10 Borlänge
      </p>
    </div>
    <div class="col-lg-2 col-md-3 col-sm-3">
      <h6>
        <a href="mailto:info@ccshc.com">info@ccshc.com</a>
      </h6>
    </div>
    <div class="col-lg-2 col-md-3 col-sm-3">
      <h6>
        <a href="<?php the_field('facebook_link', 'option'); ?>" target="_blank">Facebook</a>
      </h6>
      <h6>
        <a href="<?php the_field('instagram_link', 'option'); ?>" target="_blank">Instagram</a>
      </h6>
    </div>
    <div class="col-lg-3 col-md-3 ml-auto col-sm-12">
      <h6>
        <img src="<?= get_template_directory_uri(); ?>/dist/images/CCS_Oliva_payoff_digital.svg" class="payoff payoff-desktop float-right" alt="Olvia icon">
        <img src="<?= get_template_directory_uri(); ?>/dist/images/CCS_Oliva_payoff_digital.svg" class="payoff payoff-mobile float-left" alt="Olvia icon">
      </h6>
    </div>
  </div>
</footer>
