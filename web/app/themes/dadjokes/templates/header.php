<header class="banner">
  <div class="container">
    <nav class="nav-primary">
      <?php
      if (has_nav_menu('primary_navigation_left')) :
        wp_nav_menu(['theme_location' => 'primary_navigation_left', 'menu_class' => 'nav']);
      endif;
      ?>
    </nav>
    <a class="brand" href="<?= esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
    <nav class="nav-primary">
      <?php
      if (has_nav_menu('primary_navigation_right')) :
        wp_nav_menu(['theme_location' => 'primary_navigation_right', 'menu_class' => 'nav']);
      endif;
      ?>
    </nav>
  </div>
</header>
